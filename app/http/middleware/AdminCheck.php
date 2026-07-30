<?php

namespace app\http\middleware;

class AdminCheck
{
	protected $header = ["Access-Control-Allow-Methods" => "GET, POST, OPTIONS", "Access-Control-Allow-Headers" => "Content-Type, X-CSRF-TOKEN, X-Requested-With"];
	public function handle($request, \Closure $next)
	{
		$header = $this->header;
		if ($request->method(true) == "OPTIONS") {
			return \think\Response::create()->code(204)->header($header);
		}
		$sessionAdminId = cmf_get_current_admin_id();
		if (intval($sessionAdminId) !== 1) {
			if (!$sessionAdminId) {
				return json(["status" => 405, "msg" => "您还没有登录"]);
			}
			return json(["status" => 403, "msg" => "仅超级管理员可执行系统升级"]);
		}
		return $next($request);
	}
}
