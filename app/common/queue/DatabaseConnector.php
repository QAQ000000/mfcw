<?php

namespace app\common\queue;

use think\Db;
use think\queue\connector\Database;
use think\queue\job\Database as DatabaseJob;

class DatabaseConnector extends Database
{
	protected $nextSweepAt = [];

	public function __construct(array $options)
	{
		$options += [
			"sweep_interval" => 30,
			"sweep_jitter" => 5,
		];
		parent::__construct($options);
	}

	public function pop($queue = null)
	{
		$queue = $this->getQueue($queue);

		if (!is_null($this->options["expire"]) && $this->shouldSweepExpiredJobs($queue)) {
			try {
				$this->releaseJobsThatHaveBeenReservedTooLong($queue);
			} finally {
				$this->scheduleNextSweep($queue);
			}
		}

		if ($job = $this->getNextAvailableJob($queue)) {
			$this->markJobAsReserved($job->id);
			Db::commit();

			return new DatabaseJob($this, $job, $queue);
		}

		Db::commit();
	}

	protected function shouldSweepExpiredJobs($queue)
	{
		$now = $this->currentTime();
		return !isset($this->nextSweepAt[$queue]) || $this->nextSweepAt[$queue] <= $now;
	}

	protected function scheduleNextSweep($queue)
	{
		$interval = max(0, (int) $this->options["sweep_interval"]);
		$this->nextSweepAt[$queue] = $this->currentTime() + $interval + $this->sweepJitter($queue);
	}

	protected function sweepJitter($queue)
	{
		$maximum = max(0, (int) $this->options["sweep_jitter"]);
		if ($maximum === 0) {
			return 0;
		}

		$worker = function_exists("getmypid") ? (int) getmypid() : 0;
		$hash = crc32((string) $queue . ":" . $worker) & 0x7fffffff;
		return $hash % ($maximum + 1);
	}

	protected function currentTime()
	{
		return time();
	}

	protected function getNextAvailableJob($queue)
	{
		Db::startTrans();

		$job = Db::name($this->options["table"])
			->lock(true)
			->where("queue", $this->getQueue($queue))
			->where("reserved", 0)
			->where("available_at", "<=", $this->currentTime())
			->order("id", "asc")
			->find();

		return $job ? (object) $job : null;
	}
}
