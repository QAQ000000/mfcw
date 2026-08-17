<?php

$testRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "zjmf-cart-cache-test-" . getmypid();
define("CMF_DATA", $testRoot . DIRECTORY_SEPARATOR);

require dirname(__DIR__) . "/app/common/logic/Product.php";

class CartCacheTestClientActivityLog
{
	public static function markInternal($description, $source)
	{
		return $description;
	}
}
class_alias("CartCacheTestClientActivityLog", "app\\common\\logic\\ClientActivityLog");

if (!function_exists("active_log_final")) {
	function active_log_final($description, $userid = 0, $type = 0)
	{
		return true;
	}
}

class TestableCartProductLogic extends \app\common\logic\Product
{
	public $existingProductIds = [];

	protected function findDeletedProductIds($pids)
	{
		$existing = array_fill_keys(array_map("intval", $this->existingProductIds), true);
		$deleted = [];
		foreach (array_unique(array_map("intval", (array) $pids)) as $pid) {
			if ($pid > 0 && !isset($existing[$pid])) {
				$deleted[] = $pid;
			}
		}
		sort($deleted, SORT_NUMERIC);
		return $deleted;
	}

	public function acquire($pid, $lease)
	{
		return $this->acquireCartSyncLock($pid, $lease);
	}

	public function release($lock)
	{
		return $this->releaseCartSyncLock($lock);
	}

	public function acquireCatalog()
	{
		return $this->acquireCatalogCacheLock();
	}

	public function releaseAny($lock)
	{
		return $this->releaseFileLock($lock);
	}
}

class FailingCronCacheProductLogic extends \app\common\logic\Product
{
	public $updateAttempts = 0;
	public $invalidateAttempts = 0;

	public function updateCache($pids = [])
	{
		$this->updateAttempts++;
		throw new \RuntimeException("forced rebuild failure");
	}

	public function invalidateCache($pids = [])
	{
		$this->invalidateAttempts++;
		throw new \RuntimeException("forced invalidation failure");
	}

	public function refresh($pids)
	{
		return $this->refreshCronProductCache($pids, "test-supplier");
	}
}

function assertTrue($condition, $message)
{
	if (!$condition) {
		fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
		exit(1);
	}
}

function sourceContains($file, $needles)
{
	$source = file_get_contents($file);
	foreach ($needles as $needle) {
		assertTrue(strpos($source, $needle) !== false, basename($file) . " missing: " . $needle);
	}
}

function sourceDoesNotContain($file, $needles)
{
	$source = file_get_contents($file);
	foreach ($needles as $needle) {
		assertTrue(strpos($source, $needle) === false, basename($file) . " unexpectedly contains: " . $needle);
	}
}

function sourceMatches($file, $pattern, $message)
{
	$source = file_get_contents($file);
	assertTrue((bool) preg_match($pattern, $source), basename($file) . ": " . $message);
}

