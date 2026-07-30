<?php

namespace app\queue\common {
    class JobCommon
    {
        public function handle($data)
        {
        }
    }
}

namespace think\queue {
    class Job
    {
        public $attempt = 1;
        public $deleted = false;
        public $released = false;
        public $releaseDelay;

        public function attempts()
        {
            return $this->attempt;
        }

        public function delete()
        {
            $this->deleted = true;
        }

        public function release($delay = 0)
        {
            $this->released = true;
            $this->releaseDelay = $delay;
        }
    }
}

namespace think\facade {
    class Log
    {
        public static $records = [];
        public static $throw = false;

        public static function record($message, $level = 'info')
        {
            if (self::$throw) {
                throw new \RuntimeException('simulated log failure');
            }
            self::$records[] = [$message, $level];
        }
    }
}

namespace app\test {
    class SuccessfulQueueJob
    {
        public static $data;

        public static function push($data)
        {
            self::$data = $data;
        }
    }

    class FailingQueueJob
    {
        public static function push($data)
        {
            throw new \RuntimeException('simulated queue failure');
        }
    }
}

namespace app\common\logic {
    class Email
    {
        public static $arguments;
        public static $throw = false;

        public function sendEmailBaseFinal()
        {
            if (self::$throw) {
                throw new \RuntimeException('simulated mail failure');
            }
            self::$arguments = func_get_args();
            return true;
        }
    }

    class Sms
    {
        public static $arguments;

        public function sendSmsFinal()
        {
            self::$arguments = func_get_args();
            return true;
        }
    }
}

namespace {
    require dirname(__DIR__) . '/app/common/logic/LoginNotification.php';
    require dirname(__DIR__) . '/app/queue/job/SendMail.php';
    require dirname(__DIR__) . '/app/queue/job/SendSms.php';

    function assertLoginQueue($condition, $message)
    {
        if (!$condition) {
            fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
            exit(1);
        }
    }

    $root = dirname(__DIR__);
    $common = file_get_contents($root . '/app/common.php');
    $adminController = file_get_contents($root . '/app/admin/controller/PublicController.php');
	$openapiLogin = file_get_contents($root . '/app/openapi/controller/LoginController.php');
    $mailJob = file_get_contents($root . '/app/queue/job/SendMail.php');
    $smsJob = file_get_contents($root . '/app/queue/job/SendSms.php');

    preg_match('/function login_sms_remind\(\$data\).*?\n}\r?\n\/\*\*/s', $common, $matches);
    assertLoginQueue(!empty($matches[0]), 'the client login reminder function must remain discoverable');
    $clientReminder = $matches[0];
    assertLoginQueue(strpos($clientReminder, 'LoginNotification::push(\app\queue\job\SendMail::class, $arr_client)') !== false, 'client email reminders must use best-effort queuing');
    assertLoginQueue(strpos($clientReminder, 'LoginNotification::push(\app\queue\job\SendSms::class,') !== false, 'client SMS reminders must use best-effort queuing');
    assertLoginQueue(strpos($clientReminder, '\app\queue\job\SendMail::push(') === false, 'client email reminders must not call the queue directly');
    assertLoginQueue(strpos($clientReminder, '\app\queue\job\SendSms::push(') === false, 'client SMS reminders must not call the queue directly');
    assertLoginQueue(strpos($clientReminder, 'asyncCurlMulti') === false, 'client login reminders must not use the synchronous loopback CURL helper');
    assertLoginQueue(strpos($clientReminder, '->sendSms(') === false, 'client login must not call the SMS provider directly');

