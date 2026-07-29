<?php

namespace app\common\cache;

class AtomicFile extends \think\cache\driver\File
{
	const TEMP_PREFIX = ".zjmf-cache-";
	const WRITE_CHUNK_SIZE = 1048576;

	public function set($name, $value, $expire = null)
	{
		$this->writeTimes++;

		if (is_null($expire)) {
			$expire = $this->options["expire"];
		}

		$expire = $this->getExpireTime($expire);
		$filename = $this->getCacheKey($name, true);
		$first = $this->tag && !is_file($filename);
		$data = $this->serialize($value);

		if ($this->options["data_compress"] && function_exists("gzcompress")) {
			$data = gzcompress($data, 3);
			if ($data === false) {
				return false;
			}
		}

		$data = "<?php\n//" . sprintf("%012d", $expire) . "\n exit();?>\n" . $data;
		$directory = dirname($filename);
		$this->tightenDirectoryPermissions($directory);
		$tempFile = $this->createTemporaryFile($directory);
		if (!is_string($tempFile) || $tempFile === "" || !$this->isSameDirectory($tempFile, $directory)) {
			if (is_string($tempFile) && is_file($tempFile)) {
				@unlink($tempFile);
			}
			return false;
		}

		try {
			$handle = @fopen($tempFile, "wb");
			if (!is_resource($handle)) {
				return false;
			}

			$writeSucceeded = false;
			try {
				$writeSucceeded = $this->writeAll($handle, $data) && $this->flushAndSync($handle);
			} catch (\Throwable $e) {
				$writeSucceeded = false;
			} finally {
				@fclose($handle);
			}

			if (!$writeSucceeded || !$this->applyTemporaryFileMetadata($tempFile, $filename)) {
				return false;
			}
			if (!$this->replaceFile($tempFile, $filename)) {
				return false;
			}

			$tempFile = null;
			clearstatcache(true, $filename);
			if ($first) {
				$this->setTagItem($filename);
			}
			return true;
		} finally {
			if (is_string($tempFile) && is_file($tempFile)) {
				@unlink($tempFile);
			}
		}
	}

	protected function createTemporaryFile($directory)
	{
		return @tempnam($directory, self::TEMP_PREFIX);
	}

	protected function replaceFile($source, $destination)
	{
		return @rename($source, $destination);
	}

	private function writeAll($handle, $data)
	{
		$length = strlen($data);
		$offset = 0;
		while ($offset < $length) {
			$chunk = substr($data, $offset, self::WRITE_CHUNK_SIZE);
			$written = @fwrite($handle, $chunk);
			if ($written === false || $written === 0) {
				return false;
			}
			$offset += $written;
		}
		return true;
	}

	private function flushAndSync($handle)
	{
		if (!@fflush($handle)) {
			return false;
		}
		if (function_exists("fsync") && !@fsync($handle)) {
			return false;
		}
		return true;
	}

	private function applyTemporaryFileMetadata($tempFile, $destination)
	{
		$stat = @stat($destination);
		if (is_array($stat)) {
			if (function_exists("chown")) {
				@chown($tempFile, $stat["uid"]);
			}
			if (function_exists("chgrp")) {
				@chgrp($tempFile, $stat["gid"]);
			}
		}
		return @chmod($tempFile, $this->resolveFileMode($stat));
	}

	private function resolveFileMode($stat)
	{
		if (!is_array($stat) || !isset($stat["mode"])) {
			return 0640;
		}
		return 0600 | ($stat["mode"] & 0060);
	}

	private function tightenDirectoryPermissions($directory)
	{
		$permissions = @fileperms($directory);
		if ($permissions === false) {
			return false;
		}
		$mode = ($permissions & 0050) === 0050 ? 0750 : 0700;
		return @chmod($directory, $mode);
	}

	private function isSameDirectory($path, $directory)
	{
		$pathDirectory = realpath(dirname($path));
		$targetDirectory = realpath($directory);
		return $pathDirectory !== false && $targetDirectory !== false && $pathDirectory === $targetDirectory;
	}
}
