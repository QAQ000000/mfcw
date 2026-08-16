# 支付网关插件

## 1. 入口与职责

客户支付的主要入口为：

| 方法与路径 | 处理器 | 作用 |
| --- | --- | --- |
| `GET /get_gateways/:module` | `PayController::getGatewayList()` | 返回启用网关 |
| `POST /start_pay` | `PayController::startPay()` | 校验账单归属并启动网关 |
| `POST /check_order` | `OrderController::checkOrder()` | 查询本地支付状态 |
| `ANY /gateway/:plugin/:controller/:action` | `GatewayController` 动态分发 | 网关同步、异步回调 |

客户 OpenAPI 的支付与余额入口均位于强制 JWT 分组：

| 方法与路径 | 处理器 | 作用 |
| --- | --- | --- |
| `POST /v1/pay` | `openapi/PayController::pay()` | 返回支付页数据并启动网关 |
| `POST /v1/invoices/:id/fund` | `PayController::fund()` | 对账单使用余额 |
| `DELETE /v1/invoices/:id/fund` | `PayController::fundDelete()` | 撤销账单余额抵扣 |
| `POST /v1/invoices/:id/credit` | `PayController::credit()` | 使用信用额支付 |
| `GET /v1/invoices/:id/status` | `PayController::status()` | 查询本地账单状态 |

`/start_pay` 最终调用 `app/home/common.php::start_pay()`。它从数据库重新读取账单、余额、
用户货币和商品名，再通过 `shook()` 分发到网关。插件不得另设以客户端金额直接创建支付
的入口。

动态回调路由由 `InitHookBehavior` 注册，不经过客户登录中间件。回调控制器必须把它当作
公网不可信入口，完整完成供应商认证后才能记账。

## 2. 网关契约

网关位于 `public/plugins/gateways/<name>/`，主类继承 `app\admin\lib\Plugin`，实现
`install()`、`uninstall()` 以及 `<Name>Handle(array $param)`。方法大小写应与
`getGatewayInfo()` 的目录名转换结果一致；以现有 `AliPayHandle()`、`WxPayHandle()`
和 `UserCustomHandle()` 为准。

启动参数由系统生成：

```php
[
    'out_trade_no' => 123,             // 本地账单 ID
    'product_name' => '公司名 + 商品名',
    'total_fee' => '99.00',            // 当前应付余额
    'attach' => 'type@uid@id@total@gateway',
    'fee_type' => 'CNY',
]
```

`attach` 只是兼容数据，不是可信签名。创建供应商订单时仍应以本地账单查询结果为准，
不要在回调中反序列化它并直接决定用户、金额或支付方式。

网关返回 `['type' => <type>, 'data' => <payload>]`：

| `type` | `data` | 前端用途 |
| --- | --- | --- |
| `url` | 二维码内容 URL | 由系统前端生成二维码 |
| `insert` | 供应商提供的二维码或可插入内容 | 直接展示供应商结果 |
| `jump` | 完整 HTTPS 支付地址 | 跳转供应商收银台 |
| `html` | 表单或线下支付说明 HTML | 作为网关内容渲染 |

异常应抛出不含密钥的 `Exception` 或返回系统可识别的错误。不要输出半个表单后再抛错，
也不要在主类中直接 `exit`。

## 3. 配置与回调控制器

根目录 `config.php` 使用通用插件配置格式。常见配置包括商户号、应用 ID、公私钥、
API 密钥、支持币种和支付产品开关。回调地址可作为只读展示字段，但运行时应从可信的
站点域名配置构造，不允许客户端覆盖。

回调控制器通常放在：

```text
public/plugins/gateways/<name>/controller/IndexController.php
```

例如异步地址为 `/gateway/<name>/index/notifyHandle`。向核心提交的数据契约为：

```php
check_pay([
    'invoice_id' => $localInvoiceId,
    'trans_id' => $providerTransactionId,
    'currency' => $providerCurrency,
    'payment' => $pluginName,
    'amount_in' => $providerAmount,
    'paid_time' => $providerPaidTime,
]);
```

`check_pay()` 只是 `OrderController::orderPayHandle()` 的薄封装，不负责供应商验签。
调用它之前，插件必须同时确认：

1. 消息签名或 webhook 证书有效，且使用原始请求体按供应商规范验证；
2. 供应商交易状态明确为最终支付成功，不是创建、待付、关闭或退款状态；
3. 商户号、应用 ID、收款账户与当前插件配置完全一致；
4. 供应商订单号映射到预期本地账单，不能只信任附加字段；
5. 实收金额与本地应付金额按最小货币单位精确相等，币种也相等；
6. 供应商交易号非空且稳定，可作为幂等键；
7. 支付时间和事件 ID 合理，重复或乱序通知不会重复记账。