$logic = new TestableCartProductLogic();
$productReflection = new ReflectionClass($logic);
$decodeDirtyState = $productReflection->getMethod("decodeCatalogDirtyState");
$decodeDirtyState->setAccessible(true);
$mergeDirtyState = $productReflection->getMethod("mergeCatalogDirtyState");
$mergeDirtyState->setAccessible(true);
$buildDirtyFallbackRows = $productReflection->getMethod("buildCatalogDirtyFallbackRows");
$buildDirtyFallbackRows->setAccessible(true);
assertTrue(
	$decodeDirtyState->invoke($logic, "legacy-generation") === ["generation" => "legacy-generation", "pids" => []],
	"legacy dirty generations must remain retryable"
);
$logic->existingProductIds = [77, 999];
$mergedDirtyState = $mergeDirtyState->invoke(
	$logic,
	json_encode(["generation" => "first", "pids" => [42, 77]]),
	"second",
	[77, 999]
);
assertTrue($mergedDirtyState === ["generation" => "second", "pids" => [42]], "dirty retries must retain deleted IDs without persisting current products");
$logic->existingProductIds = range(1, 13000);
$largeDirtyState = $mergeDirtyState->invoke($logic, "0", "large-catalog", range(1, 13000));
assertTrue($largeDirtyState === ["generation" => "large-catalog", "pids" => []], "large current catalogs must not be copied into the pending set");
assertTrue(strlen($largeDirtyState["generation"]) < 1024, "the dirty generation must remain safely below the configuration TEXT limit");
$logic->existingProductIds = range(1, 13000);
$deletedDirtyData = $mergeDirtyState->invoke($logic, "0", "deleted-product", [7, 14001]);
assertTrue($deletedDirtyData === ["generation" => "deleted-product", "pids" => [14001]], "deleted product IDs must remain durable for later cache cleanup");
$fallbackPids = range(100000, 112999);
$fallbackRows = $buildDirtyFallbackRows->invoke($logic, "upgrade-window", $fallbackPids, 123);
$fallbackRestoredPids = [];
foreach ($fallbackRows as $row) {
	assertTrue(strlen($row["value"]) <= 60000, "fallback dirty rows must remain below the configuration TEXT limit");
	$fallbackState = json_decode($row["value"], true);
	$fallbackRestoredPids = array_merge($fallbackRestoredPids, $fallbackState["pids"]);
}
assertTrue($fallbackRestoredPids === $fallbackPids, "upgrade-window fallback rows must retain every deleted product ID");
assertTrue(count($fallbackRows) === 4, "large fallback state must be split into bounded configuration rows");
$previousUmask = umask(0022);
$first = $logic->acquire(42, 20);
umask($previousUmask);
assertTrue(is_array($first), "first worker must acquire the product lock");
assertTrue(strlen($first["token"]) >= 32, "lock owner token must be unique and non-trivial");
assertTrue((fileperms(dirname(dirname($first["path"]))) & 0777) === 0750, "the shared lock root must reject access from unrelated users");
assertTrue((fileperms(dirname($first["path"])) & 0777) === 0750, "the lock scope must reject access from unrelated users");
assertTrue((fileperms($first["path"]) & 0777) === 0640, "lock files must be private to the shared service account");

$metadata = json_decode(file_get_contents($first["path"]), true);
assertTrue($metadata["token"] === $first["token"], "lock metadata must identify its owner");
assertTrue($metadata["expires_at"] > time(), "lock metadata must include a future lease");

$second = $logic->acquire(42, 20);
assertTrue($second === false, "a concurrent worker must not acquire the same product lock");
assertTrue($logic->release($first) === true, "the lock owner must release its own lock");

$third = $logic->acquire(42, 20);
assertTrue(is_array($third), "the lock must be available after owner release");
assertTrue($third["token"] !== $first["token"], "each lock acquisition must use a new token");
assertTrue($logic->release($third) === true, "the next owner must release its own lock");

$tampered = $logic->acquire(43, 20);
assertTrue(is_array($tampered), "the owner-check lock must be acquired");
ftruncate($tampered["handle"], 0);
rewind($tampered["handle"]);
fwrite($tampered["handle"], json_encode(["token" => "different-owner", "expires_at" => time() + 20]));
fflush($tampered["handle"]);
assertTrue($logic->release($tampered) === false, "a changed owner token must not be accepted during release");
$afterTamper = $logic->acquire(43, 20);
assertTrue(is_array($afterTamper), "a token mismatch must still unlock the file descriptor safely");
assertTrue($logic->release($afterTamper) === true, "the next valid owner must release the lock");

$catalog = $logic->acquireCatalog();
assertTrue(is_array($catalog), "the catalog builder lock must be acquired");
$lockOutput = [];
$lockStatus = 0;
exec("flock -n " . escapeshellarg($catalog["path"]) . " -c true", $lockOutput, $lockStatus);
assertTrue($lockStatus !== 0, "another process must not enter the catalog critical section");
assertTrue($logic->releaseAny($catalog) === true, "the catalog lock owner must release its lock");
$lockOutput = [];
$lockStatus = 1;
exec("flock -n " . escapeshellarg($catalog["path"]) . " -c true", $lockOutput, $lockStatus);
assertTrue($lockStatus === 0, "the catalog critical section must reopen after release");

