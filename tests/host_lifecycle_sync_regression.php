<?php

function assertHostLifecycleSync($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$root = dirname(__DIR__);
$hostLogic = file_get_contents($root . "/app/common/logic/Host.php");
$hostApi = file_get_contents($root . "/app/api/controller/HostController.php");
$pushLogic = file_get_contents($root . "/app/zjmf.php");
$cron = file_get_contents($root . "/app/admin/command/Cron.php");
$adminServices = file_get_contents($root . "/app/admin/controller/ClientsServicesController.php");
$adminOrders = file_get_contents($root . "/app/admin/controller/OrderController.php");
$homeProvision = file_get_contents($root . "/app/home/controller/ProvisionController.php");

$suspendStart = strpos($hostLogic, 'public function suspend(');
$unsuspendStart = strpos($hostLogic, 'public function unsuspend(');
$terminateStart = strpos($hostLogic, 'public function terminate(');

assertHostLifecycleSync($suspendStart !== false && $unsuspendStart !== false && $terminateStart !== false, "host lifecycle methods must exist");

$suspendMethod = substr($hostLogic, $suspendStart, $unsuspendStart - $suspendStart);
$unsuspendMethod = substr($hostLogic, $unsuspendStart, $terminateStart - $unsuspendStart);
$terminateMethod = substr($hostLogic, $terminateStart, strpos($hostLogic, 'public function sync(', $terminateStart) - $terminateStart);

assertHostLifecycleSync(strpos($suspendMethod, 'pushHostInfo($id, "domainstatus,suspendreason");') !== false, "successful suspension must push status and reason downstream");
assertHostLifecycleSync(strpos($suspendMethod, 'if ($reason_type == "flow")') === false, "expiry suspension must not be excluded from downstream synchronization");
assertHostLifecycleSync(strpos($unsuspendMethod, 'if ($host["domainstatus"] == "Suspended")') !== false, "every real suspended-to-active transition must be synchronized");
assertHostLifecycleSync(strpos($unsuspendMethod, '&& ($suspendreason == "用量超额" || $suspendreason == "flow")') === false, "expiry renewal must not be excluded from downstream synchronization");
$terminatePush = strpos($terminateMethod, 'pushHostInfo($id, "suspendreason");');
$terminateClear = strpos($terminateMethod, 'update(["stream_info" => ""])');
assertHostLifecycleSync($terminatePush !== false && $terminateClear !== false && $terminatePush < $terminateClear, "termination must persist synchronization before stream metadata is cleared");
assertHostLifecycleSync(strpos($hostApi, '["Pending", "Active", "Cancelled", "Fraud", "Deleted", "Suspended"]') !== false, "the downstream sync endpoint must accept lifecycle statuses");
assertHostLifecycleSync(strpos($hostApi, '$sync_type = $params["type"] ?? "";') !== false, "ordinary lifecycle pushes must not require a create type field");
assertHostLifecycleSync(strpos($hostApi, '$params["suspendreason"] ?? $host["suspendreason"]') !== false, "sync payloads without a suspension reason must preserve the current value");
assertHostLifecycleSync(strpos($hostApi, 'a.serverid') !== false, "create synchronization diagnostics must load the server id they use");
assertHostLifecycleSync(strpos($hostApi, '$sms_params = ["product_name"') !== false, "welcome notifications must not overwrite the authenticated synchronization payload");
assertHostLifecycleSync(strpos($hostApi, 'if (!empty($stream_info["downstream_url"]))') !== false && strpos($hostApi, 'pushHostInfo($id, "suspendreason");') !== false, "received lifecycle changes and reasons must continue through reseller chains");
assertHostLifecycleSync(strpos($pushLogic, 'insertGetId($retry)') !== false && strpos($pushLogic, 'where("post_data", $encoded_post_data)->delete()') !== false, "lifecycle pushes must be persisted before delivery and removed only after the same payload succeeds");
assertHostLifecycleSync(strpos($cron, 'field("id,host_id,url,post_data,num")') !== false, "the retry worker must load the row id and attempt count it updates");
assertHostLifecycleSync(strpos($cron, 'where("post_data", $v["post_data"])') !== false, "a slow retry must not acknowledge a newer lifecycle payload");
assertHostLifecycleSync(strpos($hostLogic, 'mergeUpstreamLifecycleState') !== false && strpos($hostLogic, '$update["suspendreason"] = "";') !== false, "manual synchronization must reconcile upstream lifecycle state and reason");
assertHostLifecycleSync(strpos($hostLogic, 'in_array($localStatus, $terminalStatuses, true)') !== false, "manual synchronization must not revive a locally terminal service");
assertHostLifecycleSync(strpos($hostLogic, '$status === "Active" && !in_array($localStatus, ["Pending", "Active"], true)') !== false, "manual synchronization must not clear a local suspension");
assertHostLifecycleSync(strpos($hostLogic, '$suspendreasonType . "-" . $suspendreason') !== false, "manual synchronization must preserve the upstream suspension type");
assertHostLifecycleSync(strpos($terminateMethod, '$module_res = resourceCurl($host["productid"], "/host/cancel", $post_data);') !== false, "resource termination must use the supplier response");
assertHostLifecycleSync(strpos($adminServices, 'pushHostInfo($id, "domainstatus,suspendreason");') !== false, "database-only administrator suspension must still notify downstream resellers");
assertHostLifecycleSync(strpos($homeProvision, 'pushHostInfo($id);') !== false, "custom supplier actions that change status must notify downstream resellers");
assertHostLifecycleSync(strpos($adminOrders, 'whereNotIn("domainstatus", ["Pending", "Cancelled"])') !== false, "order cancellation must not silently cancel provisioned services");

require_once $root . "/app/common/logic/Host.php";
$hostLogicInstance = new \app\common\logic\Host();
$mergeLifecycle = new ReflectionMethod($hostLogicInstance, "mergeUpstreamLifecycleState");
$mergeLifecycle->setAccessible(true);
$mergeState = function (array $host, array $upstream) use ($mergeLifecycle, $hostLogicInstance) {
	$update = [];
	$arguments = [$host, $upstream, &$update];
	$mergeLifecycle->invokeArgs($hostLogicInstance, $arguments);
	return $update;
};

$pendingActivation = $mergeState(["domainstatus" => "Pending"], ["domainstatus" => "Active"]);
assertHostLifecycleSync(($pendingActivation["domainstatus"] ?? "") === "Active" && ($pendingActivation["suspendreason"] ?? null) === "", "manual synchronization must still activate a pending service");
$localSuspension = $mergeState(["domainstatus" => "Suspended"], ["domainstatus" => "Active"]);
assertHostLifecycleSync(!isset($localSuspension["domainstatus"]), "manual synchronization must preserve a local suspension");
$localTermination = $mergeState(["domainstatus" => "Deleted"], ["domainstatus" => "Active"]);
assertHostLifecycleSync(!isset($localTermination["domainstatus"]), "manual synchronization must not revive a deleted service");
$upstreamSuspension = $mergeState(["domainstatus" => "Active"], ["domainstatus" => "Suspended", "suspendreason_type" => "due", "suspendreason" => "产品到期"]);
assertHostLifecycleSync(($upstreamSuspension["domainstatus"] ?? "") === "Suspended" && ($upstreamSuspension["suspendreason"] ?? "") === "due-产品到期", "manual synchronization must reconstruct the typed upstream suspension reason");
$upstreamTermination = $mergeState(["domainstatus" => "Active"], ["domainstatus" => "Deleted"]);
assertHostLifecycleSync(($upstreamTermination["domainstatus"] ?? "") === "Deleted", "manual synchronization must apply an upstream terminal state");

fwrite(STDOUT, "host lifecycle sync regression checks passed" . PHP_EOL);
