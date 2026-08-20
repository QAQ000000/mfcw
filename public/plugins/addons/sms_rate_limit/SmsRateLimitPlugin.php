<?php

namespace addons\sms_rate_limit;

use app\admin\lib\Plugin;
use think\Db;

class SmsRateLimitPlugin extends Plugin
{
	public $hasAdmin = 1;

	public $info = [
		"name" => "SmsRateLimit",
		"title" => "验证码发送限流",
		"description" => "按手机号、邮箱地址和全站发送量限制短信及邮件验证码请求",
		"status" => 1,
		"author" => "MFCW",
		"version" => "1.1.0",
		"module" => "addons",
		"lang" => [
			"chinese" => "验证码发送限流",
			"chinese_tw" => "驗證碼發送限流",
			"english" => "Verification Code Rate Limit",
		],
	];

	public function install()
	{
		$table = $this->tableName();
		Db::execute("CREATE TABLE IF NOT EXISTS `{$table}` (
			`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`phone_hash` char(64) NOT NULL DEFAULT '',
			`create_time` int(10) unsigned NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			KEY `idx_phone_time` (`phone_hash`, `create_time`),
			KEY `idx_create_time` (`create_time`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		return true;
	}

	public function uninstall()
	{
		Db::execute("DROP TABLE IF EXISTS `{$this->tableName()}`");
		return true;
	}

	public function smsSendLimit($params)
	{
		if (($params["channel"] ?? "") === "email") {
			return $this->emailCodeSendLimit($params);
		}
		$phone = preg_replace("/[^0-9]/", "", trim((string) ($params["phone"] ?? "")));
		if ($phone === "") {
			return ["status" => 400, "msg" => "手机号格式错误"];
		}

		return $this->applyLimit("sms", $phone, [
			"cooldown" => ["cooldown_seconds", 60, 3600],
			"recipient_daily" => ["phone_daily_limit", 10, 1000],
			"global_minute" => ["global_minute_limit", 100, 100000],
			"global_daily" => ["global_daily_limit", 2000, 1000000],
		], [
			"busy" => "短信发送繁忙，请稍后重试",
			"cooldown" => "验证码已发送，请稍后再试",
			"recipient_daily" => "该手机号今日发送次数已达上限",
			"global_daily" => "今日短信发送量已达上限",
		]);
	}

	public function emailCodeSendLimit($params)
	{
		$email = strtolower(trim((string) ($params["email"] ?? "")));
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ["status" => 400, "msg" => "邮箱格式错误"];
		}

		return $this->applyLimit("email", $email, [
			"cooldown" => ["email_cooldown_seconds", 60, 3600],
			"recipient_daily" => ["email_daily_limit", 10, 1000],
			"global_minute" => ["email_global_minute_limit", 100, 100000],
			"global_daily" => ["email_global_daily_limit", 2000, 1000000],
		], [
			"busy" => "邮件验证码发送繁忙，请稍后重试",
			"cooldown" => "邮件验证码已发送，请稍后再试",
			"recipient_daily" => "该邮箱今日发送次数已达上限",
			"global_daily" => "今日邮件验证码发送量已达上限",
		]);
	}

	private function applyLimit($channel, $recipient, array $limitDefinitions, array $messages)
	{
		$config = $this->getConfig();
		$cooldown = $this->configuredLimit($config, $limitDefinitions["cooldown"]);
		$recipientDailyLimit = $this->configuredLimit($config, $limitDefinitions["recipient_daily"]);
		$globalMinuteLimit = $this->configuredLimit($config, $limitDefinitions["global_minute"]);
		$globalDailyLimit = $this->configuredLimit($config, $limitDefinitions["global_daily"]);
		$now = time();
		$today = strtotime(date("Y-m-d", $now));
		$channelPrefix = $channel === "email" ? "m" : "s";
		$recipientHash = $channelPrefix . substr(hash("sha256", $recipient), 1);
		$lockName = "mfcw_verification_rate_limit_" . $channelPrefix;
		$rows = Db::query("SELECT GET_LOCK(?, 0) AS `acquired`", [$lockName]);
		$acquired = intval($rows[0]["acquired"] ?? 0) === 1;
		if (!$acquired) {
			return ["status" => 400, "msg" => $messages["busy"]];
		}

		try {
			Db::name("sms_rate_limit_event")->where("create_time", "lt", $today - 86400)->delete();
			$lastSentAt = intval(Db::name("sms_rate_limit_event")->where("phone_hash", $recipientHash)->max("create_time"));
			if ($cooldown > 0 && $lastSentAt > 0 && $now - $lastSentAt < $cooldown) {
				return ["status" => 400, "msg" => $messages["cooldown"]];
			}
			$recipientDailyCount = Db::name("sms_rate_limit_event")->where("phone_hash", $recipientHash)->where("create_time", ">=", $today)->count();
			if ($recipientDailyLimit > 0 && $recipientDailyCount >= $recipientDailyLimit) {
				return ["status" => 400, "msg" => $messages["recipient_daily"]];
			}
			$globalMinuteCount = Db::name("sms_rate_limit_event")->where("phone_hash", "like", $channelPrefix . "%")->where("create_time", ">=", $now - 60)->count();
			if ($globalMinuteLimit > 0 && $globalMinuteCount >= $globalMinuteLimit) {
				return ["status" => 400, "msg" => $messages["busy"]];
			}
			$globalDailyCount = Db::name("sms_rate_limit_event")->where("phone_hash", "like", $channelPrefix . "%")->where("create_time", ">=", $today)->count();
			if ($globalDailyLimit > 0 && $globalDailyCount >= $globalDailyLimit) {
				return ["status" => 400, "msg" => $messages["global_daily"]];
			}
			Db::name("sms_rate_limit_event")->insert([
				"phone_hash" => $recipientHash,
				"create_time" => $now,
			]);
			return ["status" => 200, "msg" => "success"];
		} catch (\Throwable $e) {
			trace("VerificationCodeRateLimit failed: " . $e->getMessage(), "error");
			return ["status" => 400, "msg" => $messages["busy"]];
		} finally {
			Db::query("SELECT RELEASE_LOCK(?)", [$lockName]);
		}
	}

	private function configuredLimit(array $config, array $definition)
	{
		return $this->limitValue($config, $definition[0], $definition[1], 0, $definition[2]);
	}

	private function limitValue(array $config, $key, $default, $minimum, $maximum)
	{
		$value = isset($config[$key]) ? intval($config[$key]) : $default;
		return min($maximum, max($minimum, $value));
	}

	private function tableName()
	{
		$prefix = (string) Db::getConfig("prefix");
		if (!preg_match("/^[a-zA-Z0-9_]*$/", $prefix)) {
			throw new \RuntimeException("Invalid database table prefix");
		}
		return $prefix . "sms_rate_limit_event";
	}
}
