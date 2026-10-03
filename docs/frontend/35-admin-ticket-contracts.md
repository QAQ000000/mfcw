# 工单与客服逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [预设回复](#p070) `/preset-reply` | `list` | 路由 factory 指向模块 |
| [预设回复编辑](#p071) `/addedit-pre-reply` | `form` | 路由 factory 指向模块 |
| [工单列表](#p072) `/support-ticket` | `list` | 路由 factory 指向模块 |
| [新建工单](#p073) `/add-support-ticket` | `form` | 路由 factory 指向模块 |
| [工单详情](#p074) `/support-ticket-detail` | `conversation` | 路由 factory 指向模块 |
| [工单统计](#p075) `/support-statistics` | `report` | 路由 factory 指向模块 |
| [工单部门](#p137) `/work-order-dept` | `list` | 路由 factory 指向模块 |
| [工单部门编辑](#p138) `/new-work-order-dept` | `form` | 路由 factory 指向模块 |
| [工单自定义字段](#p139) `/add-custom-fields` | `form` | 路由 factory 指向模块 |
| [工单状态](#p140) `/work-order-status` | `list` | 路由 factory 指向模块 |
| [工单传递规则](#p141) `/work-order-rules` | `list` | 路由 factory 指向模块 |
| [服务支持设置](#p180) `/service-support` | `form` | 路由 factory 指向模块 |

<a id="p070"></a>

## 预设回复 `/preset-reply`

旧版证据：[P070](27-admin-built-page-evidence.md#p070)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“预设回复”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `d874/0a5150a6` | `el-tab-pane` | `添加分类 ($lang.add_classify)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `d874/0a5150a6` | `el-form-item` | `分类名称` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d874/0a5150a6` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d874/0a5150a6` | `el-table-column` | `ID` / `id` / `-` | `循环 e.preReplyTypeList` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `循环 e.preReplyTypeList` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `内容 ($lang.content)` / `content` / `-` | `循环 e.preReplyTypeList` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `操作` / `-` / `-` | `循环 e.preReplyTypeList` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-tab-pane` | `搜索 ($lang.search)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `d874/0a5150a6` | `el-form-item` | `文章名 ($lang.title_article)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d874/0a5150a6` | `el-form-item` | `信息 ($lang.info)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d874/0a5150a6` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d874/0a5150a6` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `标题 ($lang.title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `内容 ($lang.content)` / `content` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d874/0a5150a6` | `el-dialog` | `-` / `-` / `修改预设分类 ($lang.edit_default_category)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `d874/0a5150a6` | `el-form-item` | `分类名称 ($lang.classify_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `d874/0a5150a6` | `添加分类 ($lang.add_classify)` | `on.click → e.addTypeSubmit` | `无提取条件` |
| `d874/0a5150a6` | `编辑分类 ($lang.edit_classify)` | `on.click → function(a){return e.editTypeHandleClick(t)}` | `循环 e.preReplyTypeList` |
| `d874/0a5150a6` | `删除分类 ($lang.delete_classify)` | `on.click → function(a){return e.deleteTypeHandleClick(t.id)}` | `循环 e.preReplyTypeList` |
| `d874/0a5150a6` | `添加预设回复 ($lang.add_default_reply)` | `on.click → function(a){return e.addPreReplyHanleClick(t.id)}` | `循环 e.preReplyTypeList` |
| `d874/0a5150a6` | `编辑 ($lang.edit)` | `on.click → function(a){return e.editPreReplyHanleClick(t.id,n.row.id)}` | `循环 e.preReplyTypeList; scopedSlots` |
| `d874/0a5150a6` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteHandleClick(n.row.id)}` | `循环 e.preReplyTypeList; scopedSlots` |
| `d874/0a5150a6` | `搜索 ($lang.search)` | `on.click → e.searchHanleClick` | `无提取条件` |
| `d874/0a5150a6` | `删除 ($lang.delete)` | `on.click → function(a){return e.deleteHandleClick(t.row.id)}` | `scopedSlots` |
| `d874/0a5150a6` | `取消 ($lang.cancel)` | `on.click → function(t){e.editTypeDialogVisiable=!1}` | `无提取条件` |
| `d874/0a5150a6` | `保存更改 ($lang.save_the_changes)` | `on.click → e.editTypeSubmit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0a5150a6` / `getData` | `未显式指定` `"ticket_prereply_list"` (无显式 data/params) | `GET {A}/ticket_prereply_list` → `admin/ticket_prereply/replyList`；规则 `app\admin\controller\TicketPrereplycontroller::replylist`；[源行](../../data/route/admin.php#L477) | 未提取；新设计明确成功后重读受影响对象 |
| `0a5150a6` / `addTypeSubmit` | `"post"` `"add_ticket_prereply_category"` (data) | `POST {A}/add_ticket_prereply_category` → `admin/ticket_prereply/addCategory`；规则 `app\admin\controller\TicketPrereplycontroller::addcategory`；[源行](../../data/route/admin.php#L478) | `getData` |
| `0a5150a6` / `deleteTypeHandleClick` | `未显式指定` `"delete_ticket_prereply_category/"+e` (无显式 data/params) | `GET {A}/delete_ticket_prereply_category/:id` → `admin/ticket_prereply/deleteCategory`；规则 `app\admin\controller\TicketPrereplycontroller::deletecategory`；[源行](../../data/route/admin.php#L481) | `getData` |
| `0a5150a6` / `editTypeSubmit` | `"post"` `"save_ticket_prereply_category"` (data) | `POST {A}/save_ticket_prereply_category` → `admin/ticket_prereply/editCategory`；规则 `app\admin\controller\TicketPrereplycontroller::editcategory`；[源行](../../data/route/admin.php#L480) | `getData` |
| `0a5150a6` / `deleteHandleClick` | `"delete"` `"ticket_prereply/"+e+"/"` (无显式 data/params) | `DELETE {A}/ticket_prereply/:id/` → `admin/ticket_prereply/deletePrereply`；规则 `app\admin\controller\TicketPrereplycontroller::deleteprereply`；[源行](../../data/route/admin.php#L487) | `getData`、`searchHanleClick` |
| `0a5150a6` / `searchHanleClick` | `"post"` `"search_ticket_prereply"` (data) | `POST {A}/search_ticket_prereply` → `admin/ticket_prereply/searchPrereply`；规则 `app\admin\controller\TicketPrereplycontroller::searchprereply`；[源行](../../data/route/admin.php#L486) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`addPreReplyHanleClick: this.$router.push({path:"/addedit-pre-reply",query:{typeId:e}})`
- 旧跳转：`editPreReplyHanleClick: this.$router.push({path:"/addedit-pre-reply",query:{typeId:e,id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p071"></a>

## 预设回复编辑 `/addedit-pre-reply`

旧版证据：[P071](27-admin-built-page-evidence.md#p071)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“预设回复编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `57e4/a19fbf66` | `el-form-item` | `分类 ($lang.classify)` / `cid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `57e4/a19fbf66` | `el-form-item` | `回复名称 ($lang.reply_name)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `57e4/a19fbf66` | `el-form-item` | `回复内容 ($lang.reply_content)` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `57e4/a19fbf66` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `57e4/a19fbf66` | `e.id?e.$lang.save_the_changes:e.$lang.add_reply` | `on.click → e.preReplySubmit` | `无提取条件` |
| `57e4/a19fbf66` | `取消 ($lang.cancel)` | `on.click → e.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `a19fbf66` / `getTypeList` | `未显式指定` `"add_ticket_prereply/page"` (无显式 data/params) | `GET {A}/add_ticket_prereply/page` → `admin/ticket_prereply/addPrereplyPage`；规则 `app\admin\controller\TicketPrereplycontroller::addprereplypage`；[源行](../../data/route/admin.php#L482) | 未提取；新设计明确成功后重读受影响对象 |
| `a19fbf66` / `getEditDetail` | `未显式指定` `"save_ticket_prereply/page?id="+e` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `a19fbf66` / `preReplySubmit` | `"post"` `"add_ticket_prereply"` (data) | `POST {A}/add_ticket_prereply` → `admin/ticket_prereply/addPrereply`；规则 `app\admin\controller\TicketPrereplycontroller::addprereply`；[源行](../../data/route/admin.php#L483) | 未提取；新设计明确成功后重读受影响对象 |
| `a19fbf66` / `preReplySubmit` | `"post"` `"save_ticket_prereply"` (data) | `POST {A}/save_ticket_prereply` → `admin/ticket_prereply/savePrereply`；规则 `app\admin\controller\TicketPrereplycontroller::saveprereply`；[源行](../../data/route/admin.php#L485) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`preReplySubmit: e.$router.push({path:"/preset-reply"})`
- 旧跳转：`cancel: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p072"></a>

## 工单列表 `/support-ticket`

旧版证据：[P072](27-admin-built-page-evidence.md#p072)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“工单列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8a83/754dded1` | `el-tab-pane` | `e.title` / `-` / `-` | `循环 e.statusCustomOptions` | 主区导航；保留对象与选中项 |
| `8a83/754dded1` | `el-form-item` | `客户 ($lang.client)` / `uid` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `部门 ($lang.department)` / `dptid` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `优先级 ($lang.priority)` / `priority` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `工单标题/内容 ($lang.work_order_title_content)` / `content` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `工单编号 ($lang.work_order_num)` / `tid` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-form-item` | `" "` / `-` / `-` | `e.searchWarpper` | 分组表单；未知原值不置空 |
| `8a83/754dded1` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `工单标题 ($lang.work_order_title)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `提交人 ($lang.submitter)` / `user_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `状态 ($lang.state)` / `status_title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `处理人 ($lang.handler)` / `handle_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `部门 ($lang.department)` / `department_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `提交时间 ($lang.submit_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8a83/754dded1` | `el-table-column` | `上次回复 ($lang.last_reply)` / `last_reply_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8a83/754dded1` | `新建工单` | `on.click → e.newTicketHandleClick` | `无提取条件` |
| `8a83/754dded1` | `" "+e._s(e.searchWarpper?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → e.changeSearchWarpper` | `无提取条件` |
| `8a83/754dded1` | `查询 ($lang.demand)` | `on.click → e.searchHandleClick` | `e.searchWarpper` |
| `8a83/754dded1` | `清空 ($lang.empty)` | `on.click → e.resetHandleClick` | `e.searchWarpper` |
| `8a83/754dded1` | `t.row.tid` | `on.click → function(a){return e.toDetail(t.row.id,t.row.tid)}` | `scopedSlots` |
| `8a83/754dded1` | `t.row.title` | `on.click → function(a){return e.toDetail(t.row.id,t.row.tid)}` | `scopedSlots` |
| `8a83/754dded1` | `t.row.user_name` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots; else(0===t.row.uid)` |
| `8a83/754dded1` | `关闭 ($lang.shut_down)` | `on.click → e.closeTicketHandleClick` | `无提取条件` |
| `8a83/754dded1` | `删除` | `on.click → e.deleteTicketHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `754dded1` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `754dded1` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `754dded1` / `getData` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | `playMusic` |
| `754dded1` / `getData` | `未显式指定` `"list_ticket"` (params) | `GET {A}/list_ticket` → `admin/ticket/getList`；规则 `app\admin\controller\Ticketcontroller::getlist`；[源行](../../data/route/admin.php#L490) | `playMusic` |
| `754dded1` / `getUserData` | `未显式指定` `"getClient"` (无显式 data/params) | `GET {A}/getClient` → `admin/Public/getClient`；规则 `app\admin\controller\Publiccontroller::getclient`；[源行](../../data/route/admin.php#L117) | 未提取；新设计明确成功后重读受影响对象 |
| `754dded1` / `getDepartmentData` | `未显式指定` `"getTicketDepartment"` (无显式 data/params) | `GET {A}/getTicketDepartment` → `admin/Public/getTicketDepartment`；规则 `app\admin\controller\Publiccontroller::getticketdepartment`；[源行](../../data/route/admin.php#L118) | 未提取；新设计明确成功后重读受影响对象 |
| `754dded1` / `autoRefreshHandleClick` | `"post"` `"tastes/editUserTanstes"` (data) | `POST {A}/tastes/editUserTanstes` → `admin/userTastes/editUserTanstes`；规则 `app\admin\controller\UserTastescontroller::editusertanstes`；[源行](../../data/route/admin.php#L155) | `userTastes` |
| `754dded1` / `mergeTicketHandleClick` | `"post"` `"merge_ticket"` (data) | `POST {A}/merge_ticket` → `admin/ticket/mergeTicket`；规则 `app\admin\controller\Ticketcontroller::mergeticket`；[源行](../../data/route/admin.php#L493) | `getData` |
| `754dded1` / `closeTicketHandleClick` | `"post"` `"close_ticket"` (data) | `POST {A}/close_ticket` → `admin/ticket/closeTicket`；规则 `app\admin\controller\Ticketcontroller::closeticket`；[源行](../../data/route/admin.php#L494) | `getData` |
| `754dded1` / `deleteTicketHandleClick` | `"post"` `"delete_ticket"` (data) | `POST {A}/delete_ticket` → `admin/ticket/deleteTicket`；规则 `app\admin\controller\Ticketcontroller::deleteticket`；[源行](../../data/route/admin.php#L495) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/support-ticket-detail",query:{id:t.row.id,tid:t.row.tid}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 旧跳转：`adSearch: t.$router.push({query:u()({},o)})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`newTicketHandleClick: this.$router.push("/add-support-ticket")`
- 旧跳转：`toDetail: this.$router.push({path:"/support-ticket-detail",query:{id:e,tid:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p073"></a>

## 新建工单 `/add-support-ticket`

旧版证据：[P073](27-admin-built-page-evidence.md#p073)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“新建工单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `85e3/1a92f09a` | `el-form-item` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-form-item` | `处理部门 ($lang.processing_department)` / `dptid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-form-item` | `优先级 ($lang.priority)` / `priority` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-form-item` | `工单标题 ($lang.work_order_title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-form-item` | `工单内容 ($lang.work_order_content)` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-form-item` | `附件 ($lang.attachment)` / `attachment` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `85e3/1a92f09a` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `85e3/1a92f09a` | `开启工单` | `on.click → t.openTicketSubmit` | `无提取条件` |
| `85e3/1a92f09a` | `返回 ($lang.get_back)` | `on.click → t.goBack` | `无提取条件` |
| `85e3/1a92f09a` | `取消 ($lang.cancel)` | `on.click → t.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1a92f09a` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `1a92f09a` / `getAddPageInfoList` | `未显式指定` `"add_ticket_page"` (params) | `GET {A}/add_ticket_page` → `admin/ticket/createPage`；规则 `app\admin\controller\Ticketcontroller::createpage`；[源行](../../data/route/admin.php#L488) | `customerSelectedChange` |
| `1a92f09a` / `openTicketSubmit` | `"post"` `"add_ticket"` (data) | `POST {A}/add_ticket` → `admin/ticket/add`；规则 `app\admin\controller\Ticketcontroller::add`；[源行](../../data/route/admin.php#L489) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"work-order-dept"}`
- 旧跳转：`openTicketSubmit: t.$router.push({path:"/customer-view/tickets",query:{id:t.$route.query.uid}})`
- 旧跳转：`openTicketSubmit: t.$router.go(-1)`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p074"></a>

## 工单详情 `/support-ticket-detail`

旧版证据：[P074](27-admin-built-page-evidence.md#p074)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、编号、状态与返回 → 左侧消息时间线/附件/回复编辑器 → 右侧客户、服务、部门和处理信息。内部备注与对外回复明确区分，发送结果由重读确认。

**手机排版**：对象摘要 → 可折叠部门/关联信息 → 时间线 → 回复区；长正文换行、附件独立处理，键盘开启时回复按钮可达。

**本页专项约束**：读取GET list_ticket/:id；时间线按真实消息顺序展示。回复、内部备注、附件、部门/状态变更各自确认结果，上传失败不丢草稿，不重复发送。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f1234/e20547b0` | `el-table-column` | `产品/服务 ($lang.product_service)` / `productname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/e20547b0` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/e20547b0` | `el-table-column` | `付款周期 ($lang.payment_period)` / `billingcycle` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/e20547b0` | `el-table-column` | `开通时间 ($lang.opening_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/e20547b0` | `el-table-column` | `到期时间 ($lang.due_time)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/e20547b0` | `el-table-column` | `状态 ($lang.state)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-tab-pane` | `添加回复 ($lang.add_reply)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f1234/4b93323c` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `f1234/4b93323c` | `el-tab-pane` | `添加备注 ($lang.add_remark)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f1234/4b93323c` | `el-tab-pane` | `选项 ($lang.option)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f1234/4b93323c` | `el-form-item` | `部门 ($lang.department)` / `dptid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-form-item` | `客户名 ($lang.client_name)` / `uid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-form-item` | `工单标题 ($lang.work_order_title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-form-item` | `e.fieldname` / `-` / `-` | `循环 t.customfields; 循环 e` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f1234/4b93323c` | `el-tab-pane` | `产品信息 ($lang.product_info)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `f1234/4b93323c` | `el-table-column` | `关联产品 ($lang.related_product)` / `productname` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-table-column` | `付款周期 ($lang.payment_period)` / `billingcycle` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-table-column` | `开通时间 ($lang.open_time)` / `create_time` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-table-column` | `到期时间 ($lang.expire_date)` / `nextduedate` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-table-column` | `状态 ($lang.state)` / `domainstatus` / `-` | `t.associatTableData.length` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f1234/4b93323c` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f1234/4b93323c` | `关闭 ($lang.shut_down)` | `on.click → function(e){return t.closeTicketHandleClick(4,"confirm")}` | `无提取条件` |
| `f1234/4b93323c` | `接单` | `on.click → t.ticketReceive` | `0===t.related.handle` |
| `f1234/4b93323c` | `移交工单` | `on.click → t.handoverItem` | `else(0===t.related.handle); 4!==t.related.status` |
| `f1234/4b93323c` | `回复` | `on.click → t.replyHandleClick` | `无提取条件` |
| `f1234/4b93323c` | `回复并关闭工单` | `on.click → t.replyAndCloseHandleClick` | `无提取条件` |
| `f1234/4b93323c` | `添加备注 ($lang.add_remark)` | `on.click → t.addTicketNoteHandleClick` | `无提取条件` |
| `f1234/4b93323c` | `保存更改` | `on.click → t.submitForm` | `无提取条件` |
| `f1234/4b93323c` | `取消更改 ($lang.cancel_changes)` | `on.click → t.resetForm` | `无提取条件` |
| `f1234/4b93323c` | `t._s(t._f("imgFilter")(r))+" "` | `on.click → function(a){return t.downAttachment(e.id,e.type,n)}` | `t.replyList.length; 循环 t.replyList; "log"!==e.type; e.showInfo&&e.attachment.length; 循环 e.attachment` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `e20547b0` / `getTicketHosts` | `未显式指定` `"hostbyuid"` (params) | `GET {A}/hostbyuid` → `admin/user_manage/hostByUid`；规则 `app\admin\controller\UserManagecontroller::hostbyuid`；[源行](../../data/route/admin.php#L176) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `ticketReceive` | `"put"` `"ticket_receive"` (data) | `PUT {A}/ticket_receive` → `admin/ticket/ticketReceive`；规则 `app\admin\controller\Ticketcontroller::ticketreceive`；[源行](../../data/route/admin.php#L506) | `getTicketDetail` |
| `4b93323c` / `handelConfirm` | `"put"` `"ticket_transfer"` (data) | `PUT {A}/ticket_transfer` → `admin/ticket/ticketTransfer`；规则 `app\admin\controller\Ticketcontroller::tickettransfer`；[源行](../../data/route/admin.php#L508) | `onClose`、`getTicketDetail` |
| `4b93323c` / `handoverItem` | `未显式指定` `"ticket_transfer_list"` (params) | `GET {A}/ticket_transfer_list` → `admin/ticket/ticketTransferList`；规则 `app\admin\controller\Ticketcontroller::tickettransferlist`；[源行](../../data/route/admin.php#L507) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `closeTicketHandleClick` | `"post"` `"close_ticket"` (data) | `POST {A}/close_ticket` → `admin/ticket/closeTicket`；规则 `app\admin\controller\Ticketcontroller::closeticket`；[源行](../../data/route/admin.php#L494) | `getTicketDetail` |
| `4b93323c` / `getStatus` | `未显式指定` `"list_ticket_status"` (无显式 data/params) | `GET {A}/list_ticket_status` → `admin/ticket_status/getList`；规则 `app\admin\controller\TicketStatuscontroller::getlist`；[源行](../../data/route/admin.php#L465) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `getTicketDetail` | `未显式指定` `"list_ticket/"+t` (无显式 data/params) | `GET {A}/list_ticket/:id` → `admin/ticket/ticketDetail`；规则 `app\admin\controller\Ticketcontroller::ticketdetail`；[源行](../../data/route/admin.php#L502) | `HTMLDecode` |
| `4b93323c` / `replyHandleClick` | `"post"` `"reply_ticket"` (data) | `POST {A}/reply_ticket` → `admin/ticket/reply`；规则 `app\admin\controller\Ticketcontroller::reply`；[源行](../../data/route/admin.php#L492) | `getTicketDetail` |
| `4b93323c` / `replyAndCloseHandleClick` | `"post"` `"reply_ticket"` (data) | `POST {A}/reply_ticket` → `admin/ticket/reply`；规则 `app\admin\controller\Ticketcontroller::reply`；[源行](../../data/route/admin.php#L492) | `closeTicketHandler` |
| `4b93323c` / `closeTicketHandler` | `"post"` `"close_ticket"` (data) | `POST {A}/close_ticket` → `admin/ticket/closeTicket`；规则 `app\admin\controller\Ticketcontroller::closeticket`；[源行](../../data/route/admin.php#L494) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `addTicketNoteHandleClick` | `"post"` `"add_ticket_note"` (data) | `POST {A}/add_ticket_note` → `admin/ticket/addNote`；规则 `app\admin\controller\Ticketcontroller::addnote`；[源行](../../data/route/admin.php#L496) | `getTicketDetail` |
| `4b93323c` / `getAddPageInfoList` | `未显式指定` `"add_ticket_page"` (params) | `GET {A}/add_ticket_page` → `admin/ticket/createPage`；规则 `app\admin\controller\Ticketcontroller::createpage`；[源行](../../data/route/admin.php#L488) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `submitForm` | `"post"` `"save_ticket"` (data) | `POST {A}/save_ticket` → `admin/ticket/saveTicket`；规则 `app\admin\controller\Ticketcontroller::saveticket`；[源行](../../data/route/admin.php#L503) | `getTicketDetail`、`getAddPageInfoList`、`getStatus` |
| `4b93323c` / `editTicketReplyHandleClick` | `"post"` `"save_ticket_reply"` (data) | `POST {A}/save_ticket_reply` → `admin/ticket/saveReply`；规则 `app\admin\controller\Ticketcontroller::savereply`；[源行](../../data/route/admin.php#L497) | `getTicketDetail` |
| `4b93323c` / `deleteTicketReply` | `"post"` `"delete_ticket_reply"` (data) | `POST {A}/delete_ticket_reply` → `admin/ticket/deleteReply`；规则 `app\admin\controller\Ticketcontroller::deletereply`；[源行](../../data/route/admin.php#L499) | `getTicketDetail` |
| `4b93323c` / `deleteTicketReply` | `"post"` `"delete_ticket_note"` (data) | `POST {A}/delete_ticket_note` → `admin/ticket/deleteNote`；规则 `app\admin\controller\Ticketcontroller::deletenote`；[源行](../../data/route/admin.php#L498) | `getTicketDetail` |
| `4b93323c` / `downAttachment` | `未显式指定` `"download_ticket_attachment"` (params) | `GET {A}/download_ticket_attachment` → `admin/ticket/downloadAttachment`；规则 `app\admin\controller\Ticketcontroller::downloadattachment`；[源行](../../data/route/admin.php#L501) | 未提取；新设计明确成功后重读受影响对象 |
| `4b93323c` / `getTicketHosts` | `未显式指定` `"hostbyuid"` (params) | `GET {A}/hostbyuid` → `admin/user_manage/hostByUid`；规则 `app\admin\controller\UserManagecontroller::hostbyuid`；[源行](../../data/route/admin.php#L176) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:r.uid,hid:r.id}}`
- 旧跳转：`render router-link: {path:"work-order-status"}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.uid}}`
- 旧跳转：`goProduct: this.$router.push({name:"productInnerpage",query:{id:t.uid,hid:t.id}})`
- 旧跳转：`replyHandleClick: t.$router.go(-1)`
- 旧跳转：`closeTicketHandler: t.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p075"></a>

## 工单统计 `/support-statistics`

旧版证据：[P075](27-admin-built-page-evidence.md#p075)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：围绕“工单统计”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e859/a80c8236` | `el-table-column` | `处理人 ($lang.handler)` / `user_login` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `处理工单数 ($lang.processing_number)` / `ticket_count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `总分 ($lang.total_points)` / `ticket_star_sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `1分 ($lang.one_grade)` / `ticket_star_1` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `2分 ($lang.two_grade)` / `ticket_star_2` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `3分 ($lang.three_grade)` / `ticket_star_3` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `4分 ($lang.four_grade)` / `ticket_star_4` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e859/a80c8236` | `el-table-column` | `5分 ($lang.five_grade)` / `ticket_star_5` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e859/a80c8236` | `查询 ($lang.demand)` | `on.click → t.searchHandle` | `无提取条件` |
| `e859/a80c8236` | `重置 ($lang.reset)` | `on.click → t.resetSearch` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `a80c8236` / `getTicketStatistics` | `未显式指定` `"ticket_statistics"` (params) | `GET {A}/ticket_statistics` → `admin/ticket/ticketStatistics`；规则 `app\admin\controller\Ticketcontroller::ticketstatistics`；[源行](../../data/route/admin.php#L505) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p137"></a>

## 工单部门 `/work-order-dept`

旧版证据：[P137](27-admin-built-page-evidence.md#p137)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“工单部门”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e653/57502afd` | `el-table-column` | `部门名称 ($lang.department_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e653/57502afd` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e653/57502afd` | `el-table-column` | `是否隐藏 ($lang.whether_to_hide)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e653/57502afd` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `e653/57502afd` | `el-table-column` | `自动回复 ($lang.auto_reply)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `e653/57502afd` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `e653/57502afd` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `e653/57502afd` | `添加新部门` | `on.click → t.newDeptHandleClick` | `无提取条件` |
| `e653/57502afd` | `编辑 ($lang.edit)` | `on.click → function(n){return t.editHandleClick(e.row.id)}` | `scopedSlots` |
| `e653/57502afd` | `删除 ($lang.delete)` | `on.click → function(n){return t.deleteHandleClick(e.row.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `57502afd` / `getData` | `未显式指定` `"list_ticket_department"` (无显式 data/params) | `GET {A}/list_ticket_department` → `admin/ticket_department/getList`；规则 `app\admin\controller\TicketDepartmentcontroller::getlist`；[源行](../../data/route/admin.php#L460) | 未提取；新设计明确成功后重读受影响对象 |
| `57502afd` / `deleteHandleClick` | `"post"` `"delete_ticket_department"` (data) | `POST {A}/delete_ticket_department` → `admin/ticket_department/delete`；规则 `app\admin\controller\TicketDepartmentcontroller::delete`；[源行](../../data/route/admin.php#L457) | `getData` |
| `57502afd` / `moveUpHandleClick` | `"post"` `"moveup_ticket_department"` (data) | `POST {A}/moveup_ticket_department` → `admin/ticket_department/moveUp`；规则 `app\admin\controller\TicketDepartmentcontroller::moveup`；[源行](../../data/route/admin.php#L459) | `getData` |
| `57502afd` / `moveDownHandleClick` | `"post"` `"movedown_ticket_department"` (data) | `POST {A}/movedown_ticket_department` → `admin/ticket_department/moveDown`；规则 `app\admin\controller\TicketDepartmentcontroller::movedown`；[源行](../../data/route/admin.php#L458) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`newDeptHandleClick: this.$router.push({path:"/new-work-order-dept"})`
- 旧跳转：`editHandleClick: this.$router.push({path:"/new-work-order-dept",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p138"></a>

## 工单部门编辑 `/new-work-order-dept`

旧版证据：[P138](27-admin-built-page-evidence.md#p138)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“工单部门编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `40ef/2d15bf9e` | `el-tab-pane` | `详情 ($lang.detail)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `40ef/2d15bf9e` | `el-form-item` | `部门名称 ($lang.department_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `需要激活产品 ($lang.need_activate_product)` / `is_product_order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `提交工单需实名 ($lang.submit_need_realname)` / `is_certifi` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `自动回复 ($lang.auto_reply)` / `is_open_auto_reply` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `自动回复设置 ($lang.auto_reply_set)` / `-` / `-` | `e.formData.is_open_auto_reply` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `回复内容 ($lang.reply_content)` / `-` / `-` | `e.formData.is_open_auto_reply` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `工单评分 ($lang.repair_order_score)` / `feedback_request` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-tab-pane` | `自定义字段 ($lang.custom_field)` / `-` / `-` | `e.orderId` | 主区导航；保留对象与选中项 |
| `40ef/2d15bf9e` | `el-table-column` | `排序 ($lang.sort)` / `sortorder` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `字段名称 ($lang.field_name)` / `fieldname` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `字段类型 ($lang.filed_type)` / `fieldtype` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `验证 ($lang.validation)` / `regexpr` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `内容 ($lang.content)` / `fieldoptions` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `e.orderId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40ef/2d15bf9e` | `el-tab-pane` | `工单传递 ($lang.process_order_transfer)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `40ef/2d15bf9e` | `el-form-item` | `关联上游部门 ($lang.connecting_upstream_department)` / `hidden` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `40ef/2d15bf9e` | `el-form-item` | `t.name` / `-` / `-` | `1===e.formData.is_related_upstream; 循环 e.financeOptions` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `40ef/2d15bf9e` | `添加字段` | `on.click → e.addNewFields` | `e.orderId` |
| `40ef/2d15bf9e` | `删除 ($lang.delete)` | `on.click → function(a){return e.deleteFields(t.row.id)}` | `e.orderId; scopedSlots` |
| `40ef/2d15bf9e` | `修改 ($lang.modification)` | `on.click → function(a){return e.updateFields(t.row.id)}` | `e.orderId; scopedSlots` |
| `40ef/2d15bf9e` | `e._s(e.orderId?e.$lang.save_the_changes:e.$lang.add_a_new_department)+" "` | `on.click → e.submitForm` | `无提取条件` |
| `40ef/2d15bf9e` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `40ef/2d15bf9e` | `取消 ($lang.cancel)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2d15bf9e` / `deleteFields` | `"get"` `"del_ticket_custom_param"` (params) | `GET {A}/del_ticket_custom_param` → `admin/ticket_department/delTicketCustomParam`；规则 `app\admin\controller\TicketDepartmentcontroller::delticketcustomparam`；[源行](../../data/route/admin.php#L471) | `getFormInfoById` |
| `2d15bf9e` / `getFormInfo` | `未显式指定` `"get_ticket_department"` (无显式 data/params) | `GET {A}/get_ticket_department` → `admin/ticket_department/addPage`；规则 `app\admin\controller\TicketDepartmentcontroller::addpage`；[源行](../../data/route/admin.php#L454) | `getUpstreamConfigOptions` |
| `2d15bf9e` / `getFormInfoById` | `未显式指定` `"list_ticket_department/"+e` (无显式 data/params) | `GET {A}/list_ticket_department/:id` → `admin/ticket_department/getDetail`；规则 `app\admin\controller\TicketDepartmentcontroller::getdetail`；[源行](../../data/route/admin.php#L461) | 未提取；新设计明确成功后重读受影响对象 |
| `2d15bf9e` / `submitForm` | `"post"` `"add_ticket_department"` (data) | `POST {A}/add_ticket_department` → `admin/ticket_department/add`；规则 `app\admin\controller\TicketDepartmentcontroller::add`；[源行](../../data/route/admin.php#L455) | 未提取；新设计明确成功后重读受影响对象 |
| `2d15bf9e` / `submitForm` | `"post"` `"save_ticket_department"` (data) | `POST {A}/save_ticket_department` → `admin/ticket_department/save`；规则 `app\admin\controller\TicketDepartmentcontroller::save`；[源行](../../data/route/admin.php#L456) | 未提取；新设计明确成功后重读受影响对象 |
| `2d15bf9e` / `getUpstreamConfigOptions` | `未显式指定` `"common/get_upstream_ticket_department_list"` (params) | `GET {A}/common/get_upstream_ticket_department_list` → `admin/common/getUpstreamTicketDepartmentList`；规则 `app\admin\controller\Commoncontroller::getupstreamticketdepartmentlist`；[源行](../../data/route/admin.php#L104) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`updateFields: this.$router.push({path:"/add-custom-fields",query:{ticketId:this.$route.query.id,fieldId:e}})`
- 旧跳转：`addNewFields: this.$router.push({path:"/add-custom-fields",query:{ticketId:this.$route.query.id}})`
- 旧跳转：`submitForm: e.$router.push({path:"/work-order-dept"})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p139"></a>

## 工单自定义字段 `/add-custom-fields`

旧版证据：[P139](27-admin-built-page-evidence.md#p139)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“工单自定义字段”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `d0fe/0207a097` | `el-form-item` | `字段名称 ($lang.field_name)` / `fieldname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d0fe/0207a097` | `el-form-item` | `字段类型 ($lang.filed_type)` / `fieldtype` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d0fe/0207a097` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d0fe/0207a097` | `el-form-item` | `选项 ($lang.option)` / `fieldoptions` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `d0fe/0207a097` | `el-form-item` | `必填 ($lang.must_fill_in)` / `required` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `d0fe/0207a097` | `保存 ($lang.save)` | `on.click → e.saveFields` | `无提取条件` |
| `d0fe/0207a097` | `取消 ($lang.cancel)` | `on.click → e.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0207a097` / `getDetail` | `"get"` `"get_ticket_param_val"` (params) | `GET {A}/get_ticket_param_val` → `admin/ticket_department/getTicketParamVal`；规则 `app\admin\controller\TicketDepartmentcontroller::getticketparamval`；[源行](../../data/route/admin.php#L469) | 未提取；新设计明确成功后重读受影响对象 |
| `0207a097` / `saveFields` | `"get"` `"edit_ticket_custom_param"` (params) | `GET {A}/edit_ticket_custom_param` → `admin/ticket_department/editTicketCustomParam`；规则 `app\admin\controller\TicketDepartmentcontroller::editticketcustomparam`；[源行](../../data/route/admin.php#L470) | 未提取；新设计明确成功后重读受影响对象 |
| `0207a097` / `saveFields` | `"get"` `"add_ticket_custom_param"` (params) | `GET {A}/add_ticket_custom_param` → `admin/ticket_department/addTicketCustomParam`；规则 `app\admin\controller\TicketDepartmentcontroller::addticketcustomparam`；[源行](../../data/route/admin.php#L468) | 未提取；新设计明确成功后重读受影响对象 |
| `0207a097` / `getFieldsList` | `"get"` `"get_custom_param_type"` (params) | `GET {A}/get_custom_param_type` → `admin/ticket_department/getCustomParamType`；规则 `app\admin\controller\TicketDepartmentcontroller::getcustomparamtype`；[源行](../../data/route/admin.php#L467) | `objToArr` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`saveFields: e.$router.back()`
- 旧跳转：`cancel: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p140"></a>

## 工单状态 `/work-order-status`

旧版证据：[P140](27-admin-built-page-evidence.md#p140)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“工单状态”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5a4e/58a4da42` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5a4e/58a4da42` | `el-table-column` | `标题 ($lang.title)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5a4e/58a4da42` | `el-table-column` | `排序 ($lang.sort)` / `order` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5a4e/58a4da42` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `5a4e/58a4da42` | `el-dialog` | `-` / `-` / `""===t.statusId?t.$lang.add_process_sheet_state:t.$lang.modify_workorder_status` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `5a4e/58a4da42` | `el-form-item` | `状态标题 ($lang.state_title)` / `title` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5a4e/58a4da42` | `el-form-item` | `状态颜色 ($lang.state_the_color)` / `color` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5a4e/58a4da42` | `el-form-item` | `产品排序 ($lang.product_sort)` / `order` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5a4e/58a4da42` | `添加` | `on.click → t.addHandleClick` | `无提取条件` |
| `5a4e/58a4da42` | `编辑 ($lang.edit)` | `on.click → function(a){return t.editHandleClick(e.row.id)}` | `scopedSlots` |
| `5a4e/58a4da42` | `删除 ($lang.delete)` | `on.click → function(a){return t.deleteHandleClick(e.row.id)}` | `scopedSlots; else([1,2,3,4,5].includes(e.row.id))` |
| `5a4e/58a4da42` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogFormVisible=!1}` | `无提取条件` |
| `5a4e/58a4da42` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `58a4da42` / `saveRowEdit` | `"post"` `"save_ticket_status"` (data) | `POST {A}/save_ticket_status` → `admin/ticket_status/save`；规则 `app\admin\controller\TicketStatuscontroller::save`；[源行](../../data/route/admin.php#L463) | `getData` |
| `58a4da42` / `getData` | `未显式指定` `"list_ticket_status"` (无显式 data/params) | `GET {A}/list_ticket_status` → `admin/ticket_status/getList`；规则 `app\admin\controller\TicketStatuscontroller::getlist`；[源行](../../data/route/admin.php#L465) | 未提取；新设计明确成功后重读受影响对象 |
| `58a4da42` / `getFormInfoById` | `未显式指定` `"list_ticket_status/"+t` (无显式 data/params) | `GET {A}/list_ticket_status/:id` → `admin/ticket_status/getDetail`；规则 `app\admin\controller\TicketStatuscontroller::getdetail`；[源行](../../data/route/admin.php#L466) | 未提取；新设计明确成功后重读受影响对象 |
| `58a4da42` / `submitForm` | `"post"` `"add_ticket_status"` (data) | `POST {A}/add_ticket_status` → `admin/ticket_status/add`；规则 `app\admin\controller\TicketStatuscontroller::add`；[源行](../../data/route/admin.php#L462) | `getData` |
| `58a4da42` / `submitForm` | `"post"` `"save_ticket_status"` (data) | `POST {A}/save_ticket_status` → `admin/ticket_status/save`；规则 `app\admin\controller\TicketStatuscontroller::save`；[源行](../../data/route/admin.php#L463) | `getData` |
| `58a4da42` / `deleteHandleClick` | `"post"` `"delete_ticket_status"` (data) | `POST {A}/delete_ticket_status` → `admin/ticket_status/delete`；规则 `app\admin\controller\TicketStatuscontroller::delete`；[源行](../../data/route/admin.php#L464) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p141"></a>

## 工单传递规则 `/work-order-rules`

旧版证据：[P141](27-admin-built-page-evidence.md#p141)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“工单传递规则”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `47bf/06ccbe80` | `el-table-column` | `部门 ($lang.department)` / `departments` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `47bf/06ccbe80` | `el-table-column` | `产品 ($lang.product)` / `products` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `47bf/06ccbe80` | `el-table-column` | `屏蔽关键字 ($lang.shield_key)` / `mask_keywords` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `47bf/06ccbe80` | `el-table-column` | `自动回复 ($lang.auto_reply)` / `is_open_auto_reply` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `47bf/06ccbe80` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `47bf/06ccbe80` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `47bf/06ccbe80` | `el-dialog` | `-` / `-` / `""===t.rulesId?t.$lang.add_process_order_transfer_rule:t.$lang.modify_workorder_transfer_rule` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `47bf/06ccbe80` | `el-form-item` | `部门 ($lang.department)` / `departments` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `47bf/06ccbe80` | `el-form-item` | `产品 ($lang.product)` / `products` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `47bf/06ccbe80` | `el-form-item` | `自动回复 ($lang.auto_reply)` / `is_open_auto_reply` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `47bf/06ccbe80` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `47bf/06ccbe80` | `el-form-item` | `屏蔽关键字 ($lang.shield_key)` / `mask_keywords` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `47bf/06ccbe80` | `添加规则` | `on.click → t.addHandleClick` | `无提取条件` |
| `47bf/06ccbe80` | `编辑 ($lang.edit)` | `on.click → function(r){return t.editHandleClick(e.row)}` | `scopedSlots` |
| `47bf/06ccbe80` | `删除 ($lang.delete)` | `on.click → function(r){return t.deleteHandleClick(e.row.id)}` | `scopedSlots` |
| `47bf/06ccbe80` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogFormVisible=!1}` | `无提取条件` |
| `47bf/06ccbe80` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `06ccbe80` / `getData` | `未显式指定` `"list_ticket_deliver"` (无显式 data/params) | `GET {A}/list_ticket_deliver` → `admin/ticket_deliver/getList`；规则 `app\admin\controller\TicketDelivercontroller::getlist`；[源行](../../data/route/admin.php#L476) | 未提取；新设计明确成功后重读受影响对象 |
| `06ccbe80` / `getFormInfoById` | `未显式指定` `"get_ticket_deliver"` (无显式 data/params) | `GET {A}/get_ticket_deliver` → `admin/ticket_deliver/addPage`；规则 `app\admin\controller\TicketDelivercontroller::addpage`；[源行](../../data/route/admin.php#L472) | 未提取；新设计明确成功后重读受影响对象 |
| `06ccbe80` / `getFormInfoById` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |
| `06ccbe80` / `submitForm` | `"post"` `"add_ticket_deliver"` (data) | `POST {A}/add_ticket_deliver` → `admin/ticket_deliver/add`；规则 `app\admin\controller\TicketDelivercontroller::add`；[源行](../../data/route/admin.php#L473) | `getData` |
| `06ccbe80` / `submitForm` | `"post"` `"save_ticket_deliver"` (data) | `POST {A}/save_ticket_deliver` → `admin/ticket_deliver/save`；规则 `app\admin\controller\TicketDelivercontroller::save`；[源行](../../data/route/admin.php#L474) | `getData` |
| `06ccbe80` / `deleteHandleClick` | `"post"` `"delete_ticket_deliver"` (data) | `POST {A}/delete_ticket_deliver` → `admin/ticket_deliver/delete`；规则 `app\admin\controller\TicketDelivercontroller::delete`；[源行](../../data/route/admin.php#L475) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p180"></a>

## 服务支持设置 `/service-support`

旧版证据：[P180](27-admin-built-page-evidence.md#p180)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“服务支持设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4374/49594bc8` | `el-tab-pane` | `t.name.toString()` / `-` / `-` | `e.isMobile; 循环 e.pageData.level_data` | 主区导航；保留对象与选中项 |
| `4374/49594bc8` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `文件名 ($lang.file_name)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `文件类型 ($lang.file_type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `需要登录 ($lang.need_to_log_to)` / `clientsonly` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `需要购买 ($lang.request_to_buy)` / `productdownload` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `隐藏 ($lang.conceal)` / `hidden` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `下载次数 ($lang.download_count)` / `downloads` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-table-column` | `创建时间 ($lang.create_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4374/49594bc8` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4374/49594bc8` | `新建分组 ($lang.new_grouping)` | `on.click → e.addGroup` | `e.isMobile` |
| `4374/49594bc8` | `新建分组 ($lang.new_grouping)` | `on.click → e.addGroup` | `无提取条件` |
| `4374/49594bc8` | `添加文件 ($lang.add_file)` | `on.click → e.goFile` | `无提取条件` |
| `4374/49594bc8` | `n.title` | `on.click → function(t){return e.goEdit(n)}` | `scopedSlots` |
| `4374/49594bc8` | `移除 ($lang.remove)` | `on.click → e.delFile` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `49594bc8` / `delFile` | `"delete"` `"downloads/file"` (params) | `DELETE {A}/downloads/file` → `admin/Downloads/deleteFile`；规则 `app\admin\controller\Downloadscontroller::deletefile`；[源行](../../data/route/admin.php#L585) | `getDownloadList` |
| `49594bc8` / `moveUp` | `"post"` `"downloads/updatesort"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getPreId` |
| `49594bc8` / `moveDown` | `"post"` `"downloads/updatesort"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getNextId` |
| `49594bc8` / `toTop` | `"post"` `"downloads/updatesort"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `49594bc8` / `delGroup` | `"delete"` `"downloads/cat"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `49594bc8` / `editGroup` | `未显式指定` `"downloads/edit"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `49594bc8` / `handelConfirm` | `"post"` `"downloads/create"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `onClose`、`getDownloadList` |
| `49594bc8` / `handelConfirm` | `"post"` `"downloads/update"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `onClose`、`getDownloadList` |
| `49594bc8` / `getDownloadList` | `未显式指定` `"downloads/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goEdit: this.$router.push({name:"File",query:{id:this.groupID,wid:e.id,type:"edit"}})`
- 旧跳转：`goFile: this.$router.push({name:"File",query:{id:this.groupID,type:"add"}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
