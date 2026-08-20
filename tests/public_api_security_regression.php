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
$openapiLogin = file_get_contents($root . '/app/openapi/controller/LoginController.php');
$openapiPublic = file_get_contents($root . '/app/openapi/controller/PublicController.php');
$openapiAffiliate = file_get_contents($root . '/app/openapi/controller/AffiliateController.php');
$oauth = file_get_contents($root . '/app/api/controller/OauthController.php');
$legacyOauthView = file_get_contents($root . '/app/home/controller/ViewClientsController.php');
$homeRoutes = file_get_contents($root . '/data/route/home.php');
$homeIndex = file_get_contents($root . '/app/home/controller/IndexController.php');
$legacyAdmin = file_get_contents($root . '/app/admin/controller/AdminController.php');
$homeLogin = file_get_contents($root . '/app/home/controller/LoginController.php');
$productListStart = strpos($products, 'public function proList()');
$productDetailStart = strpos($products, 'public function detail()');
$upgradeProductStart = strpos($products, 'public function getUpgradeProduct()');
$productList = substr($products, $productListStart, $productDetailStart - $productListStart);
$productDetail = substr($products, $productDetailStart, $upgradeProductStart - $productDetailStart);
$upgradeProducts = substr($products, $upgradeProductStart);

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
	strpos($productList, "->where('p.hidden', 0)") !== false
		&& strpos($productList, "->where('g.hidden', 0)") !== false
		&& strpos($productList, "->where('fg.hidden', 0)") !== false
		&& strpos($productList, "->where('p.api_type', '<>', 'resource')") !== false,
	'public product list must expose only visible non-P3 products in visible groups'
);
assertPublicApiSecurity(
	strpos($productDetail, "->where('p.hidden', 0)") !== false
		&& strpos($productDetail, "->where('g.hidden', 0)") !== false
		&& strpos($productDetail, "->where('fg.hidden', 0)") !== false
		&& strpos($productDetail, "->where('p.api_type', '<>', 'resource')") !== false
		&& strpos($productDetail, "return json(['status' => 404, 'msg' => '产品不存在'])") !== false,
	'product detail must reject hidden, orphaned and P3 products'
);
$internalProductUnset = "unset(\$v['api_type'], \$v['upstream_version'], \$v['upstream_price_type'], \$v['upstream_price_value'])";
assertPublicApiSecurity(
	strpos($productList, $internalProductUnset) !== false
		&& strpos($productDetail, $internalProductUnset) !== false
		&& strpos($upgradeProducts, $internalProductUnset) !== false,
	'every customer product response must remove internal supplier and markup fields'
);
assertPublicApiSecurity(
	strpos($upgradeProducts, "->where('p.api_type', '<>', 'resource')") !== false
		&& strpos($upgradeProducts, "->where('fg.hidden', 0)") !== false
		&& strpos($upgradeProducts, 'resourceUserGradePercent') === false,
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

assertPublicApiSecurity(
	strpos($openapiLogin, 'private function verificationCodeMatches') !== false
		&& strpos($openapiLogin, 'Cache::has($key)') !== false
		&& strpos($openapiLogin, 'hash_equals((string) $cached_code, (string) $provided_code)') !== false,
	'OpenAPI registration and password reset must reject missing caches and compare verification codes strictly'
);
assertPublicApiSecurity(
	strpos($openapiLogin, 'if (configuration("allow_email_register_code"))') !== false
		&& strpos($openapiLogin, '$rules["code"] = "require"') !== false,
	'OpenAPI email registration must require a code when the configured email-code flow is enabled'
);
assertPublicApiSecurity(
	strpos($openapiLogin, 'configuration("allow_register_email_captcha")') !== false
		&& strpos($openapiLogin, 'where("email", $data["email"])') !== false,
	'OpenAPI email registration must use the email captcha setting and check duplicate email addresses'
);
assertPublicApiSecurity(
	strpos($openapiLogin, 'Cache::rm($verification_code_key)') !== false
		&& strpos($openapiLogin, '["uid" => $client["id"]') !== false,
	'OpenAPI verification codes must be consumed and password-reset hooks must receive the affected user id'
);
assertPublicApiSecurity(
	strpos($openapiPublic, 'phonenumber=\\"') === false
		&& strpos($openapiPublic, 'whereOr("email", $account)') !== false
		&& strpos($openapiPublic, 'hash_equals((string) $cached_code, (string) $data["code"])') !== false,
	'OpenAPI second verification must bind account lookups and compare cached codes strictly'
);
assertPublicApiSecurity(
	strpos($openapiAffiliate, "like '%{") === false
		&& strpos($openapiAffiliate, 'whereOr("i.subtotal", "like", $search_desc)') !== false
		&& strpos($openapiAffiliate, 'where("c.username", "like", "%" . $params["username"] . "%")') !== false,
	'OpenAPI affiliate searches must use bound query-builder conditions'
);
assertPublicApiSecurity(
	substr_count($openapiAffiliate, '$order_fields = [') === 2
		&& substr_count($openapiAffiliate, 'in_array($sort, ["asc", "desc"], true)') === 2,
	'OpenAPI affiliate sorting must use field and direction allowlists'
);
assertPublicApiSecurity(
	strpos($openapiAffiliate, '$row["email"] = $this->maskEmail') !== false
		&& strpos($openapiAffiliate, '$row["phonenumber"] = $this->maskPhone') !== false,
	'OpenAPI affiliate users must not expose full email addresses or phone numbers'
);
assertPublicApiSecurity(
	strpos($oauth, 'private function accessTokenCacheKey') !== false
		&& substr_count($oauth, '$this->storeAccessToken($token)') === 3
		&& strpos($legacyOauthView, '"oauth_access_token_" . strtolower($token)') !== false
		&& strpos($oauth, 'Cache::set("access_token"') === false
		&& strpos($legacyOauthView, 'Cache::set("access_token"') === false,
	'OAuth access tokens must use independent cache entries across all issuers'
);
assertPublicApiSecurity(
	strpos($oauth, 'private function authorizeTokenCacheKey') !== false
		&& strpos($oauth, 'hash_equals($key, $authorize_json_web_token)') !== false,
	'OAuth automatic authorization tokens must be isolated by login session and compared strictly'
);
assertPublicApiSecurity(
	strpos($homeRoutes, 'del_cwxt_home_login') === false
		&& strpos($homeIndex, 'function del_cwxt_home_login') === false,
	'public callers must not be able to clear arbitrary client login lockouts'
);
assertPublicApiSecurity(
	strpos($legacyAdmin, 'insertGetId($_POST)') === false
		&& strpos($legacyAdmin, '$insert = [') !== false
		&& strpos($legacyAdmin, 'in_array(1, $role_ids, true)') !== false
		&& strpos($legacyAdmin, '\\think\\Db::startTrans()') !== false,
	'legacy administrator creation must use an explicit field allowlist and authorize roles before its transaction'
);
assertPublicApiSecurity(
	strpos($legacyAdmin, 'preg_match("/^\\\\d{4}-\\\\d{2}-\\\\d{2}$/", $date)') !== false
		&& strpos($legacyAdmin, 'realpath(CMF_ROOT . "data/journal")') !== false
		&& strpos($legacyAdmin, 'strncmp($filename, $journal_prefix') !== false,
	'legacy administrator log viewing must enforce a canonical journal path and strict date format'
);
assertPublicApiSecurity(
	strpos($homeRoutes, 'resource_login_supplier') === false
		&& strpos($homeLogin, 'hash_equals($stored_password, $password)') === false
		&& strpos($homeLogin, '!empty($data["token"]) ? $data["token"] : $password') === false,
	'unused resource supplier maintenance login must not remain publicly reachable'
);

fwrite(STDOUT, "public API security regression checks passed" . PHP_EOL);
