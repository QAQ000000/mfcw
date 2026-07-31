<?php

namespace app\queue\job;

class SyncProduct extends \app\queue\common\JobCommon
{
	public function fire(\think\queue\Job $job, $data)
	{
		$pid = intval($data["pid"] ?? 0);
		$released = false;
		try {
			$result = $this->handle($data);
			if (($result["status"] ?? 400) != 200) {
				throw new \RuntimeException((string) ($result["msg"] ?? "供应商同步失败"));
			}
			cache("cart_product_sync_success_" . $pid, 1, 15);
			cache("cart_product_sync_failure_" . $pid, null);
			$job->delete();
		} catch (\Throwable $e) {
			try {
				\think\facade\Log::record(static::class . " queue failed for product #{$pid}: " . $e->getMessage(), "error");
			} catch (\Throwable $logError) {
			}
			if ($pid > 0 && $job->attempts() < 2) {
				cache("cart_product_sync_queued_" . $pid, 1, 120);
				$job->release(15);
				$released = true;
			} else {
				cache("cart_product_sync_failure_" . $pid, 1, 60);
				$job->delete();
			}
		} finally {
			if (!$released && $pid > 0) {
				cache("cart_product_sync_queued_" . $pid, null);
			}
		}
	}

	public function handle($data)
	{
		parent::handle($data);
		$pid = intval($data["pid"] ?? 0);
		if ($pid <= 0) {
			return ["status" => 400, "msg" => "商品不存在"];
		}
		$product = \think\Db::name("products")
			->field("id,api_type,zjmf_api_id,upstream_pid,upstream_price_type,upstream_price_value")
			->where("id", $pid)
			->find();
		if (empty($product) || $product["api_type"] !== "zjmf_api") {
			return ["status" => 200, "msg" => "商品无需同步"];
		}
		$auto_update = \think\Db::name("zjmf_finance_api")->where("id", $product["zjmf_api_id"])->value("auto_update");
		if (intval($auto_update) !== 1) {
			return ["status" => 200, "msg" => "供应商自动同步已关闭"];
		}
		$param = [
			"pid" => $pid,
			"zjmf_finance_api_id" => intval($product["zjmf_api_id"]),
			"upstream_pid" => intval($product["upstream_pid"]),
			"timeout" => 5,
			"page_type" => "cart_queue",
			"upstream_price_type" => $product["upstream_price_type"],
			"upstream_price_value" => $product["upstream_price_value"],
		];
		return (new \app\common\logic\Product())->syncProduct($param);
	}
}
