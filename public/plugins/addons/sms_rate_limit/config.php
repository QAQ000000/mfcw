<?php

return [
	"cooldown_seconds" => [
		"title" => "同一手机号冷却时间（秒）",
		"type" => "text",
		"value" => 60,
		"tip" => "所有短信验证码入口共用，范围 0-3600 秒，0 为不限",
	],
	"phone_daily_limit" => [
		"title" => "单手机号每日上限",
		"type" => "text",
		"value" => 10,
		"tip" => "范围 0-1000 次，0 为不限",
	],
	"global_minute_limit" => [
		"title" => "短信全站每分钟上限",
		"type" => "text",
		"value" => 100,
		"tip" => "范围 0-100000 次，0 为不限",
	],
	"global_daily_limit" => [
		"title" => "短信全站每日上限",
		"type" => "text",
		"value" => 2000,
		"tip" => "范围 0-1000000 次，0 为不限",
	],
	"email_cooldown_seconds" => [
		"title" => "同一邮箱冷却时间（秒）",
		"type" => "text",
		"value" => 60,
		"tip" => "所有邮件验证码入口共用，范围 0-3600 秒，0 为不限",
	],
	"email_daily_limit" => [
		"title" => "单邮箱每日上限",
		"type" => "text",
		"value" => 10,
		"tip" => "范围 0-1000 次，0 为不限",
	],
	"email_global_minute_limit" => [
		"title" => "邮件全站每分钟上限",
		"type" => "text",
		"value" => 100,
		"tip" => "范围 0-100000 次，0 为不限",
	],
	"email_global_daily_limit" => [
		"title" => "邮件全站每日上限",
		"type" => "text",
		"value" => 2000,
		"tip" => "范围 0-1000000 次，0 为不限",
	],
];
