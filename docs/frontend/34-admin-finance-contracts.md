# 财务、信用额、合同与报表逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [余额明细兼容入口](#p007) `/balance-details1` | `log` | 路由 factory 指向模块 |
| [客户提现审核](#p058) `/customer-withdrawal` | `list` | 路由 factory 指向模块 |
| [交易流水](#p067) `/business-statement` | `list` | 路由 factory 指向模块 |
| [账单管理](#p068) `/bill-management` | `list` | 路由 factory 指向模块 |
| [账单详情](#p069) `/bill-detail` | `detail` | 路由 factory 指向模块 |
| [发票设置](#p119) `/voucher-setting` | `form` | 路由 factory 指向模块 |
| [发票审核](#p120) `/invoice-audit` | `list` | 路由 factory 指向模块 |
| [货币设置](#p126) `/currency-settings` | `list` | 路由 factory 指向模块 |
| [支付接口](#p134) `/payment-interface` | `list` | 路由 factory 指向模块 |
| [优惠码](#p135) `/promo-code` | `list` | 路由 factory 指向模块 |
| [优惠码编辑](#p136) `/promo-code-add` | `form` | 路由 factory 指向模块 |
| [年度收入统计](#p179) `/annual-statistics` | `report` | 路由 factory 指向模块 |
| [新客户统计](#p182) `/new-customer` | `report` | 路由 factory 指向模块 |
| [产品收入统计](#p183) `/product-revenue` | `report` | 路由 factory 指向模块 |
| [收入排名](#p184) `/revenue-ranking` | `report` | 路由 factory 指向模块 |
| [信用额管理](#p199) `/credit-management` | `list` | 路由 factory 指向模块 |
| [信用额设置](#p200) `/credit-setting` | `form` | 路由 factory 指向模块 |
| [合同审核](#p213) `/contracts_audit` | `list` | 路由 factory 指向模块 |
| [合同设置](#p214) `/contracts_setting` | `form` | 路由 factory 指向模块 |
| [合同编辑](#p215) `/add_contract` | `form` | 路由 factory 指向模块 |

<a id="p007"></a>

## 余额明细兼容入口 `/balance-details1`

旧版证据：[P007](27-admin-built-page-evidence.md#p007)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“余额明细兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `65e9/1767fe89` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `备注 ($lang.remark)` / `notes` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `余额 ($lang.remain_sum)` / `detailed` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `65e9/1767fe89` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `65e9/1767fe89` | `el-dialog` | `-` / `-` / `创建充值账单 ($lang.create_bill)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `65e9/1767fe89` | `充值 ($lang.recharge)` | `on.click → function(t){e.czDialogVisible=!0}` | `无提取条件` |
| `65e9/1767fe89` | `强制修改余额 ($lang.forced_modification_balance)` | `on.click → e.forceModify` | `无提取条件` |
| `65e9/1767fe89` | `编辑` | `on.click → function(n){return e.editBalance(t.row)}` | `scopedSlots` |
| `65e9/1767fe89` | `删除 ($lang.delete)` | `on.click → function(n){return e.deleteBalance(t.row)}` | `scopedSlots` |
| `65e9/1767fe89` | `取消 ($lang.cancel)` | `on.click → function(t){e.czDialogVisible=!1}` | `无提取条件` |
| `65e9/1767fe89` | `确定 ($lang.confirm)` | `on.click → e.creatBillHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1767fe89` / `getList` | `未显式指定` `"credit"` (params) | `RESOURCE {A}/credit` → `admin/Credit`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L568) | 未提取；新设计明确成功后重读受影响对象 |
| `1767fe89` / `markPaidHandleClick` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | `getList` |
| `1767fe89` / `creatBillHandleClick` | `"post"` `"add_recharge_invoice/"+e.uid` (data) | `POST {A}/add_recharge_invoice/:uid` → `admin/user_manage/addRechargeInvoice`；规则 `app\admin\controller\UserManagecontroller::addrechargeinvoice`；[源行](../../data/route/admin.php#L206) | `markPaidHandleClick` |
| `1767fe89` / `handleSizeChange` | `未显式指定` `"credit"` (params) | `RESOURCE {A}/credit` → `admin/Credit`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L568) | 未提取；新设计明确成功后重读受影响对象 |
| `1767fe89` / `currentChange` | `未显式指定` `"credit"` (params) | `RESOURCE {A}/credit` → `admin/Credit`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L568) | 未提取；新设计明确成功后重读受影响对象 |
| `1767fe89` / `editBalance` | `未显式指定` `"credit/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1767fe89` / `deleteBalance` | `"delete"` `"credit/".concat(e)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getList` |
| `1767fe89` / `handelConfirm` | `"put"` `"credit/".concat(e.id)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getList`、`close` |
| `1767fe89` / `handelConfirm` | `"post"` `"credit"` (data) | `RESOURCE {A}/credit` → `admin/Credit`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L568) | `getList`、`close` |
| `1767fe89` / `handelConfirm` | `"post"` `"credit/reduce"` (data) | `POST {A}/credit/reduce` → `admin/credit/reduce`；规则 `app\admin\controller\Creditcontroller::reduce`；[源行](../../data/route/admin.php#L569) | `getList`、`close` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`creatBillHandleClick: e.$router.push({path:"/customer-view/bill",query:{id:e.$route.query.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p058"></a>

## 客户提现审核 `/customer-withdrawal`

旧版证据：[P058](27-admin-built-page-evidence.md#p058)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户提现审核”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4d11/0934b223` | `el-tab-pane` | `提现审核 ($lang.introduction_withdrawal)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `4d11/0934b223` | `el-form-item` | `用户名 ($lang.user_name)` / `id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4d11/0934b223` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4d11/0934b223` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4d11/0934b223` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `姓名(公司名) ($lang.name_company)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `金额 ($lang.sum)` / `num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `操作人 ($lang.operator)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `拒绝原因 ($lang.refuse_reason)` / `reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `4d11/0934b223` | `el-tab-pane` | `收益提现 ($lang.income_withdrawal)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `4d11/0934b223` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `昵称 ($lang.nickname)` / `person` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `收款方式 ($lang.payment_method)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `收款人 ($lang.payee)` / `person` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `收款账号 ($lang.payment_account)` / `account_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `提交时间 ($lang.submit_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `操作人 ($lang.operator)` / `user_login` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `拒绝原因 ($lang.refuse_reason)` / `cancelled_reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4d11/0934b223` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4d11/0934b223` | `" "+t._s(t.showSearchArea1?t.$lang.pack_up_the_search:t.$lang.advanced_search)+" "` | `on.click → function(e){t.showSearchArea1=!t.showSearchArea1}` | `无提取条件` |
| `4d11/0934b223` | `搜索 ($lang.search)` | `on.click → t.promotionSearchHandleClick` | `无提取条件` |
| `4d11/0934b223` | `清空 ($lang.empty)` | `on.click → t.clearPromotionSearch` | `无提取条件` |
| `4d11/0934b223` | `通过` | `on.click → function(a){return t.promotionOperating(e.row,1)}` | `scopedSlots; 1===e.row.status` |
| `4d11/0934b223` | `驳回` | `on.click → function(a){return t.promotionOperating(e.row,2)}` | `scopedSlots; 1===e.row.status` |
| `4d11/0934b223` | `查询 ($lang.demand)` | `on.click → t.getProfitList` | `无提取条件` |
| `4d11/0934b223` | `清空 ($lang.empty)` | `on.click → t.reset` | `无提取条件` |
| `4d11/0934b223` | `r.person` | `on.click → function(e){return t.goUser(r.uid)}` | `scopedSlots` |
| `4d11/0934b223` | `通过` | `on.click → function(e){return t.profitOperating(r,1)}` | `scopedSlots; "Pending"===r.status` |
| `4d11/0934b223` | `驳回` | `on.click → function(e){return t.profitOperating(r,2)}` | `scopedSlots; "Pending"===r.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0934b223` / `getPromotionList` | `"post"` `"aff/affiwithdraw_record"` (data) | `ANY {A}/aff/affiwithdraw_record` → `admin/affiliate/affiwithdrawrecord`；规则 `app\admin\controller\Affiliatecontroller::affiwithdrawrecord`；[源行](../../data/route/admin.php#L709) | 未提取；新设计明确成功后重读受影响对象 |
| `0934b223` / `getpayType` | `"get"` `"aff/gateway_list"` (无显式 data/params) | `ANY {A}/aff/gateway_list` → `admin/affiliate/gatewaylist`；规则 `app\admin\controller\Affiliatecontroller::gatewaylist`；[源行](../../data/route/admin.php#L711) | 未提取；新设计明确成功后重读受影响对象 |
| `0934b223` / `promotionSubmit` | `"post"` `"aff/affiwithdrawsh"` (data) | `ANY {A}/aff/affiwithdrawsh` → `admin/affiliate/affiwithdrawsh`；规则 `app\admin\controller\Affiliatecontroller::affiwithdrawsh`；[源行](../../data/route/admin.php#L710) | `getPromotionList`、`promotionDialogClose` |
| `0934b223` / `getProfitList` | `未显式指定` `"withdraw/withdraw"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0934b223` / `profitOperating` | `"post"` `"withdraw/withdraw"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getProfitList` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goUser: this.$router.push({name:"abstract",query:{id:t}})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/promotion_plan",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p067"></a>

## 交易流水 `/business-statement`

旧版证据：[P067](27-admin-built-page-evidence.md#p067)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“交易流水”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c9e0/4b621598` | `el-tab-pane` | `e.label` / `-` / `-` | `循环 e.typeOptions` | 主区导航；保留对象与选中项 |
| `c9e0/4b621598` | `el-form-item` | `显示 ($lang.show)` / `show` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `开始时间 ($lang.start_time)` / `start_time` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `结束时间 ($lang.end_time)` / `end_time` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `支付方式 ($lang.payment_mode)` / `gateway` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `销售 ($lang.sell)` / `sale_id` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `" "` / `-` / `-` | `e.searchArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `关联用户 ($lang.associated_with_user)` / `-` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `时间 ($lang.time)` / `pay_time` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `账单编号 ($lang.bill_serial_number)` / `invoice_id` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `收入 ($lang.income)` / `amount_in` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `支出 ($lang.expenditure)` / `amount_out` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `货币类型 ($lang.currency_type)` / `currency` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-form-item` | `预付款 ($lang.advance)` / `refund` / `-` | `e.flowArea` | 分组表单；未知原值不置空 |
| `c9e0/4b621598` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `金额 ($lang.sum)` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `销售 ($lang.sell)` / `sale_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `流水号 ($lang.serial_number)` / `trans_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `类型 ($lang.type)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `c9e0/4b621598` | `el-table-column` | `币种 ($lang.currency)` / `code` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `总收入 ($lang.total_income)` / `info.amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `总支出 ($lang.total_spend)` / `info.amount_out` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c9e0/4b621598` | `el-table-column` | `总结余 ($lang.total_surplus)` / `info.surplus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c9e0/4b621598` | `添加交易流水 ($lang.add_transaction_stream_water)` | `on.click → e.changeFlowArea` | `无提取条件` |
| `c9e0/4b621598` | `" "+e._s(e.searchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → e.changeSearchArea` | `无提取条件` |
| `c9e0/4b621598` | `搜索 ($lang.search)` | `on.click → e.getTableData` | `e.searchArea` |
| `c9e0/4b621598` | `清空 ($lang.empty)` | `on.click → e.resetSearchForm` | `e.searchArea` |
| `c9e0/4b621598` | `提交 ($lang.submit)` | `on.click → e.addSubmitForm` | `e.flowArea` |
| `c9e0/4b621598` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `e.flowArea` |
| `c9e0/4b621598` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots` |
| `c9e0/4b621598` | `编辑 ($lang.edit)` | `on.click → function(a){return e.editStatement(t.row)}` | `scopedSlots` |
| `c9e0/4b621598` | `删除 ($lang.delete)` | `on.click → function(a){return e.handleDelete(t.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4b621598` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `4b621598` / `getTableData` | `未显式指定` `"accounts"` (params) | `GET {A}/accounts` → `admin/account/index`；规则 `app\admin\controller\Accountcontroller::index`；[源行](../../data/route/admin.php#L560)<br>`POST {A}/accounts` → `admin/account/save`；规则 `app\admin\controller\Accountcontroller::save`；[源行](../../data/route/admin.php#L563) | `objToArr` |
| `4b621598` / `getPaymentData` | `未显式指定` `"search_page"` (无显式 data/params) | `GET {A}/search_page` → `admin/account/searchPage`；规则 `app\admin\controller\Accountcontroller::searchpage`；[源行](../../data/route/admin.php#L559) | 未提取；新设计明确成功后重读受影响对象 |
| `4b621598` / `handleClick` | `未显式指定` `"accounts/create?uid="+e` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4b621598` / `handleDelete` | `"delete"` `"accounts/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getTableData` |
| `4b621598` / `editStatement` | `未显式指定` `"accounts/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4b621598` / `addSubmitForm` | `"post"` `"accounts"` (data) | `POST {A}/accounts` → `admin/account/save`；规则 `app\admin\controller\Accountcontroller::save`；[源行](../../data/route/admin.php#L563) | `getTableData` |
| `4b621598` / `handelConfirm` | `"put"` `"accounts/".concat(e)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `close`、`getTableData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:r.invoice_id,uid:r.uid}}`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p068"></a>

## 账单管理 `/bill-management`

旧版证据：[P068](27-admin-built-page-evidence.md#p068)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“账单管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6dec/615a6870` | `el-tab-pane` | `e.label` / `-` / `-` | `循环 e.pay_statusCustomOptions` | 主区导航；保留对象与选中项 |
| `6dec/615a6870` | `el-form-item` | `客户 ($lang.client)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `付款方式 ($lang.payment_term)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `账单支付日 ($lang.bills_day)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `账单类型 ($lang.bill_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `销售 ($lang.sell)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `账单号 ($lang.order_no)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6dec/615a6870` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `账单#` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `账单生成日 ($lang.bill_generation_day)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `账单支付日 ($lang.bills_day)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `账单逾期日 ($lang.bill_overdue_date)` / `due_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `总计 ($lang.total)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `付款方式 ($lang.payment_term)` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `销售 ($lang.sell)` / `sale_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `账单类型 ($lang.bill_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6dec/615a6870` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6dec/615a6870` | `" "+e._s(e.showSearchArea?this.$lang.pack_up_the_search:this.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `6dec/615a6870` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `无提取条件` |
| `6dec/615a6870` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `无提取条件` |
| `6dec/615a6870` | `t.row.id` | `on.click → function(a){e.editBillHandleClick(t.row.id,t.row.uid)}` | `scopedSlots` |
| `6dec/615a6870` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots` |
| `6dec/615a6870` | `编辑 ($lang.edit)` | `on.click → function(a){e.editBillHandleClick(t.row.id,t.row.uid)}` | `scopedSlots` |
| `6dec/615a6870` | `标记为已支付 ($lang.mark_paid)` | `on.click → e.markPaidHandleClick` | `无提取条件` |
| `6dec/615a6870` | `标记为被取消 ($lang.marked_cancell)` | `on.click → e.markCancelledHandleClick` | `无提取条件` |
| `6dec/615a6870` | `复制账单 ($lang.copy_bill)` | `on.click → e.copyBillHandleClick` | `无提取条件` |
| `6dec/615a6870` | `删除 ($lang.delete)` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `615a6870` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `615a6870` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `615a6870` / `searchPage` | `未显式指定` `"invoice/search_page"` (params) | `GET {A}/invoice/search_page` → `admin/invoice/searchPage`；规则 `app\admin\controller\Invoicecontroller::searchpage`；[源行](../../data/route/admin.php#L533) | 未提取；新设计明确成功后重读受影响对象 |
| `615a6870` / `getData` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `615a6870` / `getData` | `未显式指定` `"invoice/index"` (params) | `GET {A}/invoice/index` → `admin/invoice/index`；规则 `app\admin\controller\Invoicecontroller::index`；[源行](../../data/route/admin.php#L534) | 未提取；新设计明确成功后重读受影响对象 |
| `615a6870` / `markPaidHandleClick` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | `getData` |
| `615a6870` / `markUnpaidHandleClick` | `未显式指定` `"invoice/unpaid"` (params) | `GET {A}/invoice/unpaid` → `admin/invoice/unpaid`；规则 `app\admin\controller\Invoicecontroller::unpaid`；[源行](../../data/route/admin.php#L536) | `getData` |
| `615a6870` / `markCancelledHandleClick` | `未显式指定` `"invoice/cancelled"` (params) | `GET {A}/invoice/cancelled` → `admin/invoice/cancelled`；规则 `app\admin\controller\Invoicecontroller::cancelled`；[源行](../../data/route/admin.php#L537) | `getData` |
| `615a6870` / `copyBillHandleClick` | `未显式指定` `"invoice/duplicate"` (params) | `GET {A}/invoice/duplicate` → `admin/invoice/duplicate`；规则 `app\admin\controller\Invoicecontroller::duplicate`；[源行](../../data/route/admin.php#L539) | `getData` |
| `615a6870` / `deleteOrderHandleClick` | `"delete"` `"invoice/delete"` (params) | `DELETE {A}/invoice/delete` → `admin/invoice/delete`；规则 `app\admin\controller\Invoicecontroller::delete`；[源行](../../data/route/admin.php#L538) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:t.row.id,uid:t.row.uid}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 旧跳转：`goProduct: this.$router.push({path:"/customer-view/product-innerpage",query:{id:e.uid,hid:e.hostid}})`
- 旧跳转：`adSearch: t.$router.replace({query:c})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`editBillHandleClick: this.$router.push({path:"/bill-detail",query:{id:e,uid:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p069"></a>

## 账单详情 `/bill-detail`

旧版证据：[P069](27-admin-built-page-evidence.md#p069)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：项目表、余额抵扣、网关支付与交易记录分区；已付/未付/作废/退款分别校验前置状态。旧有副作用GET不自动调用或重试；退款后读取实际账单/交易状态，不能按按钮名称猜目标状态。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9e24/be31a696` | `el-form-item` | `客户姓名 ($lang.customer_name)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单编号 ($lang.bill_number)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `""` / `-` | `t.updateInfo` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单生成日 ($lang.bill_generation_day)` / `create_time` / `-` | `else(t.updateInfo)` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `""` / `-` | `t.updateInfo` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单逾期日 ($lang.bill_overdue_date)` / `due_time` / `-` | `else(t.updateInfo)` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `账单金额 ($lang.bill_money)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `余额支付 ($lang.balance_payment)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `接口支付 ($lang.interface_to_pay)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `支付时间 ($lang.pay_time)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `信用额支付 ($lang.credit_payment)` / `""` / `-` | `1==t.billInfo.use_credit_limit` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `备注 ($lang.remark)` / `""` / `-` | `t.updateInfo` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `备注 ($lang.remark)` / `""` / `-` | `else(t.updateInfo)` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `else(t.updateInfo)` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `付款方式 ($lang.payment_term)` / `payment` / `-` | `else(t.updateInfo)` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-table-column` | `时间 ($lang.time)` / `pay_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `金额 ($lang.sum)` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `描述 ($lang.describe)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `用户名 ($lang.user_name)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ipaddr` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9e24/be31a696` | `el-dialog` | `-` / `-` / `发送邮件 ($lang.sendmail)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9e24/be31a696` | `el-dialog` | `-` / `-` / `手动入账 ($lang.manually_enter_item_account)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9e24/be31a696` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `时间 ($lang.time)` / `pay_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `付款方式 ($lang.payment_term)` / `gateway` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `付款流水号 ($lang.payment_account_number)` / `trans_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `发送邮件 ($lang.sendmail)` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-dialog` | `-` / `-` / `退款 ($lang.refund)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9e24/be31a696` | `el-form-item` | `退款类型 ($lang.refund_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-form-item` | `发送邮件 ($lang.sendmail)` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-dialog` | `-` / `-` / `退款 ($lang.refund)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9e24/be31a696` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9e24/be31a696` | `el-dialog` | `-` / `-` / `t.$lang.use+t.payText+t.$lang.payment` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9e24/be31a696` | `发送邮件 ($lang.sendmail)` | `on.click → function(e){t.sendEmail=!0}` | `无提取条件` |
| `9e24/be31a696` | `编辑` | `on.click → t.update` | `t.updateInfo` |
| `9e24/be31a696` | `t.billInfo.username` | `on.click → t.goUserAbstract` | `无提取条件` |
| `9e24/be31a696` | `(查看账单)` | `on.click → t.showCustomerBill` | `无提取条件` |
| `9e24/be31a696` | `余额支付` | `on.click → function(e){return t.showPayModal("余额")}` | `else(t.$valIsNull(t.invoiceSummaryData)\|\|t.$valIsNull(t.invoiceSummaryData.exists_pay)); 0!=parseFloat(t.billInfo.sub); 1==t.invoiceSummaryData.exists_pay.credit.is_pay&&"recharge"!=t.billInfo.type&&parseFloat(t.billInfo.surplus)>0` |
| `9e24/be31a696` | `信用额支付` | `on.click → function(e){return t.showPayModal("信用额")}` | `else(t.$valIsNull(t.invoiceSummaryData)\|\|t.$valIsNull(t.invoiceSummaryData.exists_pay)); 0!=parseFloat(t.billInfo.sub); 1==t.invoiceSummaryData.exists_pay.credit_limit.is_pay&&"recharge"!=t.billInfo.type&&"credit_limit"!=t.billInfo.type&&parseFloat(t.billInfo.surplus)>0` |
| `9e24/be31a696` | `保存` | `on.click → t.saveChangesHandleClick` | `else(t.updateInfo)` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.updateInfo=!0}` | `else(t.updateInfo)` |
| `9e24/be31a696` | `手动入账 ($lang.manually_enter_item_account)` | `on.click → t.rzClick` | `无提取条件` |
| `9e24/be31a696` | `退款` | `on.click → function(a){return t.refund(e.row)}` | `scopedSlots` |
| `9e24/be31a696` | `删除` | `on.click → function(a){return t.deleteTransactionDetailsHandleClick(e.row.id)}` | `scopedSlots` |
| `9e24/be31a696` | `删除 ($lang.delete)` | `on.click → function(a){return t.deleteBillItemHandleClick(e.row.id)}` | `scopedSlots; else(e.row.isLast)` |
| `9e24/be31a696` | `保存更改` | `on.click → t.billEditSaveHandleClick` | `无提取条件` |
| `9e24/be31a696` | `取消更改 ($lang.cancel_changes)` | `on.click → t.getBilldSummary` | `无提取条件` |
| `9e24/be31a696` | `返回 ($lang.get_back)` | `on.click → t.goList` | `无提取条件` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.sendEmail=!1}` | `无提取条件` |
| `9e24/be31a696` | `确定 ($lang.confirm)` | `on.click → t.sendEmailHandleClick` | `无提取条件` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.manualPosting=!1}` | `无提取条件` |
| `9e24/be31a696` | `确定 ($lang.confirm)` | `on.click → t.newPayHandleClick` | `无提取条件` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.refundShow=!1}` | `无提取条件` |
| `9e24/be31a696` | `确定 ($lang.confirm)` | `on.click → t.refundHandleClick` | `无提取条件` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.refundDelShow=!1}` | `无提取条件` |
| `9e24/be31a696` | `确定 ($lang.confirm)` | `on.click → t.deletePay` | `无提取条件` |
| `9e24/be31a696` | `取消 ($lang.cancel)` | `on.click → function(e){t.payShow=!1}` | `无提取条件` |
| `9e24/be31a696` | `确定 ($lang.confirm)` | `on.click → function(e){return t.addPayInvoice(t.payText)}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `be31a696` / `getBilldSummary` | `未显式指定` `"invoice/summary/"+t` (无显式 data/params) | `GET {A}/invoice/summary/:id` → `admin/invoice/summary`；规则 `app\admin\controller\Invoicecontroller::summary`；[源行](../../data/route/admin.php#L540) | `getLogListData` |
| `be31a696` / `sendEmailHandleClick` | `"post"` `"invoice/email"` (data) | `POST {A}/invoice/email` → `admin/Invoice/invoceEmail`；规则 `app\admin\controller\Invoicecontroller::invoceemail`；[源行](../../data/route/admin.php#L553) | `getLogListData` |
| `be31a696` / `markCancelledHandleClick` | `未显式指定` `"invoice/cancelled"` (params) | `GET {A}/invoice/cancelled` → `admin/invoice/cancelled`；规则 `app\admin\controller\Invoicecontroller::cancelled`；[源行](../../data/route/admin.php#L537) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `markUnpaidHandleClick` | `未显式指定` `"invoice/unpaid"` (params) | `GET {A}/invoice/unpaid` → `admin/invoice/unpaid`；规则 `app\admin\controller\Invoicecontroller::unpaid`；[源行](../../data/route/admin.php#L536) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `markPaidHandleClick` | `未显式指定` `"invoice/paid"` (params) | `GET {A}/invoice/paid` → `admin/invoice/paid`；规则 `app\admin\controller\Invoicecontroller::paid`；[源行](../../data/route/admin.php#L535) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `addpayPage` | `未显式指定` `"invoice/addpay_page/"+t` (无显式 data/params) | `GET {A}/invoice/addpay_page/:id` → `admin/invoice/addPayPage`；规则 `app\admin\controller\Invoicecontroller::addpaypage`；[源行](../../data/route/admin.php#L541) | `getLogListData` |
| `be31a696` / `newPayHandleClick` | `"post"` `"invoice/addpay"` (data) | `POST {A}/invoice/addpay` → `admin/invoice/addPay`；规则 `app\admin\controller\Invoicecontroller::addpay`；[源行](../../data/route/admin.php#L542) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `optionPage` | `未显式指定` `"invoice/option_page/"+t` (无显式 data/params) | `GET {A}/invoice/option_page/:id` → `admin/invoice/optionPage`；规则 `app\admin\controller\Invoicecontroller::optionpage`；[源行](../../data/route/admin.php#L543) | `getLogListData` |
| `be31a696` / `saveChangesHandleClick` | `"post"` `"invoice/option"` (data) | `POST {A}/invoice/option` → `admin/invoice/option`；规则 `app\admin\controller\Invoicecontroller::option`；[源行](../../data/route/admin.php#L544) | `getLogListData`、`getBilldSummary`、`optionPage` |
| `be31a696` / `balancePage` | `未显式指定` `"invoice/add_pay_invoice_page/"+t` (无显式 data/params) | `GET {A}/invoice/add_pay_invoice_page/:id` → `admin/invoice/addPayInvoicePage`；规则 `app\admin\controller\Invoicecontroller::addpayinvoicepage`；[源行](../../data/route/admin.php#L545) | `getLogListData` |
| `be31a696` / `addPayInvoice` | `"post"` `"invoice/add_pay_invoice"` (data) | `POST {A}/invoice/add_pay_invoice` → `admin/invoice/addPayInvoice`；规则 `app\admin\controller\Invoicecontroller::addpayinvoice`；[源行](../../data/route/admin.php#L546) | `getLogListData`、`balancePage`、`getBilldSummary` |
| `be31a696` / `addPayInvoice` | `"post"` `"invoice/apply_credit_limit"` (data) | `POST {A}/invoice/apply_credit_limit` → `admin/invoice/applyCreditLimit`；规则 `app\admin\controller\Invoicecontroller::applycreditlimit`；[源行](../../data/route/admin.php#L547) | `getLogListData`、`balancePage`、`getBilldSummary` |
| `be31a696` / `deletePay` | `"post"` `"invoice/delete_pay_invoice"` (data) | `POST {A}/invoice/delete_pay_invoice` → `admin/invoice/deletePayInvoice`；规则 `app\admin\controller\Invoicecontroller::deletepayinvoice`；[源行](../../data/route/admin.php#L548) | `optionPage`、`getLogListData`、`balancePage`、`getBilldSummary` |
| `be31a696` / `refundPage` | `未显式指定` `"invoice/refund_page"` (params) | `GET {A}/invoice/refund_page` → `admin/invoice/refundPage`；规则 `app\admin\controller\Invoicecontroller::refundpage`；[源行](../../data/route/admin.php#L549) | `getLogListData` |
| `be31a696` / `refundHandleClick` | `"post"` `"invoice/refund"` (data) | `POST {A}/invoice/refund` → `admin/invoice/refund`；规则 `app\admin\controller\Invoicecontroller::refund`；[源行](../../data/route/admin.php#L550) | `optionPage`、`getLogListData`、`getBilldSummary` |
| `be31a696` / `remarkPage` | `未显式指定` `"invoice/notes_page"` (params) | `GET {A}/invoice/notes_page` → `admin/invoice/notesPage`；规则 `app\admin\controller\Invoicecontroller::notespage`；[源行](../../data/route/admin.php#L551) | `getLogListData` |
| `be31a696` / `remarksSave` | `"post"` `"invoice/notes"` (data) | `POST {A}/invoice/notes` → `admin/invoice/notes`；规则 `app\admin\controller\Invoicecontroller::notes`；[源行](../../data/route/admin.php#L552) | `getLogListData`、`remarkPage` |
| `be31a696` / `deleteBillItemHandleClick` | `"delete"` `"invoice/delete_item"` (params) | `DELETE {A}/invoice/delete_item` → `admin/invoice/deleteItems`；规则 `app\admin\controller\Invoicecontroller::deleteitems`；[源行](../../data/route/admin.php#L555) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `billEditSaveHandleClick` | `"post"` `"invoice/edit_item"` (data) | `POST {A}/invoice/edit_item` → `admin/invoice/editItem`；规则 `app\admin\controller\Invoicecontroller::edititem`；[源行](../../data/route/admin.php#L554) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `deleteTransactionDetailsHandleClick` | `"delete"` `"invoice/delete_account/"+t` (无显式 data/params) | `DELETE {A}/invoice/delete_account/:id` → `admin/invoice/delAccount`；规则 `app\admin\controller\Invoicecontroller::delaccount`；[源行](../../data/route/admin.php#L556) | `getLogListData`、`getBilldSummary` |
| `be31a696` / `getEmailList` | `未显式指定` `"common/get_email_tem"` (params) | `GET {A}/common/get_email_tem` → `admin/common/getEmailTem`；规则 `app\admin\controller\Commoncontroller::getemailtem`；[源行](../../data/route/admin.php#L96) | `getLogListData` |
| `be31a696` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `be31a696` / `getLogListData` | `未显式指定` `"invoice/log_list"` (params) | `GET {A}/invoice/log_list` → `admin/invoice/invoiceLog`；规则 `app\admin\controller\Invoicecontroller::invoicelog`；[源行](../../data/route/admin.php#L558) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"customer-view/abstract",query:{id:t.uid}}`
- 旧跳转：`render router-link: {path:"customer-view/bill",query:{id:t.uid}}`
- 旧跳转：`goList: this.$router.back()`
- 旧跳转：`showCustomerBill: this.$router.push({path:"customer-view/bill",query:{id:this.uid}})`
- 旧跳转：`goUserAbstract: this.$router.push({path:"customer-view/abstract",query:{id:this.uid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p119"></a>

## 发票设置 `/voucher-setting`

旧版证据：[P119](27-admin-built-page-evidence.md#p119)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“发票设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f0e8/d79147d4` | `el-tab-pane` | `费率设置 ($lang.rate_setting)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f0e8/d79147d4` | `el-form-item` | `发票管理 ($lang.invoice_management)` / `custom_invoice_id_start` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f0e8/d79147d4` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f0e8/d79147d4` | `el-form-item` | `发票费率(%) ($lang.invoice_rate)` / `rate` / `-` | `"1"===e.invoiceFormData.voucher_manager` | 分组表单；未知原值不置空 |
| `f0e8/d79147d4` | `el-tab-pane` | `快递管理 ($lang.express_management)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f0e8/d79147d4` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f0e8/d79147d4` | `el-table-column` | `快递名称 ($lang.express_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f0e8/d79147d4` | `el-table-column` | `快递价格 ($lang.express_price)` / `price` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f0e8/d79147d4` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f0e8/d79147d4` | `el-dialog` | `-` / `-` / `e.formData.id?e.$lang.express_edit:e.$lang.express_add` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `f0e8/d79147d4` | `el-form-item` | `快递名称 ($lang.express_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f0e8/d79147d4` | `el-form-item` | `快递价格 ($lang.express_price)` / `price` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f0e8/d79147d4` | `图标/动态文案，回查原证据` | `on.change → e.managerChange` | `无提取条件` |
| `f0e8/d79147d4` | `保存 ($lang.save)` | `on.click → e.setRateSubmit` | `无提取条件` |
| `f0e8/d79147d4` | `添加快递 ($lang.express_add)` | `on.click → function(t){e.dialogFormVisible=!0}` | `无提取条件` |
| `f0e8/d79147d4` | `修改 ($lang.modification)` | `on.click → function(t){return e.editHandleClick(n)}` | `scopedSlots` |
| `f0e8/d79147d4` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteHandleClick(n)}` | `scopedSlots` |
| `f0e8/d79147d4` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogFormVisible=!1}` | `无提取条件` |
| `f0e8/d79147d4` | `确定 ($lang.confirm)` | `on.click → e.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `d79147d4` / `getRate` | `未显式指定` `"voucher/rate"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `d79147d4` / `setRateSubmit` | `"post"` `"voucher/rate"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getRate` |
| `d79147d4` / `getData` | `未显式指定` `"voucher/expresslist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `d79147d4` / `deleteHandleClick` | `"delete"` `"voucher/express"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `d79147d4` / `dialogOpen` | `未显式指定` `"voucher/express"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `d79147d4` / `submitForm` | `"post"` `"voucher/express"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `d79147d4` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `d79147d4` / `生命周期:created` | `未显式指定` `"system/commoninfo"` (无显式 data/params) | `GET {A}/system/commoninfo` → `admin/System/getcommoninfo`；规则 `app\admin\controller\Systemcontroller::getcommoninfo`；[源行](../../app/admin/controller/SystemController.php#L25) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p120"></a>

## 发票审核 `/invoice-audit`

旧版证据：[P120](27-admin-built-page-evidence.md#p120)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“发票审核”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `dde9/0c1600fe` | `el-tab-pane` | `全部 ($lang.all)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `dde9/0c1600fe` | `el-tab-pane` | `待审核 ($lang.to_audit)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `dde9/0c1600fe` | `el-tab-pane` | `已驳回 ($lang.rejected)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `dde9/0c1600fe` | `el-tab-pane` | `已发出 ($lang.issued)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `dde9/0c1600fe` | `el-tab-pane` | `待支付 ($lang.to_be_paid)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `dde9/0c1600fe` | `el-table-column` | `发票ID ($lang.invoice_id)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `发票抬头 ($lang.invoice_title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `开具类型 ($lang.issue_type)` / `issue_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `发票金额 ($lang.invoice_amount)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `邮寄地址 ($lang.mailing_addr)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `申请时间 ($lang.apply_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `审核时间 ($lang.audit_time)` / `check_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `状态 ($lang.state)` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-dialog` | `-` / `-` / `发票审核 ($lang.invoice_audit)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `dde9/0c1600fe` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `dde9/0c1600fe` | `el-form-item` | `备注留言 ($lang.comments)` / `notes` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `dde9/0c1600fe` | `el-dialog` | `-` / `-` / `发票详情 ($lang.invoice_detail)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `dde9/0c1600fe` | `el-table-column` | `产品名称 ($lang.product_name)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `金额 ($lang.sum)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `税率 ($lang.tax_rate)` / `taxed` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dde9/0c1600fe` | `el-table-column` | `税额 ($lang.tax_amount)` / `taxed_amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `dde9/0c1600fe` | `查看 ($lang.to_view)` | `on.click → function(e){return t.getInvoiceDetail(i.id)}` | `scopedSlots` |
| `dde9/0c1600fe` | `操作 ($lang.operation)` | `on.click → function(e){return t.optHandleClick(i)}` | `scopedSlots; "Pending"===i.status\|\|"Unpaid"===i.status` |
| `dde9/0c1600fe` | `取消 ($lang.cancel)` | `on.click → function(e){t.checkDialogVis=!1}` | `无提取条件` |
| `dde9/0c1600fe` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |
| `dde9/0c1600fe` | `关闭 ($lang.shut_down)` | `on.click → function(e){t.invoiceDetailDialog=!1}` | `无提取条件` |
| `dde9/0c1600fe` | `审核 ($lang.audit)` | `on.click → t.checkHandleClick` | `"Pending"===t.invoiceDetail.voucher.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0c1600fe` / `getData` | `未显式指定` `"voucher/voucherlist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0c1600fe` / `submitForm` | `"post"` `"voucher/voucherstatus"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `0c1600fe` / `getInvoiceDetail` | `未显式指定` `"voucher/voucherdetail"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:t.invoiceDetail.invoice_id,uid:t.invoiceDetail.uid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p126"></a>

## 货币设置 `/currency-settings`

旧版证据：[P126](27-admin-built-page-evidence.md#p126)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“货币设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `faa5/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `货币代码 ($lang.currency_code)` / `code` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `前缀（例如：￥） ($lang.prefix_for_example)` / `prefix` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `后缀 ($lang.suffix)` / `suffix` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `格式 ($lang.format)` / `format` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `汇率 ($lang.exchange_rate)` / `rate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `faa5/-` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `faa5/-` | `汇率更新` | `on.click → e.updateRate` | `无提取条件` |
| `faa5/-` | `价格更新` | `on.click → e.updataPrice` | `无提取条件` |
| `faa5/-` | `设为默认货币 ($lang.set_default_currency)` | `on.click → function(a){return e.setDefault(t.row)}` | `scopedSlots` |
| `faa5/-` | `编辑` | `on.click → function(a){return e.editCurrency(t.row)}` | `scopedSlots` |
| `faa5/-` | `删除 ($lang.delete)` | `on.click → function(a){return e.handleDelete(t.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `editCurrency` | `未显式指定` `"currency/edit_currency/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `handleDelete` | `"get"` `"currency/delete_currency/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getCurrencyList` | `未显式指定` `"currency/currency_list"` (params) | `GET {A}/currency/currency_list` → `admin/currency/currencyList`；规则 `app\admin\controller\Currencycontroller::currencylist`；[源行](../../data/route/admin.php#L267) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `setDefault` | `未显式指定` `"currency/default_currency/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitDialog` | `"post"` `"currency/edit_currency_post"` (data) | `POST {A}/currency/edit_currency_post` → `admin/currency/editCurrencyPost`；规则 `app\admin\controller\Currencycontroller::editcurrencypost`；[源行](../../data/route/admin.php#L270) | `getCurrencyList`、`close` |
| `-` / `submitDialog` | `"post"` `"currency/add_currency"` (data) | `POST {A}/currency/add_currency` → `admin/currency/addCurrency`；规则 `app\admin\controller\Currencycontroller::addcurrency`；[源行](../../data/route/admin.php#L268) | `getCurrencyList`、`close` |
| `-` / `updateRate` | `未显式指定` `"currency/update_rate"` (无显式 data/params) | `GET {A}/currency/update_rate` → `admin/currency/updateRate`；规则 `app\admin\controller\Currencycontroller::updaterate`；[源行](../../data/route/admin.php#L272) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `updataPrice` | `未显式指定` `"currency/update_price"` (无显式 data/params) | `GET {A}/currency/update_price` → `admin/currency/updatePrice`；规则 `app\admin\controller\Currencycontroller::updateprice`；[源行](../../data/route/admin.php#L274) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p134"></a>

## 支付接口 `/payment-interface`

旧版证据：[P134](27-admin-built-page-evidence.md#p134)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“支付接口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `ae17/de028fb4` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `插件名称 ($lang.plug_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `标识 ($lang.identification)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `作者 ($lang.author)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `版本 ($lang.versions)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `ae17/de028fb4` | `el-dialog` | `-` / `-` / `t.plInfo.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `ae17/de028fb4` | `el-form-item` | `e.title` / `""` / `-` | `循环 t.plInfo.config` | 分组表单；未知原值不置空 |
| `ae17/de028fb4` | `el-dialog` | `-` / `-` / `t.pltitle` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `ae17/de028fb4` | `el-form-item` | `""` / `newGatewayId` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `ae17/de028fb4` | `获取更多支付接口 ($lang.moreInterface3)` | `on.click → t.jumpUrl` | `无提取条件` |
| `ae17/de028fb4` | `安装` | `on.click → function(e){return t.plInstallHandleClick(n.name)}` | `scopedSlots; 3===n.status` |
| `ae17/de028fb4` | `卸载` | `on.click → function(e){return t.plUnInstallHandleClick(n.id)}` | `scopedSlots; 3!==n.status` |
| `ae17/de028fb4` | `启用 ($lang.start_using)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"enable")}` | `scopedSlots; 0===n.status` |
| `ae17/de028fb4` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"disable")}` | `scopedSlots; 1===n.status` |
| `ae17/de028fb4` | `配置` | `on.click → function(e){return t.plSettingHandleClick(n.id)}` | `scopedSlots; 3!==n.status` |
| `ae17/de028fb4` | `复制` | `on.click → function(e){return t.plCopyHandleClick(n)}` | `scopedSlots; "UserCustom"===n.name` |
| `ae17/de028fb4` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `ae17/de028fb4` | `保存更改` | `on.click → t.saveHandleClick` | `无提取条件` |
| `ae17/de028fb4` | `取消 ($lang.cancel)` | `on.click → function(e){t.uninstallDialogVisible=!1}` | `无提取条件` |
| `ae17/de028fb4` | `确定 ($lang.confirm)` | `on.click → t.sure` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `de028fb4` / `getData` | `未显式指定` `"pl_index/".concat(t,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `de028fb4` / `plInstallHandleClick` | `"post"` `"pl_install"` (data) | `POST {A}/pl_install` → `admin/plugin/plInstall`；规则 `app\admin\controller\Plugincontroller::plinstall`；[源行](../../data/route/admin.php#L159) | `getData` |
| `de028fb4` / `plUnInstallApi` | `"post"` `"pl_uninstall"` (data) | `POST {A}/pl_uninstall` → `admin/plugin/plUninstall`；规则 `app\admin\controller\Plugincontroller::pluninstall`；[源行](../../data/route/admin.php#L160) | `getData` |
| `de028fb4` / `plToggleApi` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `de028fb4` / `plSettingHandleClick` | `未显式指定` `"pl_setting/gateways/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `de028fb4` / `plCopyHandleClick` | `"post"` `"pl_copy"` (data) | `POST {A}/pl_copy` → `admin/plugin/plCopy`；规则 `app\admin\controller\Plugincontroller::plcopy`；[源行](../../data/route/admin.php#L158) | `getData` |
| `de028fb4` / `saveHandleClick` | `"post"` `"pl_setting_post"` (data) | `POST {A}/pl_setting_post` → `admin/plugin/plSettingPost`；规则 `app\admin\controller\Plugincontroller::plsettingpost`；[源行](../../data/route/admin.php#L163) | `getData` |
| `de028fb4` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `de028fb4` / `rowDrag` | `"post"` `"pl_sort/".concat(t.moduleName,"/")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p135"></a>

## 优惠码 `/promo-code`

旧版证据：[P135](27-admin-built-page-evidence.md#p135)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“优惠码”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `729a/3e8f66f4` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `优惠码 ($lang.promotion_code)` / `code` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `价值 ($lang.value)` / `value` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `循环优惠 ($lang.revolving_offer)` / `recurring` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `已使用次数 / 最大使用次数 ($lang.used_time_maximun)` / `used` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `开始时间 ($lang.start_time)` / `start_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `失效时间 ($lang.failure_time)` / `expiration_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `729a/3e8f66f4` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `729a/3e8f66f4` | `添加优惠码 ($lang.add_promotion_code)` | `on.click → t.addPromo` | `无提取条件` |
| `729a/3e8f66f4` | `立即过期` | `on.click → function(n){return t.expiresNowPromo(e.row)}` | `scopedSlots` |
| `729a/3e8f66f4` | `编辑` | `on.click → function(n){return t.editPromo(e.row)}` | `scopedSlots` |
| `729a/3e8f66f4` | `删除` | `on.click → function(n){return t.deletePromo(e.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3e8f66f4` / `initPromo` | `未显式指定` `"list_promo_code"` (params) | `GET {A}/list_promo_code` → `admin/promo_code/getList`；规则 `app\admin\controller\PromoCodecontroller::getlist`；[源行](../../data/route/admin.php#L451) | 未提取；新设计明确成功后重读受影响对象 |
| `3e8f66f4` / `expiresNowPromo` | `"post"` `"expired_promo_code"` (data) | `POST {A}/expired_promo_code` → `admin/promo_code/expireImmediately`；规则 `app\admin\controller\PromoCodecontroller::expireimmediately`；[源行](../../data/route/admin.php#L450) | `initPromo` |
| `3e8f66f4` / `deletePromo` | `"post"` `"delete_promo_code"` (data) | `POST {A}/delete_promo_code` → `admin/promo_code/delete`；规则 `app\admin\controller\PromoCodecontroller::delete`；[源行](../../data/route/admin.php#L449) | `initPromo` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`addPromo: this.$router.push({name:"promoCodeAdd"})`
- 旧跳转：`editPromo: this.$router.push({name:"promoCodeAdd",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p136"></a>

## 优惠码编辑 `/promo-code-add`

旧版证据：[P136](27-admin-built-page-evidence.md#p136)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“优惠码编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5486/610dc680` | `el-form-item` | `优惠码 ($lang.promotion_code)` / `code` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `是否为循环优惠 ($lang.is_it_revolving_offer)` / `recurring` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `折扣 ($lang.discount)` / `value` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `代理商可用 ($lang.agents_available)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `适用于 ($lang.for)` / `appliesto` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `需要 ($lang.need)` / `requires` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `""` / `requires_exist` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `结算周期 (产品/服务) ($lang.settiement_cycle_product_service)` / `cycles` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `开始时间 ($lang.start_time)` / `start_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `失效时间 ($lang.failure_time)` / `expiration_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `最大使用次数 ($lang.maximum_usage)` / `max_times` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `升降级产品配置 ($lang.up_down_product_config)` / `lifelong` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `一次性 ($lang.onetime)` / `one_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `新注册用户 ($lang.new_reg_user)` / `only_new_client` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `现有的用户 ($lang.existing_user)` / `only_old_client` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `用户只能使用一次 ($lang.user_can_only_once)` / `once_per_client` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `管理员备注 ($lang.admin_remark)` / `notes` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5486/610dc680` | `el-form-item` | `升级配置选项 ($lang.upgrade_configuration_options)` / `upgrade_options` / `-` | `e.formData.upgrades; "option"===e.formData.upgrade_type` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5486/610dc680` | `点此自动生成优惠码 ($lang.create_promotion_code)` | `on.click → function(t){return e.randomPromo(8)}` | `无提取条件` |
| `5486/610dc680` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `5486/610dc680` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `5486/610dc680` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `610dc680` / `addInitData` | `未显式指定` `"add_promo_code/page"` (无显式 data/params) | `GET {A}/add_promo_code/page` → `admin/promo_code/addPage`；规则 `app\admin\controller\PromoCodecontroller::addpage`；[源行](../../data/route/admin.php#L445) | `objToArr` |
| `610dc680` / `editInitData` | `未显式指定` `"save_promo_code/page"` (params) | `GET {A}/save_promo_code/page` → `admin/promo_code/savePage`；规则 `app\admin\controller\PromoCodecontroller::savepage`；[源行](../../data/route/admin.php#L447) | `objToArr` |
| `610dc680` / `submitForm` | `"post"` `"save_promo_code"` (data) | `POST {A}/save_promo_code` → `admin/promo_code/save`；规则 `app\admin\controller\PromoCodecontroller::save`；[源行](../../data/route/admin.php#L448) | 未提取；新设计明确成功后重读受影响对象 |
| `610dc680` / `submitForm` | `"post"` `"add_promo_code"` (data) | `POST {A}/add_promo_code` → `admin/promo_code/add`；规则 `app\admin\controller\PromoCodecontroller::add`；[源行](../../data/route/admin.php#L446) | 未提取；新设计明确成功后重读受影响对象 |
| `610dc680` / `getProductsList` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |
| `610dc680` / `productConfigOptions` | `未显式指定` `"common/product_config_options"` (无显式 data/params) | `GET {A}/common/product_config_options` → `admin/common/getProductConfigOptions`；规则 `app\admin\controller\Commoncontroller::getproductconfigoptions`；[源行](../../data/route/admin.php#L102) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.push({name:"promoCode"})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p179"></a>

## 年度收入统计 `/annual-statistics`

旧版证据：[P179](27-admin-built-page-evidence.md#p179)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：year_reports与year_reports_chart的筛选保持一致，年度/月度和币种口径明确；没有数据与读取失败分别显示。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4ce9/6753f37b` | `el-table-column` | `时间 ($lang.time)` / `date` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ce9/6753f37b` | `el-table-column` | `收入 ($lang.income)` / `income` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ce9/6753f37b` | `el-table-column` | `支出 ($lang.spend)` / `expenses` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ce9/6753f37b` | `el-table-column` | `剩余 ($lang.surplus)` / `last` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `6753f37b` / `getYearDataChart` | `未显式指定` `"year_reports_chart"` (无显式 data/params) | `GET {A}/year_reports_chart` → `admin/reports/getYearIncomeStatisticsForChart`；规则 `app\admin\controller\Reportscontroller::getyearincomestatisticsforchart`；[源行](../../data/route/admin.php#L403) | `chartFunc` |
| `6753f37b` / `getYearData` | `未显式指定` `"year_reports"` (params) | `GET {A}/year_reports` → `admin/reports/getYearIncomeStatistics`；规则 `app\admin\controller\Reportscontroller::getyearincomestatistics`；[源行](../../data/route/admin.php#L402) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p182"></a>

## 新客户统计 `/new-customer`

旧版证据：[P182](27-admin-built-page-evidence.md#p182)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：新客户指标按new_client实际时间分组；不混同销售资源池客户，也不将注册数量直接当付费客户数。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6e88/49cc0dc0` | `el-table-column` | `日期 ($lang.date)` / `day_string` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `新客户 ($lang.new_client)` / `new_clients_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `新订单 ($lang.new_order_form)` / `new_order_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `完成订单 ($lang.accomplish_order_form)` / `complete_order_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `新建工单 ($lang.new_work_order)` / `new_ticket_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `回复的工单 ($lang.replied_work_order)` / `reply_ticket_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6e88/49cc0dc0` | `el-table-column` | `取消请求 ($lang.cancel_request)` / `cancel_requests_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6e88/49cc0dc0` | `搜索` | `on.click → t.getNewClient` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `49cc0dc0` / `getNewClient` | `未显式指定` `"new_client"` (params) | `GET {A}/new_client` → `admin/reports/getNewClientStatistics`；规则 `app\admin\controller\Reportscontroller::getnewclientstatistics`；[源行](../../data/route/admin.php#L404) | `creatEchart` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p183"></a>

## 产品收入统计 `/product-revenue`

旧版证据：[P183](27-admin-built-page-evidence.md#p183)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：product_income返回顶层data[]/groups_count/years；商品分组与年份来自真实响应，跨币种口径不猜测。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e46f/35cfbc5a` | `el-table-column` | `产品 ($lang.product)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e46f/35cfbc5a` | `el-table-column` | `新订购收入 ($lang.new_subscription_revenue)` / `new_order_amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e46f/35cfbc5a` | `el-table-column` | `新订购数量 ($lang.new_order_quantity)` / `new_order_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e46f/35cfbc5a` | `el-table-column` | `续费收入 ($lang.renewal_fee_income)` / `renew_order_amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e46f/35cfbc5a` | `el-table-column` | `续费数量 ($lang.number_renewal)` / `renew_order_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e46f/35cfbc5a` | `el-table-column` | `总金额 ($lang.total_money)` / `total_amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e46f/35cfbc5a` | `搜索 ($lang.search)` | `on.click → e.getProduct` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `35cfbc5a` / `getProduct` | `未显式指定` `"product_income"` (params) | `GET {A}/product_income` → `admin/reports/productIncome`；规则 `app\admin\controller\Reportscontroller::productincome`；[源行](../../data/route/admin.php#L406) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p184"></a>

## 收入排名 `/revenue-ranking`

旧版证据：[P184](27-admin-built-page-evidence.md#p184)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：按forward_client返回的真实排名/金额口径显示；币种筛选与分页保持，不能将响应排序与前端总额重算混用。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4c2b/ab649ee2` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4c2b/ab649ee2` | `el-table-column` | `客户名称 ($lang.customer_name2)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4c2b/ab649ee2` | `el-table-column` | `收入 ($lang.income)` / `income_sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4c2b/ab649ee2` | `el-table-column` | `支出 ($lang.expenditure)` / `expense_sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4c2b/ab649ee2` | `el-table-column` | `剩余 ($lang.surplus)` / `last` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4c2b/ab649ee2` | `a.username` | `on.click → function(e){return t.goAbstract(a)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `ab649ee2` / `getForwardt` | `未显式指定` `"forward_client"` (params) | `GET {A}/forward_client` → `admin/reports/rankForwardClient`；规则 `app\admin\controller\Reportscontroller::rankforwardclient`；[源行](../../data/route/admin.php#L405) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goAbstract: this.$router.push({name:"abstract",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p199"></a>

## 信用额管理 `/credit-management`

旧版证据：[P199](27-admin-built-page-evidence.md#p199)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“信用额管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f825/72a4f0bf` | `el-tab-pane` | `消费记录 ($lang.records_of_consumption)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f825/72a4f0bf` | `el-form-item` | `账单ID ($lang.bill_id)` / `invoice_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `客户 ($lang.client)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `账单支付日 ($lang.bills_day)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `账单类型 ($lang.bill_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-table-column` | `账单# ($lang.bill_num)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `产品 ($lang.product)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `金额 ($lang.sum)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `付款时间 ($lang.payment_time)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-tab-pane` | `还款记录 ($lang.payment_history)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f825/72a4f0bf` | `el-form-item` | `账单ID ($lang.bill_id)` / `invoice_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `客户 ($lang.client)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `账单支付日 ($lang.bills_day)` / `paid_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `还款日期 ($lang.repayment_date)` / `due_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f825/72a4f0bf` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `账单号 ($lang.order_no)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `应还金额 ($lang.amount_due)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `已还金额 ($lang.amount_paid)` / `paid_amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `还款日期 ($lang.repayment_date)` / `due_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `付款时间 ($lang.payment_time)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-tab-pane` | `客户列表 ($lang.customer_list)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f825/72a4f0bf` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `手机号/邮箱 ($lang.phone_email)` / `phonenumber` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `当前余额 ($lang.current_balance)` / `credit_limit_balance` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `账单待还金额 ($lang.amount_to_be_returned)` / `credit_limit_unpaid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `未出账金额 ($lang.outstanding_amount)` / `amount_to_be_settled` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f825/72a4f0bf` | `el-table-column` | `当月还款状态 ($lang.repayment_status_of_the_current_month)` / `payment_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f825/72a4f0bf` | `" "+e._s(e.showSearchArea?this.$lang.pack_up_the_search:this.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `f825/72a4f0bf` | `搜索 ($lang.search)` | `on.click → e.paymentSearchHandeClick` | `无提取条件` |
| `f825/72a4f0bf` | `清空 ($lang.empty)` | `on.click → e.clearPaymentSearchHandleClick` | `无提取条件` |
| `f825/72a4f0bf` | `n.id` | `on.click → function(t){e.editBillHandleClick(n.id,n.uid)}` | `scopedSlots` |
| `f825/72a4f0bf` | `n.username` | `on.click → function(t){return e.goToView(n.uid)}` | `scopedSlots` |
| `f825/72a4f0bf` | `" "+e._s(e.showSearchArea?this.$lang.pack_up_the_search:this.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `f825/72a4f0bf` | `搜索 ($lang.search)` | `on.click → e.repaymentSearchHandeClick` | `无提取条件` |
| `f825/72a4f0bf` | `重置 ($lang.reset)` | `on.click → e.clearRepaymentSearchHandleClick` | `无提取条件` |
| `f825/72a4f0bf` | `n.username` | `on.click → function(t){return e.goToView(n.uid)}` | `scopedSlots` |
| `f825/72a4f0bf` | `n.id` | `on.click → function(t){e.editBillHandleClick(n.id,n.uid)}` | `scopedSlots` |
| `f825/72a4f0bf` | `搜索 ($lang.search)` | `on.click → e.getCustomer` | `无提取条件` |
| `f825/72a4f0bf` | `n.id` | `on.click → function(t){return e.goToView(n.id)}` | `scopedSlots` |
| `f825/72a4f0bf` | `n.username` | `on.click → function(t){return e.goToView(n.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `72a4f0bf` / `searchPage` | `未显式指定` `"invoice/search_page"` (params) | `GET {A}/invoice/search_page` → `admin/invoice/searchPage`；规则 `app\admin\controller\Invoicecontroller::searchpage`；[源行](../../data/route/admin.php#L533) | 未提取；新设计明确成功后重读受影响对象 |
| `72a4f0bf` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `72a4f0bf` / `getPayment` | `"get"` `"credit_limit/list"` (params) | `GET {A}/credit_limit/list` → `admin/credit_limit/list`；规则 `app\admin\controller\CreditLimitcontroller::list`；[源行](../../data/route/admin.php#L575) | 未提取；新设计明确成功后重读受影响对象 |
| `72a4f0bf` / `getRepayment` | `"get"` `"credit_limit/user_invoice"` (params) | `GET {A}/credit_limit/user_invoice` → `admin/credit_limit/userInvoice`；规则 `app\admin\controller\CreditLimitcontroller::userinvoice`；[源行](../../data/route/admin.php#L576) | 未提取；新设计明确成功后重读受影响对象 |
| `72a4f0bf` / `getCustomer` | `"get"` `"credit_limit/client_list"` (params) | `GET {A}/credit_limit/client_list` → `admin/credit_limit/clientList`；规则 `app\admin\controller\CreditLimitcontroller::clientlist`；[源行](../../data/route/admin.php#L578) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`editBillHandleClick: this.$router.push({path:"/bill-detail",query:{id:e,uid:t}})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p200"></a>

## 信用额设置 `/credit-setting`

旧版证据：[P200](27-admin-built-page-evidence.md#p200)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“信用额设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `08cc/ce6977ea` | `el-form-item` | `信用额总开关 ($lang.total_credit_switch)` / `shd_credit_limit` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-form-item` | `信用额额度设置 ($lang.credit_limit_setting)` / `shd_credit_limit_amount` / `-` | `1==t.formData.shd_credit_limit` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-form-item` | `出账日 ($lang.billing_date)` / `shd_credit_limit_bill_generation_date` / `-` | `1==t.formData.shd_credit_limit` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-form-item` | `最后还款日 ($lang.final_repayment_date)` / `shd_credit_limit_bill_repayment_period` / `-` | `1==t.formData.shd_credit_limit` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-form-item` | `违约金总开关 ($lang.penalty_master_switch)` / `shd_credit_limit_liquidated_damages` / `-` | `1==t.formData.shd_credit_limit` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-switch` | `-` / `-` / `-` | `1==t.formData.shd_credit_limit` | 分组表单；未知原值不置空 |
| `08cc/ce6977ea` | `el-form-item` | `单日违约金百分比设置 ($lang.percentage_setting_of_one_day_liquidated_damages)` / `shd_credit_limit_liquidated_damages_percent` / `-` | `1==t.formData.shd_credit_limit&&1==t.formData.shd_credit_limit_liquidated_damages` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `08cc/ce6977ea` | `保存更改 ($lang.save_the_changes)` | `on.click → t.save` | `无提取条件` |
| `08cc/ce6977ea` | `取消更改 ($lang.cancel_changes)` | `on.click → t.getData` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `ce6977ea` / `getData` | `"get"` `"credit_limit/config"` (params) | `GET {A}/credit_limit/config` → `admin/credit_limit/getConfig`；规则 `app\admin\controller\CreditLimitcontroller::getconfig`；[源行](../../data/route/admin.php#L579) | 未提取；新设计明确成功后重读受影响对象 |
| `ce6977ea` / `save` | `"post"` `"credit_limit/config"` (data) | `POST {A}/credit_limit/config` → `admin/credit_limit/postConfig`；规则 `app\admin\controller\CreditLimitcontroller::postconfig`；[源行](../../data/route/admin.php#L580) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p213"></a>

## 合同审核 `/contracts_audit`

旧版证据：[P213](27-admin-built-page-evidence.md#p213)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“合同审核”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4cdc/46b7ca75` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `客户 ($lang.client)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `产品信息 ($lang.product_info)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `付款时间 ($lang.payment_time)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `产品状态 ($lang.product_status)` / `domainstatus_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `合同状态 ($lang.contract_status)` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4cdc/46b7ca75` | `el-dialog` | `-` / `-` / `邮寄管理 ($lang.mail_management)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `4cdc/46b7ca75` | `el-form-item` | `合同ID:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `产品信息:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `收件人姓名:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `电话:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `收件地址:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `是否邮寄:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `快递公司:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cdc/46b7ca75` | `el-form-item` | `快递单号:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4cdc/46b7ca75` | `查看下载 ($lang.view_download)` | `on.click → function(e){return t.handleView(r.id,r.status)}` | `scopedSlots; 0!==r.status` |
| `4cdc/46b7ca75` | `邮寄管理 ($lang.mail_management)` | `on.click → function(e){return t.handleIsMail(r)}` | `scopedSlots; 1==r.status\|\|3==r.status\|\|4==r.status` |
| `4cdc/46b7ca75` | `作废 ($lang.to_void)` | `on.click → function(e){return t.handleInvalid(r.id)}` | `scopedSlots; 2==r.status&&0==r.force` |
| `4cdc/46b7ca75` | `作废合同 ($lang.void_contract)` | `on.click → t.contractCancel` | `无提取条件` |
| `4cdc/46b7ca75` | `确定 ($lang.confirm)` | `on.click → t.emailManage` | `无提取条件` |
| `4cdc/46b7ca75` | `取消 ($lang.cancel)` | `on.click → function(e){t.mailDialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `46b7ca75` / `emailManage` | `"post"` `"contract/contract/".concat(t.id)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `46b7ca75` / `cnacelEmail` | `"post"` `"contract/cancel_post/".concat(t.id)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `46b7ca75` / `contractCancel` | `"post"` `"contract/cancel"` (data) | `POST {A}/contract/cancel` → `admin/contract/cancel`；规则 `app\admin\controller\Contractcontroller::cancel`；[源行](../../data/route/admin.php#L391) | `getData` |
| `46b7ca75` / `handleView` | `未显式指定` `"contract/download/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `46b7ca75` / `handleView` | `"get"` `"contract/contract_page"` (params) | `GET {A}/contract/contract_page` → `admin/contract/contractPage`；规则 `app\admin\controller\Contractcontroller::contractpage`；[源行](../../data/route/admin.php#L397) | 未提取；新设计明确成功后重读受影响对象 |
| `46b7ca75` / `handleView` | `"POST"` `"contract/contract_page/".concat(t)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `46b7ca75` / `getData` | `"get"` `"contract/contract"` (params) | `GET {A}/contract/contract` → `admin/contract/contract`；规则 `app\admin\controller\Contractcontroller::contract`；[源行](../../data/route/admin.php#L390) | 未提取；新设计明确成功后重读受影响对象 |
| `46b7ca75` / `handleInvalid` | `"post"` `"contract/cancel"` (data) | `POST {A}/contract/cancel` → `admin/contract/cancel`；规则 `app\admin\controller\Contractcontroller::cancel`；[源行](../../data/route/admin.php#L391) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.uid}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:r.uid,hid:r.hostid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p214"></a>

## 合同设置 `/contracts_setting`

旧版证据：[P214](27-admin-built-page-evidence.md#p214)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“合同设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4e28/743e0614` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `合同名称 ($lang.contract_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `强制签订 ($lang.forced_sign)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `已签订/待签订 ($lang.signed_to_be)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `包含产品 ($lang.contains_product)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `备注 ($lang.remark)` / `remark` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/743e0614` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4e28/47d9f2ef` | `el-tab-pane` | `系统设置 ($lang.system_setting)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `4e28/47d9f2ef` | `el-tab-pane` | `合同模板管理 ($lang.contract_template_management)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4e28/743e0614` | `新增合同 ($lang.add_contract)` | `on.click → function(e){return t.$router.push("add_contract")}` | `无提取条件` |
| `4e28/743e0614` | `搜索 ($lang.search)` | `on.click → function(e){return t.getData()}` | `无提取条件` |
| `4e28/743e0614` | `r.id` | `on.click → function(e){return t.handleEditContract(r.id)}` | `scopedSlots` |
| `4e28/743e0614` | `修改 ($lang.modification)` | `on.click → function(e){return t.handleEditContract(r.id)}` | `scopedSlots` |
| `4e28/743e0614` | `删除 ($lang.delete)` | `on.click → function(e){return t.handleDeleteContract(r.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `743e0614` / `getData` | `"get"` `"contract/tpl"` (params) | `GET {A}/contract/tpl` → `admin/contract/tpl`；规则 `app\admin\controller\Contractcontroller::tpl`；[源行](../../data/route/admin.php#L388) | 未提取；新设计明确成功后重读受影响对象 |
| `743e0614` / `handleDeleteContract` | `"DELETE"` `"contract/tpl/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`handleEditContract: this.$router.push({name:"addContract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p215"></a>

## 合同编辑 `/add_contract`

旧版证据：[P215](27-admin-built-page-evidence.md#p215)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“合同编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `780a/3cef0fce` | `el-form-item` | `合同名称 ($lang.contract_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `合同状态 ($lang.contract_status)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `强制签订 ($lang.forced_sign)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `订单开通后 ($lang.after_order_open)` / `-` / `-` | `1==t.addContractForm.force` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `基础合同 ($lang.basic_contract)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `关联产品 ($lang.related_product)` / `pids` / `-` | `0==t.addContractForm.base` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `合同备注 ($lang.contract_notes)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `合同落款我方信息 ($lang.contract_signing_our_information)` / `inscribe_custom` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `我方授权代表 ($lang.our_authorized_representative)` / `represent` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `授权电话 ($lang.authorized_telephone)` / `phonenumber` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `授权电子邮箱 ($lang.authorization_email)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `合同内容 ($lang.contract_content)` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `780a/3cef0fce` | `el-form-item` | `可变参数 ($lang.variable_parameters)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `780a/3cef0fce` | `提交 ($lang.submit)` | `on.click → function(e){return t.handleSubmitContract("addContractRef")}` | `无提取条件` |
| `780a/3cef0fce` | `取消 ($lang.cancel)` | `on.click → function(e){return t.$router.back(-1)}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3cef0fce` / `getAddContractData` | `"GET"` `"contract/detail"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3cef0fce` / `handleSubmitContract` | `"POST"` `"contract/detail/".concat(t)` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3cef0fce` / `handleSubmitContract` | `"POST"` `"contract/detail"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3cef0fce` / `生命周期:created` | `"GET"` `"contract/detail/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`handleSubmitContract: e.$router.push({path:"/contracts_setting",query:{active:"second"}})`
- 旧跳转：`goBack: this.$router.push({path:"/contracts_setting",query:{active:"second"}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
