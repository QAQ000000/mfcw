<?php

namespace think {
    class Db
    {
        public static $columns = [['Field' => 'client_visible']];

        public static function query($sql)
        {
            return self::$columns;
        }
    }
}

namespace think\db {
    class Query
    {
        public $conditions = [];

        public function where($field, $operator = null, $value = null)
        {
            $this->conditions[] = [$field, $operator, $value];
            return $this;
        }
    }
}

namespace {
    require dirname(__DIR__) . '/app/common/logic/ClientActivityLog.php';

    use app\common\logic\ClientActivityLog;
    use think\Db;
    use think\db\Query;

    function config($key)
    {
        return $key === 'database.prefix' ? 'shd_' : null;
    }

    function assertLogCondition($condition, $message)
    {
        if (!$condition) {
            fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
            exit(1);
        }
    }

    function assertSourceContains($relativePath, $needle, $message)
    {
        $source = file_get_contents(dirname(__DIR__) . '/' . $relativePath);
        assertLogCondition(strpos($source, $needle) !== false, $message);
    }

    function assertSourceMatches($relativePath, $pattern, $message)
    {
        $source = file_get_contents(dirname(__DIR__) . '/' . $relativePath);
        assertLogCondition((bool) preg_match($pattern, $source), $message);
    }

    $query = new Query();
    ClientActivityLog::applyVisibilityFilter($query);
    assertLogCondition(
        $query->conditions[0] === ['client_visible', 1, null],
        'client queries must start with the structured visibility field'
    );

    Db::$columns = [];
    $structuredVisibility = new \ReflectionProperty(ClientActivityLog::class, 'structuredVisibility');
    $structuredVisibility->setAccessible(true);
    $structuredVisibility->setValue(null, null);
    $legacySchemaQuery = new Query();
    ClientActivityLog::applyVisibilityFilter($legacySchemaQuery);
    assertLogCondition(
        !in_array(['client_visible', 1, null], $legacySchemaQuery->conditions, true),
        'old schemas must not query a column that has not been migrated yet'
    );
    $legacySchemaInternal = ClientActivityLog::prepareForCurrentSchema(
        ClientActivityLog::markInternal('上游原始错误', 'supplier')
    );
    assertLogCondition(
        $legacySchemaInternal === ['description' => '[internal:supplier]上游原始错误'],
        'old-schema writers must retain the inline marker until the structured column exists'
    );
    Db::$columns = [['Field' => 'client_visible']];
    $structuredVisibility->setValue(null, null);

    assertLogCondition(
        ClientActivityLog::isVisible('普通日志：请联系供应商处理') === true,
        'ordinary business text containing supplier must remain visible'
    );
    assertLogCondition(
        ClientActivityLog::isVisible('模块命令:开机失败 - 原因:本地模块拒绝操作') === true,
        'legacy local module failures must remain visible'
    );
    assertLogCondition(
        ClientActivityLog::isVisible('模块命令:开机失败 - 原因:CURL ERROR: timeout') === false,
        'raw transport failures must remain hidden'
    );
    assertLogCondition(
        ClientActivityLog::isVisible('普通日志', 0) === false,
        'the structured visibility field must override description text'
    );

    $internal = ClientActivityLog::prepareForStorage(
        ClientActivityLog::markInternal('上游原始错误', 'supplier')
    );
    assertLogCondition($internal['description'] === '上游原始错误', 'inline marker must not be stored');
    assertLogCondition($internal['client_visible'] === 0, 'internal marker must set structured visibility');

    $hookMetadata = ClientActivityLog::hookMetadata(
        ClientActivityLog::markInternal('上游原始错误', 'supplier'),
        $internal['client_visible']
    );
    assertLogCondition($hookMetadata === ['client_visible' => 0, 'source' => 'supplier'], 'log hooks must receive structured supplier visibility');
    assertLogCondition(
        ClientActivityLog::hookMetadata('普通日志') === ['client_visible' => 1, 'source' => ''],
        'ordinary log hooks must remain client visible without an internal source'
    );

    $cronInternal = ClientActivityLog::prepareForStorage(
        'Cron_' . ClientActivityLog::markInternal('同步失败', 'supplier')
    );
    assertLogCondition($cronInternal['description'] === 'Cron_同步失败', 'Cron prefix must be preserved');
    assertLogCondition($cronInternal['client_visible'] === 0, 'Cron internal log must remain hidden');