只有本地记账成功后才能向供应商回复成功。同步浏览器跳转只用于展示结果，不应作为
最终入账依据；页面应轮询 `/check_order` 或等待异步通知。

## 4. 调用生命周期

```text
POST /start_pay {invoiceid, payment}
  -> 校验当前客户拥有未删除、未支付账单
  -> gateway_list() 限制为启用网关
  -> start_pay() 重新计算剩余应付金额与币种
  -> <Name>Handle() 调供应商创建订单
  -> 返回 url/insert/jump/html 给前端

供应商异步通知
  -> /gateway/<name>/index/notifyHandle
  -> 验签 + 状态/商户/订单/金额/币种校验
  -> check_pay(<normalized data>)
  -> accounts 流水 + invoices 状态 + processPaidInvoice()
  -> 成功提交后回复供应商

浏览器返回
  -> 只跳回本地结果页
  -> POST /check_order 获取本地最终状态
```

PayPal 等需要在浏览器返回阶段向供应商执行支付的接口，应先在供应商 API 查询并执行，
再按同样的最终状态校验处理；浏览器提交的 payer ID 或 token 本身不构成支付证明。

## 5. 安全风险与加固要求

- 历史网关开发文档只说“处理相关验证”，没有把验签、交易状态、金额、币种和商户
  校验列为强制项。新网关必须执行上一节的全部条件，代码评审不能只看到 `check_pay()`。
- `orderPayHandle()` 在金额不足时也会先写 `payment_status=Paid`，而账单 `status` 可能
  仍非 `Paid`；币种不一致时还会把供应商金额替换成本地总额。修复前，插件必须在进入
  核心前严格拒绝少付和错币种，监控两种状态字段不一致的账单。
- `/v1/invoices/:id/fund` 最终保存 `downstream_url`、`downstream_token` 和
  `downstream_id` 到主机 `stream_info` 时只检查字段格式，没有要求当前 JWT 是资源 API
  身份。普通客户可为自己的相关账单提交回推目标，后续主机或工单同步可能向该地址发送
  数据。修复时应只允许经过服务身份认证且与已登记下游匹配的请求更新这些字段，并对
  URL 使用 HTTPS 精确白名单及出站网络限制。
- Alipay 示例在调用本地记账之前就输出 `success`。这会让本地失败后供应商停止重试；
  应根据事务结果最后回复，并记录可关联但已脱敏的失败事件。
- 核心检查已支付账单和已存在 `accounts.trans_id`，但未确认数据库存在相应唯一约束。
  并发通知仍可能穿过先查后写；应为供应商交易号建立合适的唯一索引，并把幂等检查、
  流水插入和账单状态条件更新放入同一事务。
- `html` 和 `insert` 是插件信任内容。只能安装可信网关；线下说明应经过允许标签净化，
  在线支付优先使用固定本地模板和跳转 URL，不渲染供应商可控脚本。
- `jump` URL 必须限定 HTTPS 和供应商精确域名，禁止 `javascript:`、协议相对 URL、
  用户可控回跳域和开放重定向。
- 金额使用数据库定点值或整数最小货币单位比较，不能用二进制浮点近似决定是否入账。
- 密钥轮换需要兼容通知延迟；日志不得记录私钥、签名原文、完整支付 token 或客户账单
  明细。

## 6. 实现检查

1. 覆盖签名错误、非成功状态、错商户、错账单、少付、多付、错币种和空交易号。
2. 并发发送同一事件和不同事件的同一交易号，确认只生成一条流水并只处理一次账单。
3. 模拟本地事务失败，确认供应商收到失败响应并会重试。
4. 测试桌面、移动、二维码、取消支付、浏览器重复返回和异步通知乱序。
5. 检查停用网关不能启动新支付，同时为已创建订单保留受控的通知处理迁移方案。

## 7. 权威源码

- 客户支付入口：`data/route/home.php`、`app/home/controller/PayController.php`。
- OpenAPI 支付入口：`data/route/openapi.php`、
  `app/openapi/controller/PayController.php`。
- 支付参数与网关分发：`app/home/common.php`、`app/openapi/common.php`。
- 网关类名映射与 `check_pay()`：`app/common.php`。
- 动态回调路由：`vendor/thinkcmf/cmf/src/behavior/InitHookBehavior.php`。
- 本地记账：`app/home/controller/OrderController.php`。
- 官方历史契约：`public/plugins/gateways/gateways_document.md`。
- 可审查示例：`public/plugins/gateways/ali_pay/`、`wx_pay/`、`paypal/`、
  `user_custom/`。
