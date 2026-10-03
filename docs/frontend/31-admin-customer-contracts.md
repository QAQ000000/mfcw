# 客户与客户详情逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [客户列表](#p020) `/customer-list` | `list` | 路由 factory 指向模块 |
| [客户详情容器](#p027) `/customer-view` | `shell` | 路由 factory 指向模块 |
| [客户摘要](#p028) `/customer-view/abstract` | `detail` | 路由 factory 指向模块 |
| [客户站内信记录](#p029) `/customer-view/station-letterlog` | `log` | 路由 factory 指向模块 |
| [客户开发者信息](#p030) `/customer-view/developer` | `detail` | 路由 factory 指向模块 |
| [历史客户摘要](#p031) `/customer-view/abstractOld` | `detail` | 路由 factory 指向模块 |
| [客户账单](#p032) `/customer-view/bill` | `list` | 路由 factory 指向模块 |
| [客户交易](#p033) `/customer-view/transactions` | `list` | 路由 factory 指向模块 |
| [客户余额与信用额](#p034) `/customer-view/credit` | `detail` | 路由 factory 指向模块 |
| [客户工单](#p035) `/customer-view/tickets` | `list` | 路由 factory 指向模块 |
| [客户操作日志](#p036) `/customer-view/log` | `log` | 路由 factory 指向模块 |
| [客户通知记录](#p037) `/customer-view/noticelog` | `log` | 路由 factory 指向模块 |
| [客户附件](#p038) `/customer-view/annex` | `list` | 路由 factory 指向模块 |
| [客户短信记录](#p039) `/customer-view/smslog` | `log` | 路由 factory 指向模块 |
| [客户邮件记录](#p040) `/customer-view/emaillog` | `log` | 路由 factory 指向模块 |
| [客户资料](#p041) `/customer-view/person` | `form` | 路由 factory 指向模块 |
| [客户服务详情](#p042) `/customer-view/product-innerpage` | `detail` | chunk 内候选，页面归属待人工确认 |
| [客户产品服务](#p043) `/customer-view/product-list` | `list` | 路由 factory 指向模块 |
| [客户推介关系](#p044) `/customer-view/promotion_plan` | `detail` | 路由 factory 指向模块 |
| [客户跟进状态](#p045) `/customer-view/follow-status` | `detail` | 路由 factory 指向模块 |
| [客户 API 概览](#p046) `/customer-view/api-overview` | `detail` | 路由 factory 指向模块 |
| [新增客户](#p048) `/customer-add` | `form` | 路由 factory 指向模块 |
| [客户分组](#p049) `/customer-group` | `list` | 路由 factory 指向模块 |
| [客户自定义字段](#p050) `/customer-custom` | `list` | 路由 factory 指向模块 |
| [客户实名认证](#p052) `/customer-authentication` | `list` | 路由 factory 指向模块 |
| [客户跟进记录](#p053) `/add-records` | `form` | 路由 factory 指向模块 |
| [销售管理](#p055) `/sales-management` | `list` | 路由 factory 指向模块 |
| [销售统计](#p056) `/sales-statistics` | `report` | 路由 factory 指向模块 |
| [客户推介计划](#p057) `/customer-promotionplan` | `list` | 路由 factory 指向模块 |
| [客户资源池](#p060) `/customer-resources` | `list` | 路由 factory 指向模块 |
| [客户等级](#p061) `/customer-level` | `list` | 路由 factory 指向模块 |
| [推介计划设置](#p131) `/promotion_plan` | `form` | 路由 factory 指向模块 |
| [实名认证设置](#p133) `/authentication-setting` | `form` | 路由 factory 指向模块 |
| [客户资料编辑兼容入口](#p185) `/edit-person` | `form` | 路由 factory 指向模块 |
| [客户开发者管理](#p186) `/customer-developer` | `list` | 路由 factory 指向模块 |

<a id="p020"></a>

## 客户列表 `/customer-list`

旧版证据：[P020](27-admin-built-page-evidence.md#p020)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：保留余额与信用额两列；点击姓名进入/customer-view/abstract并传query.id。搜索改变回第1页，排序仅用合法ASC/DESC；新增客户进入独立/customer-add，不在本页暗中代下单。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `41f5/3a7c7393` | `el-form-item` | `t.label==e.$lang.mail?e.$lang.email:t.label` / `t.value` / `-` | `e.showSearchArea; 循环 e.searchOptions` | 分组表单；未知原值不置空 |
| `41f5/3a7c7393` | `el-form-item` | `实名状态` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `41f5/3a7c7393` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `41f5/3a7c7393` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `姓名 ($lang.name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `手机号/邮箱 ($lang.phone_email)` / `phonenumber` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `服务 ($lang.server)` / `host_total` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `收入/支出 ($lang.income_expenditure)` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `余额 ($lang.remain_sum)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `客户分组 ($lang.customer_group)` / `group_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `销售 ($lang.sell)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `信用额（已用/总计） ($lang.credit_amount)` / `credit_limit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `41f5/3a7c7393` | `el-table-column` | `API开通时间 ($lang.API_open_time)` / `create_time` / `-` | `"0"!=e.allow_resource_api` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `41f5/3a7c7393` | `帮助文档 ($lang.help_document)` | `on.click → e.openDoc` | `无提取条件` |
| `41f5/3a7c7393` | `添加客户` | `on.click → e.goToAddCustomer` | `无提取条件` |
| `41f5/3a7c7393` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `41f5/3a7c7393` | `搜索 ($lang.search)` | `on.click → e.searchClick` | `e.showSearchArea` |
| `41f5/3a7c7393` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `41f5/3a7c7393` | `r.id` | `on.click → function(t){return e.goToView(r.id)}` | `scopedSlots` |
| `41f5/3a7c7393` | `" "+e._s(r.username)+" "` | `on.click → function(t){return e.goToView(r.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3a7c7393` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `3a7c7393` / `getData` | `"post"` `"client_list"` (data) | `RULE {A}/client_list` → `admin/user_manage/clientList`；规则 `app\admin\controller\UserManagecontroller::clientlist`；[源行](../../data/route/admin.php#L172) | 未提取；新设计明确成功后重读受影响对象 |
| `3a7c7393` / `getData` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/product-list",query:{id:r.id,currency_id:r.currency_id}}`
- 旧跳转：`adSearch: t.$router.replace({query:i})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`goToAddCustomer: this.$router.push("/customer-add")`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p027"></a>

## 客户详情容器 `/customer-view`

旧版证据：[P027](27-admin-built-page-evidence.md#p027)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 `/customer-view/abstract`、`/customer-view/station-letterlog`、`/customer-view/developer`、`/customer-view/abstractOld`、`/customer-view/bill`、`/customer-view/transactions`、`/customer-view/credit`、`/customer-view/tickets`、`/customer-view/log`、`/customer-view/noticelog`、`/customer-view/annex`、`/customer-view/smslog`、`/customer-view/emaillog`、`/customer-view/person`、`/customer-view/product-innerpage`、`/customer-view/product-list`、`/customer-view/promotion_plan`、`/customer-view/follow-status`、`/customer-view/api-overview`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：固定客户上下文、返回客户列表与可用子页。直接进入子页也读取当前客户，切换客户清除旧异步结果；menu/tabs不等于接口授权。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5a39/36f8db60` | `el-tab-pane` | `客户摘要 ($lang.customer_paper)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `开发者信息 ($lang.developer_info)` / `-` / `-` | `else(e.screenWidth>992); e.developer` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `个人资料 ($lang.personal_data)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `产品/服务 ($lang.product_service)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `账单 ($lang.bill)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `交易记录 ($lang.transaction_record)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `信用管理 ($lang.credit_manage)` / `-` / `-` | `else(e.screenWidth>992); 1==e.edition&&1==e.license_type` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `工单 ($lang.work_order)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `日志 ($lang.log)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `API概览 ($lang.API_overview)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `通知日志 ($lang.notificate_log)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `附件 ($lang.attachment)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `推介计划 ($lang.promotion_plan)` / `-` / `-` | `else(e.screenWidth>992); e.showPromanPlan` | 主区导航；保留对象与选中项 |
| `5a39/36f8db60` | `el-tab-pane` | `跟进状态 ($lang.follow_up_state)` / `-` / `-` | `else(e.screenWidth>992)` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `7e24bb4d` / `getCustomerBaseInfo` | `未显式指定` `"get_user"` (params) | `GET {A}/get_user` → `admin/user_manage/getUser`；规则 `app\admin\controller\UserManagecontroller::getuser`；[源行](../../data/route/admin.php#L171) | `checkWidth` |
| `7e24bb4d` / `forcedRefresh` | `未显式指定` `"get_user"` (params) | `GET {A}/get_user` → `admin/user_manage/getUser`；规则 `app\admin\controller\UserManagecontroller::getuser`；[源行](../../data/route/admin.php#L171) | `checkWidth` |
| `36f8db60` / `getCustomerPro` | `未显式指定` `"clients_services"` (params) | `CONTROLLER {A}/clients_services` → `admin/ClientsServices`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L598)<br>`GET {A}/clients_services` → `admin/ClientsServices/index`；规则 `app\admin\controller\ClientsServicescontroller::index`；[源行](../../data/route/admin.php#L599) | 未提取；新设计明确成功后重读受影响对象 |
| `36f8db60` / `getCustomerInfo` | `未显式指定` `"get_user"` (params) | `GET {A}/get_user` → `admin/user_manage/getUser`；规则 `app\admin\controller\UserManagecontroller::getuser`；[源行](../../data/route/admin.php#L171) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/developer",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/person",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/product-list",query:{id:e.id,hid:e.hid,currencyId:e.currencyId}}`
- 旧跳转：`render router-link: {path:"/customer-view/bill",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/transactions",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/credit",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/tickets",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/log",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/api-overview",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/noticelog",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/annex",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/promotion_plan",query:{id:e.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/follow-status",query:{id:e.id}}`
- 旧跳转：`handleClick: this.$router.push({path:this.route[e.name],query:{id:this.id,uid:this.uid,currencyId:this.currencyId}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p028"></a>

## 客户摘要 `/customer-view/abstract`

旧版证据：[P028](27-admin-built-page-evidence.md#p028)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“客户摘要”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `cc92/1e1dde92` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `cc92/1e1dde92` | `el-dialog` | `-` / `-` / `创建充值账单 ($lang.create_bill)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `cc92/1e1dde92` | `图标/动态文案，回查原证据` | `on.change → t.closeCustomer` | `无提取条件` |
| `cc92/1e1dde92` | `图标/动态文案，回查原证据` | `on.click → function(e){return e.preventDefault(),t.getJwt(e)}`<br>`on.mousedown → t.rightHandleClick` | `无提取条件` |
| `cc92/1e1dde92` | `添加账单 ($lang.add_bill)` | `on.click → t.addBillHandleClick` | `无提取条件` |
| `cc92/1e1dde92` | `管理余额 ($lang.manage_balance)` | `on.click → t.toBalance` | `无提取条件` |
| `cc92/1e1dde92` | `查看订单 ($lang.select_order)` | `on.click → t.goOrderView` | `无提取条件` |
| `cc92/1e1dde92` | `添加订单 ($lang.add_order)` | `on.click → t.goAddOrder` | `无提取条件` |
| `cc92/1e1dde92` | `确定 ($lang.confirm)` | `on.click → t.creatBillHandleClick` | `无提取条件` |
| `cc92/1e1dde92` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1e1dde92` / `creditLimit` | `未显式指定` `"credit_limit"` (params) | `GET {A}/credit_limit` → `admin/credit_limit/index`；规则 `app\admin\controller\CreditLimitcontroller::index`；[源行](../../data/route/admin.php#L570)<br>`POST {A}/credit_limit` → `admin/credit_limit/save`；规则 `app\admin\controller\CreditLimitcontroller::save`；[源行](../../data/route/admin.php#L572)<br>`PUT {A}/credit_limit` → `admin/credit_limit/update`；规则 `app\admin\controller\CreditLimitcontroller::update`；[源行](../../data/route/admin.php#L573)<br>`DELETE {A}/credit_limit` → `admin/credit_limit/delete`；规则 `app\admin\controller\CreditLimitcontroller::delete`；[源行](../../data/route/admin.php#L574) | `formatDate` |
| `1e1dde92` / `notesChangeSubmit` | `"post"` `"post_client_notes"` (data) | `POST {A}/post_client_notes` → `admin/user_manage/postClientNotes`；规则 `app\admin\controller\UserManagecontroller::postclientnotes`；[源行](../../data/route/admin.php#L213) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `getMsgData` | `未显式指定` `"profile/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getCustomData` |
| `1e1dde92` / `editUserData` | `"post"` `"profile_post"` (data) | `POST {A}/profile_post` → `admin/user_manage/profilePost`；规则 `app\admin\controller\UserManagecontroller::profilepost`；[源行](../../data/route/admin.php#L197) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `getData` | `未显式指定` `"summary?client_id=".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `getJwt` | `未显式指定` `"login_by_user/"+t` (无显式 data/params) | `GET {A}/login_by_user/:uid` → `admin/user_manage/loginByUser`；规则 `app\admin\controller\UserManagecontroller::loginbyuser`；[源行](../../data/route/admin.php#L205) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `personDetail` | `未显式指定` `"certifi_person_detail/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `addBillHandleClick` | `"post"` `"add_user_invoice"` (data) | `POST {A}/add_user_invoice` → `admin/user_manage/addUserInvoice`；规则 `app\admin\controller\UserManagecontroller::adduserinvoice`；[源行](../../data/route/admin.php#L190) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `creatBillHandleClick` | `"post"` `"add_recharge_invoice/"+t.uid` (data) | `POST {A}/add_recharge_invoice/:uid` → `admin/user_manage/addRechargeInvoice`；规则 `app\admin\controller\UserManagecontroller::addrechargeinvoice`；[源行](../../data/route/admin.php#L206) | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `closeCustomer` | `未显式指定` `"close_client/".concat(t)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `deleteCustomer` | `未显式指定` `"delete_client/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1e1dde92` / `changeStatus` | `"post"` `"certifi_status"` (data) | `POST {A}/certifi_status` → `admin/user_manage/certifiStatus`；规则 `app\admin\controller\UserManagecontroller::certifistatus`；[源行](../../data/route/admin.php#L184) | `personDetail` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/tickets",query:{id:t.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/transactions",query:{id:t.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/bill",query:{id:t.id}}`
- 旧跳转：`toAddRecords: this.$router.push({path:"/add-records",query:{uid:this.$route.query.id}})`
- 旧跳转：`goOrderView: this.$router.push({path:"/order-list",query:{uid:this.$route.query.id,username:this.summary.username}})`
- 旧跳转：`goAddOrder: this.$router.push({path:"/add-order",query:{uid:this.$route.query.id,username:this.summary.username}})`
- 旧跳转：`editUserData: e.$router.push("/customer-list")`
- 旧跳转：`getData: t.$router.push("/customer-list")`
- 旧跳转：`addBillHandleClick: t.$router.push({path:"/bill-detail",query:{id:i.invoice_id,uid:t.id}})`
- 旧跳转：`creatBillHandleClick: t.$router.push({path:"/customer-view/bill",query:{id:t.id}})`
- 旧跳转：`goToProduct: this.$router.push({name:"productInnerpage",query:{id:this.id,hid:t}})`
- 旧跳转：`deleteCustomer: t.$router.push({name:"customerList"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p029"></a>

## 客户站内信记录 `/customer-view/station-letterlog`

旧版证据：[P029](27-admin-built-page-evidence.md#p029)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“客户站内信记录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8b1d/15a474cc` | `el-form-item` | `时间 ($lang.time)` / `search_timeShow` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b1d/15a474cc` | `el-form-item` | `主题 ($lang.theme)` / `keywords` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b1d/15a474cc` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b1d/15a474cc` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b1d/15a474cc` | `el-form-item` | `下载附件 ($lang.download_attachment)` / `selectOpeartion` / `-` | `scopedSlots; n.attachment&&n.attachment.length` | 分组表单；未知原值不置空 |
| `8b1d/15a474cc` | `el-table-column` | `发送时间 ($lang.send_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b1d/15a474cc` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b1d/15a474cc` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b1d/15a474cc` | `el-table-column` | `状态 ($lang.state)` / `read_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8b1d/15a474cc` | `搜索 ($lang.search)` | `on.click → function(t){return e.getSystemlog("loading")}` | `无提取条件` |
| `8b1d/15a474cc` | `e._s(t.name)+" "` | `on.click → function(a){return e.downloadAnnex(t)}` | `scopedSlots; n.attachment&&n.attachment.length; 循环 n.attachment` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `15a474cc` / `getSystemlog` | `未显式指定` `"log_record/system_message_log"` (params) | `GET {A}/log_record/system_message_log` → `admin/log_record/getSystemMessageLog`；规则 `app\admin\controller\LogRecordcontroller::getsystemmessagelog`；[源行](../../data/route/admin.php#L629) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p030"></a>

## 客户开发者信息 `/customer-view/developer`

旧版证据：[P030](27-admin-built-page-evidence.md#p030)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“客户开发者信息”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `de9a/4c2ba7b0` | `el-form-item` | `作者昵称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `de9a/4c2ba7b0` | `el-form-item` | `联系方式` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `de9a/4c2ba7b0` | `el-form-item` | `个人简介` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `de9a/4c2ba7b0` | `el-dialog` | `-` / `-` / `创建充值账单` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `de9a/4c2ba7b0` | `图标/动态文案，回查原证据` | `on.click → function(e){return e.preventDefault(),t.getJwt(e)}`<br>`on.mousedown → t.rightHandleClick` | `无提取条件` |
| `de9a/4c2ba7b0` | `取 消` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `de9a/4c2ba7b0` | `确 定` | `on.click → t.creatBillHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4c2ba7b0` / `getDeveloperDetail` | `未显式指定` `"developer/developerdetail"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4c2ba7b0` / `getSummary` | `未显式指定` `"summary?client_id=".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4c2ba7b0` / `getJwt` | `未显式指定` `"login_by_user/"+t` (无显式 data/params) | `GET {A}/login_by_user/:uid` → `admin/user_manage/loginByUser`；规则 `app\admin\controller\UserManagecontroller::loginbyuser`；[源行](../../data/route/admin.php#L205) | 未提取；新设计明确成功后重读受影响对象 |
| `4c2ba7b0` / `personDetail` | `未显式指定` `"certifi_person_detail/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4c2ba7b0` / `addBillHandleClick` | `"post"` `"add_user_invoice"` (data) | `POST {A}/add_user_invoice` → `admin/user_manage/addUserInvoice`；规则 `app\admin\controller\UserManagecontroller::adduserinvoice`；[源行](../../data/route/admin.php#L190) | 未提取；新设计明确成功后重读受影响对象 |
| `4c2ba7b0` / `creatBillHandleClick` | `"post"` `"add_recharge_invoice/"+t.uid` (data) | `POST {A}/add_recharge_invoice/:uid` → `admin/user_manage/addRechargeInvoice`；规则 `app\admin\controller\UserManagecontroller::addrechargeinvoice`；[源行](../../data/route/admin.php#L206) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`getSummary: t.$router.push("/customer-list")`
- 旧跳转：`addBillHandleClick: t.$router.push({path:"/bill-detail",query:{id:r.invoice_id,uid:t.id}})`
- 旧跳转：`creatBillHandleClick: t.$router.push({path:"/customer-view/bill",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p031"></a>

## 历史客户摘要 `/customer-view/abstractOld`

旧版证据：[P031](27-admin-built-page-evidence.md#p031)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“历史客户摘要”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `114e/2cf09ed4` | `el-table-column` | `ID` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `产品/服务 ($lang.product_service)` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `付款周期 ($lang.payment_period)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `订购时间 ($lang.order_time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `到期时间 ($lang.due_time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `状态 ($lang.state)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `114e/2cf09ed4` | `el-dialog` | `-` / `-` / `创建充值账单 ($lang.create_bill)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `114e/2cf09ed4` | `以该客户登录 ($lang.log_customer)` | `on.mousedown → t.toShopping` | `无提取条件` |
| `114e/2cf09ed4` | `添加账单 ($lang.add_bill)` | `on.click → t.addBillHandleClick` | `无提取条件` |
| `114e/2cf09ed4` | `创建充值账单 ($lang.create_bill)` | `on.click → function(e){t.dialogVisible=!0}` | `无提取条件` |
| `114e/2cf09ed4` | `余额管理 ($lang.balance_manage)` | `on.click → t.toBalance` | `无提取条件` |
| `114e/2cf09ed4` | `关闭该客户账户 ($lang.close_customer_account)` | `on.click → t.closeCustomer` | `无提取条件` |
| `114e/2cf09ed4` | `删除该客户账户 ($lang.delete_customer_account)` | `on.click → t.deleteCustomer` | `无提取条件` |
| `114e/2cf09ed4` | `a.hid` | `on.click → function(e){return t.goToProduct(a.hid)}` | `scopedSlots` |
| `114e/2cf09ed4` | `a.hostname` | `on.click → function(e){return t.goToProduct(a.hid)}` | `scopedSlots` |
| `114e/2cf09ed4` | `编辑 ($lang.edit)` | `on.click → function(e){return t.goToProduct(a.hid)}` | `scopedSlots` |
| `114e/2cf09ed4` | `确定 ($lang.confirm)` | `on.click → t.creatBillHandleClick` | `无提取条件` |
| `114e/2cf09ed4` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2cf09ed4` / `getData` | `未显式指定` `"summary?client_id=".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `toShopping` | `未显式指定` `"login_by_user/"+t` (无显式 data/params) | `GET {A}/login_by_user/:uid` → `admin/user_manage/loginByUser`；规则 `app\admin\controller\UserManagecontroller::loginbyuser`；[源行](../../data/route/admin.php#L205) | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `personDetail` | `未显式指定` `"certifi_person_detail/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `addBillHandleClick` | `"post"` `"add_user_invoice"` (data) | `POST {A}/add_user_invoice` → `admin/user_manage/addUserInvoice`；规则 `app\admin\controller\UserManagecontroller::adduserinvoice`；[源行](../../data/route/admin.php#L190) | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `creatBillHandleClick` | `"post"` `"add_recharge_invoice/"+t.uid` (data) | `POST {A}/add_recharge_invoice/:uid` → `admin/user_manage/addRechargeInvoice`；规则 `app\admin\controller\UserManagecontroller::addrechargeinvoice`；[源行](../../data/route/admin.php#L206) | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `closeCustomer` | `未显式指定` `"close_client/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `deleteCustomer` | `未显式指定` `"delete_client/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2cf09ed4` / `changeStatus` | `"post"` `"certifi_status"` (data) | `POST {A}/certifi_status` → `admin/user_manage/certifiStatus`；规则 `app\admin\controller\UserManagecontroller::certifistatus`；[源行](../../data/route/admin.php#L184) | `personDetail` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/add-order",query:{uid:t.id}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:t.id,hid:a.hid}}`
- 旧跳转：`getData: t.$router.push("/customer-list")`
- 旧跳转：`addBillHandleClick: t.$router.push({path:"/bill-detail",query:{id:a.invoice_id,uid:t.id}})`
- 旧跳转：`creatBillHandleClick: t.$router.push({path:"/customer-view/bill",query:{id:t.id}})`
- 旧跳转：`goToProduct: this.$router.push({name:"productInnerpage",query:{id:this.id,hid:t}})`
- 旧跳转：`deleteCustomer: t.$router.push({name:"customerList"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p032"></a>

## 客户账单 `/customer-view/bill`

旧版证据：[P032](27-admin-built-page-evidence.md#p032)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户账单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3d9c/56c95a36` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `付款方式 ($lang.payment_term)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `账单支付日 ($lang.bills_day)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `付款状态 ($lang.payment_status)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `总计 ($lang.total)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `账单内容 ($lang.bill_content)` / `""` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `3d9c/56c95a36` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `账单ID ($lang.bill_id)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `账单生成日 ($lang.bill_generation_day)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `账单逾期日 ($lang.bill_overdue_date)` / `due_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `账单支付日 ($lang.bills_day)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `总计 ($lang.total)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `支付方式 ($lang.payment_mode)` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `账单类型 ($lang.bill_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3d9c/56c95a36` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3d9c/56c95a36` | `添加账单 ($lang.add_bill)` | `on.click → e.newBillHandleClick` | `无提取条件` |
| `3d9c/56c95a36` | `e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `3d9c/56c95a36` | `搜索 ($lang.search)` | `on.click → e.getData` | `e.showSearchArea` |
| `3d9c/56c95a36` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `3d9c/56c95a36` | `a.id` | `on.click → function(t){return e.editBillHandleClick(a.id)}` | `scopedSlots` |
| `3d9c/56c95a36` | `查看 ($lang.to_view)` | `on.click → function(t){return e.editBillHandleClick(a.id)}` | `scopedSlots` |
| `3d9c/56c95a36` | `删除` | `on.click → function(t){return e.deleteBillHandleClick(a.id)}` | `scopedSlots` |
| `3d9c/56c95a36` | `标记为已支付 ($lang.mark_paid)` | `on.click → e.markPaidHandleClick` | `无提取条件` |
| `3d9c/56c95a36` | `合并账单 ($lang.merge_bill)` | `on.click → function(t){e.combineDialogVis=!0}` | `无提取条件` |
| `3d9c/56c95a36` | `标记为被取消 ($lang.marked_cancell)` | `on.click → e.markCancelledHandleClick` | `无提取条件` |
| `3d9c/56c95a36` | `复制账单 ($lang.copy_bill)` | `on.click → e.copyBillHandleClick` | `无提取条件` |
| `3d9c/56c95a36` | `删除 ($lang.delete)` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `56c95a36` / `searchPage` | `未显式指定` `"invoice/search_page"` (params) | `GET {A}/invoice/search_page` → `admin/invoice/searchPage`；规则 `app\admin\controller\Invoicecontroller::searchpage`；[源行](../../data/route/admin.php#L533) | 未提取；新设计明确成功后重读受影响对象 |
| `56c95a36` / `newBillHandleClick` | `"post"` `"add_user_invoice"` (data) | `POST {A}/add_user_invoice` → `admin/user_manage/addUserInvoice`；规则 `app\admin\controller\UserManagecontroller::adduserinvoice`；[源行](../../data/route/admin.php#L190) | 未提取；新设计明确成功后重读受影响对象 |
| `56c95a36` / `getData` | `未显式指定` `"user_invoice"` (params) | `GET {A}/user_invoice` → `admin/user_manage/userInvoice`；规则 `app\admin\controller\UserManagecontroller::userinvoice`；[源行](../../data/route/admin.php#L187) | 未提取；新设计明确成功后重读受影响对象 |
| `56c95a36` / `deleteBillHandleClick` | `"delete"` `"invoice/delete"` (params) | `DELETE {A}/invoice/delete` → `admin/invoice/delete`；规则 `app\admin\controller\Invoicecontroller::delete`；[源行](../../data/route/admin.php#L538) | `getData` |
| `56c95a36` / `markPaidHandleClick` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | `getData` |
| `56c95a36` / `markUnpaidHandleClick` | `未显式指定` `"invoice/unpaid"` (params) | `GET {A}/invoice/unpaid` → `admin/invoice/unpaid`；规则 `app\admin\controller\Invoicecontroller::unpaid`；[源行](../../data/route/admin.php#L536) | `getData` |
| `56c95a36` / `markCancelledHandleClick` | `未显式指定` `"invoice/cancelled"` (params) | `GET {A}/invoice/cancelled` → `admin/invoice/cancelled`；规则 `app\admin\controller\Invoicecontroller::cancelled`；[源行](../../data/route/admin.php#L537) | `getData` |
| `56c95a36` / `copyBillHandleClick` | `未显式指定` `"invoice/duplicate"` (params) | `GET {A}/invoice/duplicate` → `admin/invoice/duplicate`；规则 `app\admin\controller\Invoicecontroller::duplicate`；[源行](../../data/route/admin.php#L539) | `getData` |
| `56c95a36` / `deleteOrderHandleClick` | `"delete"` `"invoice/delete"` (params) | `DELETE {A}/invoice/delete` → `admin/invoice/delete`；规则 `app\admin\controller\Invoicecontroller::delete`；[源行](../../data/route/admin.php#L538) | `getData` |
| `56c95a36` / `getCombineInvoices` | `未显式指定` `"get_combine_invoices"` (params) | `GET {A}/get_combine_invoices` → `admin/invoice/getCombineInvoices`；规则 `app\admin\controller\Invoicecontroller::getcombineinvoices`；[源行](../../data/route/admin.php#L512) | 未提取；新设计明确成功后重读受影响对象 |
| `56c95a36` / `combineSubmit` | `"post"` `"combine_invoices"` (data) | `POST {A}/combine_invoices` → `admin/invoice/combineInvoices`；规则 `app\admin\controller\Invoicecontroller::combineinvoices`；[源行](../../data/route/admin.php#L513) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:a.id,uid:e.id}}`
- 旧跳转：`newBillHandleClick: e.$router.push({path:"/bill-detail",query:{id:a.invoice_id,uid:e.id}})`
- 旧跳转：`editBillHandleClick: this.$router.push({path:"/bill-detail",query:{id:e,uid:this.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p033"></a>

## 客户交易 `/customer-view/transactions`

旧版证据：[P033](27-admin-built-page-evidence.md#p033)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户交易”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2e73/e3e8f242` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `交易记录号 ($lang.transaction_record_number)` / `trans_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `交易记录生成日 ($lang.transaction_record_date)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `收入 ($lang.income)` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `手续费 ($lang.poundage)` / `fees` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `支出 ($lang.spend)` / `amount_out` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e73/e3e8f242` | `el-dialog` | `-` / `-` / `this.formData.id?t.$lang.edit_transaction_record:t.$lang.add_transaction_record` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `2e73/e3e8f242` | `el-form-item` | `付款时间 ($lang.payment_time)` / `pay_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `账单编号 ($lang.bill_number)` / `invoice_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `收入 ($lang.income)` / `amount_in` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `支出 ($lang.spend)` / `amount_out` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `手续费 ($lang.poundage)` / `fees` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `货币类型 ($lang.currency_type)` / `currency` / `-` | `else(t.formData.id)` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-dialog` | `-` / `-` / `编辑交易记录 ($lang.edit_transaction_record)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `2e73/e3e8f242` | `el-form-item` | `付款时间 ($lang.payment_time)` / `pay_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `账单编号 ($lang.bill_number)` / `invoice_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `收入 ($lang.income)` / `amount_in` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `支出 ($lang.spend)` / `amount_out` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2e73/e3e8f242` | `el-form-item` | `手续费 ($lang.poundage)` / `fees` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2e73/e3e8f242` | `添加交易记录` | `on.click → function(e){t.DialogVisiable=!0}` | `无提取条件` |
| `2e73/e3e8f242` | `编辑` | `on.click → function(e){return t.editHandleClick(r.id)}` | `scopedSlots` |
| `2e73/e3e8f242` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteHandleClick(r.id)}` | `scopedSlots` |
| `2e73/e3e8f242` | `取消 ($lang.cancel)` | `on.click → function(e){t.DialogVisiable=!1}` | `无提取条件` |
| `2e73/e3e8f242` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |
| `2e73/e3e8f242` | `取消 ($lang.cancel)` | `on.click → function(e){t.editDialogVisiable=!1}` | `无提取条件` |
| `2e73/e3e8f242` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `e3e8f242` / `getTableData` | `未显式指定` `"accounts"` (params) | `GET {A}/accounts` → `admin/account/index`；规则 `app\admin\controller\Accountcontroller::index`；[源行](../../data/route/admin.php#L560)<br>`POST {A}/accounts` → `admin/account/save`；规则 `app\admin\controller\Accountcontroller::save`；[源行](../../data/route/admin.php#L563) | 未提取；新设计明确成功后重读受影响对象 |
| `e3e8f242` / `getAddPageInfo` | `未显式指定` `"accounts/create?uid="+t` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `e3e8f242` / `submitForm` | `"post"` `"accounts"` (data) | `POST {A}/accounts` → `admin/account/save`；规则 `app\admin\controller\Accountcontroller::save`；[源行](../../data/route/admin.php#L563) | `getTableData` |
| `e3e8f242` / `submitForm` | `"put"` `"accounts/".concat(t)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getTableData` |
| `e3e8f242` / `editHandleClick` | `未显式指定` `"accounts/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `e3e8f242` / `deleteHandleClick` | `"delete"` `"accounts/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getTableData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p034"></a>

## 客户余额与信用额 `/customer-view/credit`

旧版证据：[P034](27-admin-built-page-evidence.md#p034)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：余额credit与信用额credit_limit分区，不把余额调整当信用额修改；还款、额度、日志按各自接口读取。不得新增无依据的冻结/解冻。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6334/0236ef30` | `el-dialog` | `-` / `-` / `调整额度 ($lang.adjust_amount)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6334/0236ef30` | `el-dialog` | `-` / `-` / `调整时间 ($lang.adjust_time)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6334/0236ef30` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `付款方式 ($lang.payment_term)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `付款状态 ($lang.payment_status)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `账单#` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `金额 ($lang.sum)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `账单生成日 ($lang.bill_generation_day)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `账单逾期日 ($lang.bill_overdue_date)` / `due_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `付款方式 ($lang.payment_term)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `操作` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-dialog` | `-` / `-` / `调整记录 ($lang.adjust_record)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6334/0236ef30` | `el-form-item` | `类型 ($lang.type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `操作时间 ($lang.operating_time)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `描述信息 ($lang.description_information)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `""` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-table-column` | `ID` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `描述 ($lang.describe)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `类型 ($lang.type)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `操作时间 ($lang.operating_time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `操作人 ($lang.operator)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `操作IP ($lang.operation_of_IP)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-dialog` | `-` / `-` / `信用账单详情 ($lang.credit_bill_detail)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6334/0236ef30` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `付款状态 ($lang.payment_status)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6334/0236ef30` | `el-table-column` | `账单ID ($lang.bill_id)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `金额 ($lang.sum)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `产品 ($lang.product)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `类型 ($lang.type)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/0236ef30` | `el-table-column` | `账单生成日 ($lang.bill_generation_day)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6334/46bdf582` | `el-dialog` | `-` / `-` / `启用信用额` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6334/0236ef30` | `确定 ($lang.confirm)` | `on.click → function(t){return e.putCreditLimit("edu")}` | `无提取条件` |
| `6334/0236ef30` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogFormVisible=!1}` | `无提取条件` |
| `6334/0236ef30` | `确认修改 ($lang.confirm_the_change)` | `on.click → function(t){return e.putCreditLimit("time")}` | `无提取条件` |
| `6334/0236ef30` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogTime=!1}` | `无提取条件` |
| `6334/0236ef30` | `调整额度 ($lang.adjust_amount)` | `on.click → function(t){e.dialogFormVisible=!0}` | `无提取条件` |
| `6334/0236ef30` | `关闭信用额 ($lang.close_credit)` | `on.click → e.deleteCreditLimit` | `无提取条件` |
| `6334/0236ef30` | `调整日期 ($lang.adjust_date)` | `on.click → function(t){e.dialogTime=!0}` | `无提取条件` |
| `6334/0236ef30` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `无提取条件` |
| `6334/0236ef30` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `无提取条件` |
| `6334/0236ef30` | `t.row.id` | `on.click → function(i){e.editBillHandleClick(t.row.id,t.row.uid)}` | `scopedSlots` |
| `6334/0236ef30` | `编辑 ($lang.edit)` | `on.click → function(i){e.editBillHandleClick(t.row.id,t.row.uid)}` | `scopedSlots` |
| `6334/0236ef30` | `查看 ($lang.to_view)` | `on.click → function(i){return e.showDialogOrderVisible(t.row.id)}` | `scopedSlots` |
| `6334/0236ef30` | `标记为已支付 ($lang.mark_paid)` | `on.click → e.markPaidHandleClick` | `无提取条件` |
| `6334/0236ef30` | `标记为被取消 ($lang.marked_cancell)` | `on.click → e.markCancelledHandleClick` | `无提取条件` |
| `6334/0236ef30` | `复制账单 ($lang.copy_bill)` | `on.click → e.copyBillHandleClick` | `无提取条件` |
| `6334/0236ef30` | `删除 ($lang.delete)` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |
| `6334/0236ef30` | `搜索 ($lang.search)` | `on.click → e.searchLog` | `无提取条件` |
| `6334/0236ef30` | `清空 ($lang.empty)` | `on.click → e.clearLog` | `无提取条件` |
| `6334/0236ef30` | `搜索 ($lang.search)` | `on.click → function(t){return e.showDialogOrderVisible(e.invoicedetail.invoice_id)}` | `无提取条件` |
| `6334/0236ef30` | `清空 ($lang.empty)` | `on.click → e.searchinvoicedetailClick` | `无提取条件` |
| `6334/46bdf582` | `启用信用额 ($lang.enable_credit)` | `on.click → e.enableCredit` | `0==e.creditLimitData.is_open_credit_limit` |
| `6334/46bdf582` | `提交 ($lang.submit)` | `on.click → e.showdialogFormVisible` | `无提取条件` |
| `6334/46bdf582` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogFormVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0236ef30` / `showDialogOrderVisible` | `未显式指定` `"credit_limit/user_invoice_detail"` (params) | `GET {A}/credit_limit/user_invoice_detail` → `admin/credit_limit/creditLimitInvoice`；规则 `app\admin\controller\CreditLimitcontroller::creditlimitinvoice`；[源行](../../data/route/admin.php#L577) | `formatDate` |
| `0236ef30` / `creditLimitLog` | `未显式指定` `"credit_limit/log"` (params) | `GET {A}/credit_limit/log` → `admin/credit_limit/log`；规则 `app\admin\controller\CreditLimitcontroller::log`；[源行](../../data/route/admin.php#L571) | `formatDate` |
| `0236ef30` / `putCreditLimit` | `"put"` `"credit_limit"` (data) | `PUT {A}/credit_limit` → `admin/credit_limit/update`；规则 `app\admin\controller\CreditLimitcontroller::update`；[源行](../../data/route/admin.php#L573) | `creditLimitLog` |
| `0236ef30` / `deleteCreditLimit` | `"delete"` `"credit_limit"` (params) | `DELETE {A}/credit_limit` → `admin/credit_limit/delete`；规则 `app\admin\controller\CreditLimitcontroller::delete`；[源行](../../data/route/admin.php#L574) | 未提取；新设计明确成功后重读受影响对象 |
| `0236ef30` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `0236ef30` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `0236ef30` / `searchPage` | `未显式指定` `"invoice/search_page"` (params) | `GET {A}/invoice/search_page` → `admin/invoice/searchPage`；规则 `app\admin\controller\Invoicecontroller::searchpage`；[源行](../../data/route/admin.php#L533) | 未提取；新设计明确成功后重读受影响对象 |
| `0236ef30` / `getData` | `未显式指定` `"credit_limit/user_invoice"` (params) | `GET {A}/credit_limit/user_invoice` → `admin/credit_limit/userInvoice`；规则 `app\admin\controller\CreditLimitcontroller::userinvoice`；[源行](../../data/route/admin.php#L576) | 未提取；新设计明确成功后重读受影响对象 |
| `0236ef30` / `markPaidHandleClick` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | `getData` |
| `0236ef30` / `markUnpaidHandleClick` | `未显式指定` `"invoice/unpaid"` (params) | `GET {A}/invoice/unpaid` → `admin/invoice/unpaid`；规则 `app\admin\controller\Invoicecontroller::unpaid`；[源行](../../data/route/admin.php#L536) | `getData` |
| `0236ef30` / `markCancelledHandleClick` | `未显式指定` `"invoice/cancelled"` (params) | `GET {A}/invoice/cancelled` → `admin/invoice/cancelled`；规则 `app\admin\controller\Invoicecontroller::cancelled`；[源行](../../data/route/admin.php#L537) | `getData` |
| `0236ef30` / `copyBillHandleClick` | `未显式指定` `"invoice/duplicate"` (params) | `GET {A}/invoice/duplicate` → `admin/invoice/duplicate`；规则 `app\admin\controller\Invoicecontroller::duplicate`；[源行](../../data/route/admin.php#L539) | `getData` |
| `0236ef30` / `deleteOrderHandleClick` | `"delete"` `"invoice/delete"` (params) | `DELETE {A}/invoice/delete` → `admin/invoice/delete`；规则 `app\admin\controller\Invoicecontroller::delete`；[源行](../../data/route/admin.php#L538) | `getData` |
| `46bdf582` / `creditLimit` | `未显式指定` `"credit_limit"` (params) | `GET {A}/credit_limit` → `admin/credit_limit/index`；规则 `app\admin\controller\CreditLimitcontroller::index`；[源行](../../data/route/admin.php#L570)<br>`POST {A}/credit_limit` → `admin/credit_limit/save`；规则 `app\admin\controller\CreditLimitcontroller::save`；[源行](../../data/route/admin.php#L572)<br>`PUT {A}/credit_limit` → `admin/credit_limit/update`；规则 `app\admin\controller\CreditLimitcontroller::update`；[源行](../../data/route/admin.php#L573)<br>`DELETE {A}/credit_limit` → `admin/credit_limit/delete`；规则 `app\admin\controller\CreditLimitcontroller::delete`；[源行](../../data/route/admin.php#L574) | `formatDate` |
| `46bdf582` / `getPersonDetail` | `未显式指定` `"certifi_person_detail/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `46bdf582` / `MsgCreditLimit` | `"post"` `"credit_limit"` (data) | `POST {A}/credit_limit` → `admin/credit_limit/save`；规则 `app\admin\controller\CreditLimitcontroller::save`；[源行](../../data/route/admin.php#L572) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:t.row.id,uid:t.row.uid}}`
- 旧跳转：`goProduct: this.$router.push({path:"/customer-view/product-innerpage",query:{id:e.uid,hid:e.hostid}})`
- 旧跳转：`adSearch: t.$router.replace({query:l})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`editBillHandleClick: this.$router.push({path:"/bill-detail",query:{id:e,uid:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p035"></a>

## 客户工单 `/customer-view/tickets`

旧版证据：[P035](27-admin-built-page-evidence.md#p035)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户工单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fd26/5f5ced86` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fd26/5f5ced86` | `el-table-column` | `主题 ($lang.theme)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fd26/5f5ced86` | `el-table-column` | `状态 ($lang.state)` / `status.title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fd26/5f5ced86` | `el-table-column` | `部门 ($lang.department)` / `depart_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fd26/5f5ced86` | `el-table-column` | `提交时间 ($lang.submit_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fd26/5f5ced86` | `el-table-column` | `上次回复 ($lang.last_reply)` / `last_replay` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fd26/5f5ced86` | `新建工单 ($lang.new_work_order)` | `on.click → t.newTicketsHandleClick` | `无提取条件` |
| `fd26/5f5ced86` | `"#"+t._s(e.row.tid)+"-"+t._s(e.row.title)` | `on.click → function(n){return t.toDetail(e.row.id,e.row.tid)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5f5ced86` / `getTableData` | `未显式指定` `"client_ticket"` (params) | `GET {A}/client_ticket` → `admin/ticket/getClientTicketPage`；规则 `app\admin\controller\Ticketcontroller::getclientticketpage`；[源行](../../data/route/admin.php#L504) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/support-ticket-detail",query:{id:e.row.id,tid:e.row.tid}}`
- 旧跳转：`newTicketsHandleClick: this.$router.push({path:"/add-support-ticket",query:{uid:this.id}})`
- 旧跳转：`toDetail: this.$router.push({path:"/support-ticket-detail",query:{id:t,tid:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p036"></a>

## 客户操作日志 `/customer-view/log`

旧版证据：[P036](27-admin-built-page-evidence.md#p036)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“客户操作日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b8ce/ef9c45f2` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b8ce/ef9c45f2` | `el-form-item` | `描述 ($lang.describe)` / `search_desc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b8ce/ef9c45f2` | `el-form-item` | `IP地址 ($lang.ip_address)` / `search_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b8ce/ef9c45f2` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b8ce/ef9c45f2` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8ce/ef9c45f2` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8ce/ef9c45f2` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8ce/ef9c45f2` | `el-table-column` | `来源 ($lang.source)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8ce/ef9c45f2` | `el-table-column` | `用户名 ($lang.user_name)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8ce/ef9c45f2` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ipaddr` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `b8ce/ef9c45f2` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `b8ce/ef9c45f2` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `ef9c45f2` / `getData` | `未显式指定` `"zjmf_finance_api/logs"` (params) | `GET {A}/zjmf_finance_api/logs` → `admin/zjmfFinanceApi/apiLog`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apilog`；[源行](../../data/route/admin.php#L770) | 未提取；新设计明确成功后重读受影响对象 |
| `ef9c45f2` / `getData` | `未显式指定` `"log_record"` (params) | `GET {A}/log_record` → `admin/user_manage/logRecord`；规则 `app\admin\controller\UserManagecontroller::logrecord`；[源行](../../data/route/admin.php#L202) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p037"></a>

## 客户通知记录 `/customer-view/noticelog`

旧版证据：[P037](27-admin-built-page-evidence.md#p037)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“客户通知记录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b9e7/081a5bdd` | `el-tab-pane` | `短信日志 ($lang.message_log)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `b9e7/081a5bdd` | `el-tab-pane` | `邮件日志 ($lang.mail_log)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `b9e7/081a5bdd` | `el-tab-pane` | `站内信日志 ($lang.intra_station_log)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p038"></a>

## 客户附件 `/customer-view/annex`

旧版证据：[P038](27-admin-built-page-evidence.md#p038)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户附件”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a505/07a1a08f` | `el-table-column` | `附件名称 ($lang.attachment_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-table-column` | `上传时间 ($lang.upload_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-table-column` | `上传人 ($lang.upload_people)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-table-column` | `文件名 ($lang.file_name)` / `downame` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-table-column` | `备注 ($lang.remarks)` / `remarks` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a505/07a1a08f` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a505/07a1a08f` | `上传 ($lang.upload)` | `on.click → e.openDia` | `无提取条件` |
| `a505/07a1a08f` | `r.name` | `on.click → function(t){return e.download(r.id)}` | `scopedSlots` |
| `a505/07a1a08f` | `编辑 ($lang.edit)` | `on.click → function(t){return e.editRow(r.id)}` | `scopedSlots` |
| `a505/07a1a08f` | `删除 ($lang.delete)` | `on.click → function(t){return e.delRow(r.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `07a1a08f` / `delRow` | `未显式指定` `"downloads/userfile"` (params) | `GET {A}/downloads/userfile` → `admin/Downloads/deleteUserFile`；规则 `app\admin\controller\Downloadscontroller::deleteuserfile`；[源行](../../data/route/admin.php#L591) | `getUserDown` |
| `07a1a08f` / `editRow` | `未显式指定` `"downloads/userfilepage"` (params) | `GET {A}/downloads/userfilepage` → `admin/Downloads/getUserFilePage`；规则 `app\admin\controller\Downloadscontroller::getuserfilepage`；[源行](../../data/route/admin.php#L593) | 未提取；新设计明确成功后重读受影响对象 |
| `07a1a08f` / `getUserDown` | `未显式指定` `"downloads/userdownlist"` (params) | `GET {A}/downloads/userdownlist` → `admin/Downloads/getUserDownList`；规则 `app\admin\controller\Downloadscontroller::getuserdownlist`；[源行](../../data/route/admin.php#L588) | 未提取；新设计明确成功后重读受影响对象 |
| `07a1a08f` / `handelConfirm` | `"post"` `"downloads/saveuserfile"` (params) | `POST {A}/downloads/saveuserfile` → `admin/Downloads/postSaveUserFile`；规则 `app\admin\controller\Downloadscontroller::postsaveuserfile`；[源行](../../data/route/admin.php#L594) | `getUserDown`、`close` |
| `07a1a08f` / `handelConfirm` | `"post"` `"downloads/adduserfile"` (data) | `POST {A}/downloads/adduserfile` → `admin/Downloads/postAddUserFile`；规则 `app\admin\controller\Downloadscontroller::postadduserfile`；[源行](../../data/route/admin.php#L592) | `getUserDown`、`close` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p039"></a>

## 客户短信记录 `/customer-view/smslog`

旧版证据：[P039](27-admin-built-page-evidence.md#p039)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“客户短信记录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a951/2fdf4dd8` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a951/2fdf4dd8` | `el-form-item` | `手机 ($lang.cellphone)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a951/2fdf4dd8` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a951/2fdf4dd8` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `时间 ($lang.time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `短信内容 ($lang.message_content)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `手机 ($lang.cellphone)` / `phone` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `是否成功 ($lang.is_success)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `fail_reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a951/2fdf4dd8` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a951/2fdf4dd8` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `a951/2fdf4dd8` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2fdf4dd8` / `getData` | `未显式指定` `"log_record/smslog"` (params) | `GET {A}/log_record/smslog` → `admin/log_record/getSmsLog`；规则 `app\admin\controller\LogRecordcontroller::getsmslog`；[源行](../../data/route/admin.php#L627) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p040"></a>

## 客户邮件记录 `/customer-view/emaillog`

旧版证据：[P040](27-admin-built-page-evidence.md#p040)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“客户邮件记录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9965/4be5aa6f` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9965/4be5aa6f` | `el-form-item` | `主题 ($lang.theme)` / `subject` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9965/4be5aa6f` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9965/4be5aa6f` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `主题 ($lang.theme)` / `subject` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `收件人 ($lang.recipient)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `是否成功 ($lang.is_success)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `fail_reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9965/4be5aa6f` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9965/4be5aa6f` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `9965/4be5aa6f` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |
| `9965/4be5aa6f` | `t.row.subject` | `on.click → function(a){return e.subjectHandleClick(t.row.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4be5aa6f` / `getData` | `未显式指定` `"log_record/emaillog"` (params) | `GET {A}/log_record/emaillog` → `admin/log_record/getEmailLog`；规则 `app\admin\controller\LogRecordcontroller::getemaillog`；[源行](../../data/route/admin.php#L625) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p041"></a>

## 客户资料 `/customer-view/person`

旧版证据：[P041](27-admin-built-page-evidence.md#p041)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：固定三组：个人资料；账户信息（手机/邮箱/QQ/密码）；其他设置（支付方式/推荐人/语言/销售/分组/状态及两个开关）。推荐人第一版只读，密码/头像不默认提交；保留currency等已读值与custom[id]。保存无变化不提交，400/超时保留草稿并重读，避免部分写入被误报为全部失败。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5899d/f40d8fe4` | `el-form-item` | `姓名 ($lang.name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `性别 ($lang.sex)` / `sex` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `公司 ($lang.firm)` / `companyname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `国家 ($lang.nation)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `省 ($lang.province)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `地址 ($lang.address)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `邮编 ($lang.postcode)` / `postcode` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `t.fieldname` / `-` / `-` | `循环 e.customList` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `了解途径 ($lang.understand_way)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `手机 ($lang.cellphone)` / `phonenumber` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `邮箱 ($lang.email)` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `QQ` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `支付方式 ($lang.payment_mode)` / `defaultgateway` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `推荐人 ($lang.referees)` / `aff_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `语言 ($lang.language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `销售 ($lang.sale)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `客户分组 ($lang.customer_group)` / `groupid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `接收营销信息 ($lang.receive_market_message)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-form-item` | `关闭发送邮件短信 ($lang.send_close)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5899d/f40d8fe4` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5899d/f40d8fe4` | `保存更改 ($lang.save_the_changes)` | `on.click → e.editCustomer` | `无提取条件` |
| `5899d/f40d8fe4` | `取消更改 ($lang.cancel_changes)` | `on.click → e.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `f40d8fe4` / `querySearchAsync` | `未显式指定` `"profile/getclients/".concat(e)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f40d8fe4` / `getMsgData` | `未显式指定` `"profile/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getCustomData` |
| `f40d8fe4` / `editCustomer` | `"post"` `"profile_post"` (data) | `POST {A}/profile_post` → `admin/user_manage/profilePost`；规则 `app\admin\controller\UserManagecontroller::profilepost`；[源行](../../data/route/admin.php#L197) | 未提取；新设计明确成功后重读受影响对象 |
| `f40d8fe4` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `f40d8fe4` / `getClientGroups` | `未显式指定` `"common/get_client_groups"` (无显式 data/params) | `GET {A}/common/get_client_groups` → `admin/common/getClientGroups`；规则 `app\admin\controller\Commoncontroller::getclientgroups`；[源行](../../data/route/admin.php#L97) | 未提取；新设计明确成功后重读受影响对象 |
| `f40d8fe4` / `getSmsCountry` | `未显式指定` `"common/get_sms_country"` (无显式 data/params) | `GET {A}/common/get_sms_country` → `admin/common/getSmsCountry`；规则 `app\admin\controller\Commoncontroller::getsmscountry`；[源行](../../data/route/admin.php#L101) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/payment-interface"}`
- 旧跳转：`render router-link: {path:"/general-settings/local"}`
- 旧跳转：`render router-link: {path:"/sales-management"}`
- 旧跳转：`render router-link: {path:"/customer-group"}`
- 旧跳转：`editCustomer: e.$router.push({path:"/customer-view/abstract",query:{id:e.id}})`
- 旧跳转：`cancel: this.$router.push({path:"/customer-view/abstract",query:{id:this.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p042"></a>

## 客户服务详情 `/customer-view/product-innerpage`

旧版证据：[P042](27-admin-built-page-evidence.md#p042)；归属：chunk 内候选，页面归属待人工确认。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：模块输出、任务状态与通用计费信息分开；接口200但无task_id不能伪造异步进度。候选组件须先核对默认导出，密码/控制台操作不自动执行。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0aab/7cab67cb` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `bd52/d14fcff0` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1fae/fceb5584` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `7cab67cb` / `reinstallDcim` | `"post"` `"upper/dcim_client/get_os"` (data) | `POST {A}/upper/dcim_client/get_os` → `admin/upperReaches/dcimClientGetOs`；规则 `app\admin\controller\UpperReachescontroller::dcimclientgetos`；[源行](../../data/route/admin.php#L751) | 未提取；新设计明确成功后重读受影响对象 |
| `7cab67cb` / `handelConfirm` | `"post"` `"upper/dcim_client/reinstall"` (data) | `POST {A}/upper/dcim_client/reinstall` → `admin/upperReaches/dcimClientReinstall`；规则 `app\admin\controller\UpperReachescontroller::dcimclientreinstall`；[源行](../../data/route/admin.php#L747) | `onClose` |
| `d14fcff0` / `handelConfirm` | `"post"` `"upper/dcim_client/crack_pass"` (data) | `POST {A}/upper/dcim_client/crack_pass` → `admin/upperReaches/dcimClientCrackPass`；规则 `app\admin\controller\UpperReachescontroller::dcimclientcrackpass`；[源行](../../data/route/admin.php#L748) | `onClose` |
| `fceb5584` / `makeFree` | `"post"` `"upper/emptyupper"` (data) | `POST {A}/upper/emptyupper` → `admin/upperReaches/emptyUpper`；规则 `app\admin\controller\UpperReachescontroller::emptyupper`；[源行](../../data/route/admin.php#L735) | `distributionCb` |
| `fceb5584` / `distribution` | `"post"` `"upper/allotupper"` (data) | `POST {A}/upper/allotupper` → `admin/upperReaches/allotUpper`；规则 `app\admin\controller\UpperReachescontroller::allotupper`；[源行](../../data/route/admin.php#L734) | `distributionCb` |
| `fceb5584` / `getupperTable` | `未显式指定` `"upper/upperindex"` (params) | `ANY {A}/upper/upperindex` → `admin/upperReaches/upperIndex`；规则 `app\admin\controller\UpperReachescontroller::upperindex`；[源行](../../data/route/admin.php#L724)<br>`ANY {A}/upper/upperindex` → `admin/upperReaches/upperIndex`；规则 `app\admin\controller\UpperReachescontroller::upperindex`；[源行](../../data/route/admin.php#L728) | 未提取；新设计明确成功后重读受影响对象 |
| `fceb5584` / `getupperList` | `未显式指定` `"upper/index"` (params) | `ANY {A}/upper/index` → `admin/upperReaches/index`；规则 `app\admin\controller\UpperReachescontroller::index`；[源行](../../data/route/admin.php#L720) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goIP: this.$router.push({path:"/addOrEdit-resource",query:{id:e.id}})`
- 旧跳转：`goProduct: this.$router.push({path:"/customer-view/product-innerpage",query:{id:e.uid,hid:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p043"></a>

## 客户产品服务 `/customer-view/product-list`

旧版证据：[P043](27-admin-built-page-evidence.md#p043)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户产品服务”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `bc20/fd7646c6` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `ID` / `hid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `产品/服务 ($lang.product_service)` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `产品类型 ($lang.product_type)` / `host_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `付款周期 ($lang.payment_period)` / `billingcycle` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `订购时间 ($lang.order_time)` / `regdate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `到期时间 ($lang.expire_date)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `状态 ($lang.state)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bc20/fd7646c6` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `bc20/fd7646c6` | `r.hid` | `on.click → function(t){return e.goToProduct(r.hid)}` | `scopedSlots` |
| `bc20/fd7646c6` | `r.name` | `on.click → function(t){return e.goToProduct(r.hid)}` | `scopedSlots` |
| `bc20/fd7646c6` | `编辑` | `on.click → function(t){return e.goToProduct(r.hid)}` | `scopedSlots` |
| `bc20/fd7646c6` | `续费 ($lang.renew)` | `on.click → e.renewHandleClick` | `无提取条件` |
| `bc20/fd7646c6` | `批量删除 ($lang.batch_delete)` | `on.click → e.delHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `fd7646c6` / `getData` | `未显式指定` `"hostbyuid"` (params) | `GET {A}/hostbyuid` → `admin/user_manage/hostByUid`；规则 `app\admin\controller\UserManagecontroller::hostbyuid`；[源行](../../data/route/admin.php#L176) | 未提取；新设计明确成功后重读受影响对象 |
| `fd7646c6` / `getRenewData` | `"post"` `"clients_services/host_batch_renew_page"` (data) | `POST {A}/clients_services/host_batch_renew_page` → `admin/clients_services/postBatchRenewPage`；规则 `app\admin\controller\ClientsServicescontroller::postbatchrenewpage`；[源行](../../data/route/admin.php#L602) | 未提取；新设计明确成功后重读受影响对象 |
| `fd7646c6` / `delHandleClick` | `"delete"` `"clients_services/host"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `fd7646c6` / `createBill` | `"post"` `"clients_services/host_batch_renew"` (data) | `POST {A}/clients_services/host_batch_renew` → `admin/clients_services/postBatchRenew`；规则 `app\admin\controller\ClientsServicescontroller::postbatchrenew`；[源行](../../data/route/admin.php#L603) | `getData`、`useCredit`、`markPaid` |
| `fd7646c6` / `useCredit` | `"post"` `"clients_services/apply_credit"` (data) | `POST {A}/clients_services/apply_credit` → `admin/clients_services/applyCredit`；规则 `app\admin\controller\ClientsServicescontroller::applycredit`；[源行](../../data/route/admin.php#L605) | 未提取；新设计明确成功后重读受影响对象 |
| `fd7646c6` / `markPaid` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:e.id,hid:r.hid}}`
- 旧跳转：`goToProduct: this.$router.push({name:"productInnerpage",query:{id:this.id,hid:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p044"></a>

## 客户推介关系 `/customer-view/promotion_plan`

旧版证据：[P044](27-admin-built-page-evidence.md#p044)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“客户推介关系”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `479b/00272f56` | `el-tab-pane` | `注册记录 ($lang.registration_record)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `479b/00272f56` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `""` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-table-column` | `用户ID ($lang.user_id)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `用户名（公司名） ($lang.username_company)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `注册时间 ($lang.registration_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `最后登录时间 ($lang.last_login_time)` / `lastlogin` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-tab-pane` | `订购记录 ($lang.order_record)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `479b/00272f56` | `el-table-column` | `用户ID ($lang.user_id)` / `uid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `用户名` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `产品名称 ($lang.product_name)` / `child_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `订购时间 ($lang.order_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `付款时间 ($lang.payment_time)` / `aff_sure_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `佣金 ($lang.commissions)` / `commission` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-tab-pane` | `提现记录 ($lang.withdrawal_record)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `479b/00272f56` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `""` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-table-column` | `申请时间 ($lang.apply_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `提现金额 ($lang.withdrawal_amount)` / `num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `操作人 ($lang.operator)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `提现方式 ($lang.withdrawal_way)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `拒绝原因 ($lang.refuse_reason)` / `reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `479b/00272f56` | `el-tab-pane` | `个人设置 ($lang.personal_set)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `479b/00272f56` | `el-form-item` | `推介计划 ($lang.promotion_plan)` / `affiliate_enabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `推介计划比例类型 ($lang.referral_plan_type)` / `affiliate_type` / `-` | `1===e.dataFormData.affiliate_enabled` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `1===e.dataFormData.affiliate_type?e.$lang.recommend_scheme_amount:e.$lang.referral_plan_proportion` / `affiliate_bates` / `-` | `1===e.dataFormData.affiliate_enabled; e.dataFormData.affiliate_type` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `二次订购 ($lang.second_order)` / `affiliate_is_reorder` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `二次订单比例类型 ($lang.second_order_proportion_type)` / `affiliate_reorder_type` / `-` | `1===e.dataFormData.affiliate_is_reorder` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `1===e.dataFormData.affiliate_reorder_type?e.$lang.second_order_amount:e.$lang.second_order_ratio` / `affiliate_reorder` / `-` | `1===e.dataFormData.affiliate_is_reorder; e.dataFormData.affiliate_reorder_type` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `续费 ($lang.renew)` / `affiliate_is_renew` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `续费比例比例类型 ($lang.renewal_proportion_type)` / `affiliate_renew_type` / `-` | `1===e.dataFormData.affiliate_is_renew` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `1===e.dataFormData.affiliate_renew_type?e.$lang.renewal_amount:e.$lang.proportion_of_renewal` / `affiliate_renew` / `-` | `1===e.dataFormData.affiliate_is_renew; e.dataFormData.affiliate_renew_type` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `访问数量 ($lang.access_number)` / `visitors` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `注册数量 ($lang.register_num)` / `registcount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `订购数量 ($lang.ordere_number)` / `payamount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `可提现佣金 ($lang.withdrawable_commission)` / `balance` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `审核中的佣金 ($lang.commission_in_review)` / `audited_balance` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `已提现佣金 ($lang.have_withdrawal_commission)` / `withdrawn` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `479b/00272f56` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `479b/00272f56` | `e._s(e.showSearchArea2?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea2=!e.showSearchArea2}` | `无提取条件` |
| `479b/00272f56` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick2` | `无提取条件` |
| `479b/00272f56` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick2` | `无提取条件` |
| `479b/00272f56` | `r.username` | `on.click → function(t){return e.goToView(r.uid)}` | `scopedSlots` |
| `479b/00272f56` | `e._s(e.showSearchArea4?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea4=!e.showSearchArea4}` | `无提取条件` |
| `479b/00272f56` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick4` | `无提取条件` |
| `479b/00272f56` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick4` | `无提取条件` |
| `479b/00272f56` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `479b/00272f56` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |
| `479b/00272f56` | `提交 ($lang.submit)` | `on.click → e.submitForm2` | `无提取条件` |
| `479b/00272f56` | `重置 ($lang.reset)` | `on.click → e.resetForm2` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `00272f56` / `getUserGetMoneyRecordList` | `"get"` `"aff/useraffi_record"` (params) | `GET {A}/aff/useraffi_record` → `admin/affiliate/useraffirecord`；规则 `app\admin\controller\Affiliatecontroller::useraffirecord`；[源行](../../data/route/admin.php#L702) | 未提取；新设计明确成功后重读受影响对象 |
| `00272f56` / `getUserSettingList` | `"get"` `"aff/useraffi_list"` (params) | `GET {A}/aff/useraffi_list` → `admin/affiliate/useraffilist`；规则 `app\admin\controller\Affiliatecontroller::useraffilist`；[源行](../../data/route/admin.php#L701) | 未提取；新设计明确成功后重读受影响对象 |
| `00272f56` / `getUserBuyRecordList` | `"get"` `"aff/useraffibuy_record"` (params) | `GET {A}/aff/useraffibuy_record` → `admin/affiliate/useraffibuyrecord`；规则 `app\admin\controller\Affiliatecontroller::useraffibuyrecord`；[源行](../../data/route/admin.php#L703) | 未提取；新设计明确成功后重读受影响对象 |
| `00272f56` / `getLadder` | `未显式指定` `"affladder"` (params) | `GET {A}/affladder` → `admin/config_general/ladderList`；规则 `app\admin\controller\ConfigGeneralcontroller::ladderlist`；[源行](../../data/route/admin.php#L305) | 未提取；新设计明确成功后重读受影响对象 |
| `00272f56` / `getData` | `"get"` `"aff/useraffi_page"` (params) | `GET {A}/aff/useraffi_page` → `admin/affiliate/useraffiPage`；规则 `app\admin\controller\Affiliatecontroller::useraffipage`；[源行](../../data/route/admin.php#L700) | `isStratUse` |
| `00272f56` / `editRow02` | `未显式指定` `"aff/edit_affladderpage"` (params) | `GET {A}/aff/edit_affladderpage` → `admin/config_general/editAffLadderPage`；规则 `app\admin\controller\ConfigGeneralcontroller::editaffladderpage`；[源行](../../data/route/admin.php#L307) | 未提取；新设计明确成功后重读受影响对象 |
| `00272f56` / `deleteRow02` | `未显式指定` `"aff/del_affladder"` (params) | `GET {A}/aff/del_affladder` → `admin/config_general/delAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::delaffladder`；[源行](../../data/route/admin.php#L309) | `getLadder` |
| `00272f56` / `submitUseraffi` | `"post"` `"aff/useraffi_post"` (data) | `ANY {A}/aff/useraffi_post` → `admin/affiliate/useraffiPost`；规则 `app\admin\controller\Affiliatecontroller::useraffipost`；[源行](../../data/route/admin.php#L705) | `getData` |
| `00272f56` / `editMoney` | `"post"` `"aff/useraffi_balance"` (data) | `ANY {A}/aff/useraffi_balance` → `admin/affiliate/useraffibalance`；规则 `app\admin\controller\Affiliatecontroller::useraffibalance`；[源行](../../data/route/admin.php#L706) | `getData` |
| `00272f56` / `handelLadderConfirm` | `"post"` `"aff/add_affladder"` (params) | `ANY {A}/aff/add_affladder` → `admin/config_general/addAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::addaffladder`；[源行](../../data/route/admin.php#L306) | `getLadder`、`onLadderClose` |
| `00272f56` / `handelLadderConfirm` | `"post"` `"aff/edit_affladder"` (params) | `ANY {A}/aff/edit_affladder` → `admin/config_general/editAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::editaffladder`；[源行](../../data/route/admin.php#L308) | `getLadder`、`onLadderClose` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p045"></a>

## 客户跟进状态 `/customer-view/follow-status`

旧版证据：[P045](27-admin-built-page-evidence.md#p045)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“客户跟进状态”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5cdc/28d5e40c` | `el-dialog` | `-` / `-` / `e.addRemarkForm.id?e.$lang.supplement_record:e.$lang.add_record` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `5cdc/28d5e40c` | `el-form-item` | `时间 ($lang.time)` / `stime` / `-` | `e.addRemarkForm.id` | 分组表单；未知原值不置空 |
| `5cdc/28d5e40c` | `el-form-item` | `记录 ($lang.record)` / `remark` / `-` | `e.addRemarkForm.id` | 分组表单；未知原值不置空 |
| `5cdc/28d5e40c` | `el-form-item` | `时间 ($lang.time)` / `stime` / `-` | `else(e.addRemarkForm.id)` | 分组表单；未知原值不置空 |
| `5cdc/28d5e40c` | `el-form-item` | `记录 ($lang.record)` / `record` / `-` | `else(e.addRemarkForm.id)` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5cdc/28d5e40c` | `搜索 ($lang.search)` | `on.click → e.searchHandleClick` | `无提取条件` |
| `5cdc/28d5e40c` | `添加记录 ($lang.add_record)` | `on.click → function(t){e.addRecordVis=!0}` | `无提取条件` |
| `5cdc/28d5e40c` | `补充 ($lang.supplement)` | `on.click → function(a){return e.supplementHandleClick(t)}` | `循环 e.pageData.list` |
| `5cdc/28d5e40c` | `保存 ($lang.save)` | `on.click → e.submitForm` | `无提取条件` |
| `5cdc/28d5e40c` | `确定 ($lang.confirm)` | `on.click → e.addRecordSubmit` | `无提取条件` |
| `5cdc/28d5e40c` | `取消 ($lang.cancel)` | `on.click → function(t){e.addRecordVis=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `28d5e40c` / `getData` | `未显式指定` `"track_record"` (params) | `GET {A}/track_record` → `admin/user_manage/getTrackRecord`；规则 `app\admin\controller\UserManagecontroller::gettrackrecord`；[源行](../../data/route/admin.php#L193) | 未提取；新设计明确成功后重读受影响对象 |
| `28d5e40c` / `submitForm` | `"post"` `"track_status"` (data) | `POST {A}/track_status` → `admin/user_manage/clientTrackStatus`；规则 `app\admin\controller\UserManagecontroller::clienttrackstatus`；[源行](../../data/route/admin.php#L194) | `getData` |
| `28d5e40c` / `addRecordSubmit` | `"post"` `"add_remark_log"` (data) | `POST {A}/add_remark_log` → `admin/user_manage/addRemarkLog`；规则 `app\admin\controller\UserManagecontroller::addremarklog`；[源行](../../data/route/admin.php#L192) | `getData` |
| `28d5e40c` / `addRecordSubmit` | `"post"` `"add_record_log"` (data) | `POST {A}/add_record_log` → `admin/user_manage/addRecordLog`；规则 `app\admin\controller\UserManagecontroller::addrecordlog`；[源行](../../data/route/admin.php#L191) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p046"></a>

## 客户 API 概览 `/customer-view/api-overview`

旧版证据：[P046](27-admin-built-page-evidence.md#p046)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/customer-view`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“客户 API 概览”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fe5e/74d74acd` | `el-table-column` | `产品名称 ($lang.product_name)` / `name` / `-` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open)` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fe5e/74d74acd` | `el-table-column` | `试用数量 ($lang.trial_number)` / `ontrial` / `-` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open)` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fe5e/74d74acd` | `el-table-column` | `最大购买数量 ($lang.max_pay_number)` / `qty` / `-` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open)` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fe5e/74d74acd` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open)` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fe5e/74d74acd` | `el-dialog` | `-` / `-` / `this.formData.id?t.$lang.edit_exemption:t.$lang.add_exemption` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `fe5e/74d74acd` | `el-form-item` | `产品组 ($lang.product_group)` / `groupId` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fe5e/74d74acd` | `el-form-item` | `产品名称 ($lang.product_name)` / `"add"===t.type?"pid":""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fe5e/74d74acd` | `el-form-item` | `最大购买数量 ($lang.max_pay_number)` / `qty` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fe5e/74d74acd` | `el-form-item` | `试用数量 ($lang.trial_number)` / `ontrial` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fe5e/74d74acd` | `el-dialog` | `-` / `-` / `锁定原因 ($lang.lock_reason)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `fe5e/74d74acd` | `el-form-item` | `锁定原因 ($lang.lock_reason)` / `lock_reason` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fe5e/74d74acd` | `新增 ($lang.new_add)` | `on.click → t.addExemptionProduct` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open)` |
| `fe5e/74d74acd` | `编辑` | `on.click → function(e){return t.editHandleClick(a)}` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open); scopedSlots` |
| `fe5e/74d74acd` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteHandleClick(a.id)}` | `else(t.showNoOpen\|\|t.apiLoading\|\|2==t.api_open); scopedSlots` |
| `fe5e/74d74acd` | `立即开启 ($lang.immediate_open)` | `on.click → t.openApi` | `t.showNoOpen&&!t.apiLoading&&2!=t.api_open` |
| `fe5e/74d74acd` | `解除锁定 ($lang.unlocked)` | `on.click → t.unlockApi` | `else(t.showNoOpen\|\|t.apiLoading\|\|2!=t.api_open)` |
| `fe5e/74d74acd` | `取消 ($lang.cancel)` | `on.click → function(e){t.DialogVisiable=!1}` | `无提取条件` |
| `fe5e/74d74acd` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |
| `fe5e/74d74acd` | `取消 ($lang.cancel)` | `on.click → function(e){t.showReasonModal=!1}` | `无提取条件` |
| `fe5e/74d74acd` | `确定 ($lang.confirm)` | `on.click → t.submitLockApi` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `74d74acd` / `openApi` | `"post"` `"zjmf_finance_api/open"` (data) | `POST {A}/zjmf_finance_api/open` → `admin/zjmfFinanceApi/apiOpen`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apiopen`；[源行](../../data/route/admin.php#L771) | `getApiData` |
| `74d74acd` / `getProductInfo` | `未显式指定` `"zjmf_finance_api/freepage"` (params) | `GET {A}/zjmf_finance_api/freepage` → `admin/zjmfFinanceApi/apiFreePage`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apifreepage`；[源行](../../data/route/admin.php#L761)<br>`POST {A}/zjmf_finance_api/freepage` → `admin/zjmfFinanceApi/apiFreePost`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apifreepost`；[源行](../../data/route/admin.php#L762)<br>`DELETE {A}/zjmf_finance_api/freepage` → `admin/zjmfFinanceApi/apiFreeDelete`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apifreedelete`；[源行](../../data/route/admin.php#L763) | 未提取；新设计明确成功后重读受影响对象 |
| `74d74acd` / `unlockApi` | `"post"` `"zjmf_finance_api/toggle"` (data) | `POST {A}/zjmf_finance_api/toggle` → `admin/zjmfFinanceApi/apiToggle`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apitoggle`；[源行](../../data/route/admin.php#L760) | `getApiData` |
| `74d74acd` / `submitLockApi` | `"post"` `"zjmf_finance_api/toggle"` (data) | `POST {A}/zjmf_finance_api/toggle` → `admin/zjmfFinanceApi/apiToggle`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apitoggle`；[源行](../../data/route/admin.php#L760) | `getApiData` |
| `74d74acd` / `resetSecritKey` | `"post"` `"zjmf_finance_api/reset"` (data) | `POST {A}/zjmf_finance_api/reset` → `admin/zjmfFinanceApi/resetApiPwd`；规则 `app\admin\controller\ZjmfFinanceApicontroller::resetapipwd`；[源行](../../data/route/admin.php#L759) | `getApiData` |
| `74d74acd` / `getApiData` | `未显式指定` `"zjmf_finance_api/summary"` (params) | `GET {A}/zjmf_finance_api/summary` → `admin/zjmfFinanceApi/summary`；规则 `app\admin\controller\ZjmfFinanceApicontroller::summary`；[源行](../../data/route/admin.php#L758) | `chartFunc` |
| `74d74acd` / `submitForm` | `"post"` `"zjmf_finance_api/freepage"` (data) | `POST {A}/zjmf_finance_api/freepage` → `admin/zjmfFinanceApi/apiFreePost`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apifreepost`；[源行](../../data/route/admin.php#L762) | `getApiData` |
| `74d74acd` / `deleteHandleClick` | `"delete"` `"zjmf_finance_api/freepage"` (data) | `DELETE {A}/zjmf_finance_api/freepage` → `admin/zjmfFinanceApi/apiFreeDelete`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apifreedelete`；[源行](../../data/route/admin.php#L763) | `getApiData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p048"></a>

## 新增客户 `/customer-add`

旧版证据：[P048](27-admin-built-page-evidence.md#p048)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“新增客户”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7542/4dd45467` | `el-form-item` | `姓名 ($lang.name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `性别 ($lang.sex)` / `sex` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `所在公司 ($lang.company)` / `companyname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `国家 ($lang.nation)` / `country` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `省 ($lang.province)` / `province` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `地址 ($lang.address)` / `address1` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `邮编 ($lang.postcode)` / `postcode` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `e.fieldname` / `-` / `-` | `循环 t.customList` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `了解途径 ($lang.understand_way)` / `know_us` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `手机 ($lang.cellphone)` / `phonenumber` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `邮箱 ($lang.email)` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `QQ` / `qq` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `支付方式 ($lang.payment_mode)` / `defaultgateway` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `语言 ($lang.language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `销售 ($lang.sale)` / `sale_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `客户分组 ($lang.customer_group)` / `groupid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `管理员备注 ($lang.admin_remark)` / `notes` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7542/4dd45467` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7542/4dd45467` | `添加客户 ($lang.add_customer)` | `on.click → t.addForm` | `无提取条件` |
| `7542/4dd45467` | `返回 ($lang.return)` | `on.click → t.goBack` | `无提取条件` |
| `7542/4dd45467` | `取消添加 ($lang.cancel_add)` | `on.click → t.cancelAdd` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4dd45467` / `getAddMsgData` | `未显式指定` `"create_client"` (无显式 data/params) | `GET {A}/create_client` → `admin/user_manage/createClient`；规则 `app\admin\controller\UserManagecontroller::createclient`；[源行](../../data/route/admin.php#L198) | 未提取；新设计明确成功后重读受影响对象 |
| `4dd45467` / `addForm` | `"post"` `"create_client_post"` (data) | `POST {A}/create_client_post` → `admin/user_manage/createClientPost`；规则 `app\admin\controller\UserManagecontroller::createclientpost`；[源行](../../data/route/admin.php#L199) | 未提取；新设计明确成功后重读受影响对象 |
| `4dd45467` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `4dd45467` / `getClientGroups` | `未显式指定` `"common/get_client_groups"` (无显式 data/params) | `GET {A}/common/get_client_groups` → `admin/common/getClientGroups`；规则 `app\admin\controller\Commoncontroller::getclientgroups`；[源行](../../data/route/admin.php#L97) | 未提取；新设计明确成功后重读受影响对象 |
| `4dd45467` / `getSmsCountry` | `未显式指定` `"common/get_sms_country"` (无显式 data/params) | `GET {A}/common/get_sms_country` → `admin/common/getSmsCountry`；规则 `app\admin\controller\Commoncontroller::getsmscountry`；[源行](../../data/route/admin.php#L101) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/payment-interface"}`
- 旧跳转：`render router-link: {path:"/general-settings/local"}`
- 旧跳转：`render router-link: {path:"/sales-management"}`
- 旧跳转：`render router-link: {path:"/customer-group"}`
- 旧跳转：`addForm: t.$router.push("/customer-list")`
- 旧跳转：`goBack: this.$router.push("/customer-list")`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p049"></a>

## 客户分组 `/customer-group`

旧版证据：[P049](27-admin-built-page-evidence.md#p049)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户分组”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `50b8/4cbdc738` | `el-tab-pane` | `客户分组 ($lang.customer_group)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `50b8/4cbdc738` | `el-table-column` | `客户组名称 ($lang.client_group_name)` / `group_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `50b8/4cbdc738` | `el-table-column` | `组颜色 ($lang.set_color)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `50b8/4cbdc738` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `50b8/4cbdc738` | `el-dialog` | `-` / `-` / `(t.isFirstAdd?t.$lang.add:t.$lang.edit)+t.$lang.customer_group` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `50b8/4cbdc738` | `el-form-item` | `客户组名称 ($lang.client_group_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `50b8/4cbdc738` | `el-form-item` | `组颜色 ($lang.set_color)` / `color` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `50b8/4cbdc738` | `el-tab-pane` | `商品分组 ($lang.commodity_grouping)` / `-` / `-` | `t.$hiddenPromo` | 主区导航；保留对象与选中项 |
| `50b8/4cbdc738` | `el-table-column` | `组名称 ($lang.group_name)` / `group_name` / `-` | `t.$hiddenPromo` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `50b8/4cbdc738` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `t.$hiddenPromo` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `50b8/4cbdc738` | `el-dialog` | `-` / `-` / `-` | `t.$hiddenPromo` | 独立弹层；加载/校验/关闭保留草稿 |
| `50b8/4cbdc738` | `el-tab-pane` | `折扣设置 ($lang.discount_set)` / `-` / `-` | `t.$hiddenPromo` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `50b8/4cbdc738` | `帮助文档 ($lang.help_document)` | `on.click → t.openDoc` | `无提取条件` |
| `50b8/4cbdc738` | `添加客户分组` | `on.click → t.addGroupVis` | `无提取条件` |
| `50b8/4cbdc738` | `编辑 ($lang.edit)` | `on.click → function(a){return t.groupEdit(e.row)}` | `scopedSlots` |
| `50b8/4cbdc738` | `删除` | `on.click → function(a){return t.deletePrompt(e.row)}` | `scopedSlots` |
| `50b8/4cbdc738` | `取消 ($lang.cancel)` | `on.click → t.cancel` | `无提取条件` |
| `50b8/4cbdc738` | `保存更改` | `on.click → function(e){return t.groupAdd("addCustomerArray")}` | `无提取条件` |
| `50b8/4cbdc738` | `添加分组 ($lang.add_a_group)` | `on.click → t.addProduct` | `t.$hiddenPromo` |
| `50b8/4cbdc738` | `编辑` | `on.click → function(e){return t.editPro(r)}` | `t.$hiddenPromo; scopedSlots` |
| `50b8/4cbdc738` | `删除` | `on.click → function(e){return t.delPro(r)}` | `t.$hiddenPromo; scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4cbdc738` / `changeTypr` | `"post"` `"product/edit_userproductgroup"` (data) | `ANY {A}/product/edit_userproductgroup` → `admin/product/editUserProductgroup`；规则 `app\admin\controller\Productcontroller::edituserproductgroup`；[源行](../../data/route/admin.php#L441) | `getDiscount` |
| `4cbdc738` / `getDiscount` | `未显式指定` `"product/zklist_page"` (无显式 data/params) | `GET {A}/product/zklist_page` → `admin/product/zklistPage`；规则 `app\admin\controller\Productcontroller::zklistpage`；[源行](../../data/route/admin.php#L440) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `handleSizeChange` | `未显式指定` `"product/productgroup"` (params) | `GET {A}/product/productgroup` → `admin/product/groupList`；规则 `app\admin\controller\Productcontroller::grouplist`；[源行](../../data/route/admin.php#L434) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `currentChange` | `未显式指定` `"product/productgroup"` (params) | `GET {A}/product/productgroup` → `admin/product/groupList`；规则 `app\admin\controller\Productcontroller::grouplist`；[源行](../../data/route/admin.php#L434) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `editPro` | `未显式指定` `"product/edit_productgrouppage"` (params) | `GET {A}/product/edit_productgrouppage` → `admin/product/editProductgroupPage`；规则 `app\admin\controller\Productcontroller::editproductgrouppage`；[源行](../../data/route/admin.php#L437) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `delPro` | `未显式指定` `"product/del_productgroup"` (params) | `GET {A}/product/del_productgroup` → `admin/product/delProductgroup`；规则 `app\admin\controller\Productcontroller::delproductgroup`；[源行](../../data/route/admin.php#L439) | `getData`、`getProduct`、`getDiscount` |
| `4cbdc738` / `handelConfirm` | `"post"` `"product/add_productgroup"` (data) | `ANY {A}/product/add_productgroup` → `admin/product/addProductgroup`；规则 `app\admin\controller\Productcontroller::addproductgroup`；[源行](../../data/route/admin.php#L436) | `getData`、`getProduct`、`getDiscount`、`onClose` |
| `4cbdc738` / `handelConfirm` | `"post"` `"product/edit_productgroup"` (data) | `ANY {A}/product/edit_productgroup` → `admin/product/editProductgroup`；规则 `app\admin\controller\Productcontroller::editproductgroup`；[源行](../../data/route/admin.php#L438) | `getData`、`getProduct`、`getDiscount`、`onClose` |
| `4cbdc738` / `addProduct` | `未显式指定` `"product/add_productgrouppage"` (无显式 data/params) | `GET {A}/product/add_productgrouppage` → `admin/product/addProductgroupPage`；规则 `app\admin\controller\Productcontroller::addproductgrouppage`；[源行](../../data/route/admin.php#L435) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `getProduct` | `未显式指定` `"product/productgroup"` (params) | `GET {A}/product/productgroup` → `admin/product/groupList`；规则 `app\admin\controller\Productcontroller::grouplist`；[源行](../../data/route/admin.php#L434) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `getData` | `未显式指定` `"client_group"` (无显式 data/params) | `RESOURCE {A}/client_group` → `admin/ClientGroup`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L185) | 未提取；新设计明确成功后重读受影响对象 |
| `4cbdc738` / `deletePrompt` | `"delete"` `"client_group/"+t` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData`、`getProduct`、`getDiscount` |
| `4cbdc738` / `addGroup` | `"post"` `"client_group"` (data) | `RESOURCE {A}/client_group` → `admin/ClientGroup`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L185) | `getData`、`getProduct`、`getDiscount` |
| `4cbdc738` / `eidGroup` | `"put"` `"client_group/"+t.group_id` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData`、`getProduct`、`getDiscount` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p050"></a>

## 客户自定义字段 `/customer-custom`

旧版证据：[P050](27-admin-built-page-evidence.md#p050)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户自定义字段”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9094/3653e051` | `el-form-item` | `字段名称 ($lang.field_name)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `字段类型 ($lang.filed_type)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `描述 ($lang.describe)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `验证 ($lang.validation)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `选项 ($lang.option)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `显示排序 ($lang.according_to_sorting)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `其他设置 ($lang.other_set)` / `-` / `-` | `循环 e.customfields` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `字段名称 ($lang.field_name)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `字段类型 ($lang.filed_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `描述 ($lang.describe)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `验证 ($lang.validation)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `选项 ($lang.option)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `显示排序 ($lang.according_to_sorting)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9094/3653e051` | `el-form-item` | `其他设置 ($lang.other_set)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9094/3653e051` | `删除` | `on.click → function(l){return e.deleteCustom(t.id,t.type)}` | `循环 e.customfields` |
| `9094/3653e051` | `提交 ($lang.submit)` | `on.click → e.editCustom` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3653e051` / `getData` | `未显式指定` `"custom_fields"` (无显式 data/params) | `GET {A}/custom_fields` → `admin/set/getCustomFields`；规则 `app\admin\controller\Setcontroller::getcustomfields`；[源行](../../data/route/admin.php#L223)<br>`POST {A}/custom_fields` → `admin/set/postCustomFields`；规则 `app\admin\controller\Setcontroller::postcustomfields`；[源行](../../data/route/admin.php#L224) | 未提取；新设计明确成功后重读受影响对象 |
| `3653e051` / `editCustom` | `"post"` `"custom_fields"` (data) | `POST {A}/custom_fields` → `admin/set/postCustomFields`；规则 `app\admin\controller\Setcontroller::postcustomfields`；[源行](../../data/route/admin.php#L224) | `getData` |
| `3653e051` / `deleteCustom` | `"post"` `"del_custom_fields"` (data) | `POST {A}/del_custom_fields` → `admin/set/delCustomFields`；规则 `app\admin\controller\Setcontroller::delcustomfields`；[源行](../../data/route/admin.php#L225) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p052"></a>

## 客户实名认证 `/customer-authentication`

旧版证据：[P052](27-admin-built-page-evidence.md#p052)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户实名认证”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `44d25/526a0697` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `姓名 ($lang.name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `实名认证名称 ($lang.authenticat_real_name)` / `certifi_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `身份证号码 ($lang.ID_card_number)` / `idcard` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `认证方式 ($lang.authentication)` / `certype` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `认证类型 ($lang.authentication_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `状态/原因 ($lang.status_cause)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `提交时间 ($lang.submit_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-dialog` | `-` / `-` / `1==t.row.type?t.$lang.person_certified:2==t.row.type?t.$lang.enterprise_certified:t.$lang.individual_transfer_to_enterprise` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `44d25/526a0697` | `el-form-item` | `姓名：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `认证方式：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `e.title+"："` / `-` / `-` | `循环 t.row.custom_fields_log_arr; "text"===e.type` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `e.title+"："` / `-` / `-` | `循环 t.row.custom_fields_log_arr; "file"===e.type` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `企业名称：` / `-` / `-` | `2==t.row.type\|\|3==t.row.type` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `企业营业执照 ($lang.enterprise_business_license)` / `-` / `-` | `2==t.row.type\|\|3==t.row.type` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `真实姓名：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `证件类型：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `身份证类型：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `证件号码：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `文件名：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-form-item` | `其他信息：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `44d25/526a0697` | `el-dialog` | `-` / `-` / `t.$lang.history+"("+t.username+")"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `44d25/526a0697` | `el-table-column` | `实名认证名称 ($lang.authenticat_real_name)` / `certifi_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `身份证号码 ($lang.ID_card_number)` / `idcard` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `认证方式 ($lang.authentication)` / `certype` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `认证类型 ($lang.authentication_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `状态/原因 ($lang.status_cause)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `44d25/526a0697` | `el-table-column` | `提交时间 ($lang.submit_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `44d25/526a0697` | `帮助文档 ($lang.help_document)` | `on.click → t.openDoc` | `无提取条件` |
| `44d25/526a0697` | `搜索` | `on.click → t.searchClick` | `无提取条件` |
| `44d25/526a0697` | `e.row.username` | `on.click → function(a){return t.goToView(e.row)}` | `scopedSlots` |
| `44d25/526a0697` | `查看 ($lang.to_view)` | `on.click → function(a){return t.showCertifyModal(e.row)}` | `scopedSlots` |
| `44d25/526a0697` | `历史记录 ($lang.history)` | `on.click → function(a){return t.showHistoryModal(e.row)}` | `scopedSlots` |
| `44d25/526a0697` | `通过` | `on.click → function(a){return t.operating(e.row,1)}` | `scopedSlots; else(2!==e.row.status&&3!==e.row.status&&4!==e.row.status\|\|!e.row.is_newest)` |
| `44d25/526a0697` | `驳回` | `on.click → function(a){return t.turndown(e.row,2)}` | `scopedSlots; else(1!==e.row.status&&3!==e.row.status&&4!==e.row.status\|\|!e.row.is_newest)` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `526a0697` / `showHistoryModal` | `"get"` `"cerify_history_log"` (params) | `GET {A}/cerify_history_log` → `admin/user_manage/getCerifyHistoryLog`；规则 `app\admin\controller\UserManagecontroller::getcerifyhistorylog`；[源行](../../data/route/admin.php#L179) | 未提取；新设计明确成功后重读受影响对象 |
| `526a0697` / `getData` | `未显式指定` `"cerify_log_list"` (params) | `GET {A}/cerify_log_list` → `admin/user_manage/cerifyLogList`；规则 `app\admin\controller\UserManagecontroller::cerifyloglist`；[源行](../../data/route/admin.php#L178) | 未提取；新设计明确成功后重读受影响对象 |
| `526a0697` / `operating` | `"post"` `"certifi_status"` (data) | `POST {A}/certifi_status` → `admin/user_manage/certifiStatus`；规则 `app\admin\controller\UserManagecontroller::certifistatus`；[源行](../../data/route/admin.php#L184) | `getData` |
| `526a0697` / `turndown` | `"post"` `"certifi_status"` (data) | `POST {A}/certifi_status` → `admin/user_manage/certifiStatus`；规则 `app\admin\controller\UserManagecontroller::certifistatus`；[源行](../../data/route/admin.php#L184) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.row.uid}}`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t.uid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p053"></a>

## 客户跟进记录 `/add-records`

旧版证据：[P053](27-admin-built-page-evidence.md#p053)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“客户跟进记录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c663/10120036` | `el-form-item` | `选择认证类型： ($lang.select_authentication_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `选择认证方式： ($lang.select_authentication_method)` / `certifi_type` / `-` | `t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `a.title+"："` / `a.field` / `-` | `循环 t.customer; t.formData.type&&"text"==a.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `a.title+"："` / `a.field` / `-` | `循环 t.customer; t.formData.type&&"file"==a.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-upload` | `-` / `-` / `-` | `循环 t.customer; t.formData.type&&"file"==a.type` | 对应字段组；上传结果与业务保存分开 |
| `c663/10120036` | `el-form-item` | `真实姓名：` / `auth_real_name` / `-` | `t.formData.type&&1==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `证件类型：` / `cardType` / `-` | `t.formData.type&&1==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `身份证类型：` / `auth_card_type` / `-` | `t.formData.type&&1==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `企业名称：` / `company_name` / `-` | `t.formData.type&&2==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `公司营业执照：` / `company_organ_code` / `-` | `t.formData.type&&2==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `提交人姓名：` / `auth_real_name` / `-` | `t.formData.type&&2==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `证件号码：` / `idcard` / `-` | `t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `身份证正面：` / `-` / `-` | `t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-upload` | `-` / `-` / `-` | `t.formData.type` | 对应字段组；上传结果与业务保存分开 |
| `c663/10120036` | `el-form-item` | `身份证反面：` / `-` / `-` | `t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-upload` | `-` / `-` / `-` | `t.formData.type` | 对应字段组；上传结果与业务保存分开 |
| `c663/10120036` | `el-form-item` | `营业执照：` / `-` / `-` | `t.formData.type&&2==t.formData.type` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-upload` | `-` / `-` / `-` | `t.formData.type&&2==t.formData.type` | 对应字段组；上传结果与业务保存分开 |
| `c663/10120036` | `el-form-item` | `授权书：` / `-` / `-` | `t.formData.type&&2==t.formData.type&&1==t.config.certifi_business_is_author` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-upload` | `-` / `-` / `-` | `t.formData.type&&2==t.formData.type&&1==t.config.certifi_business_is_author` | 对应字段组；上传结果与业务保存分开 |
| `c663/10120036` | `el-form-item` | `-` / `-` / `-` | `t.formData.type&&2==t.formData.type&&1==t.config.certifi_business_is_author` | 分组表单；未知原值不置空 |
| `c663/10120036` | `el-form-item` | `认证状态：` / `status` / `-` | `t.formData.type` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c663/10120036` | `下载授权书模板 ($lang.download_authorization_template)` | `on.click → t.downloadAuth` | `t.formData.type&&2==t.formData.type&&1==t.config.certifi_business_is_author` |
| `c663/10120036` | `提交 ($lang.submit)` | `on.click → t.submit` | `无提取条件` |
| `c663/10120036` | `返回 ($lang.get_back)` | `on.click → t.back` | `无提取条件` |
| `c663/10120036` | `重置 ($lang.reset)` | `on.click → t.reset` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `10120036` / `getData` | `"get"` `"authorInfo"` (params) | `GET {A}/authorInfo` → `admin/user_manage/authorInfo`；规则 `app\admin\controller\UserManagecontroller::authorinfo`；[源行](../../data/route/admin.php#L214) | 未提取；新设计明确成功后重读受影响对象 |
| `10120036` / `submit` | `"post"` `"authorSubmit"` (data) | `POST {A}/authorSubmit` → `admin/user_manage/authorSubmit`；规则 `app\admin\controller\UserManagecontroller::authorsubmit`；[源行](../../data/route/admin.php#L215) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`back: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p055"></a>

## 销售管理 `/sales-management`

旧版证据：[P055](27-admin-built-page-evidence.md#p055)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“销售管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8de4/6f8689fc` | `el-tab-pane` | `商品提成 ($lang.commodity_commission)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `8de4/6f8689fc` | `el-table-column` | `组名称 ($lang.group_name)` / `group_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `新购提成比例 ($lang.new_purchase_commission_ratio)` / `bates` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `续费提成比例 ($lang.renewal_royalty_ratio)` / `bates` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `升降级提成比例 ($lang.promotion_and_demotion)` / `bates` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `包含续费计算 ($lang.include_renewal_calculation)` / `is_renew` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `计算升降级 ($lang.calculate_promotion_and_demotion)` / `updategrade` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8de4/6f8689fc` | `el-tab-pane` | `阶梯设置 ($lang.ladder_set)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `8de4/6f8689fc` | `el-table-column` | `营业额 ($lang.turnover)` / `turnover` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `额外提成奖励 ($lang.additional_commission_incentive)` / `bates` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8de4/6f8689fc` | `el-tab-pane` | `人员设置 ($lang.worker_set)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `8de4/6f8689fc` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `真实姓名 ($lang.real_user_name)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `邮箱 ($lang.email)` / `user_email` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `用户名 ($lang.user_name)` / `user_login` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `管理员分组 ($lang.admin_group)` / `role` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-table-column` | `是否销售 ($lang.is_sale)` / `is_sale` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-table-column` | `下单时可选 ($lang.optional_place_order)` / `sale_is_use` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-table-column` | `只能查看自己客户 ($lang.only_view_your_customer)` / `only_mine` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-table-column` | `未分配客户所有人可见 ($lang.unassign_customer_visible)` / `cat_ownerless` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-table-column` | `查看所有人业绩 ($lang.look_performance)` / `all_sale` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-table-column` | `仅自己客户工单提醒 ($lang.only_own_work_reminder)` / `only_oneself_notice` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8de4/6f8689fc` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-tab-pane` | `设置 ($lang.set_up)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `8de4/6f8689fc` | `el-form-item` | `下单销售分配 ($lang.order_sale_distribution)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-form-item` | `注册销售分配 ($lang.register_sale_allocation)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-form-item` | `自动分配逻辑 ($lang.automatic_allocation_logic)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8de4/6f8689fc` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8de4/6f8689fc` | `添加分组 ($lang.add_a_group)` | `on.click → e.addGroup` | `无提取条件` |
| `8de4/6f8689fc` | `编辑` | `on.click → function(t){return e.editRow(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `删除` | `on.click → function(t){return e.deleteRow(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `添加阶梯 ($lang.add_ladder)` | `on.click → e.addLadder` | `无提取条件` |
| `8de4/6f8689fc` | `编辑` | `on.click → function(t){return e.editRow02(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `删除` | `on.click → function(t){return e.deleteRow02(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSettings(r)}` | `scopedSlots` |
| `8de4/6f8689fc` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `6f8689fc` / `getFourTabsData` | `未显式指定` `"sale/get_sale_enble"` (无显式 data/params) | `ANY {A}/sale/get_sale_enble` → `admin/sale/getSaleEnble`；规则 `app\admin\controller\Salecontroller::getsaleenble`；[源行](../../data/route/admin.php#L696) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `submitForm` | `"post"` `"sale/sale_enble"` (data) | `ANY {A}/sale/sale_enble` → `admin/sale/saleEnblePost`；规则 `app\admin\controller\Salecontroller::saleenblepost`；[源行](../../data/route/admin.php#L697) | `getFourTabsData` |
| `6f8689fc` / `getData` | `未显式指定` `"salegroup"` (params) | `GET {A}/salegroup` → `admin/sale/groupList`；规则 `app\admin\controller\Salecontroller::grouplist`；[源行](../../data/route/admin.php#L677) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `getLadder` | `未显式指定` `"saleladder"` (params) | `GET {A}/saleladder` → `admin/sale/ladderList`；规则 `app\admin\controller\Salecontroller::ladderlist`；[源行](../../data/route/admin.php#L685) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `getSetting` | `未显式指定` `"sale/adminlist"` (params) | `GET {A}/sale/adminlist` → `admin/sale/adminList`；规则 `app\admin\controller\Salecontroller::adminlist`；[源行](../../data/route/admin.php#L694) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `handleSizeChange` | `未显式指定` `"salegroup"` (params) | `GET {A}/salegroup` → `admin/sale/groupList`；规则 `app\admin\controller\Salecontroller::grouplist`；[源行](../../data/route/admin.php#L677) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `currentChange` | `未显式指定` `"salegroup"` (params) | `GET {A}/salegroup` → `admin/sale/groupList`；规则 `app\admin\controller\Salecontroller::grouplist`；[源行](../../data/route/admin.php#L677) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `handleSizeChange02` | `未显式指定` `"saleladder"` (params) | `GET {A}/saleladder` → `admin/sale/ladderList`；规则 `app\admin\controller\Salecontroller::ladderlist`；[源行](../../data/route/admin.php#L685) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `currentChange02` | `未显式指定` `"saleladder"` (params) | `GET {A}/saleladder` → `admin/sale/ladderList`；规则 `app\admin\controller\Salecontroller::ladderlist`；[源行](../../data/route/admin.php#L685) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `handleSizeChange03` | `未显式指定` `"sale/adminlist"` (params) | `GET {A}/sale/adminlist` → `admin/sale/adminList`；规则 `app\admin\controller\Salecontroller::adminlist`；[源行](../../data/route/admin.php#L694) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `currentChange03` | `未显式指定` `"sale/adminlist"` (params) | `GET {A}/sale/adminlist` → `admin/sale/adminList`；规则 `app\admin\controller\Salecontroller::adminlist`；[源行](../../data/route/admin.php#L694) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `editRow` | `未显式指定` `"sale/edit_salegrouppage"` (params) | `GET {A}/sale/edit_salegrouppage` → `admin/sale/editSalegroupPage`；规则 `app\admin\controller\Salecontroller::editsalegrouppage`；[源行](../../data/route/admin.php#L680) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `deleteRow` | `未显式指定` `"sale/del_salegroup"` (params) | `GET {A}/sale/del_salegroup` → `admin/sale/delSalegroup`；规则 `app\admin\controller\Salecontroller::delsalegroup`；[源行](../../data/route/admin.php#L682) | `getData` |
| `6f8689fc` / `editRow02` | `未显式指定` `"sale/edit_saleladderpage"` (params) | `GET {A}/sale/edit_saleladderpage` → `admin/sale/editSaleLadderPage`；规则 `app\admin\controller\Salecontroller::editsaleladderpage`；[源行](../../data/route/admin.php#L687) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `deleteRow02` | `未显式指定` `"sale/del_saleladder"` (params) | `GET {A}/sale/del_saleladder` → `admin/sale/delSaleLadder`；规则 `app\admin\controller\Salecontroller::delsaleladder`；[源行](../../data/route/admin.php#L689) | `getLadder` |
| `6f8689fc` / `addGroup` | `未显式指定` `"sale/add_salegrouppage"` (无显式 data/params) | `GET {A}/sale/add_salegrouppage` → `admin/sale/addSalegroupPage`；规则 `app\admin\controller\Salecontroller::addsalegrouppage`；[源行](../../data/route/admin.php#L678) | 未提取；新设计明确成功后重读受影响对象 |
| `6f8689fc` / `handelConfirm` | `"post"` `"sale/edit_salegroup"` (data) | `ANY {A}/sale/edit_salegroup` → `admin/sale/editSalegroup`；规则 `app\admin\controller\Salecontroller::editsalegroup`；[源行](../../data/route/admin.php#L681) | `getData`、`getLadder`、`onClose` |
| `6f8689fc` / `handelConfirm` | `"post"` `"sale/add_salegroup"` (data) | `ANY {A}/sale/add_salegroup` → `admin/sale/addSalegroup`；规则 `app\admin\controller\Salecontroller::addsalegroup`；[源行](../../data/route/admin.php#L679) | `getData`、`getLadder`、`onClose` |
| `6f8689fc` / `handelLadderConfirm` | `"post"` `"sale/add_saleladder"` (data) | `POST {A}/sale/add_saleladder` → `admin/sale/addSaleLadder`；规则 `app\admin\controller\Salecontroller::addsaleladder`；[源行](../../data/route/admin.php#L686) | `getLadder`、`onLadderClose` |
| `6f8689fc` / `handelLadderConfirm` | `"post"` `"sale/edit_saleladder"` (data) | `POST {A}/sale/edit_saleladder` → `admin/sale/editSaleLadder`；规则 `app\admin\controller\Salecontroller::editsaleladder`；[源行](../../data/route/admin.php#L688) | `getLadder`、`onLadderClose` |
| `6f8689fc` / `changeSettings` | `"post"` `"sale/edit_adminlist"` (data) | `ANY {A}/sale/edit_adminlist` → `admin/sale/editAdminList`；规则 `app\admin\controller\Salecontroller::editadminlist`；[源行](../../data/route/admin.php#L695) | `getSetting` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/admin-management"}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p056"></a>

## 销售统计 `/sales-statistics`

旧版证据：[P056](27-admin-built-page-evidence.md#p056)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：围绕“销售统计”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `27cf/7445c629` | `el-table-column` | `客户 ($lang.client)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `产品 ($lang.product)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `账单编号 ($lang.bill_number)` / `invoice_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `账单支付时间 ($lang.Bill_time)` / `pay_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `提成 ($lang.commission)` / `batesamount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `27cf/7445c629` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `27cf/7445c629` | `帮助文档 ($lang.help_document)` | `on.click → t.openDoc` | `无提取条件` |
| `27cf/7445c629` | `搜索 ($lang.search)` | `on.click → t.topSearch` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `7445c629` / `getTimetype` | `未显式指定` `"sale/get_timetype"` (无显式 data/params) | `ANY {A}/sale/get_timetype` → `admin/sale/getTimetype`；规则 `app\admin\controller\Salecontroller::gettimetype`；[源行](../../data/route/admin.php#L684) | 未提取；新设计明确成功后重读受影响对象 |
| `7445c629` / `getTopData` | `未显式指定` `"sale/sale_statistics"` (params) | `GET {A}/sale/sale_statistics` → `admin/sale/saleStatistics`；规则 `app\admin\controller\Salecontroller::salestatistics`；[源行](../../data/route/admin.php#L690) | `changeText` |
| `7445c629` / `getCharts` | `未显式指定` `"sale/sale_statistics"` (params) | `GET {A}/sale/sale_statistics` → `admin/sale/saleStatistics`；规则 `app\admin\controller\Salecontroller::salestatistics`；[源行](../../data/route/admin.php#L690) | `chartFunc` |
| `7445c629` / `getTableData` | `"post"` `"sale/sale_records"` (data) | `ANY {A}/sale/sale_records` → `admin/sale/saleRecordsNew`；规则 `app\admin\controller\Salecontroller::salerecordsnew`；[源行](../../data/route/admin.php#L691) | `changeText` |
| `7445c629` / `getUser` | `未显式指定` `"sale/sale_users"` (无显式 data/params) | `GET {A}/sale/sale_users` → `admin/sale/saleUsers`；规则 `app\admin\controller\Salecontroller::saleusers`；[源行](../../data/route/admin.php#L692) | 未提取；新设计明确成功后重读受影响对象 |
| `7445c629` / `changeSearch` | `"post"` `"sale/sale_records"` (data) | `ANY {A}/sale/sale_records` → `admin/sale/saleRecordsNew`；规则 `app\admin\controller\Salecontroller::salerecordsnew`；[源行](../../data/route/admin.php#L691) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/sales-management"}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p057"></a>

## 客户推介计划 `/customer-promotionplan`

旧版证据：[P057](27-admin-built-page-evidence.md#p057)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户推介计划”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `07e9/058aae8e` | `el-tab-pane` | `推介计划 ($lang.promotion_plan)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `07e9/058aae8e` | `el-form-item` | `客户名 ($lang.client_name)` / `id` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-form-item` | `可提现佣金 ($lang.withdrawable_commission)` / `balance` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-form-item` | `访问量 ($lang.traffic)` / `visitors` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-form-item` | `已提现佣金 ($lang.have_withdrawal_commission)` / `withdrawn` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-form-item` | `注册数量 ($lang.register_num)` / `registcount` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `07e9/058aae8e` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `姓名(公司名) ($lang.name_company)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `访问数量 ($lang.access_number)` / `visitors` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `注册数量 ($lang.register_num)` / `registcount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `订购数量 ($lang.ordere_number)` / `payamount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `总佣金 ($lang.total_commission)` / `sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `07e9/058aae8e` | `el-table-column` | `已提现佣金 ($lang.have_withdrawal_commission)` / `withdrawn` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `07e9/058aae8e` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `07e9/058aae8e` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `e.showSearchArea` |
| `07e9/058aae8e` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `07e9/058aae8e` | `e._s(r.username)+e._s(r.companyname?"("+r.companyname+")":"")+" "` | `on.click → function(t){return e.goUserInner(r.uid)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `058aae8e` / `getpayType` | `"get"` `"aff/gateway_list"` (无显式 data/params) | `ANY {A}/aff/gateway_list` → `admin/affiliate/gatewaylist`；规则 `app\admin\controller\Affiliatecontroller::gatewaylist`；[源行](../../data/route/admin.php#L711) | 未提取；新设计明确成功后重读受影响对象 |
| `058aae8e` / `getData` | `未显式指定` `"aff"` (params) | `GET {A}/aff` → `admin/affiliate/index`；规则 `app\admin\controller\Affiliatecontroller::index`；[源行](../../data/route/admin.php#L699) | 未提取；新设计明确成功后重读受影响对象 |
| `058aae8e` / `getLadder` | `"post"` `"aff/affiwithdraw_record"` (data) | `ANY {A}/aff/affiwithdraw_record` → `admin/affiliate/affiwithdrawrecord`；规则 `app\admin\controller\Affiliatecontroller::affiwithdrawrecord`；[源行](../../data/route/admin.php#L709) | 未提取；新设计明确成功后重读受影响对象 |
| `058aae8e` / `handelConfirm` | `"post"` `"aff/affiwithdrawsh"` (data) | `ANY {A}/aff/affiwithdrawsh` → `admin/affiliate/affiwithdrawsh`；规则 `app\admin\controller\Affiliatecontroller::affiwithdrawsh`；[源行](../../data/route/admin.php#L710) | `getLadder`、`onLadderClose` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goUserInner: this.$router.push({name:"promotion_plan",query:{id:e}})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/promotion_plan",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p060"></a>

## 客户资源池 `/customer-resources`

旧版证据：[P060](27-admin-built-page-evidence.md#p060)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户资源池”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3f74/5f51ab36` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-table-column` | `收入 ($lang.income)` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-table-column` | `余额 ($lang.remain_sum)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-table-column` | `创建时间 ($lang.create_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-table-column` | `添加销售 ($lang.add_sale)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3f74/5f51ab36` | `el-dialog` | `-` / `-` / `添加销售 ($lang.add_sale)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `3f74/5f51ab36` | `el-form-item` | `销售代表 ($lang.sale_represent)` / `sale_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3f74/5f51ab36` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `3f74/5f51ab36` | `添加 ($lang.add)` | `on.click → function(t){return e.addSale(r)}` | `scopedSlots` |
| `3f74/5f51ab36` | `确定 ($lang.confirm)` | `on.click → e.addSaleSubmit` | `无提取条件` |
| `3f74/5f51ab36` | `取消 ($lang.cancel)` | `on.click → function(t){e.addSaleVis=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5f51ab36` / `getData` | `未显式指定` `"client_list_resource"` (params) | `GET {A}/client_list_resource` → `admin/user_manage/clientListRe`；规则 `app\admin\controller\UserManagecontroller::clientlistre`；[源行](../../data/route/admin.php#L173) | 未提取；新设计明确成功后重读受影响对象 |
| `5f51ab36` / `getSaleList` | `未显式指定` `"common/sale_list"` (无显式 data/params) | `GET {A}/common/sale_list` → `admin/common/saleList`；规则 `app\admin\controller\Commoncontroller::salelist`；[源行](../../data/route/admin.php#L103) | 未提取；新设计明确成功后重读受影响对象 |
| `5f51ab36` / `addSaleSubmit` | `"post"` `"bind_sale"` (data) | `ANY {A}/bind_sale` → `admin/user_manage/hostBindSale`；规则 `app\admin\controller\UserManagecontroller::hostbindsale`；[源行](../../data/route/admin.php#L174) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.id}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p061"></a>

## 客户等级 `/customer-level`

旧版证据：[P061](27-admin-built-page-evidence.md#p061)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户等级”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c184/247c313f` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `c184/1ec9f9ec` | `el-table-column` | `客户等级 ($lang.class_name)` / `level_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `收入 ($lang.income)` / `expense` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `购买商品数量 ($lang.pay_good_num)` / `buy_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `累计登录次数 ($lang.accumulated_login_time)` / `login_times` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `最近登录次数 ($lang.recent_Login)` / `login_times` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `续费次数 ($lang.renewal_number)` / `renew_times` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `最近续费次数 ($lang.recent_renewal_time)` / `last_renew_times` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c184/1ec9f9ec` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c184/1ec9f9ec` | `添加客户等级 ($lang.add_class_name)` | `on.click → e.openDialog` | `无提取条件` |
| `c184/1ec9f9ec` | `编辑` | `on.click → function(t){return e.openDialog("edit",n.id)}` | `scopedSlots` |
| `c184/1ec9f9ec` | `删除` | `on.click → function(t){return e.delRow(n.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `247c313f` / `onOpen` | `未显式指定` `"user_level/levelpage"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `247c313f` / `handelConfirm` | `"post"` `"user_level/level"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `close` |
| `1ec9f9ec` / `getUserLevel` | `未显式指定` `"user_level/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1ec9f9ec` / `delRow` | `"delete"` `"user_level/level"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getUserLevel` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p131"></a>

## 推介计划设置 `/promotion_plan`

旧版证据：[P131](27-admin-built-page-evidence.md#p131)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“推介计划设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9902/2319d923` | `el-form-item` | `推介计划 ($lang.promotion_plan)` / `affiliate_enabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `激活赠送金额 ($lang.activation_gift)` / `affiliate_bonusde_posit` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `推介返利类型 ($lang.promotion_rebate_type)` / `affiliate_type` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `1===e.formData.affiliate_type?e.$lang.recommend_scheme_amount:e.$lang.referral_plan_proportion` / `affiliate_bates` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `应邀返利 ($lang.invited_rebate)` / `affiliate_invited` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-switch` | `-` / `-` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `应邀返利类型 ($lang.invited_rebate_type)` / `affiliate_invited_type` / `-` | `e.isPromotionChecked; 1==e.formData.affiliate_invited` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `应邀返利金额 ($lang.invited_rebate_amount)` / `affiliate_invited_money` / `-` | `e.isPromotionChecked; 1==e.formData.affiliate_invited` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `请输入推荐链接cookie有效期 ($lang.enter_cookie)` / `affiliate_cookie` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `提现最低金额 ($lang.minimum_withdrawal_amount)` / `affiliate_withdraw` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `提现必须实名 ($lang.withdrawal_must_real_name)` / `affiliate_is_authentication` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-switch` | `-` / `-` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `推荐佣金延迟天数 ($lang.referral_commission_delay_day)` / `affiliate_delay_commission` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `是否开启二次订购 ($lang.whether_to_initiate_second_order)` / `affiliate_reorder_type` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-switch` | `-` / `-` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `二次订单比例类型 ($lang.second_order_proportion_type)` / `affiliate_reorder_type` / `-` | `e.isPromotionChecked; e.isReorderChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `1===e.formData.affiliate_reorder_type?e.$lang.amount_second_order:e.$lang.proportion_of_second_order` / `affiliate_reorder` / `-` | `e.isPromotionChecked; e.isReorderChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `是否开启续费 ($lang.whether_to_open_renewal)` / `affiliate_is_renew` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-switch` | `-` / `-` / `-` | `e.isPromotionChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `续费比例比例类型 ($lang.renewal_proportion_type)` / `affiliate_renew_type` / `-` | `e.isPromotionChecked; e.isRenewChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `1===e.formData.affiliate_renew_type?e.$lang.renewal_amount:e.$lang.proportion_of_renewal` / `affiliate_renew` / `-` | `e.isPromotionChecked; e.isRenewChecked` | 分组表单；未知原值不置空 |
| `9902/2319d923` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9902/2319d923` | `图标/动态文案，回查原证据` | `on.change → e.PromotionChecked` | `无提取条件` |
| `9902/2319d923` | `图标/动态文案，回查原证据` | `on.change → e.AuthenticationChecked` | `e.isPromotionChecked` |
| `9902/2319d923` | `图标/动态文案，回查原证据` | `on.change → e.ReorderChecked` | `e.isPromotionChecked` |
| `9902/2319d923` | `图标/动态文案，回查原证据` | `on.change → e.RenewChecked` | `e.isPromotionChecked` |
| `9902/2319d923` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `9902/2319d923` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2319d923` / `getData` | `未显式指定` `"config_general/affiliate"` (无显式 data/params) | `GET {A}/config_general/affiliate` → `admin/config_general/getAffiliate`；规则 `app\admin\controller\ConfigGeneralcontroller::getaffiliate`；[源行](../../data/route/admin.php#L303) | `isStratUse` |
| `2319d923` / `getLadder` | `未显式指定` `"affladder"` (params) | `GET {A}/affladder` → `admin/config_general/ladderList`；规则 `app\admin\controller\ConfigGeneralcontroller::ladderlist`；[源行](../../data/route/admin.php#L305) | 未提取；新设计明确成功后重读受影响对象 |
| `2319d923` / `handleSizeChange02` | `未显式指定` `"affladder"` (params) | `GET {A}/affladder` → `admin/config_general/ladderList`；规则 `app\admin\controller\ConfigGeneralcontroller::ladderlist`；[源行](../../data/route/admin.php#L305) | 未提取；新设计明确成功后重读受影响对象 |
| `2319d923` / `currentChange02` | `未显式指定` `"affladder"` (params) | `GET {A}/affladder` → `admin/config_general/ladderList`；规则 `app\admin\controller\ConfigGeneralcontroller::ladderlist`；[源行](../../data/route/admin.php#L305) | 未提取；新设计明确成功后重读受影响对象 |
| `2319d923` / `editRow02` | `未显式指定` `"aff/edit_affladderpage"` (params) | `GET {A}/aff/edit_affladderpage` → `admin/config_general/editAffLadderPage`；规则 `app\admin\controller\ConfigGeneralcontroller::editaffladderpage`；[源行](../../data/route/admin.php#L307) | 未提取；新设计明确成功后重读受影响对象 |
| `2319d923` / `deleteRow02` | `未显式指定` `"aff/del_affladder"` (params) | `GET {A}/aff/del_affladder` → `admin/config_general/delAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::delaffladder`；[源行](../../data/route/admin.php#L309) | `getLadder` |
| `2319d923` / `submitForm` | `"post"` `"config_general/affiliate"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `2319d923` / `handelLadderConfirm` | `"post"` `"aff/add_affladder"` (params) | `ANY {A}/aff/add_affladder` → `admin/config_general/addAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::addaffladder`；[源行](../../data/route/admin.php#L306) | `getLadder`、`onLadderClose` |
| `2319d923` / `handelLadderConfirm` | `"post"` `"aff/edit_affladder"` (params) | `ANY {A}/aff/edit_affladder` → `admin/config_general/editAffLadder`；规则 `app\admin\controller\ConfigGeneralcontroller::editaffladder`；[源行](../../data/route/admin.php#L308) | `getLadder`、`onLadderClose` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/authentication-setting"}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p133"></a>

## 实名认证设置 `/authentication-setting`

旧版证据：[P133](27-admin-built-page-evidence.md#p133)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“实名认证设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9afb/383b06be` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-table-column` | `接口名称 ($lang.interface_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-table-column` | `类型 ($lang.type)` / `certifi_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-table-column` | `开发者 ($lang.developer)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9afb/383b06be` | `el-dialog` | `-` / `-` / `t.plInfo.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9afb/383b06be` | `el-form-item` | `e.title` / `""` / `-` | `循环 t.plInfo.config` | 分组表单；未知原值不置空 |
| `9afb/383b06be` | `el-dialog` | `-` / `-` / `t.pltitle` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9afb/0c380670` | `el-tab-pane` | `基础设置 ($lang.basic)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `9afb/0c380670` | `el-form-item` | `实名认证 ($lang.name_authentication)` / `certifi_open` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `高级设置 ($lang.advanced_setting)` / `certifi_business_btn` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `自动更新姓名 ($lang.auto_update_name)` / `certifi_realname` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `认证手机号必须与绑定一致 ($lang.phone_num_binding_must)` / `certifi_isbindphone` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `人工审核通过自动发送短息 ($lang.send_message_automatically_after_audit)` / `artificial_auto_send_msg` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `未认证暂停产品 ($lang.no_real_name_down_product)` / `certifi_is_stop` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `暂停期限 ($lang.suspension_period)` / `certifi_stop_day` / `-` | `"1"===t.formData.certifi_is_stop&&"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `上传认证文件 ($lang.need_card_id)` / `certifi_is_upload` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `企业认证高级设置 ($lang.enterprise_certification_advanced_settings)` / `certifi_business_open` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `营业执照上传 ($lang.business_license_upload)` / `certifi_business_is_upload` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `授权书上传 ($lang.power_of_attorney_upload)` / `certifi_business_is_author` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-switch` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; t.formData.certifi_business_author_path` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-form-item` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; else(t.formData.certifi_business_author_path)` | 分组表单；未知原值不置空 |
| `9afb/0c380670` | `el-upload` | `-` / `-` / `-` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; else(t.formData.certifi_business_author_path)` | 对应字段组；上传结果与业务保存分开 |
| `9afb/0c380670` | `el-tab-pane` | `接口设置 ($lang.interface_settings)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9afb/383b06be` | `申请接口` | `on.click → function(e){return t.applyApi(i)}` | `scopedSlots; 3!==i.status` |
| `9afb/383b06be` | `启用 ($lang.start_using)` | `on.click → function(e){return t.plToggleHandleClick(i.id,"enable")}` | `scopedSlots; 0===i.status` |
| `9afb/383b06be` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.plToggleHandleClick(i.id,"disable")}` | `scopedSlots; 1===i.status` |
| `9afb/383b06be` | `配置` | `on.click → function(e){return t.plSettingHandleClick(i.id)}` | `scopedSlots; 3!==i.status` |
| `9afb/383b06be` | `安装` | `on.click → function(e){return t.plInstallHandleClick(i.name)}` | `scopedSlots; 3===i.status` |
| `9afb/383b06be` | `卸载` | `on.click → function(e){return t.plUnInstallHandleClick(i.id)}` | `scopedSlots; 3!==i.status` |
| `9afb/383b06be` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `9afb/383b06be` | `保存更改 ($lang.save_the_changes)` | `on.click → t.saveHandleClick` | `无提取条件` |
| `9afb/383b06be` | `取消 ($lang.cancel)` | `on.click → function(e){t.uninstallDialogVisible=!1}` | `无提取条件` |
| `9afb/383b06be` | `确定 ($lang.confirm)` | `on.click → t.sure` | `无提取条件` |
| `9afb/0c380670` | `获取更多实名接口` | `on.click → t.jumpUrl` | `"second"===t.activeName` |
| `9afb/0c380670` | `图标/动态文案，回查原证据` | `on.change → function(e){return t.switchChange("artificial_auto_send_msg")}` | `"1"===t.formData.certifi_open` |
| `9afb/0c380670` | `图标/动态文案，回查原证据` | `on.change → function(e){return t.switchChange("certifi_business_open")}` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_btn` |
| `9afb/0c380670` | `图标/动态文案，回查原证据` | `on.change → function(e){return t.switchChange("certifi_business_is_upload")}` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` |
| `9afb/0c380670` | `图标/动态文案，回查原证据` | `on.change → function(e){return t.switchChange("certifi_business_is_author")}` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&"1"===t.formData.certifi_business_btn` |
| `9afb/0c380670` | `查看 ($lang.to_view)` | `on.click → t.viewFile` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; t.formData.certifi_business_author_path` |
| `9afb/0c380670` | `下载 ($lang.download)` | `on.click → t.downloadFile` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; t.formData.certifi_business_author_path` |
| `9afb/0c380670` | `删除 ($lang.delete)` | `on.click → t.deleteFile` | `"1"===t.formData.certifi_open&&"1"===t.formData.certifi_business_open&&1==t.edition&&"1"===t.formData.certifi_business_btn; t.formData.certifi_business_author_path` |
| `9afb/0c380670` | `提交 ($lang.submit)` | `on.click → t.submitForm` | `无提取条件` |
| `9afb/0c380670` | `重置 ($lang.reset)` | `on.click → t.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `383b06be` / `getData` | `未显式指定` `"pl_index/".concat(t,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `383b06be` / `plInstallHandleClick` | `"post"` `"pl_install"` (data) | `POST {A}/pl_install` → `admin/plugin/plInstall`；规则 `app\admin\controller\Plugincontroller::plinstall`；[源行](../../data/route/admin.php#L159) | `getData` |
| `383b06be` / `plUnInstallApi` | `"post"` `"pl_uninstall"` (data) | `POST {A}/pl_uninstall` → `admin/plugin/plUninstall`；规则 `app\admin\controller\Plugincontroller::pluninstall`；[源行](../../data/route/admin.php#L160) | `getData` |
| `383b06be` / `plToggleHandleClick` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `383b06be` / `plToggleApi` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `383b06be` / `plSettingHandleClick` | `未显式指定` `"pl_setting/certification/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `383b06be` / `plCopyHandleClick` | `"post"` `"pl_copy"` (data) | `POST {A}/pl_copy` → `admin/plugin/plCopy`；规则 `app\admin\controller\Plugincontroller::plcopy`；[源行](../../data/route/admin.php#L158) | `getData` |
| `383b06be` / `saveHandleClick` | `"post"` `"pl_setting_post"` (data) | `POST {A}/pl_setting_post` → `admin/plugin/plSettingPost`；规则 `app\admin\controller\Plugincontroller::plsettingpost`；[源行](../../data/route/admin.php#L163) | `getData` |
| `383b06be` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `383b06be` / `rowDrag` | `"post"` `"pl_sort/".concat(t.moduleName,"/")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `0c380670` / `deleteFile` | `"get"` `"config_certifi/authorDel"` (params) | `GET {A}/config_certifi/authorDel` → `admin/config_certifi/authorDel`；规则 `app\admin\controller\ConfigCertificontroller::authordel`；[源行](../../data/route/admin.php#L355) | `getData` |
| `0c380670` / `getType` | `未显式指定` `"certifi_types"` (无显式 data/params) | `GET {A}/certifi_types` → `admin/config_certifi/types`；规则 `app\admin\controller\ConfigCertificontroller::types`；[源行](../../data/route/admin.php#L348) | 未提取；新设计明确成功后重读受影响对象 |
| `0c380670` / `getThree` | `未显式指定` `"certifi_three_type"` (无显式 data/params) | `GET {A}/certifi_three_type` → `admin/config_certifi/alipay_three_type`；规则 `app\admin\controller\ConfigCertificontroller::alipay_three_type`；[源行](../../data/route/admin.php#L346) | 未提取；新设计明确成功后重读受影响对象 |
| `0c380670` / `getData` | `未显式指定` `"config_certifi/setting"` (无显式 data/params) | `GET {A}/config_certifi/setting` → `admin/config_certifi/setting`；规则 `app\admin\controller\ConfigCertificontroller::setting`；[源行](../../data/route/admin.php#L350)<br>`POST {A}/config_certifi/setting` → `admin/config_certifi/settingPost`；规则 `app\admin\controller\ConfigCertificontroller::settingpost`；[源行](../../data/route/admin.php#L351) | 未提取；新设计明确成功后重读受影响对象 |
| `0c380670` / `submitForm` | `"post"` `"config_certifi/setting"` (data) | `POST {A}/config_certifi/setting` → `admin/config_certifi/settingPost`；规则 `app\admin\controller\ConfigCertificontroller::settingpost`；[源行](../../data/route/admin.php#L351) | `getData` |
| `0c380670` / `submitSettingForm` | `"put"` `"certifi_alipay"` (data) | `PUT {A}/certifi_alipay` → `admin/config_certifi/update`；规则 `app\admin\controller\ConfigCertificontroller::update`；[源行](../../data/route/admin.php#L349) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p185"></a>

## 客户资料编辑兼容入口 `/edit-person`

旧版证据：[P185](27-admin-built-page-evidence.md#p185)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“客户资料编辑兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `92cc/3fa1cf92` | `el-form-item` | `用户名 ($lang.user_name)` / `user_login` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `邮箱 ($lang.email)` / `user_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `语言 ($lang.language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `原密码 ($lang.original_password)` / `original_pass` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `新密码 ($lang.new_password)` / `user_pass` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `确认密码 ($lang.confirm_password)` / `re_user_pass` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `92cc/3fa1cf92` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `92cc/3fa1cf92` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `92cc/3fa1cf92` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3fa1cf92` / `getAdminData` | `未显式指定` `"user/edit_self_info_page"` (无显式 data/params) | `GET {A}/user/edit_self_info_page` → `admin/user/editSelfInfoPage`；规则 `app\admin\controller\Usercontroller::editselfinfopage`；[源行](../../data/route/admin.php#L151) | 未提取；新设计明确成功后重读受影响对象 |
| `3fa1cf92` / `editAdminDataApi` | `"post"` `"user/edit_self_info"` (data) | `POST {A}/user/edit_self_info` → `admin/user/editSelfInfo`；规则 `app\admin\controller\Usercontroller::editselfinfo`；[源行](../../data/route/admin.php#L152) | 未提取；新设计明确成功后重读受影响对象 |
| `3fa1cf92` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p186"></a>

## 客户开发者管理 `/customer-developer`

旧版证据：[P186](27-admin-built-page-evidence.md#p186)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户开发者管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0426/0928b04a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `昵称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `手机号` / `phonenumber` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `认证信息` / `certifi_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `可售应用` / `sell_app` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `销量` / `sell.count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `收入` / `sell.total` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `创建时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `状态` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0426/0928b04a` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0426/0928b04a` | `图标/动态文案，回查原证据` | `on.click → e.getData` | `无提取条件` |
| `0426/0928b04a` | `通过` | `on.click → function(t){return e.optHandleClick(n,"Active")}` | `scopedSlots; "Pending"===n.status` |
| `0426/0928b04a` | `驳回` | `on.click → function(t){return e.optHandleClick(n,"Cancelled")}` | `scopedSlots; "Pending"===n.status` |
| `0426/0928b04a` | `停用` | `on.click → function(t){return e.optHandleClick(n,"Suspended")}` | `scopedSlots; "Active"===n.status` |
| `0426/0928b04a` | `启用` | `on.click → function(t){return e.optHandleClick(n,"Active")}` | `scopedSlots; "Suspended"===n.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0928b04a` / `getData` | `未显式指定` `"developer/developerlist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0928b04a` / `optApi` | `"post"` `"developer/checkdeveloper"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `0928b04a` / `optApiReason` | `"post"` `"developer/checkdeveloper"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/developer",query:{id:n.uid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
