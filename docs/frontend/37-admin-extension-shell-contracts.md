# 外壳、插件与扩展逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [后台登录](#p001) `/login` | `login` | 路由 factory 指向模块 |
| [无权限](#p002) `/forbidden` | `error` | 未定位组件 |
| [页面不存在](#p003) `/404` | `error` | 路由 factory 指向模块 |
| [系统错误](#p004) `/500` | `error` | 路由 factory 指向模块 |
| [后台外壳](#p011) `/` | `shell` | 路由 factory 指向模块 |
| [后台首页](#p012) `/home-page` | `dashboard` | 路由 factory 指向模块 |
| [应用详情](#p013) `/app-detail` | `detail` | 路由 factory 指向模块 |
| [应用商店容器](#p014) `/app-store` | `shell` | 路由 factory 指向模块 |
| [商店应用详情](#p015) `/app-store/app-inner` | `detail` | 路由 factory 指向模块 |
| [应用排行榜](#p016) `/app-store/app-leaderboard` | `list` | 路由 factory 指向模块 |
| [商店应用列表](#p017) `/app-store/app-list` | `list` | 路由 factory 指向模块 |
| [我的应用](#p018) `/app-store/my-app` | `list` | 路由 factory 指向模块 |
| [安装进度](#p019) `/install-progress` | `detail` | 路由 factory 指向模块 |
| [模块插件](#p132) `/module-plugin` | `list` | 路由 factory 指向模块 |
| [应用列表](#p187) `/application-list` | `list` | 路由 factory 指向模块 |
| [应用管理详情](#p188) `/application-detail` | `detail` | 路由 factory 指向模块 |
| [应用审核](#p189) `/appcheck-list` | `list` | 路由 factory 指向模块 |
| [评论管理](#p190) `/comment-list` | `list` | 路由 factory 指向模块 |
| [热门应用](#p191) `/hot-app` | `list` | 路由 factory 指向模块 |
| [推荐应用](#p192) `/highly-recommended` | `list` | 路由 factory 指向模块 |
| [扩展通知列表](#p201) `/notify_list` | `list` | 路由 factory 指向模块 |
| [指令查询](#p202) `/Instruction_query` | `list` | 路由 factory 指向模块 |
| [自动回复设置](#p203) `/auto_reply_setting` | `form` | 路由 factory 指向模块 |
| [功能模块](#p204) `/functional-module` | `list` | 路由 factory 指向模块 |
| [功能模块编辑](#p205) `/add_functional_module` | `form` | 路由 factory 指向模块 |
| [关键词管理](#p206) `/keyword-manage` | `list` | 路由 factory 指向模块 |
| [特殊回复](#p207) `/special-reply` | `form` | 路由 factory 指向模块 |
| [关键词编辑](#p208) `/add_keywords` | `form` | 路由 factory 指向模块 |
| [知识分类](#p209) `/cate-management` | `list` | 路由 factory 指向模块 |
| [扩展知识库](#p210) `/knowledge-base` | `list` | 路由 factory 指向模块 |
| [插件管理容器](#p211) `/plug-management` | `shell` | 路由 factory 指向模块 |
| [插件导出](#p212) `/plug-management/plug-export` | `form` | 路由 factory 指向模块 |

<a id="p001"></a>

## 后台登录 `/login`

旧版证据：[P001](27-admin-built-page-evidence.md#p001)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：背景品牌图 → 最大宽400px的登录表单；账号、密码、按配置显示验证码/二次验证 → 登录与辅助入口。仅明确成功后进入授权页面，凭据仅留于当前提交过程。

**手机排版**：表单宽min(400px,100% - 32px)，输入44px；320/390px无横向溢出，错误紧随字段，验证码不裁切。

**本页专项约束**：围绕“后台登录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9ed6/7d93d0fc` | `el-form-item` | `""` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9ed6/7d93d0fc` | `el-form-item` | `""` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9ed6/7d93d0fc` | `el-form-item` | `-` / `captcha` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9ed6/7d93d0fc` | `el-form-item` | `""` / `code` / `-` | `1===e.second_verify_admin&&e.second_verify_action_admin.includes("login")` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9ed6/7d93d0fc` | `" "+e._s(e.changeBtnValue)` | `on.click → e.sendCode` | `1===e.second_verify_admin&&e.second_verify_action_admin.includes("login")` |
| `9ed6/7d93d0fc` | `登录` | `on.click → e.login` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1a5f00d6` / `getVerify` | `未显式指定` `"/verify"` (params) | `GET {A}/verify` → `admin/Public/verify`；规则 `app\admin\controller\Publiccontroller::verify`；[源行](../../data/route/admin.php#L92) | 未提取；新设计明确成功后重读受影响对象 |
| `7d93d0fc` / `login` | `"post"` `"login"` (data) | `POST {A}/login` → `admin/Public/ad_login`；规则 `app\admin\controller\Publiccontroller::ad_login`；[源行](../../data/route/admin.php#L84) | `getCommonData`、`getSystemInfo` |
| `7d93d0fc` / `login` | `未显式指定` `"user/edit_self_info_page"` (无显式 data/params) | `GET {A}/user/edit_self_info_page` → `admin/user/editSelfInfoPage`；规则 `app\admin\controller\Usercontroller::editselfinfopage`；[源行](../../data/route/admin.php#L151) | `getCommonData`、`getSystemInfo` |
| `7d93d0fc` / `getSystemInfo` | `未显式指定` `"system/info"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getLastVersion` |
| `7d93d0fc` / `getLastVersion` | `未显式指定` `"system/lastversion"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `7d93d0fc` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `7d93d0fc` / `loginPage` | `未显式指定` `"login_page"` (无显式 data/params) | `GET {A}/login_page` → `admin/Public/adPage`；规则 `app\admin\controller\Publiccontroller::adpage`；[源行](../../data/route/admin.php#L83) | 未提取；新设计明确成功后重读受影响对象 |
| `7d93d0fc` / `sendCode` | `"post"` `"second_verify_send"` (data) | `POST {A}/second_verify_send` → `admin/Public/secondVerifySend`；规则 `app\admin\controller\Publiccontroller::secondverifysend`；[源行](../../data/route/admin.php#L86) | `countDown` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`login: e.$router.push(e.prePath)`
- 旧跳转：`login: e.$router.push({name:"home"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p002"></a>

## 无权限 `/forbidden`

旧版证据：[P002](27-admin-built-page-evidence.md#p002)；归属：未定位组件。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：状态标题 → 可理解的错误原因 → 返回/重试；不展示堆栈、凭据或未经授权的对象资料。重试只重复读取。

**手机排版**：单列居中，按钮44px；长错误说明换行，无嵌套浮动面板。

**本页专项约束**：围绕“无权限”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

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

<a id="p003"></a>

## 页面不存在 `/404`

旧版证据：[P003](27-admin-built-page-evidence.md#p003)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：状态标题 → 可理解的错误原因 → 返回/重试；不展示堆栈、凭据或未经授权的对象资料。重试只重复读取。

**手机排版**：单列居中，按钮44px；长错误说明换行，无嵌套浮动面板。

**本页专项约束**：围绕“页面不存在”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `75b4/9cbea866` | `返回上一页 ($lang.return_previous_page)` | `on.click → t.goBack` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p004"></a>

## 系统错误 `/500`

旧版证据：[P004](27-admin-built-page-evidence.md#p004)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：状态标题 → 可理解的错误原因 → 返回/重试；不展示堆栈、凭据或未经授权的对象资料。重试只重复读取。

**手机排版**：单列居中，按钮44px；长错误说明换行，无嵌套浮动面板。

**本页专项约束**：围绕“系统错误”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7af1/e60eb4a6` | `返回上一页` | `on.click → t.goBack` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goBack: this.$router.push(this.prePath)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p011"></a>

## 后台外壳 `/`

旧版证据：[P011](27-admin-built-page-evidence.md#p011)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `home-page`；子页 `/home-page`、`/app-detail`、`/app-store`、`/install-progress`、`/customer-list`、`/base-info`、`/theme-template`、`/login-register`、`/order-product`、`/twice-confirm`、`/third-login`、`/customer-view`、`/set`、`/customer-add`、`/customer-group`、`/customer-custom`、`/customer-product`、`/customer-authentication`、`/add-records`、`/cancel-request`、`/sales-management`、`/sales-statistics`、`/customer-promotionplan`、`/customer-withdrawal`、`/customer-cancelreq`、`/customer-resources`、`/customer-level`、`/order-list`、`/add-order`、`/order-detail`、`/renewal-order`、`/supplier-renewal-order`、`/business-statement`、`/bill-management`、`/bill-detail`、`/preset-reply`、`/addedit-pre-reply`、`/support-ticket`、`/add-support-ticket`、`/support-ticket-detail`、`/support-statistics`、`/news-list`、`/add-news`、`/news-category`、`/help-list`、`/add-help`、`/help-category`、`/custom-template-fields`、`/add-custom-template-fields`、`/sms-template`、`/sms-template-index`、`/sms-create-template`、`/sms-send-settings`、`/system-log`、`/station-letter-log`、`/system-admin-log`、`/inform-log`、`/email-log`、`/sms-log`、`/api-log`、`/log-cleanup`、`/automatic-task-log`、`/system-message`、`/php-message`、`/database-message`、`/data-migration`、`/about`、`/general-settings`、`/second`、`/voucher-setting`、`/invoice-audit`、`/admin-management`、`/admin-edit`、`/black-list`、`/email-list`、`/email-edit`、`/currency-settings`、`/permissions-managment`、`/permissions-edit`、`/automatic-tasks`、`/timing-results`、`/promotion_plan`、`/module-plugin`、`/authentication-setting`、`/payment-interface`、`/promo-code`、`/promo-code-add`、`/work-order-dept`、`/new-work-order-dept`、`/add-custom-fields`、`/work-order-status`、`/work-order-rules`、`/product-server`、`/add-product-group`、`/edit-product`、`/configurable-option`、`/edit-configurable-option-group`、`/server-settings`、`/add-server`、`/group-list`、`/add-group`、`/add-interface`、`/dcim`、`/dcim-view`、`/dcim-traffic`、`/dcim-traffic-log`、`/dcim-product`、`/zjmfcloud`、`/zjmfcloud-product`、`/munual-resource`、`/upStream-edit`、`/addOrEdit-resource`、`/task-queue`、`/configure-edit`、`/api-setup`、`/statistics-taskQueue`、`/commodity-list`、`/commodity-product`、`/commodity-taskQueue`、`/add-supplier`、`/supplier-order-list`、`/zjmf-api`、`/official-setting`、`/menu_manage`、`/create_menu`、`/create_menu_www`、`/friendly_link`、`/marketing-push`、`/message-write`、`/annual-statistics`、`/service-support`、`/file`、`/new-customer`、`/product-revenue`、`/revenue-ranking`、`/edit-person`、`/customer-developer`、`/application-list`、`/application-detail`、`/appcheck-list`、`/comment-list`、`/hot-app`、`/highly-recommended`、`/dcim-authorization`、`/dcim-authorization-disable`、`/dcim-authorization-error`、`/dcim-debug-log`、`/dcim-authorization-update`、`/resource-pool`、`/credit-management`、`/credit-setting`、`/notify_list`、`/Instruction_query`、`/auto_reply_setting`、`/functional-module`、`/add_functional_module`、`/keyword-manage`、`/special-reply`、`/add_keywords`、`/cate-management`、`/knowledge-base`、`/plug-management`、`/contracts_audit`、`/contracts_setting`、`/add_contract`、`/order-management-list`、`/refund-detail`、`/aftersale-detail`、`/business-management`、`/resourcePool-taskQueue`、`/resourcePool-workOrder`、`/resourcePool-set`、`/statistical-information`、`/commodity-management`、`/ssistant-audit`、`/assist-apply`、`/assist-detail`、`/resource-pool-shop`、`/resourcePool-logs`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“后台外壳”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7abe/e902b874` | `el-form-item` | `""` / `first` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7abe/e902b874` | `el-form-item` | `""` / `second` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7abe/e902b874` | `el-form-item` | `""` / `third` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7abe/e902b874` | `图标/动态文案，回查原证据` | `on.click → t.searchBtnSub` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `e902b874` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `e902b874` / `生命周期:created` | `未显式指定` `"system/commoninfo"` (无显式 data/params) | `GET {A}/system/commoninfo` → `admin/System/getcommoninfo`；规则 `app\admin\controller\Systemcontroller::getcommoninfo`；[源行](../../app/admin/controller/SystemController.php#L25) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"customerAdd"}`
- 旧跳转：`render router-link: {name:"addOrder"}`
- 旧跳转：`render router-link: e.url?e.url:""`
- 旧跳转：`adSearch: a.$router.push({path:n.list[0].url.split("#")[1]})`
- 旧跳转：`adSearch: a.$router.push({path:"/customer-list",query:e})`
- 旧跳转：`adSearch: a.$router.push({path:n.data.list[0].url.split("#")[1]})`
- 旧跳转：`adSearch: a.$router.push({path:"/customer-product",query:e})`
- 旧跳转：`adSearch: a.$router.push({path:n.data[0].url.split("#")[1]})`
- 旧跳转：`adSearch: a.$router.push({path:"/support-ticket",query:e})`
- 旧跳转：`adSearch: a.$router.push({path:"/bill-management",query:e})`
- 旧跳转：`adSearch: a.$router.push({path:"/order-list",query:e})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p012"></a>

## 后台首页 `/home-page`

旧版证据：[P012](27-admin-built-page-evidence.md#p012)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：页标题与统计范围 → 可验证的指标 → 趋势与待办 → 最近记录；区域加载与失败独立处理，指标来源未落实时不填演示数据。

**手机排版**：指标按优先级排列，趋势全宽，待办逐项显示；手机导航及内容实时重排。

**本页专项约束**：围绕“后台首页”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `705f13ea` / `getBaseInfo` | `未显式指定` `"report/base_info"` (params) | `GET {A}/report/base_info` → `admin/report/baseInfo`；规则 `app\admin\controller\Reportcontroller::baseinfo`；[源行](../../data/route/admin.php#L399) | `tradeChartDataSet`、`monthChartDataSet`、`monthStaffChartDataSet` |
| `705f13ea` / `getBaseModule` | `未显式指定` `"report/get_base_module"` (无显式 data/params) | `GET {A}/report/get_base_module` → `admin/report/getSystemInfoModulesList`；规则 `app\admin\controller\Reportcontroller::getsysteminfomoduleslist`；[源行](../../data/route/admin.php#L400) | 未提取；新设计明确成功后重读受影响对象 |
| `705f13ea` / `updateBaseModule` | `"post"` `"report/update_base_module"` (data) | `POST {A}/report/update_base_module` → `admin/report/updateSystemInfoModulesSort`；规则 `app\admin\controller\Reportcontroller::updatesysteminfomodulessort`；[源行](../../data/route/admin.php#L401) | `getBaseModule` |
| `705f13ea` / `defaultModules` | `"post"` `"report/update_base_module"` (data) | `POST {A}/report/update_base_module` → `admin/report/updateSystemInfoModulesSort`；规则 `app\admin\controller\Reportcontroller::updatesysteminfomodulessort`；[源行](../../data/route/admin.php#L401) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"systemMessage"}`
- 旧跳转：`render router-link: {name:"systemLog"}`
- 旧跳转：`render router-link: {name:"supportTicket"}`
- 旧跳转：`render router-link: {name:"orderList",query:{status:"Pending"}}`
- 旧跳转：`render router-link: {name:"CustomerAuthentication"}`
- 旧跳转：`render router-link: {name:"WithdrawalAudit"}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.id}}`
- 旧跳转：`render router-link: {name:"customerProduct",query:{from:"home-page",productType:e.type}}`
- 旧跳转：`render router-link: {path:"support-ticket-detail",query:{id:e.id,tid:e.tid}}`
- 旧跳转：`toOrder: this.$router.push({name:"orderList",query:{st:a,pay_status:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN。

<a id="p013"></a>

## 应用详情 `/app-detail`

旧版证据：[P013](27-admin-built-page-evidence.md#p013)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“应用详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `915b/78db8c22` | `el-tab-pane` | `应用描述` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `915b/78db8c22` | `el-tab-pane` | `使用说明` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `915b/78db8c22` | `el-tab-pane` | `版本记录` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `915b/78db8c22` | `立即购买` | `on.click → a.goBuy` | `0===a.pageData.product.status` |
| `915b/78db8c22` | `立即更新` | `on.click → a.upload` | `3===a.pageData.product.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`orderCallBack: this.$router.push({name:"appStore"})`
- 旧跳转：`payCallBack: this.$router.push({name:"appStore"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p014"></a>

## 应用商店容器 `/app-store`

旧版证据：[P014](27-admin-built-page-evidence.md#p014)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 `/app-store/app-inner`、`/app-store/app-leaderboard`、`/app-store/app-list`、`/app-store/my-app`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“应用商店容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `7b93895b` / `生命周期:created` | `未显式指定` `"app_store/set_token"` (无显式 data/params) | `GET {A}/app_store/set_token` → `admin/appStore/setToken`；规则 `app\admin\controller\AppStorecontroller::settoken`；[源行](../../data/route/admin.php#L87) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p015"></a>

## 商店应用详情 `/app-store/app-inner`

旧版证据：[P015](27-admin-built-page-evidence.md#p015)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/app-store`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“商店应用详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `69c2/1c81148c` | `el-tab-pane` | `详情` / `-` / `-` | `else(t.pageLoading)` | 主区导航；保留对象与选中项 |
| `69c2/1c81148c` | `el-tab-pane` | `使用说明` / `-` / `-` | `else(t.pageLoading)` | 主区导航；保留对象与选中项 |
| `69c2/1c81148c` | `el-tab-pane` | `版本说明` / `-` / `-` | `else(t.pageLoading)` | 主区导航；保留对象与选中项 |
| `69c2/1c81148c` | `el-tab-pane` | `评价` / `-` / `-` | `else(t.pageLoading)` | 主区导航；保留对象与选中项 |
| `69c2/1c81148c` | `el-dialog` | `-` / `-` / `t.appDetail.product.my_evaluation.username?"追加评论":"发布评论"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `69c2/1c81148c` | `el-form-item` | `评论` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `69c2/1c81148c` | `el-form-item` | `星级` / `content` / `-` | `else(t.appDetail.product.my_evaluation.username)` | 分组表单；未知原值不置空 |
| `69c2/1c81148c` | `el-dialog` | `-` / `-` / `回复评论` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `69c2/1c81148c` | `el-form-item` | `评论` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `69c2/1c81148c` | `立即购买` | `on.click → t.goBuy` | `else(t.pageLoading); 0===t.appDetail.product.status` |
| `69c2/1c81148c` | `立即安装` | `on.click → t.installApp` | `else(t.pageLoading); 1===t.appDetail.product.status` |
| `69c2/1c81148c` | `卸载` | `on.click → t.uniApp` | `else(t.pageLoading); 2===t.appDetail.product.status\|\|3===t.appDetail.product.status` |
| `69c2/1c81148c` | `更新` | `on.click → t.update` | `else(t.pageLoading); 3===t.appDetail.product.status` |
| `69c2/1c81148c` | `t._s(t.appDetail.product.my_evaluation.username?"追加评论":"发布评论")+" "` | `on.click → function(e){t.commentDialogVis=!0}` | `0!==t.appDetail.product.status` |
| `69c2/1c81148c` | `查看更多` | `on.click → t.seeMore` | `t.clientWidth>768; t.appDetail.other_app.length>=6` |
| `69c2/1c81148c` | `取 消` | `on.click → function(e){t.commentDialogVis=!1}` | `无提取条件` |
| `69c2/1c81148c` | `发布` | `on.click → t.addCommentSubmit` | `无提取条件` |
| `69c2/1c81148c` | `取 消` | `on.click → function(e){t.replyDialogVis=!1}` | `无提取条件` |
| `69c2/1c81148c` | `回复` | `on.click → t.replySubmit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1c81148c` / `getAppDetail` | `未显式指定` `"app_store/app/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1c81148c` / `toggleFavorite` | `"delete"` `"app_store/favorite/app/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppDetail` |
| `1c81148c` / `toggleFavorite` | `"post"` `"app_store/favorite/app/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppDetail` |
| `1c81148c` / `addCommentSubmit` | `"post"` `"app_store/app/".concat(t.id,"/evaluation")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppDetail`、`addCommentAgain` |
| `1c81148c` / `addCommentAgain` | `"post"` `"app_store/evaluation/".concat(t.id,"/evaluate")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppDetail` |
| `1c81148c` / `getCommentList` | `未显式指定` `"app_store/app/".concat(t,"/evaluation")` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1c81148c` / `deleteMyComment` | `"delete"` `"app_store/evaluation/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppDetail` |
| `1c81148c` / `commentLikeToggle` | `"delete"` `"app_store/evaluation/".concat(t,"/like")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getCommentList`、`getAppDetail` |
| `1c81148c` / `commentLikeToggle` | `"post"` `"app_store/evaluation/".concat(t,"/like")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getCommentList`、`getAppDetail` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`seeMore: this.$router.push({name:"appList",params:{seeMore:this.appDetail.product.app_type}})`
- 旧跳转：`toAnotherApp: this.$router.push({query:l()(this.$route.query,{id:t.id})})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p016"></a>

## 应用排行榜 `/app-store/app-leaderboard`

旧版证据：[P016](27-admin-built-page-evidence.md#p016)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/app-store`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“应用排行榜”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `39a521dc` / `getList` | `未显式指定` `"app_store/ranking_list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goInner: this.$router.push({name:"appInner",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p017"></a>

## 商店应用列表 `/app-store/app-list`

旧版证据：[P017](27-admin-built-page-evidence.md#p017)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/app-store`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“商店应用列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `15fc/f4378688` | `查看更多` | `on.click → function(e){return t.seeMore(a)}` | `循环 t.pageData; e.length; 0===t.onSeeMore&&e.length>=8` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `f4378688` / `getAppList` | `未显式指定` `"app_store"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toDetail: this.$router.push({name:"appInner",query:{id:t},params:{isLogin:this.isLogin}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p018"></a>

## 我的应用 `/app-store/my-app`

旧版证据：[P018](27-admin-built-page-evidence.md#p018)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/app-store`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“我的应用”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `ad5ddace` / `changeCollection` | `"delete"` `"app_store/favorite/app/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `favorite` |
| `ad5ddace` / `myApps` | `未显式指定` `"app_store/my_apps"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `ad5ddace` / `favorite` | `未显式指定` `"app_store/favorite"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goInner: this.$router.push({name:"appInner",query:{id:e}})`
- 旧跳转：`changeTabs: this.$router.push({query:l()(this.$route.query,{type:"myCollection"})})`
- 旧跳转：`changeTabs: this.$router.push({query:l()({})})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p019"></a>

## 安装进度 `/install-progress`

旧版证据：[P019](27-admin-built-page-evidence.md#p019)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“安装进度”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6730/b63b5f32` | `qwe` | `on.click → e.qwe` | `无提取条件` |

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

<a id="p132"></a>

## 模块插件 `/module-plugin`

旧版证据：[P132](27-admin-built-page-evidence.md#p132)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“模块插件”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `62b6/d82065bc` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `插件名称 ($lang.plug_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `标识 ($lang.identification)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `作者 ($lang.author)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `版本 ($lang.versions)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `62b6/d82065bc` | `el-dialog` | `-` / `-` / `t.plInfo.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `62b6/d82065bc` | `el-form-item` | `e.title` / `""` / `-` | `循环 t.plInfo.config` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `62b6/d82065bc` | `安装` | `on.click → function(e){return t.plInstallHandleClick(n.name)}` | `scopedSlots; 3===n.status` |
| `62b6/d82065bc` | `卸载` | `on.click → function(e){return t.plUnInstallHandleClick(n.id)}` | `scopedSlots; 3!==n.status` |
| `62b6/d82065bc` | `启用 ($lang.start_using)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"enable")}` | `scopedSlots; 0===n.status` |
| `62b6/d82065bc` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"disable")}` | `scopedSlots; 1===n.status` |
| `62b6/d82065bc` | `配置` | `on.click → function(e){return t.plSettingHandleClick(n.id)}` | `scopedSlots; 3!==n.status` |
| `62b6/d82065bc` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `62b6/d82065bc` | `保存更改 ($lang.save_the_changes)` | `on.click → t.saveHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `d82065bc` / `getData` | `未显式指定` `"pl_index/".concat(t,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `d82065bc` / `plInstallHandleClick` | `"post"` `"pl_install"` (data) | `POST {A}/pl_install` → `admin/plugin/plInstall`；规则 `app\admin\controller\Plugincontroller::plinstall`；[源行](../../data/route/admin.php#L159) | `getData` |
| `d82065bc` / `plUnInstallHandleClick` | `"post"` `"pl_uninstall"` (data) | `POST {A}/pl_uninstall` → `admin/plugin/plUninstall`；规则 `app\admin\controller\Plugincontroller::pluninstall`；[源行](../../data/route/admin.php#L160) | `getData` |
| `d82065bc` / `plToggleHandleClick` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `d82065bc` / `plSettingHandleClick` | `未显式指定` `"pl_setting/addons/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `d82065bc` / `saveHandleClick` | `"post"` `"pl_setting_post"` (data) | `POST {A}/pl_setting_post` → `admin/plugin/plSettingPost`；规则 `app\admin\controller\Plugincontroller::plsettingpost`；[源行](../../data/route/admin.php#L163) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p187"></a>

## 应用列表 `/application-list`

旧版证据：[P187](27-admin-built-page-evidence.md#p187)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“应用列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6d7d/09bd50f6` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用标识` / `uuid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `昵称` / `nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用简述` / `info` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `状态` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `上架时间` / `unretired_time` / `-` | `"1"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `提交时间` / `update_time` / `-` | `"2"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `出售价格/方式` / `pay_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `收入/销量` / `count` / `-` | `"1"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6d7d/09bd50f6` | `图标/动态文案，回查原证据` | `on.click → t.getData` | `无提取条件` |
| `6d7d/09bd50f6` | `上架` | `on.click → function(e){return t.toggleRetired(r)}` | `scopedSlots; 1===r.status` |
| `6d7d/09bd50f6` | `下架` | `on.click → function(e){return t.toggleRetired(r)}` | `scopedSlots; 0===r.status` |
| `6d7d/09bd50f6` | `通过` | `on.click → function(e){return t.checkDeveloperApp(r,1)}` | `scopedSlots; 3===r.status` |
| `6d7d/09bd50f6` | `驳回` | `on.click → function(e){return t.checkDeveloperApp(r,2)}` | `scopedSlots; 3===r.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `09bd50f6` / `getData` | `未显式指定` `"developer/developerapplist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `09bd50f6` / `toggleRetired` | `"post"` `"developer/toggleretired"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `09bd50f6` / `checkApp` | `"post"` `"developer/checkdeveloperapp"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/developer",query:{id:r.uid}}`
- 旧跳转：`render router-link: {path:"application-detail",query:{id:r.id,appstatus:t.$route.query.appstatus}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p188"></a>

## 应用管理详情 `/application-detail`

旧版证据：[P188](27-admin-built-page-evidence.md#p188)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“应用管理详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9b2f/f7f0bbea` | `el-tab-pane` | `t.$lang.应用` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `9b2f/f7f0bbea` | `el-form-item` | `昵称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `手机` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `简介` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `应用名称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `应用类型` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `出售方式` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `出售价格` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `使用说明` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `版本说明` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-form-item` | `应用描述` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9b2f/f7f0bbea` | `el-tab-pane` | `交易` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `9b2f/f7f0bbea` | `el-table-column` | `交易流水号` / `trans_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `购买人` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `支付时间` / `pay_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `支付方式` / `gateway` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `支付金额` / `amount_in` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-tab-pane` | `日志` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `9b2f/f7f0bbea` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `时间` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `描述` / `desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9b2f/f7f0bbea` | `el-table-column` | `原因` / `reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9b2f/f7f0bbea` | `下架` | `on.click → t.toggleRetired` | `0===t.appInfo.product.retired&&1===t.appInfo.product.app_status` |
| `9b2f/f7f0bbea` | `上架` | `on.click → t.toggleRetired` | `1===t.appInfo.product.retired&&1===t.appInfo.product.app_status` |
| `9b2f/f7f0bbea` | `通过` | `on.click → function(e){return t.checkDeveloperApp(1)}` | `t.appInfo.product.app_status&&1!==t.appInfo.product.app_status&&2!==t.appInfo.product.app_status\|\|0===t.appInfo.product.app_status` |
| `9b2f/f7f0bbea` | `驳回` | `on.click → function(e){return t.checkDeveloperApp(2)}` | `0===t.appInfo.product.app_status` |
| `9b2f/f7f0bbea` | `返回` | `on.click → t.goBack` | `t.appInfo.product.app_status\|\|0===t.appInfo.product.app_status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `f7f0bbea` / `getAppInfoById` | `未显式指定` `"developer/developerapp"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f7f0bbea` / `deleteHandleClick` | `"delete"` `"developer/developerapp"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f7f0bbea` / `toggleRetired` | `"post"` `"developer/toggleretired"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppInfoById` |
| `f7f0bbea` / `checkApp` | `"post"` `"developer/checkdeveloperapp"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAppInfoById` |
| `f7f0bbea` / `getTransactionData` | `未显式指定` `"developer/appaccounts"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f7f0bbea` / `getLogData` | `未显式指定` `"developer/developerapplogs"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`deleteHandleClick: t.$router.push("/application-list?appstatus=1")`
- 旧跳转：`deleteHandleClick: t.$router.push("/appcheck-list?appstatus=2")`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p189"></a>

## 应用审核 `/appcheck-list`

旧版证据：[P189](27-admin-built-page-evidence.md#p189)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“应用审核”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6d7d/09bd50f6` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用标识` / `uuid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `昵称` / `nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用简述` / `info` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `应用类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `状态` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `上架时间` / `unretired_time` / `-` | `"1"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `提交时间` / `update_time` / `-` | `"2"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `出售价格/方式` / `pay_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `收入/销量` / `count` / `-` | `"1"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6d7d/09bd50f6` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6d7d/09bd50f6` | `图标/动态文案，回查原证据` | `on.click → t.getData` | `无提取条件` |
| `6d7d/09bd50f6` | `上架` | `on.click → function(e){return t.toggleRetired(r)}` | `scopedSlots; 1===r.status` |
| `6d7d/09bd50f6` | `下架` | `on.click → function(e){return t.toggleRetired(r)}` | `scopedSlots; 0===r.status` |
| `6d7d/09bd50f6` | `通过` | `on.click → function(e){return t.checkDeveloperApp(r,1)}` | `scopedSlots; 3===r.status` |
| `6d7d/09bd50f6` | `驳回` | `on.click → function(e){return t.checkDeveloperApp(r,2)}` | `scopedSlots; 3===r.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `09bd50f6` / `getData` | `未显式指定` `"developer/developerapplist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `09bd50f6` / `toggleRetired` | `"post"` `"developer/toggleretired"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `09bd50f6` / `checkApp` | `"post"` `"developer/checkdeveloperapp"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/developer",query:{id:r.uid}}`
- 旧跳转：`render router-link: {path:"application-detail",query:{id:r.id,appstatus:t.$route.query.appstatus}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p190"></a>

## 评论管理 `/comment-list`

旧版证据：[P190](27-admin-built-page-evidence.md#p190)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“评论管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `1b4c/e8967678` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `用户` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `应用名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `应用类型` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `评论语` / `content` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `星级` / `score` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `状态` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `提交时间` / `update_time` / `-` | `"2"===t.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1b4c/e8967678` | `el-dialog` | `-` / `-` / `编辑评论` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1b4c/e8967678` | `el-form-item` | `评论` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1b4c/e8967678` | `el-form-item` | `星级` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `1b4c/e8967678` | `通过` | `on.click → function(e){return t.checkComment(r,1)}` | `scopedSlots; 0===r.status` |
| `1b4c/e8967678` | `驳回` | `on.click → function(e){return t.checkComment(r,2)}` | `scopedSlots; 0===r.status` |
| `1b4c/e8967678` | `编辑` | `on.click → function(e){return t.editComment(r)}` | `scopedSlots` |
| `1b4c/e8967678` | `取 消` | `on.click → function(e){t.commentDialogVis=!1}` | `无提取条件` |
| `1b4c/e8967678` | `发布` | `on.click → t.editCommentSubmit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `e8967678` / `getData` | `未显式指定` `"developer/app_evaluations"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `e8967678` / `checkApp` | `"post"` `"developer/check_app_evaluations"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `e8967678` / `editCommentSubmit` | `"put"` `"developer/edit_app_evaluation"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p191"></a>

## 热门应用 `/hot-app`

旧版证据：[P191](27-admin-built-page-evidence.md#p191)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“热门应用”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6365/40c7c0c8` | `el-table-column` | `排序` / `app_hot_order` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `锁定状态` / `app_hot_lock` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `应用标示` / `uuid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `开发者昵称` / `nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `应用名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `应用简述` / `info` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `应用类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `提交时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `出售价格/方式` / `pay_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6365/40c7c0c8` | `el-dialog` | `-` / `-` / `编辑` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6365/40c7c0c8` | `el-form-item` | `应用标示` / `uuid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6365/40c7c0c8` | `el-form-item` | `排序` / `order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6365/40c7c0c8` | `el-form-item` | `锁定` / `lock` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6365/40c7c0c8` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6365/40c7c0c8` | `图标/动态文案，回查原证据` | `on.click → e.getData` | `无提取条件` |
| `6365/40c7c0c8` | `编辑` | `on.click → function(t){return e.editItem(a)}` | `scopedSlots` |
| `6365/40c7c0c8` | `取消` | `on.click → e.onClose` | `无提取条件` |
| `6365/40c7c0c8` | `确定` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `40c7c0c8` / `handelConfirm` | `"put"` `"developer/hot_app"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `onClose`、`getData` |
| `40c7c0c8` / `getData` | `未显式指定` `"developer/hotapplist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p192"></a>

## 推荐应用 `/highly-recommended`

旧版证据：[P192](27-admin-built-page-evidence.md#p192)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“推荐应用”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `843e3/a8de3c40` | `el-table-column` | `排序` / `app_recommend_order` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `锁定状态` / `app_recommend_lock` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `应用标识` / `uuid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `开发者昵称` / `nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `应用名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `应用简述` / `info` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `应用类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `提交时间` / `update_time` / `-` | `"2"===e.$route.query.appstatus` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `出售价格/方式` / `pay_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `843e3/a8de3c40` | `el-dialog` | `-` / `-` / `e.highFormData.id?"修改排序":"添加推荐应用"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `843e3/a8de3c40` | `el-form-item` | `应用标识` / `uuid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `843e3/a8de3c40` | `el-form-item` | `排序` / `order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `843e3/a8de3c40` | `el-form-item` | `是否锁定` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `843e3/a8de3c40` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `843e3/a8de3c40` | `添加应用` | `on.click → e.dialogVis` | `无提取条件` |
| `843e3/a8de3c40` | `图标/动态文案，回查原证据` | `on.click → e.getData` | `无提取条件` |
| `843e3/a8de3c40` | `编辑` | `on.click → function(t){return e.editCommentHandleClick(r)}` | `scopedSlots` |
| `843e3/a8de3c40` | `删除` | `on.click → function(t){return e.deleteCommentHandleClick(r)}` | `scopedSlots` |
| `843e3/a8de3c40` | `取 消` | `on.click → function(t){e.highDialog=!1}` | `无提取条件` |
| `843e3/a8de3c40` | `发布` | `on.click → e.editCommentSubmit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `a8de3c40` / `getData` | `未显式指定` `"developer/recommendapplist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `a8de3c40` / `deleteCommentHandleClick` | `"delete"` `"developer/recommend_app"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `a8de3c40` / `editCommentSubmit` | `"put"` `"developer/recommend_app"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `a8de3c40` / `editCommentSubmit` | `"post"` `"developer/recommend_app"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p201"></a>

## 扩展通知列表 `/notify_list`

旧版证据：[P201](27-admin-built-page-evidence.md#p201)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“扩展通知列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `099b/54eea020` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `099b/54eea020` | `el-table-column` | `姓名` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `099b/54eea020` | `el-table-column` | `手机号/邮箱` / `phonenumber` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `099b/54eea020` | `el-table-column` | `联系信息` / `address` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `099b/54eea020` | `el-table-column` | `最新指令` / `execute_log` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `099b/54eea020` | `el-table-column` | `上次沟通时间` / `execute_log` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `099b/54eea020` | `搜索` | `on.click → e.getTableData` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"InstructionQuery",query:{id:n.execute_log.id}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p202"></a>

## 指令查询 `/Instruction_query`

旧版证据：[P202](27-admin-built-page-evidence.md#p202)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“指令查询”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3937/4663aaab` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-table-column` | `操作` / `execute_message` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-table-column` | `时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-table-column` | `接口` / `device` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-table-column` | `状态` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-table-column` | `详情` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3937/4663aaab` | `el-dialog` | `-` / `-` / `详情` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3937/4663aaab` | `搜索` | `on.click → e.getTableData` | `无提取条件` |
| `3937/4663aaab` | `查看详情` | `on.click → function(t){return e.openDialog(n.message_log)}` | `scopedSlots; n.message_log.length` |
| `3937/4663aaab` | `取 消` | `on.click → function(t){e.dialogVisible=!1}` | `无提取条件` |
| `3937/4663aaab` | `确 定` | `on.click → function(t){e.dialogVisible=!1}` | `无提取条件` |

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

<a id="p203"></a>

## 自动回复设置 `/auto_reply_setting`

旧版证据：[P203](27-admin-built-page-evidence.md#p203)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“自动回复设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `d11d/6dd4b52c` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `作者 ($lang.author)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `当前版本 ($lang.current_version)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `插件名 ($lang.the_plugin_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `插件标题 ($lang.plug_in_title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `操作 ($lang.operation)` / `address` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `d11d/6dd4b52c` | `el-form-item` | `部署设置 ($lang.deployment_settings)` / `type` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "setting"!==e.dialog.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `机器服务地址 ($lang.service_address)` / `bot_serve_url` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "self"===e.dialogForm.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `sign_key` / `sign_key` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "self"===e.dialogForm.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `消息接收地址 ($lang.message_receiving_address)` / `bot_client_url` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "system"===e.dialogForm.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `app_id` / `app_id` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "system"===e.dialogForm.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `app_key` / `app_key` / `-` | `"install"===e.dialog.type\|\|"setting"===e.dialog.type; "system"===e.dialogForm.type` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-table-column` | `QQ号 ($lang.qq_num)` / `account` / `-` | `"account"===e.dialog.type` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `备注 ($lang.remark)` / `description` / `-` | `"account"===e.dialog.type` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-table-column` | `操作 ($lang.operation)` / `description` / `-` | `"account"===e.dialog.type` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d11d/6dd4b52c` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `d11d/6dd4b52c` | `el-form-item` | `QQ号 ($lang.qq_num)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-form-item` | `备注 ($lang.remark)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/6dd4b52c` | `el-dialog` | `-` / `-` / `登录 ($lang.login)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `d11d/950064bc` | `el-form-item` | `产品到期通知:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/950064bc` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/950064bc` | `el-form-item` | `产品续费通知:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/950064bc` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/950064bc` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `重启` / `-` / `-` | `e.formInfo.i_reboot` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_reboot` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_reboot; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_reboot; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_reboot; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `开机` / `-` / `-` | `e.formInfo.i_boot_up` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_boot_up` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_boot_up; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_boot_up; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_boot_up; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `关机` / `-` / `-` | `e.formInfo.i_shut_down` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_shut_down` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_shut_down; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_shut_down; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_shut_down; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `重装 ($lang.reinstall)` / `-` / `-` | `e.formInfo.i_reload` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_reload` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_reload; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_reload; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_reload; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `破解密码 ($lang.cracking_password)` / `-` / `-` | `e.formInfo.i_break_password` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_break_password` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_break_password; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_break_password; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_break_password; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `申请退款 ($lang.apply_refund)` / `-` / `-` | `e.formInfo.i_request_refund` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_request_refund` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_request_refund; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_request_refund; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_request_refund; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `下单 ($lang.place_the_order)` / `-` / `-` | `e.formInfo.i_place_order` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_place_order` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_place_order; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_place_order; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_place_order; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `流量查询 ($lang.traffic_query)` / `-` / `-` | `e.formInfo.i_bandwidth` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_bandwidth` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_bandwidth; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_bandwidth; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_bandwidth; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `续费机器 ($lang.renewal_machine)` / `-` / `-` | `e.formInfo.i_renew` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_renew` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_renew; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_renew; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_renew; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `带宽查询 ($lang.bandwidth_query)` / `-` / `-` | `e.formInfo.i_query_traffic` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_query_traffic` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_query_traffic; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_query_traffic; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_query_traffic; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `更换远程链接端口` / `-` / `-` | `e.formInfo.i_replace_port` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_replace_port` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `敏感操作验证 ($lang.sensitive_operation_verification)` / `-` / `-` | `e.formInfo.i_replace_port; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-switch` | `-` / `-` / `-` | `e.formInfo.i_replace_port; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `e.formInfo.i_replace_port; e.advanced` | 分组表单；未知原值不置空 |
| `d11d/11c13db9` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d11d/43f6087c` | `el-tab-pane` | `接受设置` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `d11d/43f6087c` | `el-tab-pane` | `通知设置` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `d11d/43f6087c` | `el-tab-pane` | `接口设置` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `d11d/6dd4b52c` | `" "+e._s(n.status?e.$lang.forbidden:e.$lang.start_using)+" "` | `on.click → function(t){return e.openDialog(n,"toggle")}` | `scopedSlots; 3!==n.status` |
| `d11d/6dd4b52c` | `配置 ($lang.configuration)` | `on.click → function(t){return e.openDialog(n,"setting")}` | `scopedSlots; 3!==n.status` |
| `d11d/6dd4b52c` | `卸载 ($lang.uninstall)` | `on.click → function(t){return e.openDialog(n,"uninstall")}` | `scopedSlots; 3!==n.status` |
| `d11d/6dd4b52c` | `账号管理` | `on.click → function(t){return e.openDialog(n,"account")}` | `scopedSlots; 3!==n.status` |
| `d11d/6dd4b52c` | `安装 ($lang.install)` | `on.click → function(t){return e.openDialog(n,"install")}` | `scopedSlots; else(3!==n.status)` |
| `d11d/6dd4b52c` | `添加` | `on.click → function(t){e.addBotDialogVisible=!0}` | `"account"===e.dialog.type; e.dialogForm.botList.length<3` |
| `d11d/6dd4b52c` | `登录` | `on.click → function(t){return e.loginBot(n)}` | `"account"===e.dialog.type; scopedSlots; "offline"===n.status` |
| `d11d/6dd4b52c` | `退出登录 ($lang.login_out)` | `on.click → function(t){return e.loginOutBot(n)}` | `"account"===e.dialog.type; scopedSlots; else("offline"===n.status); "online"===n.status` |
| `d11d/6dd4b52c` | `删除 ($lang.delete)` | `on.click → function(t){return e.delBot(n)}` | `"account"===e.dialog.type; scopedSlots` |
| `d11d/6dd4b52c` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialog.dialogVisible=!1}` | `"account"!==e.dialog.type` |
| `d11d/6dd4b52c` | `确定 ($lang.confirm)` | `on.click → e.submit` | `"account"!==e.dialog.type` |
| `d11d/6dd4b52c` | `取消 ($lang.cancel)` | `on.click → function(t){e.addBotDialogVisible=!1}` | `无提取条件` |
| `d11d/6dd4b52c` | `确定 ($lang.confirm)` | `on.click → e.addBotSubmit` | `无提取条件` |
| `d11d/950064bc` | `保存 ($lang.save)` | `on.click → e.changeSwitch` | `无提取条件` |
| `d11d/11c13db9` | `保存 ($lang.save)` | `on.click → e.changeSwitch` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `43f6087c` / `getSmListInfo` | `未显式指定` `"pl_index/".concat(e,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p204"></a>

## 功能模块 `/functional-module`

旧版证据：[P204](27-admin-built-page-evidence.md#p204)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“功能模块”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f3fd/722beca8` | `el-tab-pane` | `系统默认` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f3fd/722beca8` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `功能模块` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `唤起关键字` / `kerword_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `命中次数` / `match_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-tab-pane` | `自定义` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f3fd/722beca8` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `功能模块` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `唤起关键字` / `kerword_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f3fd/722beca8` | `el-table-column` | `命中次数` / `match_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f3fd/722beca8` | `搜索 ($lang.search)` | `on.click → e.changeActive` | `无提取条件` |
| `f3fd/722beca8` | `创建功能` | `on.click → function(t){return e.$router.push("add_functional_module")}` | `无提取条件` |
| `f3fd/722beca8` | `搜索 ($lang.search)` | `on.click → e.changeActive` | `无提取条件` |

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

<a id="p205"></a>

## 功能模块编辑 `/add_functional_module`

旧版证据：[P205](27-admin-built-page-evidence.md#p205)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“功能模块编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8b5e/bf777150` | `el-form-item` | `功能模块:` / `func_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b5e/bf777150` | `el-form-item` | `依赖组件:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b5e/bf777150` | `el-form-item` | `执行器模块:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8b5e/bf777150` | `el-table-column` | `类型` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b5e/bf777150` | `el-table-column` | `关键字` / `keyword` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b5e/bf777150` | `el-table-column` | `关键字匹配规则` / `matching_text_preg` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8b5e/bf777150` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8b5e/bf777150` | `保存` | `on.click → e.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: e.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p206"></a>

## 关键词管理 `/keyword-manage`

旧版证据：[P206](27-admin-built-page-evidence.md#p206)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“关键词管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9c2b/2d9c5220` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `标题` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `功能名称` / `keyword` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `匹配文本` / `matching_text` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `匹配正则` / `matching_text_preg` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-table-column` | `状态` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9c2b/2d9c5220` | `el-switch` | `-` / `-` / `-` | `scopedSlots; "general_execute"===n.type` | 分组表单；未知原值不置空 |
| `9c2b/2d9c5220` | `el-table-column` | `管理` / `matching_reply` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9c2b/2d9c5220` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeStatus(n)}` | `scopedSlots; "general_execute"===n.type` |
| `9c2b/2d9c5220` | `编辑` | `on.click → function(t){return e.$router.push({name:"AddKeywords",query:{id:n.id,isEdit:!0}})}` | `scopedSlots` |

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

<a id="p207"></a>

## 特殊回复 `/special-reply`

旧版证据：[P207](27-admin-built-page-evidence.md#p207)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“特殊回复”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `52a8/57e5d3f6` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `标题` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `匹配文本` / `matching_text` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `类型` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `匹配正则` / `matching_text_preg` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `回复(匹配到)` / `matching_reply` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a8/57e5d3f6` | `el-table-column` | `管理` / `matching_reply` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `52a8/57e5d3f6` | `创建关键字` | `on.click → function(t){return e.$router.push({name:"AddKeywords",query:{type:"special"}})}` | `无提取条件` |
| `52a8/57e5d3f6` | `编辑` | `on.click → function(t){return e.$router.push({name:"AddKeywords",query:{id:n.id,isEdit:!0,type:"special"}})}` | `scopedSlots` |
| `52a8/57e5d3f6` | `删除` | `on.click → function(t){return e.delBtn(n)}` | `scopedSlots` |

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

<a id="p208"></a>

## 关键词编辑 `/add_keywords`

旧版证据：[P208](27-admin-built-page-evidence.md#p208)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“关键词编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7ec9/f6bbb476` | `el-form-item` | `标题` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `功能名称` / `keyword` / `-` | `"special"!==e.$route.query.type` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `匹配文本` / `matching_text` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `匹配正则` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `类型` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `匹配成功文案` / `matching_reply` / `-` | `"special"===e.$route.query.type` | 分组表单；未知原值不置空 |
| `7ec9/f6bbb476` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7ec9/f6bbb476` | `保存 ($lang.save)` | `on.click → e.saveKeywords` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`saveKeywords: e.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p209"></a>

## 知识分类 `/cate-management`

旧版证据：[P209](27-admin-built-page-evidence.md#p209)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“知识分类”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7dff/1d2e0f8f` | `el-table-column` | `分类名称` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7dff/1d2e0f8f` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7dff/1d2e0f8f` | `el-dialog` | `-` / `-` / `t.editFlag?"编辑分类":"创建分类"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `7dff/1d2e0f8f` | `el-form-item` | `分类名称` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7dff/1d2e0f8f` | `el-form-item` | `分类类型` / `link_type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7dff/1d2e0f8f` | `el-form-item` | `关键字` / `keyword` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7dff/1d2e0f8f` | `创建分类` | `on.click → t.createCate` | `无提取条件` |
| `7dff/1d2e0f8f` | `添加` | `on.click → function(e){return t.addCate(n)}` | `scopedSlots` |
| `7dff/1d2e0f8f` | `编辑` | `on.click → function(e){return t.editCate(n)}` | `scopedSlots` |
| `7dff/1d2e0f8f` | `确 定` | `on.click → t.createCateSubmit` | `无提取条件` |
| `7dff/1d2e0f8f` | `取 消` | `on.click → t.handleClose` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1d2e0f8f` / `editCate` | `"get"` `"link_cause/edit"` (params) | `GET {A}/link_cause/edit` → `admin/LinkCause/edit`；规则 `app\admin\controller\LinkCausecontroller::edit`；[源行](../../data/route/admin.php#L880) | 未提取；新设计明确成功后重读受影响对象 |
| `1d2e0f8f` / `addCate` | `"get"` `"link_cause/create"` (params) | `GET {A}/link_cause/create` → `admin/LinkCause/create`；规则 `app\admin\controller\LinkCausecontroller::create`；[源行](../../data/route/admin.php#L882) | 未提取；新设计明确成功后重读受影响对象 |
| `1d2e0f8f` / `getData` | `"get"` `"link_cause/list"` (params) | `GET {A}/link_cause/list` → `admin/LinkCause/index`；规则 `app\admin\controller\LinkCausecontroller::index`；[源行](../../data/route/admin.php#L879) | 未提取；新设计明确成功后重读受影响对象 |
| `1d2e0f8f` / `createCateSubmit` | `"post"` `"link_cause/save"` (data) | `POST {A}/link_cause/save` → `admin/LinkCause/save`；规则 `app\admin\controller\LinkCausecontroller::save`；[源行](../../data/route/admin.php#L881) | `handleClose`、`getData` |
| `1d2e0f8f` / `createCateSubmit` | `"post"` `"link_cause/add"` (data) | `POST {A}/link_cause/add` → `admin/LinkCause/add`；规则 `app\admin\controller\LinkCausecontroller::add`；[源行](../../data/route/admin.php#L883) | `handleClose`、`getData` |
| `1d2e0f8f` / `createCate` | `"get"` `"link_cause/create"` (params) | `GET {A}/link_cause/create` → `admin/LinkCause/create`；规则 `app\admin\controller\LinkCausecontroller::create`；[源行](../../data/route/admin.php#L882) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p210"></a>

## 扩展知识库 `/knowledge-base`

旧版证据：[P210](27-admin-built-page-evidence.md#p210)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“扩展知识库”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `cc46/4987f698` | `el-table-column` | `标题` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cc46/4987f698` | `el-table-column` | `分类` / `level_view_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cc46/4987f698` | `el-table-column` | `关键字` / `keywords` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cc46/4987f698` | `el-table-column` | `类型` / `type_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cc46/4987f698` | `el-table-column` | `管理` / `address` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cc46/4987f698` | `el-dialog` | `-` / `-` / `e.editFlag?"编辑知识库":"创建知识库"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `cc46/4987f698` | `el-form-item` | `标题` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `cc46/4987f698` | `el-form-item` | `分类` / `link_cause` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `cc46/4987f698` | `el-form-item` | `关键字` / `keyword` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `cc46/4987f698` | `el-form-item` | `类型` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `cc46/4987f698` | `el-form-item` | `回复` / `reply` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `cc46/4987f698` | `创建知识库` | `on.click → e.createCate` | `无提取条件` |
| `cc46/4987f698` | `编辑` | `on.click → function(t){return e.editRow(n)}` | `scopedSlots` |
| `cc46/4987f698` | `删除` | `on.click → function(t){return e.deleteRow(n)}` | `scopedSlots` |
| `cc46/4987f698` | `确 定` | `on.click → e.createCateSubmit` | `无提取条件` |
| `cc46/4987f698` | `取 消` | `on.click → e.handleClose` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4987f698` / `editRow` | `"get"` `"link_cause/list"` (params) | `GET {A}/link_cause/list` → `admin/LinkCause/index`；规则 `app\admin\controller\LinkCausecontroller::index`；[源行](../../data/route/admin.php#L879) | 未提取；新设计明确成功后重读受影响对象 |
| `4987f698` / `editRow` | `"get"` `"link_knowledge/edit"` (params) | `GET {A}/link_knowledge/edit` → `admin/LinkKnowledge/edit`；规则 `app\admin\controller\LinkKnowledgecontroller::edit`；[源行](../../data/route/admin.php#L886) | 未提取；新设计明确成功后重读受影响对象 |
| `4987f698` / `deleteRow` | `"get"` `"link_knowledge/delete"` (params) | `GET {A}/link_knowledge/delete` → `admin/LinkKnowledge/delete`；规则 `app\admin\controller\LinkKnowledgecontroller::delete`；[源行](../../data/route/admin.php#L890) | `getData` |
| `4987f698` / `getData` | `"get"` `"link_knowledge/list"` (params) | `GET {A}/link_knowledge/list` → `admin/LinkKnowledge/index`；规则 `app\admin\controller\LinkKnowledgecontroller::index`；[源行](../../data/route/admin.php#L885) | 未提取；新设计明确成功后重读受影响对象 |
| `4987f698` / `createCate` | `"get"` `"link_knowledge/create"` (params) | `GET {A}/link_knowledge/create` → `admin/LinkKnowledge/create`；规则 `app\admin\controller\LinkKnowledgecontroller::create`；[源行](../../data/route/admin.php#L888) | 未提取；新设计明确成功后重读受影响对象 |
| `4987f698` / `createCate` | `"get"` `"link_cause/list"` (params) | `GET {A}/link_cause/list` → `admin/LinkCause/index`；规则 `app\admin\controller\LinkCausecontroller::index`；[源行](../../data/route/admin.php#L879) | 未提取；新设计明确成功后重读受影响对象 |
| `4987f698` / `createCateSubmit` | `"post"` `"link_knowledge/save"` (data) | `POST {A}/link_knowledge/save` → `admin/LinkKnowledge/save`；规则 `app\admin\controller\LinkKnowledgecontroller::save`；[源行](../../data/route/admin.php#L887) | `handleClose`、`getData` |
| `4987f698` / `createCateSubmit` | `"post"` `"link_knowledge/add"` (data) | `POST {A}/link_knowledge/add` → `admin/LinkKnowledge/add`；规则 `app\admin\controller\LinkKnowledgecontroller::add`；[源行](../../data/route/admin.php#L889) | `handleClose`、`getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p211"></a>

## 插件管理容器 `/plug-management`

旧版证据：[P211](27-admin-built-page-evidence.md#p211)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 `/plug-management/plug-export`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“插件管理容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

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

<a id="p212"></a>

## 插件导出 `/plug-management/plug-export`

旧版证据：[P212](27-admin-built-page-evidence.md#p212)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/plug-management`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“插件导出”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2992/336957a5` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2992/336957a5` | `el-table-column` | `导出列表名称 ($lang.export_list_name)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2992/336957a5` | `el-table-column` | `导出选项 ($lang.export_option)` / `subtotal` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2992/336957a5` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2992/336957a5` | `el-dialog` | `-` / `-` / `新增导出项` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `2992/336957a5` | `el-form-item` | `导出列表名称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2992/336957a5` | `el-form-item` | `导出选项名称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2992/336957a5` | `新增导出项 ($lang.add_export_items)` | `on.click → function(e){t.dialogFormVisible=!0}` | `无提取条件` |
| `2992/336957a5` | `导出 ($lang.export)` | `on.click → function(n){t.editBillHandleClick(e.row.id,e.row.uid)}` | `scopedSlots` |
| `2992/336957a5` | `编辑 ($lang.edit)` | `on.click → function(n){t.editBillHandleClick(e.row.id,e.row.uid)}` | `scopedSlots` |
| `2992/336957a5` | `确 定` | `on.click → function(e){t.dialogFormVisible=!1}` | `无提取条件` |
| `2992/336957a5` | `取 消` | `on.click → function(e){t.dialogFormVisible=!1}` | `无提取条件` |

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
