<?php

function assertSecurityHardening($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function securityMethodSource($source, $method)
{
	$pattern = '/(?:public|protected|private) function ' . preg_quote($method, '/') . '\\b.*?(?=\\n\\t(?:public|protected|private) function |\\n})/s';
	assertSecurityHardening((bool) preg_match($pattern, $source, $matches), $method . " must exist");
	return $matches[0];
}

$root = dirname(__DIR__);
$pay = file_get_contents($root . "/app/home/controller/PayController.php");
$userInvoice = file_get_contents($root . "/app/home/controller/UserInvoiceController.php");
$openapiInvoices = file_get_contents($root . "/app/openapi/controller/InvoicesController.php");
$upload = file_get_contents($root . "/app/common/logic/Upload.php");
$emailTemplateValidate = file_get_contents($root . "/app/admin/validate/EmailTemplateValidate.php");
$download = file_get_contents($root . "/app/common/logic/Download.php");
$common = file_get_contents($root . "/app/common.php");
$homeMessages = file_get_contents($root . "/app/home/controller/SystemMessageController.php");
$openapiMessages = file_get_contents($root . "/app/openapi/controller/MessageController.php");
$check = file_get_contents($root . "/app/http/middleware/Check.php");
$homeHost = file_get_contents($root . "/app/home/controller/HostController.php");
$openapiHost = file_get_contents($root . "/app/openapi/controller/HostController.php");
$customerAnnex = file_get_contents($root . "/public/admin/js/CustomerAnnex~31ecd969.97a1785b.js");

foreach ([$pay, $userInvoice, $openapiInvoices] as $source) {
	assertSecurityHardening(strpos($source, 'whereRaw($where)') === false, "keyword searches must not use concatenated whereRaw clauses");
}
assertSecurityHardening(substr_count($pay, 'where($keyword_where)') >= 2, "fund count and list queries must share the bound keyword filter");
assertSecurityHardening(substr_count($openapiInvoices, 'where($keyword_where)') >= 2, "OpenAPI fund count and list queries must share the bound keyword filter");

$changePaymt = securityMethodSource($pay, "changePaymt");
assertSecurityHardening(strpos($changePaymt, '$request->uid') !== false, "changePaymt must use the authenticated uid");
assertSecurityHardening(strpos($changePaymt, 'where("uid", $uid)') !== false, "changePaymt must scope invoice writes by uid");
assertSecurityHardening(strpos($changePaymt, '["0", "1"]') !== false, "changePaymt must restrict the payment flag domain");

$useCreditPage = securityMethodSource($pay, "useCreditPage");
assertSecurityHardening(strpos($useCreditPage, 'where("uid", $uid)') !== false, "useCreditPage must scope invoice reads by uid");

$deleteOrder = securityMethodSource($userInvoice, "deleteOrder");
assertSecurityHardening(substr_count($deleteOrder, 'where("uid", $uid)') >= 4, "deleteOrder must scope invoices, orders, and hosts by uid");
assertSecurityHardening(strpos($deleteOrder, 'where("a.uid", $uid)') !== false && strpos($deleteOrder, 'where("b.uid", $uid)') !== false, "deleteOrder host lookup must enforce ownership on both joined tables");

$moveTo = securityMethodSource($upload, "moveTo");
assertSecurityHardening(substr_count($moveTo, 'realpath(') >= 3, "moveTo must canonicalize source and destination directories");
assertSecurityHardening(strpos($moveTo, 'basename($file) !== $file') !== false, "moveTo must reject path components");
assertSecurityHardening(strpos($moveTo, 'is_link($filepath)') !== false, "moveTo must reject temporary symlinks");

assertSecurityHardening(strpos($download, 'function resolveSupportFile') !== false, "downloads must use a shared support-file resolver");
assertSecurityHardening(strpos($download, 'strncmp($path, $prefix') !== false, "download resolver must enforce the canonical directory prefix");
foreach ([
	"app/home/controller/DownController.php",
	"app/openapi/controller/DownloadsController.php",
	"app/openapi/controller/HostController.php",
	"app/admin/controller/DownloadsController.php",
] as $relativePath) {
	$source = file_get_contents($root . "/" . $relativePath);
	assertSecurityHardening(strpos($source, 'Download::resolveSupportFile($filename)') !== false, $relativePath . " must use the safe download resolver");
}

$tempRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "zjmf-security-" . bin2hex(random_bytes(8));
$uploadSource = $tempRoot . DIRECTORY_SEPARATOR . "upload";
$uploadTarget = $tempRoot . DIRECTORY_SEPARATOR . "target";
$downloadRoot = $tempRoot . DIRECTORY_SEPARATOR . "downloads";
$supportRoot = $downloadRoot . DIRECTORY_SEPARATOR . "support";
mkdir($uploadSource, 0755, true);
mkdir($uploadTarget, 0755, true);
mkdir($supportRoot, 0755, true);
define("UPLOAD_DEFAULT", $uploadSource . DIRECTORY_SEPARATOR);
define("UPLOAD_PATH_DWN", $downloadRoot . DIRECTORY_SEPARATOR);
require_once $root . "/app/common/logic/Upload.php";
require_once $root . "/app/common/logic/Download.php";

$temporaryName = str_repeat("a", 32) . "1780000000.jpg";
file_put_contents($uploadSource . DIRECTORY_SEPARATOR . $temporaryName, "image-data");
$uploadLogic = new \app\common\logic\Upload($uploadSource);
$contentCheck = new ReflectionMethod($uploadLogic, "isUploadContentSafe");
$contentCheck->setAccessible(true);
$cleanGif = base64_decode("R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==");
$cleanGifPath = $tempRoot . DIRECTORY_SEPARATOR . "clean.gif";
$phpGifPath = $tempRoot . DIRECTORY_SEPARATOR . "php.gif";
$textPath = $tempRoot . DIRECTORY_SEPARATOR . "plain.txt";
$htmlPath = $tempRoot . DIRECTORY_SEPARATOR . "html.txt";
$svgPath = $tempRoot . DIRECTORY_SEPARATOR . "active.svg";
$xmlPath = $tempRoot . DIRECTORY_SEPARATOR . "active.xml";
$archivePath = $tempRoot . DIRECTORY_SEPARATOR . "archive.zip";
file_put_contents($cleanGifPath, $cleanGif);
file_put_contents($phpGifPath, $cleanGif . "<?php system(\$_GET['cmd']); ?>");
file_put_contents($textPath, "plain attachment");
file_put_contents($htmlPath, "<script>alert('xss')</script>");
file_put_contents($svgPath, '<svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"></svg>');
file_put_contents($xmlPath, '<?xml version="1.0"?><root/>');
file_put_contents($archivePath, "PK\x03\x04regular archive fixture");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $cleanGifPath, "image/gif", false, "clean.gif") === true, "clean GIF uploads must remain supported");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $phpGifPath, "image/gif", false, "payload.gif") === true, "safe image names must not be rejected because of compressed or trailing bytes");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $phpGifPath, "image/gif", false, "avatar.php.jpg") === false, "dangerous compound image names must be rejected");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $textPath, "text/plain", true, "shell.php") === false, "script attachment names must be rejected");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $textPath, "text/plain", true, "notes.txt") === true, "plain text attachments must remain supported");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $archivePath, "application/zip", true, "files.zip") === true, "regular archive attachments must remain supported");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $htmlPath, "text/html", true, "page.txt") === false, "HTML-like attachments must be rejected");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $svgPath, "application/octet-stream", true, "notice.svg") === false, "active SVG attachments must be rejected even with a generic reported MIME");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $textPath, "application/octet-stream", true, "notice.shtml") === false, "SSI-capable attachment names must be rejected");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $xmlPath, "application/octet-stream", true, "notice.xml") === false, "browser-active XML attachments must be rejected");
assertSecurityHardening($contentCheck->invoke($uploadLogic, $textPath, "application/octet-stream", true, "notice.js") === false, "JavaScript attachment names must be rejected");

