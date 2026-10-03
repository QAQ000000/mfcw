# 后台权限、菜单与二次验证契约

本文区分源码已实现的权限检查和新模板的展示要求。实例角色、规则 ID、插件菜单必须在隔离测试库中导出；以下规则名称来自代码构造方式，不表示当前数据库已经存在或授权。

## 实际鉴权链

依据：[AdminBaseController](../../app/admin/controller/AdminBaseController.php)、[AdminUserModel](../../app/admin/model/AdminUserModel.php)、[Request::action](../../vendor/thinkphp/library/think/Request.php#L1972)。

1. 业务 API 初始化读取 `ADMIN_ID`，检查登录期限、可选 IP 校验、RBAC、`checkLoginToken()`；常见拒绝为业务 `status=405`（会话失败）、`401`（无权限）、`307`（系统授权异常）。HTTP 状态与业务 status 分别处理。
2. 规则构造为 `app\` + module + `\controller\` + controller + `controller::` + action。action 默认转小写，controller 保留框架解析名称。例如 `app\admin\controller\UserManagecontroller::clientlist`，后缀并非 `Controller`。
3. 普通管理员先匹配 `auth_rule.name`，规则不存在即拒绝，再执行 `cmf_auth_check()`。ID=1 或 role_id=1 有特殊放行，不能只用超级管理员验收。
4. 菜单来自 `auth_rule.is_display=1`，与 `role_user/auth_access` 关联；`role.auth_role` 及会话缓存也参与权限数据返回。菜单 URL、父子关系和按钮规则不是同一对象。
5. PHP [ViewAdminBaseController](../../app/admin/controller/ViewAdminBaseController.php) 直接继承 CMF Base，构造函数仅执行 sessionInit；没有继承上述 API 初始化链。不能承诺所有 View* 页面都自动返回 401/405。新模板页面保护需单独验证，敏感信息仍以业务接口校验为准。

401 当前响应含 `name/rule/auth/identify`；前端展示简短拒绝提示，诊断字段不当作授权依据。过期后重新登录并丢弃旧权限缓存，页面不得根据前一次成功加载继续写入。

## 首批页面与按钮的实际规则

下表统一规则前缀 `P = app\admin\controller\`；拼接时按原样保留控制器名称。路径前缀 `{A}` 取部署 `admin_application`。规则 ID 需通过 `auth_rule.name` 查询，不在文档中写死。

| 页面/按钮 | 方法、URL | 规则名称（P 后缀） | 额外范围/刷新 |
| --- | --- | --- | --- |
| 客户列表 | RULE `{A}/client_list`（旧编译页面实际 POST） | `UserManagecontroller::clientlist` | GetUser 的销售范围；更新后重新读取 list/total |
| 客户摘要 | GET `{A}/summary` | `UserManagecontroller::summary` | client_id，check1，409 范围失败 |
| 客户资料读取 | GET `{A}/profile/:client_id` | `UserManagecontroller::profile` | 客户范围按方法核对 |
| 客户资料保存 | POST `{A}/profile_post` | `UserManagecontroller::profilepost` | client_id；失败保留输入并重查，400 可能是主资料已写入后的自定义校验失败 |
| 外壳公共数据 | GET `{A}/common` | `Commoncontroller::common` | data.config/rule/sale/gateway；按是否实际使用授予 |
| 资料表单选项 | GET `{A}/common/get_getways`、`get_client_groups`、`get_sms_country` | `Commoncontroller::getgetways/getclientgroups/getsmscountry`（三条规则） | 分别返回 gateway/client_groups/sms_country；编辑权限不自动授权辅助读取 |
| 信用额读取 | GET `{A}/credit_limit` | `CreditLimitcontroller::index` | uid，专业版及全局/客户启用；与余额独立 |
| 信用额启用/调整/停用 | POST/PUT/DELETE `{A}/credit_limit` | `CreditLimitcontroller::save/update/delete`（分别三条规则） | 影响客户额度/还款，不是冻结/解冻余额 |
| 信用额日志 | GET `{A}/credit_limit/log` | `CreditLimitcontroller::log` | uid，日志分页 |
| 工单详情 | GET `{A}/list_ticket/:id` | `Ticketcontroller::ticketdetail` | 内部 id + 工单部门权限，406 拒绝 |
| 工单回复 | POST `{A}/reply_ticket` | `Ticketcontroller::reply` | 部门检查、未合并工单、附件验证 |
| 工单改状态 | POST `{A}/close_ticket` | `Ticketcontroller::closeticket` | id[]；过滤允许部门/未合并对象，成功后逐项查状态 |
| 账单详情 | GET `{A}/invoice/summary/:id` | `Invoicecontroller::summary` | 与退款/人工入账规则分开 |
| 标记已付/未付/取消 | GET `{A}/invoice/paid`、`unpaid`、`cancelled` | `Invoicecontroller::paid/unpaid/cancelled`（分别三条规则） | 当前是有副作用 GET；禁止预取和自动重试 |
| 退款 | POST `{A}/invoice/refund` | `Invoicecontroller::refund` | accounts.id、可退额、信用额还款限制 |
| 取消订单 | GET `{A}/order/cancel` | `Ordercontroller::cancel` | 主机状态限制；禁止预取 |
| 激活/仅改状态 | POST `{A}/orders/active`、`change_status` | `Ordercontroller::active/changestatus`（分别两条规则） | “改状态”不等于开通模块 |
| 服务模块动作 | POST `{A}/provision/default` | `Provisioncontroller::execute` | func 动作分支；不能假定每个 func 有独立 auth_rule |
| 设置读取/选项/保存 | POST `{A}/config_general/getConfig`、`getConfigOption`、`newGeneral` | `ConfigGeneralcontroller::postgetconfig/postgetconfigoption/postnewgeneral`（三条规则） | controller 隐式路由包含 post 前缀；按分区读取/保存白名单键 |
| 报表读取 | GET `{A}/year_reports`、`year_reports_chart`、`new_client`、`forward_client`、`product_income` | `Reportscontroller::getyearincomestatistics/getyearincomestatisticsforchart/getnewclientstatistics/rankforwardclient/productincome`（五条规则） | 报表读取不自动授权财务写入 |

`/` 分隔的多个 action 表示各自规则，不能保存成一个包含 `/` 的 name。尚未映射的操作不得用“财务写入”等文字能力替代真实规则。

2026-10-03 只读查询副本发现：clientlist/profilepost 的持久化名称与源码构造存在大小写差异，普通等值查询能匹配；summary 有两条匹配规则。列排序规则、最终授权 ID 及角色缓存尚未验证，不能假定 name 与 ID 一一对应，也不能直接新增“大小写不同”的规则。详见[样板规则落地记录](26-admin-pilot-contract.md)。本轮没有创建角色或验证真实会话。

## 部门与销售范围

[TicketDepartmentAdminModel](../../app/admin/model/TicketDepartmentAdminModel.php) 通过 `ticket_department_admin(admin_id,dptid)` 校验部门；check() 对管理员 ID=1 特例放行，getAllow() 读取实际配置。普通管理员有 ticketdetail 规则仍可能因部门被拒绝，必须测试这个组合。

[GetUserController](../../app/admin/controller/GetUserController.php) 使用 `is_sale/only_mine/cat_ownerless` 和客户 `sale_id`；check1 对无销售归属客户直接通过，而列表初始化的过滤不同。不要在新 UI 中把“销售只能看自己客户”描述为现有统一规则。逐接口使用真实范围验证，统一规则属于另一个后端变更。

## 已找到的二次验证动作

动作名不是 auth_rule.name。启用条件由 `isSecondVerify()` 和站点配置控制；`secondVerifyResultAdmin()` 校验邮件缓存和请求 code。用户交互中的确认弹窗与二次身份验证也不同。

| 业务 | 二次验证 action | 调用来源 |
| --- | --- | --- |
| 后台登录 | `login` | PublicController 的登录验证码分支 |
| 新建管理员 | `create_admin` | UserController::create |
| 编辑管理员 | `edit_admin` | UserController::update |
| 修改个人密码 | `modify_password` | UserController::editSelfInfo |
| 新建角色组 | `create_admin_group` | RbacController::addRole |
| 修改角色组 | `modify_admin_group` | RbacController::editRole |

配置辅助逻辑还调用 `second_verify_set`，与静态允许动作列表不完全一致，需运行验证。当前证据不能推导出“所有退款/余额/主机操作均已二次验证”。新模板可统一确认影响范围；增加服务端二次验证必须另开后端任务。

## 隔离验收角色

通过现有后台角色管理建立 `ui-read`（核心读取）、`ui-edit`（资料保存和工单回复）、`ui-denied`（未授目标规则）；都使用普通角色，另准备一个配置了部门权限的工单管理员和一个无该部门权限的管理员。通过管理页面配置真实规则与部门，退出重登刷新会话。账号和密码存于测试环境，不写入 Markdown。

记录 `auth_rule` 的 id/name/url/pid/is_display、角色授权以及部门/销售设置，保存在受控验收附件中。对每个按钮验证菜单、直接访问、读取、写入、跨范围对象、会话失效。结果按[验收文档](18-frontend-test-acceptance.md)记为 PASS/FAIL/BLOCKED；没有实例导出和真实会话证据的行仍是静态映射。