    $legacy = ClientActivityLog::prepareForStorage('API 访问密钥错误');
    assertLogCondition($legacy['client_visible'] === 0, 'legacy API credential errors must be structured');

    foreach (['zjmf_api', 'resource', 'manual', 'whmcs'] as $apiType) {
        assertLogCondition(ClientActivityLog::isSupplierApiType($apiType), $apiType . ' must be protected');
        assertLogCondition(
            ClientActivityLog::clientSafeModuleError('raw supplier error', $apiType, false, '操作失败') === '操作失败',
            $apiType . ' raw error must not reach a customer'
        );
    }
    assertLogCondition(
        ClientActivityLog::clientSafeModuleError('raw supplier error', 'whmcs', true, '操作失败') === 'raw supplier error',
        'administrators must retain the diagnostic error'
    );
    assertLogCondition(
        ClientActivityLog::clientSafeModuleError('local module error', 'normal', false, '操作失败') === 'local module error',
        'local module behavior must remain compatible'
    );

    $migrationSource = file_get_contents(dirname(__DIR__) . '/public/upgrade/3.5.8.1.sql');
    assertLogCondition(
        strpos($migrationSource, 'NOT NULL DEFAULT 0') !== false,
        'new and old writers must fail closed after the visibility column is added'
    );
    assertLogCondition(
        substr_count($migrationSource, 'WHERE `id` <= @activity_log_legacy_cutoff_id') >= 2,
        'ambiguous historical module diagnostics must default to internal'
    );
    assertLogCondition(
        strpos($migrationSource, "'_activity_log_visibility_cutoff_id'") !== false
            && strpos($migrationSource, '@saved_activity_log_cutoff_id') !== false
            && strpos($migrationSource, '@activity_log_legacy_cutoff_id') !== false,
        'migration reruns must preserve the first legacy-row boundary'
    );
    assertLogCondition(
        strpos($migrationSource, 'SET `activity`.`client_visible` = 1') === false,
        'historical source type must not be inferred from a host current product'
    );
    assertLogCondition(
        strpos($migrationSource, "GET_LOCK('_migration_20260729_activity_visibility', 30)") !== false
            && strpos($migrationSource, "RELEASE_LOCK('_migration_20260729_activity_visibility')") !== false,
        'cutoff creation and backfill must be serialized'
    );
    $snapshot = strpos($migrationSource, 'SET @activity_log_snapshot_id');
    $columnDdl = strpos($migrationSource, 'ADD COLUMN `client_visible`');
    assertLogCondition(
        $snapshot !== false && $columnDdl !== false && $snapshot < $columnDdl,
        'the old-schema row boundary must be captured before adding the fail-closed column'
    );
    assertLogCondition(
        strpos($migrationSource, 'WHERE `id` <= \'') !== false
            && strpos($migrationSource, '@activity_log_snapshot_id') !== false,
        'only rows present before the DDL snapshot may be backfilled as visible'
    );
    assertLogCondition(
        strpos($migrationSource, "TRIM(' `shd_activity_log`')") !== false
            && strpos($migrationSource, 'TABLE_NAME = @activity_log_table') !== false,
        'the migration must use the upgrade runner-compatible dynamic table prefix'
    );
    assertSourceContains(
        'public/upgrade/upgrade.log',
        '3.5.8.1,客户日志可见性与缓存一致性补丁,3.5.8.1.sql',
        'the visibility migration must be wired into the actual upgrade chain'
    );
    assertSourceContains(
        'app/api/controller/UpgradeSystemController.php',
        'Database upgrade postcondition failed: activity_log.client_visible DEFAULT 0 is missing',
        'the API upgrade runner must refuse to advance the version after a failed migration'
    );
    assertSourceContains(
        'public/upgrade/upgrade.php',
        'PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION',
        'the manual upgrade runner must throw on SQL errors'
    );

