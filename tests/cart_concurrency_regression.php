<?php

require_once dirname(__DIR__) . "/app/common/logic/Shop.php";

use app\common\logic\Shop;

function assertCartConcurrency($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

assertCartConcurrency(Shop::MAX_CART_LINES === 50, "cart line limit must remain explicit");
assertCartConcurrency(Shop::MAX_CART_INSTANCES === 100, "cart instance limit must remain explicit");

$duplicateProduct = ["products" => [
	["pid" => 7, "qty" => 60],
	["pid" => 7, "qty" => 41],
]];
assertCartConcurrency(Shop::normalizeCartProductQuantities($duplicateProduct) === false, "duplicate rows must not bypass the per-product ceiling");

$tooManyInstances = ["products" => [
	["pid" => 7, "qty" => 60],
	["pid" => 8, "qty" => 41],
]];
assertCartConcurrency(Shop::normalizeCartProductQuantities($tooManyInstances) === false, "different products must not bypass the total instance ceiling");

$tooManyLines = ["products" => []];
for ($i = 1; $i <= 51; $i++) {
	$tooManyLines["products"][] = ["pid" => $i, "qty" => 1];
}
assertCartConcurrency(Shop::normalizeCartProductQuantities($tooManyLines) === false, "cart line ceiling must be enforced");

$sanitize = new ReflectionMethod(Shop::class, "sanitizeStoredCartQuantities");
$sanitize->setAccessible(true);
$legacyCart = ["products" => []];
for ($i = 0; $i < 80; $i++) {
	$legacyCart["products"][] = ["pid" => $i % 2 + 1, "qty" => "9223372036854775807"];
}
$sanitizedLegacyCart = $sanitize->invoke(null, $legacyCart);
assertCartConcurrency(count($sanitizedLegacyCart["products"]) <= Shop::MAX_CART_LINES, "legacy carts must be bounded while loading");
$sanitizedTotal = array_sum(array_column($sanitizedLegacyCart["products"], "qty"));
assertCartConcurrency($sanitizedTotal <= Shop::MAX_CART_INSTANCES, "legacy cart instances must be bounded while loading");

$singleOnly = ["products" => [
	["pid" => 9, "qty" => 1],
	["pid" => 9, "qty" => 1],
]];
$singleOnlyResult = Shop::validateCartProductLimits($singleOnly, [9 => ["allow_qty" => 0]]);
assertCartConcurrency($singleOnlyResult["status"] === "error", "allow_qty=0 must apply to the aggregated PID quantity");
$p3Result = Shop::validateCartProductLimits(["products" => [["pid" => 10, "qty" => 1]]], [10 => ["allow_qty" => 1, "api_type" => "resource"]]);
assertCartConcurrency($p3Result["status"] === "error", "P3 resource products must fail with a controlled cart error");

$root = dirname(__DIR__);
$shop = file_get_contents($root . "/app/common/logic/Shop.php");
$home = file_get_contents($root . "/app/home/controller/CartController.php");
$openapi = file_get_contents($root . "/app/openapi/controller/CartController.php");
$bridge = file_get_contents($root . "/public/upgrade/3.7.7.sql");
$install = file_get_contents($root . "/public/install/thinkcmf.sql");
$apiUpgrader = file_get_contents($root . "/app/api/controller/UpgradeSystemController.php");
$cliUpgrader = file_get_contents($root . "/public/upgrade/upgrade.php");

assertCartConcurrency(strpos($shop, 'GET_LOCK(?, ?)') !== false && strpos($shop, 'RELEASE_LOCK(?)') !== false, "logged-in cart operations must hold a per-user database lock");
assertCartConcurrency(strpos($shop, 'private $cart_lock') === false, "read-only cart construction must not hold a request-wide database lock");
assertCartConcurrency(strpos($shop, 'acquireMutationLock()') !== false && strpos($shop, '购物车正在处理中，请稍后重试') !== false, "cart mutations must fail with a controlled busy response");
preg_match('/public function settle\(.*?public function /s', $home, $homeSettleMatches);
assertCartConcurrency(!empty($homeSettleMatches[0]) && strpos($homeSettleMatches[0], 'acquireUserCartLock($uid, 5)') < strpos($homeSettleMatches[0], '$shop->getShoppingCart()'), "Home checkout must acquire the UID lock before reading the cart snapshot");
preg_match('/public function cartCheckout\(\).*?public function /s', $openapi, $openapiSettleMatches);
assertCartConcurrency(!empty($openapiSettleMatches[0]) && strpos($openapiSettleMatches[0], 'acquireUserCartLock($uid, 5)') < strpos($openapiSettleMatches[0], '$shop->getShoppingCart()'), "OpenAPI checkout must acquire the UID lock before reading the cart snapshot");
assertCartConcurrency(strpos($home, 'ksort($inventoryRequirements, SORT_NUMERIC)') !== false && strpos($home, 'where("qty", ">=", $requiredQty)->setDec("qty", $requiredQty)') !== false, "Home checkout must reserve aggregated stock in PID order");
assertCartConcurrency(strpos($openapi, 'ksort($inventoryRequirements, SORT_NUMERIC)') !== false && strpos($openapi, 'where("qty", ">=", $requiredQty)->setDec("qty", $requiredQty)') !== false, "OpenAPI checkout must reserve aggregated stock in PID order");
assertCartConcurrency(strpos($homeSettleMatches[0], '->lock(true)') === false && strpos($openapiSettleMatches[0], '->lock(true)') === false, "unlimited-stock products must not be row-locked during checkout");
assertCartConcurrency(strpos($home, '$cartLock->release();') < strpos($home, 'refreshInventoryCache($inventory_product_ids'), "Home checkout must release the cart lock before post-commit work");
assertCartConcurrency(strpos($openapi, '$cartLock->release();') < strpos($openapi, 'refreshInventoryCache($inventory_product_ids'), "OpenAPI checkout must release the cart lock before post-commit work");
assertCartConcurrency(strpos($home, 'catch (\\Throwable $e)') !== false && strpos($openapi, 'catch (\\Throwable $e)') !== false, "all transactional failures must roll back stock reservations");
assertCartConcurrency(strpos($bridge, 'ADD UNIQUE INDEX `uq_cart_session_uid` (`uid`(100))') !== false, "upgrade must enforce one durable cart per UID");
assertCartConcurrency(strpos($bridge, "SET `uid` = NULL\nWHERE `uid` = ''") !== false, "upgrade must normalize historical empty UIDs before adding the unique index");
assertCartConcurrency(strpos($install, 'ADD UNIQUE INDEX `uq_cart_session_uid` (`uid`(100))') !== false, "fresh installs must enforce one durable cart per UID");
assertCartConcurrency(strpos($apiUpgrader, '\\think\\Db::') === false, "disabled Web upgrader must not execute database migrations");
assertCartConcurrency(strpos($cliUpgrader, "INDEX_NAME = 'uq_cart_session_uid'") !== false, "CLI upgrader must verify cart uniqueness");
assertCartConcurrency(substr_count($shop, 'public function clearCart()') === 1 && strpos($shop, '$cartLock = $this->acquireMutationLock();', strpos($shop, 'public function clearCart()')) !== false, "cart clearing must use the per-user mutation lock");
preg_match('/private function _init\(\).*?private function save\(/s', $shop, $initMatches);
assertCartConcurrency(!empty($initMatches[0]) && strpos($initMatches[0], '->update(') === false && strpos($initMatches[0], '->insert(') === false, "read-only Shop construction must never persist cart data");
assertCartConcurrency(strpos($home, '$removeResult["status"] !== "success"') !== false && strpos($openapi, '$removeResult["status"] !== "success"') !== false, "cart removal endpoints must surface lock failures");

fwrite(STDOUT, "cart concurrency regression checks passed" . PHP_EOL);
