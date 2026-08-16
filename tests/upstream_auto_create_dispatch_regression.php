<?php

namespace think {
	class Queue
	{
		public static $result;
		public static $arguments;
		public static $laterCalls = [];

		public static function push($job, $data, $queue)
		{
			self::$arguments = [$job, $data, $queue];
			return self::$result;
		}

		public static function later($timer, $job, $data, $queue)
		{
			self::$laterCalls[] = [$timer, $job, $data, $queue];
		}
	}
}

namespace think\queue {
	class Job
	{
		public $attempt = 1;
		public $deleted = false;
		public $released = false;
		public $releaseDelay;

		public function attempts()
		{
			return $this->attempt;
		}

		public function delete()
		{
			$this->deleted = true;
		}

		public function release($delay = 0)
		{
			$this->released = true;
			$this->releaseDelay = $delay;
		}
	}
}

namespace think\facade {
	class Log
	{
		public static $records = [];
		public static $throw = false;

		public static function record($message, $level = "info")
		{
			if (self::$throw) {
				throw new \RuntimeException("simulated logging failure");
			}
			self::$records[] = [$message, $level];
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
	require dirname(__DIR__) . "/app/queue/job/AutoCreate.php";
}

namespace app\queue\job {
	class QueueResultProbe extends \app\queue\common\JobCommon
	{
	}

	class AutoCreateProbe extends AutoCreate
	{
		public $fail = false;

		public function handle($data)
		{
			if ($this->fail) {
				throw new \RuntimeException("simulated upstream failure");
			}
		}
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

	preg_match('/\$productid = .*?if \(\$host\["domainstatus"\] == "Suspended"\)/s', $invoices, $matches);
	assertUpstreamAutoCreate(!empty($matches[0]), "the invoice auto-create branch must remain discoverable");
	$dispatch = $matches[0];
	assertUpstreamAutoCreate(strpos($dispatch, 'if ($host["api_type"] == "zjmf_api")') !== false, "upstream products must use the reliable dispatch branch");
	assertUpstreamAutoCreate(strpos($dispatch, 'try {') !== false && strpos($dispatch, 'catch (\\Throwable $e)') !== false, "queue exceptions must fall back without breaking payment handling");
	assertUpstreamAutoCreate(strpos($dispatch, 'if ($queue_result === false)') !== false, "only an explicit queue failure may trigger HTTP fallback");
	assertUpstreamAutoCreate(strpos($dispatch, '} elseif (configuration("shd_allow_auto_create_queue")) {') !== false, "non-upstream products must preserve the configured queue behavior");
	assertUpstreamAutoCreate(substr_count($dispatch, '["url" => "async_create", "data" => $auto_create_data]') === 2, "HTTP dispatch must remain available for fallback and legacy products");

	$successfulJob = new \think\queue\Job();
	$probe = new \app\queue\job\AutoCreateProbe();
	$probe->fire($successfulJob, ["hid" => 3922]);
	assertUpstreamAutoCreate($successfulJob->deleted === true, "a successful auto-create job must be deleted after handling");
	assertUpstreamAutoCreate($successfulJob->released === false, "a successful auto-create job must not be released");

	$probe->fail = true;
	$retryJob = new \think\queue\Job();
	$probe->fire($retryJob, ["hid" => 3923]);
	assertUpstreamAutoCreate($retryJob->deleted === false, "a retryable auto-create failure must retain the current job");
	assertUpstreamAutoCreate($retryJob->released === true && $retryJob->releaseDelay === 10, "a retryable auto-create failure must release the current job for ten seconds");
	\think\facade\Log::$throw = true;
	$loggingFailureJob = new \think\queue\Job();
	$probe->fire($loggingFailureJob, ["hid" => 3924]);
	assertUpstreamAutoCreate($loggingFailureJob->released === true && $loggingFailureJob->releaseDelay === 10, "logging failures must not prevent auto-create retries");
	\think\facade\Log::$throw = false;

	$finalJob = new \think\queue\Job();
	$finalJob->attempt = 3;
	$probe->fire($finalJob, ["hid" => 3925]);
	assertUpstreamAutoCreate($finalJob->deleted === true, "an auto-create job must be deleted after the third failed attempt");
	assertUpstreamAutoCreate($finalJob->released === false, "a terminal auto-create failure must not be released again");
	assertUpstreamAutoCreate(count(\think\facade\Log::$records) === 2, "each auto-create exception must be logged");
	assertUpstreamAutoCreate(\think\Queue::$laterCalls === [], "auto-create retries must not enqueue fresh jobs with reset attempt counts");

	echo "upstream auto-create dispatch regression checks passed" . PHP_EOL;
}
