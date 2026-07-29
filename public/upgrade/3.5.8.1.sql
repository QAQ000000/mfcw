-- Upgrade 3.5.8 installations before enabling structured client log visibility.
-- The column creation and all backfills are safe to run repeatedly. The first
-- run persists a fixed legacy-row boundary so later reruns cannot hide new
-- local-module logs that were deliberately written as client-visible.

-- Serialize the whole migration. The named lock is released automatically if
-- this connection exits because of an error.
SELECT GET_LOCK('_migration_20260729_activity_visibility', 30)
INTO @client_visibility_migration_lock;
SET @client_visibility_guard_sql = IF(
    @client_visibility_migration_lock = 1,
    'SET @client_visibility_lock_acquired = 1',
    'SELECT * FROM `_migration_20260729_activity_visibility_lock_timeout`'
);
PREPARE client_visibility_guard_stmt FROM @client_visibility_guard_sql;
EXECUTE client_visibility_guard_stmt;
DEALLOCATE PREPARE client_visibility_guard_stmt;

-- Snapshot the rows owned by the old schema before adding a fail-closed column.
-- Old application nodes that write after this point omit the column and are
-- therefore hidden instead of creating a rolling-deployment disclosure.
SET @activity_log_table = REPLACE(TRIM(' `shd_activity_log`'), '`', '');
SET @activity_log_snapshot_id = (
    SELECT IFNULL(MAX(`id`), 0)
    FROM `shd_activity_log`
);

SET @client_visible_exists = (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = @activity_log_table
      AND COLUMN_NAME = 'client_visible'
);
SET @client_visible_ddl = IF(
    @client_visible_exists = 0,
    'ALTER TABLE `shd_activity_log` ADD COLUMN `client_visible` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT ''客户可见:1是,0否'' AFTER `description`',
    'SET @client_visible_noop = 1'
);
PREPARE client_visible_stmt FROM @client_visible_ddl;
EXECUTE client_visible_stmt;
DEALLOCATE PREPARE client_visible_stmt;

-- Existing installations of the first patch used DEFAULT 1. Change the
-- default even when the column already exists so old nodes fail closed.
ALTER TABLE `shd_activity_log`
MODIFY COLUMN `client_visible` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '客户可见:1是,0否';

-- Only rows present before a newly-created column are legacy-visible by
-- default. Rows written concurrently by an old node retain DEFAULT 0.
SET @client_visible_legacy_sql = IF(
    @client_visible_exists = 0,
    CONCAT('UPDATE `shd_activity_log` SET `client_visible` = 1 WHERE `id` <= ', @activity_log_snapshot_id),
    'SET @client_visible_legacy_noop = 1'
);
PREPARE client_visible_legacy_stmt FROM @client_visible_legacy_sql;
EXECUTE client_visible_legacy_stmt;
DEALLOCATE PREPARE client_visible_legacy_stmt;

-- Persist the first migration boundary. Once DEFAULT 0 is active, old nodes
-- that omit client_visible fail closed, so later runs do not need a wider
-- boundary and must not include new structured local-module logs.
SET @client_visibility_cutoff_setting = '_activity_log_visibility_cutoff_id';
SET @saved_activity_log_cutoff_id = (
    SELECT CAST(`value` AS UNSIGNED)
    FROM `shd_configuration`
    WHERE `setting` = @client_visibility_cutoff_setting
    LIMIT 1
);
SET @activity_log_legacy_cutoff_id = IFNULL(
    @saved_activity_log_cutoff_id,
    @activity_log_snapshot_id
);
INSERT INTO `shd_configuration` (`setting`, `value`, `create_time`, `update_time`)
SELECT @client_visibility_cutoff_setting, @activity_log_legacy_cutoff_id, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
WHERE @saved_activity_log_cutoff_id IS NULL;

-- Convert old inline markers to structured visibility. Existing descriptions stay intact.
UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `description` LIKE 'Cron_[internal:%';

UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `description` LIKE '[internal:%';

-- Backfill the known supplier synchronization templates from older releases.
UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `description` LIKE '购物车页面获取供应商''%'
   OR `description` LIKE 'Cron_购物车页面获取供应商''%'
   OR `description` LIKE '保存商品获取供应商''%'
   OR `description` LIKE 'Cron_保存商品获取供应商''%'
   OR `description` LIKE '保存商品同步供应商''%'
   OR `description` LIKE 'Cron_保存商品同步供应商''%'
   OR `description` LIKE '定时任务获取供应商''%'
   OR `description` LIKE 'Cron_定时任务获取供应商''%'
   OR `description` LIKE '定时任务同步供应商''%'
   OR `description` LIKE 'Cron_定时任务同步供应商''%'
   OR `description` LIKE '同步供应商''%'
   OR `description` LIKE 'Cron_同步供应商''%'
   OR `description` LIKE '供应商''%暂无商品需要同步%'
   OR `description` LIKE 'Cron_供应商''%暂无商品需要同步%'
   OR `description` LIKE '商品''%原因:供应商''%已删除该商品%'
   OR `description` LIKE 'Cron_商品''%原因:供应商''%已删除该商品%';

-- Historical rows did not record their source type, and a host may since have
-- changed products. Keep ambiguous module failures internal; new structured
-- local-module failures remain customer-visible.
UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `id` <= @activity_log_legacy_cutoff_id
  AND (
      `description` LIKE '模块命令:%失败%'
      OR `description` LIKE 'Cron_模块命令:%失败%'
      OR `description` LIKE '模块命令失败%'
      OR `description` LIKE 'Cron_模块命令失败%'
  );

-- Raw transport and credential failures are technical diagnostics regardless
-- of their source and may contain endpoint or authentication details.
UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `description` LIKE '%CURL ERROR:%'
   OR `description` LIKE '%API%密钥%错误%'
   OR `description` LIKE '%API%秘钥%错误%'
   OR `description` LIKE '%购物车%同步%失败%';

-- Older detailed success logs did not record their source type and can expose
-- server groups, interfaces, and IPs. Treat the whole historical template as
-- internal; new local-module success logs keep their structured visibility.
UPDATE `shd_activity_log`
SET `client_visible` = 0
WHERE `id` <= @activity_log_legacy_cutoff_id
  AND (
      `description` LIKE '开通host%服务器模块:%接口:%IP:%'
      OR `description` LIKE 'Cron_开通host%服务器模块:%接口:%IP:%'
  );

-- Keep one durable retry generation. Any non-zero duplicate means a previous
-- cache mutation still needs to be retried.
START TRANSACTION;
SET @product_catalog_cache_was_dirty = (
    SELECT COUNT(*)
    FROM `shd_configuration`
    WHERE `setting` = '_product_catalog_cache_dirty'
      AND `value` NOT IN ('', '0')
    FOR UPDATE
);
DELETE FROM `shd_configuration`
WHERE `setting` = '_product_catalog_cache_dirty';
INSERT INTO `shd_configuration` (`setting`, `value`, `create_time`, `update_time`)
VALUES (
    '_product_catalog_cache_dirty',
    IF(@product_catalog_cache_was_dirty > 0, CONCAT('migration-', UNIX_TIMESTAMP(), '-', CONNECTION_ID()), '0'),
    UNIX_TIMESTAMP(),
    UNIX_TIMESTAMP()
);
COMMIT WORK;

SELECT RELEASE_LOCK('_migration_20260729_activity_visibility')
INTO @client_visibility_migration_lock_released;
