<?php

namespace app\http\middleware;

class ApiCheck
{
	public function __construct()
	{
	}
	public function handle(\think\Request $request, \Closure $next)
	{
		$header = $request->header();
		$token = $header["authorization"] ?? "";
		if (empty($token)) {
			$result["status"] = 400;
			$result["msg"] = "请输入用户名密码";
			return json($result);
		}
		$token = explode(" ", $token);
		if (count($token) > 1) {
			$token = $token[1] ?? "";
		} else {
			$token = $token[0] ?? "";
		}
		$token = base64_decode($token, true);
		if ($token === false || $token === "") {
			$result["status"] = 400;
			$result["msg"] = "参数错误";
			return json($result);
		}
		$pos = strpos($token, ":");
		if ($pos === false) {
			$result["status"] = 400;
			$result["msg"] = "参数错误";
			return json($result);
		}
		$username = substr($token, 0, $pos);
		$password = substr($token, $pos + 1);
		if ($username === "" || $password === "") {
			$result["status"] = 400;
			$result["msg"] = "参数错误";
			return json($result);
		}
		$api = \think\Db::name("api")->where("username", $username)->where("password", md5($password))->find();
		if (empty($api)) {
			$result["status"] = 400;
			$result["msg"] = "账号或密码错误";
			return json($result);
		}
		$ip = array_values(array_filter(array_map("trim", explode(",", (string) ($api["ip"] ?? ""))), function ($value) {
			return $value !== "";
		}));
		$client_ip = get_client_ip();
		if (empty($ip) || !in_array($client_ip, $ip, true)) {
			$result["status"] = 400;
			$result["msg"] = "当前IP不允许访问";
			return json($result);
		}
		return $next($request);
	}
}
