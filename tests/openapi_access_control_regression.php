<?php

function assertOpenApiAccessControl($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function methodSource($source, $method)
{
	$pattern = '/public function ' . preg_quote($method, '/') . '\\b.*?(?=\n\tpublic function |\n})/s';
	assertOpenApiAccessControl((bool) preg_match($pattern, $source, $matches), $method . " must exist");
	return $matches[0];
}

$root = dirname(__DIR__);
$host = file_get_contents($root . "/app/openapi/controller/HostController.php");
$product = file_get_contents($root . "/app/openapi/controller/ProductController.php");
$apiCheck = file_get_contents($root . "/app/http/middleware/ApiCheck.php");
$host = str_replace("\r\n", "\n", $host);
$product = str_replace("\r\n", "\n", $product);
$apiCheck = str_replace("\r\n", "\n", $apiCheck);

foreach ([$host, $product] as $source) {
	$renewPage = methodSource($source, "renewPage");
	assertOpenApiAccessControl(strpos($renewPage, 'where("a.uid", intval($this->request->uid))') !== false, "renew page must be scoped to the authenticated owner");

	$renew = methodSource($source, "renew");
	assertOpenApiAccessControl(strpos($renew, 'where("id", $hid)->where("uid", $uid)') !== false, "renew must reject another user's host");
	assertOpenApiAccessControl(strpos($renew, 'THE_PRODUCT_WAS_NOT_FOUND') !== false, "renew must return an ownership error");

	$renewAuto = methodSource($source, "renewAuto");
	assertOpenApiAccessControl(strpos($renewAuto, 'where("id", $hid)->where("uid", $uid)') !== false, "auto-renew must scope both the read and write to the owner");

	$renewBatch = methodSource($source, "renewBatch");
	assertOpenApiAccessControl(strpos($renewBatch, 'where("uid", $uid)->whereIn("id", $check_ids)') !== false, "batch renew must validate every host owner");
}

$reinstall = methodSource($host, "getReinstall");
assertOpenApiAccessControl(strpos($reinstall, 'where("id", $host_id)->where("uid", intval($this->request->uid))') !== false, "reinstall options must be scoped to the authenticated owner");
assertOpenApiAccessControl(strpos($reinstall, 'if (empty($host_data))') !== false, "reinstall options must reject an unknown or foreign host");

assertOpenApiAccessControl(strpos($apiCheck, 'base64_decode($token, true)') !== false, "API credentials must use strict Base64 decoding");
assertOpenApiAccessControl(strpos($apiCheck, 'empty($ip) || !in_array($client_ip, $ip, true)') !== false, "API IP allowlists must reject empty lists and use strict comparison");
assertOpenApiAccessControl(strpos($apiCheck, '$header["authorization"] ?? ""') !== false, "missing Authorization headers must be handled without notices");

fwrite(STDOUT, "OpenAPI access-control regression checks passed" . PHP_EOL);
