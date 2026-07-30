<?php

namespace app\queue\job;

class SendMail extends \app\queue\common\JobCommon
{
	const QUEUE_NAME = "sendMail";
	public function fire(\think\queue\Job $job, $data)
	{
		try {
			$this->handle($data);
			$job->delete();
		} catch (\Throwable $e) {
			\think\facade\Log::record(static::class . " queue failed: " . $e->getMessage(), "error");
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
		$email = new \app\common\logic\Email();
		list($relid, $name, $type, $admin, $cc, $bcc, $msg, $attachments, $adminid, $ip) = [$data["relid"] ?? "", $data["name"] ?? "", $data["type"] ?? "", $data["admin"] ?? "", $data["cc"] ?? "", $data["bcc"] ?? "", $data["message"] ?? "", $data["attachments"] ?? "", $data["adminid"] ?? "", $data["ip"] ?? ""];
		return $email->sendEmailBaseFinal($relid, $name, $type, true, $admin, $cc, $bcc, $msg, $attachments, $adminid, $ip);
	}
	public function delaty(&$data)
	{
		$data["delaty"] = isset($data["delaty"]) ? $data["delaty"] + 1 : 1;
	}
}