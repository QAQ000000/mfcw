<?php

function assertUpstreamRescueProxy($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

$root = dirname(__DIR__);
$hostLogic = file_get_contents($root . "/app/common/logic/Host.php");
$homeProvision = file_get_contents($root . "/app/home/controller/ProvisionController.php");
$adminProvision = file_get_contents($root . "/app/admin/controller/ProvisionController.php");

$methodStart = strpos($hostLogic, "public function rescueSystem(");
assertUpstreamRescueProxy($methodStart !== false, "Host::rescueSystem must exist");
$rescueMethod = substr($hostLogic, $methodStart);

assertUpstreamRescueProxy(
	substr_count($rescueMethod, '$post_data["func"] = "rescue_system";') === 2,
	"both zjmf_api and resource rescue requests must use the receiver protocol name"
);
assertUpstreamRescueProxy(
	strpos($rescueMethod, '$post_data["func"] = "rescueSystem";') === false,
	"the legacy method-name spelling must not be forwarded to upstream finance systems"
);
assertUpstreamRescueProxy(
	substr_count($rescueMethod, '$post_data["temp_pass"] = input("post.temp_pass", "");') === 2,
	"both zjmf_api and resource rescue requests must forward the generated temporary password"
);
assertUpstreamRescueProxy(
	strpos($homeProvision, 'case "rescue_system":') !== false,
	"the customer receiver must accept the rescue proxy protocol name"
);
assertUpstreamRescueProxy(
	strpos($adminProvision, 'case "rescue_system":') !== false,
	"the administrator receiver must accept the rescue proxy protocol name"
);

fwrite(STDOUT, "upstream rescue proxy regression checks passed" . PHP_EOL);
