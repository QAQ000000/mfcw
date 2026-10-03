# 页面接口契约与数据映射

本文记录当前源码可确认的核心接口。`{A}` 是包含前导 `/` 的实际后台前缀。下文是静态契约，尚未通过登录会话验收。全量字面量路由与页面直接调用见[静态盘点](22-admin-route-inventory.md)。不能用控制器名或方法名拼接请求 URL。

## 契约记录格式

每个页面在开发任务中必须填写：

```text
页面/路由：
渲染控制器和模板：
初始读取接口（方法、路径、权限）：
筛选/分页参数：
写入接口及请求字段：
成功响应和刷新范围：
失败码、空态、处理中和重试：
敏感字段和审计要求：
```

后台业务规则以 `AdminBaseController`、对象归属和额外部门/销售范围校验为准。View* 基类与 API 基类不同，不能把 View* 中随机生成的 `$Token` 当成已实现的 CSRF 保护。

## 页面到接口分组

| 页面组 | 页面入口 | 当前权威实现 | 接口来源 | 说明 |
| --- | --- | --- | --- | --- |
| 后台外壳 | `/index`、`/plugins` | `ViewAdminController`、`ViewPluginsController` | `admin/common/*`、`admin/plugin/*` | 菜单、通知、插件数据需按实际返回结构适配 |
| 客户 | `/clients`、`/clientssummary`、`/clientsprofile` | `ViewClientsController`、`UserManageController` | `client_list`、`summary`、`profile/*`、`create_client*` | 客户上下文必须由服务端重新校验 |
| 客户财务 | `/clientsinvoices`、`/clientstransactions`、`/viewinvoices` | `ViewClientsController`、`UserManageController`、财务控制器 | `user_invoice`、`user_productinvoice`、账单/交易控制器 | 金额以本地账单和交易为准 |
| 信用额 | `/clientscredit`、前台 `/credit` | `CreditLimitController` | `credit_limit` 系列，见下文 | 与 CreditController/clients.credit 预存余额分开 |
| 客户服务 | `/clientsservices`、`/clientsviewservices` | `ViewClientsController`、`ProvisionController` | `hostbyuid`、`provision/*`、主机控制接口 | 异步开通、暂停、控制需要轮询最终状态 |
| 工单 | `/supportticket`、`/clientssupporttickets`、`/clientssupportticketdetail` | `ViewWorkorderController`、`TicketController` | GET `list_ticket/:id`、POST `reply_ticket`、POST `close_ticket` 等 | 回复、关闭、转派和附件操作均需权限 |
| 订单业务 | `/orders`、`/orderdetail`、`/productlist`、`/cancelrequests` | `ViewBusinessController` | 订单、产品、取消请求控制器 | 状态变更必须刷新订单、账单和服务关联 |
| 财务 | `/transactions`、`/invoices`、`/withdrawdeposits`、`/receipt` | `ViewFinanceController` | 交易、发票、提现、凭证控制器 | 退款、审核、标记支付需审计和幂等 |
| 商品和模块 | `/configproducts`、`/configproduct*`、`/configservermodule*` | `ViewGoodController` | 产品、配置项、`provision/*` | 保存后区分立即生效和下单时生效 |
| 资源和上游 | `/munualresource`、`/upStreamedit`、`/zjmfapi` | `ViewResourceController`、`UpperReachesController`、`ZjmfFinanceApiController` | 上游、资源、IPMI/DCIM、API 控制器 | 凭据脱敏，危险控制显示任务状态 |
| 统计 | `/annualstatistics`、`/newcustomer`、`/productrevenue`、`/revenueranking` | `ReportsController` | year_reports、year_reports_chart、new_client、forward_client、product_income | View* 占位不代表业务未实现，字段见下文 |

## 列表接口统一要求