$coincidentalMarkerImage = null;
$imageFiles = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . "/public", FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $imageFile) {
	$extension = strtolower($imageFile->getExtension());
	if (!in_array($extension, ["gif", "jpg", "jpeg", "png"], true)) {
		continue;
	}
	if (@getimagesize($imageFile->getPathname()) === false) {
		continue;
	}
	$imageFiles[] = $imageFile->getPathname();
	$mime = function_exists("mime_content_type") ? mime_content_type($imageFile->getPathname()) : "image/" . $extension;
	assertSecurityHardening($contentCheck->invoke($uploadLogic, $imageFile->getPathname(), $mime, false, $imageFile->getFilename()) === true, "repository image must remain accepted: " . $imageFile->getPathname());
	if ($coincidentalMarkerImage === null && strpos(file_get_contents($imageFile->getPathname()), "<?") !== false) {
		$coincidentalMarkerImage = $imageFile->getPathname();
	}
}
assertSecurityHardening(count($imageFiles) > 600, "all structurally recognized images in the public corpus must be covered");
assertSecurityHardening($coincidentalMarkerImage !== null, "the corpus must include a valid image with coincidental script-marker bytes");
assertSecurityHardening(strpos($emailTemplateValidate, "text/html") === false, "attachment MIME rules must not allow inline HTML");
assertSecurityHardening(strpos($customerAnnex, 'accept:"image/jpeg,image/png,image/gif"') !== false, "customer attachment picker must only advertise supported image formats");
assertSecurityHardening(strpos($customerAnnex, 'e.$lang.allow_suffixes') !== false, "customer attachment dialog must display the allowed image suffixes");

