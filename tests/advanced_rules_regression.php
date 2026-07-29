<?php

namespace think {
	class Db
	{
		private static $tables = [];
		private static $nextIds = [];
		private static $transactions = [];

		public static function seed(array $tables)
		{
			self::$tables = [];
			self::$nextIds = [];
			self::$transactions = [];
			foreach ($tables as $table => $rows) {
				self::$tables[$table] = array_values($rows);
				$ids = array_map(function ($row) {
					return intval(isset($row["id"]) ? $row["id"] : 0);
				}, $rows);
				self::$nextIds[$table] = empty($ids) ? 1 : max($ids) + 1;
			}
		}

		public static function name($table)
		{
			return new MemoryQuery($table);
		}

		public static function rows($table)
		{
			return isset(self::$tables[$table]) ? self::$tables[$table] : [];
		}

		public static function insert($table, array $row)
		{
			if (!isset(self::$tables[$table])) {
				self::$tables[$table] = [];
				self::$nextIds[$table] = 1;
			}
			if (!isset($row["id"])) {
				$row["id"] = self::$nextIds[$table]++;
			} else {
				self::$nextIds[$table] = max(self::$nextIds[$table], intval($row["id"]) + 1);
			}
			self::$tables[$table][] = $row;
			return intval($row["id"]);
		}

		public static function startTrans()
		{
			self::$transactions[] = [self::$tables, self::$nextIds];
		}

		public static function commit()
		{
			array_pop(self::$transactions);
		}

		public static function rollback()
		{
			$snapshot = array_pop(self::$transactions);
			if ($snapshot) {
				self::$tables = $snapshot[0];
				self::$nextIds = $snapshot[1];
			}
		}
	}

	class MemoryCollection
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

	class MemoryQuery
	{
		private $table;
		private $alias;
		private $joins = [];
		private $conditions = [];
		private $fields;
		private $excludeFields = false;
		private $orderField;
		private $orderDirection = "asc";

		public function __construct($table)
		{
			$this->table = $table;
			$this->alias = $table;
		}

		public function alias($alias)
		{
			$this->alias = $alias;
			return $this;
		}

		public function leftJoin($table, $condition)
		{
			$parts = preg_split('/\s+/', trim($table));
			$joinTable = $parts[0];
			$joinAlias = count($parts) > 1 ? $parts[count($parts) - 1] : $joinTable;
			$this->joins[] = [$joinTable, $joinAlias, $condition];
			return $this;
		}

		public function field($fields, $exclude = false)
		{
			$this->fields = $fields;
			$this->excludeFields = $exclude;
			return $this;
		}

		public function where($field, $operator = null, $value = null)
		{
			if (func_num_args() === 2) {
				$value = $operator;
				$operator = "=";
			}
			$this->conditions[] = ["compare", $field, strtolower((string) $operator), $value];
			return $this;
		}

		public function whereIn($field, $values)
		{
			$this->conditions[] = ["in", $field, array_values((array) $values)];
			return $this;
		}

		public function order($field, $direction = "asc")
		{
			$this->orderField = $field;
			$this->orderDirection = strtolower($direction);
			return $this;
		}

		public function select()
		{
			$rows = [];
			foreach ($this->contexts() as $context) {
				$rows[] = $this->project($context);
			}
			return new MemoryCollection($rows);
		}

		public function find()
		{
			$contexts = $this->contexts();
			return empty($contexts) ? null : $this->project($contexts[0]);
		}

		public function column($field)
		{
			$values = [];
			foreach ($this->contexts() as $context) {
				$values[] = $this->fieldValue($context, $field);
			}
			return $values;
		}

		public function max($field)
		{
			$values = $this->column($field);
			return empty($values) ? null : max($values);
		}

		public function insertGetId(array $row)
		{
			return Db::insert($this->table, $row);
		}

		public function insertAll(array $rows)
		{
			foreach ($rows as $row) {
				Db::insert($this->table, $row);
			}
			return count($rows);
		}

