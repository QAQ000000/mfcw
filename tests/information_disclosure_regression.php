<?php

function assertInformationDisclosureCondition($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function informationDisclosureMethodSource($relativePath, $method)
{
	$source = file_get_contents(dirname(__DIR__) . "/" . $relativePath);
	$pattern = '/(?:public|protected|private) function ' . preg_quote($method, '/') . '\\b.*?(?=\\r?\\n\\t(?:public|protected|private) function |\\r?\\n})/s';
	assertInformationDisclosureCondition((bool) preg_match($pattern, $source, $matches), $relativePath . "::" . $method . " must exist");
	return $matches[0];
}

class InformationDisclosureTestCommonController
{
}

class_alias("InformationDisclosureTestCommonController", "app\\home\\controller\\CommonController");
require dirname(__DIR__) . "/app/home/controller/ZjmfFinanceApiController.php";

$apiController = new \app\home\controller\ZjmfFinanceApiController();
$formatter = (new ReflectionClass($apiController))->getMethod("structureApiLogDescription");
$formatter->setAccessible(true);
$formatted = $formatter->invoke($apiController, '支付 <img src=x onerror=alert(1)> Host ID:3922 &amp; Order ID:7');
assertInformationDisclosureCondition(strpos($formatted["description"], "<") === false, "legacy API log descriptions must not contain executable markup");
assertInformationDisclosureCondition(count($formatted["description_parts"]) === 4, "API log references must retain surrounding text in order");
assertInformationDisclosureCondition(
	$formatted["description_parts"][1] === ["type" => "reference", "text" => "Host ID:3922", "resource" => "host", "id" => "3922"],
	"host references must use the structured allowlisted contract"
);
assertInformationDisclosureCondition(
	$formatted["description_parts"][3] === ["type" => "reference", "text" => "Order ID:7", "resource" => "order", "id" => "7"],
	"order references must use the structured allowlisted contract"
);

$hostList = informationDisclosureMethodSource("app/home/controller/HostController.php", "getList");
foreach (["b.area", "b.auth", 'area_name', 'area_code', '$data[$key]["auth"]'] as $leakedField) {
	assertInformationDisclosureCondition(strpos($hostList, $leakedField) === false, "host list must not expose " . $leakedField);
}
assertInformationDisclosureCondition(strpos($hostList, "get_all_dcim_area") === false, "host list must not expose the DCIM area dictionary");
assertInformationDisclosureCondition(strpos($hostList, '$result["data"]["area"]') === false, "host list must not return an area field");

$apiLog = informationDisclosureMethodSource("app/home/controller/ZjmfFinanceApiController.php", "apiLog");
assertInformationDisclosureCondition(strpos($apiLog, "structureApiLogDescription") !== false, "API logs must expose structured description parts");
assertInformationDisclosureCondition(strpos($apiLog, "<a ") === false, "API logs must not build anchor markup on the server");
assertInformationDisclosureCondition(strpos($apiLog, "<span") === false, "API logs must not build span markup on the server");

$descriptionFormatter = informationDisclosureMethodSource("app/home/controller/ZjmfFinanceApiController.php", "structureApiLogDescription");
assertInformationDisclosureCondition(strpos($descriptionFormatter, '"description_parts"') !== false, "the API log formatter must return structured parts");
assertInformationDisclosureCondition(strpos($descriptionFormatter, "htmlspecialchars") !== false, "the legacy API log description must remain safe for HTML-rendering clients");
foreach (["invoice", "user", "host", "order", "ticket", "transaction"] as $resource) {
	assertInformationDisclosureCondition(strpos($descriptionFormatter, '"' . $resource . '"') !== false, "the API log formatter must allowlist " . $resource . " references");
}

$cloudCurl = informationDisclosureMethodSource("app/common/logic/DcimCloud.php", "curl");
assertInformationDisclosureCondition(substr_count($cloudCurl, "supplierFailureForClient") >= 3, "DCIM Cloud transport failures must use one safe response path");
assertInformationDisclosureCondition(strpos($cloudCurl, '$this->lastHttpCode') !== false, "DCIM Cloud HTTP status codes must stay inside the logic layer");

$cloudFailure = informationDisclosureMethodSource("app/common/logic/DcimCloud.php", "supplierFailureForClient");
assertInformationDisclosureCondition(strpos($cloudFailure, "操作失败，请稍后重试或联系管理员") !== false, "DCIM Cloud customers must receive a fixed local error");
assertInformationDisclosureCondition(strpos($cloudFailure, '"http_code"') === false, "DCIM Cloud customer failures must not expose HTTP status details");

$cloudLog = informationDisclosureMethodSource("app/common/logic/DcimCloud.php", "recordSupplierDiagnostic");
assertInformationDisclosureCondition(strpos($cloudLog, '\\think\\facade\\Log::record') !== false, "raw DCIM Cloud failures must be written to the internal runtime log");
assertInformationDisclosureCondition(strpos($cloudLog, "sanitizeSupplierDiagnostic") !== false, "DCIM Cloud diagnostics must be sanitized before logging");

fwrite(STDOUT, "information disclosure regression checks passed" . PHP_EOL);
