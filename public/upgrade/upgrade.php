<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit;
}
if (!in_array('--run', $argv, true)) {
    fwrite(STDERR, "用法: php upgrade.php --run\n");
    exit(2);
}

$database = include dirname(__DIR__, 2) . "/app/config/database.php";
$host = $database['hostname'];
$dbname = $database['database'];
$prefix = $database['prefix']??"shd_";
if (!preg_match('/^[a-z0-9_]+$/i', $prefix)) {
	    fwrite(STDERR, "数据库表前缀不合法，升级已停止\n");
	    exit(1);
}
$user = $database['username'];
$pass = $database['password'];
$defaultCharset = 'utf8mb4';
$charset = $database['charset'];
$defaultTablePre = 'shd_';
$port = $database['hostport'];
try{
    $opts_values = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    );
    $dbObject = new PDO("mysql:host={$host};port={$port};dbname={$dbname}",$user,$pass,$opts_values);
}catch (PDOException $e){
    error_log('Database upgrade connection failed: ' . $e->getMessage());
    fwrite(STDERR, "数据库连接失败，请检查服务端错误日志\n");
    exit(1);
}
$res = $dbObject->query('select*from ' . $prefix . "configuration where setting='update_last_version'")->fetchAll(PDO::FETCH_ASSOC);
$version = $res[0]['value'];
if(empty($version)){
		fwrite(STDERR, "未找到 update_last_version，升级已停止\n");
	    exit(1);
}
# 内测版
$system_version_type = $dbObject->query('select*from ' . $prefix . "configuration where setting='system_version_type'")->fetchAll(PDO::FETCH_ASSOC);
if ($system_version_type[0]['value'] && $system_version_type[0]['value'] == 'beta'){
    $beta_version =  $dbObject->query('select*from ' . $prefix . "configuration where setting='beta_version'")->fetchAll(PDO::FETCH_ASSOC);
    $version = $beta_version[0]['value']??$version;
}
if(empty($version)){
		fwrite(STDERR, "未找到可升级版本，升级已停止\n");
	    exit(1);
}
$handle = fopen(__DIR__ . '/upgrade.log', 'r');
$content = '';
while(!feof($handle)){
    $content .= fread($handle, 8080);
}
fclose($handle);
$arr = explode("\n",$content);
//过滤空值
$fun = function ($value){
    if (empty($value)){
        return false;
    }else{
        return true;
    }
};
$arr = array_filter($arr,$fun);
$arr_last_pop = array_pop($arr);
$arr_last = explode(',',$arr_last_pop);
//获取最新记录
$arr[] = $arr_last_pop;
$last_version = $arr_last[1];
if (version_compare($last_version,$version,'>')){
    foreach ($arr as $v){
        $v = explode(',',$v);
        $sql_version = $v[1];
        $sql_file = __DIR__ . '/' . $v[1] . '.sql';
        if (version_compare($sql_version,$version,'>')){
            if (file_exists($sql_file)){
                //读取SQL文件
                $sql = file_get_contents($sql_file);
                $sql = str_replace("\r", "\n", $sql);
                $sql = str_replace("BEGIN;\n", '', $sql);//兼容 navicat 导出的 insert 语句
                $sql = str_replace("COMMIT;\n", '', $sql);//兼容 navicat 导出的 insert 语句
                $sql = str_replace($defaultCharset, $charset, $sql);
                $sql = trim($sql);
                //替换表前缀
                $sql  = str_replace(" `{$defaultTablePre}", " `{$prefix}", $sql);
                $sqls = explode(";\n", $sql);
                foreach ($sqls as $sql){
                    try{
                        $dbObject->query($sql);
                    }catch (PDOException $e){
                        error_log("Database upgrade failed at version {$sql_version}: " . $e->getMessage());
                        fwrite(STDERR, "数据库升级失败，版本号未更新，请检查服务端错误日志\n");
                        exit(1);
                    }
                }
            }
        }
    }
}
if (version_compare($last_version, '3.5.8.1', '>=')) {
    $visibilityColumn = $dbObject->query("SHOW COLUMNS FROM `{$prefix}activity_log` LIKE 'client_visible'")->fetch(PDO::FETCH_ASSOC);
	    if (!$visibilityColumn || (string) $visibilityColumn['Default'] !== '0') {
	        fwrite(STDERR, "数据库升级校验失败，版本号未更新\n");
	        exit(1);
	    }
	$dirtyRows = $dbObject->query("SELECT COUNT(*) FROM `{$prefix}configuration` WHERE `setting` = '_product_catalog_cache_dirty'")->fetchColumn();
		if ((int) $dirtyRows < 1) {
			fwrite(STDERR, "商品缓存升级校验失败，版本号未更新\n");
			exit(1);
		}
}
if (version_compare($last_version, '3.5.8.2', '>=')) {
	$pendingTable = $dbObject->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = " . $dbObject->quote($prefix . 'product_catalog_cache_pending'))->fetchColumn();
		if ((int) $pendingTable !== 1) {
			fwrite(STDERR, "商品缓存待清理表升级校验失败，版本号未更新\n");
			exit(1);
		}
}
if (version_compare($last_version, '3.5.8.3', '>=')) {
	$expectedIndexes = [
		['activity_log', 'idx_activity_log_client_page', [['uid', null], ['client_visible', null], ['id', null]]],
		['clients', 'idx_clients_email', [['email', null]]],
		['invoice_items', 'idx_invoice_items_rel_type_invoice', [['rel_id', null], ['type', null], ['invoice_id', null]]],
		['orders', 'idx_orders_invoiceid', [['invoiceid', null]]],
		['jobs', 'idx_jobs_expired', [['queue', 191], ['reserved', null], ['reserved_at', null]]],
		['jobs', 'idx_jobs_available', [['queue', 191], ['reserved', null], ['id', null], ['available_at', null]]],
	];
	try {
		$tableStatement = $dbObject->prepare('SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?');
		$indexStatement = $dbObject->prepare('SELECT COLUMN_NAME AS column_name, SEQ_IN_INDEX AS seq_in_index, SUB_PART AS sub_part, NON_UNIQUE AS non_unique FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ? ORDER BY SEQ_IN_INDEX');
		foreach ($expectedIndexes as $expectedIndex) {
			$tableName = $prefix . $expectedIndex[0];
			$tableStatement->execute([$tableName]);
			if ((int) $tableStatement->fetchColumn() !== 1) {
				throw new RuntimeException("table {$tableName} is missing");
			}
			$indexStatement->execute([$tableName, $expectedIndex[1]]);
			$indexRows = $indexStatement->fetchAll(PDO::FETCH_ASSOC);
			if (count($indexRows) !== count($expectedIndex[2])) {
				throw new RuntimeException("index {$tableName}.{$expectedIndex[1]} has an unexpected column count");
			}
			foreach ($expectedIndex[2] as $position => $expectedColumn) {
				$actualColumn = $indexRows[$position];
				$actualPrefix = isset($actualColumn['sub_part']) ? (int) $actualColumn['sub_part'] : null;
				if ((string) $actualColumn['column_name'] !== $expectedColumn[0]
					|| (int) $actualColumn['seq_in_index'] !== $position + 1
					|| $actualPrefix !== $expectedColumn[1]
					|| (int) $actualColumn['non_unique'] !== 1) {
					throw new RuntimeException("index {$tableName}.{$expectedIndex[1]} has an unexpected definition");
				}
			}
		}
		} catch (Throwable $e) {
			error_log('Database upgrade postcondition failed: ' . $e->getMessage());
			fwrite(STDERR, "数据库索引升级校验失败，版本号未更新\n");
			exit(1);
		}
}
if (version_compare($last_version, '3.7.7', '>=')) {
	$cartIndexStatement = $dbObject->prepare("SELECT COLUMN_NAME AS column_name, SEQ_IN_INDEX AS seq_in_index, SUB_PART AS sub_part, NON_UNIQUE AS non_unique FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = 'uq_cart_session_uid' ORDER BY SEQ_IN_INDEX");
	$cartIndexStatement->execute([$prefix . 'cart_session']);
	$cartIndexRows = $cartIndexStatement->fetchAll(PDO::FETCH_ASSOC);
	$cartIndex = $cartIndexRows[0] ?? [];
	if (count($cartIndexRows) !== 1
		|| (string) ($cartIndex['column_name'] ?? '') !== 'uid'
		|| (int) ($cartIndex['seq_in_index'] ?? 0) !== 1
		|| (int) ($cartIndex['sub_part'] ?? 0) !== 100
			|| (int) ($cartIndex['non_unique'] ?? 1) !== 0) {
			fwrite(STDERR, "购物车并发约束升级校验失败，版本号未更新\n");
			exit(1);
		}
}
if ($system_version_type[0]['value'] && $system_version_type[0]['value'] == 'beta'){ # 内测版
    $update_sql_beta = "update " . $prefix . "configuration set value='{$last_version}' where setting = 'beta_version'";
    $dbObject->query($update_sql_beta);
}
$update_sql = "update " . $prefix . "configuration set value='{$last_version}' where setting = 'update_last_version'";
$res = $dbObject->query($update_sql);
$executed_update = "update " . $prefix . "configuration set value=1 where setting = 'executed_update'";
$res = $dbObject->query($executed_update);
// 升级成功,注销登录
session_start();
$_SESSION = [];
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'',time()-3600,'/');
}
session_destroy();
echo "恭喜你，升级完成\n系统升级已完成，请删除public/upgrade目录";