foreach (["uploadHandle", "uploadHandles1", "uploadHandles", "uploadMultiHandle"] as $uploadMethod) {
	$methodSource = securityMethodSource($upload, $uploadMethod);
	assertSecurityHardening(strpos($methodSource, "isUploadContentSafe") !== false, $uploadMethod . " must run shared pre-storage validation");
}
assertSecurityHardening(strpos($upload, "sanitizeStoredImage") === false, "uploads must not decode and rewrite images after storage");
assertSecurityHardening(strpos($upload, "imagecreatefrom") === false && strpos($upload, "\\think\\image\\gif\\Decoder") === false, "upload validation must not allocate decoded image buffers");
$legacyDownloadUpload = securityMethodSource($download, "upload");
assertSecurityHardening(strpos($legacyDownloadUpload, "Upload::isUploadContentSafe") !== false, "legacy product downloads must use shared pre-storage validation");
$moveResult = $uploadLogic->moveTo($temporaryName, $uploadTarget);
assertSecurityHardening($moveResult === $temporaryName, "a generated temporary upload name must remain usable");
assertSecurityHardening(is_file($uploadTarget . DIRECTORY_SEPARATOR . $temporaryName), "a valid temporary upload must move into the target directory");
assertSecurityHardening($uploadLogic->moveTo($temporaryName, $uploadTarget) === $temporaryName, "a previously moved upload must remain idempotent");
assertSecurityHardening(isset($uploadLogic->moveTo("../outside.txt", $uploadTarget)["error"]), "upload traversal must be rejected");

$supportName = "manual.pdf";
file_put_contents($supportRoot . DIRECTORY_SEPARATOR . $supportName, "pdf-data");
assertSecurityHardening(\app\common\logic\Download::resolveSupportFile($supportName) === realpath($supportRoot . DIRECTORY_SEPARATOR . $supportName), "a regular support file must resolve");
$outsideFile = $tempRoot . DIRECTORY_SEPARATOR . "outside.txt";
file_put_contents($outsideFile, "secret");
$linkPath = $supportRoot . DIRECTORY_SEPARATOR . "outside-link.txt";
if (function_exists("symlink") && @symlink($outsideFile, $linkPath)) {
	assertSecurityHardening(\app\common\logic\Download::resolveSupportFile("outside-link.txt") === null, "a support symlink must not escape the download directory");
	unlink($linkPath);
}
unlink($uploadTarget . DIRECTORY_SEPARATOR . $temporaryName);
unlink($cleanGifPath);
unlink($phpGifPath);
unlink($textPath);
unlink($htmlPath);
unlink($svgPath);
unlink($xmlPath);
unlink($archivePath);
unlink($supportRoot . DIRECTORY_SEPARATOR . $supportName);
unlink($outsideFile);
rmdir($uploadSource);
rmdir($uploadTarget);
rmdir($supportRoot);
rmdir($downloadRoot);
rmdir($tempRoot);

