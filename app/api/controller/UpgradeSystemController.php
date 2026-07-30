<?php

namespace app\api\controller;

class UpgradeSystemController extends \think\Controller
{
	/**
	 * @title 获取版本号
	 * @description 接口说明: 获取版本号
	 * @param
	 * @author x
	 * @url  api/upgrade/version
	 * @method GET
	 */
	public function sysVersion()
	{
		return jsons(["status" => 200, "data" => [
			"version" => getZjmfVersion(),
			"is_download" => 0,
			"auto_upgrade" => 0,
		]]);
	}

	/**
	 * @title 更新系统
	 * @description 更新系统:下载zip包
	 * @url api/upgrade/autoupdate
	 * @method POST
	 */
	public function getAutoUpdate()
	{
		return $this->autoUpgradeDisabled();
	}

	/**
	 * @title 检测系统更新进度
	 * @url api/upgrade/checkautoupdate
	 * @method GET
	 */
	public function getCheckAutoUpdate()
	{
		return $this->autoUpgradeDisabled();
	}

	/**
	 * @title 解压文件
	 * @url api/upgrade/checkupdateunzip
	 * @method POST
	 */
	public function getCheckUpdateUnzip()
	{
		return $this->autoUpgradeDisabled();
	}

	/**
	 * @title 文件升级替换
	 * @url api/upgrade/checkupdatecopy
	 * @method POST
	 */
	public function getCheckUpdateCopy()
	{
		return $this->autoUpgradeDisabled();
	}

	/**
	 * 保留方法用于阻止框架默认控制器路由绕过显式路由配置。
	 */
	public function getSqlUpdate()
	{
		return $this->autoUpgradeDisabled();
	}

	private function autoUpgradeDisabled()
	{
		return jsonrule(["status" => 403, "msg" => "分叉版本已禁用官方自动升级，请使用审核后的手动升级包"]);
	}
}
