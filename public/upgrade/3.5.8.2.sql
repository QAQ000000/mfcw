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
