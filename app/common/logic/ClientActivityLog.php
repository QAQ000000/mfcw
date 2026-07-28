<?php

namespace app\common\logic;

use think\db\Query;

class ClientActivityLog
{
    private const INTERNAL_PREFIX = '[internal:';

    private const LEGACY_INTERNAL_PATTERNS = [
        '购物车页面获取供应商\'%',
        '保存商品获取供应商\'%',
        '定时任务获取供应商\'%',
        '定时任务同步供应商\'%',
        '同步供应商\'%',
        '供应商\'%暂无商品需要同步%',
        '商品\'%原因:供应商\'%已删除该商品%',
    ];

    public static function applyVisibilityFilter(Query $query)
    {
        $query->where('description', 'not like', self::INTERNAL_PREFIX . '%');
        foreach (self::LEGACY_INTERNAL_PATTERNS as $pattern) {
            $query->where('description', 'not like', $pattern);
        }
        return $query;
    }

    public static function isVisible($description)
    {
        $description = (string) $description;
        if (strpos($description, self::INTERNAL_PREFIX) === 0) {
            return false;
        }
        foreach (self::LEGACY_INTERNAL_PATTERNS as $pattern) {
            $regex = '/^' . str_replace('%', '.*', preg_quote($pattern, '/')) . '$/s';
            if (preg_match($regex, $description)) {
                return false;
            }
        }
        return true;
    }

    public static function markInternal($description, $source)
    {
        $source = preg_replace('/[^a-z0-9_-]/i', '', (string) $source) ?: 'system';
        return self::INTERNAL_PREFIX . strtolower($source) . ']' . (string) $description;
    }

    public static function protectSupplierDescription($description, $apiType)
    {
        if (in_array((string) $apiType, ['zjmf_api', 'resource', 'manual', 'whmcs'], true)) {
            return self::markInternal($description, 'supplier');
        }
        return $description;
    }
}