现有接口不能统一假设为 `data.list/total`。列表返回可能是顶层 `list/total`、`invoices/count`、`data/count` 或 `data.page.total`。适配器逐接口读取，分页采用各接口实际 `limit` 或 `size`，筛选/排序保留在页面状态。增加白名单、导出限额属于后端变更，不能描述成模板已经具备的保护。

项目中 `status` 是业务结果字段，不等同于 HTTP 状态码。HTTP 200 也可能表示业务失败；模板必须同时检查 HTTP、业务 `status` 和数据完整性。

## 写入和异步接口

下列是重构要求，不代表现有每个接口均已实现。实际支持范围见核心契约和状态矩阵：

1. 显式 HTTP 方法、Token/CSRF 和服务端权限校验；
2. 客户、订单、产品、账单、主机 ID 从服务端会话和数据库关系重新确认；
3. 重复点击的幂等键或重复请求保护；
4. 成功后返回受影响对象或任务 ID；
5. 处理中状态可通过轮询或刷新查询，超时显示重试和最终状态入口；
6. 失败保留表单内容，不能用成功提示覆盖错误。

## 真实后台核心接口

所有 URL 拼接实际 {A} 前缀。公共拒绝结果来自 AdminBaseController：业务 status=405 未登录/会话条件失败，401 无规则权限，307 系统授权异常；不把它们映射为 HTTP 同名状态。400/406/409 为具体业务校验，失败保留安全输入。

| 页面 | 方法和 URL | 实现参数 | 响应与刷新 |
| --- | --- | --- | --- |
| 登录 | POST `{A}/login` | username,password,captcha；启用二次验证时带 code | Public::ad_login；data.user,rule,user_tastes；205 表示插件接管；登录成功建立 Session |
| 客户列表 | RULE `{A}/client_list`（旧编译页面实际 POST） | page,limit,order,sort,username,companyname,email,phonenumber,status,qq,api_status,client_groups,sale，另有自定义字段；旧组件用 qs.stringify 表单编码 | UserManage::clientList；顶层 list,total,search,level_search,api_status,seachData,allow_resource_api；保留 seachData 拼写；保存后重查列表 |
| 客户摘要 | GET `{A}/summary` | client_id | UserManage::summary 组装账户、服务、账务、工单摘要；404 不存在，409 客户范围失败 |
| 客户资料 | GET `{A}/profile/:client_id` | 路径 client_id | 顶层 profile,sale,language,client_status,custom,custom_value |
| 客户保存 | POST `{A}/profile_post` | client_id 与已加载资料白名单；username/status 必填，email/phonenumber 至少一个，currency/language/defaultgateway 保留有效原值，custom[id] 按表单编码；内部 $uid 不是请求字段 | 不是差异 PATCH；400 可能发生于主资料已写入后的自定义字段校验，失败/超时也要重查并保留草稿，不自动重试；409 为范围拒绝 |
| 客户编辑元数据 | GET `{A}/common/get_getways`、`common/get_client_groups`、`common/get_sms_country` | 无客户定位参数；分别顶层 gateway、client_groups、sms_country | Common 经 GetUser/AdminBase 进行鉴权；选项读取失败不清空原值，辅助权限需单独落实 |
| 工单详情 | GET `{A}/list_ticket/:id` | 内部数字 id | data.list,ticket,user,customfields；406 无工单/无部门权限；读取会清 admin_unread |
| 工单回复 | POST `{A}/reply_ticket` | id,content,attachment[] | 406 空正文/无工单/无部门权限，400 附件失败；成功后工单 status=2，重查详情 |
| 工单改状态 | POST `{A}/close_ticket` | id[] 数组，status 默认 4 | 无有效 ID/状态 406；成功后逐项重查，200 不保证所有选中项已修改 |
| 账单详情 | GET `{A}/invoice/summary/:id` | 路径账单 id | 顶层 invoices,invoice_items,accounts,exists_pay；invoices 含 status/status_zh,subtotal,total,credit_zh,pay_amount,surplus/surplus_zh,use_credit_limit；accounts 含 type,is_refund,diff_amount；400 缺 ID/不存在；配套 GET invoice/addpay_page/:id 和 invoice/refund_page |
| 退款 | POST `{A}/invoice/refund` | id 是 accounts 交易 ID，amount,email,type,trans_id；type 默认 addascredit | 400 金额超支付/超剩余或信用额还款账单；刷新账单、交易、余额；不是输入账单 ID |
| 服务模块操作 | POST `{A}/provision/default` | id 为 host ID，func=create/suspend/unsuspend/terminate 等；按动作带 reason_type,reason,send,os,password | 缺 ID 406，按具体动作返回；无统一 task_id；200 后查最终主机状态 |
| 商品目录 | GET `{A}/product_list_page` | keywords,page,limit,order,sort,name（部分虽读取但未用于分页） | 顶层 data[] 一级组→groups[]→products[]，total 为一级组计数；不是普通产品平铺分页，产品有 count/count_active |
| 商品编辑读取 | GET `{A}/edit_product_page/:id` | id；type_view 默认 1 | data.product,pricing,currencies,product_group,modules,server_group,customfields,config_groups,config_links,all_product_data,upgrade_product_ids,api_type 等；顶层 rows,pgrouplist,ptype；400 缺 ID、406 产品不存在；上游商品还可能发起外部配置读取 |
| 商品保存 | POST `{A}/edit_product` | id,type,gid,name,pay_type,pay_method,api_type 及配置组字段；定价 currency[币种ID][周期/安装费] | ProductsValidate；pay_type=free/onetime/recurring/day/hour；name≤100；400/406 校验/类型/对象；资源商品另分支；不是将 data.product JSON 原样 PUT；保存后重查编辑页与前台报价 |

