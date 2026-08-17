<?php

namespace app\http\middleware;

class PerformanceConsole
{
	const SCRIPT_MARKER = "data-zjmf-performance-console";

	public function handle($request, \Closure $next)
	{
		$response = $next($request);
		if (!$this->isEnabled() || !is_object($response) || !method_exists($response, "header")) {
			return $response;
		}

		$isHtml = false;
		$content = null;
		if (method_exists($response, "getHeader")) {
			$contentType = (string) $response->getHeader("Content-Type");
			$isHtml = stripos($contentType, "text/html") === 0;
		}
		if ($isHtml && method_exists($response, "getContent") && method_exists($response, "content")) {
			$content = $response->getContent();
		}

		$metrics = $this->collectMetrics();
		$response->header("Server-Timing", $this->formatServerTiming($metrics));
		if ($isHtml && is_string($content)) {
			$response->content($this->injectConsole($content));
		}

		return $response;
	}

	private function isEnabled()
	{
		if (defined("ZJMF_PERFORMANCE_CONSOLE")) {
			return ZJMF_PERFORMANCE_CONSOLE === true;
		}
		$remoteAddress = $_SERVER["REMOTE_ADDR"] ?? "";
		return $remoteAddress === "127.0.0.1" || $remoteAddress === "::1";
	}

	private function collectMetrics()
	{
		$beginTime = $_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true);
		try {
			$app = \think\Container::get("app");
			if (is_object($app) && method_exists($app, "getBeginTime")) {
				$beginTime = $app->getBeginTime();
			}
		} catch (\Throwable $e) {
		}

		$cacheReads = 0;
		$cacheWrites = 0;
		try {
			$cache = \think\Container::get("cache");
			if (is_object($cache) && method_exists($cache, "store")) {
				$cache = $cache->store();
			}
			if (is_object($cache)) {
				$cacheReads = method_exists($cache, "getReadTimes") ? intval($cache->getReadTimes()) : 0;
				$cacheWrites = method_exists($cache, "getWriteTimes") ? intval($cache->getWriteTimes()) : 0;
			}
		} catch (\Throwable $e) {
		}

		return [
			"app" => max(0, (microtime(true) - floatval($beginTime)) * 1000),
			"sql_read" => intval(\think\Db::$queryTimes),
			"sql_write" => intval(\think\Db::$executeTimes),
			"cache_read" => $cacheReads,
			"cache_write" => $cacheWrites,
		];
	}

	private function formatServerTiming($metrics)
	{
		return sprintf(
			'app;dur=%s;desc="Page generation",sql_read;dur=%d;desc="MySQL queries",sql_write;dur=%d;desc="MySQL writes",cache_read;dur=%d;desc="Cache reads",cache_write;dur=%d;desc="Cache writes"',
			number_format($metrics["app"], 3, ".", ""),
			$metrics["sql_read"],
			$metrics["sql_write"],
			$metrics["cache_read"],
			$metrics["cache_write"]
		);
	}

	private function injectConsole($content)
	{
		if (stripos($content, self::SCRIPT_MARKER) !== false) {
			return $content;
		}
		$script = <<<'HTML'
<script data-zjmf-performance-console>
(function () {
    "use strict";
    if (window.__zjmfPerformanceConsole) return;
    window.__zjmfPerformanceConsole = true;
    var labels = {
        app: "Page generation",
        sql_read: "MySQL queries",
        sql_write: "MySQL writes",
        cache_read: "Cache reads",
        cache_write: "Cache writes"
    };
    function printMetrics(entry) {
        if (!entry || !entry.serverTiming || !entry.serverTiming.length) return;
        var rows = [];
        entry.serverTiming.forEach(function (metric) {
            if (!labels[metric.name]) return;
            rows.push({
                Metric: labels[metric.name],
                Value: metric.name === "app" ? metric.duration.toFixed(3) + " ms" : Math.round(metric.duration)
            });
        });
        if (!rows.length) return;
        console.groupCollapsed("ZJMF Performance: " + entry.name);
        console.table(rows);
        console.groupEnd();
    }
    function printNavigation() {
        var entries = performance.getEntriesByType && performance.getEntriesByType("navigation");
        printMetrics(entries && entries[0]);
    }
    if (document.readyState === "complete") {
        setTimeout(printNavigation, 0);
    } else {
        window.addEventListener("load", printNavigation, { once: true });
    }
    if (window.PerformanceObserver) {
        var observer = new PerformanceObserver(function (list) {
            list.getEntries().forEach(printMetrics);
        });
        try {
            observer.observe({ type: "resource", buffered: true });
        } catch (error) {
            observer.observe({ entryTypes: ["resource"] });
        }
    }
})();
</script>
HTML;
		$bodyPosition = strripos($content, "</body>");
		if ($bodyPosition === false) {
			return $content . $script;
		}
		return substr($content, 0, $bodyPosition) . $script . substr($content, $bodyPosition);
	}
}
