<?php

namespace think {
	class Queue
	{
		public static $result;
		public static $arguments;

		public static function push($job, $data, $queue)
		{
			self::$arguments = [$job, $data, $queue];
			return self::$result;
		}
	}
}

namespace {
	function getDomain()
	{
		return "https://example.test";
	}

	function getRootUrl()
	{
		return "/admin";
	}

	function assertUpstreamAutoCreate($condition, $message)
	{
		if (!$condition) {
			fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
			exit(1);
		}
	}

	require dirname(__DIR__) . "/app/queue/common/JobCommon.php";
}

namespace app\queue\job {
	class QueueResultProbe extends \app\queue\common\JobCommon
	{
	}
}

namespace {

	\think\Queue::$result = 23;
	$result = \app\queue\job\QueueResultProbe::push(["hid" => 3922]);
	assertUpstreamAutoCreate($result === 23, "queue job IDs must be returned to the caller");
	assertUpstreamAutoCreate(\think\Queue::$arguments[1]["hid"] === 3922, "the host ID must be preserved");
	assertUpstreamAutoCreate(\think\Queue::$arguments[1]["queue_req"] === ["domain" => "https://example.test", "rootUrl" => "/admin"], "queue request context must still be attached");

	\think\Queue::$result = 0;
	assertUpstreamAutoCreate(\app\queue\job\QueueResultProbe::push(["hid" => 3923]) === 0, "a synchronous queue success result of zero must be preserved");
	\think\Queue::$result = false;
	assertUpstreamAutoCreate(\app\queue\job\QueueResultProbe::push(["hid" => 3924]) === false, "an explicit queue failure must be preserved");

	$root = dirname(__DIR__);
	$invoices = file_get_contents($root . "/app/common/logic/Invoices.php");
	$autoCreate = file_get_contents($root . "/app/queue/job/AutoCreate.php");

	preg_match('/\$productid = .*?if \(\$host\["domainstatus"\] == "Suspended"\)/s', $invoices, $matches);
	assertUpstreamAutoCreate(!empty($matches[0]), "the invoice auto-create branch must remain discoverable");
	$dispatch = $matches[0];
	assertUpstreamAutoCreate(strpos($dispatch, 'if ($host["api_type"] == "zjmf_api")') !== false, "upstream products must use the reliable dispatch branch");
	assertUpstreamAutoCreate(strpos($dispatch, 'try {') !== false && strpos($dispatch, 'catch (\\Throwable $e)') !== false, "queue exceptions must fall back without breaking payment handling");
	assertUpstreamAutoCreate(strpos($dispatch, 'if ($queue_result === false)') !== false, "only an explicit queue failure may trigger HTTP fallback");
	assertUpstreamAutoCreate(strpos($dispatch, '} elseif (configuration("shd_allow_auto_create_queue")) {') !== false, "non-upstream products must preserve the configured queue behavior");
	assertUpstreamAutoCreate(substr_count($dispatch, '["url" => "async_create", "data" => $auto_create_data]') === 2, "HTTP dispatch must remain available for fallback and legacy products");
	assertUpstreamAutoCreate(strpos($autoCreate, 'self::later($data, 10);') !== false, "auto-create failures must retry with the correct argument order");
	assertUpstreamAutoCreate(strpos($autoCreate, 'self::later(10, $data);') === false, "the invalid retry argument order must not return");

	echo "upstream auto-create dispatch regression checks passed" . PHP_EOL;
}
