<?php

$testRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "zjmf-atomic-cache-test-" . getmypid() . "-" . bin2hex(random_bytes(4));
define("CMF_DATA", $testRoot . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR);

require dirname(__DIR__) . "/vendor/thinkphp/library/think/cache/Driver.php";
require dirname(__DIR__) . "/vendor/thinkphp/library/think/cache/driver/File.php";
require dirname(__DIR__) . "/app/common/cache/AtomicFile.php";

class InspectableAtomicFile extends \app\common\cache\AtomicFile
{
	public $temporaryFiles = [];
	public $failReplacement = false;

	protected function createTemporaryFile($directory)
	{
		$path = parent::createTemporaryFile($directory);
		$this->temporaryFiles[] = $path;
		return $path;
	}

	protected function replaceFile($source, $destination)
	{
		if ($this->failReplacement) {
			return false;
		}
		return parent::replaceFile($source, $destination);
	}
}

function assertTrue($condition, $message)
{
	if (!$condition) {
		throw new RuntimeException($message);
	}
}

function removeTestTree($directory)
{
	if (!is_dir($directory)) {
		return;
	}
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ($iterator as $item) {
		if ($item->isDir()) {
			@rmdir($item->getPathname());
		} else {
			@unlink($item->getPathname());
		}
	}
	@rmdir($directory);
}

$isForkedChild = false;
try {
	$cacheDirectory = $testRoot . DIRECTORY_SEPARATOR . "cache";
	assertTrue(mkdir($cacheDirectory, 0777, true), "test cache directory must be created");
	assertTrue(chmod($cacheDirectory, 0777), "test cache directory must begin world-writable");
	$cache = new InspectableAtomicFile(["path" => $cacheDirectory, "cache_subdir" => false]);
	$key = "large-catalog";
	$filename = $cacheDirectory . DIRECTORY_SEPARATOR . md5($key) . ".php";
	$firstValue = str_repeat("catalog-A-", 220000);
	$secondValue = str_repeat("catalog-B-", 220000);

	assertTrue($cache->set($key, $firstValue) === true, "large cache value must be written");
	assertTrue($cache->get($key) === $firstValue, "large cache value must round-trip without truncation");
	assertTrue(($permissions = fileperms($filename)) !== false && ($permissions & 0777) === 0640, "new cache files must default to 0640");
	assertTrue((fileperms($cacheDirectory) & 0777) === 0750, "cache directories must remove world access");

	assertTrue(chmod($filename, 0600), "test cache file permissions must be adjustable");
	assertTrue($cache->set($key, $secondValue) === true, "existing cache value must be atomically replaced");
	assertTrue($cache->get($key) === $secondValue, "replacement cache value must round-trip");
	assertTrue((fileperms($filename) & 0777) === 0600, "replacement must preserve stricter owner-only permissions");
	assertTrue(count($cache->temporaryFiles) === 2, "each write must allocate its own temporary file");
	assertTrue($cache->temporaryFiles[0] !== $cache->temporaryFiles[1], "temporary file names must be unique");
	foreach ($cache->temporaryFiles as $temporaryFile) {
		assertTrue(dirname($temporaryFile) === $cacheDirectory, "temporary files must be created beside the destination");
		assertTrue(strpos(basename($temporaryFile), \app\common\cache\AtomicFile::TEMP_PREFIX) === 0, "temporary files must use the cache prefix");
		assertTrue(!file_exists($temporaryFile), "successful writes must not leave temporary files behind");
	}

	$cache->failReplacement = true;
	assertTrue($cache->set($key, "must-not-publish") === false, "a failed atomic replacement must be reported");
	$failedTemporaryFile = end($cache->temporaryFiles);
	assertTrue(!file_exists($failedTemporaryFile), "failed replacements must remove their temporary files");
	assertTrue($cache->get($key) === $secondValue, "a failed replacement must preserve the previous cache value");

	if (function_exists("pcntl_fork") && function_exists("pcntl_waitpid")) {
		$cache->failReplacement = false;
		$childPid = pcntl_fork();
		assertTrue($childPid !== -1, "the concurrent cache writer must fork");
		if ($childPid === 0) {
			$isForkedChild = true;
			$childCache = new \app\common\cache\AtomicFile(["path" => $cacheDirectory, "cache_subdir" => false]);
			for ($iteration = 0; $iteration < 20; $iteration++) {
				$value = $iteration % 2 === 0 ? $firstValue : $secondValue;
				if ($childCache->set($key, $value) !== true) {
					exit(2);
				}
			}
			exit(0);
		}

		$childStatus = 0;
		$waitResult = 0;
		do {
			$observed = $cache->get($key);
			assertTrue($observed === $firstValue || $observed === $secondValue, "concurrent readers must only observe complete cache values");
			$waitResult = pcntl_waitpid($childPid, $childStatus, WNOHANG);
		} while ($waitResult === 0);
		assertTrue($waitResult === $childPid && pcntl_wifexited($childStatus) && pcntl_wexitstatus($childStatus) === 0, "the concurrent cache writer must complete successfully");
		assertTrue(glob($cacheDirectory . DIRECTORY_SEPARATOR . \app\common\cache\AtomicFile::TEMP_PREFIX . "*") === [], "concurrent writes must not leave temporary files behind");
	}

	$config = require dirname(__DIR__) . "/app/config/cache.php";
	$driverClass = "app\\common\\cache\\AtomicFile";
	assertTrue($config["default"]["type"] === $driverClass, "the default cache store must use AtomicFile");
	assertTrue($config["file"]["type"] === $driverClass, "the named file cache store must use AtomicFile");
	assertTrue($config["default"]["path"] === CMF_DATA . "runtime/cahce/", "the cache path must remain anchored to CMF_DATA");

	fwrite(STDOUT, "atomic file cache regression checks passed" . PHP_EOL);
} finally {
	if (!$isForkedChild) {
		removeTestTree($testRoot);
	}
}