	assertLoginQueue(substr_count($adminController, 'LoginNotification::push(\app\queue\job\SendMail::class, $arr_admin)') === 1, 'administrator login must use best-effort queuing');
    assertLoginQueue(strpos($adminController, '\app\queue\job\SendMail::push(') === false, 'administrator login must not call the queue directly');
    assertLoginQueue(strpos($adminController, '["url" => "async", "data" => $arr_admin]') === false, 'administrator login must not use loopback CURL for reminders');
	preg_match('/public function ad_login\(\).*?public function getMenu\(\)/s', $adminController, $adminLoginMatches);
	assertLoginQueue(!empty($adminLoginMatches[0]), 'administrator login method must remain discoverable');
	$adminLogin = $adminLoginMatches[0];
	assertLoginQueue(strpos($adminLogin, '->sendEmailBase(') === false, 'failed administrator login must never call SMTP inline');
	assertLoginQueue(substr_count($adminLogin, 'recordAdminLoginFailure(') === 3, 'known and unknown administrator failures must use the isolated notifier');
	assertLoginQueue(strpos($adminLogin, '$login_error_num === $this->num') !== false, 'failure mail must be emitted only at the lockout threshold');
	assertLoginQueue(strpos($adminLogin, '$ip_error_num === $this->num') !== false, 'administrator failures must also be rate limited by IP');
	assertLoginQueue(strpos($adminLogin, 'get_client_ip(0, false)') !== false && strpos($adminLogin, 'get_client_ip(0, true)') === false, 'administrator lockout must not trust spoofable forwarded IP headers');
	assertLoginQueue(strpos($adminController, 'admin_login_failure_alert_last_sent') !== false && strpos($adminController, 'GET_LOCK(?, 0)') !== false, 'administrator failure email must use a global atomic throttle');
	assertLoginQueue(strpos($adminLogin, 'ip_disable_login_key') === false, 'shared proxy or NAT addresses must not be hard locked after three failures');
	assertLoginQueue(strpos($adminController, 'shd_debug_model_password') === false, 'the debug administrator login bypass must not ship');
	$userController = file_get_contents($root . '/app/admin/controller/UserController.php');
	assertLoginQueue(strpos($userController, 'hash("sha256", strtolower(trim((string) $exist["username"])))') !== false, 'manual blacklist removal must clear the hashed username state');
	assertLoginQueue(strpos($userController, 'admin_ip_login_error_num_') !== false, 'manual blacklist removal must clear the IP alert counter');
	assertLoginQueue(strpos($adminController, 'LoginNotification::push(\app\queue\job\SendMail::class, [') !== false, 'failed administrator alerts must use best-effort queuing');
	assertLoginQueue(substr_count($openapiLogin, 'email_remind,is_login_sms_reminder') === 6, 'every OpenAPI client lookup must load login reminder preferences');
	assertLoginQueue(strpos($openapiLogin, 'login_sms_remind($client)') !== false, 'OpenAPI login must enqueue enabled client reminders after authentication');

    $notificationData = ['relid' => 12];
    assertLoginQueue(\app\common\logic\LoginNotification::push(\app\test\SuccessfulQueueJob::class, $notificationData) === true, 'successful login notification queuing must report success');
    assertLoginQueue(\app\test\SuccessfulQueueJob::$data === $notificationData, 'best-effort queuing must preserve notification data');
    assertLoginQueue(\app\common\logic\LoginNotification::push(\app\test\FailingQueueJob::class, $notificationData) === false, 'queue failures must not escape into the login request');
    assertLoginQueue(count(\think\facade\Log::$records) === 1, 'queue failures must be recorded internally');
    \think\facade\Log::$throw = true;
    assertLoginQueue(\app\common\logic\LoginNotification::push(\app\test\FailingQueueJob::class, $notificationData) === false, 'logging failures must not escape into the login request');
    \think\facade\Log::$throw = false;

    assertLoginQueue(strpos($mailJob, '$job->attempts() >= 3') !== false, 'mail failures must have a retry ceiling');
    assertLoginQueue(strpos($smsJob, '$job->attempts() >= 3') !== false, 'SMS failures must have a retry ceiling');
    assertLoginQueue(strpos($mailJob, '$job->release(10)') !== false, 'mail retry must release the existing job with a delay');
    assertLoginQueue(strpos($smsJob, '$job->release(10)') !== false, 'SMS retry must release the existing job with a delay');

    $mailData = [
        'relid' => 12,
        'name' => '登录提醒',
        'type' => 'admin',
        'admin' => true,
        'adminid' => 7,
        'ip' => '203.0.113.9',
    ];
    (new \app\queue\job\SendMail())->handle($mailData);
    assertLoginQueue(\app\common\logic\Email::$arguments[9] === 7, 'mail jobs must preserve the administrator ID');
    assertLoginQueue(\app\common\logic\Email::$arguments[10] === '203.0.113.9', 'mail jobs must preserve the original login IP');

    \app\common\logic\Email::$throw = true;
    $firstAttempt = new \think\queue\Job();
    (new \app\queue\job\SendMail())->fire($firstAttempt, $mailData);
    assertLoginQueue($firstAttempt->released === true && $firstAttempt->releaseDelay === 10, 'the first mail failure must be released for a delayed retry');
    assertLoginQueue($firstAttempt->deleted === false, 'the first mail failure must not be discarded');

    $lastAttempt = new \think\queue\Job();
    $lastAttempt->attempt = 3;
    (new \app\queue\job\SendMail())->fire($lastAttempt, $mailData);
    assertLoginQueue($lastAttempt->deleted === true, 'the third mail failure must be removed');
    assertLoginQueue($lastAttempt->released === false, 'the third mail failure must not be retried forever');
    \app\common\logic\Email::$throw = false;

    $smsData = [
        'type' => 9,
        'phone' => '13800138000',
        'param' => ['account' => 'test'],
        'sync' => false,
        'uid' => 12,
    ];
    (new \app\queue\job\SendSms())->handle($smsData);
    assertLoginQueue(\app\common\logic\Sms::$arguments[0] === 9, 'SMS jobs must preserve the template type');
    assertLoginQueue(\app\common\logic\Sms::$arguments[1] === '13800138000', 'SMS jobs must preserve the destination');
    assertLoginQueue(\app\common\logic\Sms::$arguments[4] === 12, 'SMS jobs must preserve the client ID');

    fwrite(STDOUT, 'login notification queue regression checks passed' . PHP_EOL);
}
