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
