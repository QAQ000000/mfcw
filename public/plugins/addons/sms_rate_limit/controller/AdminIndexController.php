<?php

namespace addons\sms_rate_limit\controller;

use app\admin\controller\PluginAdminBaseController;
use think\Db;

class AdminIndexController extends PluginAdminBaseController
{
	private $limits = [
		"cooldown_seconds" => [0, 3600, "同一手机号冷却时间"],
		"phone_daily_limit" => [0, 1000, "单手机号每日上限"],
		"global_minute_limit" => [0, 100000, "短信全站每分钟上限"],
		"global_daily_limit" => [0, 1000000, "短信全站每日上限"],
		"email_cooldown_seconds" => [0, 3600, "同一邮箱冷却时间"],
		"email_daily_limit" => [0, 1000, "单邮箱每日上限"],
		"email_global_minute_limit" => [0, 100000, "邮件全站每分钟上限"],
		"email_global_daily_limit" => [0, 1000000, "邮件全站每日上限"],
	];

	public function setting()
	{
		if ($this->request->isPost()) {
			$config = [];
			foreach ($this->limits as $key => $limit) {
				$value = trim((string) $this->request->param($key, ""));
				if (!preg_match("/^\\d+$/", $value) || intval($value) < $limit[0] || intval($value) > $limit[1]) {
					return $this->error($limit[2] . "必须为" . $limit[0] . "-" . $limit[1] . "之间的整数");
				}
				$config[$key] = intval($value);
			}

			Db::name("plugin")
				->where("name", $this->getPlugin()->getName())
				->where("module", "addons")
				->update(["config" => json_encode($config)]);
			return $this->success("保存成功", shd_addon_url("SmsRateLimit://AdminIndex/setting"));
		}

		$plugin = $this->getPlugin();
		$currentConfig = $plugin->getConfig();
		$this->assign("Title", "验证码发送限流");
		$this->assign("config", array_merge($plugin->getDefaultConfig(), is_array($currentConfig) ? $currentConfig : []));
		return $this->fetch("/setting");
	}
}
