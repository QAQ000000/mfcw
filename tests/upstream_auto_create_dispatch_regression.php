<?php

function assertUpstreamAutoCreate($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$invoices = file_get_contents(dirname(__DIR__) . "/app/common/logic/Invoices.php");

preg_match('/\$productid = .*?if \(\$host\["domainstatus"\] == "Suspended"\)/s', $invoices, $matches);
assertUpstreamAutoCreate(!empty($matches[0]), "the invoice auto-create branch must remain discoverable");
$dispatch = $matches[0];

assertUpstreamAutoCreate(
	strpos($dispatch, 'if ($host["api_type"] == "zjmf_api" || configuration("shd_allow_auto_create_queue"))') !== false,
	"upstream products must use the database queue even when the queue setting is disabled"
);
assertUpstreamAutoCreate(
	substr_count($dispatch, '\\app\\queue\\job\\AutoCreate::push(') === 1,
	"the payment branch must contain one auto-create queue dispatch"
);
assertUpstreamAutoCreate(
	substr_count($dispatch, '["url" => "async_create"') === 1,
	"HTTP dispatch must remain only for non-upstream products with the queue setting disabled"
);
assertUpstreamAutoCreate(
	strpos($dispatch, '$queue_result') === false && strpos($dispatch, 'catch (\\Throwable') === false,
	"upstream queue failures must not fall back to non-persistent HTTP dispatch"
);

echo "upstream auto-create dispatch regression checks passed" . PHP_EOL;
