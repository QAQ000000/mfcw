<?php

function assertOpenApiCheckoutGuard($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$source = file_get_contents(dirname(__DIR__) . "/app/openapi/controller/CartController.php");
$source = str_replace("\r\n", "\n", $source);

$checkoutStart = strpos($source, "public function cartCheckout()");
assertOpenApiCheckoutGuard($checkoutStart !== false, "cartCheckout must exist");
assertOpenApiCheckoutGuard((bool) preg_match('/public function cartCheckout\(\).*?(?=\n\tpublic function |\n})/s', $source, $matches), "cartCheckout source must be readable");
$checkout = $matches[0];

$directCart = strpos($checkout, 'if (!empty($pos_param["cart_data"]))');
$configFilter = strpos($checkout, '$shop->configfilter(', $directCart);
$priceCalculation = strpos($checkout, '$productModel->checkProductPrice(');

assertOpenApiCheckoutGuard($directCart !== false, "direct OpenAPI checkout branch must exist");
assertOpenApiCheckoutGuard(strpos($checkout, 'is_array($pos_param["cart_data"])', $directCart) !== false, "direct checkout data must be an array");
assertOpenApiCheckoutGuard(strpos($checkout, 'is_array($configoptions)', $directCart) !== false, "submitted configuration must be an array");
assertOpenApiCheckoutGuard($configFilter !== false, "direct checkout must normalize configurable options");
assertOpenApiCheckoutGuard($priceCalculation !== false && $configFilter < $priceCalculation, "configuration normalization must run before price calculation");

fwrite(STDOUT, "OpenAPI zero-amount purchase regression checks passed" . PHP_EOL);
