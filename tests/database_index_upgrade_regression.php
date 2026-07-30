<?php

function assertDatabaseIndexUpgrade($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
        exit(1);
    }
}

function createTableDefinition($sql, $table)
{
    $pattern = '/CREATE TABLE `' . preg_quote($table, '/') . '` \((.*?)\) ENGINE=/s';
    preg_match($pattern, $sql, $matches);
    assertDatabaseIndexUpgrade(!empty($matches[1]), "fresh-install table {$table} must exist");
    return preg_replace('/\s+/', ' ', $matches[1]);
}

$root = dirname(__DIR__);
$installSql = file_get_contents($root . '/public/install/thinkcmf.sql');
$upgradeSql = file_get_contents($root . '/public/upgrade/3.5.8.3.sql');
$apiUpgrader = file_get_contents($root . '/app/api/controller/UpgradeSystemController.php');
$standaloneUpgrader = file_get_contents($root . '/public/upgrade/upgrade.php');

$indexes = [
    'idx_activity_log_client_page' => ['shd_activity_log', '`uid`,`client_visible`,`id`'],
    'idx_clients_email' => ['shd_clients', '`email`'],
    'idx_invoice_items_rel_type_invoice' => ['shd_invoice_items', '`rel_id`,`type`,`invoice_id`'],
    'idx_orders_invoiceid' => ['shd_orders', '`invoiceid`'],
    'idx_jobs_expired' => ['shd_jobs', '`queue`(191),`reserved`,`reserved_at`'],
    'idx_jobs_available' => ['shd_jobs', '`queue`(191),`reserved`,`id`,`available_at`'],
];
$upgradeSignatures = [
    'idx_activity_log_client_page' => 'uid:NULL,client_visible:NULL,id:NULL',
    'idx_clients_email' => 'email:NULL',
    'idx_invoice_items_rel_type_invoice' => 'rel_id:NULL,type:NULL,invoice_id:NULL',
    'idx_orders_invoiceid' => 'invoiceid:NULL',
    'idx_jobs_expired' => 'queue:191,reserved:NULL,reserved_at:NULL',
    'idx_jobs_available' => 'queue:191,reserved:NULL,id:NULL,available_at:NULL',
];
$postconditionDefinitions = [
    ['["activity_log", "idx_activity_log_client_page", [["uid", null], ["client_visible", null], ["id", null]]]', "['activity_log', 'idx_activity_log_client_page', [['uid', null], ['client_visible', null], ['id', null]]]"],
    ['["clients", "idx_clients_email", [["email", null]]]', "['clients', 'idx_clients_email', [['email', null]]]"],
    ['["invoice_items", "idx_invoice_items_rel_type_invoice", [["rel_id", null], ["type", null], ["invoice_id", null]]]', "['invoice_items', 'idx_invoice_items_rel_type_invoice', [['rel_id', null], ['type', null], ['invoice_id', null]]]"],
    ['["orders", "idx_orders_invoiceid", [["invoiceid", null]]]', "['orders', 'idx_orders_invoiceid', [['invoiceid', null]]]"],
    ['["jobs", "idx_jobs_expired", [["queue", 191], ["reserved", null], ["reserved_at", null]]]', "['jobs', 'idx_jobs_expired', [['queue', 191], ['reserved', null], ['reserved_at', null]]]"],
    ['["jobs", "idx_jobs_available", [["queue", 191], ["reserved", null], ["id", null], ["available_at", null]]]', "['jobs', 'idx_jobs_available', [['queue', 191], ['reserved', null], ['id', null], ['available_at', null]]]"],
];