$failingCronCache = new FailingCronCacheProductLogic();
$previousErrorLog = ini_get("error_log");
ini_set("error_log", $testRoot . DIRECTORY_SEPARATOR . "error.log");
assertTrue($failingCronCache->refresh([42]) === false, "cron cache failures must degrade without escaping to the supplier loop");
ini_set("error_log", $previousErrorLog);
assertTrue($failingCronCache->updateAttempts === 1, "cron must attempt a cache rebuild once");
assertTrue($failingCronCache->invalidateAttempts === 1, "cron must attempt best-effort invalidation after rebuild failure");

$root = dirname(__DIR__);
sourceDoesNotContain($root . "/app/home/controller/CartController.php", [
	'"page_type" => "set_config_page"',
	'(new \\app\\common\\logic\\Product())->syncProduct($param);',
	'"cart/stock_control"',
	'商品库存校验暂不可用',
	'queueProductSyncForCart',
	'syncProductForCart',
	'validateCartProductSnapshot',
	'supplier_version',
]);
sourceContains($root . "/app/common/logic/ConfigOptions.php", [
	'->whereIn("config_id", $configIds)',
	'->whereIn("relid", $suboptionIds)',
	'$suboptions = $suboptionsByConfig[$cid] ?? [];',
	'$pricings = $pricingsBySub[$subid] ?? [];',
]);
$configOptionsSource = file_get_contents($root . "/app/common/logic/ConfigOptions.php");
preg_match('/public function getConfigInfo\(.*?public function configShow/s', $configOptionsSource, $getConfigInfoMethod);
assertTrue(substr_count($getConfigInfoMethod[0], 'Db::name("product_config_options_sub")') === 1, "getConfigInfo must load all suboptions in one query");
assertTrue(substr_count($getConfigInfoMethod[0], 'Db::name("pricing")') === 1, "getConfigInfo must load all pricing rows in one query");
sourceDoesNotContain($root . "/app/common/logic/Shop.php", [
	'validateCartProductSnapshot',
	'supplier_version',
]);
sourceDoesNotContain($root . "/app/openapi/controller/CartController.php", [
	'queueProductSyncForCart',
	'validateCartProductSnapshot',
	'supplier_version',
]);
sourceContains($root . "/app/common/logic/Product.php", [
	"public function invalidateCache",
	"return clearCartIndexResponseCache() === true;",
	'$this->deleteInfoCacheUnlocked()',
	'$this->deleteListCacheUnlocked()',
	'$this->deleteDetailCacheUnlocked($pids)',
	'$this->acquireCatalogCacheLock();',
	'@chmod($directory, 0750);',
	'@chmod($path, 0640);',
	'$deadline = microtime(true) + max(0, floatval($waitSeconds));',
	'return $this->acquireFileLock("catalog-cache", "catalog", 120, $nonBlocking, $nonBlocking ? 0 : 5);',
	'$this->markCatalogCacheDirty($context, $error, $pids);',
	'public function retryDirtyCacheInvalidation()',
	'$this->mergeCatalogDirtyState(array_column($rows, "value"), $generation, $pids)',
	'$this->storePendingProductIds($dirtyState["pids"], $generation, $now)',
	'$this->buildCatalogDirtyFallbackRows($dirtyState["generation"], $dirtyState["pids"], $now)',
	'if (!$this->pendingTableExists())',
	'$this->findDeletedProductIds(array_merge($currentPids, (array) $pids))',
	'foreach (array_chunk($pids, 1000) as $chunk)',
	'array_merge($currentPids ?: [], $dirtyState["pids"], $pendingPids)',
	'$this->deletePendingProductIds($pendingPids);',
	'$this->updateInfoCacheUnlocked()',
	'$this->updateDetailCacheUnlocked($pids)',
	'$this->updateListCacheUnlocked([], true)',
	'$this->markCatalogCacheDirty("catalog cache rebuild"',
	'$this->acquireCatalogCacheLock(true);',
	'$this->syncProductUnlocked($param);',
	'$this->refreshCronProductCache($updated_product_ids, $api_name);',
	"} finally {",
]);
$productSource = file_get_contents($root . "/app/common/logic/Product.php");
preg_match('/public function updateCache\(.*?public function invalidateCache/s', $productSource, $updateCacheMethod);
assertTrue(strpos($updateCacheMethod[0], '$this->invalidateCache(') === false, "updateCache must not reacquire the catalog lock");
assertTrue(strpos($updateCacheMethod[0], 'Unlocked(') !== false, "updateCache must use lock-free internal builders while holding the catalog lock");
assertTrue(strpos($updateCacheMethod[0], 'markCatalogCacheDirty') !== false, "updateCache must persist a retry marker when any caller ignores its return value");
preg_match('/private function markCatalogCacheDirty\(.*?private function mergeCatalogDirtyState/s', $productSource, $markDirtyMethod);
$markLockPosition = strpos($markDirtyMethod[0], '$this->catalogDirtyRows(true)');
$pendingWritePosition = strpos($markDirtyMethod[0], '$this->storePendingProductIds(');
assertTrue(
	$markLockPosition !== false && $pendingWritePosition !== false && $markLockPosition < $pendingWritePosition,
	"dirty writers must lock the generation row before changing pending IDs"
);
preg_match('/public function retryDirtyCacheInvalidation\(.*?private function invalidateCacheUnlocked/s', $productSource, $retryDirtyMethod);
$retryTransactionPosition = strpos($retryDirtyMethod[0], '\\think\\Db::startTrans()');
$retryLockPosition = strpos($retryDirtyMethod[0], '$this->catalogDirtyRows(true)');
$pendingDeletePosition = strpos($retryDirtyMethod[0], '$this->deletePendingProductIds($pendingPids)');
$generationClearPosition = strpos($retryDirtyMethod[0], '->insert(["setting" => $this->cache_dirty_setting, "value" => 0');
assertTrue(
	$retryTransactionPosition !== false && $retryLockPosition > $retryTransactionPosition
	&& $pendingDeletePosition > $retryLockPosition && $generationClearPosition > $pendingDeletePosition,
	"retry cleanup must remove pending IDs and clear the generation atomically while holding the generation lock"
);
preg_match('/private function invalidateCacheUnlocked\(.*?private function deleteCacheKey/s', $productSource, $invalidateMethod);
$infoDeletePosition = strpos($invalidateMethod[0], '$this->deleteInfoCacheUnlocked()');
$listDeletePosition = strpos($invalidateMethod[0], '$this->deleteListCacheUnlocked()');
$detailDeletePosition = strpos($invalidateMethod[0], '$this->deleteDetailCacheUnlocked($pids)');
$versionPublishPosition = strpos($invalidateMethod[0], 'clearCartIndexResponseCache()');
assertTrue(
	$infoDeletePosition !== false && $listDeletePosition !== false && $detailDeletePosition !== false && $versionPublishPosition !== false
	&& $versionPublishPosition > $infoDeletePosition && $versionPublishPosition > $listDeletePosition && $versionPublishPosition > $detailDeletePosition,
	"cache invalidation must publish the cart snapshot version only after all catalog keys are removed"
);
preg_match('/public function refreshInventoryCache\(.*?private function normalizeProductIds/s', $productSource, $inventoryMethod);
assertTrue(strpos($inventoryMethod[0], '$this->acquireCatalogCacheLock(true)') !== false, "inventory cache refreshes must never delay checkout while waiting for a catalog rebuild");
preg_match('/public function syncProductForCart\(.*?protected function acquireCartSyncLock/s', $productSource, $cartSyncMethod);
assertTrue(substr_count($cartSyncMethod[0], 'cache($success_key) || cache($failure_key)') >= 2, "cart sync markers must be checked again after acquiring the PID lock");
assertTrue(strpos($cartSyncMethod[0], '$this->syncProductUnlocked($param)') !== false, "cart sync must not reacquire its own PID lock");
preg_match('/public function cronSyncProduct\(.*?protected function refreshCronProductCache/s', $productSource, $cronMethod);
$dirtyPosition = strpos($cronMethod[0], '$updated_product_ids[] = $local_product["id"]');
$writePosition = strpos($cronMethod[0], '$this->baseUpdateProduct($value, $local_product, $rate, true)');
assertTrue($dirtyPosition !== false && $writePosition !== false && $dirtyPosition < $writePosition, "cron must mark a product dirty before a possible database write");
assertTrue(strpos($cronMethod[0], '$this->acquireCartSyncLock($local_product["id"], 120)') !== false, "cron and manual/cart sync must share the PID lock");
assertTrue(strpos($cronMethod[0], '$current_product = \\think\\Db::name("products")') !== false, "cron must reload the product after acquiring its PID lock");
assertTrue(strpos($cronMethod[0], 'if (empty($current_product))') !== false, "cron must skip products deleted while it waited for the PID lock");
sourceMatches(
	$root . "/app/common/logic/Product.php",
	'/foreach \(\$pids as \$pid\) \{\s*unset\(\$list\[\$pid\]\);\s*\}\s*\$tmp = \$this->getList\(\$pids\);/s',
	"targeted list rebuilds must remove hidden or deleted product entries before merging"
);
sourceContains($root . "/app/admin/controller/ConfigOptionsController.php", [
	'$this->rememberProductIds($pids);',
	'$this->invalidateChangedProductCache();',
	'$this->updateProductVersion($param["sub_ids"], "options_sub");',
	'Failed to invalidate product cache after config option commit',
]);
sourceMatches(
	$root . "/app/admin/controller/ConfigOptionsController.php",
	'/private function updateProductVersion\(.*?private function rememberProductIds/s',
	"updateProductVersion helper must remain inspectable"
);
$configSource = file_get_contents($root . "/app/admin/controller/ConfigOptionsController.php");
preg_match('/private function updateProductVersion\(.*?private function rememberProductIds/s', $configSource, $versionHelper);
assertTrue(strpos($versionHelper[0], "updateCache(") === false, "updateProductVersion must not rebuild cache before transaction commit");
sourceMatches(
	$root . "/app/admin/controller/ConfigOptionsController.php",
	'/Db::commit\(\);\s*\$this->invalidateChangedProductCache\(\);/',
	"transactional configuration changes must invalidate after commit"
);
sourceContains($root . "/app/admin/controller/CurrencyController.php", [
	'private function invalidateProductCatalogCache($incrementVersion = false)',
	'(new \\app\\common\\logic\\Product())->invalidateCacheOrMarkDirty($pids ?: [], "currency commit");',
	'cache("shd_cron_currency_rate", null);',
	'Failed to invalidate product cache after currency commit',
]);
sourceMatches(
	$root . "/app/admin/controller/CurrencyController.php",
	'/public function updateRate\(\).*?cache\("shd_cron_currency_rate", null\);/s',
	"successful rate-only updates must invalidate the supplier currency-rate cache"
);
$currencySource = file_get_contents($root . "/app/admin/controller/CurrencyController.php");
preg_match('/public function updateRate\(\).*?private function getRate/s', $currencySource, $rateMethod);
assertTrue(strpos($rateMethod[0], 'invalidateProductCatalogCache') === false, "rate-only updates must not invalidate every product cache");
sourceMatches(
	$root . "/app/admin/controller/CurrencyController.php",
	'/Db::commit\(\);\s*if \(\$invalidateCatalog\) \{\s*\$this->invalidateProductCatalogCache\(true\);/',
	"bulk repricing must invalidate after commit"
);
sourceContains($root . "/app/admin/controller/CurrencyController.php", [
	'if ($res || $pricingUpdated) {',
]);
sourceContains($root . "/app/admin/command/Cron.php", [
	'(new \\app\\common\\logic\\Product())->retryDirtyCacheInvalidation();',
]);
sourceContains($root . "/app/common.php", [
	'return cache("cart_catalog_snapshot_version"',
	') === true;',
]);
sourceContains($root . "/public/upgrade/3.5.8.1.sql", [
	"CREATE TABLE IF NOT EXISTS `shd_product_catalog_cache_pending`",
	"Product::retryDirtyCacheInvalidation",
]);
$upgradeSql = file_get_contents($root . "/public/upgrade/3.5.8.1.sql");
assertTrue(strpos($upgradeSql, '`id` DESC') === false, "the migration must not reference a nonexistent configuration.id column");
assertTrue(strpos($upgradeSql, "JSON_EXTRACT") === false, "the migration must not parse large JSON dirty state while locking configuration");
sourceContains($root . "/public/upgrade/3.5.8.2.sql", [
	"CREATE TABLE IF NOT EXISTS `shd_product_catalog_cache_pending`",
	"Runtime retry processing streams it through",
]);
sourceContains($root . "/public/install/thinkcmf.sql", [
	"('_product_catalog_cache_dirty', '0', UNIX_TIMESTAMP(), UNIX_TIMESTAMP())",
	"CREATE TABLE `shd_product_catalog_cache_pending`",
]);
sourceContains($root . "/public/upgrade/upgrade.php", [
	"'_product_catalog_cache_dirty'",
	"(int) \$dirtyRows < 1",
	"product_catalog_cache_pending",
]);
sourceContains($root . "/app/api/controller/UpgradeSystemController.php", [
	'return $this->autoUpgradeDisabled();',
]);
assertTrue(strpos(file_get_contents($root . "/app/api/controller/UpgradeSystemController.php"), '\\think\\Db::') === false, "the disabled Web upgrader must not execute migration queries");
sourceContains($root . "/app/api/controller/ProductController.php", [
	"\$existingPids = empty(\$pids) ? [] : Db::name('products')->whereIn('id', \$pids)->column('id');",
	'$logic->deleteDetailCache($missingPids);',
]);
sourceContains($root . "/app/admin/controller/AdvancedOptionsController.php", [
	'\\think\\Db::commit();',
	'$this->invalidateProductCaches($pids);',
	'invalidateCacheOrMarkDirty($pids, "advanced option commit")',
]);
sourceMatches(
	$root . "/app/admin/controller/AdvancedOptionsController.php",
	'/\\\\think\\\\Db::commit\(\);\s*\} catch .*?\$this->invalidateProductCaches\(\$pids\);/s',
	"advanced rules must invalidate only after a successful commit"
);
$productControllerSource = file_get_contents($root . "/app/admin/controller/ProductController.php");
assertTrue(
	strpos($productControllerSource, 'array_merge($oldPids, array_map("intval", (array) $param["pids"]))') !== false,
	"customer product-group edits must invalidate both removed and added product IDs"
);
assertTrue(
	strpos($productControllerSource, '$this->getUserProductGroupPids([$spg["products"], $param["products"]])') !== false,
	"customer discount edits must invalidate both old and new product groups"
);

@unlink($testRoot . "/locks/cart-sync/product-42.lock");
@unlink($testRoot . "/locks/cart-sync/product-43.lock");
@unlink($testRoot . "/locks/catalog-cache/catalog.lock");
@unlink($testRoot . "/error.log");
@rmdir($testRoot . "/locks/cart-sync");
@rmdir($testRoot . "/locks/catalog-cache");
@rmdir($testRoot . "/locks");
@rmdir($testRoot);

fwrite(STDOUT, "cart cache regression checks passed" . PHP_EOL);
