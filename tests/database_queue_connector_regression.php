<?php

namespace think\queue\connector {
	class Database
	{
		protected $options = [
			"expire" => 60,
			"default" => "default",
			"table" => "jobs",
		];

		public function __construct(array $options)
		{
			$this->options = array_merge($this->options, $options);
		}

		protected function getQueue($queue)
		{
			return $queue ?: $this->options["default"];
		}

		protected function releaseJobsThatHaveBeenReservedTooLong($queue)
		{
		}

		protected function markJobAsReserved($id)
		{
		}
	}
}

namespace think\queue\job {
	class Database
	{
		public function __construct($connector, $job, $queue)
		{
		}
	}
}

namespace think {
	class QueueTestQuery
	{
		public $orders = [];
		public $wheres = [];
		private $rows;

		public function __construct(array $rows)
		{
			$this->rows = $rows;
		}

		public function lock($value)
		{
			return $this;
		}

		public function where($field, $operator = null, $value = null)
		{
			if (func_num_args() === 2) {
				$value = $operator;
				$operator = "=";
			}
			$this->wheres[] = [$field, $operator, $value];
			return $this;
		}

		public function order($field, $direction = null)
		{
			$this->orders[] = [$field, $direction];
			return $this;
		}

		public function find()
		{
			$rows = array_values(array_filter($this->rows, function ($row) {
				foreach ($this->wheres as $where) {
					list($field, $operator, $value) = $where;
					if ($operator === "=" && $row[$field] != $value) {
						return false;
					}
					if ($operator === "<=" && $row[$field] > $value) {
						return false;
					}
				}
				return true;
			}));
			usort($rows, function ($left, $right) {
				foreach ($this->orders as $order) {
					list($field, $direction) = $order;
					if ($left[$field] == $right[$field]) {
						continue;
					}
					$result = $left[$field] < $right[$field] ? -1 : 1;
					return strtolower($direction) === "desc" ? -$result : $result;
				}
				return 0;
			});
			return $rows[0] ?? null;
		}
	}

	class Db
	{
		public static $query;
		public static $rows = [];

		public static function startTrans()
		{
		}

		public static function commit()
		{
		}

		public static function name($table)
		{
			self::$query = new QueueTestQuery(self::$rows);
			return self::$query;
		}
	}
}

namespace {
	require dirname(__DIR__) . "/app/common/queue/DatabaseConnector.php";

	class InspectableDatabaseConnector extends \app\common\queue\DatabaseConnector
	{
		public $now = 1000;
		public $sweeps = [];
		public $failSweep = false;

		protected function currentTime()
		{
			return $this->now;
		}

		protected function sweepJitter($queue)
		{
			return $this->options["sweep_jitter"];
		}

		protected function releaseJobsThatHaveBeenReservedTooLong($queue)
		{
			$this->sweeps[] = $queue;
			if ($this->failSweep) {
				throw new \RuntimeException("simulated sweep failure");
			}
		}

		public function inspectNextAvailableJob($queue)
		{
			return $this->getNextAvailableJob($queue);
		}
	}

	function assertDatabaseQueue($condition, $message)
	{
		if (!$condition) {
			throw new \RuntimeException($message);
		}
	}

	$connector = new InspectableDatabaseConnector([
		"expire" => 120,
		"default" => "default",
		"table" => "jobs",
		"sweep_interval" => 30,
		"sweep_jitter" => 3,
	]);

	$connector->pop();
	assertDatabaseQueue($connector->sweeps === ["default"], "the first pop must recover expired jobs");
	$connector->now = 1032;
	$connector->pop();
	assertDatabaseQueue(count($connector->sweeps) === 1, "recovery must remain throttled through the configured interval and jitter");
	$connector->now = 1033;
	$connector->pop();
	assertDatabaseQueue(count($connector->sweeps) === 2, "recovery must resume after the throttle window");
	$connector->pop("emails");
	assertDatabaseQueue($connector->sweeps === ["default", "default", "emails"], "each queue must have an independent sweep window");

	$disabled = new InspectableDatabaseConnector([
		"expire" => null,
		"sweep_interval" => 0,
		"sweep_jitter" => 0,
	]);
	$disabled->pop();
	assertDatabaseQueue($disabled->sweeps === [], "expire=null must disable expired-job recovery completely");

	$retrying = new InspectableDatabaseConnector([
		"expire" => 120,
		"sweep_interval" => 30,
		"sweep_jitter" => 0,
	]);
	$retrying->failSweep = true;
	try {
		$retrying->pop();
		assertDatabaseQueue(false, "a failed expired-job recovery must propagate its database error");
	} catch (\RuntimeException $exception) {
		assertDatabaseQueue($exception->getMessage() === "simulated sweep failure", "the expected recovery error must be observed");
	}
	$retrying->failSweep = false;
	$retrying->pop();
	assertDatabaseQueue(count($retrying->sweeps) === 1, "a failed recovery must still start the throttle window");
	$retrying->now = 1029;
	$retrying->pop();
	assertDatabaseQueue(count($retrying->sweeps) === 1, "failed recovery must not be retried inside the throttle window");
	$retrying->now = 1030;
	$retrying->pop();
	assertDatabaseQueue(count($retrying->sweeps) === 2, "failed recovery must be retried after the throttle window");

	\think\Db::$rows = [
		["id" => 10, "queue" => "default", "reserved" => 0, "available_at" => 900],
		["id" => 20, "queue" => "default", "reserved" => 0, "available_at" => 800],
		["id" => 5, "queue" => "default", "reserved" => 0, "available_at" => 1100],
	];
	$connector->now = 1000;
	$nextJob = $connector->inspectNextAvailableJob("default");
	assertDatabaseQueue(
		\think\Db::$query->orders === [["id", "asc"]],
		"available jobs must preserve the vendor id ordering"
	);
	assertDatabaseQueue(
		$nextJob->id === 10,
		"an earlier retry must keep priority after it becomes available even when a later job became available first"
	);

	$config = require dirname(__DIR__) . "/app/config/queue.php";
	assertDatabaseQueue($config["connector"] === "app\\common\\queue\\DatabaseConnector", "queue config must use the application connector");
	assertDatabaseQueue($config["sweep_interval"] === 30, "the default expired-job sweep interval must remain 30 seconds");

	fwrite(STDOUT, "database queue connector regression checks passed" . PHP_EOL);
}
