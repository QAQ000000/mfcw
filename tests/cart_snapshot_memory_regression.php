<?php
// No database/upstream calls. Optional baseline: CART_SNAPSHOT_SOURCE_ROOT=/old/tree.
// php -d memory_limit=128M tests/cart_snapshot_memory_regression.php [large-cold|large-stale|large-hot]
// Optional SNAPSHOT_RESIDENT_MB simulates memory already occupied by the application.
namespace think {
    class Db
    {
        public static $queries = 0;
        public static function name($table) { return new SnapshotFixtureQuery(); }
    }
    class SnapshotFixtureQuery
    {
        private $currency = 1;
        public function __call($method, $arguments)
        {
            if (!in_array($method, ['alias', 'field', 'join', 'leftJoin', 'where', 'order'], true)) {
                throw new \RuntimeException('Unexpected query operation: ' . $method);
            }
            if ($method === 'leftJoin' && preg_match('/p\.currency=(\d+)/', $arguments[1], $match)) {
                $this->currency = (int) $match[1];
            }
            return $this;
        }
        public function cursor()
        {
            Db::$queries++;
            yield from \snapshotFixtureRows($this->currency);
        }
        public function select() { return new SnapshotFixtureCollection(iterator_to_array($this->cursor(), false)); }
    }
    class SnapshotFixtureCollection
    {
        private $rows;
        public function __construct($rows) { $this->rows = $rows; }
        public function toArray() { return $this->rows; }
    }
}
namespace {
    $sourceRoot = getenv('CART_SNAPSHOT_SOURCE_ROOT') ?: dirname(__DIR__);
    require $sourceRoot . '/vendor/thinkphp/library/think/cache/Driver.php';
    require $sourceRoot . '/vendor/thinkphp/library/think/cache/driver/File.php';
    require $sourceRoot . '/app/common/cache/AtomicFile.php';
    require $sourceRoot . '/app/common/logic/Cart.php';