依据：`PublicController::ad_login`、`UserManageController::clientList/profile/profilePost`、`TicketController::ticketDetail/reply/closeTicket`、`InvoiceController::refund`、`ProvisionController::execute`。非核心页面目前只有入口/调用映射，尚不具有完整 schema。

登录→列表→资料保存的完整顺序与字段规则见[后台样板契约](26-admin-pilot-contract.md)。profile 没有返回 city/region/avatar，首版不可补空值提交。profilePost 无整段事务，推介关系、主资料与自定义字段可能不是同时成功；错误响应不能一概解释为没有写入。登录/部分公共 GET 包含维护副作用，登录错误分支还可能缺 status 或返回请求字段，验收记录应过滤凭据。

## 信用额接口

`clients.credit` 是预存余额，`credit_limit` 是信用额度；CreditController 与 CreditLimitController 不可互换。后台信用额接口受 getEdition() 限制，启用还受 shd_credit_limit 与客户开关影响。

| 请求 | 参数 | 实际响应/副作用 |
| --- | --- | --- |
| GET `{A}/credit_limit` | uid | 顶层 user,credit_limit_config,status,msg；user 包含 certify,is_open_credit_limit,credit_limit,credit_limit_used,credit_limit_balance,credit_limit_used_percent,amount_to_be_settled,bill_generation_date,bill_repayment_period,repayment_date,next_bill_generation_date,this_month_bill 及客户/币种信息 |
| POST `{A}/credit_limit` | uid,credit_limit,bill_generation_date,bill_repayment_period | 启用，事务更新 clients；400 客户不存在/非专业版本/失败 |
| PUT `{A}/credit_limit` | uid；可选 credit_limit,bill_generation_date,bill_repayment_period,repayment_date | 调整并写日志；还款日变更可能修改相关账单 due_time |
| DELETE `{A}/credit_limit` | uid | is_open_credit_limit 置 0；不清债务，不删除还款账单 |
| GET `{A}/credit_limit/log` | uid,page,size,order,sort,keywords,start_time,end_time,type[] | 顶层 data/count；类型 Change Credit Limit、Change Repayment Date、Change Bill Time |
| GET `{A}/credit_limit/list` | 客户过滤及 page,limit,order,sort，见方法/get_search | 顶层 invoices,count,invoice_status；信用额支付明细 |
| GET `{A}/credit_limit/user_invoice` | 客户过滤及 page,limit,order,sort | invoices,count,invoice_status,credit_limit_invoice_status；还款账单 |
| GET `{A}/credit_limit/user_invoice_detail` | id；分页/排序 | invoices,count,invoice_status；缺 id 400 |

