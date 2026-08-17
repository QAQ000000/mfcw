<?php

namespace think {
	class Db
	{
		public static $tables = [];

		public static function name($table)
		{
			return new FakeQuery($table);
		}
	}

	class FakeQuery
	{
		private $table;
		private $where = [];

		public function __construct($table)
		{
			$this->table = $table;
		}

		public function field($fields)
		{
			return $this;
		}

		public function where($field, $operator = null, $value = null)
		{
			if (func_num_args() === 2) {
				$value = $operator;
				$operator = "=";
			}
			$this->where[] = [$field, $operator, $value];
			return $this;
		}

		public function select()
		{
			return new FakeResult($this->rows());
		}

		public function find()
		{
			$rows = $this->rows();
			return $rows[0] ?? null;
		}

		public function update(array $data)
		{
			$updated = 0;
			foreach (Db::$tables[$this->table] as &$row) {
				if ($this->matches($row)) {
					$row = array_merge($row, $data);
					$updated++;
				}
			}
			unset($row);
			return $updated;
		}

		private function rows()
		{
			return array_values(array_filter(Db::$tables[$this->table] ?? [], function ($row) {
				return $this->matches($row);
			}));
		}

		private function matches($row)
		{
			foreach ($this->where as $condition) {
				list($field, $operator, $value) = $condition;
				$actual = $row[$field] ?? null;
				if ($operator === ">") {
					if (!($actual > $value)) {
						return false;
					}
				} elseif ($actual != $value) {
					return false;
				}
			}
			return true;
		}
	}

	class FakeResult
	{
		private $rows;

		public function __construct(array $rows)
		{
			$this->rows = $rows;
		}

		public function toArray()
		{
			return $this->rows;
		}
	}
}

namespace app\common\logic {
	class ClientActivityLog
	{
		public static function markInternal($description, $source)
		{
			return $description;
		}
	}
}

namespace {
	$upstreamInventoryResponse = [];
	$activityLogs = [];

	function getZjmfUpstreamProductsInfo($id)
	{
		global $upstreamInventoryResponse;
		return $upstreamInventoryResponse[$id];
	}

	function active_log_final($description, $userid = 0, $type = 0, $typeDataId = 0, $fromType = 1)
	{
		global $activityLogs;
		$activityLogs[] = $description;
	}

	require dirname(__DIR__) . "/app/common/logic/Product.php";

	class TestableStockProduct extends \app\common\logic\Product
	{
		public $refreshedProductIds = [];

		protected function acquireCartSyncLock($pid, $lease)
		{
			return ["pid" => $pid];
		}

		protected function releaseCartSyncLock($lock)
		{
			return true;
		}

		public function refreshInventoryCache($pids = [], $context = "inventory commit")
		{
			$this->refreshedProductIds = $pids;
			return true;
		}
	}

	function assertStockCron($condition, $message)
	{
		if (!$condition) {
			fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
			exit(1);
		}
	}

	\think\Db::$tables = [
		"zjmf_finance_api" => [
			["id" => 1, "name" => "supplier", "type" => "zjmf_api"],
		],
		"products" => [
			["id" => 10, "api_type" => "zjmf_api", "zjmf_api_id" => 1, "upstream_pid" => 100, "upstream_version" => 7, "upstream_stock_control" => 1, "upstream_qty" => 2, "stock_control" => 1, "qty" => 9, "name" => "changed"],
			["id" => 11, "api_type" => "zjmf_api", "zjmf_api_id" => 1, "upstream_pid" => 101, "upstream_version" => 4, "upstream_stock_control" => 0, "upstream_qty" => 0, "stock_control" => 0, "qty" => 5, "name" => "unchanged"],
		],
	];
	$upstreamInventoryResponse = [
		1 => ["status" => 200, "data" => ["info" => [
			["id" => 100, "location_version" => 7, "stock_control" => 1, "qty" => 6],
			["id" => 101, "location_version" => 4, "stock_control" => 0, "qty" => 0],
		]]],
	];

	$product = new TestableStockProduct();
	$result = $product->cronSyncInventory();
	$changed = \think\Db::$tables["products"][0];
	$unchanged = \think\Db::$tables["products"][1];

	assertStockCron($result["status"] === 200, "successful supplier inventory must mark the task successful");
	assertStockCron($result["updated"] === 1, "only changed inventory rows must be counted");
	assertStockCron($changed["upstream_stock_control"] === 1 && $changed["upstream_qty"] === 6, "the task must update upstream inventory fields");
	assertStockCron($changed["stock_control"] === 1 && $changed["qty"] === 9 && $changed["name"] === "changed", "the task must not modify local inventory or product details");
	assertStockCron($unchanged["qty"] === 5, "unchanged products must not be written");
	assertStockCron($product->refreshedProductIds === [10], "only changed product inventory caches must be refreshed");

	$upstreamInventoryResponse[1] = ["status" => 400, "msg" => "timeout"];
	$failedResult = (new TestableStockProduct())->cronSyncInventory();
	assertStockCron($failedResult["status"] === 400, "supplier failures must mark the inventory task as failed");
	assertStockCron(!empty($activityLogs), "supplier failures must leave an activity log");

	$root = dirname(__DIR__);
	$commandRegistry = file_get_contents($root . "/app/command.php");
	$cronSource = file_get_contents($root . "/app/admin/command/Cron.php");
	$stockCommand = file_get_contents($root . "/app/admin/command/StockCron.php");
	$controller = file_get_contents($root . "/app/admin/controller/CronController.php");
	$admin_chunk_path = $root . "/public/admin/js/AutomaticTasks~3dfaf398.8ffdff17.js";
	if (!is_file($admin_chunk_path)) {
		$admin_chunk_path = $root . "/public/admin123/js/AutomaticTasks~3dfaf398.8ffdff17.js";
	}
	$adminChunk = file_get_contents($admin_chunk_path);

	assertStockCron(strpos($commandRegistry, "StockCron") !== false, "the inventory command must be registered");
	assertStockCron(strpos($cronSource, '$this->syncUpstreamProductInfo();') !== false, "the original full product cron must remain unchanged");
	assertStockCron(strpos($stockCommand, 'setName("cron:stock")') !== false, "the inventory command name must remain stable");
	assertStockCron(strpos($controller, 'stock_cron_status') !== false, "the automatic-tasks API must expose inventory task status");
	assertStockCron(strpos($adminChunk, 'please_setting_stock_min_one') !== false && strpos($adminChunk, 'stockAlertStatus') !== false, "the automatic-tasks page must display inventory command and status prompts");

	fwrite(STDOUT, "stock cron regression checks passed" . PHP_EOL);
}
