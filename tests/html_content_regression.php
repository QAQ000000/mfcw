<?php

define("CMF_ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once CMF_ROOT . "vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php";
require_once CMF_ROOT . "app/common.php";

function assertHtmlContent($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$adminHtml = '<style>.terms{display:grid;grid-template-columns:1fr 1fr}</style><section class="terms" data-layout="legal"><h2>服务条款</h2><table><tr><td>内容</td></tr></table></section>';
$storedHtml = htmlspecialchars(htmlspecialchars($adminHtml, ENT_QUOTES, "UTF-8"), ENT_QUOTES, "UTF-8");
$renderedHtml = trustedAdminHtmlContent($storedHtml);

assertHtmlContent(strpos($renderedHtml, "&lt;h2") === false, "doubly encoded administrator HTML must not be displayed as source code");
assertHtmlContent($renderedHtml === $adminHtml, "administrator HTML and CSS must remain unchanged after storage decoding");

$unsafeHtml = htmlspecialchars(htmlspecialchars('<p onclick="alert(1)">内容<script>alert(1)</script><a href="javascript:alert(1)">链接</a></p>', ENT_QUOTES, "UTF-8"), ENT_QUOTES, "UTF-8");
$filteredHtml = safeHtmlContent($unsafeHtml);
assertHtmlContent(strpos($filteredHtml, "script") === false, "executable script elements must still be removed");
assertHtmlContent(strpos($filteredHtml, "onclick") === false, "event handler attributes must still be removed");
assertHtmlContent(strpos($filteredHtml, "javascript:") === false, "executable URL schemes must still be removed");

fwrite(STDOUT, "html content regression checks passed" . PHP_EOL);