		private function contexts()
		{
			$contexts = [];
			foreach (Db::rows($this->table) as $row) {
				$contexts[] = [$this->alias => $row];
			}
			foreach ($this->joins as $join) {
				list($joinTable, $joinAlias, $expression) = $join;
				$next = [];
				foreach ($contexts as $context) {
					$matched = false;
					foreach (Db::rows($joinTable) as $joinRow) {
						$candidate = $context;
						$candidate[$joinAlias] = $joinRow;
						if ($this->joinMatches($candidate, $expression)) {
							$matched = true;
							$next[] = $candidate;
						}
					}
					if (!$matched) {
						$context[$joinAlias] = [];
						$next[] = $context;
					}
				}
				$contexts = $next;
			}
			$contexts = array_values(array_filter($contexts, function ($context) {
				return $this->matches($context);
			}));
			if ($this->orderField !== null) {
				$field = $this->orderField;
				$direction = $this->orderDirection;
				usort($contexts, function ($left, $right) use($field, $direction) {
					$comparison = $this->fieldValue($left, $field) <=> $this->fieldValue($right, $field);
					return $direction === "desc" ? -$comparison : $comparison;
				});
			}
			return $contexts;
		}

		private function joinMatches(array $context, $expression)
		{
			$parts = preg_split('/\s*=\s*/', trim($expression));
			return count($parts) === 2 && $this->fieldValue($context, $parts[0]) == $this->fieldValue($context, $parts[1]);
		}

		private function matches(array $context)
		{
			foreach ($this->conditions as $condition) {
				if ($condition[0] === "in") {
					if (!in_array($this->fieldValue($context, $condition[1]), $condition[2])) {
						return false;
					}
					continue;
				}
				$actual = $this->fieldValue($context, $condition[1]);
				$operator = $condition[2];
				$expected = $condition[3];
				if ($operator === "=" && $actual != $expected) {
					return false;
				}
				if (($operator === "<>" || $operator === "!=") && $actual == $expected) {
					return false;
				}
			}
			return true;
		}

		private function fieldValue(array $context, $field)
		{
			$field = str_replace("`", "", trim($field));
			if (strpos($field, ".") !== false) {
				list($alias, $name) = explode(".", $field, 2);
				return isset($context[$alias][$name]) ? $context[$alias][$name] : null;
			}
			if (isset($context[$this->alias]) && array_key_exists($field, $context[$this->alias])) {
				return $context[$this->alias][$field];
			}
			foreach ($context as $row) {
				if (array_key_exists($field, $row)) {
					return $row[$field];
				}
			}
			return null;
		}

		private function project(array $context)
		{
			$base = isset($context[$this->alias]) ? $context[$this->alias] : [];
			if ($this->fields === null) {
				return $base;
			}
			$fields = is_array($this->fields) ? $this->fields : preg_split('/\s*,\s*/', $this->fields);
			if ($this->excludeFields) {
				foreach ($fields as $field) {
					unset($base[$field]);
				}
				return $base;
			}
			$result = [];
			foreach ($fields as $field) {
				$field = trim($field);
				$parts = preg_split('/\s+as\s+/i', $field);
				$source = $parts[0];
				$key = isset($parts[1]) ? $parts[1] : (strpos($source, ".") === false ? $source : substr($source, strrpos($source, ".") + 1));
				$result[$key] = $this->fieldValue($context, $source);
			}
			return $result;
		}
	}
}

namespace app\admin\controller {
	class AdminBaseController
	{
		public $request;
		public $lang = ["Product_admin_duplicate" => "duplicate %s as %s"];
	}
}

namespace app\common\logic {
	class Product
	{
		public static $updated = [];

		public function updateCache($pids = [])
		{
			self::$updated = $pids;
			return true;
		}
	}
}

namespace app\common\model {
	class ProductModel
	{
		public function setLinkAge($mode)
		{
			return $this;
		}

		public function handleLingAge($ids)
		{
			return true;
		}
	}
}

namespace {
	function lang($message)
	{
		return $message;
	}

	function jsonrule($data = [])
	{
		return $data;
	}

	function active_log($description)
	{
		return true;
	}

	class AdvancedRulesTestRequest
	{
		private $params;

		public function __construct(array $params)
		{
			$this->params = $params;
		}

		public function param($name = null)
		{
			return $name === null ? $this->params : (isset($this->params[$name]) ? $this->params[$name] : null);
		}
	}

	function assertAdvancedRule($condition, $message)
	{
		if (!$condition) {
			fwrite(STDERR, "FAIL: " . $message . PHP_EOL);
			exit(1);
		}
	}

