# 数据库说明

本文是面向开发和升级的数据库地图，不替代安装 SQL。完整初始结构以
[`public/install/thinkcmf.sql`](../public/install/thinkcmf.sql) 为准，版本变更以
[`public/upgrade/`](../public/upgrade/) 中的迁移为准。

## 基本约定

- 逻辑表名通过 ThinkPHP 的表前缀配置映射到物理表；默认安装 SQL 使用 `shd_` 前缀，
  例如 `Db::name("clients")` 对应 `shd_clients`。
- 当前结构主要依赖应用层关系，安装 SQL 没有为核心业务建立完整的数据库外键。不能因为
  SQL 没有外键就认为记录可以脱离客户、订单或产品存在。
- 时间字段大多是 Unix 时间戳，客户创建日期等少数字段是日期字符串；修改时按现有字段和
  调用方保持一致。
- 金额字段使用 `decimal`，不能使用浮点数计算或相信客户端提交的金额。入账必须以本地
  订单/账单和支付回调验签后的结果为准。

## 核心关系

```text
clients 1 ── N contacts
clients 1 ── N orders ── 1 invoices ── N invoice_items
products 1 ── N pricing
products 1 ── N host
orders 1 ── N host
host 1 ── N ticket
ticket 1 ── N ticket_reply
products 1 ── N product_config_* / cart snapshot
clients/products/host ── 上游 API 或服务器模块
```

这些关系由 `uid`、`productid`、`orderid`、`invoiceid`、`rel_id`、`host_id` 等字段和应用
逻辑维护，迁移或清理数据时必须检查反向引用。

## 主要表

| 逻辑表 | 关键字段 | 约束和用途 |
| --- | --- | --- |
| `clients` | `id`、`uuid`、`email`、`phonenumber`、`credit`、`status` | 主账户、余额、登录和通知配置；`id` 主键，`wechat_id` 有唯一索引 |
| `contacts` | `id`、`uid`、`email`、`permissions`、`status` | 主账户联系人；`uid` 指向客户主账户，`wechat_id` 有唯一索引 |
| `products` | `id`、`gid`、`type`、`pay_type`、`pay_method`、`stock_control`、`qty`、`server_type` | 商品、库存和开通策略；`gid`、库存和上游字段由产品逻辑共同维护 |
| `pricing` | `type`、`currency`、`relid`、各账期价格 | 产品/配置项价格；有 `(type, relid)` 索引，不应随意假设全局唯一 |
| `cart_session` | 会话和客户关联字段 | 购物车状态，不代表订单或支付成功；缓存失效和快照版本需同时考虑 |
| `orders` | `id`、`uid`、`ordernum`、`amount`、`invoiceid`、`status` | 订单主记录；订单号、金额、状态与账单和服务开通需要保持一致 |
| `invoices` | `id`、`uid`、`status`、金额字段 | 应收账单；支付、退款和到期逻辑依赖状态和项目明细 |
| `invoice_items` | `invoice_id`、`uid`、`type`、`rel_id`、金额字段 | 账单项目，关联产品、主机或其他计费对象 |
| `host` | `id`、`uid`、`productid`、`orderid`、`serverid`、`domainstatus`、`nextduedate` | 已购买服务和上游资源标识；主机归属校验必须使用服务端 `uid` |
| `ticket` / `ticket_reply` | `tid`、`uid`、`host_id`、`status`、回复时间 | 工单和回复；附件、部门和上下游转发有额外契约 |
| `jobs` | `queue`、`payload`、`attempts`、`reserved`、`available_at` | 数据库队列；由独立 worker 消费，不应在多个实例之间共享连接配置 |
| `configuration` | `setting`、`value` | 系统配置和 Cron 锁/运行时间；物理表没有主键，写入要沿用配置辅助函数 |
| `plugin` | `name`、`status`、`config`、`module` | 插件发现、启停和配置；插件安装要保持幂等 |

## 状态与写入规则

1. 跨表创建订单、账单、订单项目和服务时，先校验客户、产品、价格和库存，再在事务中
   写入本地记录。
2. 支付回调先验签，再按本地账单查询金额、币种和状态；重复通知必须幂等，不能重复入账。
3. 库存同步只更新上游库存字段和相关缓存；本地销售库存、商品名称等字段必须按产品逻辑
   的明确契约处理。
4. 主机状态变更要经过 `app/common/logic/Host.php`、服务器模块或对应控制器，不能直接
   批量改 `domainstatus` 绕过暂停、终止和日志副作用。
5. 删除或归档客户、产品、订单、主机前，检查订单、账单、工单、日志、插件和上游 ID 的
   引用；默认采用业务上的取消/关闭状态保留审计记录。

## 迁移规则

- 新版本迁移放入 `public/upgrade/<version>.sql`，保持可重复执行或由升级器保证只执行一次。
- 修改安装结构时同步更新 `public/install/thinkcmf.sql`，并为已有实例提供升级 SQL。
- 迁移不得覆盖实例 `app/config/database.php`、上传文件、运行时缓存或日志。
- 迁移前备份数据库，迁移后检查表、索引、字段、版本记录和关键业务查询；升级流程见
  [`README.md`](../README.md) 和 [部署说明](deployment.md)。

## 数据库变更完成标准

- 说明受影响的表、字段、索引和旧数据处理方式。
- 提供升级前后兼容策略及重复执行行为。
- 对订单、支付、库存、队列或权限变更增加对应回归测试。
- 在隔离 MySQL/MariaDB 测试库执行迁移；不要拿生产业务库做破坏性验证。
