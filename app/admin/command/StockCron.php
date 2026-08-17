<?php

namespace app\admin\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class StockCron extends Command
{
	protected function configure()
	{
		$this->setName("cron:stock")->setDescription("每分钟同步上游商品库存");
	}

	protected function execute(Input $input, Output $output)
	{
		$lock = $this->acquireLock();
		if ($lock === false) {
			$finished_at = time();
			$error = "库存计划任务无法取得执行锁，任务可能仍在运行或锁文件不可写";
			updateConfiguration("stock_cron_last_run_time_over", $finished_at);
			updateConfiguration("stock_cron_last_run_status", 0);
			updateConfiguration("stock_cron_last_run_error", $error);
			$output->writeln($error);
			return 1;
		}

		$started_at = time();
		$status = 0;
		$error = "";
		try {
			updateConfiguration("stock_cron_last_run_time", $started_at);
			$output->writeln("库存计划任务开始:" . date("Y-m-d H:i:s", $started_at));
			$result = (new \app\common\logic\Product())->cronSyncInventory();
			$status = ($result["status"] ?? 400) == 200 ? 1 : 0;
			$error = implode("; ", $result["errors"] ?? []);
			$output->writeln("库存变更商品数:" . intval($result["updated"] ?? 0));
			$output->writeln("库存跳过商品数:" . intval($result["skipped"] ?? 0));
		} catch (\Throwable $e) {
			$error = $e->getMessage();
			active_log_final("库存计划任务执行异常:" . $error, 0, 5);
		} finally {
			$finished_at = time();
			$this->releaseLock($lock);
			updateConfiguration("stock_cron_last_run_time_over", $finished_at);
			updateConfiguration("stock_cron_last_run_status", $status);
			updateConfiguration("stock_cron_last_run_error", $error);
			$output->writeln("库存计划任务结束:" . date("Y-m-d H:i:s", $finished_at));
		}

		return $status === 1 ? 0 : 1;
	}

	private function acquireLock()
	{
		$data_dir = defined("CMF_DATA") ? CMF_DATA : sys_get_temp_dir() . DIRECTORY_SEPARATOR;
		$lock_dir = rtrim($data_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "locks" . DIRECTORY_SEPARATOR . "cron";
		if (!is_dir($lock_dir) && !@mkdir($lock_dir, 0750, true) && !is_dir($lock_dir)) {
			return false;
		}
		$handle = @fopen($lock_dir . DIRECTORY_SEPARATOR . "stock.lock", "c+");
		if (!is_resource($handle)) {
			return false;
		}
		if (!@flock($handle, LOCK_EX | LOCK_NB)) {
			fclose($handle);
			return false;
		}
		return $handle;
	}

	private function releaseLock($handle)
	{
		if (!is_resource($handle)) {
			return;
		}
		flock($handle, LOCK_UN);
		fclose($handle);
	}
}
