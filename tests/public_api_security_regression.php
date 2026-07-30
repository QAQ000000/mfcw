<?php

function assertPublicApiSecurity($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/data/route/api.php');
$provision = file_get_contents($root . '/app/home/controller/ProvisionController.php');
$products = file_get_contents($root . '/app/api/controller/ProductController.php');
$flowPackets = file_get_contents($root . '/app/api/controller/FlowPacketController.php');
$ticket = file_get_contents($root . '/app/home/controller/TicketController.php');
$adminCheck = file_get_contents($root . '/app/http/middleware/AdminCheck.php');

assertPublicApiSecurity(
	strpos($routes, 'Route::get("api/product/upgrade_product", "api/product/getUpgradeProduct")->middleware("Check")') !== false,
	'upgrade-product pricing must require an authenticated client'
);
assertPublicApiSecurity(
	strpos($provision, 'supplierCustomSuccess($host, $res, $func)') !== false,
	'supplier custom methods must use their function-specific response schema'
);
assertPublicApiSecurity(
	strpos($provision, 'case "listSnapBackup"') !== false
		&& strpos($provision, '"disk_name", "remarks", "create_time"') !== false
		&& strpos($provision, 'case "showSecurityRules"') !== false
		&& strpos($provision, 'is_array($response["list"] ?? null)') !== false
		&& strpos($provision, 'case "remoteInfo"') !== false
		&& strpos($provision, '? 0 : 1') !== false,
	'supplier custom read methods must retain only their documented customer fields'
);
assertPublicApiSecurity(
	strpos($provision, 'supplierProxySuccess($host, $result, "操作成功", ["url"])') !== false,
	'supplier custom buttons may expose only the required redirect URL'
);
assertPublicApiSecurity(
	strpos($products, "unset(\$v['api_type'], \$v['upstream_version'], \$v['upstream_price_type'], \$v['upstream_price_value'])") !== false,
	'upgrade products must remove internal supplier and markup fields'
);
assertPublicApiSecurity(
	strpos($products, "->where('p.api_type', '<>', 'resource')") !== false
		&& strpos(substr($products, strpos($products, 'public function getUpgradeProduct')), 'resourceUserGradePercent') === false,
	'upgrade products must exclude P3 resource products and calls'
);
assertPublicApiSecurity(
	strpos($flowPackets, "->where('p.hidden', 0)") !== false
		&& strpos($flowPackets, "->where('g.hidden', 0)") !== false
		&& strpos($flowPackets, "->where('p.api_type', '<>', 'resource')") !== false,
	'flow packets must expose only visible non-P3 products in visible groups'
);
assertPublicApiSecurity(
	substr_count($flowPackets, "empty(\$packet['product'])") >= 1 || strpos($flowPackets, "empty(\$packets[\$key]['product'])") !== false,
	'packets without any public product must be omitted'
);
$ticketHook = strpos($ticket, 'hook("before_create_ticket", $params)');
$departmentCheck = strpos($ticket, 'if (empty($department))');
$serviceCheck = strpos($ticket, '$service = intval($params["service"])');
assertPublicApiSecurity($ticketHook !== false && $departmentCheck !== false && $serviceCheck !== false && $ticketHook > $departmentCheck && $ticketHook > $serviceCheck, 'ticket hooks must run only after caller, department, and service validation');
assertPublicApiSecurity(strpos($adminCheck, 'intval($sessionAdminId) !== 1') !== false, 'database upgrades must be restricted to the super administrator');
assertPublicApiSecurity(strpos($adminCheck, 'Access-Control-Allow-Origin') === false && strpos($adminCheck, 'Access-Control-Allow-Credentials') === false, 'upgrade routes must not reflect credentialed cross-origin requests');

fwrite(STDOUT, "public API security regression checks passed" . PHP_EOL);