    assertSourceContains(
        'app/common/logic/Host.php',
        '"is_admin" => $this->is_admin',
        'queued provisioning must preserve the caller visibility context'
    );
    assertSourceContains(
        'app/queue/job/AutoCreate.php',
        '$host_logic->is_admin = !empty($data["is_admin"]);',
        'old queue jobs must default to client-safe errors without notices'
    );
    assertSourceContains(
        'app/queue/job/AutoCreate.php',
        '$data_i["active_type_param"] = [$data["hid"], $ip];',
        'old queue jobs without an IP must use the normalized local value'
    );
    assertSourceContains(
        'app/admin/controller/PublicController.php',
        '$host_logic->is_admin = !empty($data["is_admin"]);',
        'legacy async HTTP jobs must default to client-safe errors without notices'
    );
    assertSourceMatches(
        'app/admin/controller/OrderController.php',
        '~public function active\(\).*?new \\\\app\\\\common\\\\logic\\\\Host\(\);\s*\$host_model->is_admin = true;~s',
        'manual order activation must retain diagnostics for administrators'
    );
    assertSourceMatches(
        'app/admin/command/Cron.php',
        '~public function cancellations\(\).*?new \\\\app\\\\common\\\\logic\\\\Host\(\);\s*\$host_logic->is_admin = true;~s',
        'cron operations must retain diagnostics in internal run maps'
    );
    assertSourceContains(
        'app/admin/command/Cron.php',
        '"is_admin" => true, "ip" => ""',
        'cron async provisioning must retain its administrator context'
    );
    $invoiceSource = file_get_contents(dirname(__DIR__) . '/app/common/logic/Invoices.php');
    assertLogCondition(
        substr_count($invoiceSource, '$Host->is_admin = $this->is_admin;') >= 2,
        'invoice-triggered host actions must propagate the administrator context'
    );
    assertSourceMatches(
        'app/common/logic/Upgrade.php',
        '~public function upgradeConfigAdmin\(.*?new Host\(\);\s*\$host_logic->is_admin = true;~s',
        'administrator configuration upgrades must retain supplier diagnostics'
    );
    assertSourceContains(
        'app/common/logic/Upgrade.php',
        '$host_logic->is_admin = $this->is_admin;',
        'invoice-triggered upgrades must propagate their visibility context'
    );
    assertSourceMatches(
        'app/common/logic/Invoices.php',
        '~elseif \(\$type == "upgrade"\).*?\$upgrade_logic->is_admin = \$this->is_admin;\s*\$upgrade_logic->doUpgrade~s',
        'paid upgrade invoices must pass the administrator context into Upgrade'
    );
    assertSourceContains(
        'app/common/logic/Invoices.php',
        '"is_admin" => $this->is_admin',
        'queued invoice processing must preserve the caller visibility context'
    );
    assertSourceContains(
        'app/common/logic/Invoices.php',
        '"is_admin" => $this->is_admin, "ip" => $ip',
        'queued invoice processing must preserve the caller IP context'
    );
    assertSourceContains(
        'app/queue/job/InvoicePaid.php',
        '$invoice->is_admin = !empty($data["is_admin"]);',
        'old invoice jobs must restore a safe default visibility context'
    );
    $adminInvoiceSource = file_get_contents(dirname(__DIR__) . '/app/admin/controller/InvoiceController.php');
    assertLogCondition(
        substr_count($adminInvoiceSource, '$invoice_logic->is_admin = true;') >= 2,
        'administrator invoice payment paths must retain supplier diagnostics'
    );
    assertSourceContains(
        'app/admin/controller/OrderController.php',
        '["hid" => $hh, "is_admin" => true, "ip" => get_client_ip6()]',
        'zero-value administrator orders must retain diagnostics during async provisioning'
    );
    assertSourceContains(
        'app/api/controller/HostController.php',
        'ClientActivityLog::markInternal($description, "supplier")',
        'supplier push callbacks must never expose detailed provisioning logs'
    );
    assertSourceContains(
        'app/common/logic/Host.php',
        '$settlementResult = $this->syncResourceUpgradeSettlement(',
        'resource settlement synchronization must not overwrite module success state'
    );
    assertSourceContains(
        'app/home/controller/UserController.php',
        'ClientActivityLog::applyVisibilityFilter($query);',
        'the client login-log endpoint must enforce structured visibility'
    );
    assertSourceContains(
        'app/openapi/controller/LogController.php',
        'ClientActivityLog::applyVisibilityFilter($query);',
        'the OpenAPI login-log endpoint must enforce structured visibility'
    );
    foreach (['app/common.php', 'app/common/logic/Log.php'] as $logWriter) {
        assertSourceContains(
            $logWriter,
            'ClientActivityLog::hookMetadata',
            $logWriter . ' must pass structured visibility to log hooks'
        );
        assertSourceContains(
            $logWriter,
            'array_merge(["description" => $hook',
            $logWriter . ' must preserve the marked description for legacy hook filters'
        );
    }

    fwrite(STDOUT, 'client activity log regression checks passed' . PHP_EOL);
}