前台 `/credit` 调用 GET `/credit_limit` 和 GET `/credit_limit/user_invoice`；`/creditdetail?action=used` 内部调用 creditLimitUsed()，未找到显式独立路由，不能凭方法名新造 URL。此处没有信用额冻结/解冻契约。

## 已实现报表契约

依据：ReportsController 及 admin.php 第 402 至 406 行。ViewStatistics 的 test 只是视图占位。

| GET 请求 | 入参/默认 | 响应与口径 |
| --- | --- | --- |
| `{A}/year_reports` | page,limit 默认 config | data.year_count[]：date,income,expenses,last；year_count_num；默认币种 accounts、delete_time=0，按年月倒序分页 |
| `{A}/year_reports_chart` | 无筛选 | data.all：income,expenses,last,currency_code,currency_prefix，为全部交易合计；chart.years/list（year,data[12],prefix）为月净额，不是毛利 |
| `{A}/new_client` | year,month 默认当前年月 | data.client_data[]：day_string,new_clients_count,new_order_count,complete_order_count,new_ticket_count,reply_ticket_count,cancel_requests_count；new_client_years_group；客户 status=1；已回复实际按当天新工单且 status!=1 计数 |
| `{A}/forward_client` | 无筛选 | data 数组：id,username,companyname,income_sum,expense_sum,last,prefix,suffix；正常客户、未删除流水，净额降序前 10；不是销售榜 |
| `{A}/product_income` | year/month 当前年月；limit=50,page=1 | 顶层 data[] 是组（id,name,products）；products[] 含 id,name,new_order_amount,new_order_num,renew_order_amount,renew_order_num,total_amount 及 new_order/renew_order 的 prefix/suffix；顶层 groups_count,years；按可见组分页，退款在计算中扣除；默认币种用于金额标识，没有 default_currency 返回字段；旧注释 search_type 未被使用 |

需运行验证：跨币种归并、无默认币种/交易空值、年末边界、退款分摊、新客户报表 SQL。已有源码不等于这些路径运行通过。

## 前台首批接口

