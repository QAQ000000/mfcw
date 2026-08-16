<?php

namespace app\queue\job;

class AutoCreate extends \app\queue\common\JobCommon
{
	const QUEUE_NAME = "autoCreate";
	public function fire(\think\queue\Job $job, $data)
	{
		try {
			$this->handle($data);
			$job->delete();
		} catch (\Throwable $e) {
			try {
				\think\facade\Log::record(static::class . " queue failed: " . $e->getMessage(), "error");
			} catch (\Throwable $logException) {
			}
			if ($job->attempts() >= 3) {
				$job->delete();
			} else {
				$job->release(10);
			}
		}
	}
	/**
	 * 逻辑处理
	 * @param $data
	 */
	public function handle($data)
	{
		parent::handle($data);
		$host_logic = new \app\common\logic\Host();
		$host_logic->is_admin = !empty($data["is_admin"]);
		$ip = $data["ip"] ?? "";
		$result = $host_logic->createFinal($data["hid"], $ip);
		$logic_run_map = new \app\common\logic\RunMap();
		$model_host = new \app\common\model\HostModel();
		$data_i = [];
		$data_i["host_id"] = $data["hid"];
		$data_i["active_type_param"] = [$data["hid"], $ip];
		$is_zjmf = $model_host->isZjmfApi($data_i["host_id"]);
		if ($result["status"] == 200) {
			$data_i["description"] = "订单 - 开通 Host ID:{$data_i["host_id"]}的产品成功";
			if ($is_zjmf) {
				$logic_run_map->saveMap($data_i, 1, 400, 1);
			}
			if (!$is_zjmf) {
				$logic_run_map->saveMap($data_i, 1, 300, 1);
			}
		} else {
			$data_i["description"] = "订单 - 开通 Host ID:{$data_i["host_id"]}的产品失败。原因:{$result["msg"]}";
			if ($is_zjmf) {
				$logic_run_map->saveMap($data_i, 0, 400, 1);
			}
			if (!$is_zjmf) {
				$logic_run_map->saveMap($data_i, 0, 300, 1);
			}
		}
	}
	public function delaty(&$data)
	{
		$data["delaty"] = isset($data["delaty"]) ? $data["delaty"] + 1 : 1;
	}
}
