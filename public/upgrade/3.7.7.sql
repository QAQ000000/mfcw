-- Bridge upstream 3.7.6 and the maintained 3.5.8.x branch to 3.7.7.
-- This file intentionally combines the idempotent 3.5.8.1-3.5.8.3 migrations
-- because version comparison correctly skips those lower versions on 3.7.6.
-- v10 columns from an upstream database are retained and ignored.

-- Upgrade installations before enabling structured client log visibility.
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

-- Persist a fixed boundary before the first implicit-commit DDL. If the
-- process stops while adding the column, a rerun can restore all legacy rows
-- from this durable snapshot before applying the sensitive-log filters again.
SET @activity_log_table = REPLACE(TRIM(' `shd_activity_log`'), '`', '');
SET @activity_log_snapshot_id = (
    SELECT IFNULL(MAX(`id`), 0)
    FROM `shd_activity_log`
);
SET @client_visibility_cutoff_setting = '_activity_log_visibility_cutoff_id';
SET @saved_activity_log_cutoff_id = (
    SELECT CAST(`value` AS UNSIGNED)
    FROM `shd_configuration`
    WHERE `setting` = @client_visibility_cutoff_setting
    LIMIT 1
);
INSERT INTO `shd_configuration` (`setting`, `value`, `create_time`, `update_time`)
SELECT @client_visibility_cutoff_setting, @activity_log_snapshot_id, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
WHERE @saved_activity_log_cutoff_id IS NULL;
SET @activity_log_legacy_cutoff_id = (
    SELECT CAST(`value` AS UNSIGNED)
    FROM `shd_configuration`
    WHERE `setting` = @client_visibility_cutoff_setting
    LIMIT 1
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

-- Keep the fail-closed default until every legacy visibility rule has been
-- reapplied. An interrupted upgrade rolls this block back atomically.
-- Existing installations of the first patch used DEFAULT 1, so repair that
-- default before beginning the data-only transaction.
ALTER TABLE `shd_activity_log`
MODIFY COLUMN `client_visible` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '客户可见:1是,0否';

START TRANSACTION;

-- Reapply the legacy-visible baseline on every run. This makes interruption
-- after ALTER TABLE recoverable; the filters below deterministically hide the
-- historical supplier and transport diagnostics again.
UPDATE `shd_activity_log`
SET `client_visible` = 1
WHERE `id` <= @activity_log_legacy_cutoff_id;

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

COMMIT WORK;

-- Upstream 3.7.6 does not contain the maintained branch's dirty-generation
-- marker. Create it only when missing and never overwrite JSON shards or a
-- generation written by a running application node.
INSERT INTO `shd_configuration` (`setting`, `value`, `create_time`, `update_time`)
SELECT '_product_catalog_cache_dirty', '0', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()
WHERE NOT EXISTS (
    SELECT 1
    FROM `shd_configuration`
    WHERE `setting` = '_product_catalog_cache_dirty'
);

-- Create durable pending-ID storage for installations that already ran the
-- original 3.5.8.1 migration.
CREATE TABLE IF NOT EXISTS `shd_product_catalog_cache_pending` (
    `pid` int(10) unsigned NOT NULL,
    `generation` varchar(64) NOT NULL DEFAULT '',
    `create_time` int(10) unsigned NOT NULL DEFAULT 0,
    `update_time` int(10) unsigned NOT NULL DEFAULT 0,
    PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Do not parse legacy JSON in SQL. Runtime retry processing streams it through
-- PHP and collapses duplicate rows after successful cache invalidation.

-- P3/resource is intentionally not shipped by this maintained release. Keep
-- residual upstream rows for rollback/audit, but make them unavailable to all
-- storefront and upgrade-product queries.
UPDATE `shd_products`
SET `hidden` = 1
WHERE `api_type` = 'resource';

-- Add high-confidence lookup indexes and queue scheduling indexes. Every block
-- repairs a same-named index with the wrong definition and is safe to rerun.

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 1 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'email:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_clients`'))
      AND INDEX_NAME = 'idx_clients_email'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_clients`'))
      AND INDEX_NAME = 'idx_clients_email'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_clients` DROP INDEX `idx_clients_email`, ADD INDEX `idx_clients_email` (`email`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_clients` ADD INDEX `idx_clients_email` (`email`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 3 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'rel_id:NULL,type:NULL,invoice_id:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_invoice_items`'))
      AND INDEX_NAME = 'idx_invoice_items_rel_type_invoice'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_invoice_items`'))
      AND INDEX_NAME = 'idx_invoice_items_rel_type_invoice'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_invoice_items` DROP INDEX `idx_invoice_items_rel_type_invoice`, ADD INDEX `idx_invoice_items_rel_type_invoice` (`rel_id`, `type`, `invoice_id`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_invoice_items` ADD INDEX `idx_invoice_items_rel_type_invoice` (`rel_id`, `type`, `invoice_id`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 1 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'invoiceid:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_orders`'))
      AND INDEX_NAME = 'idx_orders_invoiceid'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_orders`'))
      AND INDEX_NAME = 'idx_orders_invoiceid'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_orders` DROP INDEX `idx_orders_invoiceid`, ADD INDEX `idx_orders_invoiceid` (`invoiceid`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_orders` ADD INDEX `idx_orders_invoiceid` (`invoiceid`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 3 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'uid:NULL,client_visible:NULL,id:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_activity_log`'))
      AND INDEX_NAME = 'idx_activity_log_client_page'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_activity_log`'))
      AND INDEX_NAME = 'idx_activity_log_client_page'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_activity_log` DROP INDEX `idx_activity_log_client_page`, ADD INDEX `idx_activity_log_client_page` (`uid`, `client_visible`, `id`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_activity_log` ADD INDEX `idx_activity_log_client_page` (`uid`, `client_visible`, `id`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 3 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'queue:191,reserved:NULL,reserved_at:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_jobs`'))
      AND INDEX_NAME = 'idx_jobs_expired'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_jobs`'))
      AND INDEX_NAME = 'idx_jobs_expired'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_jobs` DROP INDEX `idx_jobs_expired`, ADD INDEX `idx_jobs_expired` (`queue`(191), `reserved`, `reserved_at`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_jobs` ADD INDEX `idx_jobs_expired` (`queue`(191), `reserved`, `reserved_at`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

SET @zjmf_index_exact = (
    SELECT COUNT(*) = 4 AND MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1 AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'queue:191,reserved:NULL,id:NULL,available_at:NULL'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_jobs`'))
      AND INDEX_NAME = 'idx_jobs_available'
);
SET @zjmf_index_named = (
    SELECT COUNT(*) FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_jobs`'))
      AND INDEX_NAME = 'idx_jobs_available'
);
SET @zjmf_index_sql = IF(
    @zjmf_index_exact = 1,
    'SET @zjmf_index_noop = 1',
    IF(
        @zjmf_index_named > 0,
        'ALTER TABLE `shd_jobs` DROP INDEX `idx_jobs_available`, ADD INDEX `idx_jobs_available` (`queue`(191), `reserved`, `id`, `available_at`), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_jobs` ADD INDEX `idx_jobs_available` (`queue`(191), `reserved`, `id`, `available_at`), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE zjmf_index_stmt FROM @zjmf_index_sql;
EXECUTE zjmf_index_stmt;
DEALLOCATE PREPARE zjmf_index_stmt;

-- Keep the newest row for any historical duplicate UID before enforcing one
-- durable cart per authenticated customer. Guest carts remain cookie-backed.
UPDATE `shd_cart_session`
SET `uid` = NULL
WHERE `uid` = '';

DELETE older
FROM `shd_cart_session` AS older
INNER JOIN `shd_cart_session` AS newer
    ON older.`uid` = newer.`uid`
   AND older.`uid` IS NOT NULL
   AND (
       COALESCE(older.`update_time`, 0) < COALESCE(newer.`update_time`, 0)
       OR (
           COALESCE(older.`update_time`, 0) = COALESCE(newer.`update_time`, 0)
           AND older.`id` < newer.`id`
       )
   );

SET @cart_uid_index_exact = (
    SELECT COUNT(*) = 1
       AND MIN(NON_UNIQUE) = 0
       AND MAX(NON_UNIQUE) = 0
       AND COALESCE(GROUP_CONCAT(CONCAT(COLUMN_NAME, ':', IFNULL(SUB_PART, 'NULL')) ORDER BY SEQ_IN_INDEX SEPARATOR ','), '') = 'uid:100'
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_cart_session`'))
      AND INDEX_NAME = 'uq_cart_session_uid'
);
SET @cart_uid_index_named = (
    SELECT COUNT(*)
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = TRIM(BOTH '`' FROM TRIM(' `shd_cart_session`'))
      AND INDEX_NAME = 'uq_cart_session_uid'
);
SET @cart_uid_index_sql = IF(
    @cart_uid_index_exact = 1,
    'SET @cart_uid_index_noop = 1',
    IF(
        @cart_uid_index_named > 0,
        'ALTER TABLE `shd_cart_session` DROP INDEX `uq_cart_session_uid`, ADD UNIQUE INDEX `uq_cart_session_uid` (`uid`(100)), ALGORITHM=INPLACE, LOCK=NONE',
        'ALTER TABLE `shd_cart_session` ADD UNIQUE INDEX `uq_cart_session_uid` (`uid`(100)), ALGORITHM=INPLACE, LOCK=NONE'
    )
);
PREPARE cart_uid_index_stmt FROM @cart_uid_index_sql;
EXECUTE cart_uid_index_stmt;
DEALLOCATE PREPARE cart_uid_index_stmt;

-- Keep the migration lock through every index DDL block. This prevents two
-- upgrade runners from both observing a missing index and racing to add it.
SELECT RELEASE_LOCK('_migration_20260729_activity_visibility')
INTO @client_visibility_migration_lock_released;