	function findById(array $rows, $id)
	{
		foreach ($rows as $row) {
			if (intval($row["id"]) === intval($id)) {
				return $row;
			}
		}
		return null;
	}

	function findRule(array $rules, $relation)
	{
		foreach ($rules as $rule) {
			if ($rule["relation"] === $relation) {
				return $rule;
			}
		}
		return null;
	}

	function findMappedRow(array $rows, $copyId)
	{
		foreach ($rows as $row) {
			if (intval(isset($row["copy_id"]) ? $row["copy_id"] : 0) === intval($copyId)) {
				return $row;
			}
		}
		return null;
	}

	require dirname(__DIR__) . "/app/common/model/SeniorConfModel.php";
	require dirname(__DIR__) . "/app/admin/controller/ProductController.php";

	\think\Db::seed([
		"product_config_groups" => [
			["id" => 10, "global" => 1],
			["id" => 20, "global" => 0],
			["id" => 30, "global" => 0],
			["id" => 40, "global" => 0],
		],
		"product_config_links" => [
			["id" => 1, "gid" => 10, "pid" => 1],
			["id" => 2, "gid" => 20, "pid" => 1],
			["id" => 3, "gid" => 10, "pid" => 2],
			["id" => 4, "gid" => 30, "pid" => 2],
			["id" => 5, "gid" => 10, "pid" => 3],
			["id" => 6, "gid" => 40, "pid" => 3],
		],
		"product_config_options" => [
			["id" => 100, "gid" => 10, "hidden" => 0],
			["id" => 110, "gid" => 10, "hidden" => 1],
			["id" => 201, "gid" => 20, "hidden" => 0],
			["id" => 202, "gid" => 20, "hidden" => 1],
			["id" => 301, "gid" => 30, "hidden" => 0],
			["id" => 401, "gid" => 40, "hidden" => 0],
		],
		"product_config_options_links" => [
			["id" => 1, "config_id" => 100, "sub_id" => "{}", "relation" => "visible-to-hidden", "type" => "condition", "relation_id" => 0],
			["id" => 2, "config_id" => 202, "sub_id" => "{}", "relation" => "hidden-result", "type" => "result", "relation_id" => 1],
			["id" => 3, "config_id" => 110, "sub_id" => "{}", "relation" => "hidden-to-visible", "type" => "condition", "relation_id" => 0],
			["id" => 4, "config_id" => 201, "sub_id" => "{}", "relation" => "visible-result", "type" => "result", "relation_id" => 3],
			["id" => 5, "config_id" => 100, "sub_id" => "{}", "relation" => "shared-global", "type" => "condition", "relation_id" => 0],
			["id" => 6, "config_id" => 201, "sub_id" => "{}", "relation" => "product-one-result", "type" => "result", "relation_id" => 5],
			["id" => 7, "config_id" => 301, "sub_id" => "{}", "relation" => "product-two-result", "type" => "result", "relation_id" => 5],
			["id" => 8, "config_id" => 201, "sub_id" => "{}", "relation" => "orphan-result", "type" => "result", "relation_id" => 999],
			["id" => 9, "config_id" => 100, "sub_id" => "{}", "relation" => "empty-condition", "type" => "condition", "relation_id" => 0],
		],
	]);

	$model = new \app\common\model\SeniorConfModel();
	$productOneRules = $model->getProductUseConfLinksList(1);
	$visibleCondition = findRule($productOneRules, "visible-to-hidden");
	assertAdvancedRule($visibleCondition !== null, "a visible condition must be returned");
	assertAdvancedRule(count($visibleCondition["result"]) === 1 && intval($visibleCondition["result"][0]["id"]) === 2, "a hidden result controlled by a visible condition must be retained");

	$productOneExchange = $model->getProductUseConfLinksListExchange(1);
	$visibleResult = findRule($productOneExchange, "visible-result");
	assertAdvancedRule($visibleResult !== null, "a visible result must be returned by the exchange view");
	assertAdvancedRule(count($visibleResult["result"]) === 1 && intval($visibleResult["result"][0]["id"]) === 3, "a hidden condition controlling a visible result must be retained");