| 页面 | 请求 | 参数/响应 | 行为 |
| --- | --- | --- | --- |
| 登录 | GET/POST `/login` → ViewClients；POST `/login_pass_email` 或 `/login_pass_phone` | 邮箱 email,password（6–32 位）；手机 phone（4–11 位）,phone_code,password；验证码 captcha，二次码 code,code_type；email 非邮箱时受 allow_id 控制 | Login::emailLogin/phonePassLogin；400 字段/凭据/验证码或登录方式失败；沿 ClientsModel 返回建立会话，重新读取登录态，不硬编码后台 data.user |
| 商品配置 | GET `/cart/get_product_config` | pid；data.products,customfields,product_pricings,config_groups,config_links,advanced,flag | 配置改变重查报价 |
| 报价 | POST `/cart/get_total` | pid,billingcycle,configoption,customfield,currencyid,qty；顶层 currency/products（没有 data 包裹）；products 含 child,setupfee_total,total,signal_setupfee,signal_price,duration,type 及 sale_price/sale_setupfee_total/sale_signal_price/bates 分支 | 400 数量/价格/产品/配置无效；丢弃过时响应，不自行算最终价，不把 sale_price 单独当作总价 |
| 购物车 | GET `/cart/get_shop_data` | currency,pos[]；data.cart_products,currency,promo,total_price,total_desc,gateway_list,default_gateway,credit 等 | 数量/优惠/删除成功后重查摘要 |
| 加入购物车 | POST `/cart/add_to_shop` | pid,billingcycle,serverid,configoption{},customfield{},currencyid,qty,os[],checkout（0/1）等 | 406 格式、400 库存/数量/绑定手机等，分支成功后重查 get_shop_data；校验数组有 currecncyid 历史拼写，实际取 currencyid |
| 修改数量 | POST `/cart/modify_product_qty` | i 是购物车位置，qty,pos[] | 200 后 data 是购物车摘要；错误分支可能沿 Shop 返回字符串 status，需专门适配，不只判断 HTTP 200 |
| 优惠/删除 | POST `/cart/add_promo`、`remove_promo`、`remove_product` | 优惠 promo,currency,pos[]；删除 i 或 i[] | 优惠返回 data.promo/total_price/total_desc 的局部摘要；删除 409 锁冲突；操作后重新查询全购物车，不用局部响应覆盖完整列表 |
| 结算 | POST `/cart/settle` | payment,checkout,use_credit,pos 等；以 settle 实现为准 | 锁冲突 409，库存/数量等 400/406；订单/支付/开通分别确认 |
| 账单详情 | GET `/get_invoices_detail` | id；data.payee,detail,invoice_items,currency,accounts | 不存在/非本人 400；支付后按 id 重查 |
| 支付 | POST `/start_pay` | invoiceid,payment,flag；data 为网关分支结果 | 跳转不等于成功；apply_credit 与 apply_credit_limit 不同 |
| 服务详情 | GET/POST `/servicedetail` | ViewClients 调用 Host、Upgrade、User；Route::controller(host) 未展开 | 保留模板 action 流程，不造未确认 API |
| 工单详情 | GET `/ticket/detail` | tid 是对外工单编号；访客例外需 nologin_send_ticket 与 c；data.list,ticket,evaluate,feedback_request | 读取清 client_unread，不用后台内部 id 替代 tid |
| 工单回复/关闭 | POST `/ticket/reply`、`/ticket/close` | tid；回复带 content,attachment[]，访客分支 c | 重查详情，失败保留正文和附件 |

## 设置页的隐式接口

admin.php 声明 Route::controller("config_general", "admin/ConfigGeneral")。ThinkPHP Route::controller() 对 URL action 加 HTTP 方法前缀：POST getConfig 执行 postGetConfig，不要求存在 getConfig()。依据：[路由机制](../../vendor/thinkphp/library/think/Route.php#L708)、[配置控制器](../../app/admin/controller/ConfigGeneralController.php#L391)。

| 方法/URL | 实际方法/入参 | 返回和保存行为 |
| --- | --- | --- |
| POST `{A}/config_general/getConfig` | postGetConfig；param[] 为配置键 | data 是键值映射；searchGetParam 处理布尔/数组等类型；400 异常 |
| POST `{A}/config_general/getConfigOption` | postGetConfigOption；param[] 为选项名 | data 按名映射；调用 getOption + ucfirst(name)，不存在则 []，不能据此认定请求失败 |
| POST `{A}/config_general/newGeneral` | postNewGeneral；按需提交配置键值，不是 param 包裹 | 校验、转换、事务保存，configUpdateAfter、变更日志；400 校验/异常；成功再读 getConfig |
| GET `{A}/config_general/general` | getGeneral | data.config_value、themes_templates（官网目录）、clientarea_themes |

实际 RBAC action 名分别为 postgetconfig/postgetconfigoption/postnewgeneral/getgeneral，控制器为 ConfigGeneral。新模板仅发送该分区允许配置键；服务端是否统一拒绝未知配置键属于另一个后端核验项，不把前端白名单当作安全保证。

## 仍需追溯

admin.php include 的 app/res/route/res.php 在当前 checkout 缺失，须核对部署扩展。其余隐式路由、真实响应样例、角色绑定及浏览器可达性尚未验证。设置接口已静态定位，不能再列为缺失；仍需真实会话确认权限、字段转换和保存副作用。
