<?php

namespace app\common\logic;

class LoginNotification
{
    public static function push($jobClass, array $data)
    {
        try {
            $jobClass::push($data);
            return true;
        } catch (\Throwable $e) {
            try {
                \think\facade\Log::record(
                    'Login notification enqueue failed (' . $jobClass . '): ' . $e->getMessage(),
                    'error'
                );
            } catch (\Throwable $logError) {
            }
            return false;
        }
    }
}
