<?php

function assertUploadChain($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function removeUploadChainDirectory($directory)
{
	if (!is_dir($directory)) {
		return;
	}
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ($iterator as $item) {
		$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
	}
	rmdir($directory);
}

$root = dirname(__DIR__);
define("APP_DEBUG", true);
define("CMF_ROOT", $root . DIRECTORY_SEPARATOR);
define("APP_PATH", CMF_ROOT . "app/");
define("CMF_DATA", CMF_ROOT . "data/");
define("WEB_ROOT", CMF_ROOT . "public/");
require CMF_ROOT . "vendor/thinkphp/base.php";
require_once APP_PATH . "common/validate/UploadValidate.php";
require_once APP_PATH . "common/logic/Upload.php";

$temporaryRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "zjmf-upload-chain-" . bin2hex(random_bytes(8));
$sourceDirectory = $temporaryRoot . DIRECTORY_SEPARATOR . "source";
$targetDirectory = $temporaryRoot . DIRECTORY_SEPARATOR . "target" . DIRECTORY_SEPARATOR;
mkdir($sourceDirectory, 0755, true);
mkdir($targetDirectory, 0755, true);

try {
	$makeFile = function ($name, $content) use ($sourceDirectory) {
		$path = $sourceDirectory . DIRECTORY_SEPARATOR . bin2hex(random_bytes(8));
		file_put_contents($path, $content);
		$file = new \think\File($path);
		return $file->isTest(true)->setUploadInfo([
			"name" => $name,
			"type" => "application/octet-stream",
			"size" => strlen($content),
			"error" => 0,
			"tmp_name" => $path,
		]);
	};

	$gifPayload = base64_decode("R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==")
		. base64_decode("PD9waHAgZWNobyAxOyA/Pg==");
	$jpegImage = imagecreatetruecolor(2, 3);
	imagefill($jpegImage, 0, 0, imagecolorallocate($jpegImage, 20, 40, 60));
	ob_start();
	imagejpeg($jpegImage, null, 90);
	$jpegContent = ob_get_clean();
	imagedestroy($jpegImage);
	$tiff = "II" . pack("v", 42) . pack("V", 8) . pack("v", 1)
		. pack("v", 0x0112) . pack("v", 3) . pack("V", 1) . pack("v", 6) . "\x00\x00" . pack("V", 0);
	$exifPayload = "Exif\x00\x00" . $tiff;
	$orientedJpeg = substr($jpegContent, 0, 2) . "\xFF\xE1" . pack("n", strlen($exifPayload) + 2) . $exifPayload . substr($jpegContent, 2);
	$upload = new \app\common\logic\Upload($targetDirectory);
	$results = [
		"uploadHandles1" => $upload->uploadHandles1($makeFile("shell.php", base64_decode("PD9waHAgZWNobyAxOyA/Pg==")), true),
		"activeSvg" => $upload->uploadHandles1($makeFile("notice.svg", '<svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"></svg>'), true),
		"activeShtml" => $upload->uploadHandles1($makeFile("notice.shtml", '<!--#exec cmd="id" -->'), true),
		"uploadHandles" => $upload->uploadHandles($makeFile("avatar.php.jpg", $gifPayload), true),
		"regularImage" => $upload->uploadHandles1($makeFile("notice.gif", $gifPayload), true),
		"regularArchive" => $upload->uploadHandles($makeFile("files.zip", "PK\x03\x04regular archive"), true),
		"uploadHandle" => $upload->uploadHandle($makeFile("payload.gif", $gifPayload), false),
		"uploadMultiHandle" => $upload->uploadMultiHandle([$makeFile("payload.gif", $gifPayload)]),
		"orientedJpeg" => $upload->uploadHandle($makeFile("phone.jpg", $orientedJpeg), false),
	];

	assertUploadChain($results["uploadHandles1"]["status"] !== 200, "uploadHandles1 must reject executable attachments");
	assertUploadChain($results["activeSvg"]["status"] !== 200, "uploadHandles1 must reject active SVG content");
	assertUploadChain($results["activeShtml"]["status"] !== 200, "uploadHandles1 must reject SSI-capable files");
	assertUploadChain($results["uploadHandles"]["status"] !== 200, "uploadHandles must reject dangerous compound names");
	assertUploadChain($results["regularImage"]["status"] === 200, "uploadHandles1 must keep common image uploads working");
	assertUploadChain($results["regularArchive"]["status"] === 200, "uploadHandles must keep regular archives working");
	foreach (["uploadHandle", "uploadMultiHandle"] as $method) {
		assertUploadChain($results[$method]["status"] === 200, $method . " must accept a valid GIF with a safe filename");
		$saveName = explode(",", $results[$method]["savename"])[0];
		$savedPath = $targetDirectory . $saveName;
		assertUploadChain(is_file($savedPath), $method . " must save the image");
		assertUploadChain(file_get_contents($savedPath) === $gifPayload, $method . " must not decode or rewrite image bytes");
	}
	assertUploadChain($results["orientedJpeg"]["status"] === 200, "JPEG files with EXIF orientation must remain supported");
	$orientedPath = $targetDirectory . $results["orientedJpeg"]["savename"];
	assertUploadChain(file_get_contents($orientedPath) === $orientedJpeg, "JPEG orientation metadata must remain byte-for-byte intact");
} finally {
	removeUploadChainDirectory($temporaryRoot);
}

fwrite(STDOUT, "upload security chain regression checks passed" . PHP_EOL);
