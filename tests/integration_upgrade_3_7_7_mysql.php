<?php

if (getenv('RUN_MYSQL_INTEGRATION') !== '1') {
	fwrite(STDOUT, "SKIP: set RUN_MYSQL_INTEGRATION=1 to run the temporary MySQL migration test\n");
	exit(0);
}

function assertMysqlUpgrade($condition, $message)
{
	if (!$condition) {
		throw new RuntimeException($message);
	}
}

$root = dirname(__DIR__);
$configPath = getenv('ZJMF_DB_CONFIG') ?: $root . '/app/config/database.php';
assertMysqlUpgrade(is_file($configPath), 'database config is missing; set ZJMF_DB_CONFIG');
$config = include $configPath;
$databaseName = $config['database'];
$prefix = 'z77t_' . getmypid() . '_' . bin2hex(random_bytes(4)) . '_';
assertMysqlUpgrade((bool) preg_match('/^[a-z0-9_]+$/', $prefix), 'temporary table prefix is invalid');

$dsn = sprintf(
	'mysql:host=%s;port=%s;dbname=%s;charset=%s',
	$config['hostname'],
	$config['hostport'],
	$databaseName,
	$config['charset'] ?: 'utf8mb4'
);
$pdo = new PDO($dsn, $config['username'], $config['password'], [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$sqlForTest = function ($sql) use ($prefix) {
	return str_replace('`t_', '`' . $prefix, $sql);
};
$tables = ['activity_log', 'configuration', 'products', 'clients', 'invoice_items', 'orders', 'jobs', 'cart_session', 'product_catalog_cache_pending'];

try {
	$schema = [
		"CREATE TABLE `t_activity_log` (`id` int unsigned NOT NULL AUTO_INCREMENT, `uid` int unsigned NOT NULL DEFAULT 0, `description` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_configuration` (`setting` varchar(255) NOT NULL, `value` text, `create_time` int unsigned NOT NULL DEFAULT 0, `update_time` int unsigned NOT NULL DEFAULT 0, KEY `setting` (`setting`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_products` (`id` int unsigned NOT NULL AUTO_INCREMENT, `hidden` tinyint unsigned NOT NULL DEFAULT 0, `api_type` varchar(32) NOT NULL DEFAULT 'normal', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_clients` (`id` int unsigned NOT NULL AUTO_INCREMENT, `email` varchar(191) NOT NULL DEFAULT '', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_invoice_items` (`id` int unsigned NOT NULL AUTO_INCREMENT, `rel_id` int unsigned NOT NULL DEFAULT 0, `type` varchar(32) NOT NULL DEFAULT '', `invoice_id` int unsigned NOT NULL DEFAULT 0, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_orders` (`id` int unsigned NOT NULL AUTO_INCREMENT, `invoiceid` int unsigned NOT NULL DEFAULT 0, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_jobs` (`id` bigint unsigned NOT NULL AUTO_INCREMENT, `queue` varchar(255) NOT NULL, `reserved` tinyint unsigned NOT NULL DEFAULT 0, `reserved_at` int unsigned NOT NULL DEFAULT 0, `available_at` int unsigned NOT NULL DEFAULT 0, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
		"CREATE TABLE `t_cart_session` (`id` int NOT NULL AUTO_INCREMENT, `uid` varchar(255) DEFAULT NULL, `cart_data` text, `status` varchar(10) DEFAULT NULL, `create_time` int DEFAULT NULL, `expire_time` int DEFAULT NULL, `update_time` int DEFAULT NULL, PRIMARY KEY (`id`), KEY `uid` (`uid`(100))) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
	];
	foreach ($schema as $statement) {
		$pdo->exec($sqlForTest($statement));
	}
	$pdo->exec($sqlForTest("INSERT INTO `t_activity_log` (`uid`,`description`) VALUES (1,'客户登录成功'),(1,'模块命令失败 CURL ERROR: endpoint secret')"));
	$pdo->exec($sqlForTest("INSERT INTO `t_products` (`hidden`,`api_type`) VALUES (0,'resource'),(0,'normal')"));
	$pdo->exec($sqlForTest("INSERT INTO `t_cart_session` (`uid`,`cart_data`,`update_time`) VALUES ('1','old',10),('1','new',20),('','guest-old',10),('','guest-new',20)"));

	$runBridge = function () use ($pdo, $root, $prefix) {
		$sql = file_get_contents($root . '/public/upgrade/3.7.7.sql');
		$sql = str_replace("\r", "\n", $sql);
		$sql = str_replace(' `shd_', ' `' . $prefix, trim($sql));
		foreach (explode(";\n", $sql) as $statement) {
			$statement = trim($statement);
			if ($statement !== '') {
				$pdo->exec($statement);
			}
		}
	};

	$runBridge();
	$visible = $pdo->query($sqlForTest("SELECT `client_visible` FROM `t_activity_log` ORDER BY `id`"))->fetchAll(PDO::FETCH_COLUMN);
	assertMysqlUpgrade($visible === ['1', '0'] || $visible === [1, 0], 'legacy visibility backfill is incorrect');
	assertMysqlUpgrade((int) $pdo->query($sqlForTest("SELECT COUNT(*) FROM `t_configuration` WHERE `setting`='_product_catalog_cache_dirty' AND `value`='0'"))->fetchColumn() === 1, 'missing dirty marker was not created');
	assertMysqlUpgrade((int) $pdo->query($sqlForTest("SELECT `hidden` FROM `t_products` WHERE `api_type`='resource'"))->fetchColumn() === 1, 'residual P3 product was not hidden');
	assertMysqlUpgrade((int) $pdo->query($sqlForTest("SELECT COUNT(*) FROM `t_cart_session` WHERE `uid`='1'"))->fetchColumn() === 1, 'duplicate cart rows were not collapsed');
	assertMysqlUpgrade($pdo->query($sqlForTest("SELECT `cart_data` FROM `t_cart_session` WHERE `uid`='1'"))->fetchColumn() === 'new', 'newest duplicate cart row was not retained');
	assertMysqlUpgrade((int) $pdo->query($sqlForTest("SELECT COUNT(*) FROM `t_cart_session` WHERE `uid` IS NULL"))->fetchColumn() === 2, 'historical empty guest UIDs were not normalized to nullable guest rows');

	// Re-run only through the first visibility UPDATE, then simulate a process
	// failure. The sensitive row must retain its previously committed value.
	$bridgeSql = file_get_contents($root . '/public/upgrade/3.7.7.sql');
	$bridgeSql = str_replace("\r", "\n", $bridgeSql);
	$bridgeSql = str_replace(' `shd_', ' `' . $prefix, trim($bridgeSql));
	$insideVisibilityTransaction = false;
	foreach (explode(";\n", $bridgeSql) as $statement) {
		$statement = trim($statement);
		if ($statement === '') {
			continue;
		}
		$pdo->exec($statement);
		if (strpos($statement, 'START TRANSACTION') !== false) {
			$insideVisibilityTransaction = true;
			continue;
		}
		if ($insideVisibilityTransaction && strpos($statement, 'SET `client_visible` = 1') !== false) {
			$observer = new PDO($dsn, $config['username'], $config['password'], [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]);
			$observerVisible = $observer->query($sqlForTest("SELECT `client_visible` FROM `t_activity_log` ORDER BY `id`"))->fetchAll(PDO::FETCH_COLUMN);
			assertMysqlUpgrade($observerVisible === ['1', '0'] || $observerVisible === [1, 0], 'legacy visibility restore was visible before commit');
			$pdo->exec('ROLLBACK');
			break;
		}
	}
	$pdo->query("SELECT RELEASE_LOCK('_migration_20260729_activity_visibility')");
	$visibleAfterRollback = $pdo->query($sqlForTest("SELECT `client_visible` FROM `t_activity_log` ORDER BY `id`"))->fetchAll(PDO::FETCH_COLUMN);
	assertMysqlUpgrade($visibleAfterRollback === ['1', '0'] || $visibleAfterRollback === [1, 0], 'interrupted visibility restore exposed a sensitive row');

	$pdo->exec($sqlForTest("UPDATE `t_configuration` SET `value`='{\"generation\":\"preserve\"}' WHERE `setting`='_product_catalog_cache_dirty'"));
	$pdo->exec($sqlForTest("UPDATE `t_activity_log` SET `client_visible`=0 WHERE `id`=1"));
	$runBridge();
	assertMysqlUpgrade((int) $pdo->query($sqlForTest("SELECT `client_visible` FROM `t_activity_log` WHERE `id`=1"))->fetchColumn() === 1, 'rerun did not recover a partially backfilled normal log');
	assertMysqlUpgrade($pdo->query($sqlForTest("SELECT `value` FROM `t_configuration` WHERE `setting`='_product_catalog_cache_dirty'"))->fetchColumn() === '{"generation":"preserve"}', 'rerun overwrote an existing dirty generation');

	$indexes = [
		[$prefix . 'activity_log', 'idx_activity_log_client_page'],
		[$prefix . 'clients', 'idx_clients_email'],
		[$prefix . 'invoice_items', 'idx_invoice_items_rel_type_invoice'],
		[$prefix . 'orders', 'idx_orders_invoiceid'],
		[$prefix . 'jobs', 'idx_jobs_expired'],
		[$prefix . 'jobs', 'idx_jobs_available'],
		[$prefix . 'cart_session', 'uq_cart_session_uid'],
	];
	$indexQuery = $pdo->prepare('SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND INDEX_NAME=?');
	foreach ($indexes as $index) {
		$indexQuery->execute([$databaseName, $index[0], $index[1]]);
		assertMysqlUpgrade((int) $indexQuery->fetchColumn() > 0, "missing index {$index[0]}.{$index[1]}");
	}

	fwrite(STDOUT, "MySQL 3.7.7 bridge integration passed\n");
} finally {
	foreach (array_reverse($tables) as $table) {
		try {
			$pdo->exec("DROP TABLE IF EXISTS `{$prefix}{$table}`");
		} catch (Throwable $cleanupError) {
			error_log('Temporary migration table cleanup failed: ' . $cleanupError->getMessage());
		}
	}
}
