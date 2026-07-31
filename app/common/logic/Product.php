<?php

namespace app\common\logic;

class Product
{
	private $list_name = "shd_all_products_list";
	private $detail_name = "shd_all_products_detail_";
	private $info_name = "shd_all_products_info";
	private $cache_dirty_setting = "_product_catalog_cache_dirty";
	private $cache_pending_table = "product_catalog_cache_pending";
	public $concurrent = 500;
	public $cron_max = 10;
	public function getProducts($pids = [])
	{
		$where = function (\think\db\Query $query) use($pids) {
			if (!empty($pids)) {
				$query->whereIn("p.id", $pids);
			}
		};
		$products = \think\Db::name("products")
			->alias("p")
			->leftJoin("product_groups g", "g.id=p.gid")
			->leftJoin("product_first_groups fg", "fg.id=g.gid")
			->field("p.*,g.hidden as supplier_group_hidden,fg.hidden as supplier_first_group_hidden")
			->where($where)
			->select()
			->toArray();
		$products_filter = [];
		foreach ($products as $product) {
			$product = self::normalizeSupplierProductState($product);
			$id = $product["id"];
			$fields = \think\Db::name("customfields")->field("id,fieldname,description,fieldtype,fieldoptions,regexpr,required,showorder,showinvoice,sortorder,showdetail")->where("type", "product")->where("relid", $id)->where("adminonly", 0)->where("showorder", 1)->order("sortorder desc")->select()->toArray();
			$product_pricings = \think\Db::name("pricing")->alias("a")->field("a.*,b.code")->leftJoin("currencies b", "a.currency = b.id")->where("a.type", "product")->where("a.relid", $id)->where("b.default", 1)->select()->toArray();
			$config_groups = \think\Db::name("product_config_groups")->alias("a")->leftJoin("product_config_links b", "a.id = b.gid")->field("a.id,a.name,a.description")->where("b.pid", $id)->select()->toArray();
			$config_links_data = \think\Db::name("product_config_links")->where("pid", $id)->select()->toArray();
			$oids_all = [];
			foreach ($config_groups as $k => $v) {
				$options = \think\Db::name("product_config_options")->where("gid", $v["id"])->where("hidden", 0)->select()->toArray();
				foreach ($options as $kk => $vv) {
					$subs = \think\Db::name("product_config_options_sub")->where("config_id", $vv["id"])->where("hidden", 0)->select()->toArray();
					foreach ($subs as $kkk => $vvv) {
						$pricings = \think\Db::name("pricing")->alias("a")->field("a.*,b.code")->leftJoin("currencies b", "a.currency = b.id")->where("type", "configoptions")->where("relid", $vvv["id"])->where("b.default", 1)->select()->toArray();
						$subs[$kkk]["pricings"] = $pricings;
					}
					$options[$kk]["sub"] = $subs;
				}
				$oids_all = array_merge($oids_all, array_column($options, "id"));
				$config_groups[$k]["options"] = $options;
			}
			$advanced = (new \app\common\model\SeniorConfModel())->getProductUseConfLinksFlatMap(array_unique($oids_all));
			$product["customfields"] = $fields;
			$product["product_pricings"] = $product_pricings;
			$product["advanced"] = $advanced;
			$product["config_groups"] = $config_groups;
			$product["config_links"] = array_column($config_links_data, "gid");
			$products_filter[$id] = $product;
		}
		return $products_filter;
	}
	public static function normalizeSupplierProductState($product)
	{
		$product = (array) $product;
		$localControl = intval($product["stock_control"] ?? 0) === 1;
		$upstreamControl = ($product["api_type"] ?? "") === "zjmf_api"
			&& intval($product["upstream_stock_control"] ?? 0) === 1;
		$localQty = max(0, intval($product["qty"] ?? 0));
		$upstreamQty = max(0, intval($product["upstream_qty"] ?? 0));
		if ($localControl && $upstreamControl) {
			$stockControl = 1;
			$qty = min($localQty, $upstreamQty);
		} elseif ($upstreamControl) {
			$stockControl = 1;
			$qty = $upstreamQty;
		} elseif ($localControl) {
			$stockControl = 1;
			$qty = $localQty;
		} else {
			$stockControl = 0;
			$qty = 0;
		}
		$product["stock_control"] = $stockControl;
		$product["qty"] = $qty;
		if (($product["api_type"] ?? "") === "zjmf_api") {
			$product["upstream_stock_control"] = $stockControl;
			$product["upstream_qty"] = $qty;
		}
		$product["hidden"] = intval($product["hidden"] ?? 0)
			|| intval($product["supplier_group_hidden"] ?? 0)
			|| intval($product["supplier_first_group_hidden"] ?? 0) ? 1 : 0;
		unset($product["supplier_group_hidden"], $product["supplier_first_group_hidden"]);
		return $product;
	}
	public function updateDetailCache($pids = [])
	{
		$pids = $this->normalizeProductIds($pids);
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			$this->markCatalogCacheDirty("detail cache rebuild", "无法取得商品缓存构建锁", $pids);
			return false;
		}
		try {
			$result = $this->updateDetailCacheUnlocked($pids);
			if ($result !== true) {
				$this->markCatalogCacheDirty("detail cache rebuild", "商品详情缓存写入失败", $pids);
			}
			return $result;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function updateDetailCacheUnlocked($pids = [])
	{
		if (!is_array($pids)) {
			$pids = [$pids];
		}
		foreach ($pids as $pid) {
			$tmp = $this->getProducts([$pid]);
			$tmp["__supplier_state_version"] = 1;
			if (cache($this->detail_name . $pid, json_encode($tmp)) === false) {
				return false;
			}
			unset($tmp);
		}
		return true;
	}
	public function deleteDetailCache($pids = [])
	{
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			return false;
		}
		try {
			return $this->deleteDetailCacheUnlocked($pids);
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function deleteDetailCacheUnlocked($pids = [])
	{
		if (!is_array($pids)) {
			$pids = [$pids];
		}
		foreach ($pids as $pid) {
			if (!$this->deleteCacheKey($this->detail_name . $pid)) {
				return false;
			}
		}
		return true;
	}
	public function getDetailCache($pid)
	{
		$tmp = cache($this->detail_name . $pid);
		$detail = json_decode($tmp, true);
		if (!empty($detail) && !isset($detail["__supplier_state_version"])) {
			return [];
		}
		unset($detail["__supplier_state_version"]);
		return $detail;
	}
	public function updateInfoCache()
	{
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			$this->markCatalogCacheDirty("info cache rebuild", "无法取得商品缓存构建锁");
			return false;
		}
		try {
			$result = $this->updateInfoCacheUnlocked();
			if ($result !== true) {
				$this->markCatalogCacheDirty("info cache rebuild", "商品信息缓存写入失败");
			}
			return $result;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function updateInfoCacheUnlocked()
	{
		$products = \think\Db::name("products")
			->alias("p")
			->leftJoin("product_groups g", "g.id=p.gid")
			->leftJoin("product_first_groups fg", "fg.id=g.gid")
			->field("p.id,p.name,p.location_version,p.api_type,p.stock_control,p.qty,p.upstream_stock_control,p.upstream_qty,p.hidden,g.hidden as supplier_group_hidden,fg.hidden as supplier_first_group_hidden")
			->select()
			->toArray();
		$infos = [];
		foreach ($products as $product) {
			$product = self::normalizeSupplierProductState($product);
			$infos[] = [
				"id" => $product["id"],
				"name" => $product["name"],
				"location_version" => $product["location_version"],
				"stock_control" => $product["stock_control"],
				"qty" => $product["qty"],
				"supplier_state_version" => 1,
			];
		}
		if (cache($this->info_name, json_encode($infos)) === false) {
			return false;
		}
		unset($infos);
		return true;
	}
	public function getInfoCache()
	{
		$tmp = cache($this->info_name);
		$infos = json_decode($tmp, true);
		if (!empty($infos) && !isset($infos[0]["supplier_state_version"])) {
			return [];
		}
		foreach ((array) $infos as &$info) {
			unset($info["supplier_state_version"]);
		}
		unset($info);
		return $infos;
	}
	public function deleteInfoCache()
	{
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			return false;
		}
		try {
			return $this->deleteInfoCacheUnlocked();
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function deleteInfoCacheUnlocked()
	{
		return $this->deleteCacheKey($this->info_name);
	}
	public function updateCache($pids = [])
	{
		$pids = $this->normalizeProductIds($pids);
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			$this->markCatalogCacheDirty("catalog cache rebuild", "无法取得商品缓存构建锁", $pids);
			return false;
		}
		try {
			if (!$this->updateInfoCacheUnlocked()) {
				throw new \RuntimeException("商品信息缓存写入失败");
			}
			if (!$this->updateDetailCacheUnlocked($pids)) {
				throw new \RuntimeException("商品详情缓存写入失败");
			}
			if (!$this->updateListCacheUnlocked([], true)) {
				throw new \RuntimeException("商品列表缓存写入失败");
			}
			if (clearCartIndexResponseCache() !== true) {
				throw new \RuntimeException("购物车响应缓存版本写入失败");
			}
			return true;
		} catch (\Throwable $e) {
			$invalidateError = "";
			if ($this->invalidateCacheUnlocked($pids) !== true) {
				$invalidateError = ",失败后缓存清理未完成";
			}
			$this->markCatalogCacheDirty("catalog cache rebuild", $e->getMessage() . $invalidateError, $pids);
			return false;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	public function invalidateCache($pids = [])
	{
		$pids = $this->normalizeProductIds($pids);
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			return false;
		}
		try {
			return $this->invalidateCacheUnlocked($pids);
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	public function invalidateCacheOrMarkDirty($pids = [], $context = "")
	{
		$pids = $this->normalizeProductIds($pids);
		try {
			if ($this->invalidateCache($pids) === true) {
				return true;
			}
			$error = "无法取得商品缓存失效锁";
		} catch (\Throwable $e) {
			$error = $e->getMessage();
		}
		$this->markCatalogCacheDirty($context, $error, $pids);
		return false;
	}
	private function markCatalogCacheDirty($context, $error, $pids = [])
	{
		if (!class_exists("\\think\\Db")) {
			error_log("Product catalog cache is dirty: " . $context . " - " . $error);
			return false;
		}
		try {
			try {
				$generation = bin2hex(random_bytes(16));
			} catch (\Throwable $e) {
				$generation = sha1(uniqid((string) mt_rand(), true));
			}
			$now = time();
			\think\Db::startTrans();
			try {
				$rows = $this->catalogDirtyRows(true);
				$dirtyState = $this->mergeCatalogDirtyState(array_column($rows, "value"), $generation, $pids);
				if ($this->pendingTableExists()) {
					$this->storePendingProductIds($dirtyState["pids"], $generation, $now);
					$dirtyRows = [["setting" => $this->cache_dirty_setting, "value" => $dirtyState["generation"], "create_time" => $now, "update_time" => $now]];
				} else {
					$dirtyRows = $this->buildCatalogDirtyFallbackRows($dirtyState["generation"], $dirtyState["pids"], $now);
				}
				\think\Db::name("configuration")->where("setting", $this->cache_dirty_setting)->delete();
				\think\Db::name("configuration")->insertAll($dirtyRows);
				\think\Db::commit();
			} catch (\Throwable $e) {
				\think\Db::rollback();
				throw $e;
			}
			error_log("Product catalog cache invalidation queued: " . $context . " - " . $error);
			return true;
		} catch (\Throwable $e) {
			error_log("Failed to persist product catalog cache retry: " . $e->getMessage());
			return false;
		}
	}
	private function mergeCatalogDirtyState($currentValue, $generation, $pids)
	{
		$currentPids = [];
		foreach ((array) $currentValue as $value) {
			$current = $this->decodeCatalogDirtyState($value);
			$currentPids = array_merge($currentPids, $current["pids"]);
		}
		return [
			"generation" => (string) $generation,
			"pids" => $this->findDeletedProductIds(array_merge($currentPids, (array) $pids)),
		];
	}
	private function catalogDirtyRows($lock = false)
	{
		$query = \think\Db::name("configuration")->where("setting", $this->cache_dirty_setting);
		if ($lock) {
			$query->lock(true);
		}
		return $query->select()->toArray();
	}
	private function catalogDirtyValues($rows)
	{
		$values = array_map(function ($row) {
			return (string) ($row["value"] ?? "");
		}, (array) $rows);
		sort($values, SORT_STRING);
		return $values;
	}
	protected function findDeletedProductIds($pids)
	{
		$pids = $this->normalizeProductIds($pids);
		if (empty($pids)) {
			return [];
		}
		$existing = [];
		foreach (array_chunk($pids, 1000) as $chunk) {
			$ids = \think\Db::name("products")->whereIn("id", $chunk)->column("id");
			foreach ((array) $ids as $id) {
				$existing[intval($id)] = true;
			}
		}
		return array_values(array_filter($pids, function ($pid) use($existing) {
			return !isset($existing[$pid]);
		}));
	}
	private function storePendingProductIds($pids, $generation, $now)
	{
		foreach (array_chunk($this->normalizeProductIds($pids), 1000) as $chunk) {
			$rows = [];
			foreach ($chunk as $pid) {
				$rows[] = ["pid" => $pid, "generation" => (string) $generation, "create_time" => $now, "update_time" => $now];
			}
			\think\Db::name($this->cache_pending_table)->insertAll($rows, true);
		}
	}
	private function pendingTableExists()
	{
		$table = \think\Db::name($this->cache_pending_table)->getTable();
		$result = \think\Db::query("SELECT COUNT(*) AS `count` FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?", [$table]);
		return intval($result[0]["count"] ?? 0) === 1;
	}
	private function buildCatalogDirtyFallbackRows($generation, $pids, $now)
	{
		$chunks = array_chunk($this->normalizeProductIds($pids), 4000);
		if (empty($chunks)) {
			$chunks = [[]];
		}
		$rows = [];
		foreach ($chunks as $chunk) {
			$value = json_encode(["generation" => (string) $generation, "pids" => $chunk]);
			if ($value === false || strlen($value) > 60000) {
				throw new \RuntimeException("商品缓存重试状态超出安全长度");
			}
			$rows[] = ["setting" => $this->cache_dirty_setting, "value" => $value, "create_time" => $now, "update_time" => $now];
		}
		return $rows;
	}
	private function pendingProductIds()
	{
		if (!$this->pendingTableExists()) {
			return [];
		}
		return $this->normalizeProductIds(\think\Db::name($this->cache_pending_table)->column("pid"));
	}
	private function deletePendingProductIds($pids)
	{
		foreach (array_chunk($this->normalizeProductIds($pids), 1000) as $chunk) {
			\think\Db::name($this->cache_pending_table)->whereIn("pid", $chunk)->delete();
		}
	}
	private function decodeCatalogDirtyState($value)
	{
		$value = (string) $value;
		if ($value === "" || $value === "0") {
			return ["generation" => "", "pids" => []];
		}
		$decoded = json_decode($value, true);
		if (!is_array($decoded) || !isset($decoded["generation"])) {
			return ["generation" => $value, "pids" => []];
		}
		return [
			"generation" => (string) $decoded["generation"],
			"pids" => $this->normalizeProductIds($decoded["pids"] ?? []),
		];
	}
	public function retryDirtyCacheInvalidation()
	{
		if (!class_exists("\\think\\Db")) {
			return false;
		}
		try {
			$dirtyRows = $this->catalogDirtyRows();
			$dirtyValues = $this->catalogDirtyValues($dirtyRows);
			$dirtyValue = $dirtyValues[0] ?? "0";
			$pendingPids = $this->pendingProductIds();
			$hasDirtyGeneration = !empty(array_filter($dirtyValues, function ($value) {
				return $value !== "" && $value !== "0";
			}));
			if (!$hasDirtyGeneration && empty($pendingPids)) {
				return true;
			}
			$dirtyState = $this->mergeCatalogDirtyState($dirtyValues, $dirtyValue, []);
			$currentPids = \think\Db::name("products")->column("id");
			$pids = $this->normalizeProductIds(array_merge($currentPids ?: [], $dirtyState["pids"], $pendingPids));
			if ($this->invalidateCache($pids) !== true) {
				return false;
			}
			\think\Db::startTrans();
			try {
				$currentDirtyRows = $this->catalogDirtyRows(true);
				if ($this->catalogDirtyValues($currentDirtyRows) !== $dirtyValues) {
					\think\Db::rollback();
					return false;
				}
				$this->deletePendingProductIds($pendingPids);
				$now = time();
				\think\Db::name("configuration")->where("setting", $this->cache_dirty_setting)->delete();
				\think\Db::name("configuration")->insert(["setting" => $this->cache_dirty_setting, "value" => 0, "create_time" => $now, "update_time" => $now]);
				\think\Db::commit();
				return true;
			} catch (\Throwable $e) {
				\think\Db::rollback();
				throw $e;
			}
		} catch (\Throwable $e) {
			error_log("Failed to retry product catalog cache invalidation: " . $e->getMessage());
			return false;
		}
	}
	private function invalidateCacheUnlocked($pids = [])
	{
		if (!$this->deleteInfoCacheUnlocked() || !$this->deleteListCacheUnlocked()) {
			return false;
		}
		if (!empty($pids) && !$this->deleteDetailCacheUnlocked($pids)) {
			return false;
		}
		return clearCartIndexResponseCache() === true;
	}
	private function deleteCacheKey($key)
	{
		return !cache("?" . $key) || cache($key, null) === true;
	}
	public function refreshInventoryCache($pids = [], $context = "inventory commit")
	{
		$pids = $this->normalizeProductIds($pids);
		if (empty($pids)) {
			return true;
		}
		$lock = $this->acquireCatalogCacheLock(true);
		if ($lock === false) {
			$this->markCatalogCacheDirty($context, "无法取得商品缓存刷新锁", $pids);
			return false;
		}
		try {
			$rows = \think\Db::name("products")->field("id,api_type,stock_control,qty,upstream_stock_control,upstream_qty")->whereIn("id", $pids)->select()->toArray();
			$inventory = [];
			foreach ($rows as $row) {
				$row = self::normalizeSupplierProductState($row);
				$inventory[intval($row["id"])] = ["stock_control" => intval($row["stock_control"]), "qty" => intval($row["qty"])];
			}
			$infos = $this->getInfoCache();
			if (is_array($infos) && !empty($infos)) {
				foreach ($infos as &$info) {
					$id = intval($info["id"] ?? 0);
					if (isset($inventory[$id])) {
						$info = array_merge($info, $inventory[$id]);
					}
				}
				unset($info);
				if (cache($this->info_name, json_encode($infos)) === false) {
					throw new \RuntimeException("商品信息缓存写入失败");
				}
			}
			$list = $this->getListCache();
			if (is_array($list) && !empty($list)) {
				foreach ($inventory as $id => $values) {
					if (isset($list[$id])) {
						$list[$id] = array_merge($list[$id], $values);
					}
				}
				if (cache($this->list_name, json_encode($list)) === false) {
					throw new \RuntimeException("商品列表缓存写入失败");
				}
			}
			foreach ($inventory as $id => $values) {
				$detail = $this->getDetailCache($id);
				if (is_array($detail) && isset($detail[$id])) {
					$detail[$id] = array_merge($detail[$id], $values);
					if (cache($this->detail_name . $id, json_encode($detail)) === false) {
						throw new \RuntimeException("商品详情缓存写入失败");
					}
				}
			}
			if (clearCartIndexResponseCache() !== true) {
				throw new \RuntimeException("购物车响应缓存失效失败");
			}
			return true;
		} catch (\Throwable $e) {
			$this->markCatalogCacheDirty($context, $e->getMessage(), $pids);
			return false;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function normalizeProductIds($pids)
	{
		if (!is_array($pids)) {
			$pids = [$pids];
		}
		$pids = array_map("intval", $pids);
		$pids = array_filter($pids, function ($pid) {
			return $pid > 0;
		});
		return array_values(array_unique($pids));
	}
	public function getCurrencyRateCache()
	{
		$currency_arr = cache("shd_cron_currency_rate");
		$currency_arr = json_decode($currency_arr, true);
		if (empty($currency_arr)) {
			$currency_arr = getRate("json");
			cache("shd_cron_currency_rate", json_encode($currency_arr), 86400);
		}
		return $currency_arr;
	}
	public function syncProduct($param)
	{
		$pid = intval($param["pid"] ?? 0);
		if ($pid <= 0) {
			return ["status" => 400, "msg" => "商品不存在"];
		}
		$timeout = max(1, floatval($param["timeout"] ?? 30));
		$lock = $this->acquireCartSyncLock($pid, intval(ceil($timeout * 3)) + 15);
		if ($lock === false) {
			return ["status" => 409, "msg" => "商品数据正在同步，请稍后重试"];
		}
		try {
			return $this->syncProductUnlocked($param);
		} finally {
			$this->releaseCartSyncLock($lock);
		}
	}
	private function syncProductUnlocked($param)
	{
		$id = $param["pid"];
		$product = \think\Db::name("products")->where("id", $id)->find();
		$zjmf_finance_api_id = intval($param["zjmf_finance_api_id"]);
		$api = \think\Db::name("zjmf_finance_api")->where("id", $zjmf_finance_api_id)->find();
		$api_name = $api["name"];
		$upstream_pid = intval($param["upstream_pid"]);
		$timeout = isset($param["timeout"]) ? floatval($param["timeout"]) : 30;
		$log = "";
		if (isset($param["page_type"])) {
			if ($param["page_type"] == "set_config_page") {
				$log = "购物车页面";
			} elseif ($param["page_type"] == "cart_queue") {
				$log = "购物车异步刷新";
			} elseif ($param["page_type"] == "edit_product") {
				$log = "保存商品";
			}
		}
		$res = getZjmfUpstreamProductsInfo($zjmf_finance_api_id, [$upstream_pid], $timeout);
		if ($res["status"] != 200) {
			$desc = "{$log}获取供应商'{$api_name}'商品版本信息失败,请检查供应商接口是否可用或联系供应商更新财务系统至最新版本,报错信息:{$res["msg"]}";
			active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 0);
			return ["status" => 400, "msg" => "【" . $api_name . "】无法链接,本地数据可能与上游数据不一致!"];
		}
		$info = $res["data"]["info"][0];
		if (empty($info)) {
			return ["status" => 400, "msg" => "同步失败,供应商【{$api_name}】商品已删除"];
		}
		$upstream_currency = $res["data"]["currency"];
		if (!isset($param["rate"])) {
			$local_currency = \think\Db::name("currencies")->where("default", 1)->value("code");
			$currency_arr = $this->getCurrencyRateCache();
			if ($local_currency == $upstream_currency) {
				$rate = 1;
			} else {
				$rate = bcdiv($currency_arr[$local_currency], $currency_arr[$upstream_currency], 20);
			}
		} else {
			$rate = floatval($param["rate"]);
		}
		if ($product["upstream_version"] != $info["location_version"] || $product["upstream_price_type"] != $param["upstream_price_type"]) {
			$res = getZjmfUpstreamProductsDetail($zjmf_finance_api_id, [$upstream_pid], $timeout);
			if ($res["status"] != 200) {
				$desc = "{$log}获取供应商'{$api_name}'商品详细信息失败,请检查供应商接口是否可用或联系供应商更新财务系统至最新版本,报错信息:{$res["msg"]}";
				active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 0);
				return ["status" => 400, "msg" => "【" . $api_name . "】无法链接,本地数据可能与上游数据不一致!"];
			}
			$upstream_data = $upstream_product = $res["data"]["detail"][$upstream_pid];
			if (empty($upstream_data)) {
				return ["status" => 400, "msg" => "同步失败,供应商【{$api_name}】商品已删除"];
			}
			if (empty($product["upstream_pid"])) {
				$product["first_cron"] = 1;
			}
			$product["upstream_pid"] = $upstream_pid;
			$product["zjmf_api_id"] = $zjmf_finance_api_id;
			$res = $this->baseUpdateProduct($upstream_data, $product, $rate);
			if ($res["status"] != 200) {
				$desc = "{$log}同步供应商'{$api_name}'商品'{$upstream_data["name"]}'失败,本地#PRODUCT ID:{$id},报错信息:{$res["msg"]}";
				active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 0);
				return $res;
			}
		} else {
			if ($info["qty"] != $product["upstream_qty"] || $info["stock_control"] != $product["upstream_stock_control"]) {
				\think\Db::name("products")->where("id", $id)->update(["upstream_qty" => $info["qty"], "upstream_stock_control" => $info["stock_control"]]);
			}
		}
		if ($product["upstream_version"] != $info["location_version"] || $info["qty"] != $product["upstream_qty"] || $info["stock_control"] != $product["upstream_stock_control"] || $product["upstream_price_type"] != $param["upstream_price_type"]) {
			if (!empty($param["upstream_price_type"])) {
				\think\Db::name("products")->where("id", $id)->update(["upstream_price_type" => $param["upstream_price_type"] ?: "percent", "upstream_price_value" => $param["upstream_price_value"] ?: 120]);
			}
			$this->updateCache([$id]);
			$desc = "{$log}同步供应商'{$api_name}'商品'{$info["name"]}'成功,本地#PRODUCT ID:{$id}";
			if (isset($param["page_type"]) && $param["page_type"] == "set_config_page") {
			} else {
				active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 0);
			}
		}
		return ["status" => 200, "msg" => "同步数据成功"];
	}
	public function syncProductForCart($param)
	{
		$pid = intval($param["pid"] ?? 0);
		if ($pid <= 0) {
			return ["status" => 400, "msg" => "商品不存在"];
		}
		if ($this->queueProductSyncForCart($pid)) {
			return ["status" => 200, "msg" => "商品数据将在后台刷新"];
		}
		return ["status" => 200, "msg" => "后台刷新暂不可用，已使用本地数据"];
	}
	public function queueProductSyncForCart($pid)
	{
		$pid = intval($pid);
		if ($pid <= 0) {
			return false;
		}
		$lock = $this->acquireFileLock("cart-sync-enqueue", "product-" . $pid, 10, true);
		if ($lock === false) {
			return true;
		}
		try {
			$state = $this->getCartProductSyncState($pid);
			$updated_at = intval($state["updated_at"] ?? 0);
			$status = (string) ($state["status"] ?? "");
			if (in_array($status, ["queued", "running"], true) && $updated_at >= time() - 900) {
				return true;
			}
			if ($status === "failed" && $updated_at >= time() - 60) {
				return true;
			}
			$product = $this->findCartProductVersionRow($pid);
			if (empty($product)) {
				return false;
			}
			$requested_version = self::cartProductVersion($product);
			if (self::isCartProductSyncSuccessFresh($state, $requested_version)) {
				return true;
			}
			$token = $this->newCartProductSyncToken();
			$state = [
				"token" => $token,
				"status" => "queued",
				"requested_version" => $requested_version,
				"completed_version" => "",
				"updated_at" => time(),
			];
			$this->storeCartProductSyncState($pid, $state);
			try {
				\app\queue\job\SyncProduct::push(["pid" => $pid, "token" => $token, "requested_version" => $requested_version]);
				return true;
			} catch (\Throwable $e) {
				$state["status"] = "failed";
				$state["updated_at"] = time();
				$this->storeCartProductSyncState($pid, $state);
				try {
					\think\facade\Log::record("Cart product sync enqueue failed for product #{$pid}: " . $e->getMessage(), "error");
				} catch (\Throwable $logError) {
				}
				return false;
			}
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	public static function cartProductVersion($product)
	{
		return (string) intval($product["location_version"] ?? 0);
	}
	public static function isCartProductSyncSuccessFresh($state, $currentVersion, $now = null)
	{
		if (!is_array($state) || ($state["status"] ?? "") !== "success") {
			return false;
		}
		$completed_version = (string) ($state["completed_version"] ?? "");
		$current_version = (string) $currentVersion;
		if ($completed_version === "" || !hash_equals($current_version, $completed_version)) {
			return false;
		}
		$now = $now === null ? time() : intval($now);
		return intval($state["updated_at"] ?? 0) >= $now - 15;
	}
	protected function findCartProductVersionRow($pid)
	{
		return \think\Db::name("products")->field("id,location_version,upstream_version")->where("id", intval($pid))->find();
	}
	public function getCartProductSyncState($pid)
	{
		$state = cache($this->cartProductSyncStateKey($pid));
		return is_array($state) ? $state : [];
	}
	public function beginCartProductSync($pid, $token)
	{
		$pid = intval($pid);
		$lock = $this->acquireFileLock("cart-sync-enqueue", "product-" . $pid, 10, false, 2);
		if ($lock === false) {
			return false;
		}
		try {
			$state = $this->getCartProductSyncState($pid);
			if (!hash_equals((string) ($state["token"] ?? ""), (string) $token)) {
				return false;
			}
			$status = (string) ($state["status"] ?? "");
			if ($status !== "queued" && !($status === "running" && intval($state["updated_at"] ?? 0) < time() - 30)) {
				return false;
			}
			$state["status"] = "running";
			$state["updated_at"] = time();
			$this->storeCartProductSyncState($pid, $state);
			return true;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	public function markCartProductSyncQueued($pid, $token)
	{
		return $this->transitionCartProductSyncState($pid, $token, ["running"], "queued");
	}
	public function completeCartProductSync($pid, $token, $success)
	{
		$pid = intval($pid);
		$lock = $this->acquireFileLock("cart-sync-enqueue", "product-" . $pid, 10, false, 2);
		if ($lock === false) {
			return false;
		}
		try {
			$state = $this->getCartProductSyncState($pid);
			if (!hash_equals((string) ($state["token"] ?? ""), (string) $token)) {
				return false;
			}
			$state["status"] = $success ? "success" : "failed";
			$state["updated_at"] = time();
			if ($success) {
				$product = \think\Db::name("products")->field("location_version,upstream_version")->where("id", $pid)->find();
				$state["completed_version"] = empty($product) ? "" : self::cartProductVersion($product);
			}
			$this->storeCartProductSyncState($pid, $state);
			return true;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	public function validateCartProductSnapshot($pid, $version, $queueIfMissing = true)
	{
		$pid = intval($pid);
		$product = \think\Db::name("products")
			->field("id,api_type,zjmf_api_id,location_version,upstream_version")
			->where("id", $pid)
			->find();
		if (empty($product)) {
			return ["status" => 400, "msg" => "商品不存在"];
		}
		if (($product["api_type"] ?? "") !== "zjmf_api") {
			return ["status" => 200, "version" => ""];
		}
		$current_version = self::cartProductVersion($product);
		if (!is_string($version) || $version === "" || !hash_equals($current_version, $version)) {
			return ["status" => 409, "msg" => "商品信息已更新，请刷新后重新确认"];
		}
		$auto_update = intval(\think\Db::name("zjmf_finance_api")->where("id", intval($product["zjmf_api_id"]))->value("auto_update"));
		if ($auto_update !== 1) {
			return ["status" => 200, "version" => $current_version];
		}
		$state = $this->getCartProductSyncState($pid);
		if (self::isCartProductSyncSuccessFresh($state, $current_version)) {
			return ["status" => 200, "version" => $current_version];
		}
		if ($queueIfMissing) {
			$this->queueProductSyncForCart($pid);
			$state = $this->getCartProductSyncState($pid);
			if (self::isCartProductSyncSuccessFresh($state, $current_version)) {
				return ["status" => 200, "version" => $current_version];
			}
		}
		if (($state["status"] ?? "") === "failed") {
			return ["status" => 409, "msg" => "商品信息更新失败，请稍后刷新重试"];
		}
		return ["status" => 409, "msg" => "商品信息正在更新，请稍后刷新重试"];
	}
	public function syncLegacySupplierOrderSnapshot($pid)
	{
		$pid = intval($pid);
		$product = \think\Db::name("products")
			->field("id,api_type,zjmf_api_id,upstream_pid,upstream_price_type,upstream_price_value,location_version,upstream_version")
			->where("id", $pid)
			->find();
		if (empty($product) || ($product["api_type"] ?? "") !== "zjmf_api") {
			return ["status" => 400, "msg" => "商品不存在"];
		}
		$auto_update = intval(\think\Db::name("zjmf_finance_api")->where("id", intval($product["zjmf_api_id"]))->value("auto_update"));
		if ($auto_update === 1) {
			$result = $this->syncProduct([
				"pid" => $pid,
				"zjmf_finance_api_id" => intval($product["zjmf_api_id"]),
				"upstream_pid" => intval($product["upstream_pid"]),
				"timeout" => 5,
				"page_type" => "cart_queue",
				"upstream_price_type" => $product["upstream_price_type"],
				"upstream_price_value" => $product["upstream_price_value"],
			]);
			if (($result["status"] ?? 400) !== 200) {
				return ["status" => 409, "msg" => "商品信息更新失败，请稍后重试"];
			}
			$product = \think\Db::name("products")->field("location_version,upstream_version")->where("id", $pid)->find();
			$this->storeDirectCartProductSyncSuccess($pid, self::cartProductVersion($product));
		}
		return ["status" => 200, "version" => self::cartProductVersion($product)];
	}
	public function acquireCartProductOrderLocks($pids)
	{
		$pids = $this->normalizeProductIds($pids);
		if (empty($pids)) {
			return [];
		}
		$pids = \think\Db::name("products")->whereIn("id", $pids)->where("api_type", "zjmf_api")->order("id", "asc")->column("id");
		$locks = [];
		foreach ($pids as $pid) {
			$lock = $this->acquireCartSyncLock($pid, 120);
			if ($lock === false) {
				$this->releaseCartProductOrderLocks($locks);
				return false;
			}
			$locks[] = $lock;
		}
		return $locks;
	}
	public function releaseCartProductOrderLocks($locks)
	{
		foreach (array_reverse((array) $locks) as $lock) {
			$this->releaseCartSyncLock($lock);
		}
	}
	private function transitionCartProductSyncState($pid, $token, $allowedStatuses, $newStatus)
	{
		$pid = intval($pid);
		$lock = $this->acquireFileLock("cart-sync-enqueue", "product-" . $pid, 10, false, 2);
		if ($lock === false) {
			return false;
		}
		try {
			$state = $this->getCartProductSyncState($pid);
			if (!hash_equals((string) ($state["token"] ?? ""), (string) $token)
				|| !in_array((string) ($state["status"] ?? ""), $allowedStatuses, true)) {
				return false;
			}
			$state["status"] = $newStatus;
			$state["updated_at"] = time();
			$this->storeCartProductSyncState($pid, $state);
			return true;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function cartProductSyncStateKey($pid)
	{
		return "cart_product_sync_state_" . intval($pid);
	}
	private function storeCartProductSyncState($pid, $state)
	{
		return cache($this->cartProductSyncStateKey($pid), $state, 172800);
	}
	private function newCartProductSyncToken()
	{
		try {
			return bin2hex(random_bytes(16));
		} catch (\Throwable $e) {
			return sha1(uniqid((string) mt_rand(), true));
		}
	}
	private function storeDirectCartProductSyncSuccess($pid, $version)
	{
		$pid = intval($pid);
		$lock = $this->acquireFileLock("cart-sync-enqueue", "product-" . $pid, 10, false, 2);
		if ($lock === false) {
			return false;
		}
		try {
			$this->storeCartProductSyncState($pid, [
				"token" => $this->newCartProductSyncToken(),
				"status" => "success",
				"requested_version" => $version,
				"completed_version" => $version,
				"updated_at" => time(),
			]);
			return true;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	protected function acquireCartSyncLock($pid, $lease)
	{
		return $this->acquireFileLock("cart-sync", "product-" . intval($pid), $lease, true);
	}
	protected function acquireCatalogCacheLock($nonBlocking = false)
	{
		return $this->acquireFileLock("catalog-cache", "catalog", 120, $nonBlocking, $nonBlocking ? 0 : 5);
	}
	private function prepareLockDirectory($directory)
	{
		if (!is_dir($directory)) {
			$previous_umask = umask(0027);
			try {
				$created = @mkdir($directory, 0750, true);
			} finally {
				umask($previous_umask);
			}
			if (!$created && !is_dir($directory)) {
				return false;
			}
		}
		@chmod($directory, 0750);
		return is_dir($directory) && is_writable($directory);
	}
	protected function acquireFileLock($scope, $name, $lease, $nonBlocking, $waitSeconds = 0)
	{
		$data_dir = defined("CMF_DATA") ? CMF_DATA : sys_get_temp_dir() . DIRECTORY_SEPARATOR;
		$locks_root = rtrim($data_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "locks";
		if (!$this->prepareLockDirectory($locks_root)) {
			return false;
		}
		$lock_dir = $locks_root . DIRECTORY_SEPARATOR . $scope;
		if (!$this->prepareLockDirectory($lock_dir)) {
			return false;
		}
		$name = preg_replace('/[^a-z0-9_-]/i', '', (string) $name);
		if ($name === '') {
			return false;
		}
		$path = $lock_dir . DIRECTORY_SEPARATOR . $name . ".lock";
		$previous_umask = umask(0027);
		try {
			$handle = @fopen($path, "c+");
		} finally {
			umask($previous_umask);
		}
		if (!is_resource($handle)) {
			return false;
		}
		@chmod($path, 0640);
		$deadline = microtime(true) + max(0, floatval($waitSeconds));
		$locked = false;
		do {
			$locked = @flock($handle, LOCK_EX | LOCK_NB);
			if ($locked || $nonBlocking || microtime(true) >= $deadline) {
				break;
			}
			usleep(50000);
		} while (true);
		if (!$locked) {
			fclose($handle);
			return false;
		}
		try {
			$token = bin2hex(random_bytes(16));
		} catch (\Throwable $e) {
			$token = sha1(uniqid((string) mt_rand(), true));
		}
		$lease = max(5, min(120, intval($lease)));
		$metadata = json_encode(["token" => $token, "expires_at" => time() + $lease]);
		if ($metadata === false || !ftruncate($handle, 0)) {
			flock($handle, LOCK_UN);
			fclose($handle);
			return false;
		}
		rewind($handle);
		$written = fwrite($handle, $metadata);
		if ($written !== strlen($metadata) || !fflush($handle)) {
			flock($handle, LOCK_UN);
			fclose($handle);
			return false;
		}
		return ["handle" => $handle, "path" => $path, "token" => $token, "lease" => $lease, "scope" => $scope];
	}
	protected function releaseCartSyncLock($lock)
	{
		return $this->releaseFileLock($lock);
	}
	protected function releaseFileLock($lock)
	{
		if (!is_array($lock) || !isset($lock["handle"], $lock["token"]) || !is_resource($lock["handle"])) {
			return false;
		}
		$handle = $lock["handle"];
		rewind($handle);
		$metadata = json_decode(stream_get_contents($handle), true);
		$is_owner = is_array($metadata) && isset($metadata["token"]) && hash_equals((string) $metadata["token"], (string) $lock["token"]);
		if ($is_owner) {
			ftruncate($handle, 0);
			fflush($handle);
		}
		flock($handle, LOCK_UN);
		fclose($handle);
		return $is_owner;
	}
	public function cronSyncProduct()
	{
		$apis = \think\Db::name("zjmf_finance_api")->field("id,name")->where("type", "zjmf_api")->select()->toArray();
		$currency_arr = $this->getCurrencyRateCache();
		$local_currency = \think\Db::name("currencies")->where("default", 1)->value("code");
		foreach ($apis as $api) {
			$updated_product_ids = [];
			$id = $api["id"];
			$api_name = $api["name"];
			try {
				$res = getZjmfUpstreamProductsInfo($id);
				if ($res["status"] == 200) {
				$upstream_currency = $res["data"]["currency"];
				if ($local_currency == $upstream_currency) {
					$rate = 1;
				} else {
					$rate = bcdiv($currency_arr[$local_currency], $currency_arr[$upstream_currency], 20);
				}
				$infos = $res["data"]["info"];
				$products = \think\Db::name("products")->field("id,name,description,upstream_pid,upstream_version,upstream_price_type,location_version,zjmf_api_id,gid,pay_type,
                    upstream_stock_control,upstream_qty")->where("zjmf_api_id", $id)->select()->toArray();
				$pids = $local_products = $exist = [];
				foreach ($infos as $info) {
					foreach ($products as $product) {
						if ($info["id"] == $product["upstream_pid"]) {
							$exist[] = $info["id"];
							if ($info["location_version"] != $product["upstream_version"]) {
								$pids[] = $info["id"];
								$local_products[$info["id"]] = $product;
							}
								if ($info["stock_control"] != $product["upstream_stock_control"] || $info["qty"] != $product["upstream_qty"]) {
									$product_lock = $this->acquireCartSyncLock($product["id"], 120);
									if ($product_lock !== false) {
										try {
											$current_product = \think\Db::name("products")->field("id,upstream_version,upstream_qty,upstream_stock_control")->where("id", $product["id"])->find();
											if (empty($current_product)
												|| intval($current_product["upstream_version"]) !== intval($product["upstream_version"])
												|| intval($current_product["upstream_qty"]) !== intval($product["upstream_qty"])
												|| intval($current_product["upstream_stock_control"]) !== intval($product["upstream_stock_control"])) {
												continue;
											}
											$incoming_version = intval($info["location_version"] ?? 0);
											if ($incoming_version > 0 && intval($current_product["upstream_version"]) > $incoming_version) {
												continue;
											}
											$updated_product_ids[] = $product["id"];
											\think\Db::name("products")->where("id", $product["id"])->update(["upstream_qty" => $info["qty"], "upstream_stock_control" => $info["stock_control"]]);
										} finally {
										$this->releaseCartSyncLock($product_lock);
									}
								}
							}
						}
					}
				}
				foreach ($products as $v) {
					if (!in_array($v["upstream_pid"], $exist)) {
						$desc = "商品'{$v["name"]}'无法同步,本地#PRODUCT ID:{$v["id"]},原因:供应商'{$api_name}'已删除该商品,请及时处理";
						active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
					}
				}
				$concurrent = $this->concurrent;
				$count = count($pids);
				$k = ceil($count / $concurrent);
				if ($this->cron_max < $k) {
					$k = $this->cron_max;
				}
				for ($i = 0; $i < $k; $i++) {
					$tmp = array_slice($pids, $i * $concurrent, $concurrent);
					$res = getZjmfUpstreamProductsDetail($id, $tmp);
					if ($res["status"] == 200) {
							$detail = $res["data"]["detail"];
							foreach ($detail as $key => $value) {
								$local_product = $local_products[$key];
								$product_lock = $this->acquireCartSyncLock($local_product["id"], 120);
								if ($product_lock === false) {
									continue;
								}
								try {
									$current_product = \think\Db::name("products")->where("id", $local_product["id"])->find();
									if (empty($current_product)) {
										continue;
									}
									$incoming_version = intval($value["location_version"] ?? 0);
									if ($incoming_version > 0 && intval($current_product["upstream_version"] ?? 0) >= $incoming_version) {
										continue;
									}
									$local_product = $current_product;
									$updated_product_ids[] = $local_product["id"];
									if ($local_product["upstream_price_type"] == "percent") {
										$res = $this->baseUpdateProduct($value, $local_product, $rate, true);
									} else {
										$res = $this->customUpdateProduct($value, $local_product, $rate);
									}
								} finally {
									$this->releaseCartSyncLock($product_lock);
								}
								if ($res["status"] == 200) {
									$desc = "定时任务同步供应商'{$api_name}'商品'{$value["name"]}'成功,本地#PRODUCT ID:" . $local_product["id"];
								active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
							} else {
								$desc = "定时任务同步供应商'{$api_name}'商品'{$value["name"]}'失败,本地#PRODUCT ID:{$local_product["id"]},报错信息:{$res["msg"]}";
								active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
							}
						}
					} else {
						$desc = "定时任务获取供应商'{$api_name}'商品详细信息失败,请检查供应商接口是否可用或联系供应商更新财务系统至最新版本,报错信息:{$res["msg"]}";
						active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
					}
				}
				if (empty($pids[0])) {
					$desc = "供应商'{$api_name}'暂无商品需要同步";
					active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
				}
				} else {
					$desc = "定时任务获取供应商'{$api_name}'商品版本信息失败,请检查供应商接口是否可用或联系供应商更新财务系统至最新版本,报错信息:{$res["msg"]}";
					active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
				}
			} catch (\Throwable $e) {
				$desc = "定时任务同步供应商'{$api_name}'异常,已保留成功同步的数据,报错信息:" . $e->getMessage();
				active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
			} finally {
				$this->refreshCronProductCache($updated_product_ids, $api_name);
			}
		}
		return true;
	}
	protected function refreshCronProductCache($pids, $apiName)
	{
		$pids = $this->normalizeProductIds($pids);
		if (empty($pids)) {
			return true;
		}
		try {
			if ($this->updateCache($pids) !== true) {
				throw new \RuntimeException("无法取得商品缓存构建锁");
			}
			return true;
		} catch (\Throwable $e) {
			$invalidateError = "";
			try {
				if ($this->invalidateCache($pids) !== true) {
					throw new \RuntimeException("无法取得商品缓存失效锁");
				}
			} catch (\Throwable $invalidateException) {
				$invalidateError = ",二次失效失败:" . $invalidateException->getMessage();
				error_log("Failed to invalidate cron product cache: " . $invalidateException->getMessage());
			}
			$this->markCatalogCacheDirty("cron supplier cache refresh: " . $apiName, $e->getMessage() . $invalidateError, $pids);
			$desc = "定时任务刷新供应商'{$apiName}'商品缓存失败,已保留数据库同步结果,报错信息:" . $e->getMessage() . $invalidateError;
			try {
				active_log_final(ClientActivityLog::markInternal($desc, "supplier"), 0, 5);
			} catch (\Throwable $logException) {
				error_log("Failed to record cron product cache error: " . $logException->getMessage());
			}
			return false;
		}
	}
	public function baseUpdateProduct($upstream_product, $product, $rate = 1, $is_cron = false)
	{
		$upstream_product = self::normalizeSupplierProductState($upstream_product);
		$upstream_data = $upstream_product;
		$zjmf_finance_api_id = $product["zjmf_api_id"];
		$upstream_pid = $product["upstream_pid"];
		$id = $product["id"];
		$pay_type = json_decode($upstream_product["pay_type"], true);
		if ($pay_type["pay_type"] == "day" || $pay_type["pay_type"] == "hour") {
			$pay_type["pay_type"] = "recurring";
		}
		$pay_type_local = json_decode($product["pay_type"], true);
		if ($is_cron) {
			$pay_type["clientscount_rule"] = $pay_type_local["clientscount_rule"];
		}
		$basedata = ["type" => $upstream_product["type"], "password" => $upstream_product["password"], "auto_setup" => "payment", "auto_terminate_days" => $upstream_product["auto_terminate_days"], "config_options_upgrade" => $upstream_product["config_options_upgrade"], "down_configoption_refund" => $upstream_product["down_configoption_refund"], "retired" => $upstream_product["retired"], "is_featured" => $upstream_product["is_featured"], "groupid" => $upstream_product["groupid"], "api_type" => "zjmf_api", "location_version" => $product["location_version"] + 1, "upstream_version" => $upstream_product["location_version"], "zjmf_api_id" => $zjmf_finance_api_id, "server_group" => $zjmf_finance_api_id, "upstream_pid" => $upstream_pid, "hidden" => intval($upstream_product["hidden"]), "pay_method" => $upstream_product["pay_method"], "rate" => $rate, "upstream_stock_control" => $upstream_product["stock_control"], "upstream_qty" => $upstream_product["qty"], "stock_control" => 0, "qty" => 0, "upstream_auto_setup" => $upstream_product["auto_setup"], "upstream_ontrial_status" => intval($pay_type["pay_ontrial_status"]), "upstream_product_shopping_url" => $upstream_product["product_shopping_url"] ?: ""];
		$upstream_host = json_decode($upstream_product["host"], true);
		if ($upstream_host["show"] == 0) {
			$basedata["host"] = $upstream_product["host"];
		}
		$edition = getEdition();
		if (empty($pay_type["pay_ontrial_status"]) && $edition || !$edition) {
			$basedata["pay_type"] = json_encode($pay_type);
		}
		if ($pay_type["pay_ontrial_status"] && $edition) {
			$pay_type["pay_ontrial_status"] = $pay_type_local["pay_ontrial_status"];
			$basedata["pay_type"] = json_encode($pay_type);
		}
		if ($product["first_cron"]) {
			$basedata["description"] = $upstream_product["description"];
			$basedata["allow_qty"] = $upstream_product["allow_qty"];
			$basedata["is_truename"] = $upstream_product["is_truename"];
			$basedata["is_bind_phone"] = $upstream_product["is_bind_phone"];
			$basedata["cancel_control"] = $upstream_product["cancel_control"];
			$basedata["pay_type"] = json_encode($pay_type);
		}
		$price_type = config("price_type");
		\think\Db::startTrans();
		try {
			\think\Db::name("products")->where("id", $id)->update($basedata);
			$currencies = \think\Db::name("currencies")->field("id,code")->where("default", 1)->select()->toArray();
			\think\Db::name("pricing")->where("type", "product")->where("relid", $id)->delete();
			$product_pricings = $upstream_data["product_pricings"];
			if (!empty($product_pricings[0])) {
				foreach ($currencies as $currency) {
					foreach ($product_pricings as $product_pricing) {
						if ($product_pricing["code"] == $currency["code"]) {
							unset($product_pricing["id"]);
							unset($product_pricing["code"]);
							$product_pricing["relid"] = $id;
							$product_pricing["currency"] = $currency["id"];
							if ($upstream_product["api_type"] == "zjmf_api" && $upstream_product["upstream_pid"] > 0 && $upstream_product["upstream_price_type"] == "percent") {
								foreach ($price_type as $v) {
									$product_pricing[$v[0]] = $product_pricing[$v[0]] * $upstream_product["upstream_price_value"] / 100;
									$product_pricing[$v[1]] = $product_pricing[$v[1]] * $upstream_product["upstream_price_value"] / 100;
								}
							}
							\think\Db::name("pricing")->insert($product_pricing);
						} else {
							unset($product_pricing["id"]);
							unset($product_pricing["code"]);
							$product_pricing["relid"] = $id;
							$product_pricing["currency"] = $currency["id"];
							if ($upstream_product["api_type"] == "zjmf_api" && $upstream_product["upstream_pid"] > 0 && $upstream_product["upstream_price_type"] == "percent") {
								foreach ($price_type as $v) {
									if ($product_pricing[$v[0]] >= 0) {
										$product_pricing[$v[0]] = $rate * $product_pricing[$v[0]] * $upstream_product["upstream_price_value"] / 100;
									}
									$product_pricing[$v[1]] = $rate * $product_pricing[$v[1]] * $upstream_product["upstream_price_value"] / 100;
								}
							} else {
								foreach ($price_type as $v) {
									if ($product_pricing[$v[0]] >= 0) {
										$product_pricing[$v[0]] = $product_pricing[$v[0]] * $rate;
									}
									$product_pricing[$v[1]] = $product_pricing[$v[1]] * $rate;
								}
							}
							\think\Db::name("pricing")->insert($product_pricing);
						}
					}
				}
			}
			$local_customfields = \think\Db::name("customfields")->field("id,upstream_id")->where("type", "product")->where("relid", $id)->select()->toArray();
			\think\Db::name("customfields")->where("type", "product")->where("relid", $id)->delete();
			$customfields = $upstream_data["customfields"];
			if (!empty($customfields[0])) {
				foreach ($customfields as $customfield) {
					$customfield["type"] = "product";
					$customfield["relid"] = $id;
					$customfield["adminonly"] = 0;
					$customfield["create_time"] = time();
					$customfield["update_time"] = 0;
					$customfield["upstream_id"] = $customfield["id"];
					unset($customfield["id"]);
					$new_customid = \think\Db::name("customfields")->insertGetId($customfield);
					foreach ($local_customfields as $local_customfield) {
						if ($customfield["upstream_id"] == $local_customfield["upstream_id"]) {
							\think\Db::name("customfieldsvalues")->where("fieldid", $local_customfield["id"])->update(["fieldid" => $new_customid]);
						}
					}
				}
			}
			$hostids = \think\Db::name("host")->where("productid", $id)->column("id");
			$host_links = \think\Db::name("host_config_options")->alias("a")->field("a.id,a.relid,a.configid,a.optionid,a.qty,b.upstream_id as upstream_oid,c.upstream_id as upstream_subid")->leftJoin("product_config_options b", "a.configid = b.id")->leftJoin("product_config_options_sub c", "a.optionid = c.id")->whereIn("a.relid", $hostids)->select()->toArray();
			$links = \think\Db::name("product_config_links")->where("pid", $id)->select()->toArray();
			$gids = array_column($links, "gid");
			\think\Db::name("product_config_groups")->whereIn("id", $gids)->delete();
			\think\Db::name("product_config_links")->where("pid", $id)->delete();
			$config_options = \think\Db::name("product_config_options")->whereIn("gid", $gids)->select()->toArray();
			$oids = array_column($config_options, "id");
			$sub_options = \think\Db::name("product_config_options_sub")->whereIn("config_id", $oids)->select()->toArray();
			$sub_ids = array_column($sub_options, "id");
			\think\Db::name("pricing")->where("type", "configoptions")->whereIn("relid", $sub_ids)->delete();
			\think\Db::name("product_config_options")->whereIn("id", $oids)->delete();
			\think\Db::name("product_config_options_sub")->whereIn("id", $sub_ids)->delete();
			$advanced_link_ids = \think\Db::name("product_config_options_links")->whereIn("config_id", $oids)->where("type", "condition")->where("upstream_id", ">", 0)->column("id");
			\think\Db::name("product_config_options_links")->where("type", "result")->whereIn("relation_id", $advanced_link_ids)->where("upstream_id", ">", 0)->delete();
			\think\Db::name("product_config_options_links")->whereIn("config_id", $oids)->where("type", "condition")->where("upstream_id", ">", 0)->delete();
			$config_groups = $upstream_data["config_groups"];
			if (!empty($config_groups[0])) {
				foreach ($config_groups as $config_group) {
					$options = $config_group["options"];
					$config_group["upstream_id"] = $config_group["id"];
					unset($config_group["id"]);
					unset($config_group["options"]);
					$gid = \think\Db::name("product_config_groups")->insertGetId($config_group);
					$config_link = ["gid" => $gid, "pid" => $id];
					\think\Db::name("product_config_links")->insert($config_link);
					foreach ($options as $option) {
						unset($option["advanced"]);
						$subs = $option["sub"];
						$option["upstream_id"] = $option["id"];
						unset($option["id"]);
						unset($option["gid"]);
						unset($option["sub"]);
						$option["gid"] = $gid;
						$option["auto"] = 1;
						$option["is_rebate"] = $option["is_rebate"] ?? 1;
						$option["qty_stage"] = $option["qty_stage"] ?? 0;
						$config_id = \think\Db::name("product_config_options")->insertGetId($option);
						$lingAgeArr[] = $config_id;
						foreach ($subs as $sub) {
							$pricings = $sub["pricings"];
							$sub["upstream_id"] = $sub["id"];
							unset($sub["id"]);
							unset($sub["config_id"]);
							unset($sub["pricings"]);
							$sub["config_id"] = $config_id;
							$sub_id = \think\Db::name("product_config_options_sub")->insertGetId($sub);
							foreach ($host_links as $hk => $host_link) {
								if ($host_link["upstream_oid"] == $option["upstream_id"] && $host_link["upstream_subid"] == $sub["upstream_id"]) {
									\think\Db::name("host_config_options")->where("relid", $host_link["relid"])->where("configid", $host_link["configid"])->update(["configid" => $config_id, "optionid" => $sub_id]);
									unset($host_links[$hk]);
								}
							}
							foreach ($currencies as $currency) {
								foreach ($pricings as $pricing) {
									if ($pricing["code"] == $currency["code"]) {
										unset($pricing["id"]);
										unset($pricing["currency"]);
										unset($pricing["relid"]);
										unset($pricing["code"]);
										$pricing["currency"] = $currency["id"];
										$pricing["relid"] = $sub_id;
										if ($upstream_product["api_type"] == "zjmf_api" && $upstream_product["upstream_pid"] > 0 && $upstream_product["upstream_price_type"] == "percent") {
											foreach ($price_type as $v) {
												$pricing[$v[0]] = $pricing[$v[0]] * $upstream_product["upstream_price_value"] / 100;
												$pricing[$v[1]] = $pricing[$v[1]] * $upstream_product["upstream_price_value"] / 100;
											}
										}
										\think\Db::name("pricing")->insert($pricing);
									} else {
										unset($pricing["id"]);
										unset($pricing["currency"]);
										unset($pricing["relid"]);
										unset($pricing["code"]);
										$pricing["currency"] = $currency["id"];
										$pricing["relid"] = $sub_id;
										if ($upstream_product["api_type"] == "zjmf_api" && $upstream_product["upstream_pid"] > 0 && $upstream_product["upstream_price_type"] == "percent") {
											foreach ($price_type as $v) {
												$pricing[$v[0]] = $rate * $pricing[$v[0]] * $upstream_product["upstream_price_value"] / 100;
												$pricing[$v[1]] = $rate * $pricing[$v[1]] * $upstream_product["upstream_price_value"] / 100;
											}
										} else {
											foreach ($price_type as $v) {
												$pricing[$v[0]] = $rate * $pricing[$v[0]];
												$pricing[$v[1]] = $rate * $pricing[$v[1]];
											}
										}
										\think\Db::name("pricing")->insert($pricing);
									}
								}
							}
						}
					}
				}
			}
			$advanced = $upstream_data["advanced"];
			foreach ($advanced as $m) {
				if ($m["type"] == "condition") {
					$advanced_sub_id = $m["sub_id"];
					$new_advanced_data = [];
					foreach ($advanced_sub_id as $nn => $mm) {
						$advanced_sub = \think\Db::name("product_config_options_sub")->field("config_id,id")->where("upstream_id", $nn)->order("id", "desc")->find();
						$new_advanced_sub_id = $advanced_sub["id"];
						$config_id_condition = $advanced_sub["config_id"];
						$new_advanced_data[$new_advanced_sub_id] = $mm;
					}
					$new_advanced = ["config_id" => intval($config_id_condition), "sub_id" => json_encode($new_advanced_data), "relation" => $m["relation"], "type" => $m["type"], "relation_id" => 0, "upstream_id" => $m["id"]];
					$condition_id = \think\Db::name("product_config_options_links")->insertGetId($new_advanced);
					foreach ($advanced as $m3) {
						if ($m3["type"] == "result") {
							if ($m3["relation_id"] == $m["id"]) {
								$advanced_sub_id_result = $m3["sub_id"];
								$new_advanced_data_result = [];
								foreach ($advanced_sub_id_result as $n4 => $m4) {
									$new_advanced_sub_result = \think\Db::name("product_config_options_sub")->field("config_id,id")->where("upstream_id", $n4)->order("id", "desc")->find();
									$new_advanced_sub_id_result = $new_advanced_sub_result["id"];
									$config_id_result = $new_advanced_sub_result["config_id"];
									$new_advanced_data_result[$new_advanced_sub_id_result] = $m4;
								}
								$result_advanced = ["config_id" => intval($config_id_result), "sub_id" => json_encode($new_advanced_data_result), "relation" => $m3["relation"], "type" => $m3["type"], "relation_id" => $condition_id, "upstream_id" => $m3["id"]];
								\think\Db::name("product_config_options_links")->insertGetId($result_advanced);
							}
						}
					}
				}
			}
			if (!empty($host_links[0])) {
				$link_ids = array_column($host_links, "id");
				\think\Db::name("host_config_options")->whereIn("id", $link_ids)->delete();
			}
			(new \app\common\model\ProductModel())->handleLingAge($lingAgeArr);
			\think\Db::name("info_notice")->where("relid", $id)->where("type", "product")->where("admin", 1)->update(["info" => "", "update_time" => time()]);
			\think\Db::commit();
		} catch (\Exception $e) {
			\think\Db::rollback();
			return ["status" => 400, "msg" => "同步数据失败:" . $e->getMessage()];
		}
		return ["status" => 200, "msg" => "同步数据成功"];
	}
	public function customUpdateProduct($upstream_product, $product, $rate = 1)
	{
		$pid = $product["id"];
		$group = \think\Db::name("product_groups")->where("id", $product["gid"])->find();
		$product_pricings = \think\Db::name("pricing")->alias("a")->field("a.*,b.pay_type")->leftJoin("products b", "a.relid = b.id")->where("a.type", "product")->where("b.id", $pid)->select()->toArray();
		$configoptions_pricings = \think\Db::name("pricing")->alias("a")->field("a.*,f.type")->leftJoin("product_config_options_sub b", "a.relid = b.id")->leftJoin("product_config_options c", "b.config_id = c.id")->leftJoin("product_config_links d", "c.gid = d.gid")->leftJoin("product_config_groups e", "d.gid = e.id")->leftJoin("products f", "d.pid = f.id")->where("a.type", "configoptions")->where("f.id", $pid)->select()->toArray();
		$currencies = \think\Db::name("currencies")->field("id,code")->where("default", 1)->select()->toArray();
		$price_type = config("price_type");
		$origin_price_cost = [];
		foreach ($price_type as $kkk => $vvv) {
			$currency_cost = [];
			foreach ($currencies as $currency) {
				$cost = 0;
				foreach ($product_pricings as $k => $v) {
					if ($currency["id"] == $v["currency"]) {
						$x1 = $v[$vvv[0]] < 0 ? 0 : $v[$vvv[0]];
						$y1 = $v[$vvv[1]] < 0 ? 0 : $v[$vvv[1]];
						$cost += floatval($x1) + floatval($y1);
						foreach ($configoptions_pricings as $kk => $vv) {
							if ($v["currency"] == $vv["currency"]) {
								$cost += $vv[$vvv[0]] + $vv[$vvv[1]];
							}
						}
					}
				}
				$currency_cost[$currency["code"]] = $cost;
			}
			$origin_price_cost[$kkk] = $currency_cost;
		}
		$upstream_product_pricings = $upstream_product["product_pricings"];
		$upstream_config_groups = $upstream_product["config_groups"];
		$upstream_price_cost = [];
		foreach ($price_type as $jjj => $hhh) {
			$upstream_currency_cost = [];
			foreach ($currencies as $currency) {
				$upstream_cost = 0;
				foreach ($upstream_product_pricings as $j => $h) {
					if ($currency["code"] == $h["code"]) {
						$x = $h[$hhh[0]] < 0 ? 0 : $h[$hhh[0]];
						$y = $h[$hhh[1]] < 0 ? 0 : $h[$hhh[1]];
						$upstream_cost += floatval($x) + floatval($y);
						foreach ($upstream_config_groups as $jj => $hh) {
							$options = $hh["options"];
							foreach ($options as $j4 => $h4) {
								$subs = $h4["sub"];
								foreach ($subs as $j5 => $h5) {
									$pricings = $h5["pricings"];
									foreach ($pricings as $j6 => $h6) {
										if ($h["code"] == $h6["code"]) {
											$upstream_cost += $h6[$hhh[0]] + $h6[$hhh[1]];
										}
									}
								}
							}
						}
					} else {
						$x = $h[$hhh[0]] < 0 ? 0 : $h[$hhh[0]] * $rate;
						$y = $h[$hhh[1]] < 0 ? 0 : $h[$hhh[1]] * $rate;
						$upstream_cost += floatval($x) + floatval($y);
						foreach ($upstream_config_groups as $jj => $hh) {
							$options = $hh["options"];
							foreach ($options as $j4 => $h4) {
								$subs = $h4["sub"];
								foreach ($subs as $j5 => $h5) {
									$pricings = $h5["pricings"];
									foreach ($pricings as $j6 => $h6) {
										if ($h["code"] == $h6["code"]) {
											$upstream_cost += $h6[$hhh[0]] + $h6[$hhh[1]];
										} else {
											$upstream_cost += ($h6[$hhh[0]] + $h6[$hhh[1]]) * $rate;
										}
									}
								}
							}
						}
					}
				}
				$upstream_currency_cost[$currency["code"]] = $upstream_cost;
			}
			$upstream_price_cost[$jjj] = $upstream_currency_cost;
		}
		$bilingcycle = config("billing_cycle");
		$dec = [];
		$pay_type = json_decode($product["pay_type"], true);
		$origin_price_cost_filter = [];
		if ($pay_type["pay_type"] == "onetime") {
			$origin_price_cost_filter["onetime"] = $origin_price_cost["onetime"];
		} elseif ($pay_type["pay_type"] == "recurring") {
			unset($origin_price_cost["onetime"]);
			unset($origin_price_cost["ontrial"]);
			$origin_price_cost_filter = $origin_price_cost;
		}
		if ($pay_type["pay_ontrial_status"]) {
			$origin_price_cost_filter["ontrial"] = $origin_price_cost["ontrial"];
		}
		foreach ($origin_price_cost_filter as $u => $w) {
			foreach ($currencies as $currency) {
				if ($w[$currency["code"]] < $upstream_price_cost[$u][$currency["code"]]) {
					$info = "系统检测到产品组'{$group["name"]}'中产品'{$product["name"]}'在货币为{$currency["code"]},周期为{$bilingcycle[$u]}时, 销售价低于成本价,已开启此产品库存控制,请尽快同步更新!";
					$dec[] = $info;
				}
			}
		}
			if (!empty($dec)) {
				\think\Db::name("products")->where("id", $pid)->update(["stock_control" => 1, "qty" => 0]);
				$this->refreshInventoryCache([$pid], "custom upstream price protection");
				$info = implode("\n", $dec) ?? "";
			$exist = \think\Db::name("info_notice")->where("relid", $pid)->where("type", "product")->where("admin", 1)->find();
			if ($exist) {
				\think\Db::name("info_notice")->where("relid", $pid)->where("type", "product")->where("admin", 1)->update(["info" => $info, "update_time" => time()]);
			} else {
				\think\Db::name("info_notice")->insert(["relid" => $pid, "type" => "product", "info" => $info, "admin" => 1, "create_time" => time(), "update_time" => 0]);
			}
		}
		return ["status" => 200];
	}
	public function getList($pids = [])
	{
		if (!is_array($pids)) {
			$pids = [$pids];
		}
		$where = function (\think\db\Query $query) use($pids) {
			$query->where("hidden", 0)->where("retired", 0);
			if (!empty($pids)) {
				$query->whereIn("id", $pids);
			}
		};
		$currencyid = \think\Db::name("currencies")->where("default", 1)->value("id");
		$lists = \think\Db::name("products")->field("id,type,gid,name,description,pay_method,tax,order,pay_type,api_type,
            upstream_version,upstream_price_type,upstream_price_value,stock_control,qty")->where($where)->order("order", "asc")->select()->toArray();
		$filter = [];
		foreach ($lists as $v) {
			$v = array_map(function ($value) {
				return is_string($value) ? htmlspecialchars_decode($value, ENT_QUOTES) : $value;
			}, $v);
			$paytype = (array) json_decode($v["pay_type"]);
			$pricing = \think\Db::name("pricing")->where("type", "product")->where("relid", $v["id"])->where("currency", $currencyid)->find();
			if (!empty($paytype["pay_ontrial_status"])) {
				if ($pricing["ontrial"] >= 0) {
					$v["product_price"] = $pricing["ontrial"];
					$v["setup_fee"] = $pricing["ontrialfee"];
					$v["billingcycle"] = "ontrial";
					$v["billingcycle_zh"] = lang("ONTRIAL");
				} else {
					$v["product_price"] = 0;
					$v["setup_fee"] = 0;
					$v["billingcycle"] = "";
					$v["billingcycle_zh"] = lang("PRICE_NO_CONFIG");
				}
				$v["ontrial"] = 1;
				$v["ontrial_cycle"] = $paytype["pay_ontrial_cycle"];
				$v["ontrial_cycle_type"] = $paytype["pay_ontrial_cycle_type"] ?: "day";
				$v["ontrial_price"] = $pricing["ontrial"];
				$v["ontrial_setup_fee"] = $pricing["ontrialfee"];
			} else {
				$v["ontrial"] = 0;
			}
			if ($paytype["pay_type"] == "free") {
				$v["product_price"] = 0;
				$v["setup_fee"] = 0;
				$v["billingcycle"] = "free";
				$v["billingcycle_zh"] = lang("FREE");
			} elseif ($paytype["pay_type"] == "onetime") {
				if ($pricing["onetime"] >= 0) {
					$v["product_price"] = $pricing["onetime"];
					$v["setup_fee"] = $pricing["osetupfee"];
					$v["billingcycle"] = "onetime";
					$v["billingcycle_zh"] = lang("ONETIME");
				} else {
					$v["product_price"] = 0;
					$v["setup_fee"] = 0;
					$v["billingcycle"] = "";
					$v["billingcycle_zh"] = lang("PRICE_NO_CONFIG");
				}
			} else {
				if (!empty($pricing) && $paytype["pay_type"] == "recurring") {
					if ($pricing["hour"] >= 0) {
						$v["product_price"] = $pricing["hour"];
						$v["setup_fee"] = $pricing["hsetupfee"];
						$v["billingcycle"] = "hour";
						$v["billingcycle_zh"] = lang("HOUR");
					} elseif ($pricing["day"] >= 0) {
						$v["product_price"] = $pricing["day"];
						$v["setup_fee"] = $pricing["dsetupfee"];
						$v["billingcycle"] = "day";
						$v["billingcycle_zh"] = lang("DAY");
					} elseif ($pricing["monthly"] >= 0) {
						$v["product_price"] = $pricing["monthly"];
						$v["setup_fee"] = $pricing["msetupfee"];
						$v["billingcycle"] = "monthly";
						$v["billingcycle_zh"] = lang("MONTHLY");
					} elseif ($pricing["quarterly"] >= 0) {
						$v["product_price"] = $pricing["quarterly"];
						$v["setup_fee"] = $pricing["qsetupfee"];
						$v["billingcycle"] = "quarterly";
						$v["billingcycle_zh"] = lang("QUARTERLY");
					} elseif ($pricing["semiannually"] >= 0) {
						$v["product_price"] = $pricing["semiannually"];
						$v["setup_fee"] = $pricing["ssetupfee"];
						$v["billingcycle"] = "semiannually";
						$v["billingcycle_zh"] = lang("SEMIANNUALLY");
					} elseif ($pricing["annually"] >= 0) {
						$v["product_price"] = $pricing["annually"];
						$v["setup_fee"] = $pricing["asetupfee"];
						$v["billingcycle"] = "annually";
						$v["billingcycle_zh"] = lang("ANNUALLY");
					} elseif ($pricing["biennially"] >= 0) {
						$v["product_price"] = $pricing["biennially"];
						$v["setup_fee"] = $pricing["bsetupfee"];
						$v["billingcycle"] = "biennially";
						$v["billingcycle_zh"] = lang("BIENNIALLY");
					} elseif ($pricing["triennially"] >= 0) {
						$v["product_price"] = $pricing["triennially"];
						$v["setup_fee"] = $pricing["tsetupfee"];
						$v["billingcycle"] = "triennially";
						$v["billingcycle_zh"] = lang("TRIENNIALLY");
					} elseif ($pricing["fourly"] >= 0) {
						$v["product_price"] = $pricing["fourly"];
						$v["setup_fee"] = $pricing["foursetupfee"];
						$v["billingcycle"] = "fourly";
						$v["billingcycle_zh"] = lang("FOURLY");
					} elseif ($pricing["fively"] >= 0) {
						$v["product_price"] = $pricing["fively"];
						$v["setup_fee"] = $pricing["fivesetupfee"];
						$v["billingcycle"] = "fively";
						$v["billingcycle_zh"] = lang("FIVELY");
					} elseif ($pricing["sixly"] >= 0) {
						$v["product_price"] = $pricing["sixly"];
						$v["setup_fee"] = $pricing["sixsetupfee"];
						$v["billingcycle"] = "sixly";
						$v["billingcycle_zh"] = lang("SIXLY");
					} elseif ($pricing["sevenly"] >= 0) {
						$v["product_price"] = $pricing["sevenly"];
						$v["setup_fee"] = $pricing["sevensetupfee"];
						$v["billingcycle"] = "sevenly";
						$v["billingcycle_zh"] = lang("SEVENLY");
					} elseif ($pricing["eightly"] >= 0) {
						$v["product_price"] = $pricing["eightly"];
						$v["setup_fee"] = $pricing["eightsetupfee"];
						$v["billingcycle"] = "eightly";
						$v["billingcycle_zh"] = lang("EIGHTLY");
					} elseif ($pricing["ninely"] >= 0) {
						$v["product_price"] = $pricing["ninely"];
						$v["setup_fee"] = $pricing["ninesetupfee"];
						$v["billingcycle"] = "ninely";
						$v["billingcycle_zh"] = lang("NINELY");
					} elseif ($pricing["tenly"] >= 0) {
						$v["product_price"] = $pricing["tenly"];
						$v["setup_fee"] = $pricing["tensetupfee"];
						$v["billingcycle"] = "tenly";
						$v["billingcycle_zh"] = lang("TENLY");
					} else {
						$v["product_price"] = 0;
						$v["setup_fee"] = 0;
						$v["billingcycle"] = "";
						$v["billingcycle_zh"] = lang("PRICE_CONFIG_ERROR");
					}
				} else {
					$v["product_price"] = 0;
					$v["setup_fee"] = 0;
					$v["billingcycle"] = "";
					$v["billingcycle_zh"] = lang("PRICE_NO_CONFIG");
				}
			}
			if ($paytype["pay_type"] == "recurring" && in_array($v["type"], array_keys(config("developer_app_product_type")))) {
				if ($pricing["annually"] > 0) {
					$v["product_price"] = $pricing["annually"];
					$v["setup_fee"] = $pricing["asetupfee"];
					$v["billingcycle"] = "annually";
					$v["billingcycle_zh"] = lang("ANNUALLY");
				}
			}
			$v["product_price"] = bcadd($v["setup_fee"], $v["product_price"], 2);
			$cart_logic = new Cart();
			$rebate_total = 0;
			$config_total = $cart_logic->getProductDefaultConfigPrice($v["id"], $currencyid, $v["billingcycle"], $rebate_total);
			$rebate_total = bcadd($v["product_price"], $rebate_total, 2);
			$v["product_price"] = bcadd($v["product_price"], $config_total, 2);
			if ($v["api_type"] == "zjmf_api" && $v["upstream_version"] > 0 && $v["upstream_price_type"] == "percent") {
				$v["product_price"] = bcmul($v["product_price"], $v["upstream_price_value"] / 100, 2);
				if ($v["ontrial"] == 1) {
					$v["ontrial_price"] = bcmul($v["ontrial_price"], $v["upstream_price_value"] / 100, 2);
					$v["ontrial_setup_fee"] = bcmul($v["ontrial_setup_fee"], $v["upstream_price_value"] / 100, 2);
				}
				$rebate_total = bcmul($rebate_total, $v["upstream_price_value"] / 100, 2);
			}
			$cgs = \think\Db::name("client_groups")->alias("a")->field("a.id,b.type,b.bates")->leftJoin("user_product_bates b", "a.id=b.user")->leftJoin("user_products c", "b.products=c.gid")->where("c.pid", $v["id"])->select()->toArray();
			$cg_f = [];
			foreach ($cgs as $cg) {
				if ($cg["type"] == 1) {
					$bates = bcdiv($cg["bates"], 100, 2);
					$rebate = bcmul($rebate_total, 1 - $bates, 2) < 0 ? 0 : bcmul($rebate_total, 1 - $bates, 2);
					$cg["sale_price"] = bcsub($v["product_price"], $rebate, 2) < 0 ? 0 : bcsub($v["product_price"], $rebate, 2);
					$cg["bates"] = bcmul($v["product_price"], 1 - $bates, 2);
				} else {
					$bates = $cg["bates"];
					$rebate = $rebate_total < $bates ? $rebate_total : $bates;
					$cg["sale_price"] = bcsub($v["product_price"], $rebate, 2) < 0 ? 0 : bcsub($v["product_price"], $rebate, 2);
					$cg["bates"] = $bates;
				}
				$cg_f[$cg["id"]] = $cg;
			}
			$v["cgs"] = $cg_f;
			unset($v["pay_method"]);
			unset($v["tax"]);
			unset($v["order"]);
			unset($v["pay_type"]);
			unset($v["api_type"]);
			unset($v["upstream_version"]);
			unset($v["upstream_price_type"]);
			unset($v["upstream_price_value"]);
			$filter[$v["id"]] = $v;
		}
		return $filter;
	}
	public function updateListCache($pids = [], $force = false)
	{
		$pids = $this->normalizeProductIds($pids);
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			$this->markCatalogCacheDirty("list cache rebuild", "无法取得商品缓存构建锁", $pids);
			return false;
		}
		try {
			if (!$force && empty($pids) && !empty($this->getListCache())) {
				return true;
			}
			$result = $this->updateListCacheUnlocked($pids, $force);
			if ($result !== true) {
				$this->markCatalogCacheDirty("list cache rebuild", "商品列表缓存写入失败", $pids);
			}
			return $result;
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function updateListCacheUnlocked($pids = [], $force = false)
	{
		$pids = $this->normalizeProductIds($pids);
		$list = $this->getListCache();
		if (empty($list) || $force || empty($pids)) {
			$list = $this->getList();
		} else {
			foreach ($pids as $pid) {
				unset($list[$pid]);
			}
			$tmp = $this->getList($pids);
			$list = $tmp + $list;
		}
		if ($list) {
			if (cache($this->list_name, json_encode($list)) === false) {
				return false;
			}
		} else {
			if (!$this->deleteCacheKey($this->list_name)) {
				return false;
			}
		}
		unset($list);
		unset($tmp);
		return true;
	}
	public function getListCache()
	{
		$list = cache($this->list_name);
		return json_decode($list, true);
	}
	public function deleteListCache()
	{
		$lock = $this->acquireCatalogCacheLock();
		if ($lock === false) {
			return false;
		}
		try {
			return $this->deleteListCacheUnlocked();
		} finally {
			$this->releaseFileLock($lock);
		}
	}
	private function deleteListCacheUnlocked()
	{
		return $this->deleteCacheKey($this->list_name);
	}
}