foreach ($indexes as $indexName => $definition) {
    $tableSql = createTableDefinition($installSql, $definition[0]);
    assertDatabaseIndexUpgrade(
        strpos($tableSql, "KEY `{$indexName}` ({$definition[1]})") !== false,
        "fresh-install index {$indexName} must have the expected table, order and prefix length"
    );
    assertDatabaseIndexUpgrade(
        substr_count($installSql, "KEY `{$indexName}`") === 1,
        "fresh-install index {$indexName} must occur exactly once"
    );
    assertDatabaseIndexUpgrade(
        strpos($upgradeSql, "INDEX_NAME = '{$indexName}'") !== false,
        "upgrade SQL must inspect {$indexName}"
    );
    assertDatabaseIndexUpgrade(
        strpos($upgradeSql, "DROP INDEX `{$indexName}`, ADD INDEX `{$indexName}`") !== false,
        "upgrade SQL must atomically repair a wrong same-named {$indexName}"
    );
    assertDatabaseIndexUpgrade(
        strpos($upgradeSql, "= '{$upgradeSignatures[$indexName]}'") !== false,
        "upgrade SQL must compare the exact ordered definition of {$indexName}"
    );
	assertDatabaseIndexUpgrade(
        strpos($standaloneUpgrader, "'{$indexName}'") !== false,
        "standalone upgrader must validate {$indexName}"
    );
}

$knowledgeBase = createTableDefinition($installSql, 'shd_knowledge_base');
$knowledgeBaseLinks = createTableDefinition($installSql, 'shd_knowledge_base_links');
assertDatabaseIndexUpgrade(strpos($knowledgeBase, 'idx_orders_invoiceid') === false, 'orders index must not be attached to knowledge_base');
assertDatabaseIndexUpgrade(strpos($knowledgeBaseLinks, 'idx_orders_invoiceid') === false, 'orders index must not be attached to knowledge_base_links');

$customPrefixSql = str_replace(' `shd_', ' `tenant42_', $upgradeSql);
assertDatabaseIndexUpgrade(strpos($customPrefixSql, '`shd_') === false, 'all upgrade SQL table references must support prefix replacement');
foreach (['clients', 'invoice_items', 'orders', 'activity_log', 'jobs'] as $table) {
    assertDatabaseIndexUpgrade(strpos($customPrefixSql, '`tenant42_' . $table . '`') !== false, "custom prefix must reach {$table}");
}

assertDatabaseIndexUpgrade(substr_count($upgradeSql, '@zjmf_index_exact = 1') === 6, 'all six indexes must noop only on an exact match');
assertDatabaseIndexUpgrade(substr_count($upgradeSql, 'SET @zjmf_index_noop = 1') === 6, 'all six index blocks must have a restart-safe noop path');
assertDatabaseIndexUpgrade(substr_count($upgradeSql, 'PREPARE zjmf_index_stmt FROM') === 6, 'each index must execute through one dynamic DDL statement');
assertDatabaseIndexUpgrade(substr_count($upgradeSql, 'MIN(NON_UNIQUE) = 1 AND MAX(NON_UNIQUE) = 1') === 6, 'all six indexes must be verified as non-unique');
assertDatabaseIndexUpgrade(strpos($upgradeSql, 'queue:191,reserved:NULL,reserved_at:NULL') !== false, 'expired-job index must validate queue(191)');
assertDatabaseIndexUpgrade(strpos($upgradeSql, 'queue:191,reserved:NULL,id:NULL,available_at:NULL') !== false, 'available-job index must preserve id-first queue ordering');

foreach ($postconditionDefinitions as $definition) {
	assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, $definition[1]) !== false, 'standalone upgrader must retain the exact postcondition definition');
}

assertDatabaseIndexUpgrade(strpos($apiUpgrader, '\\think\\Db::') === false, 'disabled Web upgrader must not inspect or modify the database');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, '3.5.8.3') !== false, 'standalone upgrader must gate the index postcondition at 3.5.8.3');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, 'information_schema.TABLES') !== false, 'standalone upgrader must validate target tables');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, 'information_schema.STATISTICS') !== false, 'standalone upgrader must inspect index metadata');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, 'ORDER BY SEQ_IN_INDEX') !== false, 'standalone upgrader must validate index column order');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, 'sub_part') !== false, 'standalone upgrader must validate index prefix lengths');
assertDatabaseIndexUpgrade(strpos($standaloneUpgrader, 'non_unique') !== false, 'standalone upgrader must validate non-unique indexes');

echo "database index upgrade regression passed\n";
