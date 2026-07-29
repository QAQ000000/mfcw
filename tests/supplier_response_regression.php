<?php

define("CMF_ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);

class SupplierResponseTestClientActivityLog
{
	public static function markInternal($description, $source)
	{
		return "[internal:" . $source . "]" . $description;
	}

	public static function isSupplierApiType($apiType)
	{
		return in_array(strtolower((string) $apiType), ["zjmf_api", "resource", "manual", "whmcs"], true);
	}
}

class_alias("SupplierResponseTestClientActivityLog", "app\\common\\logic\\ClientActivityLog");

$supplierResponseTestLogs = [];
function active_log_final($description, $userid = 0, $type = 0, $typeDataId = 0)
{
	global $supplierResponseTestLogs;
	$supplierResponseTestLogs[] = [$description, $userid, $type, $typeDataId];
	return true;
}

require dirname(__DIR__) . "/app/common/logic/Dcim.php";
require dirname(__DIR__) . "/app/common/logic/Host.php";

function assertSupplierCondition($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function supplierMethodSource($relativePath, $method)
{
	$source = file_get_contents(dirname(__DIR__) . "/" . $relativePath);
	$pattern = '/(?:public|protected|private) function ' . preg_quote($method, '/') . '\\b.*?(?=\\n\\t(?:public|protected|private) function |\\n})/s';
	assertSupplierCondition((bool) preg_match($pattern, $source, $matches), $relativePath . "::" . $method . " must exist");
	return $matches[0];
}

$logic = new \app\common\logic\Dcim();
$rawFailure = [
	"status" => 400,
	"msg" => "CURL ERROR: endpoint https://supplier.invalid timed out",
	"http_code" => 0,
	"content" => "api_key=secret",
	"data" => ["debug" => "supplier stack", "password" => "raw-password", "token" => "raw-token", "crackPwd" => "raw-crack-password"],
];
$clientFailure = $logic->supplierFailureForClient($rawFailure, 17, 29, "测试操作", "操作失败");
assertSupplierCondition($clientFailure === ["status" => 400, "msg" => "操作失败"], "customer failures must not retain raw supplier fields");
assertSupplierCondition(count($supplierResponseTestLogs) === 1, "raw supplier diagnostics must be recorded internally");
assertSupplierCondition(strpos($supplierResponseTestLogs[0][0], "[internal:supplier]") === 0, "supplier diagnostics must carry the internal marker");
assertSupplierCondition(strpos($supplierResponseTestLogs[0][0], "CURL ERROR:") !== false, "the internal diagnostic must retain the actionable error");
foreach (["secret", "raw-password", "raw-token", "raw-crack-password"] as $sensitiveValue) {
	assertSupplierCondition(strpos($supplierResponseTestLogs[0][0], $sensitiveValue) === false, "internal diagnostics must redact " . $sensitiveValue);
}
for ($attempt = 0; $attempt < 40; $attempt++) {
	$logic->supplierFailureForClient($rawFailure, 17, 29, "测试操作", "操作失败");
}
assertSupplierCondition(count($supplierResponseTestLogs) === 1, "identical polling diagnostics must be recorded at most once per throttle window");

$preservedFailure = $logic->supplierFailureForClient($rawFailure + ["confirm" => false], 17, 29, "测试确认", "操作失败", ["confirm"]);
assertSupplierCondition($preservedFailure === ["status" => 400, "msg" => "操作失败", "confirm" => false], "only explicitly allowed failure fields may survive");

$logic->is_admin = true;
$adminFailure = $logic->supplierFailureForClient($rawFailure, 17, 29, "后台测试", "操作失败");
assertSupplierCondition(strpos($adminFailure["msg"], "CURL ERROR:") !== false, "administrators must retain the supplier diagnostic message");
assertSupplierCondition(isset($adminFailure["http_code"], $adminFailure["content"], $adminFailure["data"]), "administrators must retain the original diagnostic fields");
$logic->is_admin = false;

$safeSuccess = $logic->supplierSuccessForClient(
	[
		"status" => 200,
		"msg" => "supplier message",
		"num" => 2,
		"endpoint" => "https://supplier.invalid",
		"data" => ["time" => 123, "value" => 9, "debug" => "secret"],
	],
	"请求成功",
	["num"],
	["time", "value"]
);
assertSupplierCondition(
	$safeSuccess === ["status" => 200, "msg" => "请求成功", "num" => 2, "data" => ["time" => 123, "value" => 9]],
	"successful supplier responses must be reconstructed from allowlisted fields"
);

$vncMethod = (new ReflectionClass($logic))->getMethod("supplierVncSuccess");
$vncMethod->setAccessible(true);
$nestedVnc = $vncMethod->invoke($logic, ["status" => 200, "data" => ["password" => "nested-pass", "url" => "wss://nested.invalid"]], "vnc启动成功");
assertSupplierCondition($nestedVnc["data"] === ["password" => "nested-pass", "url" => "wss://nested.invalid"], "nested VNC responses must retain the client contract");
$topVnc = $vncMethod->invoke($logic, ["status" => 200, "password" => "top-pass", "url" => "wss://top.invalid"], "vnc启动成功");
assertSupplierCondition($topVnc["data"] === ["password" => "top-pass", "url" => "wss://top.invalid"], "legacy top-level VNC responses must be normalized");
assertSupplierCondition($vncMethod->invoke($logic, ["status" => 200, "url" => "wss://missing.invalid"], "vnc启动成功") === null, "VNC responses without a password must fail validation");
$logic->is_admin = true;
$adminVnc = $vncMethod->invoke($logic, ["status" => 200, "vnc_pass" => "admin-pass", "url" => "wss://admin.invalid", "task" => "diagnostic"], "vnc启动成功");
assertSupplierCondition($adminVnc["password"] === "admin-pass" && $adminVnc["pass"] === "admin-pass", "administrator VNC responses must preserve password and pass compatibility fields");
assertSupplierCondition($adminVnc["data"] === ["password" => "admin-pass", "url" => "wss://admin.invalid"], "administrator VNC responses must also expose the normalized data contract");
assertSupplierCondition($adminVnc["task"] === "diagnostic", "administrator VNC responses must retain upstream diagnostic fields");
$logic->is_admin = false;

$hostLogic = new \app\common\logic\Host();
$statusMethod = (new ReflectionClass($hostLogic))->getMethod("statusDataForClient");
$statusMethod->setAccessible(true);
$supplierStatus = $statusMethod->invoke($hostLogic, [
	"status" => 200,
	"data" => [
		"status" => "on",
		"des" => "supplier text",
		"endpoint" => "https://supplier.invalid",
		"debug" => "supplier stack",
		"task_name" => "supplier task",
	],
], "zjmf_api");
assertSupplierCondition($supplierStatus === ["status" => "on", "des" => "开机"], "customer status responses must use the local status allowlist");
$unknownSupplierStatus = $statusMethod->invoke($hostLogic, ["data" => ["status" => "vendor-private", "debug" => "secret"]], "resource");
assertSupplierCondition($unknownSupplierStatus === ["status" => "unknown", "des" => "未知"], "unknown supplier status values must fail closed");
$hostLogic->is_admin = true;
$adminStatusData = ["status" => "on", "endpoint" => "https://supplier.invalid", "debug" => "supplier stack", "task_name" => "supplier task"];
assertSupplierCondition($statusMethod->invoke($hostLogic, ["data" => $adminStatusData], "resource") === $adminStatusData, "administrators must retain the complete supplier status response");
$hostLogic->is_admin = false;

$dcimMethods = ["traffic", "novnc", "reinstall", "cancelReinstall", "reinstallStatus", "detail", "refreshPowerStatus", "getTrafficUsage"];
foreach ($dcimMethods as $method) {
	$methodSource = supplierMethodSource("app/common/logic/Dcim.php", $method);
	assertSupplierCondition(
		strpos($methodSource, "supplierFailureForClient") !== false,
		"Dcim::" . $method . " must use the client-safe supplier failure contract"
	);
}

$reinstallStatusSource = supplierMethodSource("app/common/logic/Dcim.php", "reinstallStatus");
assertSupplierCondition(strpos($reinstallStatusSource, '"任务执行失败，请稍后重试或联系管理员"') !== false, "reinstall errors must use local text");
assertSupplierCondition(strpos($reinstallStatusSource, '$result["data"]["last_result"] = ["act" => $lastAct') !== false, "reinstall result text must be reconstructed locally");
assertSupplierCondition(strpos($reinstallStatusSource, 'if (!$this->is_admin)') !== false, "reinstall response rewriting must be limited to customer mode");

$powerStatusSource = supplierMethodSource("app/common/logic/Dcim.php", "refreshPowerStatus");
assertSupplierCondition(strpos($powerStatusSource, '$powerMap = [') !== false, "power status descriptions must come from a local enum");
assertSupplierCondition(substr_count($powerStatusSource, '"任务处理中"') >= 3, "customer power task descriptions must use fixed local text in every supplier branch");
assertSupplierCondition(strpos($powerStatusSource, '$this->is_admin && !empty($res["task_name"])') !== false, "administrator power responses must retain supplier task details");

$refreshControllerSource = supplierMethodSource("app/home/controller/DcimController.php", "refreshServerPowerStatus");
assertSupplierCondition(strpos($refreshControllerSource, 'where("a.uid", $request->uid)') !== false, "power refresh must verify host ownership");
assertSupplierCondition(strpos($refreshControllerSource, 'where("a.domainstatus", "Active")') !== false, "power refresh must reject inactive hosts");

foreach (["checkReinstall", "hideLastResult"] as $method) {
	$methodSource = supplierMethodSource("app/home/controller/DcimController.php", $method);
	assertSupplierCondition(strpos($methodSource, "supplierFailureForClient") !== false, "DcimController::" . $method . " must hide supplier failures");
}

$hostTrafficSource = supplierMethodSource("app/home/controller/HostController.php", "getTrafficUsage");
assertSupplierCondition(strpos($hostTrafficSource, "supplierFailureForClient") !== false, "Host traffic usage must hide supplier failures");
assertSupplierCondition(strpos($hostTrafficSource, '["time", "value", "in", "out"]') !== false, "Host traffic usage must use an explicit point-field allowlist");

fwrite(STDOUT, "supplier response regression checks passed" . PHP_EOL);
