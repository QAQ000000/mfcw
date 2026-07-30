<?php

function assertUpgrade377($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
        exit(1);
    }
}

$root = dirname(__DIR__);
$version = trim(file_get_contents($root . '/version'));
$upgradeLog = file($root . '/public/upgrade/upgrade.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$bridgePath = $root . '/public/upgrade/3.7.7.sql';
$bridge = file_get_contents($bridgePath);
$legacyVisibility = file_get_contents($root . '/public/upgrade/3.5.8.1.sql');
$legacyPending = file_get_contents($root . '/public/upgrade/3.5.8.2.sql');
$legacyIndexes = file_get_contents($root . '/public/upgrade/3.5.8.3.sql');
$installSql = file_get_contents($root . '/public/install/thinkcmf.sql');
$apiUpgrader = file_get_contents($root . '/app/api/controller/UpgradeSystemController.php');
$standaloneUpgrader = file_get_contents($root . '/public/upgrade/upgrade.php');
$upgradeRoutes = file_get_contents($root . '/data/route/api.php');
$standaloneInstaller = file_get_contents($root . '/public/upgrade/install.php');
$readme = file_get_contents($root . '/README.md');
$common = file_get_contents($root . '/app/common.php');
$adminPublic = file_get_contents($root . '/app/admin/controller/PublicController.php');

assertUpgrade377($version === '3.7.7', 'release version must be 3.7.7');
assertUpgrade377(!empty($upgradeLog), 'upgrade log must not be empty');

$entries = [];
foreach ($upgradeLog as $line) {
    $parts = str_getcsv($line);
    assertUpgrade377(count($parts) >= 4, 'every upgrade log row must contain four columns');
    $entries[] = ['version' => $parts[1], 'file' => $parts[3]];
}

$lastEntry = end($entries);
assertUpgrade377($lastEntry['version'] === '3.7.7', '3.7.7 must be the latest upgrade log version');
assertUpgrade377($lastEntry['file'] === '3.7.7.sql', '3.7.7 must point to its bridge SQL');
assertUpgrade377(version_compare('3.7.7', '3.7.6', '>'), '3.7.7 must upgrade upstream 3.7.6');
assertUpgrade377(version_compare('3.7.7', '3.5.8.3', '>'), '3.7.7 must upgrade the maintained branch');

foreach (['3.7.6', '3.5.8.3'] as $sourceVersion) {
    $selected = [];
    foreach ($entries as $entry) {
        if (version_compare($entry['version'], $sourceVersion, '>')) {
            $selected[] = $entry['file'];
        }
    }
    assertUpgrade377(in_array('3.7.7.sql', $selected, true), "{$sourceVersion} must select the bridge SQL");
}

assertUpgrade377(strpos($bridge, $legacyPending) !== false, 'bridge must contain the pending-table migration');
assertUpgrade377(strpos($bridge, $legacyIndexes) !== false, 'bridge must contain the index migration');
assertUpgrade377(strpos($bridge, 'client_visible') !== false, 'bridge must create structured log visibility');
assertUpgrade377(strpos($bridge, 'product_catalog_cache_pending') !== false, 'bridge must create pending cache storage');
assertUpgrade377(strpos($bridge, 'idx_jobs_available') !== false, 'bridge must create the queue scheduling index');
assertUpgrade377(strpos($bridge, 'uq_cart_session_uid') !== false, 'bridge must enforce one durable cart per authenticated UID');
assertUpgrade377(strpos($bridge, "WHERE `api_type` = 'resource'") !== false, 'bridge must hide residual P3 resource products without deleting their data');
assertUpgrade377(!preg_match('/DROP\s+(?:COLUMN\s+)?`?(?:upstream_configoption|upstream_price|upstream_cycle|duration)`?/i', $bridge), 'bridge must retain upstream v10 columns');

$cutoffInsert = strpos($bridge, "SELECT @client_visibility_cutoff_setting, @activity_log_snapshot_id");
$visibilityDdl = strpos($bridge, 'ALTER TABLE `shd_activity_log` ADD COLUMN `client_visible`');
$legacyRestore = strpos($bridge, 'SET `client_visible` = 1');
assertUpgrade377($cutoffInsert !== false && $visibilityDdl !== false && $cutoffInsert < $visibilityDdl, 'visibility cutoff must be durable before implicit-commit DDL');
assertUpgrade377($legacyRestore !== false && strpos($bridge, '@client_visible_exists = 0', $legacyRestore) === false, 'every rerun must restore the fixed legacy visibility baseline');
$visibilityTransaction = strpos($bridge, 'START TRANSACTION;', $visibilityDdl);
$visibilityCommit = strpos($bridge, 'COMMIT WORK;', $legacyRestore);
assertUpgrade377($visibilityTransaction !== false && $visibilityCommit !== false && $visibilityTransaction < $legacyRestore && $visibilityCommit > $legacyRestore, 'legacy log visibility backfill must remain fail closed in one transaction');
assertUpgrade377(strpos($bridge, "SELECT '_product_catalog_cache_dirty', '0'") !== false, 'upstream 3.7.6 must receive the missing dirty marker');
assertUpgrade377(strpos($bridge, "WHERE NOT EXISTS (\n    SELECT 1\n    FROM `shd_configuration`\n    WHERE `setting` = '_product_catalog_cache_dirty'") !== false, 'dirty marker creation must preserve existing JSON and generations');
$releaseLock = strrpos($bridge, "RELEASE_LOCK('_migration_20260729_activity_visibility')");
$lastIndex = strrpos($bridge, 'idx_jobs_available');
assertUpgrade377($releaseLock !== false && $lastIndex !== false && $releaseLock > $lastIndex, 'migration lock must cover every index DDL block');

assertUpgrade377(substr_count($installSql, "SET `value` = '3.7.7' WHERE `setting` = 'update_last_version'") === 1, 'fresh install version must be 3.7.7');
assertUpgrade377(substr_count($installSql, "SET `value` = '3.7.7' WHERE `setting` = 'beta_version'") === 1, 'fresh install beta version must be 3.7.7');
assertUpgrade377(strpos($apiUpgrader, '\\think\\Db::') === false, 'disabled API upgrader must not execute database migrations');
assertUpgrade377(strpos($standaloneUpgrader, "version_compare(\$last_version, '3.5.8.3', '>=')") !== false, 'standalone upgrader must verify bridge indexes');
assertUpgrade377(strpos($upgradeRoutes, '})->middleware("AdminCheck");') !== false, 'all web upgrade routes must require an administrator session');
assertUpgrade377(strpos($upgradeRoutes, 'sqlupdate') === false, 'database upgrades must not have a web route');
assertUpgrade377(substr_count($apiUpgrader, 'return $this->autoUpgradeDisabled();') === 5, 'all web upgrade stages, including SQL, must be disabled on the fork');
assertUpgrade377(strpos($apiUpgrader, 'hash_equals($sessionToken, $submittedToken)') === false, 'the disabled web upgrader must not maintain a parallel token contract');
assertUpgrade377(strpos($standaloneUpgrader, "PHP_SAPI !== 'cli'") !== false && strpos($standaloneUpgrader, "in_array('--run', \$argv, true)") !== false, 'standalone upgrader must be CLI-only and explicitly armed');
assertUpgrade377(strpos($standaloneUpgrader, 'die(') === false && substr_count($standaloneUpgrader, 'exit(1);') >= 9, 'every standalone upgrade failure must return a nonzero exit code');
assertUpgrade377(strpos($standaloneInstaller, 'http_response_code(503)') !== false, 'upgrade instruction page must report service unavailable');
assertUpgrade377(strpos($standaloneInstaller, 'php public/upgrade/upgrade.php --run') !== false, 'upgrade instruction page must show the supported CLI command');
assertUpgrade377(strpos($standaloneInstaller, 'PDO') === false && strpos($standaloneInstaller, 'app/config/database.php') === false, 'upgrade instruction page must never connect to the database');
assertUpgrade377(strpos($common, '"command" => "php public/upgrade/upgrade.php --run"') !== false, 'login upgrade state must include the supported CLI command');
assertUpgrade377(strpos($adminPublic, 'upgradeHandle($current_version, $version)') !== false, 'login upgrade state must report current and target versions');
assertUpgrade377(strpos($readme, 'php public/upgrade/upgrade.php --run') !== false, 'manual upgrade instructions must name the only supported database upgrade command');

echo "PASS: 3.7.6 and maintained releases select the idempotent 3.7.7 bridge\n";
