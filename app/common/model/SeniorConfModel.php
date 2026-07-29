<?php

namespace app\common\model;

class SeniorConfModel
{
	public function getProductUseConfLinksList($product_id)
	{
		$scope = $this->getProductConfigIdScope($product_id);
		return $this->getProductUseConfLinksMap($scope["visible"], $scope["all"]);
	}
	public function getProductUseConfLinksMap($config_id, $result_scope_id = null, $include_empty = false)
	{
		$condition_ids = $this->normalizeConfigIds($config_id);
		$result_scope_ids = $result_scope_id === null ? $condition_ids : $this->normalizeConfigIds($result_scope_id);
		$data = $this->getScopedConfLinksData($condition_ids, $result_scope_ids, $include_empty);
		$result_map = [];
		foreach ($data["results"] as $result) {
			$result_map[$result["relation_id"]][] = $this->pickFields($result, ["id", "config_id", "relation", "sub_id"]);
		}
		$res_data = [];
		foreach ($data["conditions"] as $condition) {
			$res = $this->pickFields($condition, ["id", "config_id", "relation", "sub_id"]);
			$res["result"] = $result_map[$condition["id"]] ?? [];
			$res_data[] = $res;
		}
		return $res_data;
	}
	public function getProductUseConfLinksListExchange($product_id)
	{
		$scope = $this->getProductConfigIdScope($product_id);
		return $this->getProductUseConfLinksMapExchange($scope["visible"], $scope["all"]);
	}
	public function getProductUseConfLinksMapExchange($config_id, $condition_scope_id = null)
	{
		$result_ids = $this->normalizeConfigIds($config_id);
		$condition_scope_ids = $condition_scope_id === null ? $result_ids : $this->normalizeConfigIds($condition_scope_id);
		$data = $this->getScopedConfLinksData($condition_scope_ids, $result_ids);
		$condition_map = [];
		foreach ($data["conditions"] as $condition) {
			$condition_map[$condition["id"]] = $this->pickFields($condition, ["id", "config_id", "relation", "sub_id"]);
		}
		$res_data = [];
		foreach ($data["results"] as $result) {
			$res = $this->pickFields($result, ["id", "config_id", "relation", "sub_id", "relation_id"]);
			$res["result"] = isset($condition_map[$result["relation_id"]]) ? [$condition_map[$result["relation_id"]]] : [];
			$res_data[] = $res;
		}
		return $res_data;
	}
	public function getProductUseConfLinksDetailMap($config_id)
	{
		$config_ids = $this->normalizeConfigIds($config_id);
		$data = $this->getScopedConfLinksData($config_ids, $config_ids);
		$result_map = [];
		foreach ($data["results"] as $result) {
			$result_map[$result["relation_id"]][] = $result;
		}
		foreach ($data["conditions"] as &$condition) {
			$condition["result"] = $result_map[$condition["id"]] ?? [];
		}
		unset($condition);
		return $data["conditions"];
	}
	public function getProductUseConfLinksFlatMap($config_id)
	{
		$config_ids = $this->normalizeConfigIds($config_id);
		$data = $this->getScopedConfLinksData($config_ids, $config_ids);
		$links = array_merge($data["conditions"], $data["results"]);
		usort($links, function ($a, $b) {
			return intval($a["id"]) <=> intval($b["id"]);
		});
		return $links;
	}
	private function getScopedConfLinksData($condition_config_id, $result_config_id, $include_empty = false)
	{
		$condition_config_ids = $this->normalizeConfigIds($condition_config_id);
		$result_config_ids = $this->normalizeConfigIds($result_config_id);
		if (empty($condition_config_ids) || empty($result_config_ids)) {
			return ["conditions" => [], "results" => []];
		}
		$conditions = $this->resultToArray(\think\Db::name("product_config_options_links")->whereIn("config_id", $condition_config_ids)->where("type", "condition")->where("relation_id", 0)->order("id", "asc")->select());
		$condition_ids = array_column($conditions, "id");
		$results = [];
		if (!empty($condition_ids)) {
			$results = $this->resultToArray(\think\Db::name("product_config_options_links")->whereIn("config_id", $result_config_ids)->whereIn("relation_id", $condition_ids)->where("type", "result")->order("id", "asc")->select());
		}
		if (!$include_empty) {
			$result_condition_ids = array_fill_keys(array_map("intval", array_column($results, "relation_id")), true);
			$conditions = array_values(array_filter($conditions, function ($condition) use($result_condition_ids) {
				return isset($result_condition_ids[intval($condition["id"])]);
			}));
		}
		foreach ($conditions as &$condition) {
			$condition["sub_id"] = json_decode($condition["sub_id"], true);
		}
		unset($condition);
		foreach ($results as &$result) {
			$result["sub_id"] = json_decode($result["sub_id"], true);
		}
		unset($result);
		return ["conditions" => $conditions, "results" => $results];
	}
	private function getProductConfigIdScope($product_id)
	{
		$options = $this->resultToArray(\think\Db::name("product_config_options")->alias("pco")->field("pco.id,pco.hidden")->leftJoin("product_config_links pcl", "pcl.gid = pco.gid")->where("pcl.pid", intval($product_id))->select());
		$all = [];
		$visible = [];
		foreach ($options as $option) {
			$id = intval($option["id"] ?? 0);
			if ($id <= 0) {
				continue;
			}
			$all[] = $id;
			if (intval($option["hidden"] ?? 0) === 0) {
				$visible[] = $id;
			}
		}
		return ["all" => $this->normalizeConfigIds($all), "visible" => $this->normalizeConfigIds($visible)];
	}
	private function normalizeConfigIds($config_id)
	{
		$config_ids = is_array($config_id) ? $config_id : [$config_id];
		return array_values(array_unique(array_filter(array_map("intval", $config_ids))));
	}
	private function resultToArray($result)
	{
		return is_object($result) && method_exists($result, "toArray") ? $result->toArray() : (array) $result;
	}
	private function pickFields($data, $fields)
	{
		$result = [];
		foreach ($fields as $field) {
			$result[$field] = $data[$field];
		}
		return $result;
	}
	public function getProductConfOne($config_id)
	{
		return \think\Db::name("product_config_options")->where("id", $config_id)->find();
	}
	public function getProductUseConfSubNames($sub_ids)
	{
		return \think\Db::name("product_config_options_sub")->whereIn("id", $sub_ids)->column("option_name");
	}
}
