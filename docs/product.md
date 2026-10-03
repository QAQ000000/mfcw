# 产品与业务模型

本文记录当前 3.7.7 分支已经实现的业务边界，帮助开发者先理解业务关系，再选择入口和
数据表。它不是新功能需求书；未在源码、路由或迁移中确认的能力不能当作已实现功能。

## 产品定位

系统为云主机、独立服务器及其他可配置服务提供销售和运维入口，连接客户、财务流程和
上游资源供应商。客户可以浏览商品、配置购物车、下单支付、管理已购买主机、续费和提交
工单；管理员负责商品、订单、账单、支付、插件、客户和上游接口配置。

## 参与者

| 参与者 | 主要职责 | 权限边界 |
| --- | --- | --- |
| 访客 | 浏览官网、商品和公开接口，登录或注册 | 没有客户私有数据权限 |
| 客户主账户 | 购买和管理自己的服务、账单、充值、工单和认证资料 | 由客户 JWT、Cookie 和 `uid` 约束 |
| 联系人/子账户 | 代表主账户处理被授予的客户中心能力 | 权限来自联系人记录，不等同于主账户 |
| 管理员 | 管理客户、商品、订单、财务、插件、任务和日志 | 由后台认证和管理权限约束 |
| 上游财务/资源系统 | 提供商品、库存、开通和主机控制能力 | 通过已配置 API、JWT 和供应商权限访问 |
| Cron/队列 worker | 执行定时同步、到期处理、通知和异步任务 | 使用实例自己的数据库和配置 |

## 核心业务链路

```text
客户/访客
  -> 官网或客户中心
  -> 商品列表与配置选项
  -> 购物车快照
  -> 创建订单
  -> 生成或关联账单
  -> 支付/余额/人工审核
  -> 服务器模块或上游接口开通
  -> 本地主机记录与通知
  -> 续费、暂停、恢复、控制、终止或工单支持
```

商品可以是本地资源，也可以通过 `api_type`、上游 API 和上游商品 ID 关联供应商。上游
调用成功不代表本地所有状态已经完成：开通、同步和通知可能由回调、Cron 或队列继续处理，
因此修改业务时必须同时检查本地状态、上游返回和异步任务。

## 关系速览

```text
clients -> contacts
clients -> orders -> invoices -> invoice_items
products -> pricing / product_config_* / host
orders -> host
host -> ticket -> ticket_reply
clients, products, host -> upstream API or server module
```

## 领域对象

| 对象 | 逻辑表 | 关系和用途 |
| --- | --- | --- |
| 客户 | `clients` | 主账户、余额、认证、通知和登录状态；物理表通常是 `shd_clients` |
| 联系人 | `contacts` | 归属于客户主账户，可有独立登录和通知权限 |
| 产品 | `products` | 商品、计费方式、库存、开通策略和服务器模块配置 |
| 价格 | `pricing` | 产品或配置项按货币、账期保存价格 |
| 购物车 | `cart_session`、购物车相关表 | 保存配置和价格快照，不能直接当作已支付订单 |
| 订单 | `orders` | 记录客户购买意图、订单号、金额、优惠和关联账单 |
| 账单 | `invoices`、`invoice_items` | 记录应收金额、项目、支付和退款状态 |
| 主机/服务 | `host` | 客户购买后的服务实例、到期日、状态和上游标识 |
| 工单 | `ticket`、`ticket_reply` | 客户支持、部门分派以及上下游转发 |
| 插件 | `plugin` | 已安装插件、启停状态和序列化配置 |
| 队列任务 | `jobs` | 数据库队列任务，物理表通常是 `shd_jobs` |

## 关键状态

状态值由 `app/config/public.php`、校验器和业务逻辑共同决定，新增状态前必须同步这些
来源。当前常见状态包括：

- 客户：`0` 未激活、`1` 正常、`2` 关闭。
- 订单：`Pending`、`Active`、`Cancelled`、`Fraud`、`Suspended` 等，具体转换以订单
  逻辑和配置为准。
- 账单：`Paid`、`Unpaid`、`Refunded`、`Cancelled`、`Overdue` 等。
- 主机：`Pending`、`Active`、`Suspended`、`Cancelled`、`Fraud`、`Deleted`。

状态显示名称不等于 HTTP 状态码；API 的 `status` 字段也可能是业务状态。业务代码不得
只修改显示状态而跳过开通、计费、库存或上游调用。

## 入口选择

| 需求 | 首先查看 |
| --- | --- |
| 客户 API | `data/route/openapi.php`、`app/openapi/controller/`、`docs/02-api.md` |
| 客户中心页面 | `data/route/home.php`、`app/home/controller/`、`public/themes/clientarea/` |
| 购物车 | `app/common/logic/Cart.php`、`public/themes/cart/` |
| 后台配置 | `data/route/admin.php`、`app/admin/controller/` |
| 上游调用 | `app/zjmf.php`、`app/common/logic/`、`docs/12-server-modules.md` |
| 通知 | `app/common/logic/Email.php`、`Sms.php`、队列 Job 和对应插件文档 |
