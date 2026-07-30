<?php

require_once dirname(__DIR__) . "/app/common/logic/Shop.php";

use app\common\logic\Shop;

function assertCartQuantity($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "Assertion failed: " . $message . PHP_EOL);
		exit(1);
	}
}

assertCartQuantity(Shop::MAX_PRODUCT_QUANTITY === 100, "the product quantity ceiling must remain explicit");

$valid = [[1, 1], [100, 100], ["1", 1], ["99", 99], ["100", 100]];
foreach ($valid as $case) {
	list($input, $expected) = $case;
	assertCartQuantity(Shop::normalizeProductQuantity($input) === $expected, "valid quantity was rejected: " . var_export($input, true));
}

$invalid = [
	0,
	-1,
	101,
	PHP_INT_MAX,
	"",
	"0",
	"01",
	"101",
	"9223372036854775807",
	"9999999999999999999999999999999999999999",
	"1.0",
	"1e2",
	" 1",
	"1 ",
	1.0,
	true,
	null,
	[],
];
foreach ($invalid as $input) {
	assertCartQuantity(Shop::normalizeProductQuantity($input) === false, "invalid quantity was accepted: " . var_export($input, true));
}

$cart = Shop::normalizeCartProductQuantities(["products" => [["pid" => 1, "qty" => "100"]]]);
assertCartQuantity($cart["products"][0]["qty"] === 100, "cart quantities must be normalized before checkout");
assertCartQuantity(Shop::normalizeCartProductQuantities(["products" => [["pid" => 1, "qty" => "101"]]]) === false, "checkout must reject oversized persisted quantities");
assertCartQuantity(Shop::normalizeCartProductQuantities(["products" => [["pid" => 1, "qty" => "9223372036854775807"]]]) === false, "checkout must reject overflow-sized persisted quantities");

$sanitizeStored = new ReflectionMethod(Shop::class, "sanitizeStoredCartQuantities");
$sanitizeStored->setAccessible(true);
$stored = $sanitizeStored->invoke(null, ["products" => [["pid" => 1, "qty" => "9223372036854775807"]]]);
assertCartQuantity($stored["products"][0]["qty"] === 1, "legacy oversized carts must be repaired before rendering");

$root = dirname(__DIR__);
$home = file_get_contents($root . "/app/home/controller/CartController.php");
$openapi = file_get_contents($root . "/app/openapi/controller/CartController.php");
$template = file_get_contents($root . "/public/themes/cart/default/viewcart.tpl");

assertCartQuantity(substr_count($home, "normalizeProductQuantity") >= 4, "home cart mutation and pricing endpoints must validate quantities");
assertCartQuantity(strpos($home, "normalizeCartProductQuantities") !== false, "home checkout must validate persisted quantities");
assertCartQuantity(substr_count($openapi, "normalizeProductQuantity") >= 6, "OpenAPI cart endpoints must validate quantities");
assertCartQuantity(strpos($openapi, "normalizeCartProductQuantities") !== false, "OpenAPI checkout must validate persisted quantities");
assertCartQuantity(strpos($template, 'min="1" max="100" step="1"') !== false, "cart quantity input must expose the server-side range");

fwrite(STDOUT, "cart quantity regression checks passed" . PHP_EOL);
