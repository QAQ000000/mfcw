<?php

namespace think\console {
    class Command
    {
    }
}

namespace {

require dirname(__DIR__) . '/app/admin/command/Cron.php';

function assertDailyCronSchedule($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }
}

$cron = (new \ReflectionClass(\app\admin\command\Cron::class))->newInstanceWithoutConstructor();
$method = new \ReflectionMethod($cron, 'shouldRunDailyCron');
$method->setAccessible(true);
$invoke = function ($last, $hour, $now) use ($cron, $method) {
    return $method->invoke($cron, $last, $hour, $now);
};

$previousDay = strtotime('2026-08-01 01:00:02');
assertDailyCronSchedule($invoke($previousDay, 1, strtotime('2026-08-02 01:00:01')) === true, 'a one-second schedule drift must not skip the next calendar day');
assertDailyCronSchedule($invoke($previousDay, 1, strtotime('2026-08-02 01:15:01')) === true, 'daily cron must catch up after the old 15-minute window');
assertDailyCronSchedule($invoke(0, 1, strtotime('2026-08-02 00:59:59')) === false, 'daily cron must wait until the configured start hour');
assertDailyCronSchedule($invoke(strtotime('2026-08-02 01:00:01'), 1, strtotime('2026-08-02 12:00:00')) === false, 'daily cron must run at most once per calendar day');

echo "cron_daily_schedule_regression: ok\n";

}