    class SnapshotPriceCart extends \app\common\logic\Cart
    {
        // Fixture options have no linkage; production linkage code is unchanged.
        public function optionHandleLinkAgeLevel($data) { return $data; }
    }
    function snapshotAssert($condition, $message)
    {
        if (!$condition) { throw new \RuntimeException($message); }
    }
    function cache($key, $value = null, $ttl = null)
    {
        if (func_num_args() === 1) { return $GLOBALS['snapshotCache']->get($key); }
        snapshotAssert($GLOBALS['snapshotCache']->set($key, $value, $ttl), 'Cache write failed');
        return true;
    }
    function config($key) { return $GLOBALS['snapshotCycles']; }
    function getEdition() { return true; }
    function judgeQuantity($type) { return in_array($type, [4, 7, 9, 11, 14, 15, 16, 17, 18, 19]); }
    function judgeQuantityStage($type) { return in_array($type, [15, 16, 17, 18, 19]); }
    function judgeYesNo($type) { return $type == 3; }
    function resetSnapshotRequest()
    {
        foreach (['defaultConfigSnapshots' => [], 'defaultConfigSnapshotVersion' => null] as $name => $value) {
            $property = new \ReflectionProperty(\app\common\logic\Cart::class, $name);
            $property->setAccessible(true);
            $property->setValue(null, $value);
        }
    }
    function snapshotFixtureRows($currency)
    {
        $count = $GLOBALS['snapshotLarge'] ? 2318 : 6;
        for ($cid = 1; $cid <= $count; $cid++) {
            for ($sub = 0; $sub < 4; $sub++) {
                $type = [1, 4, 15, 3, 1, 1][($cid - 1) % 6];
                $row = [
                    'product_id' => $GLOBALS['snapshotLarge'] ? 1 + (($cid - 1) % 243) : 1,
                    'cid' => (string) $cid, 'option_type' => (string) $type,
                    'option_qty_minimum' => '2', 'is_discount' => '1',
                    'option_name' => 'fixture-' . $cid, 'is_rebate' => $cid % 2 ? '1' : '0',
                    'linkage_pid' => '0', 'linkage_top_pid' => '0',
                    'sub_id' => (string) ($cid * 10 + $sub), 'sub_hidden' => $sub === 0 ? '1' : '0',
                    'qty_minimum' => (string) ($sub * 2), 'qty_maximum' => (string) ($sub * 2 + 1),
                    'sub_sort_order' => (string) $sub, 'id' => (string) ($cid * 10 + $sub),
                    'relid' => $cid === 6 ? null : (string) ($cid * 10 + $sub),
                    'type' => 'configoptions', 'currency' => (string) $currency,
                ];
                foreach ($GLOBALS['snapshotCycles'] as $fields) {
                    // Use exact-sized PDO-like decimal strings, not sprintf's spare buffer.
                    $row[$fields[0]] = (string) ($currency * 10 + $sub) . '.00';
                    $row[$fields[1]] = (string) ($currency + $sub) . '.00';
                }
                yield $row;
                // Shared config groups repeat by product; pricing must deduplicate.
                if (!$GLOBALS['snapshotLarge']) { $row['product_id'] = 2; yield $row; }
            }
        }
    }
    $mode = $argv[1] ?? 'regression';
    snapshotAssert(in_array($mode, ['regression', 'large-cold', 'large-stale', 'large-hot', 'large-seed']), 'Invalid mode');
    $snapshotLarge = $mode !== 'regression';
    $residentMB = (int) (getenv('SNAPSHOT_RESIDENT_MB') ?: 0);
    snapshotAssert($residentMB >= 0 && $residentMB <= 64, 'Invalid resident memory size');
    $residentData = str_repeat('x', $residentMB * 1048576);
    $snapshotCycles = ['monthly' => ['monthly', 'msetupfee'], 'quarterly' => ['quarterly', 'qsetupfee'],
        'semiannually' => ['semiannually', 'ssetupfee'], 'annually' => ['annually', 'asetupfee'],
        'biennially' => ['biennially', 'bsetupfee'], 'triennially' => ['triennially', 'tsetupfee']];
    foreach (['four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'] as $cycle) {
        $snapshotCycles[$cycle . 'ly'] = [$cycle . 'ly', $cycle . 'setupfee'];
    }
    $snapshotCycles['hour'] = ['hour', 'hsetupfee'];
    $snapshotCycles['day'] = ['day', 'dsetupfee'];
    $snapshotCycles['onetime'] = ['onetime', 'osetupfee'];
    $snapshotCycles['ontrial'] = ['ontrial', 'ontrialfee'];
    $snapshotCacheDirectory = $mode === 'large-seed' ? ($argv[2] ?? '')
        : sys_get_temp_dir() . '/zjmf-snapshot-test-' . getmypid() . '-' . bin2hex(random_bytes(4));
    if ($mode !== 'large-seed') {
        snapshotAssert(mkdir($snapshotCacheDirectory, 0700), 'Cannot create test cache directory');
        register_shutdown_function(function () use ($snapshotCacheDirectory) {
            foreach (new \DirectoryIterator($snapshotCacheDirectory) as $file) {
                if ($file->isFile()) { unlink($file->getPathname()); }
            }
            rmdir($snapshotCacheDirectory);
        });
    } else {
        snapshotAssert(is_dir($snapshotCacheDirectory) && strpos(basename($snapshotCacheDirectory), 'zjmf-snapshot-test-') === 0, 'Invalid seed directory');
    }
    $snapshotCache = new \app\common\cache\AtomicFile(['path' => $snapshotCacheDirectory, 'cache_subdir' => false]);
    $cart = new SnapshotPriceCart();
    $method = new \ReflectionMethod(\app\common\logic\Cart::class, 'getDefaultConfigSnapshot');
    $method->setAccessible(true);
    cache('cart_catalog_snapshot_version', '1');
    if ($mode === 'large-stale' || $mode === 'large-hot') {
        // Seed in a different process to represent a previous request, not two rebuilds in one heap.
        $command = escapeshellarg(PHP_BINARY) . ' -d memory_limit=256M ' . escapeshellarg(__FILE__)
            . ' large-seed ' . escapeshellarg($snapshotCacheDirectory);
        $process = proc_open($command, [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
        snapshotAssert(is_resource($process), 'Cannot start isolated cache seed');
        fclose($pipes[0]);
        $seedOutput = stream_get_contents($pipes[1]);
        $seedError = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        snapshotAssert(proc_close($process) === 0, 'Cache seed failed: ' . $seedError . $seedOutput);
        if ($mode === 'large-stale') { cache('cart_catalog_snapshot_version', '2'); }
        \think\Db::$queries = 0;
    }
    $snapshot = $method->invoke($cart, ['id' => 1]);
    snapshotAssert(\think\Db::$queries === ($mode === 'large-hot' ? 0 : 1), 'Unexpected rebuild query count');
    snapshotAssert(count($snapshot['options_by_product']) === ($snapshotLarge ? 243 : 2), 'Product grouping changed');
    snapshotAssert(count($snapshot['pricing_by_option'][1]) === 4, 'Shared pricing duplicated');
    snapshotAssert($snapshot['default_pricing_by_option'][1]['relid'] === '11', 'Hidden default was selected');
    snapshotAssert(!isset($snapshot['default_pricing_by_option'][6]), 'Missing pricing gained a default');
    if ($mode === 'large-stale') { snapshotAssert($snapshot['version'] === '2', 'Stale version not replaced'); }
    $cacheFile = $snapshotCacheDirectory . '/' . md5('cart_default_config_snapshot_1') . '.php';
    $payloadBytes = filesize($cacheFile) - 32;
    // Hash the already-written payload as a stream without encoding the whole object again.
    $handle = fopen($cacheFile, 'rb');
    fseek($handle, 32);
    $hash = hash_init('sha256');
    hash_update_stream($hash, $handle);
    $digest = hash_final($hash);
    fclose($handle);
    unset($snapshot);
    if ($mode === 'regression') {
        foreach ([1, 2] as $currency) {
            foreach (array_keys($snapshotCycles) as $cycle) {
                foreach ([1, 2] as $pid) {
                    $rebate = $setup = 0;
                    $total = $cart->getProductDefaultConfigPrice($pid, $currency, $cycle, $rebate, $setup);
                    snapshotAssert($total == 64 * $currency + 9, 'Total price mismatch: ' . $total);
                    snapshotAssert($rebate == 43 * $currency + 6, 'Rebate mismatch: ' . $rebate);
                    snapshotAssert($setup == 4 * $currency + 4, 'Setup fee mismatch: ' . $setup);
                }
            }
        }
        $queries = \think\Db::$queries;
        resetSnapshotRequest();
        snapshotAssert(hash('sha256', json_encode($method->invoke($cart, 1))) === $digest, 'Warm cache changed snapshot');
        snapshotAssert(\think\Db::$queries === $queries, 'Warm cache unexpectedly queried database');
        cache('cart_catalog_snapshot_version', '2');
        $staleRebuilt = $method->invoke($cart, 1);
        snapshotAssert($staleRebuilt['version'] === '2', 'Stale snapshot not rebuilt');
        $staleRebuilt['version'] = '1';
        snapshotAssert(hash('sha256', json_encode($staleRebuilt)) === $digest, 'Rebuilt snapshot content changed');
    }
    fwrite(STDOUT, json_encode(['mode' => $mode, 'payload_bytes' => $payloadBytes,
        'resident_mb' => $residentMB, 'peak_bytes' => memory_get_peak_usage(true),
        'snapshot_sha256' => $digest, 'passed' => true]) . PHP_EOL);
}
