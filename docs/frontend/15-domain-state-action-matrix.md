# 业务状态与页面操作矩阵

下面记录当前源码的前置条件和副作用，不把新的按钮策略当成现有服务端约束。`status`（订单/账单/工单）与主机 `domainstatus` 分开；`{A}` 是实际后台前缀。业务 200 不保证异步执行完成或批量全部成功。

## 订单和账单

依据：[OrderController](../../app/admin/controller/OrderController.php#L939)、[InvoiceController](../../app/admin/controller/InvoiceController.php#L238)。

| 当前状态/对象 | 操作及请求 | 源码前置条件 | 目标状态/实际副作用 | 失败和页面处理 |
| --- | --- | --- | --- | --- |
| 订单，关联主机仅 Pending/Cancelled | GET `{A}/order/cancel`，ids 或 ids[] | ids 非空；关联主机不能是其他状态 | orders→Cancelled；非 Paid 账单→Cancelled；关联主机→Cancelled，恢复库存、刷新缓存和 Hook | 400 已开通/暂停应终止产品，或事务失败；重查订单/账单/服务/库存 |
| 订单，执行激活 | POST `{A}/orders/active`，id,status,host[] | 方法按 domainstatus 配置验证 status，host 项可带 username,password,server,runcreate | 先写订单 Active，再执行模块/队列；模块失败可能仍已改订单 | 200 不能显示主机已开通，读取主机最终状态；禁止自动重试 |
| 订单，人工改状态 | POST `{A}/orders/change_status`，id,status | status 在 order_status 配置中 | 仅更新订单 status；不等于支付/开通/暂停 | 重查订单；需要生命周期操作时用对应接口 |
| 未删除账单，当前状态未严格限制 | GET `{A}/invoice/paid`，ids | 具体对象和参数校验，方法没有统一 from-state 保护 | 记录交易并设 Paid，执行 processPaidInvoice | 不视为幂等；禁止浏览器预取/网络层自动重试，重查账单、流水和服务 |
| 未删除账单，当前状态未严格限制 | GET `{A}/invoice/unpaid` 或 `cancelled`，ids | 无统一原状态转换白名单 | 写 Unpaid 或 Cancelled；不是退款/撤销交易协议 | 新 UI 建议限制显式人工确认，后端约束单独评估；重新读取关联数据 |
| 有付款交易且有剩余可退额 | POST `{A}/invoice/refund`，id 为 accounts.id，amount,type | 信用额还款账单拒绝；不超过原支付及剩余；amount=0 走全额分支 | type 默认 addascredit；退款后账单写 Refunded，部分退款也不是新枚举 | 400 金额/类型失败；刷新交易、账单、余额。type=only 不证明真实网关已退款 |
| 本人账单，需要发起支付 | POST `/start_pay`，invoiceid,payment,flag | Pay 分支校验账单/归属/金额/方式 | 网关数据或跳转；最终入账取回调和本地账单 | 页面回跳先显示核对中；GET get_invoices_detail 复查，不能凭 URL 显示 Paid |

`Overdue` 可能是列表派生状态，订单 `Suspend/Suspended` 也不能相互替换。页面枚举必须读取实际配置/返回值，未知值保留原值用于诊断并显示未知状态。

## 服务生命周期

依据：[Host 逻辑](../../app/common/logic/Host.php)、[ProvisionController](../../app/admin/controller/ProvisionController.php)。后台通过 POST `{A}/provision/default` 带 id,func；前台使用模板现有 Host/Upgrade 提交流程，不凭逻辑方法名造 URL。

| 当前状态 | 操作 | 前置条件 | 完成状态 | 失败/刷新 |
| --- | --- | --- | --- | --- |
| 待开通或需重试的服务 | create | createFinal 校验对象/Hook/模块，缓存锁 300 秒；入口权限与归属依调用方，不假定逻辑层统一检查 | 启用自动开通队列时立即 200；最终 domainstatus 依模块完成结果 | 406 正在开通；没有统一 task_id，查询服务状态和已存在的任务记录；超时不要再次创建 |
| Active（客户 self 分支） | suspend，reason_type/reason | 非管理员需要归属；self 分支要求 Active；后台不具备同样的统一 from-state 限制 | 模块成功后 Suspended；已经 Suspended 的 API 分支可直接 200 | 保留原因，重查服务；失败不得先渲染 Suspended |
| Suspended（新 UI 恢复按钮基线） | unsuspend | 归属、模块和可选暂停原因类型检查；不是所有分支统一检查 Suspended | 模块成功后 Active | 失败保留原状态，重新读取原因/日志 |
| 非 Deleted（新 UI 终止按钮基线） | terminate | 服务存在、相关 Hook 和模块校验；后台未统一限制所有原状态 | 模块成功后 Deleted | 明确确认客户/服务及不可逆影响；重新读取状态；不当作订单取消 |

按钮显示基线是新模板的保守策略，不是服务端安全保证。额外任务类型、重装/救援/DCIM 控制仍需按模块契约补充，不能统一承诺任务 ID 或终态恢复。

## 工单

依据：[后台 Ticket](../../app/admin/controller/TicketController.php#L361)、[前台 Ticket](../../app/home/controller/TicketController.php#L519)。状态名称来自 ticket_status，可被配置；下面数字是当前写入值。

| 当前对象 | 操作及前置条件 | 目标状态/副作用 | 失败/刷新 |
| --- | --- | --- | --- |
| 后台内部 id，工单未合并且有部门权限 | POST `{A}/reply_ticket`，id,content,attachment[] | status→2，client_unread→1，写回复和处理人 | 406 正文/权限/对象，400 附件；失败留正文，成功重新读 list_ticket/:id |
| 前台 tid（对外工单号），本人或配置允许的访客 c | POST `/ticket/reply`，tid,content,attachment[]；正文至 10000 字符 | 事务写回复、status→3、admin_unread→1 | 406 校验/附件，400 写入失败；不使用后台 id；重新读 ticket/detail |
| 后台 id[] 批量工单 | POST `{A}/close_ticket`，id[]，status 默认 4，目标必须存在 | 过滤允许部门及未合并对象，更新为请求状态 | 无 ID/状态 406；200 可能修改 0 条，逐项复查并报告实际完成数 |
| 前台本人/允许访客工单 | POST `/ticket/close`，tid,c | status→4；已经 4 返回 200 已关闭 | 无对象/权限 406；重查详情 |
| 读取详情 | 后台内部 id / 前台 tid | 分别清 admin_unread/client_unread | 读取不是完全无副作用，未读数随之更新 |

回复实现没有统一“已关闭不可回复”保护，前端按钮策略必须另行约定；不能把禁用按钮描述成后端已经拒绝。重复回复未见统一幂等键，超时先查时间线，再由用户决定是否再次发送。

## 信用额度与预存余额

| 当前状态 | 操作 | 前置条件 | 目标/副作用 | 页面处理 |
| --- | --- | --- | --- | --- |
| 客户信用额未开通 | POST `{A}/credit_limit` | uid 存在、版本支持；credit_limit,bill_generation_date,bill_repayment_period | 开关→1，设置额度/出账/还款周期 | 查询 credit_limit 和还款账单，不显示余额冻结 |
| 已开通信用额 | PUT `{A}/credit_limit` | uid，具体字段校验 | 调整额度或日期，写信用额日志；可能改账单到期日 | 刷新额度、日志、受影响账单 |
| 已开通信用额，有或无欠款 | DELETE `{A}/credit_limit` | uid 存在/版本支持 | 开关→0；不会清除欠款或历史还款账单 | 确认显示已有使用额，不能显示债务已清偿 |

预存余额的增加/扣减是 CreditController 的另一套流水；既不映射为 credit_limit 状态，也不新增无依据的冻结/解冻按钮。

## 客户资料保存

| 当前对象 | 操作/前置条件 | 副作用 | 失败/刷新 |
| --- | --- | --- | --- |
| 有资料编辑权限且在允许客户范围 | POST `{A}/profile_post`；client_id、username/status、联系方式、有效币种/语言/网关、自定义字段 | 主资料更新与自定义字段校验/更新不是整段事务；推介关系和 Hook 也有副作用 | 400 可能部分保存；失败/超时保留草稿并重新读取 profile/custom_value，不自动重试；无变化不发请求 |

字段白名单、序列化与普通角色依赖见[后台样板契约](26-admin-pilot-contract.md)。不能以客户端校验或禁用按钮代替服务端保护。

## 未完成的契约

实名认证、提现、插件、DCIM、资源审核需要继续逐动作追溯。报表已有读取契约，见[接口文档](13-page-api-contract.md)，无需显示“统计未实现”。未知字段用缺失/不可用状态，禁止用 0 假装真实统计。
