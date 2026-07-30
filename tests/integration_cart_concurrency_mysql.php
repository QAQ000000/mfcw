<?php

if (getenv('RUN_MYSQL_INTEGRATION') !== '1') {
	fwrite(STDOUT, "SKIP: set RUN_MYSQL_INTEGRATION=1 to run the cart concurrency test\n");
	exit(0);
}

function assertCartMysql($condition, $message)
{
	if (!$condition) {
		throw new RuntimeException($message);
	}
}

$root = dirname(__DIR__);
$configPath = getenv('ZJMF_DB_CONFIG') ?: $root . '/app/config/database.php';
assertCartMysql(is_file($configPath), 'database config is missing; set ZJMF_DB_CONFIG');
$config = include $configPath;
$table = 'z77_cart_stock_' . getmypid() . '_' . bin2hex(random_bytes(4));
assertCartMysql((bool) preg_match('/^[a-z0-9_]+$/', $table), 'temporary table name is invalid');
$dsn = sprintf(
	'mysql:host=%s;port=%s;dbname=%s;charset=%s',
	$config['hostname'],
	$config['hostport'],
	$config['database'],
	$config['charset'] ?: 'utf8mb4'
);
$connect = function () use ($dsn, $config) {
	return new PDO($dsn, $config['username'], $config['password'], [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
};

$setup = $connect();
$setup->exec("CREATE TABLE `{$table}` (`id` int unsigned NOT NULL, `stock_control` tinyint unsigned NOT NULL, `qty` int NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB");
	$setup->exec("INSERT INTO `{$table}` (`id`,`stock_control`,`qty`) VALUES (1,1,5),(2,1,5)");
$setup = null;

try {
	$sockets = stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);
	assertCartMysql($sockets !== false, 'failed to create process synchronization socket');
	$pid = pcntl_fork();
	assertCartMysql($pid >= 0, 'failed to fork stock contender');
	if ($pid === 0) {
		fclose($sockets[0]);
		$result = ['affected' => null, 'error' => null];
		try {
			fread($sockets[1], 1);
			$child = $connect();
			$child->exec('SET SESSION innodb_lock_wait_timeout=5');
			$child->beginTransaction();
			$statement = $child->prepare("UPDATE `{$table}` SET `qty`=`qty`-4 WHERE `id`=1 AND `stock_control`=1 AND `qty`>=4");
			$statement->execute();
			$result['affected'] = $statement->rowCount();
			$child->commit();
		} catch (Throwable $e) {
			$result['error'] = $e->getMessage();
		}
		fwrite($sockets[1], json_encode($result));
		fclose($sockets[1]);
		exit($result['error'] === null ? 0 : 1);
	}

	fclose($sockets[1]);
	$parent = $connect();
	$parent->beginTransaction();
	$statement = $parent->prepare("UPDATE `{$table}` SET `qty`=`qty`-4 WHERE `id`=1 AND `stock_control`=1 AND `qty`>=4");
	$statement->execute();
	assertCartMysql($statement->rowCount() === 1, 'first stock reservation did not succeed');
	fwrite($sockets[0], '1');
	usleep(500000);
	$parent->commit();
	$childResult = json_decode(stream_get_contents($sockets[0]), true);
	fclose($sockets[0]);
	pcntl_waitpid($pid, $status);
	assertCartMysql(($childResult['error'] ?? null) === null, 'second stock reservation errored: ' . ($childResult['error'] ?? 'unknown'));
	assertCartMysql((int) ($childResult['affected'] ?? -1) === 0, 'second stock reservation should lose after the first commit');
	assertCartMysql((int) $parent->query("SELECT `qty` FROM `{$table}` WHERE `id`=1")->fetchColumn() === 1, 'stock became negative or was decremented twice');

	$parent->beginTransaction();
	$parent->exec("UPDATE `{$table}` SET `qty`=`qty`-1 WHERE `id`=1 AND `qty`>=1");
	$parent->rollBack();
	assertCartMysql((int) $parent->query("SELECT `qty` FROM `{$table}` WHERE `id`=1")->fetchColumn() === 1, 'rolled-back stock reservation was not restored');

	$parent->exec("UPDATE `{$table}` SET `qty`=10 WHERE `id` IN (1,2)");
	$parent = null;
	$orderSockets = stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);
	assertCartMysql($orderSockets !== false, 'failed to create ordered-lock synchronization socket');
	$orderPid = pcntl_fork();
	assertCartMysql($orderPid >= 0, 'failed to fork ordered stock contender');
	if ($orderPid === 0) {
		fclose($orderSockets[0]);
		$orderResult = ['error' => null];
		try {
			fread($orderSockets[1], 1);
			$child = $connect();
			$child->exec('SET SESSION innodb_lock_wait_timeout=5');
			$child->beginTransaction();
			$child->query("SELECT `id` FROM `{$table}` WHERE `id` IN (2,1) ORDER BY `id` ASC FOR UPDATE")->fetchAll();
			$child->exec("UPDATE `{$table}` SET `qty`=`qty`-1 WHERE `id`=1");
			$child->exec("UPDATE `{$table}` SET `qty`=`qty`-1 WHERE `id`=2");
			$child->commit();
		} catch (Throwable $e) {
			$orderResult['error'] = $e->getMessage();
		}
		fwrite($orderSockets[1], json_encode($orderResult));
		fclose($orderSockets[1]);
		exit($orderResult['error'] === null ? 0 : 1);
	}
	fclose($orderSockets[1]);
	$parent = $connect();
	$parent->beginTransaction();
	$parent->query("SELECT `id` FROM `{$table}` WHERE `id` IN (1,2) ORDER BY `id` ASC FOR UPDATE")->fetchAll();
	fwrite($orderSockets[0], '1');
	usleep(300000);
	$parent->exec("UPDATE `{$table}` SET `qty`=`qty`-1 WHERE `id`=1");
	$parent->exec("UPDATE `{$table}` SET `qty`=`qty`-1 WHERE `id`=2");
	$parent->commit();
	$orderResult = json_decode(stream_get_contents($orderSockets[0]), true);
	fclose($orderSockets[0]);
	pcntl_waitpid($orderPid, $orderStatus);
	assertCartMysql(($orderResult['error'] ?? null) === null, 'PID-ordered stock reservation deadlocked: ' . ($orderResult['error'] ?? 'unknown'));
	$orderedQty = $parent->query("SELECT `id`,`qty` FROM `{$table}` ORDER BY `id`")->fetchAll(PDO::FETCH_KEY_PAIR);
	assertCartMysql((int) $orderedQty[1] === 8 && (int) $orderedQty[2] === 8, 'PID-ordered stock reservations did not both commit');

	$lockA = 'z77_cart_lock_' . getmypid() . '_a';
	$lockB = 'z77_cart_lock_' . getmypid() . '_b';
	$first = $connect();
	$second = $connect();
	$getLock = function (PDO $pdo, $name) {
		$stmt = $pdo->prepare('SELECT GET_LOCK(?, 0)');
		$stmt->execute([$name]);
		return (int) $stmt->fetchColumn();
	};
	$releaseLock = function (PDO $pdo, $name) {
		$stmt = $pdo->prepare('SELECT RELEASE_LOCK(?)');
		$stmt->execute([$name]);
	};
	assertCartMysql($getLock($first, $lockA) === 1, 'first UID lock was not acquired');
	assertCartMysql($getLock($second, $lockA) === 0, 'same UID lock was not mutually exclusive');
	assertCartMysql($getLock($second, $lockB) === 1, 'different UID locks should not block each other');
	$releaseLock($second, $lockB);
	$releaseLock($first, $lockA);
	assertCartMysql($getLock($second, $lockA) === 1, 'UID lock was not reusable after release');
	$releaseLock($second, $lockA);

	fwrite(STDOUT, "MySQL cart concurrency integration passed\n");
} finally {
	$cleanup = $connect();
	$cleanup->exec("DROP TABLE IF EXISTS `{$table}`");
}