	$productTwoRules = $model->getProductUseConfLinksList(2);
	$productOneShared = findRule($productOneRules, "shared-global");
	$productTwoShared = findRule($productTwoRules, "shared-global");
	assertAdvancedRule(count($productOneShared["result"]) === 1 && $productOneShared["result"][0]["relation"] === "product-one-result", "a shared global condition must only include product one's local result");
	assertAdvancedRule(count($productTwoShared["result"]) === 1 && $productTwoShared["result"][0]["relation"] === "product-two-result", "a shared global condition must only include product two's local result");
	assertAdvancedRule($model->getProductUseConfLinksList(3) === [], "a condition with no result in the current product scope must not be returned empty");

	$flatRules = $model->getProductUseConfLinksFlatMap([100, 110, 201, 202, 301]);
	assertAdvancedRule(findRule($flatRules, "orphan-result") === null, "an orphan result relation must be skipped");
	assertAdvancedRule(findRule($flatRules, "empty-condition") === null, "a condition without an in-scope result must be skipped");

	\think\Db::seed([
		"products" => [
			["id" => 1, "name" => "source", "order" => 1, "create_time" => 1, "update_time" => 1, "resource_pid" => 88],
		],
		"product_config_groups" => [
			["id" => 10, "name" => "global", "description" => "global", "upstream_id" => 0, "global" => 1],
			["id" => 20, "name" => "local", "description" => "local", "upstream_id" => 0, "global" => 0],
		],
		"product_config_links" => [
			["id" => 1, "gid" => 10, "pid" => 1],
			["id" => 2, "gid" => 20, "pid" => 1],
		],
		"product_config_options" => [
			["id" => 100, "gid" => 10, "hidden" => 0, "name" => "global condition"],
			["id" => 101, "gid" => 10, "hidden" => 0, "name" => "global result"],
			["id" => 200, "gid" => 20, "hidden" => 0, "name" => "local condition"],
			["id" => 201, "gid" => 20, "hidden" => 0, "name" => "local result"],
		],
		"product_config_options_sub" => [
			["id" => 1000, "config_id" => 100, "option_name" => "global condition sub"],
			["id" => 1010, "config_id" => 101, "option_name" => "global result sub"],
			["id" => 2000, "config_id" => 200, "option_name" => "local condition sub"],
			["id" => 2010, "config_id" => 201, "option_name" => "local result sub"],
		],
		"product_config_options_links" => [
			["id" => 1, "config_id" => 200, "sub_id" => "{\"2000\":1}", "relation" => "ll-condition", "type" => "condition", "relation_id" => 0, "upstream_id" => 9],
			["id" => 2, "config_id" => 201, "sub_id" => "{\"2010\":1}", "relation" => "ll-result", "type" => "result", "relation_id" => 1, "upstream_id" => 9],
			["id" => 3, "config_id" => 100, "sub_id" => "{\"1000\":1}", "relation" => "gg-condition", "type" => "condition", "relation_id" => 0, "upstream_id" => 9],
			["id" => 4, "config_id" => 101, "sub_id" => "{\"1010\":1}", "relation" => "gg-result", "type" => "result", "relation_id" => 3, "upstream_id" => 9],
			["id" => 5, "config_id" => 100, "sub_id" => "{\"1000\":1}", "relation" => "gl-condition", "type" => "condition", "relation_id" => 0, "upstream_id" => 9],
			["id" => 6, "config_id" => 201, "sub_id" => "{\"2010\":1}", "relation" => "gl-result", "type" => "result", "relation_id" => 5, "upstream_id" => 9],
			["id" => 7, "config_id" => 200, "sub_id" => "{\"2000\":1}", "relation" => "lg-condition", "type" => "condition", "relation_id" => 0, "upstream_id" => 9],
			["id" => 8, "config_id" => 101, "sub_id" => "{\"1010\":1}", "relation" => "lg-result", "type" => "result", "relation_id" => 7, "upstream_id" => 9],
			["id" => 9, "config_id" => 201, "sub_id" => "{\"2010\":1}", "relation" => "orphan-copy-result", "type" => "result", "relation_id" => 999, "upstream_id" => 9],
			["id" => 10, "config_id" => 200, "sub_id" => "{\"2000\":1}", "relation" => "orphan-copy-condition", "type" => "condition", "relation_id" => 0, "upstream_id" => 9],
		],
		"pricing" => [],
		"customfields" => [],
		"product_upgrade_products" => [],
		"product_downloads" => [],
	]);

