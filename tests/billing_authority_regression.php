<?php

function assertBillingAuthority($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function readBillingSource($root, $path)
{
	$source = file_get_contents($root . "/" . $path);
	assertBillingAuthority($source !== false, $path . " must be readable");
	return str_replace("\r\n", "\n", $source);
}

$root = dirname(__DIR__);
$homeCart = readBillingSource($root, "app/home/controller/CartController.php");
$openApiCart = readBillingSource($root, "app/openapi/controller/CartController.php");
$homeUpgrade = readBillingSource($root, "app/home/controller/UpgradeController.php");
$openApiProduct = readBillingSource($root, "app/openapi/controller/ProductController.php");
$openApiHost = readBillingSource($root, "app/openapi/controller/HostController.php");
$upgradeLogic = readBillingSource($root, "app/common/logic/Upgrade.php");
$renewLogic = readBillingSource($root, "app/common/logic/Renew.php");
$hostLogic = readBillingSource($root, "app/common/logic/Host.php");
$openApiRoutes = readBillingSource($root, "data/route/openapi.php");

foreach ([$homeCart, $openApiCart, $homeUpgrade, $openApiProduct, $openApiHost] as $source) {
	assertBillingAuthority(strpos($source, 'resource_percent_value') === false, "request-controlled resource percentages must not reach billing controllers");
}
assertBillingAuthority(strpos($renewLogic, '$param["resource_handling"]') === false, "request-controlled renewal handling must not affect renewal prices");
assertBillingAuthority(strpos($upgradeLogic, '* $percent_value') === false, "legacy upgrade percentages must not affect server-calculated prices");

assertBillingAuthority(strpos($renewLogic, 'field("id,uid")->whereIn("id", $hids)') !== false, "batch renewal must load every host owner before billing");
assertBillingAuthority(strpos($renewLogic, 'intval($host_owner["uid"]) !== $uid') !== false, "batch renewal must reject foreign hosts");
assertBillingAuthority(strpos($renewLogic, '!$this->is_admin && $uid !== intval(request()->uid)') !== false, "single renewal must enforce authenticated ownership");
assertBillingAuthority(strpos($renewLogic, '$this->is_admin && !empty($this->params)') !== false, "custom renewal amounts must be restricted to administrators");

foreach ([$homeUpgrade, $openApiProduct, $openApiHost] as $source) {
	assertBillingAuthority(strpos($source, '"upgrade_down_config_" . intval(request()->uid) . "_" . $hid') !== false, "configuration upgrade caches must be isolated by user");
	assertBillingAuthority(strpos($source, '"upgrade_down_product_" . intval(request()->uid) . "_" . $hid') !== false, "product upgrade caches must be isolated by user");
	assertBillingAuthority(strpos($source, 'judgeUpgradeConfigError($hid, "configoptions", intval(request()->uid))') !== false, "configuration upgrades must validate host ownership");
}

assertBillingAuthority(strpos($hostLogic, '$post_data["resource_percent_value"]') !== false, "legacy downstream upgrade requests must remain wire-compatible");
assertBillingAuthority(strpos($hostLogic, '$post_data["resource_handling"]') !== false, "legacy downstream renewal requests must remain wire-compatible");
assertBillingAuthority(strpos($openApiRoutes, 'middleware("Check")') !== false, "authenticated OpenAPI routes must remain enabled");
assertBillingAuthority(substr_count($openApiRoutes, 'Route::') > 100, "the OpenAPI route surface must not be removed as a security workaround");

fwrite(STDOUT, "Billing authority regression checks passed" . PHP_EOL);
