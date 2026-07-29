<?php

$root = dirname(__DIR__);

function assertResourceAuth($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function resourceAuthMethodSource($file, $method)
{
	$source = file_get_contents($file);
	assertResourceAuth($source !== false, basename($file) . " must be readable");
	$pattern = '/(?:public|protected|private) function ' . preg_quote($method, '/') . '\\b.*?(?=\\n\\t(?:public|protected|private) function |\\n})/s';
	assertResourceAuth((bool) preg_match($pattern, $source, $matches), basename($file) . "::" . $method . " must exist");
	return $matches[0];
}

function assertResourceAuthContains($source, $needle, $message)
{
	assertResourceAuth(strpos($source, $needle) !== false, $message);
}

function assertResourceAuthOrder($source, $needles, $message)
{
	$offset = 0;
	foreach ($needles as $needle) {
		$position = strpos($source, $needle, $offset);
		assertResourceAuth($position !== false, $message . ": missing " . $needle);
		$offset = $position + strlen($needle);
	}
}

$cartFile = $root . "/app/home/controller/CartController.php";
$cartMethod = resourceAuthMethodSource($cartFile, "postCreateProducts");

assertResourceAuthContains($cartMethod, '$param["token"]', "createproducts must accept the existing resource-shop token parameter");
assertResourceAuthContains($cartMethod, 'cache("resource_token")', "createproducts must validate the resource-shop cache token");
assertResourceAuthContains($cartMethod, 'is_string($token)', "createproducts must reject non-string provided tokens");
assertResourceAuthContains($cartMethod, 'is_string($resourceToken)', "createproducts must reject non-string cached tokens");
assertResourceAuthContains($cartMethod, '$token === ""', "createproducts must reject an empty provided token");
assertResourceAuthContains($cartMethod, '$resourceToken === ""', "createproducts must reject an empty cached token");
assertResourceAuthContains($cartMethod, 'hash_equals($resourceToken, $token)', "createproducts must compare tokens in constant time");
assertResourceAuth(
	!preg_match('/\\$token\\s*=.*?\\(string\\).*?\\$param\\["token"\\]/s', $cartMethod),
	"createproducts must validate the provided token type instead of coercing it"
);
assertResourceAuth(
	!preg_match('/\\$resourceToken\\s*=\\s*\\(string\\)\\s*cache\\("resource_token"\\)/', $cartMethod),
	"createproducts must validate the cached token type instead of coercing it"
);

assertResourceAuthContains($cartMethod, 'where("is_resource", 1)', "createproducts must require a resource-pool API");
assertResourceAuthContains($cartMethod, 'where("is_using", 1)', "createproducts must require the resource pool to be enabled");
assertResourceAuthContains($cartMethod, 'if (empty($resource))', "createproducts must reject a missing resource pool");
assertResourceAuthOrder(
	$cartMethod,
	[
		'hash_equals($resourceToken, $token)',
		'where("is_resource", 1)',
		'where("is_using", 1)',
		'if (empty($resource))',
		'\\think\\Db::startTrans();',
		'insertGetId(',
	],
	"createproducts authentication and resource checks must precede its transaction and first write"
);

$routeSource = file_get_contents($root . "/data/route/home.php");
assertResourceAuth($routeSource !== false, "home routes must be readable");
$createRoute = 'think\\facade\\Route::post("cart/createproducts", "home/Cart/postCreateProducts");';
assertResourceAuth(substr_count($routeSource, $createRoute) === 1, "createproducts must have exactly one route");
$checkGroupEnd = strpos($routeSource, 'middleware("Check")');
$createRoutePosition = strpos($routeSource, $createRoute);
$userCheckGroupEnd = strpos($routeSource, 'middleware("UserCheck")', $checkGroupEnd === false ? 0 : $checkGroupEnd + 1);
assertResourceAuth(
	$checkGroupEnd !== false
		&& $createRoutePosition !== false
		&& $userCheckGroupEnd !== false
		&& $checkGroupEnd < $createRoutePosition
		&& $createRoutePosition < $userCheckGroupEnd,
	"createproducts must remain in the resource-shop-compatible UserCheck route group"
);

$publicFile = $root . "/app/admin/controller/PublicController.php";
$publicMethod = resourceAuthMethodSource($publicFile, "checkToken");
assertResourceAuthContains($publicMethod, 'input("get.token"', "agent checktoken must read the handoff token");
assertResourceAuthContains($publicMethod, 'cache("resource_token")', "agent checktoken must read the cached handoff token");
assertResourceAuthContains($publicMethod, 'is_string($token)', "agent checktoken must reject non-string provided tokens");
assertResourceAuthContains($publicMethod, 'is_string($resourceToken)', "agent checktoken must reject non-string cached tokens");
assertResourceAuthContains($publicMethod, '$token !== ""', "agent checktoken must reject an empty provided token");
assertResourceAuthContains($publicMethod, '$resourceToken !== ""', "agent checktoken must reject an empty cached token");
assertResourceAuthContains($publicMethod, 'hash_equals($resourceToken, $token)', "agent checktoken must compare tokens in constant time");
assertResourceAuth(
	!preg_match('/\\$token\\s*=\\s*\\(string\\)\\s*input\\(/', $publicMethod),
	"agent checktoken must validate the provided token type instead of coercing it"
);
assertResourceAuth(
	!preg_match('/\\$resourceToken\\s*=\\s*\\(string\\)\\s*cache\\("resource_token"\\)/', $publicMethod),
	"agent checktoken must validate the cached token type instead of coercing it"
);
assertResourceAuth(
	strpos($publicMethod, '$token == cache("resource_token")') === false,
	"agent checktoken must not restore the empty-token loose-comparison vulnerability"
);
assertResourceAuthOrder(
	$publicMethod,
	[
		'is_string($token)',
		'is_string($resourceToken)',
		'hash_equals($resourceToken, $token)',
		'where("is_resource", 1)',
		'zjmfApiLogin(',
	],
	"agent checktoken validation must precede resource lookup and upstream login"
);

assertResourceAuth(hash_equals("known-token", "known-token"), "PHP runtime must support hash_equals");
assertResourceAuth(!hash_equals("known-token", "wrong-token"), "hash_equals must reject a wrong token");

fwrite(STDOUT, "resource import authentication regression checks passed" . PHP_EOL);
