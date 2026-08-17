<?php

if (getenv("RUN_MYSQL_INTEGRATION") !== "1") {
	fwrite(STDOUT, "SKIP: set RUN_MYSQL_INTEGRATION=1 to run the upstream auto-create queue test\n");
	exit(0);
}

function assertUpstreamQueueMysql($condition, $message)
{
	if (!$condition) {
		throw new RuntimeException($message);
	}
}

$appRoot = getenv("ZJMF_APP_ROOT") ?: dirname(__DIR__);
$root = rtrim($appRoot, "/") . "/";
assertUpstreamQueueMysql(is_file($root . "app/config/database.php"), "database config is missing");

define("APP_DEBUG", true);
define("CMF_ROOT", $root);
define("CMF_DATA", CMF_ROOT . "data/");
define("WEB_ROOT", CMF_ROOT . "public/");
define("APP_PATH", CMF_ROOT . "app/");
define("RUNTIME_PATH", CMF_DATA . "runtime_cli/");

require CMF_ROOT . "vendor/thinkphp/base.php";

\think\Container::get("app", [APP_PATH])->initialize();

$hostId = 2000000000 + random_int(1, 100000000);
\think\Db::startTrans();
try {
	\app\queue\job\AutoCreate::push(["hid" => $hostId, "is_admin" => false, "ip" => ""]);
	$jobs = \think\Db::name("jobs")->where("payload", "like", "%{$hostId}%")->select()->toArray();
	$matched = false;
	foreach ($jobs as $job) {
		$payload = json_decode($job["payload"], true);
		if (($payload["job"] ?? "") === \app\queue\job\AutoCreate::class && (int) ($payload["data"]["hid"] ?? 0) === $hostId) {
			$matched = true;
			break;
		}
	}
	assertUpstreamQueueMysql($matched, "AutoCreate::push must persist a database job for the host");
} finally {
	\think\Db::rollback();
}

echo "upstream auto-create database queue integration passed" . PHP_EOL;
