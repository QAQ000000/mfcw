<?php

namespace tests {
    class ResultSet
    {
        private $rows;

        public function __construct(array $rows)
        {
            $this->rows = $rows;
        }

        public function toArray()
        {
            return $this->rows;
        }
    }

    class ConfigurationQuery
    {
        private $settings = [];
        private $setting;

        public function field($fields)
        {
            return $this;
        }

        public function whereIn($field, array $settings)
        {
            $this->settings = $settings;
            return $this;
        }

        public function whereRaw($sql, array $bindings)
        {
            $this->setting = $bindings['setting'];
            return $this;
        }

        public function select()
        {
            \think\Db::$selectQueries++;
            \think\Db::$lastBatch = $this->settings;
            $rows = [];
            $settings = empty($this->settings) ? array_keys(\think\Db::$rows) : $this->settings;
            foreach ($settings as $setting) {
                if (array_key_exists($setting, \think\Db::$rows)) {
                    $rows[] = ['setting' => $setting, 'value' => \think\Db::$rows[$setting]];
                }
            }
            return new ResultSet($rows);
        }

        public function find()
        {
            \think\Db::$findQueries++;
            if (!array_key_exists($this->setting, \think\Db::$rows)) {
                return null;
            }
            return ['setting' => $this->setting, 'value' => \think\Db::$rows[$this->setting]];
        }

        public function update(array $data)
        {
            \think\Db::$rows[$this->setting] = $data['value'];
            return 1;
        }

        public function insertGetId(array $data)
        {
            \think\Db::$rows[$data['setting']] = $data['value'];
            return count(\think\Db::$rows);
        }
    }

    class Request
    {
        public $controller = 'Index';
        public $action = 'index';

        public function controller()
        {
            return $this->controller;
        }

        public function action()
        {
            return $this->action;
        }
    }
}

namespace think {
    class Db
    {
        public static $rows = [];
        public static $findQueries = 0;
        public static $selectQueries = 0;
        public static $lastBatch = [];

        public static function name($table)
        {
            return new \tests\ConfigurationQuery();
        }
    }
}

namespace think\facade {
    class Cookie
    {
        public static $values = [];

        public static function get($key)
        {
            return self::$values[$key] ?? null;
        }
    }
}

namespace {
    require dirname(__DIR__) . '/app/common/logic/ConfigurationRequestCache.php';

    $testRequest = new \tests\Request();

    function request()
    {
        global $testRequest;
        return $testRequest;
    }

    function assertConfigurationCache($condition, $message)
    {
        if (!$condition) {
            fwrite(STDERR, 'FAIL: ' . $message . PHP_EOL);
            exit(1);
        }
    }

    $source = file_get_contents(dirname(__DIR__) . '/app/common.php');
    preg_match('/function configuration\(\$config, \$default = \[\]\).*?(?=function updateConfiguration)/s', $source, $configurationFunction);
    preg_match('/function updateConfiguration\(\$setting, \$value\).*?(?=function clearCartIndexResponseCache)/s', $source, $updateFunction);
    assertConfigurationCache(!empty($configurationFunction[0]), 'configuration() must remain discoverable');
    assertConfigurationCache(!empty($updateFunction[0]), 'updateConfiguration() must remain discoverable');
    eval($configurationFunction[0] . $updateFunction[0]);

    \think\Db::$rows = [
        'alpha' => 'one',
        'beta' => 'two',
        'nullable' => null,
        'is_captcha' => '0',
        'login_error_switch' => '1',
        'login_error_max_num' => '3',
    ];
    \app\common\logic\ConfigurationRequestCache::reset();

    assertConfigurationCache(configuration('alpha') === 'one', 'scalar configuration must return its raw value');
    assertConfigurationCache(configuration('alpha') === 'one', 'cached scalar configuration must remain stable');
    assertConfigurationCache(\think\Db::$findQueries === 1, 'repeated scalar reads must issue one SELECT');

    $batch = configuration(['alpha', 'beta']);
    assertConfigurationCache(
        $batch === ['alpha' => 'one', 'beta' => 'two'],
        'array reads must combine scalar cache hits with newly fetched values'
    );
    assertConfigurationCache(
        \think\Db::$lastBatch === ['beta'],
        'array reads must query only settings missing from the request cache'
    );
    assertConfigurationCache(\think\Db::$selectQueries === 1, 'the first array read must use one batch SELECT');

    configuration(['alpha', 'beta']);
    assertConfigurationCache(\think\Db::$selectQueries === 1, 'cached array reads must not repeat the batch SELECT');

