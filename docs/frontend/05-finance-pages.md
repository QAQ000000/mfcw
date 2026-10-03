# 财务页面

财务页面包括账单、交易、充值、发票、余额、信用额和支付，模板主要位于客户中心主题，接口由
`home/pay`、`home/user_invoice`、`home/credit_limit`、`home/Voucher`、订单和支付逻辑处理。`clients.credit` 是预存余额，`credit_limit` 是信用额度，两者不能合并。

## 页面契约

| 页面 | 主要区域 | 验收重点 |
| --- | --- | --- |
| `/billing` | 账单筛选、状态、金额、详情和支付按钮 | 未付/已付/逾期/取消、分页和权限 |
| `/invoicelist` 及其 action 分支 | 发票申请记录、可开票账单选择、开具确认及发票详情，见下文 | 开票金额与税费/邮费分开；抬头、邮寄地址、申请状态和客户归属 |
| `/viewbilling` | 账单抬头、项目、金额、支付方式 | 金额来自服务端，重复支付有明确结果 |
| `/addfunds` | 充值金额、支付方式、余额 | 最小金额、支付取消、回调延迟和余额刷新 |
| `/credit`（`credit.tpl`） | 信用额度、已用/剩余额度、账单生成日、还款日期、还款账单 | `GET credit_limit`、`GET credit_limit/user_invoice`；专业版本及全局/客户信用额开关 |
| `/invoicecompany`、`/invoiceaddress` | 发票信息和地址表单 | 字段校验、保存失败回填、权限边界 |
| `/transaction` | 交易、余额及信用额支付记录等分类流水 | 金额方向、时间、分页和空状态 |
| `/creditdetail`（`creditdetail.tpl`） | 信用额已用明细或信用额还款账单详情 | `action=used` 与账单详情分支、客户归属、付款状态 |

## 发票申请、列表与详情

事实来源：[页面控制器](../../app/home/controller/ViewClientsController.php#L1212)、[发票接口](../../app/home/controller/VoucherController.php)、[现有模板](../../public/themes/clientarea/default/invoicelist.tpl)、[状态配置](../../app/app.php)。以下旧布局来自默认模板；移动端重排、空选禁用和失败处理是新模板要求，尚未运行验收。申请流程实际在 `invoicelist.tpl` 内分支，不应仅凭存在 `invoiceapply.tpl` 就建立另一条申请路由。

| 入口/分支 | 现有排版和交互 | 新模板保留的内容与响应式要求 |
| --- | --- | --- |
| `/invoicelist` 默认列表 | 顶部“发票申请”入口；中部表格按申请时间、抬头、开票总额、申请状态、邮寄地址、快递、操作排列；底部分页；每行查看详情，Unpaid 时另显示支付 | 开票总额取 `invoices_subtotal`，不取税费/邮费账单的 `amount`；手机按时间/状态→抬头/金额→地址/快递→操作逐条排列，地址允许换行；无记录仍保留申请入口 |
| `?action=invoiceapply` | 上部搜索；可开票账单表按勾选、账单号、金额、类型、支付时间、单笔开具排列；表下批量开具按钮及分页 | `keywords` 实际按账单 ID 查找；可选账单来自服务端，不把普通账单列表当候选集；空选禁用批量开具，分页/刷新后重新核对选择；手机每条账单保留 checkbox、金额和开具入口 |
| `?action=invoiceapply&type=issue&invoice_ids[]=…` | 顶部个人/公司单选；下一行左抬头、右快递选择；邮寄地址整行；下方项目/金额/税率/税额表；底部税费及邮费摘要、返回和确认操作 | 切换个人/公司同步切换抬头集合，提交的是抬头 `type_id`；缺抬头/地址时禁用确认并提供 `/invoicecompany`、`/invoiceaddress` 入口，返回时保留候选账单；手机表单单列，明细仅内部滚动，摘要与确认同区；具体字段见[接口契约](13-page-api-contract.md#前台发票接口) |
| `?action=check&id=<voucher.id>` | 上部性质、抬头、快递及整行邮寄地址；中部产品说明、金额、税率、税额表；底部税费加邮费 | 详情 ID 是申请记录 ID，不是付款账单 ID；增加返回列表及申请状态/备注区，手机信息单列；`data.voucher` 缺失显示不可用，不能呈现空白成功详情 |
| `/invoicecompany`、`/invoiceaddress` | 独立的抬头和收货地址管理，提供列表、新增/编辑及删除 | 抬头区分个人/公司、普通/专用发票；公司表单含税号、开户行、账号、公司地址、电话；地址含收件人、电话、省市区、详细地址、邮编、默认标记；保存成功重查，失败保留输入，已使用记录删除失败保留原行 |

申请状态使用当前 `voucher_status`：`Unpaid` 待支付、`Pending` 待审核、`Reject` 已驳回、`Send` 已发出。它们不是账单的 Paid/Cancelled/Overdue。提交先创建 Unpaid 的申请及税费/邮费账单；付款处理将申请更新为 Pending；后台可将 Pending 或 Unpaid 改为 Reject/Send，因此不能假定“已发出必然已付款”。当前配置没有 Cancelled，不能按旧控制器注释添加客户取消按钮或取消状态。

`POST /voucher/issuevoucher` 业务 200 返回 `data.invoice_id`，可进入 `/viewbilling?id=…` 支付税费/邮费；业务 1001 为零费用分支，没有 `data.invoice_id`，应刷新申请列表核对状态。400 或缺少必要数据保留表单，不跳转、不自动重试；超时先核对申请列表和账单，避免重复开票。金额及税率来自服务端，申请和付款结果分别查询。

验收使用[测试文档](18-frontend-test-acceptance.md)的 I01–I03，覆盖单笔/多笔、无候选/空选、个人/公司抬头、邮寄信息、零费用/收费、驳回/已发出及跨客户访问。现有写入对候选账单归属/资格及抬头编辑的校验缺口见[接口契约](13-page-api-contract.md#前台发票接口)，不能把模板限制当成服务端保证。

## 安全规则

- 前端不得修改或拼接最终支付金额；支付接口按本地账单和支付网关配置计算。
- 支付回调成功后，页面通过查询订单/账单状态确认结果，不能只依据跳转参数。
- 发票、余额、交易和账单必须按当前客户 `uid` 查询；无权限时不暴露是否存在记录。
- 支付密钥、完整卡号、Token 和上游响应不能进入 HTML、JavaScript 或浏览器日志。
