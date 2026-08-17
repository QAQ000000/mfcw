<?php

namespace think {
	class Db
	{
		public static $queryTimes = 7;
		public static $executeTimes = 2;
	}

	class Container
	{
		public static $services = [];

		public static function get($name)
		{
			return self::$services[$name];
		}
	}
}

namespace {
	class PerformanceConsoleTestApp
	{
		public function getBeginTime()
		{
			return microtime(true) - 0.025;
		}
	}

	class PerformanceConsoleTestCacheDriver
	{
		public function getReadTimes()
		{
			return 3;
		}

		public function getWriteTimes()
		{
			return 1;
		}
	}

	class PerformanceConsoleTestCache
	{
		public function store()
		{
			return new PerformanceConsoleTestCacheDriver();
		}
	}

	class PerformanceConsoleTestResponse
	{
		public $headers;
		public $body;

		public function __construct($contentType, $body)
		{
			$this->headers = ["Content-Type" => $contentType];
			$this->body = $body;
		}

		public function header($name, $value = null)
		{
			$this->headers[$name] = $value;
			return $this;
		}

		public function getHeader($name)
		{
			return $this->headers[$name] ?? null;
		}

		public function getContent()
		{
			return $this->body;
		}

		public function content($content)
		{
			$this->body = $content;
			return $this;
		}
	}

	function assertPerformanceConsole($condition, $message)
	{
		if (!$condition) {
			fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
			exit(1);
		}
	}

	require dirname(__DIR__) . "/app/http/middleware/PerformanceConsole.php";
	\think\Container::$services = [
		"app" => new PerformanceConsoleTestApp(),
		"cache" => new PerformanceConsoleTestCache(),
	];
	$middleware = new \app\http\middleware\PerformanceConsole();
	$request = new \stdClass();

	$_SERVER["REMOTE_ADDR"] = "127.0.0.1";
	$htmlResponse = new PerformanceConsoleTestResponse("text/html; charset=utf-8", "<html><body>ok</body></html>");
	$result = $middleware->handle($request, function () use ($htmlResponse) {
		return $htmlResponse;
	});
	$serverTiming = $result->headers["Server-Timing"] ?? "";
	assertPerformanceConsole(strpos($serverTiming, "sql_read;dur=7") !== false, "SQL read count must be exported");
	assertPerformanceConsole(strpos($serverTiming, "sql_write;dur=2") !== false, "SQL write count must be exported");
	assertPerformanceConsole(strpos($serverTiming, "cache_read;dur=3") !== false, "cache read count must be exported");
	assertPerformanceConsole(strpos($serverTiming, "cache_write;dur=1") !== false, "cache write count must be exported");
	assertPerformanceConsole(strpos($result->body, "data-zjmf-performance-console") !== false, "HTML responses must install the console observer");
	assertPerformanceConsole(strpos($result->body, "data-zjmf-performance-console") < strpos($result->body, "</body>"), "the console observer must be injected before the closing body tag");

	$jsonResponse = new PerformanceConsoleTestResponse("application/json; charset=utf-8", '{"status":200}');
	$result = $middleware->handle($request, function () use ($jsonResponse) {
		return $jsonResponse;
	});
	assertPerformanceConsole(isset($result->headers["Server-Timing"]), "JSON responses must export timing for AJAX observation");
	assertPerformanceConsole($result->body === '{"status":200}', "non-HTML response bodies must not be changed");

	$_SERVER["REMOTE_ADDR"] = "203.0.113.10";
	$publicResponse = new PerformanceConsoleTestResponse("text/html; charset=utf-8", "<html><body>public</body></html>");
	$result = $middleware->handle($request, function () use ($publicResponse) {
		return $publicResponse;
	});
	assertPerformanceConsole(!isset($result->headers["Server-Timing"]), "public requests must remain disabled by default");
	assertPerformanceConsole(strpos($result->body, "data-zjmf-performance-console") === false, "public HTML must not expose the console observer");

	$source = file_get_contents(dirname(__DIR__) . "/app/http/middleware/PerformanceConsole.php");
	assertPerformanceConsole(strpos($source, "Db::listen") === false, "performance metrics must not add per-query listeners");
	echo "performance console regression checks passed" . PHP_EOL;
}