    \app\common\logic\ConfigurationRequestCache::reset();
    $selectQueries = \think\Db::$selectQueries;
    $batch = configuration(['missing', 'nullable']);
    assertConfigurationCache($batch === ['nullable' => null], 'array reads must preserve NULL values and omit missing rows');
    assertConfigurationCache(\think\Db::$lastBatch === ['missing', 'nullable'], 'array misses below the threshold must share one SELECT');
    assertConfigurationCache(\think\Db::$selectQueries === $selectQueries + 1, 'the missing and NULL batch must issue one SELECT');
    $findQueries = \think\Db::$findQueries;
    assertConfigurationCache(configuration('missing') === null, 'missing scalar settings must return null');
    assertConfigurationCache(\think\Db::$findQueries === $findQueries, 'negative cache entries must prevent repeated SELECTs');

    updateConfiguration('alpha', 'updated');
    $findQueries = \think\Db::$findQueries;
    assertConfigurationCache(configuration('alpha') === 'updated', 'writes must refresh the request cache');
    assertConfigurationCache(\think\Db::$findQueries === $findQueries, 'write-through cache reads must not query again');

    $testRequest->controller = 'ViewClients';
    $testRequest->action = 'login';
    \think\facade\Cookie::$values['login_error_log'] = 4;
    \app\common\logic\ConfigurationRequestCache::reset();
    $queriesBeforeCaptcha = \think\Db::$findQueries;
    $selectsBeforeCaptcha = \think\Db::$selectQueries;
    assertConfigurationCache(configuration('is_captcha') === 1, 'login failures must still dynamically force captcha on');
    $queriesAfterCaptcha = \think\Db::$findQueries;
    $selectsAfterCaptcha = \think\Db::$selectQueries;
    assertConfigurationCache($queriesAfterCaptcha === $queriesBeforeCaptcha + 2, 'captcha evaluation must read only before reaching the warm threshold');
    assertConfigurationCache($selectsAfterCaptcha === $selectsBeforeCaptcha + 1, 'captcha evaluation must warm the full snapshot at the threshold');

    \think\facade\Cookie::$values['login_error_log'] = 0;
    assertConfigurationCache(configuration('is_captcha') === '0', 'dynamic captcha logic must run after reading the cached raw value');
    assertConfigurationCache(\think\Db::$findQueries === $queriesAfterCaptcha, 'dynamic captcha reevaluation must reuse raw settings');
    assertConfigurationCache(\think\Db::$selectQueries === $selectsAfterCaptcha, 'dynamic captcha reevaluation must reuse the full snapshot');

    $testRequest->controller = 'Index';
    $testRequest->action = 'index';
    \app\common\logic\ConfigurationRequestCache::reset();
    \think\Db::$findQueries = 0;
    \think\Db::$selectQueries = 0;
    for ($index = 1; $index <= 10; $index++) {
        \think\Db::$rows['warm_' . $index] = (string) $index;
    }
    for ($index = 1; $index <= 2; $index++) {
        assertConfigurationCache(configuration('warm_' . $index) === (string) $index, 'pre-threshold scalar reads must remain correct');
    }
    assertConfigurationCache(\think\Db::$findQueries === 2, 'small request workloads must continue using scalar SELECTs');
    assertConfigurationCache(configuration('warm_3') === '3', 'the threshold read must be returned from the full snapshot');
    assertConfigurationCache(\think\Db::$selectQueries === 1, 'the threshold must trigger one full configuration SELECT');
    assertConfigurationCache(configuration('warm_9') === '9', 'the full snapshot must serve subsequent known settings');
    assertConfigurationCache(configuration('unknown_after_warm') === null, 'the full snapshot must serve subsequent missing settings');
    assertConfigurationCache(\think\Db::$findQueries === 2, 'the complete snapshot must prevent further scalar SELECTs');
    assertConfigurationCache(\think\Db::$selectQueries === 1, 'the complete snapshot must not be reloaded');

    $jobCommon = file_get_contents(dirname(__DIR__) . '/app/queue/common/JobCommon.php');
    assertConfigurationCache(
        strpos($jobCommon, 'ConfigurationRequestCache::reset()') !== false,
        'long-running queue workers must reset request-scoped configuration state for every job'
    );

    $systemController = file_get_contents(dirname(__DIR__) . '/app/admin/controller/SystemController.php');
    assertConfigurationCache(
        strpos($systemController, 'updateConfiguration("system_license", $license)') !== false,
        'license replacement must update the request cache before compareLicense reads it'
    );
    assertConfigurationCache(
        strpos($source, 'ConfigurationRequestCache::put($key, $token)') !== false,
        'system token creation must populate the request cache before the installer reads it'
    );

    fwrite(STDOUT, 'configuration request cache regression checks passed' . PHP_EOL);
}
