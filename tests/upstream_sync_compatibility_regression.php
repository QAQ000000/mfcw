<?php

require dirname(__DIR__) . "/app/common/logic/Product.php";

function assertUpstreamSyncCompatibility($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

use app\common\logic\Product;

assertUpstreamSyncCompatibility(Product::cartProductVersion(["location_version" => 7, "upstream_version" => 99]) === "7", "cart snapshots must use the downstream-visible location version");

$upstreamOnly = Product::normalizeSupplierProductState([
	"api_type" => "zjmf_api",
	"stock_control" => 0,
	"qty" => 0,
	"upstream_stock_control" => 1,
	"upstream_qty" => 2,
	"hidden" => 0,
]);
assertUpstreamSyncCompatibility($upstreamOnly["stock_control"] === 1 && $upstreamOnly["qty"] === 2, "resold products must export upstream inventory");
assertUpstreamSyncCompatibility($upstreamOnly["upstream_stock_control"] === 1 && $upstreamOnly["upstream_qty"] === 2, "detail sync must expose a consistent upstream inventory pair");

$bothLimited = Product::normalizeSupplierProductState([
	"api_type" => "zjmf_api",
	"stock_control" => 1,
	"qty" => 5,
	"upstream_stock_control" => 1,
	"upstream_qty" => 2,
	"hidden" => 0,
]);
assertUpstreamSyncCompatibility($bothLimited["stock_control"] === 1 && $bothLimited["qty"] === 2, "combined local and upstream inventory must use the stricter limit");

$unlimited = Product::normalizeSupplierProductState([
	"api_type" => "normal",
	"stock_control" => 0,
	"qty" => 99,
	"upstream_stock_control" => 1,
	"upstream_qty" => 1,
	"hidden" => 0,
]);
assertUpstreamSyncCompatibility($unlimited["stock_control"] === 0 && $unlimited["qty"] === 0, "non-zjmf products must retain their local inventory semantics");

$hiddenGroup = Product::normalizeSupplierProductState([
	"api_type" => "zjmf_api",
	"stock_control" => 0,
	"qty" => 0,
	"upstream_stock_control" => 0,
	"upstream_qty" => 0,
	"hidden" => 0,
	"supplier_group_hidden" => 1,
]);
assertUpstreamSyncCompatibility($hiddenGroup["hidden"] === 1, "group-hidden products must be hidden from downstream sync");

$root = dirname(__DIR__);
$routes = file_get_contents($root . "/data/route/api.php");
$homeRoutes = file_get_contents($root . "/data/route/home.php");
$productLogic = file_get_contents($root . "/app/common/logic/Product.php");
$cartLogic = file_get_contents($root . "/app/common/logic/Cart.php");
$homeCart = file_get_contents($root . "/app/home/controller/CartController.php");
$currency = file_get_contents($root . "/app/admin/controller/CurrencyController.php");
$hostLogic = file_get_contents($root . "/app/common/logic/Host.php");

assertUpstreamSyncCompatibility(strpos($routes, 'Route::get("api/product/proinfo", "api/product/proInfo")->middleware("Check")') !== false, "proinfo must require an authenticated supplier token");
assertUpstreamSyncCompatibility(strpos($routes, 'Route::get("api/product/prodetail", "api/product/proDetail")->middleware("Check")') !== false, "prodetail must require an authenticated supplier token");
assertUpstreamSyncCompatibility(strpos($homeRoutes, 'Route::get("cart/get_product_config", "home/cart/getProductConfig")->middleware("Check")') !== false, "product configuration sync must require an authenticated supplier token");
assertUpstreamSyncCompatibility(strpos($homeRoutes, 'Route::get("cart/stock_control", "home/Cart/getQty")->middleware("Check")') !== false, "real-time stock checks must require an authenticated supplier token");
assertUpstreamSyncCompatibility(strpos($productLogic, 'supplier_state_version') !== false, "old product sync caches must be rebuilt after the supplier-state contract changes");
assertUpstreamSyncCompatibility(strpos($cartLogic, 'Product::normalizeSupplierProductState($product)') !== false, "classic cart configuration must display effective upstream inventory");
assertUpstreamSyncCompatibility(strpos($homeCart, 'a.upstream_stock_control,a.upstream_qty') !== false && strpos($homeCart, 'normalizeSupplierProductState($product)') !== false, "cart lists and totals must display effective upstream inventory");
assertUpstreamSyncCompatibility(strpos($homeCart, '"cart/stock_control", ["pid" => $product["upstream_pid"]], 3, "GET"') !== false, "stock validation must use a bounded upstream timeout");
assertUpstreamSyncCompatibility(strpos($homeCart, '商品库存校验暂不可用，请稍后重试') !== false, "supplier stock validation failures must fail closed");
assertUpstreamSyncCompatibility(strpos($currency, 'invalidateProductCatalogCache(true)') !== false && strpos($currency, 'setInc("location_version")') !== false, "currency changes that affect supplier prices must increment product versions");
assertUpstreamSyncCompatibility(strpos($hostLogic, '$post_data["supplier_version"] = (string) intval($host["upstream_version"]);') !== false, "reseller provisioning must forward the upstream location snapshot to maintained suppliers");

fwrite(STDOUT, "upstream sync compatibility regression checks passed" . PHP_EOL);
