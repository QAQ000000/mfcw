# 系统设置、内容与通知逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [邮件日志详情兼容入口](#p006) `/email-log-detail1` | `detail` | 路由 factory 指向模块 |
| [邮件预览](#p008) `/email-preview` | `preview` | 路由 factory 指向模块 |
| [系统升级](#p010) `/system-updata` | `detail` | 路由 factory 指向模块 |
| [站点基础信息](#p021) `/base-info` | `form` | 路由 factory 指向模块 |
| [主题模板](#p022) `/theme-template` | `form` | 路由 factory 指向模块 |
| [注册登录设置](#p023) `/login-register` | `form` | 路由 factory 指向模块 |
| [二次验证设置](#p025) `/twice-confirm` | `form` | 路由 factory 指向模块 |
| [第三方登录](#p026) `/third-login` | `list` | 路由 factory 指向模块 |
| [基础设置容器](#p047) `/set` | `shell` | 未定位组件 |
| [新闻列表](#p076) `/news-list` | `list` | 路由 factory 指向模块 |
| [新闻编辑](#p077) `/add-news` | `editor` | 路由 factory 指向模块 |
| [新闻分类](#p078) `/news-category` | `list` | 路由 factory 指向模块 |
| [帮助列表](#p079) `/help-list` | `list` | 路由 factory 指向模块 |
| [帮助编辑](#p080) `/add-help` | `editor` | 路由 factory 指向模块 |
| [帮助分类](#p081) `/help-category` | `list` | 路由 factory 指向模块 |
| [官网自定义字段](#p082) `/custom-template-fields` | `list` | 路由 factory 指向模块 |
| [官网自定义字段编辑](#p083) `/add-custom-template-fields` | `form` | 路由 factory 指向模块 |
| [通知模板容器](#p084) `/sms-template` | `shell` | 未定位组件 |
| [短信模板](#p085) `/sms-template/sms` | `list` | 路由 factory 指向模块 |
| [邮件模板](#p086) `/sms-template/email` | `list` | 路由 factory 指向模块 |
| [短信模板兼容入口](#p087) `/sms-template-index` | `list` | 路由 factory 指向模块 |
| [短信模板编辑](#p088) `/sms-create-template` | `editor` | 路由 factory 指向模块 |
| [通知发送设置](#p089) `/sms-send-settings` | `form` | 路由 factory 指向模块 |
| [系统日志](#p090) `/system-log` | `log` | 路由 factory 指向模块 |
| [站内信日志](#p091) `/station-letter-log` | `log` | 路由 factory 指向模块 |
| [管理员登录日志](#p092) `/system-admin-log` | `log` | 路由 factory 指向模块 |
| [通知日志](#p093) `/inform-log` | `log` | 路由 factory 指向模块 |
| [邮件日志](#p094) `/email-log` | `log` | 路由 factory 指向模块 |
| [短信日志](#p095) `/sms-log` | `log` | 路由 factory 指向模块 |
| [API 日志](#p096) `/api-log` | `log` | 路由 factory 指向模块 |
| [日志清理](#p097) `/log-cleanup` | `form` | 路由 factory 指向模块 |
| [定时任务日志](#p098) `/automatic-task-log` | `log` | 路由 factory 指向模块 |
| [系统状态](#p099) `/system-message` | `detail` | 路由 factory 指向模块 |
| [PHP 信息](#p100) `/php-message` | `detail` | 路由 factory 指向模块 |
| [数据库状态](#p101) `/database-message` | `detail` | 路由 factory 指向模块 |
| [数据迁移](#p102) `/data-migration` | `wizard` | 路由 factory 指向模块 |
| [关于系统](#p103) `/about` | `detail` | 路由 factory 指向模块 |
| [常规设置容器](#p104) `/general-settings` | `shell` | 未定位组件 |
| [常规基础设置](#p105) `/general-settings/general` | `form` | 路由 factory 指向模块 |
| [本地化设置](#p106) `/general-settings/local` | `form` | 路由 factory 指向模块 |
| [支持设置](#p107) `/general-settings/support` | `form` | 路由 factory 指向模块 |
| [推介设置](#p108) `/general-settings/promote` | `form` | 路由 factory 指向模块 |
| [安全设置](#p109) `/general-settings/safe` | `form` | 路由 factory 指向模块 |
| [其他设置](#p110) `/general-settings/other` | `form` | 路由 factory 指向模块 |
| [账单设置](#p111) `/general-settings/invoice` | `form` | 路由 factory 指向模块 |
| [登录设置](#p112) `/general-settings/login-setting` | `form` | 路由 factory 指向模块 |
| [验证码设置](#p113) `/general-settings/captcha` | `form` | 路由 factory 指向模块 |
| [财务设置](#p114) `/general-settings/finance` | `form` | 路由 factory 指向模块 |
| [订单设置](#p115) `/general-settings/order` | `form` | 路由 factory 指向模块 |
| [分类设置](#p116) `/general-settings/class` | `form` | 路由 factory 指向模块 |
| [资源 API 设置](#p117) `/general-settings/source-api` | `form` | 路由 factory 指向模块 |
| [二次验证兼容入口](#p118) `/second` | `form` | 路由 factory 指向模块 |
| [员工管理](#p121) `/admin-management` | `list` | 路由 factory 指向模块 |
| [员工编辑](#p122) `/admin-edit` | `form` | 路由 factory 指向模块 |
| [黑名单](#p123) `/black-list` | `list` | 路由 factory 指向模块 |
| [邮件模板管理](#p124) `/email-list` | `list` | 路由 factory 指向模块 |
| [邮件模板编辑](#p125) `/email-edit` | `editor` | 路由 factory 指向模块 |
| [分组权限](#p127) `/permissions-managment` | `list` | 路由 factory 指向模块 |
| [权限组编辑](#p128) `/permissions-edit` | `form` | 路由 factory 指向模块 |
| [自动任务设置](#p129) `/automatic-tasks` | `form` | 路由 factory 指向模块 |
| [定时任务状态](#p130) `/timing-results` | `log` | 路由 factory 指向模块 |
| [官网设置](#p172) `/official-setting` | `form` | 路由 factory 指向模块 |
| [导航管理](#p173) `/menu_manage` | `detail` | chunk 内候选，页面归属待人工确认 |
| [导航编辑](#p174) `/create_menu` | `form` | 路由 factory 指向模块 |
| [官网导航编辑](#p175) `/create_menu_www` | `form` | 路由 factory 指向模块 |
| [友情链接](#p176) `/friendly_link` | `list` | 路由 factory 指向模块 |
| [营销推送](#p177) `/marketing-push` | `wizard` | 路由 factory 指向模块 |
| [通知内容编辑](#p178) `/message-write` | `editor` | 路由 factory 指向模块 |
| [文件分组](#p181) `/file` | `list` | 路由 factory 指向模块 |

<a id="p006"></a>

## 邮件日志详情兼容入口 `/email-log-detail1`

旧版证据：[P006](27-admin-built-page-evidence.md#p006)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“邮件日志详情兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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
| `87ab41c6` / `getEmailDetail` | `未显式指定` `"log_record/emaildetail/"+e` (无显式 data/params) | `GET {A}/log_record/emaildetail/:id` → `admin/log_record/getEmailDetail`；规则 `app\admin\controller\LogRecordcontroller::getemaildetail`；[源行](../../data/route/admin.php#L626) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p008"></a>

## 邮件预览 `/email-preview`

旧版证据：[P008](27-admin-built-page-evidence.md#p008)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：对象标题与返回 → 隔离的预览正文；模板变量/缺失数据提示位于正文之外，禁止因预览自动发送通知或保存配置。

**手机排版**：正文自适应，长链接换行；预览内部表格独立滚动，退出预览返回原编辑上下文。

**本页专项约束**：围绕“邮件预览”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p010"></a>

## 系统升级 `/system-updata`

旧版证据：[P010](27-admin-built-page-evidence.md#p010)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“系统升级”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `cf23/1d3a1540` | `立刻升级 ($lang.upgrade_immediately)` | `on.click → e.updateHandleClick` | `e.active` |
| `cf23/1d3a1540` | `访问后台 ($lang.visit_the_background)` | `on.click → function(t){return e.$router.push("home-page")}` | `else(e.active); "banner5"==e.bannerNum` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1d3a1540` / `updateHandleClick` | `"POST"` `"upgrade/checkupdateunzip"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `loop` |
| `1d3a1540` / `upData` | `"POST"` `"upgrade/checkupdatecopy"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1d3a1540` / `getCheckUpdateReq` | `未显式指定` `"upgrade/checkautoupdate"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `upData` |
| `1d3a1540` / `getCheckUpdateReq` | `未显式指定` `"/upgrade/sqlupdate"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `upData` |
| `1d3a1540` / `生命周期:created` | `未显式指定` `"system/updatecontent"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p021"></a>

## 站点基础信息 `/base-info`

旧版证据：[P021](27-admin-built-page-evidence.md#p021)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：基础联系信息、品牌图、SEO、嵌入内容分组；外部脚本/头尾内容采用明确的可信边界。选择上传不等于配置保存成功，保存后重读。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `323d/30d7fb16` | `el-form-item` | `Logo 地址1(登录页) ($lang.logo_address_login_page)` / `logo_url` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `Logo 地址2(登录页) ($lang.logo_address_login_page_2)` / `logo_url_home` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `Logo 地址3(客户中心缩略图) ($lang.logo_address_login_page_3)` / `logo_url_home` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `Logo 地址4(账单详情页) ($lang.logo_address_login_page_4)` / `logo_url_home` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `登录页描述 ($lang.login_page_description)` / `custom_login_background_description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `公司邮箱 ($lang.company_mail)` / `company_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `隐私条款地址 ($lang.privacy_policy_address)` / `privacy_clause_url` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `服务条款地址 ($lang.privacy_service_address)` / `server_clause_url` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `应用说明 ($lang.app_specification)` / `cart_product_description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `登录页名称 ($lang.login_page_name)` / `custom_login_background_char` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `背景图地址(客户中心注册登录页) ($lang.background_img_site)` / `custom_login_background_img` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/30d7fb16` | `el-form-item` | `登录加密模板 ($lang.login_encrypt_template)` / `allow_new_login_template` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-tab-pane` | `官网 ($lang.official_website)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `323d/472d63b4` | `el-tab-pane` | `会员中心 ($lang.member_center)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `323d/472d63b4` | `el-form-item` | `手机 ($lang.cellphone)` / `main_phone` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `qq` / `company_qq` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `地址 ($lang.address)` / `main_address` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `备案号 ($lang.internet_content_provider)` / `record_no` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `坐标 ($lang.coordinate)` / `map` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `官网LOGO ($lang.official_website_logo)` / `www_logo` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `关键字 ($lang.keyword)` / `seo_keywords` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `描述 ($lang.describe)` / `seo_desc` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `公司简介 ($lang.company_profile_us)` / `company_profile` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `头部 ($lang.head)` / `header` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `底部 ($lang.bottom)` / `footer` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `是否开启登录页头底部 ($lang.whether_open_head_bottom)` / `login_header_footer` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-switch` | `-` / `-` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `登录页头部 ($lang.Login_page_header)` / `login_header` / `-` | `"official"===e.activeName; "1"===e.generalFormData.login_header_footer` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `登录页底部 ($lang.Login_page_bottom)` / `login_footer` / `-` | `"official"===e.activeName; "1"===e.generalFormData.login_header_footer` | 分组表单；未知原值不置空 |
| `323d/472d63b4` | `el-form-item` | `挂件 ($lang.pendant)` / `web_widgets` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `323d/472d63b4` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `323d/472d63b4` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `30d7fb16` / `getLoginConfig` | `未显式指定` `"config_general/new_login"` (无显式 data/params) | `GET {A}/config_general/new_login` → `admin/config_general/getNewLoginPage`；规则 `app\admin\controller\ConfigGeneralcontroller::getnewloginpage`；[源行](../../data/route/admin.php#L301)<br>`POST {A}/config_general/new_login` → `admin/config_general/postNewLoginPage`；规则 `app\admin\controller\ConfigGeneralcontroller::postnewloginpage`；[源行](../../data/route/admin.php#L302) | 未提取；新设计明确成功后重读受影响对象 |
| `30d7fb16` / `submitForm` | `"post"` `"config_general/new_login"` (data) | `POST {A}/config_general/new_login` → `admin/config_general/postNewLoginPage`；规则 `app\admin\controller\ConfigGeneralcontroller::postnewloginpage`；[源行](../../data/route/admin.php#L302) | `getData` |
| `30d7fb16` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `30d7fb16` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getLoginConfig` |
| `472d63b4` / `getData` | `未显式指定` `"config_general/general"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `472d63b4` / `submitOfficial` | `"post"` `"config_general/general"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p022"></a>

## 主题模板 `/theme-template`

旧版证据：[P022](27-admin-built-page-evidence.md#p022)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：官网、客户中心、购物车按独立主题配置记录；预览与正式选择分离，新后台不是clientarea主题。目录名由接口枚举，不把admin_default_theme当作已实现的新SPA切换开关。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3508/0009a15f` | `el-form-item` | `选择主题模板样式： ($lang.select_theme_template_style)` / `clientarea_default_themes` / `-` | `"menber"===e.activeName` | 分组表单；未知原值不置空 |
| `3508/0009a15f` | `el-form-item` | `选择主题模板样式： ($lang.select_theme_template_style)` / `order_page_style` / `-` | `else("menber"===e.activeName); "shoppingCart"===e.activeName` | 分组表单；未知原值不置空 |
| `3508/4274c558` | `el-tab-pane` | `官网 ($lang.official_website)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3508/4274c558` | `el-tab-pane` | `会员中心 ($lang.member_center)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3508/4274c558` | `el-tab-pane` | `购物车 ($lang.shopping_trolley)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3508/4274c558` | `el-form-item` | `是否开启主题模板： ($lang.whether_open_theme_template)` / `is_themes` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `3508/4274c558` | `el-switch` | `-` / `-` / `-` | `"official"===e.activeName` | 分组表单；未知原值不置空 |
| `3508/4274c558` | `el-form-item` | `选择主题模板样式： ($lang.select_theme_template_style)` / `themes_templates` / `-` | `"official"===e.activeName; "1"===e.templateFrom.is_themes` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3508/4274c558` | `获取更多主题` | `on.click → e.toMoreTheme` | `无提取条件` |
| `3508/4274c558` | `保存更改` | `on.click → e.submitForm` | `无提取条件` |
| `3508/4274c558` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0009a15f` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `0009a15f` / `getData` | `"post"` `"config_general/getConfigOption"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0009a15f` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4274c558` / `submitOfficial` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getOptions`、`getData` |
| `4274c558` / `getOptions` | `"post"` `"config_general/getConfigOption"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4274c558` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p023"></a>

## 注册登录设置 `/login-register`

旧版证据：[P023](27-admin-built-page-evidence.md#p023)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：区分前台注册登录规则与后台/login；电话/邮箱注册、验证码和资料必填项分组，配置变化后重读；本页不用于管理员登录。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3f8c8/2fe73301` | `el-tab-pane` | `基础设置 ($lang.basic)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3f8c8/2fe73301` | `el-form-item` | `""` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-form-item` | `客户注册 ($lang.customer_registration)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-form-item` | `客户登录 ($lang.customer_login)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-form-item` | `邮箱注册是否需要验证 ($lang.mailbox_registration_needs_validated)` / `allow_email_register_code` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f8c8/2fe73301` | `el-tab-pane` | `注册时选填字段 ($lang.optional_fields_for_registration)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3f8c8/2fe73301` | `el-form-item` | `注册时选填字段 ($lang.optional_fields_for_registration)` / `clients_profoptional` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3f8c8/2fe73301` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `3f8c8/2fe73301` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2fe73301` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `2fe73301` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2fe73301` / `getData` | `"post"` `"config_general/getConfigOption"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p025"></a>

## 二次验证设置 `/twice-confirm`

旧版证据：[P025](27-admin-built-page-evidence.md#p025)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：前台和后台独立设置验证动作与渠道，动作取服务端清单；二次验证不是一般危险操作确认弹窗。关闭或改变渠道后的恢复路径须验收。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2b45/59d58c23` | `el-tab-pane` | `前台二次验证开启 ($lang.foreground_secondary_verification_enabled)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `2b45/59d58c23` | `el-form-item` | `会员中心开启二次验证： ($lang.membership_center_open_secondary_verification)` / `second_verify_home` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-form-item` | `验证方式 ($lang.verify_way)` / `second_verify_action_home_type` / `-` | `"1"===e.forwardForm.second_verify_home` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-form-item` | `客户相关 ($lang.customer_relat)` / `second_verify_action_home` / `-` | `"1"===e.forwardForm.second_verify_home` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-form-item` | `产品/服务 ($lang.product_service)` / `second_verify_action_home` / `-` | `"1"===e.forwardForm.second_verify_home` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-tab-pane` | `后台二次验证开启 ($lang.backstage_secondary_validation_enable)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `2b45/59d58c23` | `el-form-item` | `后台二次验证是否开启 ($lang.background_secondary_verification_whether_open)` / `second_verify_admin` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2b45/59d58c23` | `el-form-item` | `-` / `second_verify_action_admin` / `-` | `"1"===e.backForm.second_verify_admin` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2b45/59d58c23` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `2b45/59d58c23` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `59d58c23` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `59d58c23` / `submitApi` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getOptions`、`getData` |
| `59d58c23` / `getOptions` | `"post"` `"config_general/getConfigOption"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `59d58c23` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p026"></a>

## 第三方登录 `/third-login`

旧版证据：[P026](27-admin-built-page-evidence.md#p026)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“第三方登录”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f957/495b0d15` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `开发者 ($lang.developer)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `当前版本 ($lang.current_version)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `最新版本 ($lang.latest_version)` / `app_version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f957/495b0d15` | `el-dialog` | `-` / `-` / `配置 ($lang.configuration)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `f957/495b0d15` | `el-form-item` | `n` / `""` / `-` | `循环 t.configs` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f957/495b0d15` | `获取更多接口` | `on.click → t.jumpUrl` | `无提取条件` |
| `f957/495b0d15` | `安装 ($lang.install)` | `on.click → function(e){return t.setItem(n)}` | `scopedSlots; 3==n.status` |
| `f957/495b0d15` | `启用 ($lang.start_using)` | `on.click → function(e){return t.suspend(n)}` | `scopedSlots; 0==n.status` |
| `f957/495b0d15` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.suspend(n)}` | `scopedSlots; 1==n.status` |
| `f957/495b0d15` | `卸载 ($lang.uninstall)` | `on.click → function(e){return t.setItem(n)}` | `scopedSlots; 3!==n.status` |
| `f957/495b0d15` | `配置 ($lang.configuration)` | `on.click → function(e){return t.config(n)}` | `scopedSlots; 1==n.status` |
| `f957/495b0d15` | `更新 ($lang.update)` | `on.click → function(e){return t.handleUpdate(n)}` | `scopedSlots; 3!==n.status&&1==n.update_btn&&1==n.update_disable` |
| `f957/495b0d15` | `更新 ($lang.update)` | `on.click → function(e){return t.handleUpdate(n)}` | `scopedSlots; else(3!==n.status&&1==n.update_btn&&1==n.update_disable); 3!==n.status&&1==n.update_btn` |
| `f957/495b0d15` | `取消 ($lang.cancel)` | `on.click → t.cancel` | `无提取条件` |
| `f957/495b0d15` | `确定 ($lang.confirm)` | `on.click → t.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `495b0d15` / `handleUpdate` | `"post"` `"pl_update"` (data) | `POST {A}/pl_update` → `admin/plugin/plUpdate`；规则 `app\admin\controller\Plugincontroller::plupdate`；[源行](../../data/route/admin.php#L165) | `getOauth`、`getOauthConfig` |
| `495b0d15` / `setItem` | `"post"` `"oauth/active"` (data) | `POST {A}/oauth/active` → `admin/oauth/active`；规则 `app\admin\controller\Oauthcontroller::active`；[源行](../../data/route/admin.php#L167) | `getOauth`、`getOauthConfig` |
| `495b0d15` / `submit` | `"post"` `"oauth/config_post"` (data) | `POST {A}/oauth/config_post` → `admin/oauth/configSave`；规则 `app\admin\controller\Oauthcontroller::configsave`；[源行](../../data/route/admin.php#L169) | `getOauth`、`getOauthConfig` |
| `495b0d15` / `getOauthConfig` | `未显式指定` `"oauth/config"` (无显式 data/params) | `GET {A}/oauth/config` → `admin/oauth/config`；规则 `app\admin\controller\Oauthcontroller::config`；[源行](../../data/route/admin.php#L168) | 未提取；新设计明确成功后重读受影响对象 |
| `495b0d15` / `suspend` | `"post"` `"oauth/suspend"` (data) | `POST {A}/oauth/suspend` → `admin/oauth/suspend`；规则 `app\admin\controller\Oauthcontroller::suspend`；[源行](../../data/route/admin.php#L170) | `getOauth` |
| `495b0d15` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |
| `495b0d15` / `getOauth` | `未显式指定` `"oauth"` (无显式 data/params) | `GET {A}/oauth` → `admin/oauth/listing`；规则 `app\admin\controller\Oauthcontroller::listing`；[源行](../../data/route/admin.php#L166) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p047"></a>

## 基础设置容器 `/set`

旧版证据：[P047](27-admin-built-page-evidence.md#p047)；归属：未定位组件。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/`；默认重定向 `customer-custom`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“基础设置容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p076"></a>

## 新闻列表 `/news-list`

旧版证据：[P076](27-admin-built-page-evidence.md#p076)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“新闻列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e147/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e147/-` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e147/-` | `el-table-column` | `分类 ($lang.classify)` / `parent.title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e147/-` | `el-table-column` | `发布时间 ($lang.publish_time)` / `push_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e147/-` | `el-table-column` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e147/-` | `el-table-column` | `管理 ($lang.management)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e147/-` | `添加新闻 ($lang.add_journalism)` | `on.click → t.toAdd` | `无提取条件` |
| `e147/-` | `编辑` | `on.click → function(n){return t.toEdit(e.row)}` | `scopedSlots` |
| `e147/-` | `删除` | `on.click → function(n){return t.delNews(e.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"news/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `delNews` | `"delete"` `"news/content"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"addNews",query:{id:a.id}}`
- 旧跳转：`toAdd: this.$router.push({name:"addNews"})`
- 旧跳转：`toEdit: this.$router.push({name:"addNews",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p077"></a>

## 新闻编辑 `/add-news`

旧版证据：[P077](27-admin-built-page-evidence.md#p077)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 名称/分类等基础字段 → 正文编辑器 → 变量/附件与预览 → 保存区。预览与提交分开，预览内容不执行非可信脚本。

**手机排版**：基础字段单列，正文占满内容宽；编辑工具可横向滚动，预览独立展示并保留返回草稿。

**本页专项约束**：围绕“新闻编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7100/-` | `el-form-item` | `新闻标题 ($lang.journalism_title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `分类 ($lang.classify)` / `parent_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `是否隐藏 ($lang.whether_to_hide)` / `hidden` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `日期选择 ($lang.date_selection)` / `push_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `标签 ($lang.tag)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `描述 ($lang.describe)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7100/-` | `el-form-item` | `文章内容 ($lang.contents_article)` / `push_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7100/-` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `7100/-` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `7100/-` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `submitForm` | `"post"` `"news/editcontent"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getCategory` | `未显式指定` `"news/catelist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getData` | `未显式指定` `"news/content"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `HTMLDecode` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"news-category"}`
- 旧跳转：`submitForm: e.$router.push({name:"newsList"})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p078"></a>

## 新闻分类 `/news-category`

旧版证据：[P078](27-admin-built-page-evidence.md#p078)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“新闻分类”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `52a5/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a5/-` | `el-table-column` | `分类名称 ($lang.classify_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a5/-` | `el-table-column` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a5/-` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `52a5/-` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `52a5/-` | `添加分类 ($lang.add_classify)` | `on.click → t.toAdd` | `无提取条件` |
| `52a5/-` | `编辑 ($lang.edit)` | `on.click → function(a){return t.editCategory(e.row)}` | `scopedSlots` |
| `52a5/-` | `删除 ($lang.delete)` | `on.click → function(a){return t.delCategory(e.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `bmVerify` | `"get"` `"news/checkalias"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getData` | `未显式指定` `"news/catspage"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `handelConfirm` | `"post"` `"news/editcat"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData`、`close` |
| `-` / `delCategory` | `"delete"` `"news/cat"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p079"></a>

## 帮助列表 `/help-list`

旧版证据：[P079](27-admin-built-page-evidence.md#p079)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“帮助列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5839/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5839/-` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5839/-` | `el-table-column` | `分类 ($lang.classify)` / `parent.title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5839/-` | `el-table-column` | `发布时间 ($lang.publish_time)` / `push_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5839/-` | `el-table-column` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5839/-` | `el-table-column` | `管理 ($lang.manage)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5839/-` | `添加帮助 ($lang.add_help)` | `on.click → t.toAdd` | `无提取条件` |
| `5839/-` | `编辑` | `on.click → function(n){return t.toEdit(e.row)}` | `scopedSlots` |
| `5839/-` | `删除` | `on.click → function(n){return t.delNews(e.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"news/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `delNews` | `"delete"` `"news/content"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"addHelp",query:{id:a.id}}`
- 旧跳转：`toAdd: this.$router.push({name:"addHelp"})`
- 旧跳转：`toEdit: this.$router.push({name:"addHelp",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p080"></a>

## 帮助编辑 `/add-help`

旧版证据：[P080](27-admin-built-page-evidence.md#p080)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 名称/分类等基础字段 → 正文编辑器 → 变量/附件与预览 → 保存区。预览与提交分开，预览内容不执行非可信脚本。

**手机排版**：基础字段单列，正文占满内容宽；编辑工具可横向滚动，预览独立展示并保留返回草稿。

**本页专项约束**：围绕“帮助编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5112/-` | `el-form-item` | `帮助标题 ($lang.help_title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `分类 ($lang.classify)` / `parent_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `是否隐藏 ($lang.whether_to_hide)` / `hidden` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `日期选择 ($lang.date_selection)` / `push_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `标签 ($lang.tag)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `描述 ($lang.describe)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5112/-` | `el-form-item` | `文章内容 ($lang.contents_article)` / `push_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5112/-` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `5112/-` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `5112/-` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `submitForm` | `"post"` `"news/editcontent"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getCategory` | `未显式指定` `"news/catelist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getData` | `未显式指定` `"news/content"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `HTMLDecode` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.push({name:"helpList"})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p081"></a>

## 帮助分类 `/help-category`

旧版证据：[P081](27-admin-built-page-evidence.md#p081)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“帮助分类”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3b00/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3b00/-` | `el-table-column` | `分类名称 ($lang.classify_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3b00/-` | `el-table-column` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3b00/-` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `3b00/-` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3b00/-` | `添加分类 ($lang.add_classify)` | `on.click → e.toAdd` | `无提取条件` |
| `3b00/-` | `编辑 ($lang.edit)` | `on.click → function(a){return e.editCategory(t.row)}` | `scopedSlots` |
| `3b00/-` | `删除 ($lang.delete)` | `on.click → function(a){return e.delCategory(t.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `bmVerify` | `"get"` `"news/checkalias"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getData` | `未显式指定` `"news/catspage"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `handelConfirm` | `"post"` `"news/editcat"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData`、`close` |
| `-` / `delCategory` | `"delete"` `"news/cat"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p082"></a>

## 官网自定义字段 `/custom-template-fields`

旧版证据：[P082](27-admin-built-page-evidence.md#p082)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“官网自定义字段”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0f2a/12c53f03` | `el-table-column` | `字段名 ($lang.fields_name)` / `fieldname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0f2a/12c53f03` | `el-table-column` | `字段内容 ($lang.fields_content)` / `value` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0f2a/12c53f03` | `el-table-column` | `管理 ($lang.management)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0f2a/12c53f03` | `添加字段 ($lang.add_fields)` | `on.click → t.toAdd` | `无提取条件` |
| `0f2a/12c53f03` | `编辑` | `on.click → function(a){return t.toEdit(e.row)}` | `scopedSlots` |
| `0f2a/12c53f03` | `删除` | `on.click → function(a){return t.delNews(e.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `12c53f03` / `getData` | `"get"` `"news/getCustomParam"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `12c53f03` / `delNews` | `"get"` `"news/delCustomParam"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toAdd: this.$router.push({name:"addCustomTemplateFields"})`
- 旧跳转：`toEdit: this.$router.push({name:"addCustomTemplateFields",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p083"></a>

## 官网自定义字段编辑 `/add-custom-template-fields`

旧版证据：[P083](27-admin-built-page-evidence.md#p083)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“官网自定义字段编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e2e3/-` | `el-form-item` | `字段名 ($lang.fields_name)` / `fieldname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e2e3/-` | `el-form-item` | `字段内容 ($lang.fields_content)` / `value` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e2e3/-` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `e2e3/-` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `e2e3/-` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `submitForm` | `"get"` `"news/updateCustomParam"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitForm` | `"get"` `"news/addCustomParam"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getData` | `"get"` `"news/getCustomUpdateVal"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.back()`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p084"></a>

## 通知模板容器 `/sms-template`

旧版证据：[P084](27-admin-built-page-evidence.md#p084)；归属：未定位组件。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 `/sms-template/sms`、`/sms-template/email`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“通知模板容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p085"></a>

## 短信模板 `/sms-template/sms`

旧版证据：[P085](27-admin-built-page-evidence.md#p085)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/sms-template`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“短信模板”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0671/f322ba9a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `接口名称 ($lang.interface_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `支持方向 ($lang.support_direction)` / `sms_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `开发者 ($lang.developer)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `当前版本 ($lang.current_version)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `最新版本 ($lang.latest_version)` / `app_version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0671/f322ba9a` | `el-dialog` | `-` / `-` / `t.plInfo.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `0671/f322ba9a` | `el-form-item` | `e.title` / `""` / `-` | `循环 t.plInfo.config` | 分组表单；未知原值不置空 |
| `0671/f322ba9a` | `el-dialog` | `-` / `-` / `t.pltitle` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `0671/f322ba9a` | `el-dialog` | `-` / `-` / `提示 ($lang.hint)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `0671/10ff196c` | `el-dialog` | `-` / `-` / `测试发送 ($lang.test_send)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `0671/10ff196c` | `el-form-item` | `手机 ($lang.cellphone)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0671/f322ba9a` | `申请接口` | `on.click → function(e){return t.applyApi(n)}` | `scopedSlots; 3!==n.status` |
| `0671/f322ba9a` | `启用 ($lang.start_using)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"enable")}` | `scopedSlots; 0===n.status` |
| `0671/f322ba9a` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.plToggleHandleClick(n.id,"disable")}` | `scopedSlots; 1===n.status` |
| `0671/f322ba9a` | `配置` | `on.click → function(e){return t.plSettingHandleClick(n.id)}` | `scopedSlots; 3!==n.status` |
| `0671/f322ba9a` | `安装` | `on.click → function(e){return t.plAzClick(n)}` | `scopedSlots; 3===n.status` |
| `0671/f322ba9a` | `卸载` | `on.click → function(e){return t.plUnInstallHandleClick(n)}` | `scopedSlots; 3!==n.status` |
| `0671/f322ba9a` | `更新` | `on.click → function(e){return t.handleUpdate(n)}` | `scopedSlots; 3!==n.status&&1==n.update_btn&&1==n.update_disable` |
| `0671/f322ba9a` | `更新` | `on.click → function(e){return t.handleUpdate(n)}` | `scopedSlots; else(3!==n.status&&1==n.update_btn&&1==n.update_disable); 3!==n.status&&1==n.update_btn` |
| `0671/f322ba9a` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `0671/f322ba9a` | `保存更改 ($lang.save_the_changes)` | `on.click → t.saveHandleClick` | `无提取条件` |
| `0671/f322ba9a` | `取消 ($lang.cancel)` | `on.click → function(e){t.uninstallDialogVisible=!1,t.xzMrApi=void 0,t.delRadio="1"}` | `无提取条件` |
| `0671/f322ba9a` | `确定 ($lang.confirm)` | `on.click → t.sure` | `无提取条件` |
| `0671/f322ba9a` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisibleAz=!1}` | `无提取条件` |
| `0671/f322ba9a` | `确定 ($lang.confirm)` | `on.click → t.plInstallHandleClick` | `无提取条件` |
| `0671/10ff196c` | `取消 ($lang.cancel)` | `on.click → function(e){t.testDialog=!1}` | `无提取条件` |
| `0671/10ff196c` | `确定 ($lang.confirm)` | `on.click → t.testSend` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `f322ba9a` / `handleUpdate` | `"post"` `"pl_update"` (data) | `POST {A}/pl_update` → `admin/plugin/plUpdate`；规则 `app\admin\controller\Plugincontroller::plupdate`；[源行](../../data/route/admin.php#L165) | `getData` |
| `f322ba9a` / `getData` | `未显式指定` `"pl_index/".concat(t,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f322ba9a` / `plInstallHandleClick` | `"post"` `"pl_install"` (data) | `POST {A}/pl_install` → `admin/plugin/plInstall`；规则 `app\admin\controller\Plugincontroller::plinstall`；[源行](../../data/route/admin.php#L159) | `getData` |
| `f322ba9a` / `plUnInstallApi` | `"post"` `"pl_uninstall"` (data) | `POST {A}/pl_uninstall` → `admin/plugin/plUninstall`；规则 `app\admin\controller\Plugincontroller::pluninstall`；[源行](../../data/route/admin.php#L160) | `getData` |
| `f322ba9a` / `plToggleHandleClick` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `f322ba9a` / `plToggleApi` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `f322ba9a` / `plSettingHandleClick` | `未显式指定` `"pl_setting/sms/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f322ba9a` / `plCopyHandleClick` | `"post"` `"pl_copy"` (data) | `POST {A}/pl_copy` → `admin/plugin/plCopy`；规则 `app\admin\controller\Plugincontroller::plcopy`；[源行](../../data/route/admin.php#L158) | `getData` |
| `f322ba9a` / `saveHandleClick` | `"post"` `"pl_setting_post"` (data) | `POST {A}/pl_setting_post` → `admin/plugin/plSettingPost`；规则 `app\admin\controller\Plugincontroller::plsettingpost`；[源行](../../data/route/admin.php#L163) | `getData` |
| `f322ba9a` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `f322ba9a` / `sure` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData`、`plUnInstallApi` |
| `f322ba9a` / `rowDrag` | `"post"` `"pl_sort/".concat(t.moduleName,"/")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `10ff196c` / `smsInit` | `未显式指定` `"config_message/config_mobile"` (无显式 data/params) | `GET {A}/config_message/config_mobile` → `admin/config_message/configMobile`；规则 `app\admin\controller\ConfigMessagecontroller::configmobile`；[源行](../../data/route/admin.php#L356) | 未提取；新设计明确成功后重读受影响对象 |
| `10ff196c` / `submitForm` | `"post"` `"config_message/config_mobile_post"` (data) | `POST {A}/config_message/config_mobile_post` → `admin/config_message/configMobilePost`；规则 `app\admin\controller\ConfigMessagecontroller::configmobilepost`；[源行](../../data/route/admin.php#L357) | `smsInit` |
| `10ff196c` / `testSendPage` | `未显式指定` `"config_message/test_message_template_page"` (params) | `GET {A}/config_message/test_message_template_page` → `admin/config_message/testMessageTemplatePage`；规则 `app\admin\controller\ConfigMessagecontroller::testmessagetemplatepage`；[源行](../../data/route/admin.php#L369) | 未提取；新设计明确成功后重读受影响对象 |
| `10ff196c` / `testSend` | `"post"` `"config_message/send_sms"` (data) | `POST {A}/config_message/send_sms` → `admin/config_message/sendSmsTest`；规则 `app\admin\controller\ConfigMessagecontroller::sendsmstest`；[源行](../../data/route/admin.php#L370) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p086"></a>

## 邮件模板 `/sms-template/email`

旧版证据：[P086](27-admin-built-page-evidence.md#p086)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/sms-template`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“邮件模板”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `123b/4c65f430` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `接口名称 ($lang.interface_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `开发者 ($lang.developer)` / `author` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `当前版本 ($lang.current_version)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `最新版本 ($lang.latest_version)` / `app_version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `123b/4c65f430` | `el-dialog` | `-` / `-` / `t.plInfo.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `123b/4c65f430` | `el-form-item` | `e.title` / `""` / `-` | `循环 t.plInfo.config` | 分组表单；未知原值不置空 |
| `123b/4c65f430` | `el-dialog` | `-` / `-` / `t.pltitle` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `123b/4c65f430` | `el-dialog` | `-` / `-` / `提示 ($lang.hint)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `123b/66d3fb31` | `el-dialog` | `-` / `-` / `测试发送 ($lang.test_send)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `123b/66d3fb31` | `el-form-item` | `手机 ($lang.cellphone)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `123b/4c65f430` | `申请接口` | `on.click → function(e){return t.applyApi(a)}` | `scopedSlots; 3!==a.status` |
| `123b/4c65f430` | `启用 ($lang.start_using)` | `on.click → function(e){return t.plToggleHandleClick(a.id,"enable")}` | `scopedSlots; 0===a.status` |
| `123b/4c65f430` | `禁用 ($lang.forbidden)` | `on.click → function(e){return t.plToggleHandleClick(a.id,"disable")}` | `scopedSlots; 1===a.status` |
| `123b/4c65f430` | `配置` | `on.click → function(e){return t.plSettingHandleClick(a.id)}` | `scopedSlots; 3!==a.status` |
| `123b/4c65f430` | `安装` | `on.click → function(e){return t.plAzClick(a.name)}` | `scopedSlots; 3===a.status` |
| `123b/4c65f430` | `卸载` | `on.click → function(e){return t.plUnInstallHandleClick(a)}` | `scopedSlots; 3!==a.status` |
| `123b/4c65f430` | `更新` | `on.click → function(e){return t.handleUpdate(a)}` | `scopedSlots; 3!==a.status&&1==a.update_btn&&1==a.update_disable` |
| `123b/4c65f430` | `更新` | `on.click → function(e){return t.handleUpdate(a)}` | `scopedSlots; else(3!==a.status&&1==a.update_btn&&1==a.update_disable); 3!==a.status&&1==a.update_btn` |
| `123b/4c65f430` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisible=!1}` | `无提取条件` |
| `123b/4c65f430` | `保存更改 ($lang.save_the_changes)` | `on.click → t.saveHandleClick` | `无提取条件` |
| `123b/4c65f430` | `取消 ($lang.cancel)` | `on.click → function(e){t.uninstallDialogVisible=!1,t.xzMrApi=""}` | `无提取条件` |
| `123b/4c65f430` | `确定 ($lang.confirm)` | `on.click → t.sure` | `无提取条件` |
| `123b/4c65f430` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogVisibleAz=!1}` | `无提取条件` |
| `123b/4c65f430` | `确定 ($lang.confirm)` | `on.click → t.plInstallHandleClick` | `无提取条件` |
| `123b/66d3fb31` | `取消 ($lang.cancel)` | `on.click → function(e){t.testDialog=!1}` | `无提取条件` |
| `123b/66d3fb31` | `确定 ($lang.confirm)` | `on.click → t.testSend` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4c65f430` / `handleUpdate` | `"post"` `"pl_update"` (data) | `POST {A}/pl_update` → `admin/plugin/plUpdate`；规则 `app\admin\controller\Plugincontroller::plupdate`；[源行](../../data/route/admin.php#L165) | `getData` |
| `4c65f430` / `getData` | `"get"` `"pl_index/mail/"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4c65f430` / `plInstallHandleClick` | `"post"` `"pl_install"` (data) | `POST {A}/pl_install` → `admin/plugin/plInstall`；规则 `app\admin\controller\Plugincontroller::plinstall`；[源行](../../data/route/admin.php#L159) | `getData` |
| `4c65f430` / `plUnInstallApi` | `"post"` `"pl_uninstall"` (data) | `POST {A}/pl_uninstall` → `admin/plugin/plUninstall`；规则 `app\admin\controller\Plugincontroller::pluninstall`；[源行](../../data/route/admin.php#L160) | `getData` |
| `4c65f430` / `plToggleHandleClick` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `4c65f430` / `plToggleApi` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData` |
| `4c65f430` / `plSettingHandleClick` | `未显式指定` `"pl_setting/mail/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4c65f430` / `plCopyHandleClick` | `"post"` `"pl_copy"` (data) | `POST {A}/pl_copy` → `admin/plugin/plCopy`；规则 `app\admin\controller\Plugincontroller::plcopy`；[源行](../../data/route/admin.php#L158) | `getData` |
| `4c65f430` / `saveHandleClick` | `"post"` `"pl_setting_post"` (data) | `POST {A}/pl_setting_post` → `admin/plugin/plSettingPost`；规则 `app\admin\controller\Plugincontroller::plsettingpost`；[源行](../../data/route/admin.php#L163) | `getData` |
| `4c65f430` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `4c65f430` / `sure` | `"post"` `"pl_toggle"` (data) | `POST {A}/pl_toggle` → `admin/plugin/plToggle`；规则 `app\admin\controller\Plugincontroller::pltoggle`；[源行](../../data/route/admin.php#L161) | `getData`、`plUnInstallApi` |
| `4c65f430` / `rowDrag` | `"post"` `"pl_sort/".concat(t.moduleName,"/")` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `66d3fb31` / `smsInit` | `未显式指定` `"config_message/config_mobile"` (无显式 data/params) | `GET {A}/config_message/config_mobile` → `admin/config_message/configMobile`；规则 `app\admin\controller\ConfigMessagecontroller::configmobile`；[源行](../../data/route/admin.php#L356) | 未提取；新设计明确成功后重读受影响对象 |
| `66d3fb31` / `submitForm` | `"post"` `"config_message/config_mobile_post"` (data) | `POST {A}/config_message/config_mobile_post` → `admin/config_message/configMobilePost`；规则 `app\admin\controller\ConfigMessagecontroller::configmobilepost`；[源行](../../data/route/admin.php#L357) | `smsInit` |
| `66d3fb31` / `testSendPage` | `未显式指定` `"config_message/test_message_template_page"` (params) | `GET {A}/config_message/test_message_template_page` → `admin/config_message/testMessageTemplatePage`；规则 `app\admin\controller\ConfigMessagecontroller::testmessagetemplatepage`；[源行](../../data/route/admin.php#L369) | 未提取；新设计明确成功后重读受影响对象 |
| `66d3fb31` / `testSend` | `"post"` `"config_message/send_sms"` (data) | `POST {A}/config_message/send_sms` → `admin/config_message/sendSmsTest`；规则 `app\admin\controller\ConfigMessagecontroller::sendsmstest`；[源行](../../data/route/admin.php#L370) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p087"></a>

## 短信模板兼容入口 `/sms-template-index`

旧版证据：[P087](27-admin-built-page-evidence.md#p087)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“短信模板兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `dd3a/2c92182e` | `el-form-item` | `模板ID搜索 ($lang.template_id_search)` / `-` / `-` | `e.search` | 分组表单；未知原值不置空 |
| `dd3a/2c92182e` | `el-form-item` | `模板标题搜索 ($lang.template_title_search)` / `-` / `-` | `e.search` | 分组表单；未知原值不置空 |
| `dd3a/2c92182e` | `el-form-item` | `-` / `-` / `-` | `e.search` | 分组表单；未知原值不置空 |
| `dd3a/2c92182e` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `编号 ($lang.serial_num)` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `模板ID ($lang.template_id)` / `template_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `类型 ($lang.type)` / `range_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `模板标题 ($lang.template_title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `模板内容 ($lang.template_centent)` / `content` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `审核状态 ($lang.audit_status)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `dd3a/2c92182e` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `dd3a/2c92182e` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `dd3a/2c92182e` | `创建模板 ($lang.create_template)` | `on.click → e.toAdd` | `无提取条件` |
| `dd3a/2c92182e` | `切换 ($lang.switchover)` | `on.click → e.changeSupplier` | `无提取条件` |
| `dd3a/2c92182e` | `" "+e._s(e.search?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → e.searchChange` | `无提取条件` |
| `dd3a/2c92182e` | `搜索 ($lang.search)` | `on.click → e.templateInit` | `e.search` |
| `dd3a/2c92182e` | `清空 ($lang.empty)` | `on.click → function(t){return e.clearSearchHandleClick("elForm")}` | `e.search` |
| `dd3a/2c92182e` | `编辑` | `on.click → function(a){return e.updateTemplate(t.$index,t.row)}` | `scopedSlots; 0===t.row.status\|\|3===t.row.status` |
| `dd3a/2c92182e` | `审核` | `on.click → function(a){return e.shRowTemp(t.row)}` | `scopedSlots; 0===t.row.status\|\|3===t.row.status` |
| `dd3a/2c92182e` | `删除 ($lang.delete)` | `on.click → function(a){return e.delRowTemp(t.row.id,t.row.sms_operator)}` | `scopedSlots; 0===t.row.status\|\|3===t.row.status` |
| `dd3a/2c92182e` | `编辑` | `on.click → function(a){return e.updateTemplate(t.$index,t.row)}` | `scopedSlots; else(0===t.row.status\|\|3===t.row.status); else(1===t.row.status); 2===t.row.status` |
| `dd3a/2c92182e` | `删除` | `on.click → function(a){return e.delRowTemp(t.row.id,t.row.sms_operator)}` | `scopedSlots; else(0===t.row.status\|\|3===t.row.status); else(1===t.row.status); 2===t.row.status` |
| `dd3a/2c92182e` | `测试` | `on.click → function(a){return e.testTemplate(t.$index,t.row)}` | `scopedSlots; else(0===t.row.status\|\|3===t.row.status); else(1===t.row.status); 2===t.row.status` |
| `dd3a/2c92182e` | `提交审核` | `on.click → e.shTemp` | `无提取条件` |
| `dd3a/2c92182e` | `删除所选模板` | `on.click → e.delTemp` | `无提取条件` |
| `dd3a/2c92182e` | `更新审核状态` | `on.click → e.updateCheckStatus` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2c92182e` / `templateInit` | `"get"` `"config_message/template_list"` (params) | `GET {A}/config_message/template_list` → `admin/config_message/templateList`；规则 `app\admin\controller\ConfigMessagecontroller::templatelist`；[源行](../../data/route/admin.php#L358) | 未提取；新设计明确成功后重读受影响对象 |
| `2c92182e` / `templateInit` | `未显式指定` `"config_message/update_tem_status"` (params) | `GET {A}/config_message/update_tem_status` → `admin/config_message/updateTemStatus`；规则 `app\admin\controller\ConfigMessagecontroller::updatetemstatus`；[源行](../../data/route/admin.php#L363) | 未提取；新设计明确成功后重读受影响对象 |
| `2c92182e` / `radioDefault` | `未显式指定` `"config_message/config_mobile"` (无显式 data/params) | `GET {A}/config_message/config_mobile` → `admin/config_message/configMobile`；规则 `app\admin\controller\ConfigMessagecontroller::configmobile`；[源行](../../data/route/admin.php#L356) | `templateInit` |
| `2c92182e` / `delTemp` | `未显式指定` `"config_message/delete_template"` (params) | `GET {A}/config_message/delete_template` → `admin/config_message/deleteTemplate`；规则 `app\admin\controller\ConfigMessagecontroller::deletetemplate`；[源行](../../data/route/admin.php#L365) | `radioDefault` |
| `2c92182e` / `delRowTemp` | `未显式指定` `"config_message/delete_template"` (params) | `GET {A}/config_message/delete_template` → `admin/config_message/deleteTemplate`；规则 `app\admin\controller\ConfigMessagecontroller::deletetemplate`；[源行](../../data/route/admin.php#L365) | `radioDefault` |
| `2c92182e` / `shTemp` | `"post"` `"config_message/check_post"` (data) | `POST {A}/config_message/check_post` → `admin/config_message/checkPost`；规则 `app\admin\controller\ConfigMessagecontroller::checkpost`；[源行](../../data/route/admin.php#L364) | `templateInit` |
| `2c92182e` / `shRowTemp` | `"post"` `"config_message/check_post"` (data) | `POST {A}/config_message/check_post` → `admin/config_message/checkPost`；规则 `app\admin\controller\ConfigMessagecontroller::checkpost`；[源行](../../data/route/admin.php#L364) | `templateInit` |
| `2c92182e` / `updateCheckStatus` | `未显式指定` `"config_message/update_tem_status"` (params) | `GET {A}/config_message/update_tem_status` → `admin/config_message/updateTemStatus`；规则 `app\admin\controller\ConfigMessagecontroller::updatetemstatus`；[源行](../../data/route/admin.php#L363) | `templateInit` |
| `2c92182e` / `testTemplate` | `未显式指定` `"config_message/test_message_template_page"` (params) | `GET {A}/config_message/test_message_template_page` → `admin/config_message/testMessageTemplatePage`；规则 `app\admin\controller\ConfigMessagecontroller::testmessagetemplatepage`；[源行](../../data/route/admin.php#L369) | 未提取；新设计明确成功后重读受影响对象 |
| `2c92182e` / `handelConfirm` | `"post"` `"config_message/update_template_post"` (data) | `POST {A}/config_message/update_template_post` → `admin/config_message/updateTemplatePost`；规则 `app\admin\controller\ConfigMessagecontroller::updatetemplatepost`；[源行](../../data/route/admin.php#L362) | `templateInit`、`close` |
| `2c92182e` / `phoneHandelConfirm` | `"post"` `"config_message/test_message_template"` (data) | `POST {A}/config_message/test_message_template` → `admin/config_message/testMessageTemplate`；规则 `app\admin\controller\ConfigMessagecontroller::testmessagetemplate`；[源行](../../data/route/admin.php#L368) | `close` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toAdd: this.$router.push({name:"smsCreateTemplate"})`
- 旧跳转：`updateTemplate: a.$router.push({path:"/sms-create-template",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p088"></a>

## 短信模板编辑 `/sms-create-template`

旧版证据：[P088](27-admin-built-page-evidence.md#p088)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 名称/分类等基础字段 → 正文编辑器 → 变量/附件与预览 → 保存区。预览与提交分开，预览内容不执行非可信脚本。

**手机排版**：基础字段单列，正文占满内容宽；编辑工具可横向滚动，预览独立展示并保留返回草稿。

**本页专项约束**：围绕“短信模板编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `342b/-` | `el-form-item` | `选择区域 ($lang.selection_region)` / `range_type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `短信供应商 ($lang.sms_provider)` / `sms_operator` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `模板ID ($lang.template_id)` / `id` / `-` | `e.smsId` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `模板状态 ($lang.template_status)` / `status` / `-` | `e.smsId` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `内容 ($lang.content)` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `描述 ($lang.describe)` / `describe` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `备注 ($lang.remark)` / `remark` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `342b/-` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `342b/-` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `342b/-` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `342b/-` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getEditTemplate` | `未显式指定` `"config_message/update_template/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `smsSupplierChange` |
| `-` / `createTemplatePage` | `未显式指定` `"config_message/create_template_page"` (无显式 data/params) | `GET {A}/config_message/create_template_page` → `admin/config_message/createTemplatePage`；规则 `app\admin\controller\ConfigMessagecontroller::createtemplatepage`；[源行](../../data/route/admin.php#L359) | `getEditTemplate`、`smsSupplierChange` |
| `-` / `submitForm` | `"post"` `"config_message/update_template_post"` (data) | `POST {A}/config_message/update_template_post` → `admin/config_message/updateTemplatePost`；规则 `app\admin\controller\ConfigMessagecontroller::updatetemplatepost`；[源行](../../data/route/admin.php#L362) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitForm` | `"post"` `"config_message/create_template"` (data) | `POST {A}/config_message/create_template` → `admin/config_message/createTemplate`；规则 `app\admin\controller\ConfigMessagecontroller::createtemplate`；[源行](../../data/route/admin.php#L360) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `smsSupplierChange` | `未显式指定` `"config_message/get_template_desc"` (params) | `GET {A}/config_message/get_template_desc` → `admin/config_message/getTemplateDesc`；规则 `app\admin\controller\ConfigMessagecontroller::gettemplatedesc`；[源行](../../data/route/admin.php#L375) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.go(-1)`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p089"></a>

## 通知发送设置 `/sms-send-settings`

旧版证据：[P089](27-admin-built-page-evidence.md#p089)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“通知发送设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4cc7/8f1d6b62` | `el-form-item` | `""` / `range_type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-tab-pane` | `e.label` / `-` / `-` | `循环 e.range_typeOptions` | 主区导航；保留对象与选中项 |
| `4cc7/8f1d6b62` | `el-form-item` | `短信开关 ($lang.sms_switch)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-form-item` | `切换供应商 ($lang.switching_suppliers)` / `sms_operator` / `-` | `e.formData.zkg` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-form-item` | `t.type` / `t.name` / `-` | `e.formData.zkg; 循环 e.pageDataArr; 循环 t` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-switch` | `-` / `-` / `-` | `e.formData.zkg; 循环 e.pageDataArr; 循环 t` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-dialog` | `-` / `-` / `测试发送 ($lang.test_send)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `4cc7/8f1d6b62` | `el-form-item` | `手机 ($lang.cellphone)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4cc7/8f1d6b62` | `el-dialog` | `-` / `-` / `提示 ($lang.hint)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4cc7/8f1d6b62` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `4cc7/8f1d6b62` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |
| `4cc7/8f1d6b62` | `测试发送 ($lang.test_send)` | `on.click → function(t){e.testDialog=!0}` | `无提取条件` |
| `4cc7/8f1d6b62` | `取消 ($lang.cancel)` | `on.click → function(t){e.testDialog=!1}` | `无提取条件` |
| `4cc7/8f1d6b62` | `确定 ($lang.confirm)` | `on.click → e.testSend` | `无提取条件` |
| `4cc7/8f1d6b62` | `取消 ($lang.cancel)` | `on.click → function(t){e.gysTip=!1,e.formData.sms_operator=e.oldGysVal}` | `无提取条件` |
| `4cc7/8f1d6b62` | `确定 ($lang.confirm)` | `on.click → function(t){return e.dataInit("qhSure")}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `8f1d6b62` / `dataInit` | `未显式指定` `"config_message/set_sms"` (params) | `GET {A}/config_message/set_sms` → `admin/config_message/SetSmsTemplate`；规则 `app\admin\controller\ConfigMessagecontroller::setsmstemplate`；[源行](../../data/route/admin.php#L366) | 未提取；新设计明确成功后重读受影响对象 |
| `8f1d6b62` / `submitForm` | `"post"` `"config_message/set_sms_post"` (data) | `POST {A}/config_message/set_sms_post` → `admin/config_message/SetSmsTemplatePost`；规则 `app\admin\controller\ConfigMessagecontroller::setsmstemplatepost`；[源行](../../data/route/admin.php#L367) | `dataInit` |
| `8f1d6b62` / `testSendPage` | `未显式指定` `"config_message/test_message_template_page"` (params) | `GET {A}/config_message/test_message_template_page` → `admin/config_message/testMessageTemplatePage`；规则 `app\admin\controller\ConfigMessagecontroller::testmessagetemplatepage`；[源行](../../data/route/admin.php#L369) | 未提取；新设计明确成功后重读受影响对象 |
| `8f1d6b62` / `testSend` | `"post"` `"config_message/send_sms"` (data) | `POST {A}/config_message/send_sms` → `admin/config_message/sendSmsTest`；规则 `app\admin\controller\ConfigMessagecontroller::sendsmstest`；[源行](../../data/route/admin.php#L370) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p090"></a>

## 系统日志 `/system-log`

旧版证据：[P090](27-admin-built-page-evidence.md#p090)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“系统日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6001/174825b5` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6001/174825b5` | `el-form-item` | `用户名 ($lang.user_name)` / `search_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6001/174825b5` | `el-form-item` | `描述 ($lang.describe)` / `search_desc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6001/174825b5` | `el-form-item` | `IP地址 ($lang.ip_address)` / `search_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6001/174825b5` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6001/174825b5` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6001/174825b5` | `el-table-column` | `时间 ($lang.time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6001/174825b5` | `el-table-column` | `描述 ($lang.describe)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6001/174825b5` | `el-table-column` | `来源 ($lang.source)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6001/174825b5` | `el-table-column` | `用户名 ($lang.user_name)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6001/174825b5` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ipaddr` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6001/174825b5` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `6001/174825b5` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `174825b5` / `getData` | `未显式指定` `"zjmf_finance_api/logs"` (params) | `GET {A}/zjmf_finance_api/logs` → `admin/zjmfFinanceApi/apiLog`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apilog`；[源行](../../data/route/admin.php#L770) | 未提取；新设计明确成功后重读受影响对象 |
| `174825b5` / `getData` | `未显式指定` `"log_record/systemlog"` (params) | `GET {A}/log_record/systemlog` → `admin/log_record/getSystemLog`；规则 `app\admin\controller\LogRecordcontroller::getsystemlog`；[源行](../../data/route/admin.php#L620) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p091"></a>

## 站内信日志 `/station-letter-log`

旧版证据：[P091](27-admin-built-page-evidence.md#p091)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“站内信日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4ca5/4c2eb670` | `el-form-item` | `时间 ($lang.time)` / `search_timeShow` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4ca5/4c2eb670` | `el-form-item` | `主题 ($lang.theme)` / `keywords` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4ca5/4c2eb670` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4ca5/4c2eb670` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4ca5/4c2eb670` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ca5/4c2eb670` | `el-form-item` | `下载附件 ($lang.download_attachment)` / `selectOpeartion` / `-` | `scopedSlots; n.attachment&&n.attachment.length` | 分组表单；未知原值不置空 |
| `4ca5/4c2eb670` | `el-table-column` | `发送时间 ($lang.send_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ca5/4c2eb670` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ca5/4c2eb670` | `el-table-column` | `用户 ($lang.user)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4ca5/4c2eb670` | `el-table-column` | `状态 ($lang.state)` / `read_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4ca5/4c2eb670` | `搜索 ($lang.search)` | `on.click → function(t){return e.getSystemlog("loading")}` | `无提取条件` |
| `4ca5/4c2eb670` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |
| `4ca5/4c2eb670` | `e._s(t.name)+" "` | `on.click → function(a){return e.downloadAnnex(t)}` | `scopedSlots; n.attachment&&n.attachment.length; 循环 n.attachment` |
| `4ca5/4c2eb670` | `n.username` | `on.click → function(t){return e.goUser(n)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4c2eb670` / `getSystemlog` | `未显式指定` `"log_record/system_message_log"` (params) | `GET {A}/log_record/system_message_log` → `admin/log_record/getSystemMessageLog`；规则 `app\admin\controller\LogRecordcontroller::getsystemmessagelog`；[源行](../../data/route/admin.php#L629) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goUser: this.$router.push({name:"abstract",query:{id:e.uid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p092"></a>

## 管理员登录日志 `/system-admin-log`

旧版证据：[P092](27-admin-built-page-evidence.md#p092)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“管理员登录日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f432/2629282c` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f432/2629282c` | `el-form-item` | `用户名 ($lang.user_name)` / `search_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f432/2629282c` | `el-form-item` | `IP地址 ($lang.ip_address)` / `search_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f432/2629282c` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f432/2629282c` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f432/2629282c` | `el-table-column` | `登录时间 ($lang.login_date)` / `logintime` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f432/2629282c` | `el-table-column` | `最后访问 ($lang.last_access)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f432/2629282c` | `el-table-column` | `注销时间 ($lang.cancellation_time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f432/2629282c` | `el-table-column` | `用户名 ($lang.user_name)` / `admin_username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f432/2629282c` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ipaddress` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f432/2629282c` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `f432/2629282c` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2629282c` / `getData` | `未显式指定` `"log_record/adminlog"` (params) | `GET {A}/log_record/adminlog` → `admin/log_record/getAdminLog`；规则 `app\admin\controller\LogRecordcontroller::getadminlog`；[源行](../../data/route/admin.php#L622) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p093"></a>

## 通知日志 `/inform-log`

旧版证据：[P093](27-admin-built-page-evidence.md#p093)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“通知日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `16be/3493e977` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `16be/3493e977` | `el-form-item` | `消息 ($lang.message)` / `message` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `16be/3493e977` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `16be/3493e977` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `16be/3493e977` | `el-table-column` | `发送给 ($lang.send_to)` / `to` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `16be/3493e977` | `el-table-column` | `消息 ($lang.message)` / `message` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `16be/3493e977` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `16be/3493e977` | `el-table-column` | `主题 ($lang.theme)` / `subject` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `16be/3493e977` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `16be/3493e977` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3493e977` / `getData` | `未显式指定` `"log_record/notifylog"` (params) | `GET {A}/log_record/notifylog` → `admin/log_record/getNotifyLog`；规则 `app\admin\controller\LogRecordcontroller::getnotifylog`；[源行](../../data/route/admin.php#L624) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p094"></a>

## 邮件日志 `/email-log`

旧版证据：[P094](27-admin-built-page-evidence.md#p094)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“邮件日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `d45d/9d8f0cfa` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d45d/9d8f0cfa` | `el-form-item` | `收件人 ($lang.recipient)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d45d/9d8f0cfa` | `el-form-item` | `主题 ($lang.theme)` / `subject` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d45d/9d8f0cfa` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d45d/9d8f0cfa` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `主题 ($lang.theme)` / `subject` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `收件人 ($lang.recipient)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `是否成功 ($lang.is_success)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `fail_reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d45d/9d8f0cfa` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `d45d/9d8f0cfa` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `d45d/9d8f0cfa` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |
| `d45d/9d8f0cfa` | `t.row.subject` | `on.click → function(a){return e.subjectHandleClick(t.row.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `9d8f0cfa` / `getData` | `未显式指定` `"log_record/emaillog"` (params) | `GET {A}/log_record/emaillog` → `admin/log_record/getEmailLog`；规则 `app\admin\controller\LogRecordcontroller::getemaillog`；[源行](../../data/route/admin.php#L625) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p095"></a>

## 短信日志 `/sms-log`

旧版证据：[P095](27-admin-built-page-evidence.md#p095)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“短信日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `063a/19e7beaa` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `063a/19e7beaa` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `063a/19e7beaa` | `el-form-item` | `电话 ($lang.phone)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `063a/19e7beaa` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `063a/19e7beaa` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `短信内容 ($lang.message_content)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `电话 ($lang.phone)` / `phone` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `是否成功 ($lang.is_success)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `fail_reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `063a/19e7beaa` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `063a/19e7beaa` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `063a/19e7beaa` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `19e7beaa` / `getData` | `未显式指定` `"log_record/smslog"` (params) | `GET {A}/log_record/smslog` → `admin/log_record/getSmsLog`；规则 `app\admin\controller\LogRecordcontroller::getsmslog`；[源行](../../data/route/admin.php#L627) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.uid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p096"></a>

## API 日志 `/api-log`

旧版证据：[P096](27-admin-built-page-evidence.md#p096)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“API 日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fdc9/3d5d1c25` | `el-form-item` | `时间 ($lang.time)` / `time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdc9/3d5d1c25` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdc9/3d5d1c25` | `el-form-item` | `关键字 ($lang.keyword)` / `keywords` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdc9/3d5d1c25` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdc9/3d5d1c25` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fdc9/3d5d1c25` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fdc9/3d5d1c25` | `el-table-column` | `描述 ($lang.describe)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fdc9/3d5d1c25` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fdc9/3d5d1c25` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fdc9/3d5d1c25` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `fdc9/3d5d1c25` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3d5d1c25` / `getData` | `未显式指定` `"log_record/api_log"` (params) | `GET {A}/log_record/api_log` → `admin/log_record/getApiLog`；规则 `app\admin\controller\LogRecordcontroller::getapilog`；[源行](../../data/route/admin.php#L630) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.uid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p097"></a>

## 日志清理 `/log-cleanup`

旧版证据：[P097](27-admin-built-page-evidence.md#p097)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：先选日志类型/时间范围并显示可验证影响范围，再确认清理；数量接口缺失时不伪造预估，不能用列表刷新代替清理成功确认。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b4b7/fd5975ea` | `el-form-item` | `选择日志 ($lang.select_log)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b4b7/fd5975ea` | `el-form-item` | `日志总条数 ($lang.log_total_num)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b4b7/fd5975ea` | `el-form-item` | `删除 ($lang.delete)` / `time_show` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `b4b7/fd5975ea` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `b4b7/fd5975ea` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `fd5975ea` / `getData` | `未显式指定` `"log_record/delete_log_page"` (params) | `GET {A}/log_record/delete_log_page` → `admin/log_record/getDeleteLogPage`；规则 `app\admin\controller\LogRecordcontroller::getdeletelogpage`；[源行](../../data/route/admin.php#L631) | 未提取；新设计明确成功后重读受影响对象 |
| `fd5975ea` / `submitForm` | `未显式指定` `"log_record/affirm_delete_log_page"` (params) | `GET {A}/log_record/affirm_delete_log_page` → `admin/log_record/getAffirmDeleteLogPage`；规则 `app\admin\controller\LogRecordcontroller::getaffirmdeletelogpage`；[源行](../../data/route/admin.php#L632) | `getData` |
| `fd5975ea` / `submitForm` | `"delete"` `"log_record/delete_log"` (params) | `DELETE {A}/log_record/delete_log` → `admin/log_record/deleteLog`；规则 `app\admin\controller\LogRecordcontroller::deletelog`；[源行](../../data/route/admin.php#L633) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p098"></a>

## 定时任务日志 `/automatic-task-log`

旧版证据：[P098](27-admin-built-page-evidence.md#p098)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“定时任务日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5b02/4ffa071a` | `el-form-item` | `时间 ($lang.time)` / `search_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5b02/4ffa071a` | `el-form-item` | `用户名 ($lang.user_name)` / `search_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5b02/4ffa071a` | `el-form-item` | `描述 ($lang.describe)` / `search_desc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5b02/4ffa071a` | `el-form-item` | `IP地址 ($lang.ip_address)` / `search_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5b02/4ffa071a` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5b02/4ffa071a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5b02/4ffa071a` | `el-table-column` | `时间 ($lang.time)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5b02/4ffa071a` | `el-table-column` | `描述 ($lang.describe)` / `new_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5b02/4ffa071a` | `el-table-column` | `用户名 ($lang.user_name)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5b02/4ffa071a` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ipaddr` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5b02/4ffa071a` | `搜索 ($lang.search)` | `on.click → function(t){return e.getData("loading")}` | `无提取条件` |
| `5b02/4ffa071a` | `清空 ($lang.empty)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4ffa071a` / `getData` | `未显式指定` `"log_record/cronsystemlog"` (params) | `GET {A}/log_record/cronsystemlog` → `admin/log_record/getCronSystemLog`；规则 `app\admin\controller\LogRecordcontroller::getcronsystemlog`；[源行](../../data/route/admin.php#L621) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p099"></a>

## 系统状态 `/system-message`

旧版证据：[P099](27-admin-built-page-evidence.md#p099)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“系统状态”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `987c/33c86722` | `el-form-item` | `授权类型： ($lang.authorization_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `授权状态： ($lang.authorization_status)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `授权码： ($lang.authorization_code)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `服务支持到期时间： ($lang.service_support_expiration_time)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | ` 授权到期时间： ($lang.authorization_expiration_time)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `已授权模块： ($lang.authorized_modules)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `授权服务器ip： ($lang.servers_ip)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `授权域名： ($lang.domain_name)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `系统识别码： ($lang.system_no)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `" "` / `-` / `-` | `e.clientWidth<=1366` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `最新版本： ($lang.latest_version_system)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `当前版本： ($lang.current_version_system)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `正在使用： ($lang.in_use_two)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-form-item` | `""` / `-` / `-` | `"Suspend"!==this.listArray.auth_status` | 分组表单；未知原值不置空 |
| `987c/33c86722` | `el-dialog` | `-` / `-` / `系统更新进度 ($lang.system_update_schedule)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `987c/33c86722` | `el-dialog` | `-` / `-` / `更新内容 ($lang.update_content)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `987c/33c86722` | `el-dialog` | `-` / `-` / `更换授权码 ($lang.change_authorization_code)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `987c/33c86722` | `el-form-item` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `987c/33c86722` | `" "+e._s(e.dataLoading?e.$lang.checking_updates:e.$lang.immediately_update)` | `on.click → e.updateHandleClick` | `"Suspend"!==this.listArray.auth_status; else(e.isLastestVersion); 0==e.isDownload` |
| `987c/33c86722` | `" "+e._s(e.dataLoading?e.$lang.checking_updates:e.$lang.upgrade_immediately)` | `on.click → e.goToInstall` | `"Suspend"!==this.listArray.auth_status; else(e.isLastestVersion); else(0==e.isDownload)` |
| `987c/33c86722` | `前往安装 ($lang.to_install)` | `on.click → e.goToInstall` | `100===e.progress` |
| `987c/33c86722` | `取消 ($lang.cancel)` | `on.click → function(t){e.authorizeVisable=!1}` | `无提取条件` |
| `987c/33c86722` | `确定 ($lang.confirm)` | `on.click → e.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `33c86722` / `getAuthorization` | `未显式指定` `"system/authorize"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getSystemInfo` |
| `33c86722` / `getSystemInfo` | `未显式指定` `"system/info"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getLastVersion` |
| `33c86722` / `getLastVersion` | `未显式指定` `"system/lastversion"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `checkIsDownload` |
| `33c86722` / `checkIsDownload` | `未显式指定` `"upgrade/version"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `33c86722` / `getUpdateProgress` | `未显式指定` `"upgrade/checkautoupdate"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `clearTimer` |
| `33c86722` / `updateHandleClick` | `未显式指定` `"upgrade/autoupdate"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getUpdateProgress` |
| `33c86722` / `toggleVersion` | `"post"` `"system/toggleversion"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getSystemInfo` |
| `33c86722` / `getUpdateContent` | `未显式指定` `"system/updatecontent"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `33c86722` / `submitForm` | `"put"` `"system/license"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getSystemInfo` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goToInstall: this.$router.push({name:"systemUpdata",params:{lastVersion:this.lastVersion}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p100"></a>

## PHP 信息 `/php-message`

旧版证据：[P100](27-admin-built-page-evidence.md#p100)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“PHP 信息”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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
| `-` / `getList` | `未显式指定` `"system/phpinfo"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p101"></a>

## 数据库状态 `/database-message`

旧版证据：[P101](27-admin-built-page-evidence.md#p101)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“数据库状态”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `cf86/bf6b2060` | `el-table-column` | `表名称 ($lang.table_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cf86/bf6b2060` | `el-table-column` | `表行数 ($lang.table_rows)` / `rows` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `cf86/bf6b2060` | `el-table-column` | `表大小 ($lang.table_dimensions)` / `size` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `cf86/bf6b2060` | `优化数据表` | `on.click → t.optimize` | `无提取条件` |
| `cf86/bf6b2060` | `下载数据库备份` | `on.click → t.download` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `bf6b2060` / `getData` | `未显式指定` `"system/databaseinfo"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `bf6b2060` / `optimize` | `"post"` `"system/optimizeTables"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `bf6b2060` / `download` | `"post"` `"system/downdatabackup"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `downloadBinary` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p102"></a>

## 数据迁移 `/data-migration`

旧版证据：[P102](27-admin-built-page-evidence.md#p102)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 步骤/进度 → 当前步骤输入 → 当前对象/金额摘要 → 上一步/下一步/最终确认。只按已有流程划分步骤，禁止在切换步骤时隐式提交业务。

**手机排版**：步骤缩为当前位置，内容单列，摘要紧靠最终确认；重复点击不产生重复请求。

**本页专项约束**：来源连接参数不进截图/文档；检查、执行和结果分步骤，记录已处理范围；未落实幂等/回滚前不能开放真实迁移。

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

<a id="p103"></a>

## 关于系统 `/about`

旧版证据：[P103](27-admin-built-page-evidence.md#p103)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“关于系统”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p104"></a>

## 常规设置容器 `/general-settings`

旧版证据：[P104](27-admin-built-page-evidence.md#p104)；归属：未定位组件。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 `/general-settings/general`、`/general-settings/local`、`/general-settings/support`、`/general-settings/promote`、`/general-settings/safe`、`/general-settings/other`、`/general-settings/invoice`、`/general-settings/login-setting`、`/general-settings/captcha`、`/general-settings/finance`、`/general-settings/order`、`/general-settings/class`、`/general-settings/source-api`。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：外壳导航与上下文 → router-view子页；默认子页按本页重定向记录处理。容器自身不伪造业务表格，隐藏子页不推定为无接口权限。

**手机排版**：导航折为抽屉或横向tabs，router-view宽度min-width:0；视口实时变化同步导航状态。

**本页专项约束**：围绕“常规设置容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p105"></a>

## 常规基础设置 `/general-settings/general`

旧版证据：[P105](27-admin-built-page-evidence.md#p105)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“常规基础设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `ff7c/1bfdabd9` | `el-tab-pane` | `基础信息 ($lang.basic_information)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `品牌名 ($lang.brand_name)` / `company_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `系统链接 ($lang.system_href)` / `domain` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `网站域名 ($lang.website_domain_name)` / `system_url` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-tab-pane` | `本地化 ($lang.localization)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `默认语言 ($lang.default_language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `启用语言选择菜单 ($lang.enable_language_menu)` / `allow_user_language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-tab-pane` | `显示设置 ($lang.show_setting)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `每页显示记录 ($lang.show_records_per_page)` / `per_page_limit` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `前台信用额 ($lang.front_desk_credit)` / `credit_limit` / `-` | `1==e.license_type` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `1==e.license_type` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `自定义起始客户ID ($lang.custom_start_customer_id)` / `allow_custom_clients_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `客户ID前缀 ($lang.custom_id_prefix)` / `custom_clients_id_start` / `-` | `1==e.showForm.allow_custom_clients_id` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-tab-pane` | `基础安全 ($lang.basic_security)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `后台管理目录路径 ($lang.background_management_path)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `管理员登录时长(天) ($lang.administrator_login_time)` / `cancellation_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `前台登录IP检查 ($lang.front_desk_login_ip_check)` / `home_ip_check` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `后台登录IP检查 ($lang.last_desk_login_ip_check)` / `admin_ip_check` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-tab-pane` | `维护模式 ($lang.maintenance_mode)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `维护模式 ($lang.maintenance_mode)` / `main_tenance_mode` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `维护模式信息 ($lang.maintenance_mode_info)` / `main_tenance_mode_message` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `维护模式重定向的链接 ($lang.maintenance_mode_href)` / `main_tenance_mode_url` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-tab-pane` | `Debug调试 ($lang.debug_debugging)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `ff7c/1bfdabd9` | `el-form-item` | `Debug调试 ($lang.debug_debugging)` / `shd_debug_model` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ff7c/1bfdabd9` | `el-form-item` | `-` / `-` / `-` | `1==e.debugForm.shd_debug_model` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `ff7c/1bfdabd9` | `图标/动态文案，回查原证据` | `on.change → e.submitForm` | `无提取条件` |
| `ff7c/1bfdabd9` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `6!=e.activeName` |
| `ff7c/1bfdabd9` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `6!=e.activeName` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1bfdabd9` / `getDetail` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1bfdabd9` / `getDetail` | `未显式指定` `"config_general/debugmodel"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1bfdabd9` / `getOptions` | `"post"` `"config_general/getConfigOption"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `1bfdabd9` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getDetail` |
| `1bfdabd9` / `submitForm` | `"post"` `"config_general/debugmodel"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getDetail` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p106"></a>

## 本地化设置 `/general-settings/local`

旧版证据：[P106](27-admin-built-page-evidence.md#p106)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“本地化设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a386/144decbf` | `el-form-item` | `默认语言 ($lang.default_language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a386/144decbf` | `el-form-item` | `启用语言选择菜单 ($lang.enable_language_menu)` / `allow_user_language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a386/144decbf` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a386/144decbf` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `a386/144decbf` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `144decbf` / `getData` | `未显式指定` `"config_general/local"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `144decbf` / `submitForm` | `"post"` `"config_general/local"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p107"></a>

## 支持设置 `/general-settings/support`

旧版证据：[P107](27-admin-built-page-evidence.md#p107)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“支持设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e932/2aa49380` | `el-form-item` | `工单回复列表顺序 ($lang.work_order_hf_list_sort)` / `ticket_reply_order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e932/2aa49380` | `el-form-item` | `客户工单需要登录 ($lang.kh_work_order_login)` / `nologin_send_ticket` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e932/2aa49380` | `el-form-item` | `包括产品下载 ($lang.product_download)` / `dl_incl_product` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e932/2aa49380` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e932/2aa49380` | `保存提交 ($lang.save_submit)` | `on.click → e.submitForm` | `无提取条件` |
| `e932/2aa49380` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2aa49380` / `getData` | `未显式指定` `"config_general/support"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `2aa49380` / `submitForm` | `"post"` `"config_general/support"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p108"></a>

## 推介设置 `/general-settings/promote`

旧版证据：[P108](27-admin-built-page-evidence.md#p108)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“推介设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a8c9/2e7295da` | `el-form-item` | `是否启用推介 ($lang.is_promotion_enabled)` / `affiliate_enabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `推介收入百分比 ($lang.promotion_revenue_bfb)` / `affiliate_percent` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `推介红利 ($lang.promotion_bonus)` / `affiliate_bonusde_posit` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `推介支付金额 ($lang.promotion_payment_amount)` / `affiliate_payout` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `推介佣金延迟时间 ($lang.promotion_commission_delay_time)` / `affiliate_delay_commission` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `支持请求部门 ($lang.support_request_department)` / `affiliate_department` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `推介链接 ($lang.support_href)` / `affiliate_links` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a8c9/2e7295da` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a8c9/2e7295da` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `a8c9/2e7295da` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2e7295da` / `getData` | `未显式指定` `"config_general/affiliate"` (无显式 data/params) | `GET {A}/config_general/affiliate` → `admin/config_general/getAffiliate`；规则 `app\admin\controller\ConfigGeneralcontroller::getaffiliate`；[源行](../../data/route/admin.php#L303) | 未提取；新设计明确成功后重读受影响对象 |
| `2e7295da` / `submitForm` | `"post"` `"config_general/affiliate"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p109"></a>

## 安全设置 `/general-settings/safe`

旧版证据：[P109](27-admin-built-page-evidence.md#p109)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“安全设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `ffae/500dc672` | `el-form-item` | `密码强度 ($lang.pwd_strength)` / `required_pwstrength` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ffae/500dc672` | `el-form-item` | `管理员无法登录时长 ($lang.admin_not_log_time)` / `invalid_logins_banlength` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ffae/500dc672` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `ffae/500dc672` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `ffae/500dc672` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `500dc672` / `getData` | `未显式指定` `"config_general/safe"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `500dc672` / `submitForm` | `"post"` `"config_general/safe"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p110"></a>

## 其他设置 `/general-settings/other`

旧版证据：[P110](27-admin-built-page-evidence.md#p110)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“其他设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fe46/0445d179` | `el-form-item` | `注册时选填字段 ($lang.optional_fields_for_registration)` / `clients_profoptional` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fe46/0445d179` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fe46/0445d179` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `fe46/0445d179` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0445d179` / `getData` | `未显式指定` `"config_general/other"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0445d179` / `submitForm` | `"post"` `"config_general/other"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p111"></a>

## 账单设置 `/general-settings/invoice`

旧版证据：[P111](27-admin-built-page-evidence.md#p111)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“账单设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f769/23d8c836` | `el-form-item` | `客户选择网关 ($lang.customer_chooses_gateway)` / `in_select_payment` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f769/23d8c836` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f769/23d8c836` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `f769/23d8c836` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `23d8c836` / `getData` | `未显式指定` `"config_general/invoice"` (无显式 data/params) | `GET {A}/config_general/invoice` → `admin/config_general/getInvoice`；规则 `app\admin\controller\ConfigGeneralcontroller::getinvoice`；[源行](../../data/route/admin.php#L310)<br>`POST {A}/config_general/invoice` → `admin/config_general/postInvoice`；规则 `app\admin\controller\ConfigGeneralcontroller::postinvoice`；[源行](../../data/route/admin.php#L311) | 未提取；新设计明确成功后重读受影响对象 |
| `23d8c836` / `submitForm` | `"post"` `"config_general/invoice"` (data) | `POST {A}/config_general/invoice` → `admin/config_general/postInvoice`；规则 `app\admin\controller\ConfigGeneralcontroller::postinvoice`；[源行](../../data/route/admin.php#L311) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p112"></a>

## 登录设置 `/general-settings/login-setting`

旧版证据：[P112](27-admin-built-page-evidence.md#p112)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“登录设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `202eb/5e3ec2d6` | `el-tab-pane` | `基础设置 ($lang.basic)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `202eb/5e3ec2d6` | `el-form-item` | `客户注册 ($lang.customer_registration)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-form-item` | `客户登录 ($lang.customer_login)` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-form-item` | `邮箱注册是否需要验证 ($lang.mailbox_registration_needs_validated)` / `allow_email_register_code` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-form-item` | `注册时选填字段 ($lang.optional_fields_for_registration)` / `clients_profoptional` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-tab-pane` | `第三方登录 ($lang.third_party_login)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `202eb/5e3ec2d6` | `el-switch` | `-` / `-` / `-` | `"active"===e.radio; 循环 e.activeList` | 分组表单；未知原值不置空 |
| `202eb/5e3ec2d6` | `el-form-item` | `r` / `""` / `-` | `"active"===e.radio; 循环 e.activeList; 循环 t.config` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `202eb/5e3ec2d6` | `图标/动态文案，回查原证据` | `on.change → function(a){return e.suspend(t)}` | `"active"===e.radio; 循环 e.activeList` |
| `202eb/5e3ec2d6` | `保存 ($lang.save)` | `on.click → function(a){return e.submit(t)}` | `"active"===e.radio; 循环 e.activeList` |
| `202eb/5e3ec2d6` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `"base"===e.activeName` |
| `202eb/5e3ec2d6` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `"base"===e.activeName` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5e3ec2d6` / `getData` | `未显式指定` `"config_general/register_login_page"` (无显式 data/params) | `GET {A}/config_general/register_login_page` → `admin/config_general/registerLoginPage`；规则 `app\admin\controller\ConfigGeneralcontroller::registerloginpage`；[源行](../../data/route/admin.php#L324) | 未提取；新设计明确成功后重读受影响对象 |
| `5e3ec2d6` / `submitForm` | `"post"` `"config_general/register_login"` (data) | `POST {A}/config_general/register_login` → `admin/config_general/registerLogin`；规则 `app\admin\controller\ConfigGeneralcontroller::registerlogin`；[源行](../../data/route/admin.php#L325) | `getData` |
| `5e3ec2d6` / `getOauth` | `未显式指定` `"oauth"` (无显式 data/params) | `GET {A}/oauth` → `admin/oauth/listing`；规则 `app\admin\controller\Oauthcontroller::listing`；[源行](../../data/route/admin.php#L166) | 未提取；新设计明确成功后重读受影响对象 |
| `5e3ec2d6` / `getOauthConfig` | `未显式指定` `"oauth/config"` (无显式 data/params) | `GET {A}/oauth/config` → `admin/oauth/config`；规则 `app\admin\controller\Oauthcontroller::config`；[源行](../../data/route/admin.php#L168) | 未提取；新设计明确成功后重读受影响对象 |
| `5e3ec2d6` / `setItem` | `"post"` `"oauth/active"` (data) | `POST {A}/oauth/active` → `admin/oauth/active`；规则 `app\admin\controller\Oauthcontroller::active`；[源行](../../data/route/admin.php#L167) | `getOauth`、`getOauthConfig` |
| `5e3ec2d6` / `submit` | `"post"` `"oauth/config_post"` (data) | `POST {A}/oauth/config_post` → `admin/oauth/configSave`；规则 `app\admin\controller\Oauthcontroller::configsave`；[源行](../../data/route/admin.php#L169) | `getOauth`、`getOauthConfig` |
| `5e3ec2d6` / `suspend` | `"post"` `"oauth/suspend"` (data) | `POST {A}/oauth/suspend` → `admin/oauth/suspend`；规则 `app\admin\controller\Oauthcontroller::suspend`；[源行](../../data/route/admin.php#L170) | `getOauth`、`getOauthConfig` |
| `5e3ec2d6` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p113"></a>

## 验证码设置 `/general-settings/captcha`

旧版证据：[P113](27-admin-built-page-evidence.md#p113)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“验证码设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c925/4308f7f0` | `el-tab-pane` | `验证码设置 ($lang.verification_code_setting)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `c925/4308f7f0` | `el-form-item` | `验证码方式 ($lang.verification_code_mode)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `图形验证码是否开启 ($lang.img_code_open)` / `is_captcha` / `-` | `0==a.codemode` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-switch` | `-` / `-` / `-` | `0==a.codemode` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `图形验证码长度 ($lang.img_code_length)` / `captcha_length` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `图形验证码组合 ($lang.img_code_zh)` / `captcha_combination` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `请选择图形验证码开启范围 ($lang.please_select_img_code_open_fw)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `客户注册 ($lang.customer_registration)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `客户登录 ($lang.customer_login)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `忘记密码 ($lang.forget_password1)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `安全中心 ($lang.security_center)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `后台登录 ($lang.background_login)` / `-` / `-` | `0==a.codemode; 1===a.formData.is_captcha` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `-` / `-` / `-` | `1==a.codemode` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-tab-pane` | `安全设置 ($lang.auto_start_captcha)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `c925/4308f7f0` | `el-form-item` | `是否自动启动验证码 ($lang.yes_no_auto_start_captcha)` / `login_error_switch` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c925/4308f7f0` | `el-form-item` | `请输入账号密码填写错误次数（超出该次数后，将自动启动验证码） ($lang.error_cs_tips_text)` / `login_error_max_num` / `-` | `1==a.autoCapForm.login_error_switch` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c925/4308f7f0` | `保存更改 ($lang.save_the_changes)` | `on.click → a.submitForm` | `无提取条件` |
| `c925/4308f7f0` | `取消更改 ($lang.cancel_changes)` | `on.click → a.resetForm` | `无提取条件` |
| `c925/4308f7f0` | `保存更改 ($lang.save_the_changes)` | `on.click → a.submitAutoForm` | `无提取条件` |
| `c925/4308f7f0` | `取消更改 ($lang.cancel_changes)` | `on.click → a.resetAutoForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4308f7f0` / `getDetail` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `4308f7f0` / `getData` | `未显式指定` `"config_general/captcha_page"` (无显式 data/params) | `GET {A}/config_general/captcha_page` → `admin/config_general/getcaptcha_page`；规则 `app\admin\controller\ConfigGeneralcontroller::getcaptcha_page`；[源行](../../data/route/admin.php#L326)<br>`GET {A}/config_general/captcha_page` → `admin/ConfigGeneral/getcaptcha_page`；规则 `app\admin\controller\ConfigGeneralcontroller::getcaptcha_page`；[源行](../../app/admin/controller/ConfigGeneralController.php#L1848) | 未提取；新设计明确成功后重读受影响对象 |
| `4308f7f0` / `submitForm` | `"post"` `"config_general/register_login_captcha"` (data) | `POST {A}/config_general/register_login_captcha` → `admin/config_general/postregister_login_captcha`；规则 `app\admin\controller\ConfigGeneralcontroller::postregister_login_captcha`；[源行](../../data/route/admin.php#L327)<br>`POST {A}/config_general/register_login_captcha` → `admin/ConfigGeneral/postregister_login_captcha`；规则 `app\admin\controller\ConfigGeneralcontroller::postregister_login_captcha`；[源行](../../app/admin/controller/ConfigGeneralController.php#L1898) | `getData` |
| `4308f7f0` / `submitAutoForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getDetail` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p114"></a>

## 财务设置 `/general-settings/finance`

旧版证据：[P114](27-admin-built-page-evidence.md#p114)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“财务设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3f5b/b6b1be38` | `el-form-item` | `是否启用充值 ($lang.enable_recharge)` / `addfunds_enabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-form-item` | `最小金额 ($lang.minimum_amount)` / `addfunds_minimum` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-form-item` | `最大金额 ($lang.maximum_amount)` / `addfunds_maximum` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-form-item` | `最高余额 ($lang.maximum_balance)` / `addfunds_maximum_balance` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-form-item` | `需要已激活的订单 ($lang.activated_order_required)` / `addfunds_require_order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/b6b1be38` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/-` | `el-form-item` | `降级退款至余额 ($lang.downgrade_refund_to_balance)` / `upgrade_down_product_config` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/-` | `el-form-item` | `起始账单号自定义 ($lang.start_bill_number_customization)` / `allow_custom_invoice_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f5b/-` | `el-form-item` | `下个账单ID起始值 ($lang.next_bill_id_start_number)` / `custom_invoice_id_start` / `-` | `"1"===e.formData.allow_custom_invoice_id` | 分组表单；未知原值不置空 |
| `3f5b/33d4cde1` | `el-tab-pane` | `充值 ($lang.recharge)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3f5b/33d4cde1` | `el-tab-pane` | `财务 ($lang.finance)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3f5b/b6b1be38` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `3f5b/b6b1be38` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |
| `3f5b/-` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `3f5b/-` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `b6b1be38` / `getData` | `未显式指定` `"config_general/recharge"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `b6b1be38` / `submitForm` | `"post"` `"config_general/recharge"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `-` / `getData` | `未显式指定` `"config_general/invoice_page"` (无显式 data/params) | `GET {A}/config_general/invoice_page` → `admin/config_general/invoicePage`；规则 `app\admin\controller\ConfigGeneralcontroller::invoicepage`；[源行](../../data/route/admin.php#L328) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitForm` | `"post"` `"config_general/invoice_post"` (data) | `POST {A}/config_general/invoice_post` → `admin/config_general/invoicePost`；规则 `app\admin\controller\ConfigGeneralcontroller::invoicepost`；[源行](../../data/route/admin.php#L329) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p115"></a>

## 订单设置 `/general-settings/order`

旧版证据：[P115](27-admin-built-page-evidence.md#p115)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“订单设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e979/e7cd471a` | `el-form-item` | `购买时强制手机绑定 ($lang.phone_binding)` / `custom_invoice_id_start` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e979/e7cd471a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e979/e7cd471a` | `el-form-item` | `购买时强制实名认证 ($lang.compulsory_real_name_authentication)` / `certifi_isrealname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e979/e7cd471a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e979/e7cd471a` | `el-form-item` | `商品订购样式 ($lang.product_order_style)` / `order_page_style` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e979/e7cd471a` | `保存更改 ($lang.save_the_changes)` | `on.click → t.submitForm` | `无提取条件` |
| `e979/e7cd471a` | `取消更改 ($lang.cancel_changes)` | `on.click → t.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `e7cd471a` / `getData` | `未显式指定` `"config_general/buy_product_page"` (params) | `GET {A}/config_general/buy_product_page` → `admin/config_general/getBuyProductPage`；规则 `app\admin\controller\ConfigGeneralcontroller::getbuyproductpage`；[源行](../../data/route/admin.php#L334) | 未提取；新设计明确成功后重读受影响对象 |
| `e7cd471a` / `submitForm` | `"post"` `"config_general/buy_product"` (data) | `POST {A}/config_general/buy_product` → `admin/config_general/postBuyProduct`；规则 `app\admin\controller\ConfigGeneralcontroller::postbuyproduct`；[源行](../../data/route/admin.php#L335) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p116"></a>

## 分类设置 `/general-settings/class`

旧版证据：[P116](27-admin-built-page-evidence.md#p116)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“分类设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `99c0/689196c6` | `el-form-item` | `""` / `""` / `-` | `循环 e.classArr` | 分组表单；未知原值不置空 |
| `99c0/689196c6` | `el-dialog` | `-` / `-` / `删除产品分类 ($lang.del_product_category)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `99c0/689196c6` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `99c0/689196c6` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |
| `99c0/689196c6` | `取消 ($lang.cancel)` | `on.click → function(n){e.dialogVisible=!1}` | `无提取条件` |
| `99c0/689196c6` | `确定 ($lang.confirm)` | `on.click → e.deleteConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `689196c6` / `getData` | `未显式指定` `"config_general/productgroup_page"` (无显式 data/params) | `GET {A}/config_general/productgroup_page` → `admin/config_general/productgroupPage`；规则 `app\admin\controller\ConfigGeneralcontroller::productgrouppage`；[源行](../../data/route/admin.php#L330) | 未提取；新设计明确成功后重读受影响对象 |
| `689196c6` / `deleteConfirm` | `"post"` `"config_general/productgroup"` (data) | `POST {A}/config_general/productgroup` → `admin/config_general/productGroupPost`；规则 `app\admin\controller\ConfigGeneralcontroller::productgrouppost`；[源行](../../data/route/admin.php#L332) | `getData` |
| `689196c6` / `submitForm` | `"post"` `"config_general/productgroup"` (data) | `POST {A}/config_general/productgroup` → `admin/config_general/productGroupPost`；规则 `app\admin\controller\ConfigGeneralcontroller::productgrouppost`；[源行](../../data/route/admin.php#L332) | `getData` |
| `689196c6` / `rowDrag` | `未显式指定` `"config_general/navgrouporder"` (params) | `GET {A}/config_general/navgrouporder` → `admin/config_general/navGroupOrder`；规则 `app\admin\controller\ConfigGeneralcontroller::navgrouporder`；[源行](../../data/route/admin.php#L333) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p117"></a>

## 资源 API 设置 `/general-settings/source-api`

旧版证据：[P117](27-admin-built-page-evidence.md#p117)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/general-settings`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“资源 API 设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e485/-` | `el-form-item` | `是否开启资源API ($lang.open_resource_API)` / `allow_resource_api` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e485/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e485/-` | `el-form-item` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `e485/-` | `el-form-item` | `是否需要实名认证 ($lang.real_name_authentication)` / `allow_resource_api_realname` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `e485/-` | `el-switch` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `e485/-` | `el-form-item` | `是否需要绑定手机号 ($lang.binding_mobile_phone)` / `allow_resource_api_phone` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `e485/-` | `el-switch` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e485/-` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `e485/-` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"config_general/apiconfig"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitForm` | `"post"` `"config_general/apiconfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p118"></a>

## 二次验证兼容入口 `/second`

旧版证据：[P118](27-admin-built-page-evidence.md#p118)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“二次验证兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6d57/536c1218` | `el-form-item` | `前台二次验证是否开启 ($lang.two_secondary_is_on)` / `second_verify_home` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-form-item` | `前台验证方式 ($lang.foreground_verification_method)` / `second_verify_action_home_type` / `-` | `"1"===e.formData.second_verify_home` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-form-item` | `前台动作 ($lang.front_desk_action)` / `second_verify_action_home` / `-` | `"1"===e.formData.second_verify_home` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-form-item` | `后台二次验证是否开启 ($lang.two_secondary_is_on_last)` / `second_verify_admin` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6d57/536c1218` | `el-form-item` | `后台动作 ($lang.last_desk_action)` / `second_verify_action_admin` / `-` | `"1"===e.formData.second_verify_admin` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6d57/536c1218` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `6d57/536c1218` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `536c1218` / `getPageData` | `未显式指定` `"config_general/secondverify"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `536c1218` / `submitApi` | `"post"` `"config_general/secondverify"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getPageData` |
| `536c1218` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p121"></a>

## 员工管理 `/admin-management`

旧版证据：[P121](27-admin-built-page-evidence.md#p121)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“员工管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b98d/5a099565` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `真实名称 ($lang.real_name_des)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `邮件地址 ($lang.email_address_text)` / `user_email` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `用户名 ($lang.user_name)` / `user_login` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `管理员角色 ($lang.management_role)` / `role` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `分配到的部门 ($lang.fpddbm)` / `dept` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `是否是销售 ($lang.is_sales)` / `is_sale` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `销售是否启用 ($lang.sales_is_open)` / `sale_is_use` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b98d/5a099565` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `b98d/5a099565` | `添加员工 ($lang.add_employee)` | `on.click → e.toAdd` | `无提取条件` |
| `b98d/5a099565` | `编辑` | `on.click → function(n){return e.editAdmin(t.$index,t.row)}` | `scopedSlots` |
| `b98d/5a099565` | `删除 ($lang.delete)` | `on.click → function(n){return e.deleteAdmin(t.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5a099565` / `getAdminData` | `未显式指定` `"adminuser"` (params) | `GET {A}/adminuser` → `admin/user/adminList`；规则 `app\admin\controller\Usercontroller::adminlist`；[源行](../../data/route/admin.php#L143)<br>`POST {A}/adminuser` → `admin/user/create`；规则 `app\admin\controller\Usercontroller::create`；[源行](../../data/route/admin.php#L145) | 未提取；新设计明确成功后重读受影响对象 |
| `5a099565` / `deleteAdmin` | `"delete"` `"adminuser/".concat(e,"/")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getAdminData` |
| `5a099565` / `handleSizeChange` | `未显式指定` `"adminuser"` (params) | `GET {A}/adminuser` → `admin/user/adminList`；规则 `app\admin\controller\Usercontroller::adminlist`；[源行](../../data/route/admin.php#L143)<br>`POST {A}/adminuser` → `admin/user/create`；规则 `app\admin\controller\Usercontroller::create`；[源行](../../data/route/admin.php#L145) | 未提取；新设计明确成功后重读受影响对象 |
| `5a099565` / `handleCurrentChange` | `未显式指定` `"adminuser"` (params) | `GET {A}/adminuser` → `admin/user/adminList`；规则 `app\admin\controller\Usercontroller::adminlist`；[源行](../../data/route/admin.php#L143)<br>`POST {A}/adminuser` → `admin/user/create`；规则 `app\admin\controller\Usercontroller::create`；[源行](../../data/route/admin.php#L145) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`editAdmin: n.$router.push({name:"adminEdit",query:{id:t.id}})`
- 旧跳转：`toAdd: this.$router.push({name:"adminEdit"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p122"></a>

## 员工编辑 `/admin-edit`

旧版证据：[P122](27-admin-built-page-evidence.md#p122)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“员工编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `343a/67239e5a` | `el-form-item` | `员工角色 ($lang.employee_role)` / `1===e.formData.id?"":"adminName"` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `用户名 ($lang.user_name)` / `userName` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `真实姓名 ($lang.real_user_name)` / `realName` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `邮箱 ($lang.email)` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `密码 ($lang.password)` / `pwd` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `确认密码 ($lang.confirm_password)` / `confirmPwd` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `语言 ($lang.language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `" "` / `disable` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `" "` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `工单部门 ($lang.work_order_department)` / `department` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `343a/67239e5a` | `el-form-item` | `工单签名 ($lang.work_order_signature)` / `signature` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `343a/67239e5a` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `343a/67239e5a` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `343a/67239e5a` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `67239e5a` / `createApi` | `"post"` `"adminuser"` (data) | `POST {A}/adminuser` → `admin/user/create`；规则 `app\admin\controller\Usercontroller::create`；[源行](../../data/route/admin.php#L145) | `assignment` |
| `67239e5a` / `editApi` | `"post"` `"adminuser/update"` (data) | `POST {A}/adminuser/update` → `admin/user/update`；规则 `app\admin\controller\Usercontroller::update`；[源行](../../data/route/admin.php#L147) | `assignment`、`editInit` |
| `67239e5a` / `editInit` | `"get"` `"adminuser/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `67239e5a` / `addInit` | `未显式指定` `"create_page"` (无显式 data/params) | `GET {A}/create_page` → `admin/user/createPage`；规则 `app\admin\controller\Usercontroller::createpage`；[源行](../../data/route/admin.php#L144) | 未提取；新设计明确成功后重读受影响对象 |
| `67239e5a` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`createApi: e.$router.push({name:"adminManagement"})`
- 旧跳转：`editApi: e.$router.push({name:"adminManagement"})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p123"></a>

## 黑名单 `/black-list`

旧版证据：[P123](27-admin-built-page-evidence.md#p123)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“黑名单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a0d2/1b95b668` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a0d2/1b95b668` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a0d2/1b95b668` | `el-table-column` | `操作类型 ($lang.operation_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a0d2/1b95b668` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a0d2/1b95b668` | `el-table-column` | `登录时间 ($lang.login_date)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `a0d2/1b95b668` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a0d2/1b95b668` | `解除禁用 ($lang.clear_forbidden)` | `on.click → function(e){return t.removeBlack(n)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1b95b668` / `getData` | `未显式指定` `"user/get_black_list"` (无显式 data/params) | `GET {A}/user/get_black_list` → `admin/user/getBlackList`；规则 `app\admin\controller\Usercontroller::getblacklist`；[源行](../../data/route/admin.php#L153) | 未提取；新设计明确成功后重读受影响对象 |
| `1b95b668` / `removeBlack` | `"post"` `"user/remove_black_list"` (data) | `POST {A}/user/remove_black_list` → `admin/user/removeBlackList`；规则 `app\admin\controller\Usercontroller::removeblacklist`；[源行](../../data/route/admin.php#L154) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p124"></a>

## 邮件模板管理 `/email-list`

旧版证据：[P124](27-admin-built-page-evidence.md#p124)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“邮件模板管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `bd23/fa7fa6b4` | `el-table-column` | `ID` / `id` / `-` | `循环 e.email_list` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bd23/fa7fa6b4` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `循环 e.email_list` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bd23/fa7fa6b4` | `el-switch` | `-` / `-` / `-` | `循环 e.email_list; scopedSlots` | 分组表单；未知原值不置空 |
| `bd23/fa7fa6b4` | `el-table-column` | `模板名称 ($lang.template_name)` / `-` / `-` | `循环 e.email_list` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bd23/fa7fa6b4` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `循环 e.email_list` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `bd23/fa7fa6b4` | `el-dialog` | `-` / `-` / `创建新的邮件模板 ($lang.add_new_email_template)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `bd23/fa7fa6b4` | `el-form-item` | `Email Type` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `bd23/fa7fa6b4` | `el-form-item` | `邮件识别名称 ($lang.email_identification_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `bd23/fa7fa6b4` | `el-dialog` | `-` / `-` / `语言管理 ($lang.language_management)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `bd23/fa7fa6b4` | `el-form-item` | `请选择语言 ($lang.select_language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `bd23/fa7fa6b4` | `el-dialog` | `-` / `-` / `邮件测试` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `bd23/fa7fa6b4` | `el-form-item` | `邮箱：` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `bd23/fa7fa6b4` | `添加邮件模板 ($lang.add_email_template)` | `on.click → e.getEmailData` | `无提取条件` |
| `bd23/fa7fa6b4` | `语言管理 ($lang.language_management)` | `on.click → e.languageManage` | `无提取条件` |
| `bd23/fa7fa6b4` | `切换` | `on.click → e.handleSwitchOperator` | `无提取条件` |
| `bd23/fa7fa6b4` | `邮件测试` | `on.click → e.testEmailHandler` | `无提取条件` |
| `bd23/fa7fa6b4` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.disableEmail(n)}` | `循环 e.email_list; scopedSlots` |
| `bd23/fa7fa6b4` | `t.row.name` | `on.click → function(a){return e.goToEdit(t.row.id,"view")}` | `循环 e.email_list; scopedSlots` |
| `bd23/fa7fa6b4` | `编辑 ($lang.edit)` | `on.click → function(t){return e.goToEdit(n.id)}` | `循环 e.email_list; scopedSlots` |
| `bd23/fa7fa6b4` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteEmail(n.id)}` | `循环 e.email_list; scopedSlots` |
| `bd23/fa7fa6b4` | `取消 ($lang.cancel)` | `on.click → e.cancel` | `无提取条件` |
| `bd23/fa7fa6b4` | `确定 ($lang.confirm)` | `on.click → e.createEmail` | `无提取条件` |
| `bd23/fa7fa6b4` | `禁用 ($lang.forbidden)` | `on.click → function(a){return e.disabled(t)}` | `循环 e.langList` |
| `bd23/fa7fa6b4` | `取消 ($lang.cancel)` | `on.click → e.cancelLang` | `无提取条件` |
| `bd23/fa7fa6b4` | `确定 ($lang.confirm)` | `on.click → e.addLanguage` | `无提取条件` |
| `bd23/fa7fa6b4` | `取消 ($lang.cancel)` | `on.click → e.testEmailClosed` | `无提取条件` |
| `bd23/fa7fa6b4` | `确定 ($lang.confirm)` | `on.click → e.submitTestEmail` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `fa7fa6b4` / `submitTestEmail` | `"post"` `"config_message/send_email"` (data) | `POST {A}/config_message/send_email` → `admin/config_message/sendEmailTest`；规则 `app\admin\controller\ConfigMessagecontroller::sendemailtest`；[源行](../../data/route/admin.php#L374) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `getData` | `未显式指定` `"email_template/email_list"` (无显式 data/params) | `GET {A}/email_template/email_list` → `admin/email_template/emailList`；规则 `app\admin\controller\EmailTemplatecontroller::emaillist`；[源行](../../data/route/admin.php#L276) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `getEmailData` | `未显式指定` `"email_template/create_template"` (无显式 data/params) | `GET {A}/email_template/create_template` → `admin/email_template/createTemplate`；规则 `app\admin\controller\EmailTemplatecontroller::createtemplate`；[源行](../../data/route/admin.php#L278) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `createEmail` | `"post"` `"email_template/create_template_post"` (data) | `POST {A}/email_template/create_template_post` → `admin/email_template/createTemplatePost`；规则 `app\admin\controller\EmailTemplatecontroller::createtemplatepost`；[源行](../../data/route/admin.php#L279) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `deleteEmail` | `未显式指定` `"email_template/delete_template/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `fa7fa6b4` / `disableEmail` | `"post"` `"email_template/disabled_template"` (data) | `POST {A}/email_template/disabled_template` → `admin/email_template/disabledTemplate`；规则 `app\admin\controller\EmailTemplatecontroller::disabledtemplate`；[源行](../../data/route/admin.php#L286) | `getData` |
| `fa7fa6b4` / `languageManage` | `未显式指定` `"email_template/manage_language"` (无显式 data/params) | `GET {A}/email_template/manage_language` → `admin/email_template/manageLanguages`；规则 `app\admin\controller\EmailTemplatecontroller::managelanguages`；[源行](../../data/route/admin.php#L282) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `disabled` | `"post"` `"email_template/disabled"` (data) | `POST {A}/email_template/disabled` → `admin/email_template/disabled`；规则 `app\admin\controller\EmailTemplatecontroller::disabled`；[源行](../../data/route/admin.php#L284) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `addLanguage` | `"post"` `"email_template/manage_language_post"` (data) | `POST {A}/email_template/manage_language_post` → `admin/email_template/manageLanguagesPost`；规则 `app\admin\controller\EmailTemplatecontroller::managelanguagespost`；[源行](../../data/route/admin.php#L283) | 未提取；新设计明确成功后重读受影响对象 |
| `fa7fa6b4` / `handleSwitchOperator` | `"post"` `"email_template/operator_switch"` (data) | `POST {A}/email_template/operator_switch` → `admin/email_template/emailOperatorSwitch`；规则 `app\admin\controller\EmailTemplatecontroller::emailoperatorswitch`；[源行](../../data/route/admin.php#L277) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`createEmail: e.$router.push("/email-edit?id=".concat(e.id))`
- 旧跳转：`goToEdit: this.$router.push({path:"/email-edit",query:{id:e,type:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p125"></a>

## 邮件模板编辑 `/email-edit`

旧版证据：[P125](27-admin-built-page-evidence.md#p125)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 名称/分类等基础字段 → 正文编辑器 → 变量/附件与预览 → 保存区。预览与提交分开，预览内容不执行非可信脚本。

**手机排版**：基础字段单列，正文占满内容宽；编辑工具可横向滚动，预览独立展示并保留返回草稿。

**本页专项约束**：围绕“邮件模板编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `45d6/bfadcfdc` | `el-form-item` | `附件 ($lang.attachment)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `45d6/bfadcfdc` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `45d6/bfadcfdc` | `el-form-item` | `是否禁用 ($lang.whether_to_disable)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `45d6/bfadcfdc` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `45d6/bfadcfdc` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `bfadcfdc` / `getData` | `未显式指定` `"email_template/edit_template/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `bfadcfdc` / `submitForm` | `"post"` `"email_template/edit_template_post"` (data) | `POST {A}/email_template/edit_template_post` → `admin/email_template/editTemplatePost`；规则 `app\admin\controller\EmailTemplatecontroller::edittemplatepost`；[源行](../../data/route/admin.php#L281) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.push("/email-list")`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p127"></a>

## 分组权限 `/permissions-managment`

旧版证据：[P127](27-admin-built-page-evidence.md#p127)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“分组权限”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `42e6/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-table-column` | `分组名称 ($lang.group_name2)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-table-column` | `说明 ($lang.explain)` / `remark` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-table-column` | `组成员 ($lang.group_menbers)` / `user_login` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `42e6/-` | `el-dialog` | `-` / `-` / `复制分组 ($lang.copy_a_group)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `42e6/-` | `el-form-item` | `原分组： ($lang.old_group)` / `role_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `42e6/-` | `el-form-item` | `新分组名称： ($lang.new_group_name1)` / `role_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `42e6/-` | `el-form-item` | `新分组说明： ($lang.new_group_desc)` / `role_remark` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `42e6/-` | `添加分组 ($lang.add_a_group)` | `on.click → e.permissionsAdd` | `无提取条件` |
| `42e6/-` | `复制分组 ($lang.copy_a_group)` | `on.click → function(t){e.dialogVisible=!0}` | `无提取条件` |
| `42e6/-` | `编辑 ($lang.edit)` | `on.click → function(a){return e.handleEdit(t.$index,t.row)}` | `scopedSlots` |
| `42e6/-` | `删除 ($lang.delete)` | `on.click → function(a){return e.handleDelete(t.$index,t.row)}` | `scopedSlots` |
| `42e6/-` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogVisible=!1}` | `无提取条件` |
| `42e6/-` | `确定 ($lang.confirm)` | `on.click → e.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `submit` | `"post"` `"rbac/copyRole"` (data) | `POST {A}/rbac/copyRole` → `admin/rbac/copyRole`；规则 `app\admin\controller\Rbaccontroller::copyrole`；[源行](../../data/route/admin.php#L134) | `getList` |
| `-` / `getList` | `"get"` `"rbac"` (无显式 data/params) | `GET {A}/rbac` → `admin/rbac/index`；规则 `app\admin\controller\Rbaccontroller::index`；[源行](../../data/route/admin.php#L128) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `deletePermiss` | `"delete"` `"rbac/"+e+"/"` (无显式 data/params) | `DELETE {A}/rbac/:id/` → `admin/rbac/delete`；规则 `app\admin\controller\Rbaccontroller::delete`；[源行](../../data/route/admin.php#L133) | `getList` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`handleEdit: this.$router.push({name:"permissionsEdit",query:{id:t.id}})`
- 旧跳转：`permissionsAdd: this.$router.push({name:"permissionsEdit"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p128"></a>

## 权限组编辑 `/permissions-edit`

旧版证据：[P128](27-admin-built-page-evidence.md#p128)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“权限组编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7db2/b5276ae2` | `el-form-item` | `分组名称 ($lang.group_name2)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7db2/b5276ae2` | `el-form-item` | `描述 ($lang.describe)` / `remark` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7db2/b5276ae2` | `el-form-item` | `权限 ($lang.jurisdiction)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7db2/b5276ae2` | `el-form-item` | `禁用 ($lang.forbidden)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7db2/b5276ae2` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7db2/b5276ae2` | `el-form-item` | `分组用户 ($lang.group_user)` / `user` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7db2/b5276ae2` | `全选 ($lang.select_all)` | `on.click → e.checkAll` | `无提取条件` |
| `7db2/b5276ae2` | `取消全选 ($lang.select_all_clear)` | `on.click → e.cancelAll` | `无提取条件` |
| `7db2/b5276ae2` | `提交 ($lang.submit)` | `on.click → e.saveData` | `无提取条件` |
| `7db2/b5276ae2` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `7db2/b5276ae2` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `b5276ae2` / `detailPermiss` | `"get"` `"rbac/role_page"` (无显式 data/params) | `GET {A}/rbac/role_page` → `admin/rbac/addRolePage`；规则 `app\admin\controller\Rbaccontroller::addrolepage`；[源行](../../data/route/admin.php#L129) | 未提取；新设计明确成功后重读受影响对象 |
| `b5276ae2` / `detailPermiss` | `"get"` `"rbac/"+e` (无显式 data/params) | `GET {A}/rbac/role_page` → `admin/rbac/addRolePage`；规则 `app\admin\controller\Rbaccontroller::addrolepage`；[源行](../../data/route/admin.php#L129)<br>`GET {A}/rbac/:id` → `admin/rbac/editRolePage`；规则 `app\admin\controller\Rbaccontroller::editrolepage`；[源行](../../data/route/admin.php#L131) | 未提取；新设计明确成功后重读受影响对象 |
| `b5276ae2` / `createApi` | `"post"` `"rbac"` (data) | `POST {A}/rbac` → `admin/rbac/addRole`；规则 `app\admin\controller\Rbaccontroller::addrole`；[源行](../../data/route/admin.php#L130) | `empty`、`goBack` |
| `b5276ae2` / `editApi` | `"post"` `"rbac/edit"` (data) | `POST {A}/rbac/edit` → `admin/rbac/editRole`；规则 `app\admin\controller\Rbaccontroller::editrole`；[源行](../../data/route/admin.php#L132) | `empty`、`goBack` |
| `b5276ae2` / `getCommonData` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goBack: this.$router.push({name:"permissionsManagment"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p129"></a>

## 自动任务设置 `/automatic-tasks`

旧版证据：[P129](27-admin-built-page-evidence.md#p129)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“自动任务设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f4f4/c1f88282` | `el-form-item` | `定时任务执行时间 ($lang.timed_task_zx_time)` / `cron_day_start_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `产品/服务到期暂停 ($lang.ps_suspension_due)` / `cron_host_suspend` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_host_suspend_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `产品暂停通知 ($lang.product_suspension_notice)` / `cron_host_suspend_send` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `支付后自动解除暂停 ($lang.pay_last_auto_suspension)` / `cron_host_unsuspend` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `产品解除暂停通知 ($lang.product_suspension_rt)` / `cron_host_unsuspend_send` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `产品/服务到期后自动删除 ($lang.ps_suspension_auto_del)` / `cron_host_terminate` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_host_terminate_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `-` / `-` | `"1"===e.formData.cron_host_terminate` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `"1"===e.formData.cron_host_terminate` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `-` / `-` | `"1"===e.formData.cron_host_terminate` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-table-column` | `类型 ($lang.type)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `虚拟主机 ($lang.virtual_host)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `独立服务器 ($lang.standalone_server)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `云服务器 ($lang.colud_server)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `魔方云 ($lang.cube_cloud)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `魔方DCIM ($lang.rubik_cube_dcim)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `软件产品 ($lang.software_product)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `CDN` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-table-column` | `其他服务 ($lang.other_server)` / `-` / `-` | `"1"===e.formData.cron_host_terminate; "1"===e.formData.cron_host_terminate_high` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f4f4/c1f88282` | `el-form-item` | `续费通知并生成账单 ($lang.renew_not_generate_bill)` / `cron_invoice_create_default_days` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `账单未付款提醒邮件 ($lang.non_payment_reminder_email)` / `cron_invoice_pay_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_invoice_unpaid_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第一次提醒 ($lang.first_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_invoice_first_overdue_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第二次提醒 ($lang.two_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_invoice_second_overdue_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第三次提醒 ($lang.three_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_invoice_third_overdue_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `自动关闭工单 ($lang.auto_close_work_order)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_ticket_close_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `自动取消/删除订单 ($lang.auto_del_close_order)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_order_unpaid_time` / `-` | `1==e.formData.cron_order_unpaid_time_high` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `-` / `-` | `0==e.formData.cron_order_unpaid_time_high` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_order_unpaid_action` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `删除未付款充值账单 ($lang.del_outstanding_recharge_bill)` / `cron_invoice_recharge_delete1` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_invoice_recharge_delete_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `账单逾期自动暂停 ($lang.automatic_suspension_overdue_bills)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_credit_limit_suspend_time` / `-` | `1==e.val1` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `账单未付款提醒 ($lang.reminder_outstanding_bills)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_credit_limit_invoice_unpaid_email` / `-` | `1==e.val2` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第一次提醒 ($lang.first_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_credit_limit_invoice_first_overdue_email` / `-` | `1==e.val3` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第二次提醒 ($lang.two_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_credit_limit_invoice_second_overdue_email` / `-` | `1==e.val4` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `第三次提醒 ($lang.three_reminder)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f4f4/c1f88282` | `el-form-item` | `-` / `cron_credit_limit_invoice_third_overdue_email` / `-` | `1==e.val5` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChange("cron_host_suspend","cron_host_suspend_time")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChange("cron_host_terminate","cron_host_terminate_time")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChange("cron_invoice_pay_email","cron_invoice_unpaid_email")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChangeTwo("cron_invoice_first_overdue_email_switch","cron_invoice_first_overdue_email")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChangeTwo("cron_invoice_second_overdue_email_switch","cron_invoice_second_overdue_email")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChangeTwo("cron_invoice_third_overdue_email_switch","cron_invoice_third_overdue_email")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.cron_switchChangeTwo("cron_ticket_close_time_switch","cron_ticket_close_time")}` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → e.switchChange` | `无提取条件` |
| `f4f4/c1f88282` | `图标/动态文案，回查原证据` | `on.change → e.cron_invoice_recharge_deleteChange` | `无提取条件` |
| `f4f4/c1f88282` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `f4f4/c1f88282` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `c1f88282` / `autoTasksInit` | `未显式指定` `"cron_page"` (无显式 data/params) | `GET {A}/cron_page` → `admin/cron/detail`；规则 `app\admin\controller\Croncontroller::detail`；[源行](../../data/route/admin.php#L509) | `inputBlurTwo` |
| `c1f88282` / `submitForm` | `"post"` `"save_cron"` (data) | `POST {A}/save_cron` → `admin/cron/saveCron`；规则 `app\admin\controller\Croncontroller::savecron`；[源行](../../data/route/admin.php#L510) | `autoTasksInit` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p130"></a>

## 定时任务状态 `/timing-results`

旧版证据：[P130](27-admin-built-page-evidence.md#p130)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“定时任务状态”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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
| `7983bc9c` / `autoTasksInit` | `未显式指定` `"cron_page"` (无显式 data/params) | `GET {A}/cron_page` → `admin/cron/detail`；规则 `app\admin\controller\Croncontroller::detail`；[源行](../../data/route/admin.php#L509) | 未提取；新设计明确成功后重读受影响对象 |
| `7983bc9c` / `getList` | `未显式指定` `"run_cron/trend"` (params) | `GET {A}/run_cron/trend` → `admin/RunMap/runCronTrend`；规则 `app\admin\controller\RunMapcontroller::runcrontrend`；[源行](../../data/route/admin.php#L850) | `chartFunc` |
| `7983bc9c` / `getListTwo` | `未显式指定` `"run_cron/list"` (params) | `GET {A}/run_cron/list` → `admin/RunMap/runCronList`；规则 `app\admin\controller\RunMapcontroller::runcronlist`；[源行](../../data/route/admin.php#L851) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`pushTaskQueue: this.$router.push({path:"/statistics-taskQueue",query:{type:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p172"></a>

## 官网设置 `/official-setting`

旧版证据：[P172](27-admin-built-page-evidence.md#p172)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“官网设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `79c1/3db794f7` | `el-form-item` | `手机 ($lang.cellphone)` / `main_phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `地址 ($lang.address)` / `main_address` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `备案号 ($lang.internet_content_provider)` / `record_no` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `坐标 ($lang.coordinate)` / `map` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `官网LOGO ($lang.official_website_logo)` / `www_logo` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `关键字 ($lang.keyword)` / `seo_keywords` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `描述 ($lang.describe)` / `seo_desc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `公司简介 ($lang.company_profile_us)` / `company_profile` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `头部 ($lang.head)` / `header` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `底部 ($lang.bottom)` / `footer` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `是否开启登录页头底部 ($lang.whether_open_head_bottom)` / `login_header_footer` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `登录页头部 ($lang.Login_page_header)` / `login_header` / `-` | `"1"===e.generalFormData.login_header_footer` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `登录页底部 ($lang.Login_page_bottom)` / `login_footer` / `-` | `"1"===e.generalFormData.login_header_footer` | 分组表单；未知原值不置空 |
| `79c1/3db794f7` | `el-form-item` | `挂件 ($lang.pendant)` / `web_widgets` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `79c1/3db794f7` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `79c1/3db794f7` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3db794f7` / `getData` | `未显式指定` `"config_general/general"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3db794f7` / `submitForm` | `"post"` `"config_general/general"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p173"></a>

## 导航管理 `/menu_manage`

旧版证据：[P173](27-admin-built-page-evidence.md#p173)；归属：chunk 内候选，页面归属待人工确认。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：导航树、选中节点字段与链接目标分列；新建/修改/排序分别维护选中节点。原组件归属为候选，菜单与接口权限分开，未知目标不自动生成。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8842/4fe6e918` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `地址 ($lang.address)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `标签 ($lang.tag)` / `link_tag` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-dialog` | `-` / `-` / `e.linkForm.id?e.$lang.edit_link:e.$lang.add_link` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8842/4fe6e918` | `el-form-item` | `名称:` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `地址:` / `domain` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `标签:` / `link_tag` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `状态:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8842/4fe6e918` | `添加链接 ($lang.add_link)` | `on.click → function(t){e.dialogVisible=!0}` | `无提取条件` |
| `8842/4fe6e918` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `8842/4fe6e918` | `编辑 ($lang.edit)` | `on.click → function(t){return e.handleIsEditLink(a)}` | `scopedSlots` |
| `8842/4fe6e918` | `删除 ($lang.delete)` | `on.click → function(t){return e.handleDeleteLink(a.id)}` | `scopedSlots` |
| `8842/4fe6e918` | `确定 ($lang.confirm)` | `on.click → function(t){return e.handleEditLink("linkRef")}` | `无提取条件` |
| `8842/4fe6e918` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4fe6e918` / `getData` | `"GET"` `"menus/allLinks"` (params) | `GET {A}/menus/allLinks` → `admin/menus/allLinks`；规则 `app\admin\controller\Menuscontroller::alllinks`；[源行](../../data/route/admin.php#L857) | 未提取；新设计明确成功后重读受影响对象 |
| `4fe6e918` / `handleEditLink` | `"POST"` `"menus/saveLinks"` (data) | `POST {A}/menus/saveLinks` → `admin/menus/saveLinks`；规则 `app\admin\controller\Menuscontroller::savelinks`；[源行](../../data/route/admin.php#L855) | `getData` |
| `4fe6e918` / `handleDeleteLink` | `"POST"` `"menus/deleteLinks?id=".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p174"></a>

## 导航编辑 `/create_menu`

旧版证据：[P174](27-admin-built-page-evidence.md#p174)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“导航编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a046/04835ffa` | `el-form-item` | `导航名称： ($lang.name_navigation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `导航类型： ($lang.navigation_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-dialog` | `-` / `-` / `e.editFlag?e.$lang.edit_page:e.$lang.add_page` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `a046/04835ffa` | `el-form-item` | `页面类型： ($lang.page_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `-` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `多语言： ($lang.multilingual)` / `lang` / `-` | `e.addData.muti` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `-` / `language` / `-` | `e.addData.muti; e.addData.muti; e.addData.muti&&e.showLang` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `URL：` / `url` / `-` | `1==e.addData.type` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `标签：` / `tag` / `-` | `1==e.addData.type` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `-` / `pages` / `-` | `2==e.addData.type` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `选择页面： ($lang.select_page)` / `pages` / `-` | `3==e.addData.type` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `选择页面： ($lang.select_page)` / `pages` / `-` | `0==e.addData.type` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `图标： ($lang.icon)` / `icon` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `模板页 ($lang.template_page)` / `templatePage` / `-` | `1==e.addData.senior` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-form-item` | `订购功能 ($lang.order_function)` / `orderFuc` / `-` | `1==e.addData.senior` | 分组表单；未知原值不置空 |
| `a046/04835ffa` | `el-switch` | `-` / `-` / `-` | `1==e.addData.senior` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a046/04835ffa` | `保存更改 ($lang.save_the_changes)` | `on.click → e.saveChange` | `无提取条件` |
| `a046/04835ffa` | `取消更改 ($lang.cancel_changes)` | `on.click → e.cancelChange` | `无提取条件` |
| `a046/04835ffa` | `图标/动态文案，回查原证据` | `on.change → e.switchChange` | `1==e.addData.senior` |
| `a046/04835ffa` | `确定 ($lang.confirm)` | `on.click → e.addConfirm` | `无提取条件` |
| `a046/04835ffa` | `取消 ($lang.cancel)` | `on.click → e.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `04835ffa` / `getSeniorConfig` | `"post"` `"menus/getDefaultSenior"` (data) | `POST {A}/menus/getDefaultSenior` → `admin/menus/getDefaultSenior`；规则 `app\admin\controller\Menuscontroller::getdefaultsenior`；[源行](../../data/route/admin.php#L834) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `getLanguage` | `"post"` `"menus/getLang"` (data) | `POST {A}/menus/getLang` → `admin/menus/getLang`；规则 `app\admin\controller\Menuscontroller::getlang`；[源行](../../data/route/admin.php#L833) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `changeName` | `"post"` `"menus/getSystemNav"` (data) | `POST {A}/menus/getSystemNav` → `admin/menus/getSystemNav`；规则 `app\admin\controller\Menuscontroller::getsystemnav`；[源行](../../data/route/admin.php#L831) | `getLanguage`、`trasnLang` |
| `04835ffa` / `changeName` | `"post"` `"menus/getProductList"` (data) | `POST {A}/menus/getProductList` → `admin/menus/getProductList`；规则 `app\admin\controller\Menuscontroller::getproductlist`；[源行](../../data/route/admin.php#L823) | `getLanguage`、`trasnLang` |
| `04835ffa` / `addConfirm` | `"post"` `"menus/addCustomPage"` (data) | `POST {A}/menus/addCustomPage` → `admin/menus/addCustomPage`；规则 `app\admin\controller\Menuscontroller::addcustompage`；[源行](../../data/route/admin.php#L821) | `mapTree`、`saveChange` |
| `04835ffa` / `addConfirm` | `"post"` `"menus/addProductPage"` (data) | `POST {A}/menus/addProductPage` → `admin/menus/addProductPage`；规则 `app\admin\controller\Menuscontroller::addproductpage`；[源行](../../data/route/admin.php#L822) | `mapTree`、`saveChange` |
| `04835ffa` / `changeType` | `"post"` `"menus/getSystemNav"` (data) | `POST {A}/menus/getSystemNav` → `admin/menus/getSystemNav`；规则 `app\admin\controller\Menuscontroller::getsystemnav`；[源行](../../data/route/admin.php#L831) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `changeType` | `"post"` `"menus/getProductList"` (data) | `POST {A}/menus/getProductList` → `admin/menus/getProductList`；规则 `app\admin\controller\Menuscontroller::getproductlist`；[源行](../../data/route/admin.php#L823) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `getType` | `"post"` `"menus/getNavType"` (data) | `POST {A}/menus/getNavType` → `admin/menus/getNavType`；规则 `app\admin\controller\Menuscontroller::getnavtype`；[源行](../../data/route/admin.php#L832) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `getData` | `"post"` `"menus/getMenu"` (data) | `POST {A}/menus/getMenu` → `admin/menus/getMenu`；规则 `app\admin\controller\Menuscontroller::getmenu`；[源行](../../data/route/admin.php#L818) | 未提取；新设计明确成功后重读受影响对象 |
| `04835ffa` / `saveChange` | `"post"` `"menus/setNavList"` (data) | `POST {A}/menus/setNavList` → `admin/menus/setNavList`；规则 `app\admin\controller\Menuscontroller::setnavlist`；[源行](../../data/route/admin.php#L820) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p175"></a>

## 官网导航编辑 `/create_menu_www`

旧版证据：[P175](27-admin-built-page-evidence.md#p175)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“官网导航编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e7a1/06c06bea` | `el-form-item` | `导航名称： ($lang.name_navigation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `导航类型： ($lang.navigation_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-dialog` | `-` / `-` / `a.editFlag?a.$lang.edit_page:a.$lang.add_page` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `e7a1/06c06bea` | `el-form-item` | `名称：` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `多语言： ($lang.multilingual)` / `lang` / `-` | `a.addData.muti` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `-` / `language` / `-` | `a.addData.muti; a.addData.muti; a.addData.muti&&a.showLang` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `类型：` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `内置页面：` / `url` / `-` | `0==a.addData.type` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `地址：` / `url` / `-` | `3==a.addData.type` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `模板：` / `url` / `-` | `4==a.addData.type` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `标签：` / `tag` / `-` | `3==a.addData.type\|\|4==a.addData.type` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `一级分组：` / `name` / `-` | `1==a.addData.type` | 分组表单；未知原值不置空 |
| `e7a1/06c06bea` | `el-form-item` | `商品：` / `name` / `-` | `2==a.addData.type` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e7a1/06c06bea` | `保存更改 ($lang.save_the_changes)` | `on.click → a.saveChange` | `无提取条件` |
| `e7a1/06c06bea` | `取消更改 ($lang.cancel_changes)` | `on.click → a.cancelChange` | `无提取条件` |
| `e7a1/06c06bea` | `确定 ($lang.confirm)` | `on.click → a.addConfirm` | `无提取条件` |
| `e7a1/06c06bea` | `取消 ($lang.cancel)` | `on.click → a.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `06c06bea` / `getLanguage` | `"post"` `"menus/getLang"` (data) | `POST {A}/menus/getLang` → `admin/menus/getLang`；规则 `app\admin\controller\Menuscontroller::getlang`；[源行](../../data/route/admin.php#L833) | 未提取；新设计明确成功后重读受影响对象 |
| `06c06bea` / `getOptions` | `"get"` `"menus/getCreateWebData"` (params) | `GET {A}/menus/getCreateWebData` → `admin/menus/getCreateWebData`；规则 `app\admin\controller\Menuscontroller::getcreatewebdata`；[源行](../../data/route/admin.php#L837) | 未提取；新设计明确成功后重读受影响对象 |
| `06c06bea` / `getType` | `"post"` `"menus/getNavType"` (data) | `POST {A}/menus/getNavType` → `admin/menus/getNavType`；规则 `app\admin\controller\Menuscontroller::getnavtype`；[源行](../../data/route/admin.php#L832) | 未提取；新设计明确成功后重读受影响对象 |
| `06c06bea` / `getData` | `"post"` `"menus/getMenu"` (data) | `POST {A}/menus/getMenu` → `admin/menus/getMenu`；规则 `app\admin\controller\Menuscontroller::getmenu`；[源行](../../data/route/admin.php#L818) | `getType` |
| `06c06bea` / `addConfirm` | `"post"` `"menus/createWebPage"` (data) | `POST {A}/menus/createWebPage` → `admin/menus/createWebPage`；规则 `app\admin\controller\Menuscontroller::createwebpage`；[源行](../../data/route/admin.php#L836) | `mapTree`、`saveChange` |
| `06c06bea` / `saveChange` | `"post"` `"menus/setWebNavList"` (data) | `POST {A}/menus/setWebNavList` → `admin/menus/setWebNavList`；规则 `app\admin\controller\Menuscontroller::setwebnavlist`；[源行](../../data/route/admin.php#L835) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p176"></a>

## 友情链接 `/friendly_link`

旧版证据：[P176](27-admin-built-page-evidence.md#p176)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“友情链接”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8842/4fe6e918` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `地址 ($lang.address)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `标签 ($lang.tag)` / `link_tag` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8842/4fe6e918` | `el-dialog` | `-` / `-` / `e.linkForm.id?e.$lang.edit_link:e.$lang.add_link` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8842/4fe6e918` | `el-form-item` | `名称:` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `地址:` / `domain` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `标签:` / `link_tag` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-form-item` | `状态:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8842/4fe6e918` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8842/4fe6e918` | `添加链接 ($lang.add_link)` | `on.click → function(t){e.dialogVisible=!0}` | `无提取条件` |
| `8842/4fe6e918` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `8842/4fe6e918` | `编辑 ($lang.edit)` | `on.click → function(t){return e.handleIsEditLink(a)}` | `scopedSlots` |
| `8842/4fe6e918` | `删除 ($lang.delete)` | `on.click → function(t){return e.handleDeleteLink(a.id)}` | `scopedSlots` |
| `8842/4fe6e918` | `确定 ($lang.confirm)` | `on.click → function(t){return e.handleEditLink("linkRef")}` | `无提取条件` |
| `8842/4fe6e918` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4fe6e918` / `getData` | `"GET"` `"menus/allLinks"` (params) | `GET {A}/menus/allLinks` → `admin/menus/allLinks`；规则 `app\admin\controller\Menuscontroller::alllinks`；[源行](../../data/route/admin.php#L857) | 未提取；新设计明确成功后重读受影响对象 |
| `4fe6e918` / `handleEditLink` | `"POST"` `"menus/saveLinks"` (data) | `POST {A}/menus/saveLinks` → `admin/menus/saveLinks`；规则 `app\admin\controller\Menuscontroller::savelinks`；[源行](../../data/route/admin.php#L855) | `getData` |
| `4fe6e918` / `handleDeleteLink` | `"POST"` `"menus/deleteLinks?id=".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p177"></a>

## 营销推送 `/marketing-push`

旧版证据：[P177](27-admin-built-page-evidence.md#p177)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 步骤/进度 → 当前步骤输入 → 当前对象/金额摘要 → 上一步/下一步/最终确认。只按已有流程划分步骤，禁止在切换步骤时隐式提交业务。

**手机排版**：步骤缩为当前位置，内容单列，摘要紧靠最终确认；重复点击不产生重复请求。

**本页专项约束**：围绕“营销推送”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `3f33/6cb2413e` | `el-form-item` | `营销信息总开关： ($lang.marketing_information_master_switch)` / `marketing_emails_opt_in` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-tab-pane` | `按客户推送 ($lang.push_by_customer)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3f33/6cb2413e` | `el-tab-pane` | `按商品推送 ($lang.push_by_product)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `3f33/6cb2413e` | `el-form-item` | `客户 ($lang.client)` / `cids` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `客户状态 ($lang.customer_status)` / `client_status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `销售 ($lang.sell)` / `sale_ids` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `语言 ($lang.language)` / `language` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `国家 ($lang.nation)` / `country` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `注册时长 ($lang.register_time)` / `country` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `" "` / `certifi_status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `" "` / `is_bind_phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `" "` / `is_bind_email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `商品名称 ($lang.commodity_name)` / `pids` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `主机状态 ($lang.host_state)` / `domainstatus` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `3f33/6cb2413e` | `el-form-item` | `商品接口 ($lang.commodity_port)` / `interface_ids` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `3f33/6cb2413e` | `帮助文档 ($lang.help_document)` | `on.click → e.openDoc` | `无提取条件` |
| `3f33/6cb2413e` | `图标/动态文案，回查原证据` | `on.change → e.submitForm` | `无提取条件` |
| `3f33/6cb2413e` | `撰写消息 ($lang.write_the_message)` | `on.click → e.writeMessage` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `6cb2413e` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getConfigData` |
| `6cb2413e` / `getConfigData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `6cb2413e` / `getData` | `未显式指定` `"sm_type"` (无显式 data/params) | `GET {A}/sm_type` → `admin/sendMessageBatch/getSearchParams`；规则 `app\admin\controller\SendMessageBatchcontroller::getsearchparams`；[源行](../../data/route/admin.php#L778) | 未提取；新设计明确成功后重读受影响对象 |
| `6cb2413e` / `getCommon` | `未显式指定` `"common"` (无显式 data/params) | `GET {A}/common` → `admin/common/common`；规则 `app\admin\controller\Commoncontroller::common`；[源行](../../data/route/admin.php#L93) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`writeMessage: this.$router.push({path:"message-write"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p178"></a>

## 通知内容编辑 `/message-write`

旧版证据：[P178](27-admin-built-page-evidence.md#p178)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 名称/分类等基础字段 → 正文编辑器 → 变量/附件与预览 → 保存区。预览与提交分开，预览内容不执行非可信脚本。

**手机排版**：基础字段单列，正文占满内容宽；编辑工具可横向滚动，预览独立展示并保留返回草稿。

**本页专项约束**：围绕“通知内容编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0c75/4c3f0376` | `el-form-item` | `标题 ($lang.title)` / `-` / `-` | `t.formData.send_mothod.includes("system")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `""` / `-` / `-` | `t.formData.send_mothod.includes("system")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-upload` | `-` / `-` / `-` | `t.formData.send_mothod.includes("system")` | 对应字段组；上传结果与业务保存分开 |
| `0c75/4c3f0376` | `el-form-item` | `正文 ($lang.straight_matter)` / `-` / `-` | `t.formData.send_mothod.includes("system")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `短信模板 ($lang.sms_template)` / `-` / `-` | `t.formData.send_mothod.includes("mobile")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `短信内容 ($lang.message_content)` / `-` / `-` | `t.formData.send_mothod.includes("mobile")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `主题 ($lang.theme)` / `-` / `-` | `t.formData.send_mothod.includes("email")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `""` / `-` / `-` | `t.formData.send_mothod.includes("email")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-upload` | `-` / `-` / `-` | `t.formData.send_mothod.includes("email")` | 对应字段组；上传结果与业务保存分开 |
| `0c75/4c3f0376` | `el-form-item` | `正文 ($lang.straight_matter)` / `-` / `-` | `t.formData.send_mothod.includes("email")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `可用参数 ($lang.available_parameters)` / `-` / `-` | `t.formData.send_mothod.includes("email")` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `发送频次 ($lang.send_frequency)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `消息类型 ($lang.message_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0c75/4c3f0376` | `el-form-item` | `重复发送 ($lang.send_repeatedly)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0c75/4c3f0376` | `邮件预览 ($lang.mail_preview)` | `on.click → t.emailPreview` | `t.formData.send_mothod.includes("email")` |
| `0c75/4c3f0376` | `发送信息` | `on.click → t.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4c3f0376` / `submit` | `"post"` `"sendmessage_post"` (data) | `ANY {A}/sendmessage_post` → `admin/sendMessageBatch/sendMessagePost`；规则 `app\admin\controller\SendMessageBatchcontroller::sendmessagepost`；[源行](../../data/route/admin.php#L785) | 未提取；新设计明确成功后重读受影响对象 |
| `4c3f0376` / `getSendMethod` | `未显式指定` `"getSendMethod"` (无显式 data/params) | `GET {A}/getSendMethod` → `admin/sendMessageBatch/getSendMethod`；规则 `app\admin\controller\SendMessageBatchcontroller::getsendmethod`；[源行](../../data/route/admin.php#L779) | 未提取；新设计明确成功后重读受影响对象 |
| `4c3f0376` / `getData` | `未显式指定` `"mobiletemplate_list"` (params) | `GET {A}/mobiletemplate_list` → `admin/sendMessageBatch/mobiletemplateList`；规则 `app\admin\controller\SendMessageBatchcontroller::mobiletemplatelist`；[源行](../../data/route/admin.php#L781) | 未提取；新设计明确成功后重读受影响对象 |
| `4c3f0376` / `searchlist` | `"post"` `"searchlist"` (data) | `ANY {A}/searchlist` → `admin/sendMessageBatch/searchList`；规则 `app\admin\controller\SendMessageBatchcontroller::searchlist`；[源行](../../data/route/admin.php#L780) | 未提取；新设计明确成功后重读受影响对象 |
| `4c3f0376` / `getBaseArg` | `未显式指定` `"email_template_params"` (params) | `GET {A}/email_template_params` → `admin/sendMessageBatch/getEmailTemplateParams`；规则 `app\admin\controller\SendMessageBatchcontroller::getemailtemplateparams`；[源行](../../data/route/admin.php#L783) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: t.$router.push({name:"MarketingPush"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p181"></a>

## 文件分组 `/file`

旧版证据：[P181](27-admin-built-page-evidence.md#p181)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“文件分组”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e494/0e1c9f3c` | `el-form-item` | `文件分类 ($lang.file_classify)` / `-` / `-` | `e.isEdit` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `文件类型 ($lang.file_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `上传文件 ($lang.upload_files)` / `filetype` / `-` | `e.isAdd\|\|e.showUpload` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `上传文件 ($lang.upload_files)` / `-` / `-` | `e.isEdit&&!e.showUpload` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `输入文件名 ($lang.import_file_name)` / `filename` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `文件下载地址 ($lang.file_download_address)` / `filenameUrl` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `""` / `-` / `-` | `!e.showRemote&&!e.showFileName&&!1===e.isEdit\|\|!e.showRemote&&!e.showFileName&&e.showUpload` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-upload` | `-` / `-` / `-` | `!e.showRemote&&!e.showFileName&&!1===e.isEdit\|\|!e.showRemote&&!e.showFileName&&e.showUpload` | 对应字段组；上传结果与业务保存分开 |
| `e494/0e1c9f3c` | `el-form-item` | `下载次数 ($lang.download_count)` / `downloads` / `-` | `e.isEdit\|\|e.showUpload` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `需要登录 ($lang.need_to_log_to)` / `clientsonly` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `产品附件 ($lang.accessories_product)` / `productdownload` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `e494/0e1c9f3c` | `el-form-item` | `下载链接 ($lang.download_link)` / `-` / `-` | `e.isEdit&&!e.showUpload` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e494/0e1c9f3c` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `e494/0e1c9f3c` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0e1c9f3c` / `getData` | `未显式指定` `"downloads/filepage"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0e1c9f3c` / `submitForm` | `"post"` `"downloads/addfile"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0e1c9f3c` / `submitForm` | `"post"` `"downloads/savefile"` (data) | `POST {A}/downloads/savefile` → `admin/Downloads/postSaveFile`；规则 `app\admin\controller\Downloadscontroller::postsavefile`；[源行](../../data/route/admin.php#L587) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.push({name:"ServiceSupport"})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
