<?php

namespace app\api\controller;

use think\Db;

class FlowPacketController
{
    public function flowPacketList()
    {
        $packets = Db::name('dcim_flow_packet')
            ->field('id,name,capacity,price,allow_products,sale_times,stock')
            ->where('status', 1)
            ->select()
            ->toArray();

        $productIds = [];
        foreach ($packets as $packet) {
            $productIds = array_merge($productIds, $this->parseProductIds($packet['allow_products']));
        }
        $productMap = $this->getProductMap($productIds);

        foreach ($packets as $key => $packet) {
            $packets[$key] = $this->formatPacket($packet, $productMap);
			if (empty($packets[$key]['product'])) {
				unset($packets[$key]);
			}
        }
		$packets = array_values($packets);

        return json([
            'status' => 200,
            'msg' => '请求成功',
            'data' => [
                'list' => $packets,
                'count' => count($packets),
            ],
        ]);
    }

    public function flowPacketIndex()
    {
        $id = (int) request()->param('id', 0);
        $packet = Db::name('dcim_flow_packet')
            ->field('id,name,capacity,price,allow_products,sale_times,stock')
            ->where('status', 1)
            ->where('id', $id)
            ->find();

        if (!empty($packet)) {
            $productMap = $this->getProductMap($this->parseProductIds($packet['allow_products']));
            $packet = $this->formatPacket($packet, $productMap);
			if (empty($packet['product'])) {
				$packet = [];
			}
        } else {
            $packet = [];
        }

        return json([
            'status' => 200,
            'msg' => '请求成功',
            'data' => (object) $packet,
        ]);
    }

    private function parseProductIds($allowProducts)
    {
        $ids = array_map('intval', explode(',', (string) $allowProducts));
        return array_values(array_unique(array_filter($ids, function ($id) {
            return $id > 0;
        })));
    }

    private function getProductMap(array $productIds)
    {
        if (empty($productIds)) {
            return [];
        }
        $products = Db::name('products')
			->alias('p')
			->leftJoin('product_groups g', 'g.id=p.gid')
			->field('p.id,p.name')
			->whereIn('p.id', array_values(array_unique($productIds)))
			->where('p.hidden', 0)
			->where('g.hidden', 0)
			->where('p.api_type', '<>', 'resource')
            ->select()
            ->toArray();
        return array_column($products, 'name', 'id');
    }

    private function formatPacket(array $packet, array $productMap)
    {
        if ((int) $packet['stock'] === 0) {
            $packet['stock_enable'] = 0;
        } else {
            $packet['stock_enable'] = 1;
            $packet['stock'] = max(0, (int) $packet['stock'] - (int) $packet['sale_times']);
        }

        $packet['product'] = [];
        foreach ($this->parseProductIds($packet['allow_products']) as $productId) {
            if (isset($productMap[$productId])) {
                $packet['product'][] = [
                    'id' => $productId,
                    'name' => $productMap[$productId],
                ];
            }
        }
        unset($packet['allow_products'], $packet['sale_times']);
        return $packet;
    }
}