	$controller = new \app\admin\controller\ProductController();
	$controller->request = new AdvancedRulesTestRequest(["existingproduct" => 1, "newproductname" => "copy"]);
	$response = $controller->duplicate();
	assertAdvancedRule($response["status"] === 200 && intval($response["pid"]) === 2, "the product duplicate operation must complete in the fixture");
	assertAdvancedRule(\app\common\logic\Product::$updated === [2], "the duplicated product cache must be rebuilt");

	$options = \think\Db::rows("product_config_options");
	$subs = \think\Db::rows("product_config_options_sub");
	$newLocalConditionOption = findMappedRow($options, 200);
	$newLocalResultOption = findMappedRow($options, 201);
	$newLocalConditionSub = findMappedRow($subs, 2000);
	$newLocalResultSub = findMappedRow($subs, 2010);
	assertAdvancedRule($newLocalConditionOption !== null && $newLocalResultOption !== null, "local configuration options must be copied");
	assertAdvancedRule($newLocalConditionSub !== null && $newLocalResultSub !== null, "local configuration sub-options must be copied");

	$allRules = \think\Db::rows("product_config_options_links");
	$newRules = array_values(array_filter($allRules, function ($rule) {
		return intval($rule["id"]) > 10;
	}));
	assertAdvancedRule(count($newRules) === 5, "only the five required copied links must be inserted");

	$newLlCondition = findRule($newRules, "ll-condition");
	$newLlResult = findRule($newRules, "ll-result");
	assertAdvancedRule(intval($newLlCondition["config_id"]) === intval($newLocalConditionOption["id"]), "local/local must copy the condition to the new local option");
	assertAdvancedRule(intval($newLlResult["config_id"]) === intval($newLocalResultOption["id"]) && intval($newLlResult["relation_id"]) === intval($newLlCondition["id"]), "local/local must copy and reconnect its result");

	assertAdvancedRule(findRule($newRules, "gg-condition") === null && findRule($newRules, "gg-result") === null, "global/global rules must remain shared without duplicate rows");
	assertAdvancedRule(findById($allRules, 3) !== null && findById($allRules, 4) !== null, "the original global/global relation must remain intact");
	$globalGroupShared = false;
	foreach (\think\Db::rows("product_config_links") as $configGroupLink) {
		if (intval($configGroupLink["gid"]) === 10 && intval($configGroupLink["pid"]) === 2) {
			$globalGroupShared = true;
		}
	}
	assertAdvancedRule($globalGroupShared, "global/global rules must remain available through the shared group on the copied product");

	$newGlResult = findRule($newRules, "gl-result");
	assertAdvancedRule(intval($newGlResult["config_id"]) === intval($newLocalResultOption["id"]) && intval($newGlResult["relation_id"]) === 5, "global/local must attach the copied local result to the shared global condition");
	assertAdvancedRule(findRule($newRules, "gl-condition") === null, "global/local must not duplicate its global condition");

	$newLgCondition = findRule($newRules, "lg-condition");
	$newLgResult = findRule($newRules, "lg-result");
	assertAdvancedRule(intval($newLgCondition["config_id"]) === intval($newLocalConditionOption["id"]), "local/global must copy its local condition");
	assertAdvancedRule(intval($newLgResult["config_id"]) === 101 && intval($newLgResult["relation_id"]) === intval($newLgCondition["id"]), "local/global must reconnect a product-specific global result to the copied condition");

	assertAdvancedRule(findRule($newRules, "orphan-copy-result") === null, "duplicate must skip an orphan result relation");
	assertAdvancedRule(findRule($newRules, "orphan-copy-condition") === null, "duplicate must skip a condition without a result");
	assertAdvancedRule(json_decode($newLlCondition["sub_id"], true) === [intval($newLocalConditionSub["id"]) => 1], "copied condition sub-option IDs must be remapped");
	assertAdvancedRule(json_decode($newLlResult["sub_id"], true) === [intval($newLocalResultSub["id"]) => 1], "copied result sub-option IDs must be remapped");

	fwrite(STDOUT, "advanced rules regression checks passed" . PHP_EOL);
}