foreach ([
	"app/common/logic/Upgrade.php",
	"app/admin/controller/PromoCodeController.php",
] as $relativePath) {
	$source = file_get_contents($root . "/" . $relativePath);
	assertSecurityHardening(!preg_match('/(?<!@)unserialize\\s*\\([^,\\)]*\\)/', $source), $relativePath . " must not perform unrestricted unserialize calls");
	assertSecurityHardening(strpos($source, '["allowed_classes" => false]') !== false, $relativePath . " must disable class instantiation during unserialize");
}

assertSecurityHardening(strpos($common, 'function safeHtmlContent') !== false, "rich HTML output must have a shared purifier");
assertSecurityHardening(strpos($common, 'HTMLPurifier_Config::createDefault()') !== false, "rich HTML must be filtered by HTMLPurifier");
assertSecurityHardening(strpos($common, 'ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5') !== false, "plain ticket text must be encoded safely");

foreach ([$homeMessages, $openapiMessages] as $source) {
	assertSecurityHardening(strpos($source, '$params["uid"]') === false && strpos($source, '$param["uid"]') === false, "message operations must not trust a client-supplied uid");
	assertSecurityHardening(strpos($source, 'safeHtmlContent($item["content"])') !== false, "message HTML must be purified before output");
}

assertSecurityHardening(strpos($check, 'catch (\\Throwable $e)') !== false, "JWT verification must catch unexpected throwables");
assertSecurityHardening(strpos($check, 'return $e;') === false, "JWT verification must not return exception objects");
assertSecurityHardening(substr_count($check, '($checkJwtToken["status"] ?? 0) !== 1001') >= 2, "JWT callers must short-circuit failed verification before reading claims");

$autoRenew = securityMethodSource($homeHost, "postAutoRenew");
$deleteCancel = securityMethodSource($homeHost, "deleteCancel");
$openapiDeleteCancel = securityMethodSource($openapiHost, "deleteCancel");
$openapiModule = securityMethodSource($openapiHost, "module");
assertSecurityHardening(substr_count($autoRenew, 'where("uid", $uid)') >= 2, "host auto-renew reads and writes must enforce ownership");
assertSecurityHardening(strpos($deleteCancel, 'where("uid", $uid)') !== false, "cancel-request deletion must verify host ownership");
assertSecurityHardening(strpos($openapiDeleteCancel, 'where("uid", $uid)') !== false, "OpenAPI cancel-request deletion must verify host ownership");
assertSecurityHardening(strpos($openapiModule, 'where("h.uid", $uid)') !== false, "OpenAPI module details must enforce host ownership");
assertSecurityHardening(strpos($homeHost, '$initiative_renew = 0;') !== false, "auto-renew must preserve the optional parameter default");
assertSecurityHardening(strpos(file_get_contents($root . "/app/home/controller/DownController.php"), 'Download::resolveFileInDirectory($url, $app_file[0])') !== false, "application downloads must use the canonical path resolver");

$hostSources = $homeHost
	. file_get_contents($root . "/app/home/controller/DcimController.php")
	. $openapiHost;
assertSecurityHardening(strpos($hostSources, "FIND_IN_SET('{") === false, "FIND_IN_SET values must not be interpolated");
assertSecurityHardening(substr_count($hostSources, 'FIND_IN_SET(:product_id, allow_products)') >= 6, "all flow-packet product filters must use bindings");

require_once $root . "/vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php";
$purifierConfig = HTMLPurifier_Config::createDefault();
$purifierConfig->set("Cache.DefinitionImpl", null);
$purifier = new HTMLPurifier($purifierConfig);
$purified = $purifier->purify('<p onclick="alert(1)">ok<script>alert(1)</script><a href="javascript:alert(1)">x</a></p>');
assertSecurityHardening(strpos($purified, "script") === false && strpos($purified, "onclick") === false && strpos($purified, "javascript:") === false, "HTMLPurifier must remove executable HTML");

fwrite(STDOUT, "security hardening regression checks passed" . PHP_EOL);
