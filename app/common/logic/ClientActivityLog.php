<?php

namespace app\common\logic;

use think\db\Query;

class ClientActivityLog
{
    private const INTERNAL_PREFIX = '[internal:';

    private static $structuredVisibility;

    private const SUPPLIER_API_TYPES = ['zjmf_api', 'resource', 'manual', 'whmcs'];

    private const LEGACY_INTERNAL_PATTERNS = [
        '购物车页面获取供应商\'%',
        '保存商品获取供应商\'%',
        '保存商品同步供应商\'%',
        '定时任务获取供应商\'%',
        '定时任务同步供应商\'%',
        '同步供应商\'%',
        '供应商\'%暂无商品需要同步%',
        '商品\'%原因:供应商\'%已删除该商品%',
        '%CURL ERROR:%',
        '%API%密钥%错误%',
        '%API%秘钥%错误%',
        '%购物车%同步%失败%',
    ];

    public static function applyVisibilityFilter(Query $query)
    {
        if (self::hasStructuredVisibility()) {
            $query->where('client_visible', 1);
        }
        $query->where('description', 'not like', self::INTERNAL_PREFIX . '%');
        $query->where('description', 'not like', 'Cron_' . self::INTERNAL_PREFIX . '%');
        foreach (self::LEGACY_INTERNAL_PATTERNS as $pattern) {
            $query->where('description', 'not like', $pattern);
            if (strpos($pattern, '%') !== 0) {
                $query->where('description', 'not like', 'Cron_' . $pattern);
            }
        }
        return $query;
    }

    public static function buildPaginationOrder($orderby, $sorting, $secondaryField)
    {
        $orderby = trim((string) $orderby);
        $sorting = trim((string) $sorting);
        $order = $orderby . ' ' . $sorting;
        $primaryField = trim(preg_replace('/^.*\./', '', $orderby), " `");
        if (strcasecmp($primaryField, 'id') !== 0) {
            $order .= ',' . $secondaryField . ' DESC';
        }
        return $order;
    }

    public static function isVisible($description, $clientVisible = 1)
    {
        if ((int) $clientVisible !== 1) {
            return false;
        }
        $description = (string) $description;
        $normalized = preg_replace('/^(?:Cron_)+/', '', $description);
        if (strpos($normalized, self::INTERNAL_PREFIX) === 0) {
            return false;
        }
        foreach (self::LEGACY_INTERNAL_PATTERNS as $pattern) {
            $regex = '/^' . str_replace('%', '.*', preg_quote($pattern, '/')) . '$/s';
            if (preg_match($regex, $normalized)) {
                return false;
            }
        }
        return true;
    }

    public static function prepareForStorage($description)
    {
        $description = (string) $description;
        if (preg_match('/^((?:Cron_)*)\[internal:[a-z0-9_-]+\](.*)$/is', $description, $matches)) {
            return [
                'description' => $matches[1] . $matches[2],
                'client_visible' => 0,
            ];
        }
        return [
            'description' => $description,
            'client_visible' => self::isVisible($description) ? 1 : 0,
        ];
    }

    public static function prepareForCurrentSchema($description)
    {
        if (self::hasStructuredVisibility()) {
            return self::prepareForStorage($description);
        }
        return ['description' => (string) $description];
    }

    public static function hookMetadata($description, $clientVisible = null)
    {
        $description = (string) $description;
        $normalized = preg_replace('/^(?:Cron_)+/', '', $description);
        $source = '';
        if (preg_match('/^\[internal:([a-z0-9_-]+)\]/i', $normalized, $matches)) {
            $source = strtolower($matches[1]);
        }
        if ($clientVisible === null) {
            $clientVisible = self::isVisible($description) ? 1 : 0;
        }
        return [
            'client_visible' => (int) $clientVisible,
            'source' => $source,
        ];
    }

    public static function hasStructuredVisibility()
    {
        if (self::$structuredVisibility !== null) {
            return self::$structuredVisibility;
        }
        if (!class_exists('\\think\\Db') || !function_exists('config')) {
            return self::$structuredVisibility = true;
        }
        try {
            $prefix = (string) (config('database.prefix') ?: 'shd_');
            if (!preg_match('/^[a-z0-9_]+$/i', $prefix)) {
                return self::$structuredVisibility = false;
            }
            $rows = \think\Db::query("SHOW COLUMNS FROM `{$prefix}activity_log` LIKE 'client_visible'");
            return self::$structuredVisibility = !empty($rows);
        } catch (\Throwable $e) {
            error_log('Failed to inspect activity log visibility schema: ' . $e->getMessage());
            return self::$structuredVisibility = false;
        }
    }

    public static function markInternal($description, $source)
    {
        $source = preg_replace('/[^a-z0-9_-]/i', '', (string) $source) ?: 'system';
        return self::INTERNAL_PREFIX . strtolower($source) . ']' . (string) $description;
    }

    public static function protectSupplierDescription($description, $apiType)
    {
        if (self::isSupplierApiType($apiType)) {
            return self::markInternal($description, 'supplier');
        }
        return $description;
    }

    public static function isSupplierApiType($apiType)
    {
        return in_array((string) $apiType, self::SUPPLIER_API_TYPES, true);
    }

    public static function clientSafeModuleError($message, $apiType, $isAdmin, $fallback)
    {
        if ($isAdmin || !self::isSupplierApiType($apiType)) {
            return (string) $message !== '' ? (string) $message : (string) $fallback;
        }
        return (string) $fallback;
    }
}
