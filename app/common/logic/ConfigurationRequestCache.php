<?php

namespace app\common\logic;

class ConfigurationRequestCache
{
    const WARM_ALL_THRESHOLD = 3;

    private static $items = [];
    private static $misses = 0;
    private static $complete = false;

    public static function has($setting)
    {
        return array_key_exists((string) $setting, self::$items);
    }

    public static function get($setting)
    {
        return self::$items[(string) $setting];
    }

    public static function put($setting, $value, $found = true)
    {
        self::$items[(string) $setting] = [
            'found' => (bool) $found,
            'value' => $value,
        ];
    }

    public static function shouldWarmAll($missingCount = 1)
    {
        if (self::$complete) {
            return false;
        }
        self::$misses += max(0, (int) $missingCount);
        return self::$misses >= self::WARM_ALL_THRESHOLD;
    }

    public static function isComplete()
    {
        return self::$complete;
    }

    public static function markComplete()
    {
        self::$complete = true;
    }

    public static function reset()
    {
        self::$items = [];
        self::$misses = 0;
        self::$complete = false;
    }
}
