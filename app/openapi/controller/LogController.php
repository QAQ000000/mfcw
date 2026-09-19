<?php

namespace app\openapi\controller;

use app\common\logic\ClientActivityLog;

/**
 * @title 日志
 * @description 接口说明
 */
class LogController extends \cmf\controller\HomeBaseController
{
	public function systemLog(\think\Request $request)
	{
		$uid = request()->uid;
		if (!$uid) {
			return json(["status" => 400, "msg" => lang("ID_ERROR")]);
		}
		$param = $request->param();
		$page = isset($param["page"]) ? intval($param["page"]) : config("page");
		$limit = isset($param["limit"]) ? intval($param["limit"]) : (configuration("NumRecordstoDisplay") ?: config("limit"));
		$orderby = strval($param["orderby"]) ? strval($param["orderby"]) : "id";
		$sorting = $param["sorting"] ?? "DESC";
		$order = ClientActivityLog::buildPaginationOrder($orderby, $sorting, "create_time");
		$fun = function (\think\db\Query $query) use($uid, $param) {
			$query->where("uid", $uid);
			$query->where("type", "neq", 1);
			$query->where(function (\think\db\Query $query) {
				$query->where("usertype", "Client")->whereOr("usertype", "Sub-Account");
			});
			if (!empty($param["search_time"])) {
				$start_time = strtotime(date("Y-m-d", $param["search_time"]));
				$end_time = strtotime("+1 days", $start_time);
				$query->whereBetweenTime("create_time", $start_time, $end_time);
			}
		};
		$visibility = function (\think\db\Query $query) {
			ClientActivityLog::applyVisibilityFilter($query);
		};
		$logs = \think\Db::name("activity_log")->field("id,description,ipaddr ip,port,create_time,user")->where($fun)->where($visibility)->where(function (\think\db\Query $query) use($param) {
			if (!empty($param["keywords"])) {
				$search_desc = $param["keywords"];
				$query->whereOr("description", "like", "%{$search_desc}%");
				$query->whereOr("ipaddr", "like", "%{$search_desc}%");
			}
		})->withAttr("description", function ($value, $data) {
			$pattern = "/(?P<name>\\w+ ID):(?P<digit>\\d+)/";
			preg_match_all($pattern, $value, $matches);
			$name = $matches["name"];
			$digit = $matches["digit"];
			if (!empty($name)) {
				if (defined("VIEW_TEMPLATE_WEBSITE") && VIEW_TEMPLATE_WEBSITE) {
					foreach ($name as $k => $v) {
						$relid = $digit[$k];
						$str = $v . ":" . $relid;
						if ($v == "Invoice ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/billing\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "User ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/details\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Host ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/servicedetail?id=" . $relid . "\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Order ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/billing\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Ticket ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/viewticket?tid=" . $relid . "\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Transaction ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"/billing\"><span>" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						}
					}
				} else {
					foreach ($name as $k => $v) {
						$relid = $digit[$k];
						$str = $v . ":" . $relid;
						if ($v == "Invoice ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/finance\"><span class=\"el-link--inner\" style=\"display: block;height: 24px;line-height: 24px;\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "User ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/personal-center\"><span class=\"el-link--inner\" style=\"display: block;height: 24px;line-height: 24px;\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Host ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/server/log?id=" . $relid . "\"><span class=\"el-link--inner\" style=\"display: block;height: 24px;line-height: 24px;\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Order ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/finance?id=" . $relid . "\"><span class=\"el-link--inner\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Ticket ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/tickets/viewticket?tid=" . $relid . "\"><span class=\"el-link--inner\"  style=\"display: block;height: 24px;line-height: 24px;\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						} elseif ($v == "Transaction ID") {
							$url = "<a class=\"el-link el-link--primary is-underline\" href=\"#/finance\"><span class=\"el-link--inner\"  style=\"display: block;height: 24px;line-height: 24px;\">" . $str . "</span></a>";
							$value = str_replace($str, $url, $value);
						}
					}
				}
				return $value;
			} else {
				return $value;
			}
		})->order($order)->page($page)->limit($limit)->select()->toArray();
		$count = \think\Db::name("activity_log")->where($fun)->where($visibility)->where(function (\think\db\Query $query) use($param) {
			if (!empty($param["keywords"])) {
				$search_desc = $param["keywords"];
				$query->whereOr("description", "like", "%{$search_desc}%");
				$query->whereOr("ipaddr", "like", "%{$search_desc}%");
			}
		})->count();
		$returndata = [];
		$returndata["total"] = $count;
		$returndata["log"] = $logs;
		return json(["status" => 200, "msg" => lang("SUCCESS MESSAGE"), "data" => $returndata]);
	}
	public function loginLog(\think\Request $request)
	{
		$page = $request->param("page", 1);
		$limit = $request->param("limit", 10);
		$orderby = $request->param("orderby", "id");
		$sort = $request->param("sort", "desc");
			$where[] = ["uid", "=", $request->uid];
			$param = $request->param();
			$where[] = ["type", "=", 1];
			$visibility = function (\think\db\Query $query) {
				\app\common\logic\ClientActivityLog::applyVisibilityFilter($query);
			};
			$res = \think\Db::name("activity_log")->field("id,description,ipaddr ip,port,create_time,user")->where($where)->where($visibility)->where(function (\think\db\Query $query) use($param) {
			if (!empty($param["keywords"])) {
				$search_desc = $param["keywords"];
				$query->whereOr("description", "like", "%{$search_desc}%");
				$query->whereOr("ipaddr", "like", "%{$search_desc}%");
			}
		})->page($page, $limit)->order($orderby, $sort)->select()->toArray();
			$count = \think\Db::name("activity_log")->where($where)->where($visibility)->where(function (\think\db\Query $query) use($param) {
			if (!empty($param["keywords"])) {
				$search_desc = $param["keywords"];
				$query->whereOr("description", "like", "%{$search_desc}%");
				$query->whereOr("ipaddr", "like", "%{$search_desc}%");
			}
		})->count();
		$data = ["total" => $count, "log" => $res];
		return json(["data" => $data, "status" => "200", "msg" => lang("SUCCESS MESSAGE")]);
	}
	private function structureApiLogDescription($description)
	{
		$plain = html_entity_decode((string) $description, ENT_QUOTES | ENT_HTML5, "UTF-8");
		$plain = trim(strip_tags($plain));
		$referenceTypes = [
			"Invoice ID" => "invoice",
			"User ID" => "user",
			"Host ID" => "host",
			"Order ID" => "order",
			"Ticket ID" => "ticket",
			"Transaction ID" => "transaction",
		];
		$parts = [];
		$offset = 0;
		preg_match_all('/(?:Invoice|User|Host|Order|Ticket|Transaction) ID:\d+/', $plain, $matches, PREG_OFFSET_CAPTURE);
		foreach ($matches[0] as $match) {
			$text = $match[0];
			$position = $match[1];
			if ($position > $offset) {
				$parts[] = ["type" => "text", "text" => substr($plain, $offset, $position - $offset)];
			}
			preg_match('/^(.* ID):(\d+)$/', $text, $reference);
			$parts[] = [
				"type" => "reference",
				"text" => $text,
				"resource" => $referenceTypes[$reference[1]],
				"id" => $reference[2],
			];
			$offset = $position + strlen($text);
		}
		if ($offset < strlen($plain)) {
			$parts[] = ["type" => "text", "text" => substr($plain, $offset)];
		} elseif (empty($parts) && $plain !== "") {
			$parts[] = ["type" => "text", "text" => $plain];
		}
		return [
			"description" => htmlspecialchars($plain, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"),
			"description_parts" => $parts,
		];
	}
	public function apiLog()
	{
		$param = $this->request->param();
		$page = !empty($param["page"]) ? intval($param["page"]) : config("page");
		$limit = !empty($param["limit"]) ? intval($param["limit"]) : config("limit");
		$order = !empty($param["order"]) ? trim($param["order"]) : "a.id";
		$sort = !empty($param["sort"]) ? trim($param["sort"]) : "DESC";
		$where = function (\think\db\Query $query) use($param) {
			$query->where("a.uid", request()->uid);
			if (!empty($param["keywords"])) {
				$keyword = $param["keywords"];
				$query->where("a.ip|a.description|b.username|a.port", "like", "%{$keyword}%");
			}
		};
		$logs = \think\Db::name("api_resource_log")->alias("a")->field("a.id,a.description,a.ip,a.port,a.create_time,b.username user")->leftJoin("clients b", "a.uid = b.id")->where($where)->order($order, $sort)->page($page)->limit($limit)->select()->toArray();
		foreach ($logs as $key => $log) {
			$logs[$key] = array_merge($log, $this->structureApiLogDescription($log["description"]));
		}
		$count = \think\Db::name("api_resource_log")->alias("a")->leftJoin("clients b", "a.uid = b.id")->where($where)->count();
		$data = ["log" => $logs, "total" => $count];
		return json(["status" => 200, "msg" => lang("SUCCESS MESSAGE"), "data" => $data]);
	}
}
