# 商品、服务与资源逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [配置项编辑兼容入口](#p005) `/edit-configurable-option1` | `form` | 路由 factory 指向模块 |
| [高级配置](#p009) `/senior-config` | `form` | 路由 factory 指向模块 |
| [业务产品列表](#p051) `/customer-product` | `list` | 路由 factory 指向模块 |
| [取消请求](#p054) `/cancel-request` | `list` | 路由 factory 指向模块 |
| [客户取消请求](#p059) `/customer-cancelreq` | `list` | 路由 factory 指向模块 |
| [商品管理](#p142) `/product-server` | `list` | 路由 factory 指向模块 |
| [商品分组编辑](#p143) `/add-product-group` | `form` | 路由 factory 指向模块 |
| [商品编辑容器](#p144) `/edit-product` | `detail` | chunk 内候选，页面归属待人工确认 |
| [全局可配置项](#p145) `/configurable-option` | `list` | 路由 factory 指向模块 |
| [配置项组编辑](#p146) `/edit-configurable-option-group` | `form` | 路由 factory 指向模块 |
| [服务器配置](#p147) `/server-settings` | `list` | 路由 factory 指向模块 |
| [服务器编辑](#p148) `/add-server` | `form` | 路由 factory 指向模块 |
| [服务器分组](#p149) `/group-list` | `list` | 路由 factory 指向模块 |
| [服务器分组编辑](#p150) `/add-group` | `form` | 路由 factory 指向模块 |
| [接口添加](#p151) `/add-interface` | `form` | 路由 factory 指向模块 |
| [DCIM 接口](#p152) `/dcim` | `list` | 路由 factory 指向模块 |
| [DCIM 详情](#p153) `/dcim-view` | `detail` | 路由 factory 指向模块 |
| [DCIM 流量](#p154) `/dcim-traffic` | `report` | 路由 factory 指向模块 |
| [DCIM 流量日志](#p155) `/dcim-traffic-log` | `log` | 路由 factory 指向模块 |
| [DCIM 商品](#p156) `/dcim-product` | `list` | 路由 factory 指向模块 |
| [魔方云接口](#p157) `/zjmfcloud` | `list` | 路由 factory 指向模块 |
| [魔方云商品](#p158) `/zjmfcloud-product` | `list` | 路由 factory 指向模块 |
| [手工资源](#p159) `/munual-resource` | `list` | 路由 factory 指向模块 |
| [上游编辑](#p160) `/upStream-edit` | `form` | 路由 factory 指向模块 |
| [手工资源编辑](#p161) `/addOrEdit-resource` | `form` | 路由 factory 指向模块 |
| [任务队列](#p162) `/task-queue` | `log` | 路由 factory 指向模块 |
| [资源配置编辑](#p163) `/configure-edit` | `form` | 路由 factory 指向模块 |
| [API 设置](#p164) `/api-setup` | `form` | 路由 factory 指向模块 |
| [统计任务队列](#p165) `/statistics-taskQueue` | `log` | 路由 factory 指向模块 |
| [上游商品列表](#p166) `/commodity-list` | `list` | 路由 factory 指向模块 |
| [上游产品列表](#p167) `/commodity-product` | `list` | 路由 factory 指向模块 |
| [上游任务队列](#p168) `/commodity-taskQueue` | `log` | 路由 factory 指向模块 |
| [供应商编辑](#p169) `/add-supplier` | `form` | 路由 factory 指向模块 |
| [魔方财务接口](#p171) `/zjmf-api` | `list` | 路由 factory 指向模块 |
| [DCIM 授权](#p193) `/dcim-authorization` | `list` | 路由 factory 指向模块 |
| [DCIM 授权停用页](#p194) `/dcim-authorization-disable` | `detail` | 路由 factory 指向模块 |
| [DCIM 授权异常页](#p195) `/dcim-authorization-error` | `detail` | 路由 factory 指向模块 |
| [DCIM 调试日志](#p196) `/dcim-debug-log` | `log` | 路由 factory 指向模块 |
| [DCIM 授权更新页](#p197) `/dcim-authorization-update` | `form` | 路由 factory 指向模块 |
| [资源池容器](#p198) `/resource-pool` | `detail` | 路由 factory 指向模块 |
| [资源池订单管理](#p216) `/order-management-list` | `list` | 路由 factory 指向模块 |
| [资源池退款详情](#p217) `/refund-detail` | `detail` | 路由 factory 指向模块 |
| [资源池售后详情](#p218) `/aftersale-detail` | `detail` | 路由 factory 指向模块 |
| [资源池业务管理](#p219) `/business-management` | `list` | 路由 factory 指向模块 |
| [资源池任务队列](#p220) `/resourcePool-taskQueue` | `log` | 路由 factory 指向模块 |
| [资源池工单](#p221) `/resourcePool-workOrder` | `list` | 路由 factory 指向模块 |
| [资源池设置](#p222) `/resourcePool-set` | `form` | 路由 factory 指向模块 |
| [资源池统计](#p223) `/statistical-information` | `report` | 路由 factory 指向模块 |
| [资源池商品管理](#p224) `/commodity-management` | `list` | 路由 factory 指向模块 |
| [资源池协助审核](#p225) `/ssistant-audit` | `list` | 路由 factory 指向模块 |
| [资源池协助申请](#p226) `/assist-apply` | `form` | 路由 factory 指向模块 |
| [资源池协助详情](#p227) `/assist-detail` | `detail` | 路由 factory 指向模块 |
| [资源池商店](#p228) `/resource-pool-shop` | `list` | 路由 factory 指向模块 |
| [资源池日志](#p229) `/resourcePool-logs` | `log` | 路由 factory 指向模块 |

<a id="p005"></a>

## 配置项编辑兼容入口 `/edit-configurable-option1`

旧版证据：[P005](27-admin-built-page-evidence.md#p005)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“配置项编辑兼容入口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `46fe/727b3ecc` | `el-form-item` | `配置选项名称 ($lang.configuration_optione_name)` / `option_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `配置项类型 ($lang.configuration_item_type)` / `option_type` / `-` | `1!=e.updatePirce` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `高级设置 ($lang.advanced_setting)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `选项说明 ($lang.optionexplain)` / `-` / `-` | `1==e.optionFormData.senior` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `选项尾部文字 ($lang.option_tail_text)` / `-` / `-` | `1==e.optionFormData.senior` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `数量阶梯 ($lang.number_ladder)` / `qty_stage` / `-` | `else(1!=e.optionFormData.senior\|\|4!=e.optionFormData.option_type&&7!=e.optionFormData.option_type&&9!=e.optionFormData.option_type&&11!=e.optionFormData.option_type&&14!=e.optionFormDat ...)` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `自动计算价格 ($lang.automatic_price_calculation)` / `-` / `-` | `1==e.optionFormData.senior` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `添加子项 ($lang.add_child)` / `e.optionId?"":"addoptionname"` / `-` | `else(20==e.optionFormData.option_type&&e.domUpdate&&1!=e.updatePirce); 1!=e.updatePirce; 3!==e.optionFormData.option_type\|\|3===e.optionFormData.option_type&&!e.optionId` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `-` / `addsortorder` / `-` | `else(20==e.optionFormData.option_type&&e.domUpdate&&1!=e.updatePirce); 1!=e.updatePirce; 3!==e.optionFormData.option_type` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-form-item` | `-` / `addhidden` / `-` | `else(20==e.optionFormData.option_type&&e.domUpdate&&1!=e.updatePirce); 1!=e.updatePirce; 3!==e.optionFormData.option_type` | 分组表单；未知原值不置空 |
| `46fe/727b3ecc` | `el-dialog` | `-` / `-` / `提示` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `46fe/727b3ecc` | `同步操作系统 ($lang.synchronous_operating_system)` | `on.click → e.asyncOsApi` | `1!=e.updatePirce; else(5!==e.optionType\|\|"dcim"!==e.prePage&&"dcimcloud"!==e.prePage)` |
| `46fe/727b3ecc` | `e._s(e.optionId?e.$lang.save_the_changes:e.$lang.confirm_add)+" "` | `on.click → e.saveEditSubmitForm` | `20!=e.optionFormData.option_type\|\|1==e.updatePirce` |
| `46fe/727b3ecc` | `e._s(e.optionId?e.$lang.save_the_changes:e.$lang.confirm_add)+" "` | `on.click → e.saveConfigOptionInfo` | `else(20!=e.optionFormData.option_type\|\|1==e.updatePirce)` |
| `46fe/727b3ecc` | `关闭 ($lang.shut_down)` | `on.click → e.backtHandleClick` | `e.$valIsNull(e.updatePirce)` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `727b3ecc` / `addConfigPage` | `未显式指定` `"options/add_options_page"` (params) | `GET {A}/options/add_options_page` → `admin/config_options/addOptionsPage`；规则 `app\admin\controller\ConfigOptionscontroller::addoptionspage`；[源行](../../data/route/admin.php#L251) | 未提取；新设计明确成功后重读受影响对象 |
| `727b3ecc` / `editConfigPage` | `未显式指定` `"options/edit_config/"+e` (params) | `GET {A}/options/edit_config/:cid` → `admin/config_options/editConfig`；规则 `app\admin\controller\ConfigOptionscontroller::editconfig`；[源行](../../data/route/admin.php#L260) | `setupfeeToPrice`、`planRatioSet`、`setRateNone`、`optionTypeChange`、`moduleDrag` |
| `727b3ecc` / `saveEditSubmitForm` | `"post"` `"options/add_options"` (data) | `POST {A}/options/add_options` → `admin/config_options/addOptions`；规则 `app\admin\controller\ConfigOptionscontroller::addoptions`；[源行](../../data/route/admin.php#L252) | `editConfigPage`、`localConfigRatioSet` |
| `727b3ecc` / `saveEditSubmitForm` | `"post"` `"options/edit_config_post"` (data) | `POST {A}/options/edit_config_post` → `admin/config_options/editConfigPost`；规则 `app\admin\controller\ConfigOptionscontroller::editconfigpost`；[源行](../../data/route/admin.php#L261) | `editConfigPage`、`localConfigRatioSet` |
| `727b3ecc` / `saveConfigOptionInfo` | `"post"` `"options/saveConfigOptionInfo"` (data) | `POST {A}/options/saveConfigOptionInfo` → `admin/config_options/saveConfigOptionInfo`；规则 `app\admin\controller\ConfigOptionscontroller::saveconfigoptioninfo`；[源行](../../data/route/admin.php#L265) | `editConfigPage` |
| `727b3ecc` / `deleteSubOptionHandleClick` | `未显式指定` `"options/delete_sub_options/"+e` (无显式 data/params) | `GET {A}/options/delete_sub_options/:subid` → `admin/config_options/deleteSubOptions`；规则 `app\admin\controller\ConfigOptionscontroller::deletesuboptions`；[源行](../../data/route/admin.php#L253) | `editConfigPage` |
| `727b3ecc` / `asyncOsApi` | `"post"` `"options/config_options_check_os/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `editConfigPage` |
| `727b3ecc` / `del_list` | `"post"` `"options/delLinkAgeSub"` (data) | `POST {A}/options/delLinkAgeSub` → `admin/config_options/delLinkAgeSub`；规则 `app\admin\controller\ConfigOptionscontroller::dellinkagesub`；[源行](../../data/route/admin.php#L264) | `editConfigPage` |
| `727b3ecc` / `moduleDrag` | `"post"` `"options/saveLinkAgeOrder"` (data) | `POST {A}/options/saveLinkAgeOrder` → `admin/config_options/saveLinkAgeOrder`；规则 `app\admin\controller\ConfigOptionscontroller::savelinkageorder`；[源行](../../data/route/admin.php#L263) | 未提取；新设计明确成功后重读受影响对象 |
| `727b3ecc` / `inputBlur` | `"post"` `"options/saveLinkAgeLevel"` (data) | `POST {A}/options/saveLinkAgeLevel` → `admin/config_options/saveLinkAgeLevel`；规则 `app\admin\controller\ConfigOptionscontroller::savelinkagelevel`；[源行](../../data/route/admin.php#L262) | 未提取；新设计明确成功后重读受影响对象 |
| `727b3ecc` / `sub_input_click` | `未显式指定` `"options/getNextLinkAgeList"` (params) | `GET {A}/options/getNextLinkAgeList` → `admin/config_options/getNextLinkAgeList`；规则 `app\admin\controller\ConfigOptionscontroller::getnextlinkagelist`；[源行](../../data/route/admin.php#L266) | `moduleDrag` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`saveEditSubmitForm: e.$router.push({path:"/edit-configurable-option1",query:{groupId:e.groupId,optionId:e.optionId,pid:e.pid}})`
- 旧跳转：`inputBlur: r.$router.push({path:"/edit-configurable-option1",query:{groupId:r.groupId,optionId:c.option_id,pid:r.pid}})`
- 旧跳转：`handleClose: this.$router.push({path:"/edit-configurable-option1",query:{groupId:this.groupId,optionId:this.optionId,pid:this.pid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p009"></a>

## 高级配置 `/senior-config`

旧版证据：[P009](27-admin-built-page-evidence.md#p009)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `-`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“高级配置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `b0e2/13c33111` | `提交 ($lang.submit)` | `on.click → t.submit` | `else(t.pageLoading)` |
| `b0e2/13c33111` | `取消 ($lang.cancel)` | `on.click → t.cancel` | `else(t.pageLoading)` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `13c33111` / `getData` | `未显式指定` `"advanced_options/page"` (params) | `GET {A}/advanced_options/page` → `admin/AdvancedOptions/page`；规则 `app\admin\controller\AdvancedOptionscontroller::page`；[源行](../../data/route/admin.php#L801) | `setSubValue`、`defatulOptionnSet` |
| `13c33111` / `linkRemove` | `"delete"` `"advanced_options/deletecondition"` (params) | `DELETE {A}/advanced_options/deletecondition` → `admin/AdvancedOptions/deleteCondition`；规则 `app\admin\controller\AdvancedOptionscontroller::deletecondition`；[源行](../../data/route/admin.php#L803) | `getData` |
| `13c33111` / `resultRemove` | `"delete"` `"advanced_options/deleteresult"` (params) | `DELETE {A}/advanced_options/deleteresult` → `admin/AdvancedOptions/deleteResult`；规则 `app\admin\controller\AdvancedOptionscontroller::deleteresult`；[源行](../../data/route/admin.php#L804) | `getData` |
| `13c33111` / `addConditon` | `"post"` `"advanced_options/addcondition"` (data) | `POST {A}/advanced_options/addcondition` → `admin/AdvancedOptions/addCondition`；规则 `app\admin\controller\AdvancedOptionscontroller::addcondition`；[源行](../../data/route/admin.php#L805) | `getData`、`clearFormData` |
| `13c33111` / `submit` | `"post"` `"advanced_options/create"` (data) | `POST {A}/advanced_options/create` → `admin/AdvancedOptions/create`；规则 `app\admin\controller\AdvancedOptionscontroller::create`；[源行](../../data/route/admin.php#L802) | `getData`、`clearFormData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`cancel: this.$router.push({path:"/edit-product",query:{id:this.pid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p051"></a>

## 业务产品列表 `/customer-product`

旧版证据：[P051](27-admin-built-page-evidence.md#p051)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“业务产品列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2e50/33d8e9bc` | `el-tab-pane` | `t` / `-` / `-` | `循环 t.domainstatusOptions` | 主区导航；保留对象与选中项 |
| `2e50/33d8e9bc` | `el-form-item` | `产品类型 ($lang.product_type)` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `主机状态 ($lang.host_state)` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `付款周期 ($lang.payment_period)` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `主机名 ($lang.host_name)` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `ip` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `客户 ($lang.client)` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-form-item` | `" "` / `-` / `-` | `t.showSearchArea` | 分组表单；未知原值不置空 |
| `2e50/33d8e9bc` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `客户 ($lang.client)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `产品名称（主机名） ($lang.product_host_name)` / `productname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `购买时间 ($lang.purchasing_date)` / `regdate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `到期时间 ($lang.expire_date)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `周期 ($lang.period)` / `billingcycle` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `价格 ($lang.price)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `状态 ($lang.state)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2e50/33d8e9bc` | `el-table-column` | `销售 ($lang.sell)` / `user_nickname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2e50/33d8e9bc` | `帮助文档 ($lang.help_document)` | `on.click → t.openDoc` | `无提取条件` |
| `2e50/33d8e9bc` | `搜索` | `on.click → t.searchHandeClick` | `无提取条件` |
| `2e50/33d8e9bc` | `" "+t._s(t.showSearchArea?t.$lang.pack_up_the_search:t.$lang.advanced_search)+" "` | `on.click → function(e){t.showSearchArea=!t.showSearchArea}` | `无提取条件` |
| `2e50/33d8e9bc` | `搜索 ($lang.search)` | `on.click → t.searchHandeClick` | `t.showSearchArea` |
| `2e50/33d8e9bc` | `清空 ($lang.empty)` | `on.click → t.clearSearchHandleClick` | `t.showSearchArea` |
| `2e50/33d8e9bc` | `图标/动态文案，回查原证据` | `on.click → function(e){return e.preventDefault(),t.getJwt(e)}`<br>`on.mousedown → t.rightHandleClick` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `33d8e9bc` / `getJwt` | `未显式指定` `"login_by_user/"+t` (无显式 data/params) | `GET {A}/login_by_user/:uid` → `admin/user_manage/loginByUser`；规则 `app\admin\controller\UserManagecontroller::loginbyuser`；[源行](../../data/route/admin.php#L205) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `onBlur` | `"post"` `"post_client_notes"` (data) | `POST {A}/post_client_notes` → `admin/user_manage/postClientNotes`；规则 `app\admin\controller\UserManagecontroller::postclientnotes`；[源行](../../data/route/admin.php#L213) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `getUserInfo` | `"post"` `"host/userInfo"` (data) | `POST {A}/host/userInfo` → `admin/Host/userInfo`；规则 `app\admin\controller\Hostcontroller::userinfo`；[源行](../../data/route/admin.php#L616) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `getTimeType` | `未显式指定` `"host/get_timetype"` (无显式 data/params) | `GET {A}/host/get_timetype` → `admin/Host/getTimetype`；规则 `app\admin\controller\Hostcontroller::gettimetype`；[源行](../../data/route/admin.php#L615) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `getProductList` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `33d8e9bc` / `getProductList` | `未显式指定` `"host/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:n.uid,hid:n.id}}`
- 旧跳转：`render router-link: {name:"abstract",query:{id:n.uid}}`
- 旧跳转：`adSearch: e.$router.push({query:i})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p054"></a>

## 取消请求 `/cancel-request`

旧版证据：[P054](27-admin-built-page-evidence.md#p054)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“取消请求”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4b27/-` | `el-form-item` | `-` / `tabs` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4b27/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `主机ID ($lang.hostid)` / `relid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `取消原因 ($lang.cancel_reason)` / `reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `主机ID ($lang.hostid)` / `hostid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `用户ID ($lang.user_id)` / `uid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `主机状态 ($lang.host_state)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `到期时间 ($lang.due_time)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `产品名称 ($lang.product_name)` / `productname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `组名称 ($lang.group_name)` / `groupname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `显示类型描述 ($lang.display_type_description)` / `type_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `显示产品描述 ($lang.display_product_description)` / `product_desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4b27/-` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4b27/-` | `删除 ($lang.delete)` | `on.click → function(a){return e.deleteRequest(t.row)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"cancel_request/list"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getCancelData` | `未显式指定` `"cancel_request/cancellist"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `deleteRequest` | `"delete"` `"cancel_request/list"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p059"></a>

## 客户取消请求 `/customer-cancelreq`

旧版证据：[P059](27-admin-built-page-evidence.md#p059)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“客户取消请求”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `551f2/5e963c19` | `el-dialog` | `-` / `-` / `-` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `551f2/5e963c19` | `el-table-column` | `姓名 ($lang.name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `产品 ($lang.product)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `类型(立即、到期) ($lang.type_immediate_due)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `原因 ($lang.reason)` / `reason` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `请求时间 ($lang.req_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `删除时间 ($lang.delete_time)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `产品状态 ($lang.product_status)` / `domainstatus` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `执行状态 ($lang.execution_status)` / `cancel_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `551f2/5e963c19` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `551f2/5e963c19` | `帮助文档 ($lang.help_document)` | `on.click → t.openDoc` | `无提取条件` |
| `551f2/5e963c19` | `取消原因管理 ($lang.cancel_cause_management)` | `on.click → t.cancelReason` | `无提取条件` |
| `551f2/5e963c19` | `" "+t._s(n.username)+" "` | `on.click → function(e){return t.goToView(n.uid)}` | `scopedSlots` |
| `551f2/5e963c19` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteHanleClick(n)}` | `scopedSlots; "被删除"!==n.domainstatus.name` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5e963c19` / `handelConfirm` | `"post"` `"request_cancel_reason_post"` (data) | `POST {A}/request_cancel_reason_post` → `admin/user_manage/requestCancelReasonPost`；规则 `app\admin\controller\UserManagecontroller::requestcancelreasonpost`；[源行](../../data/route/admin.php#L210) | 未提取；新设计明确成功后重读受影响对象 |
| `5e963c19` / `cancelReason` | `未显式指定` `"request_cancel_reason"` (无显式 data/params) | `GET {A}/request_cancel_reason` → `admin/user_manage/requestCancelReason`；规则 `app\admin\controller\UserManagecontroller::requestcancelreason`；[源行](../../data/route/admin.php#L209) | 未提取；新设计明确成功后重读受影响对象 |
| `5e963c19` / `getData` | `未显式指定` `"request_cancel_list"` (params) | `GET {A}/request_cancel_list` → `admin/user_manage/requestCancelList`；规则 `app\admin\controller\UserManagecontroller::requestcancellist`；[源行](../../data/route/admin.php#L207) | 未提取；新设计明确成功后重读受影响对象 |
| `5e963c19` / `deleteHanleClick` | `"delete"` `"request_cancel_list/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:n.uid}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:n.uid,hid:n.hostid,fa:"product-list"}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:e.row.hosts[0].uid,hid:e.row.hosts.length?e.row.hosts[0].hostid:"",fa:"productList"}}`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p142"></a>

## 商品管理 `/product-server`

旧版证据：[P142](27-admin-built-page-evidence.md#p142)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“商品管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `1cb9/43afaf0e` | `el-table-column` | `""` / `guid` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `商品名称 ($lang.commodity_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `类型 ($lang.type)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `定价 ($lang.pricing)` / `pay_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `库存 ($lang.inventory)` / `qty` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `已开通/总数量 ($lang.available_total_quantity)` / `count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `自动开通 ($lang.automatic_opening)` / `auto_setup` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-dialog` | `-` / `-` / `添加商品 ($lang.add_commodity)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1cb9/43afaf0e` | `el-form-item` | `商品名称 ($lang.commodity_name)` / `productname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `商品类型 ($lang.commodity_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `商品组 ($lang.commodity_group)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `会员中心导航分类 ($lang.member_center_navigation_classification)` / `ptype` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-dialog` | `-` / `-` / `复制商品 ($lang.copy_goods)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1cb9/43afaf0e` | `el-form-item` | `现有的商品 ($lang.available_goods)` / `existingproduct` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `新商品名称 ($lang.new_product_name)` / `newproductname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-dialog` | `-` / `-` / `e.addGroupForm.id?e.$lang.editing_group:e.$lang.the_new_grouping` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1cb9/43afaf0e` | `el-form-item` | `分组类型 ($lang.create_a_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `一级分组 ($lang.primary_group)` / `gid` / `-` | `"1"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `商品组名称 ($lang.commodity_group_name)` / `name` / `-` | `"1"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `是否隐藏 ($lang.whether_to_hide)` / `-` / `-` | `"1"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `商品组标题 ($lang.commodity_group_title)` / `headline` / `-` | `"1"==e.createType; e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `商品组标语 ($lang.merchandise_group_slogan)` / `tagline` / `-` | `"1"==e.createType; e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `访问别名 ($lang.access_to_the_alias)` / `bm` / `-` | `"1"==e.createType; e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `订购表格模板 ($lang.order_form_template)` / `-` / `-` | `"1"==e.createType; e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `""` / `order_frm_tpl` / `-` | `"1"==e.createType; "custom"===e.addGroupForm.tpl_type&&e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `自定义字段` / `-` / `-` | `"1"==e.createType; e.seniorFlag` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `分组组名称 ($lang.grouping_name)` / `name` / `-` | `"2"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `是否隐藏 ($lang.whether_to_hide)` / `-` / `-` | `"2"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `自定义字段` / `-` / `-` | `"2"==e.createType` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-form-item` | `访问URL ($lang.visit_url)` / `-` / `-` | `e.addGroupForm.id` | 分组表单；未知原值不置空 |
| `1cb9/43afaf0e` | `el-dialog` | `-` / `-` / `同步操作系统 ($lang.synchronous_operating_system)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1cb9/43afaf0e` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `商品名称 ($lang.commodity_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1cb9/43afaf0e` | `el-table-column` | `同步结果 ($lang.synchronization_results)` / `msg` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `1cb9/43afaf0e` | `新增分组 ($lang.the_new_grouping)` | `on.click → e.goToAddGroup` | `无提取条件` |
| `1cb9/43afaf0e` | `新增商品 ($lang.the_new_goods)` | `on.click → e.showAddProduct` | `无提取条件` |
| `1cb9/43afaf0e` | `复制商品 ($lang.copy_goods)` | `on.click → e.showCopyProduct` | `无提取条件` |
| `1cb9/43afaf0e` | `同步操作系统 ($lang.synchronous_operating_system)` | `on.click → function(t){e.asyncOsDialog=!0}` | `无提取条件` |
| `1cb9/43afaf0e` | `编辑 ($lang.edit)` | `on.click → function(t){return e.editGroup(a)}` | `scopedSlots; a.groups\|\|a.products` |
| `1cb9/43afaf0e` | `新增商品` | `on.click → function(t){return e.showAddProduct(a)}` | `scopedSlots; a.groups\|\|a.products; a.products` |
| `1cb9/43afaf0e` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteGroup(a)}` | `scopedSlots; a.groups\|\|a.products; a.groups&&!a.groups.length&&1!==a.id` |
| `1cb9/43afaf0e` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteGroup(a)}` | `scopedSlots; a.groups\|\|a.products; a.products&&!a.products.length` |
| `1cb9/43afaf0e` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteProduct(a.id)}` | `scopedSlots; else(a.groups\|\|a.products)` |
| `1cb9/43afaf0e` | `确定 ($lang.confirm)` | `on.click → e.submitForm` | `无提取条件` |
| `1cb9/43afaf0e` | `取消 ($lang.cancel)` | `on.click → e.cancelAdd` | `无提取条件` |
| `1cb9/43afaf0e` | `确定 ($lang.confirm)` | `on.click → e.copyProduct` | `无提取条件` |
| `1cb9/43afaf0e` | `取消 ($lang.cancel)` | `on.click → e.cancelCopy` | `无提取条件` |
| `1cb9/43afaf0e` | `高级` | `on.click → function(t){e.seniorFlag=!e.seniorFlag}` | `"1"==e.createType` |
| `1cb9/43afaf0e` | `添加` | `on.click → e.addCustomFields` | `"1"==e.createType; e.seniorFlag` |
| `1cb9/43afaf0e` | `添加` | `on.click → e.addCustomFields` | `"2"==e.createType` |
| `1cb9/43afaf0e` | `确定 ($lang.confirm)` | `on.click → e.editGroupSubmit` | `无提取条件` |
| `1cb9/43afaf0e` | `取消 ($lang.cancel)` | `on.click → e.groupDialogCancel` | `无提取条件` |
| `1cb9/43afaf0e` | `同步操作系统 ($lang.synchronous_operating_system)` | `on.click → e.asyncOsPost` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `43afaf0e` / `bmVerify` | `"post"` `"check_product_as"` (data) | `POST {A}/check_product_as` → `admin/product/checkAlias`；规则 `app\admin\controller\Productcontroller::checkalias`；[源行](../../data/route/admin.php#L417) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `editStockHandleClick` | `"post"` `"edit_stock"` (data) | `ANY {A}/edit_stock` → `admin/product/editStock`；规则 `app\admin\controller\Productcontroller::editstock`；[源行](../../data/route/admin.php#L427) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `getData` | `未显式指定` `"product_list_page"` (params) | `GET {A}/product_list_page` → `admin/product/getProuductlistPage`；规则 `app\admin\controller\Productcontroller::getprouductlistpage`；[源行](../../data/route/admin.php#L409) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `deleteGroup` | `未显式指定` `"del_product_first_group"` (params) | `GET {A}/del_product_first_group` → `admin/product/deleteFirstGroup`；规则 `app\admin\controller\Productcontroller::deletefirstgroup`；[源行](../../data/route/admin.php#L420) | `getData` |
| `43afaf0e` / `deleteGroup` | `未显式指定` `"del_product_group"` (params) | `GET {A}/del_product_group` → `admin/product/deleteGroup`；规则 `app\admin\controller\Productcontroller::deletegroup`；[源行](../../data/route/admin.php#L419) | `getData` |
| `43afaf0e` / `deleteProduct` | `未显式指定` `"del_product"` (params) | `GET {A}/del_product` → `admin/product/delete`；规则 `app\admin\controller\Productcontroller::delete`；[源行](../../data/route/admin.php#L418) | `getData` |
| `43afaf0e` / `showAddProduct` | `未显式指定` `"add_product_page"` (params) | `GET {A}/add_product_page` → `admin/product/addPage`；规则 `app\admin\controller\Productcontroller::addpage`；[源行](../../data/route/admin.php#L421) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `submitForm` | `"post"` `"create_product"` (data) | `POST {A}/create_product` → `admin/product/create`；规则 `app\admin\controller\Productcontroller::create`；[源行](../../data/route/admin.php#L422) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `showCopyProduct` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `copyProduct` | `"post"` `"product_duplicate"` (data) | `POST {A}/product_duplicate` → `admin/product/duplicate`；规则 `app\admin\controller\Productcontroller::duplicate`；[源行](../../data/route/admin.php#L424) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `proSortApi` | `"post"` `"update_productsort"` (data) | `POST {A}/update_productsort` → `admin/product/updateProductsort`；规则 `app\admin\controller\Productcontroller::updateproductsort`；[源行](../../data/route/admin.php#L412) | `getData` |
| `43afaf0e` / `proGroupSortApi` | `"post"` `"update_groupsort"` (data) | `POST {A}/update_groupsort` → `admin/product/updateGroupsort`；规则 `app\admin\controller\Productcontroller::updategroupsort`；[源行](../../data/route/admin.php#L411) | `getData` |
| `43afaf0e` / `firstGroupSortApi` | `"post"` `"update_firstgroupsort"` (data) | `POST {A}/update_firstgroupsort` → `admin/product/updateFirstGroupsort`；规则 `app\admin\controller\Productcontroller::updatefirstgroupsort`；[源行](../../data/route/admin.php#L410) | `getData` |
| `43afaf0e` / `getGroupDialogData` | `未显式指定` `"edit_product_group_page"` (params) | `GET {A}/edit_product_group_page` → `admin/product/editGroupPage`；规则 `app\admin\controller\Productcontroller::editgrouppage`；[源行](../../data/route/admin.php#L415) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `getGroupDialogData` | `未显式指定` `"edit_product_first_group_page"` (params) | `GET {A}/edit_product_first_group_page` → `admin/product/editFirstGroupPage`；规则 `app\admin\controller\Productcontroller::editfirstgrouppage`；[源行](../../data/route/admin.php#L413) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `editGroupSubmit` | `"post"` `"save_product_group"` (data) | `POST {A}/save_product_group` → `admin/product/saveProductGroup`；规则 `app\admin\controller\Productcontroller::saveproductgroup`；[源行](../../data/route/admin.php#L416) | `getData` |
| `43afaf0e` / `editGroupSubmit` | `"post"` `"save_product_first_group"` (data) | `POST {A}/save_product_first_group` → `admin/product/saveProductFirstGroup`；规则 `app\admin\controller\Productcontroller::saveproductfirstgroup`；[源行](../../data/route/admin.php#L414) | `getData` |
| `43afaf0e` / `getOsList` | `未显式指定` `"options/config_options_check_os"` (无显式 data/params) | `GET {A}/options/config_options_check_os` → `admin/config_options/configOptionsCheckOs`；规则 `app\admin\controller\ConfigOptionscontroller::configoptionscheckos`；[源行](../../data/route/admin.php#L258) | 未提取；新设计明确成功后重读受影响对象 |
| `43afaf0e` / `OsPostApi` | `"post"` `"options/config_options_check_os/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/edit-product",query:{id:a.id,prePage:a.type}}`
- 旧跳转：`goToEditProduct: this.$router.push({path:"/edit-product",query:{id:e.id,prePage:e.type}})`
- 旧跳转：`submitForm: e.$router.push({path:"/edit-product",query:{id:e.productId}})`
- 旧跳转：`copyProduct: e.$router.push({path:"/edit-product",query:{id:e.pid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p143"></a>

## 商品分组编辑 `/add-product-group`

旧版证据：[P143](27-admin-built-page-evidence.md#p143)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“商品分组编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9493/3a5e122a` | `el-form-item` | `分组类型 ($lang.create_a_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `一级分组 ($lang.primary_group)` / `gid` / `-` | `"1"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `商品组名称 ($lang.commodity_group_name)` / `name` / `-` | `"1"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `商品组标题 ($lang.commodity_group_title)` / `-` / `-` | `"1"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `商品组标语 ($lang.merchandise_group_slogan)` / `-` / `-` | `"1"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `订购表格模板 ($lang.order_form_template)` / `-` / `-` | `"1"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `""` / `order_frm_tpl` / `-` | `"1"===e.createType; 1===e.defaultPage` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `分组组名称 ($lang.grouping_name)` / `name` / `-` | `"2"===e.createType` | 分组表单；未知原值不置空 |
| `9493/3a5e122a` | `el-form-item` | `是否隐藏 ($lang.whether_to_hide)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9493/3a5e122a` | `保存更改 ($lang.save_the_changes)` | `on.click → e.saveSubmit` | `无提取条件` |
| `9493/3a5e122a` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `9493/3a5e122a` | `取消更改 ($lang.cancel_changes)` | `on.click → e.cancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3a5e122a` / `getData` | `未显式指定` `"edit_product_group_page"` (params) | `GET {A}/edit_product_group_page` → `admin/product/editGroupPage`；规则 `app\admin\controller\Productcontroller::editgrouppage`；[源行](../../data/route/admin.php#L415) | 未提取；新设计明确成功后重读受影响对象 |
| `3a5e122a` / `getData` | `未显式指定` `"edit_product_first_group_page"` (params) | `GET {A}/edit_product_first_group_page` → `admin/product/editFirstGroupPage`；规则 `app\admin\controller\Productcontroller::editfirstgrouppage`；[源行](../../data/route/admin.php#L413) | 未提取；新设计明确成功后重读受影响对象 |
| `3a5e122a` / `saveSubmit` | `"post"` `"save_product_group"` (data) | `POST {A}/save_product_group` → `admin/product/saveProductGroup`；规则 `app\admin\controller\Productcontroller::saveproductgroup`；[源行](../../data/route/admin.php#L416) | 未提取；新设计明确成功后重读受影响对象 |
| `3a5e122a` / `saveSubmit` | `"post"` `"save_product_first_group"` (data) | `POST {A}/save_product_first_group` → `admin/product/saveProductFirstGroup`；规则 `app\admin\controller\Productcontroller::saveproductfirstgroup`；[源行](../../data/route/admin.php#L414) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`saveSubmit: e.$router.push("/dcim-product")`
- 旧跳转：`saveSubmit: e.$router.push("/zjmfcloud-product")`
- 旧跳转：`saveSubmit: e.$router.push("/product-server")`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p144"></a>

## 商品编辑容器 `/edit-product`

旧版证据：[P144](27-admin-built-page-evidence.md#p144)；归属：chunk 内候选，页面归属待人工确认。本节是新布局草案，组件归属未冻结，不能据此进入业务实现。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：分基本信息、定价、模块、配置项等已有分区；按商品类型保留不同参数，切换类型不能静默清空旧配置。该路由归属仍为候选，不把chunk中所有组件视为主表单。

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

<a id="p145"></a>

## 全局可配置项 `/configurable-option`

旧版证据：[P145](27-admin-built-page-evidence.md#p145)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“全局可配置项”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `14c2/43189f15` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `14c2/43189f15` | `el-table-column` | `组名 ($lang.group_name1)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `14c2/43189f15` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `14c2/43189f15` | `el-table-column` | `产品 ($lang.product)` / `products` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `14c2/43189f15` | `el-table-column` | `操作 ($lang.operate)` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `14c2/43189f15` | `el-dialog` | `-` / `-` / `复制组 ($lang.copy_group)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `14c2/43189f15` | `el-form-item` | `配置项组 ($lang.configuration_item_group)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `14c2/43189f15` | `el-form-item` | `新的组名 ($lang.new_group_name)` / `newname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `14c2/43189f15` | `创建组` | `on.click → t.creatGroupHandleClick` | `无提取条件` |
| `14c2/43189f15` | `复制组 ($lang.copy_group)` | `on.click → t.duplicateGroupHandleClick` | `无提取条件` |
| `14c2/43189f15` | `图标/动态文案，回查原证据` | `on.click → t.getData` | `"dcim"!==t.$route.query.type&&"dcimcloud"!==t.$route.query.type` |
| `14c2/43189f15` | `编辑` | `on.click → function(n){return t.editGroupHandleClick(e.row.id)}` | `scopedSlots` |
| `14c2/43189f15` | `删除` | `on.click → function(n){return t.deleteGroupHandleClick(e.row.id)}` | `scopedSlots` |
| `14c2/43189f15` | `取消 ($lang.cancel)` | `on.click → function(e){t.dialogFormVisible=!1}` | `无提取条件` |
| `14c2/43189f15` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `43189f15` / `getSearchDate` | `未显式指定` `"options/search_page"` (params) | `GET {A}/options/search_page` → `admin/config_options/searchPage`；规则 `app\admin\controller\ConfigOptionscontroller::searchpage`；[源行](../../data/route/admin.php#L246) | `getData` |
| `43189f15` / `getData` | `未显式指定` `"options/groups_list"` (params) | `GET {A}/options/groups_list` → `admin/config_options/groupsList`；规则 `app\admin\controller\ConfigOptionscontroller::groupslist`；[源行](../../data/route/admin.php#L245) | 未提取；新设计明确成功后重读受影响对象 |
| `43189f15` / `duplicateGroupHandleClick` | `未显式指定` `"options/duplicate_groups"` (无显式 data/params) | `GET {A}/options/duplicate_groups` → `admin/config_options/duplicateGroups`；规则 `app\admin\controller\ConfigOptionscontroller::duplicategroups`；[源行](../../data/route/admin.php#L256) | 未提取；新设计明确成功后重读受影响对象 |
| `43189f15` / `deleteGroupHandleClick` | `未显式指定` `"options/delete_groups/"+t` (无显式 data/params) | `GET {A}/options/delete_groups/:gid` → `admin/config_options/deleteGroups`；规则 `app\admin\controller\ConfigOptionscontroller::deletegroups`；[源行](../../data/route/admin.php#L255) | `getData` |
| `43189f15` / `submitForm` | `"post"` `"options/duplicate_groups_post"` (data) | `POST {A}/options/duplicate_groups_post` → `admin/config_options/duplicateGroupsPost`；规则 `app\admin\controller\ConfigOptionscontroller::duplicategroupspost`；[源行](../../data/route/admin.php#L257) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`creatGroupHandleClick: this.$router.push({path:"/edit-configurable-option-group",query:{prePage:this.$route.query.type}})`
- 旧跳转：`editGroupHandleClick: this.$router.push({path:"/edit-configurable-option-group",query:{groupId:t,prePage:this.$route.query.type}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p146"></a>

## 配置项组编辑 `/edit-configurable-option-group`

旧版证据：[P146](27-admin-built-page-evidence.md#p146)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“配置项组编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c0e4/1796f07e` | `el-form-item` | `组名 ($lang.group_name1)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c0e4/1796f07e` | `el-form-item` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c0e4/1796f07e` | `el-form-item` | `指定产品 ($lang.designated_products)` / `p_id` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `c0e4/1796f07e` | `el-table-column` | `ID` / `id` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `分组ID` / `gid` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `配置项名称 ($lang.configuration_item_name)` / `option_name` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `配置项类型 ($lang.configuration_item_type)` / `option_type` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `排序 ($lang.sort)` / `order` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `是否隐藏 ($lang.whether_to_hide)` / `hidden` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `允许升降级 ($lang.upgrade_and_downgrade_allowed)` / `upgrade` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `应用优惠码 ($lang.application_discount_code)` / `is_discount` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c0e4/1796f07e` | `el-table-column` | `操作 ($lang.operation)` / `title` / `-` | `t.groupId` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c0e4/1796f07e` | `添加配置项 ($lang.add_configuration_item)` | `on.click → t.addOptionHandleClick` | `t.groupId` |
| `c0e4/1796f07e` | `编辑 ($lang.edit)` | `on.click → function(n){return t.editOptionHanleClick(e.row.id)}` | `t.groupId; scopedSlots` |
| `c0e4/1796f07e` | `删除 ($lang.delete)` | `on.click → function(n){return t.deleteOptionHandleClick(e.row.id)}` | `t.groupId; scopedSlots` |
| `c0e4/1796f07e` | `" "+t._s(t.groupId?t.$lang.save_the_changes:t.$lang.confirm_creation)+" "` | `on.click → t.saveChangesSubmitForm` | `无提取条件` |
| `c0e4/1796f07e` | `返回 ($lang.get_back)` | `on.click → t.backtToGroupListHandleClick` | `无提取条件` |
| `c0e4/1796f07e` | `重置 ($lang.reset)` | `on.click → t.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1796f07e` / `getProductList` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | `getEditGroupsPage` |
| `1796f07e` / `getEditGroupsPage` | `未显式指定` `"options/edit_groups/"+t+"?type="+e` (无显式 data/params) | `GET {A}/options/edit_groups/:gid` → `admin/config_options/editGroups`；规则 `app\admin\controller\ConfigOptionscontroller::editgroups`；[源行](../../data/route/admin.php#L249) | 未提取；新设计明确成功后重读受影响对象 |
| `1796f07e` / `saveChangesSubmitForm` | `"post"` `"options/create_groups_post"` (data) | `POST {A}/options/create_groups_post` → `admin/config_options/createGroupsPost`；规则 `app\admin\controller\ConfigOptionscontroller::creategroupspost`；[源行](../../data/route/admin.php#L248) | `getEditGroupsPage` |
| `1796f07e` / `saveChangesSubmitForm` | `"post"` `"options/edit_groups_post"` (data) | `POST {A}/options/edit_groups_post` → `admin/config_options/editGroupsPost`；规则 `app\admin\controller\ConfigOptionscontroller::editgroupspost`；[源行](../../data/route/admin.php#L250) | `getEditGroupsPage` |
| `1796f07e` / `deleteOptionHandleClick` | `未显式指定` `"options/delete_options/"+t` (无显式 data/params) | `GET {A}/options/delete_options/:cid` → `admin/config_options/deleteOptions`；规则 `app\admin\controller\ConfigOptionscontroller::deleteoptions`；[源行](../../data/route/admin.php#L254) | `getEditGroupsPage` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`saveChangesSubmitForm: t.$router.replace({path:"/edit-configurable-option-group",query:{groupId:o.groupid,prePage:t.prePage}})`
- 旧跳转：`backtToGroupListHandleClick: this.$router.push({path:"/configurable-option",query:{type:this.prePage}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p147"></a>

## 服务器配置 `/server-settings`

旧版证据：[P147](27-admin-built-page-evidence.md#p147)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“服务器配置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `376e/5ff5e4e7` | `el-tab-pane` | `接口 ($lang.interface)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `376e/5ff5e4e7` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `接口名称 ($lang.interface_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `服务器模块 ($lang.server_module)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `接口分组名 ($lang.interface_group_name)` / `gname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ip_address` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `-` / `open_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `状态 ($lang.state)` / `disabled` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-tab-pane` | `接口分组名 ($lang.interface_group_name)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `376e/5ff5e4e7` | `el-table-column` | `分组组名称 ($lang.grouping_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `-` / `open_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `分配方式 ($lang.allocation)` / `mode` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `376e/5ff5e4e7` | `el-table-column` | `操作 ($lang.operation)` / `disabled` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `376e/5ff5e4e7` | `创建接口 ($lang.create_the_interface)` | `on.click → t.toInterface` | `无提取条件` |
| `376e/5ff5e4e7` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.getInterface()}` | `无提取条件` |
| `376e/5ff5e4e7` | `编辑 ($lang.edit)` | `on.click → function(e){return t.toEditInterface(a)}` | `scopedSlots` |
| `376e/5ff5e4e7` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteServer(a)}` | `scopedSlots` |
| `376e/5ff5e4e7` | `创建分组 ($lang.create_group)` | `on.click → t.addGroup` | `无提取条件` |
| `376e/5ff5e4e7` | `编辑 ($lang.edit)` | `on.click → function(e){return t.toGroupEdit(a)}` | `scopedSlots` |
| `376e/5ff5e4e7` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteServerGroup(a)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5ff5e4e7` / `deleteServerGroup` | `未显式指定` `"delete_server_groups/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getInterfaceGroup` |
| `5ff5e4e7` / `getSingleStatus` | `未显式指定` `"server_test_link/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5ff5e4e7` / `deleteServer` | `未显式指定` `"delete_servers/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getInterface` |
| `5ff5e4e7` / `getInterface` | `未显式指定` `"servers_list"` (params) | `GET {A}/servers_list` → `admin/config_servers/serverList`；规则 `app\admin\controller\ConfigServerscontroller::serverlist`；[源行](../../data/route/admin.php#L231)<br>`GET {A}/servers_list` → `admin/config_servers/serversList`；规则 `app\admin\controller\ConfigServerscontroller::serverslist`；[源行](../../data/route/admin.php#L407)<br>`GET {A}/servers_list` → `admin/config_servers/serversList`；规则 `app\admin\controller\ConfigServerscontroller::serverslist`；[源行](../../data/route/admin.php#L408) | `getAllStatus` |
| `5ff5e4e7` / `getInterfaceGroup` | `未显式指定` `"groups_list"` (params) | `GET {A}/groups_list` → `admin/config_servers/groupsList`；规则 `app\admin\controller\ConfigServerscontroller::groupslist`；[源行](../../data/route/admin.php#L232) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toEditInterface: this.$router.push({path:"/add-interface",query:{id:t.id,type:"edit"}})`
- 旧跳转：`toInterface: this.$router.push({path:"/add-interface",query:{type:"add"}})`
- 旧跳转：`toGroupEdit: this.$router.push({path:"/add-group",query:{id:t.id,type:"edit"}})`
- 旧跳转：`addGroup: this.$router.push({path:"/add-group",query:{type:"add"}})`
- 旧跳转：`toGroupList: this.$router.push({path:"/group-list",query:{id:t.id,name:t.name}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p148"></a>

## 服务器编辑 `/add-server`

旧版证据：[P148](27-admin-built-page-evidence.md#p148)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“服务器编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `1f7a/3d5cd214` | `el-form-item` | `姓名 ($lang.name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `IP地址 ($lang.ip_address)` / `ip_address` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `主机名 ($lang.host_name)` / `hostname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `接口 ($lang.interface)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `端口 ($lang.port)` / `port` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `SSL` / `secure` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `启用/禁用 ($lang.enable_disable)` / `disabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1f7a/3d5cd214` | `el-form-item` | `Hash` / `accesshash` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `1f7a/3d5cd214` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `1f7a/3d5cd214` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `1f7a/3d5cd214` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3d5cd214` / `getDetail` | `"get"` `"edit_servers/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3d5cd214` / `addServerInit` | `未显式指定` `"servers_add"` (无显式 data/params) | `GET {A}/servers_add` → `admin/config_servers/addServers`；规则 `app\admin\controller\ConfigServerscontroller::addservers`；[源行](../../data/route/admin.php#L233) | 未提取；新设计明确成功后重读受影响对象 |
| `3d5cd214` / `submitForm` | `"post"` `"edit_servers_post"` (data) | `POST {A}/edit_servers_post` → `admin/config_servers/editServersPost`；规则 `app\admin\controller\ConfigServerscontroller::editserverspost`；[源行](../../data/route/admin.php#L236) | 未提取；新设计明确成功后重读受影响对象 |
| `3d5cd214` / `submitForm` | `"post"` `"servers_add_post"` (data) | `POST {A}/servers_add_post` → `admin/config_servers/addServersPost`；规则 `app\admin\controller\ConfigServerscontroller::addserverspost`；[源行](../../data/route/admin.php#L234) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.go(-1)`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p149"></a>

## 服务器分组 `/group-list`

旧版证据：[P149](27-admin-built-page-evidence.md#p149)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“服务器分组”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0057/3086faad` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `接口名称 ($lang.interface_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `服务器模块 ($lang.server_module)` / `type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `接口分组名 ($lang.interface_group_name)` / `gname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `IP地址 ($lang.ip_address)` / `ip_address` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `-` / `open_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `状态 ($lang.state)` / `disabled` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0057/3086faad` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0057/3086faad` | `编辑 ($lang.edit)` | `on.click → function(e){return t.toEdit(a)}` | `scopedSlots` |
| `0057/3086faad` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteServer(a)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `3086faad` / `getInterface` | `未显式指定` `"servers_list"` (params) | `GET {A}/servers_list` → `admin/config_servers/serverList`；规则 `app\admin\controller\ConfigServerscontroller::serverlist`；[源行](../../data/route/admin.php#L231)<br>`GET {A}/servers_list` → `admin/config_servers/serversList`；规则 `app\admin\controller\ConfigServerscontroller::serverslist`；[源行](../../data/route/admin.php#L407)<br>`GET {A}/servers_list` → `admin/config_servers/serversList`；规则 `app\admin\controller\ConfigServerscontroller::serverslist`；[源行](../../data/route/admin.php#L408) | `getAllStatus` |
| `3086faad` / `getSingleStatus` | `未显式指定` `"server_test_link/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `3086faad` / `deleteServer` | `未显式指定` `"delete_servers/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getInterface` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toEdit: this.$router.push({path:"/add-interface",query:{id:t.id,type:"edit"}})`
- 旧跳转：`back: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p150"></a>

## 服务器分组编辑 `/add-group`

旧版证据：[P150](27-admin-built-page-evidence.md#p150)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“服务器分组编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0108/2bd0d438` | `el-form-item` | `接口分组名 ($lang.interface_group_name)` / `group_name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0108/2bd0d438` | `el-form-item` | `分配方式 ($lang.allocation)` / `mode` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0108/2bd0d438` | `el-form-item` | `选择空闲接口 ($lang.select_idle_interface)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0108/2bd0d438` | `提交 ($lang.submit)` | `on.click → e.submit` | `无提取条件` |
| `0108/2bd0d438` | `返回 ($lang.get_back)` | `on.click → e.back` | `无提取条件` |
| `0108/2bd0d438` | `重置 ($lang.reset)` | `on.click → e.reset` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2bd0d438` / `getCreateGroups` | `未显式指定` `"create_groups"` (无显式 data/params) | `GET {A}/create_groups` → `admin/config_servers/createGroups`；规则 `app\admin\controller\ConfigServerscontroller::creategroups`；[源行](../../data/route/admin.php#L238) | 未提取；新设计明确成功后重读受影响对象 |
| `2bd0d438` / `getData` | `未显式指定` `"edit_server_groups/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getCreateGroups` |
| `2bd0d438` / `submit` | `"post"` `"create_groups_post"` (data) | `POST {A}/create_groups_post` → `admin/config_servers/createGroupsPost`；规则 `app\admin\controller\ConfigServerscontroller::creategroupspost`；[源行](../../data/route/admin.php#L239) | `back` |
| `2bd0d438` / `submit` | `"post"` `"edit_server_groups_post"` (data) | `POST {A}/edit_server_groups_post` → `admin/config_servers/editServerGroupsPost`；规则 `app\admin\controller\ConfigServerscontroller::editservergroupspost`；[源行](../../data/route/admin.php#L241) | `back` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: e.$router.back()`
- 旧跳转：`back: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p151"></a>

## 接口添加 `/add-interface`

旧版证据：[P151](27-admin-built-page-evidence.md#p151)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“接口添加”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `67a5/8a93e366` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `IP地址 ($lang.ip_address)` / `ip_address` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `服务器模块 ($lang.server_module)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `-` / `max_accounts` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `主机名 ($lang.host_name)` / `hostname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `接口分组名 ($lang.interface_group_name)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `端口 ($lang.port)` / `port` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `secure` / `ssl` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `启用/禁用 ($lang.enable_disable)` / `disabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `67a5/8a93e366` | `el-form-item` | `Hash` / `accesshash` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `67a5/8a93e366` | `获取更多模块支持 ($lang.moreInterface6)` | `on.click → e.jumpUrl` | `无提取条件` |
| `67a5/8a93e366` | `提交 ($lang.submit)` | `on.click → e.submit` | `无提取条件` |
| `67a5/8a93e366` | `返回 ($lang.get_back)` | `on.click → e.back` | `无提取条件` |
| `67a5/8a93e366` | `重置 ($lang.reset)` | `on.click → e.reset` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `8a93e366` / `changeType` | `"post"` `"get_modules_group"` (data) | `POST {A}/get_modules_group` → `admin/config_servers/getModulesGroup`；规则 `app\admin\controller\ConfigServerscontroller::getmodulesgroup`；[源行](../../data/route/admin.php#L244) | 未提取；新设计明确成功后重读受影响对象 |
| `8a93e366` / `addServerInit` | `未显式指定` `"servers_add"` (无显式 data/params) | `GET {A}/servers_add` → `admin/config_servers/addServers`；规则 `app\admin\controller\ConfigServerscontroller::addservers`；[源行](../../data/route/admin.php#L233) | 未提取；新设计明确成功后重读受影响对象 |
| `8a93e366` / `getData` | `"get"` `"edit_servers/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `changeType`、`addServerInit` |
| `8a93e366` / `submit` | `"post"` `"servers_add_post"` (data) | `POST {A}/servers_add_post` → `admin/config_servers/addServersPost`；规则 `app\admin\controller\ConfigServerscontroller::addserverspost`；[源行](../../data/route/admin.php#L234) | `back` |
| `8a93e366` / `submit` | `"post"` `"edit_servers_post"` (data) | `POST {A}/edit_servers_post` → `admin/config_servers/editServersPost`；规则 `app\admin\controller\ConfigServerscontroller::editserverspost`；[源行](../../data/route/admin.php#L236) | `back` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: e.$router.back()`
- 旧跳转：`back: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p152"></a>

## DCIM 接口 `/dcim`

旧版证据：[P152](27-admin-built-page-evidence.md#p152)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“DCIM 接口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2229/12eafac9` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `-` / `api_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `连接成功 ($lang.connection_succeed)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `IP` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `服务器数量 ($lang.number_of_servers)` / `server_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `区域 ($lang.area)` / `area` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2229/12eafac9` | `el-dialog` | `-` / `-` / `新增接口 ($lang.the_new_interface)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `2229/12eafac9` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `地址 ($lang.address)` / `hostname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `API用户名 ($lang.api_user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `APIKEY` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `端口 ($lang.port)` / `port` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `财务标识 ($lang.financial_mark)` / `user_prefix` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-form-item` | `是否禁用 ($lang.whether_to_disable)` / `disabled` / `-` | `e.$hiddenFunc` | 分组表单；未知原值不置空 |
| `2229/12eafac9` | `el-switch` | `-` / `-` / `-` | `e.$hiddenFunc` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2229/12eafac9` | `新增接口 ($lang.the_new_interface)` | `on.click → function(t){e.addDialogVisible=!0}` | `无提取条件` |
| `2229/12eafac9` | `图标/动态文案，回查原证据` | `on.click → e.searchData` | `无提取条件` |
| `2229/12eafac9` | `r.name` | `on.click → function(t){return e.goToView(r.id)}` | `scopedSlots` |
| `2229/12eafac9` | `编辑` | `on.click → function(t){return e.goToView(r.id)}` | `scopedSlots` |
| `2229/12eafac9` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteServer(r.id)}` | `scopedSlots` |
| `2229/12eafac9` | `取消 ($lang.cancel)` | `on.click → e.handelCancel` | `无提取条件` |
| `2229/12eafac9` | `确定 ($lang.confirm)` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `12eafac9` / `getData` | `未显式指定` `"dcim/server"` (params) | `POST {A}/dcim/server` → `admin/dcim/addServer`；规则 `app\admin\controller\Dcimcontroller::addserver`；[源行](../../data/route/admin.php#L645)<br>`PUT {A}/dcim/server` → `admin/dcim/editServer`；规则 `app\admin\controller\Dcimcontroller::editserver`；[源行](../../data/route/admin.php#L646)<br>`DELETE {A}/dcim/server` → `admin/dcim/delServer`；规则 `app\admin\controller\Dcimcontroller::delserver`；[源行](../../data/route/admin.php#L648)<br>`GET {A}/dcim/server` → `admin/dcim/serverList`；规则 `app\admin\controller\Dcimcontroller::serverlist`；[源行](../../data/route/admin.php#L649) | 未提取；新设计明确成功后重读受影响对象 |
| `12eafac9` / `handelConfirm` | `"post"` `"dcim/server"` (data) | `POST {A}/dcim/server` → `admin/dcim/addServer`；规则 `app\admin\controller\Dcimcontroller::addserver`；[源行](../../data/route/admin.php#L645) | `getData` |
| `12eafac9` / `deleteServer` | `"delete"` `"dcim/server"` (data) | `DELETE {A}/dcim/server` → `admin/dcim/delServer`；规则 `app\admin\controller\Dcimcontroller::delserver`；[源行](../../data/route/admin.php#L648) | `getData` |
| `12eafac9` / `getSingleStatus` | `未显式指定` `"dcim/server/".concat(e,"/status")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: "/dcim-view?id="+r.id`
- 旧跳转：`goToView: this.$router.push({path:"/dcim-view",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p153"></a>

## DCIM 详情 `/dcim-view`

旧版证据：[P153](27-admin-built-page-evidence.md#p153)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“DCIM 详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5fbe/67fde272` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `地址 ($lang.address)` / `hostname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `KEY` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `端口 ($lang.port)` / `port` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `财务标识 ($lang.financial_mark)` / `user_prefix` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `区域名称 ($lang.area_name)` / `reinstall_times` / `-` | `e.areaArr.length; 循环 e.areaArr` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `重装是否收费 ($lang.whether_to_charge_for_reloading)` / `buy_times` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `免费重装次数 ($lang.number_of_free_reloads)` / `reinstall_times` / `-` | `e.editServerFormData.buy_times` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `超出后重装单价 ($lang.after_exceeding_the_unit_price_of_reloading)` / `reinstall_price` / `-` | `e.editServerFormData.buy_times` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台流量图 ($lang.foreground_flow_chart)` / `traffic` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台kvm ($lang.front_desk_kvm)` / `kvm` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台ikvm ($lang.front_desk_ikvm)` / `ikvm` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台重置BMC ($lang.the_front_desk_to_reset_bmc)` / `bmc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台重装系统 ($lang.front_desk_reinstall_system)` / `reinstall` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台重启 ($lang.the_front_desk_to_restart)` / `reboot` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台开机 ($lang.the_front_desk_boot)` / `on` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台关机 ($lang.the_front_desk_to_turn_it_off)` / `off` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `是否开启novnc ($lang.whether_open_novnc)` / `novnc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台救援系统 ($lang.front_desk_rescue_system)` / `rescue` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `前台破解密码 ($lang.reception_cracked_the_password)` / `crack_pass` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `IP附加信息显示 ($lang.ip_display_of_additional_information)` / `enable_ip_custom` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `IP自定义字段ID ($lang.ip_custom_field_id)` / `ip_customid` / `-` | `"on"===e.editServerFormData.enable_ip_custom` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `开机 ($lang.starting_up)` / `is_certifi.on` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `关机 ($lang.shutdown)` / `is_certifi.off` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `重启 ($lang.restart)` / `is_certifi.reboot` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `重装系统 ($lang.reinstall_the_system)` / `is_certifi.reinstall` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `破解密码 ($lang.cracking_password)` / `is_certifi.crack_pass` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `救援系统 ($lang.rescue_system)` / `is_certifi.rescue` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `重置BMC ($lang.reset_BMC)` / `is_certifi.bmc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `novnc` / `is_certifi.novnc` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `kvm` / `is_certifi.kvm` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-form-item` | `ikvm` / `is_certifi.ikvm` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `5fbe/67fde272` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5fbe/67fde272` | `图标/动态文案，回查原证据` | `on.change → e.buyTimesChange` | `无提取条件` |
| `5fbe/67fde272` | `保存更改 ($lang.save_the_changes)` | `on.click → e.editServer` | `无提取条件` |
| `5fbe/67fde272` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `5fbe/67fde272` | `取消更改 ($lang.cancel_changes)` | `on.click → e.editCancel` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `67fde272` / `getData` | `未显式指定` `"dcim/server/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `67fde272` / `editServer` | `"put"` `"dcim/server"` (data) | `PUT {A}/dcim/server` → `admin/dcim/editServer`；规则 `app\admin\controller\Dcimcontroller::editserver`；[源行](../../data/route/admin.php#L646) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`editServer: e.$router.push("/dcim")`
- 旧跳转：`goBack: this.$router.push("/dcim")`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p154"></a>

## DCIM 流量 `/dcim-traffic`

旧版证据：[P154](27-admin-built-page-evidence.md#p154)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：围绕“DCIM 流量”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `8e8d/0298b91a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `流量包名称 ($lang.data_package_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `流量（GB） ($lang.flux_gb)` / `capacity` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `价格 ($lang.price)` / `price` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `启用 ($lang.start_using)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-switch` | `-` / `-` / `-` | `scopedSlots` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-table-column` | `已售/库存 ($lang.sold_stocked)` / `sale_times` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `创建时间 ($lang.create_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-table-column` | `管理 ($lang.management)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `8e8d/0298b91a` | `el-dialog` | `-` / `-` / `新增流量包 ($lang.add_data_package)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8e8d/0298b91a` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `流量包大小 ($lang.flow_packet_size)` / `capacity` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `价格 ($lang.price)` / `price` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `库存 ($lang.inventory)` / `stock` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `可绑定的产品 ($lang.bindable_products)` / `allow_products` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-dialog` | `-` / `-` / `编辑流量包 ($lang.edit_data_package)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `8e8d/0298b91a` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `流量包大小 ($lang.flow_packet_size)` / `capacity` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `价格 ($lang.price)` / `price` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `库存 ($lang.inventory)` / `stock` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `8e8d/0298b91a` | `el-form-item` | `可绑定的产品 ($lang.bindable_products)` / `allow_products` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `8e8d/0298b91a` | `新增流量包 ($lang.add_data_package)` | `on.click → e.showDialog` | `无提取条件` |
| `8e8d/0298b91a` | `图标/动态文案，回查原证据` | `on.click → e.searchData` | `无提取条件` |
| `8e8d/0298b91a` | `图标/动态文案，回查原证据` | `on.change → function(t){return e.changeSataus(t,r.id)}` | `scopedSlots` |
| `8e8d/0298b91a` | `编辑 ($lang.edit)` | `on.click → function(t){return e.showEditDialog(r.id)}` | `scopedSlots` |
| `8e8d/0298b91a` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteTraffic(r.id)}` | `scopedSlots` |
| `8e8d/0298b91a` | `取消更改 ($lang.cancel_changes)` | `on.click → e.addCancel` | `无提取条件` |
| `8e8d/0298b91a` | `保存更改 ($lang.save_the_changes)` | `on.click → e.addTraffic` | `无提取条件` |
| `8e8d/0298b91a` | `取消更改 ($lang.cancel_changes)` | `on.click → e.editCancel` | `无提取条件` |
| `8e8d/0298b91a` | `保存更改 ($lang.save_the_changes)` | `on.click → e.editTraffic` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0298b91a` / `getData` | `未显式指定` `"dcim/flowpacket"` (params) | `POST {A}/dcim/flowpacket` → `admin/dcim/addFlowPacket`；规则 `app\admin\controller\Dcimcontroller::addflowpacket`；[源行](../../data/route/admin.php#L637)<br>`PUT {A}/dcim/flowpacket` → `admin/dcim/editFlowPacket`；规则 `app\admin\controller\Dcimcontroller::editflowpacket`；[源行](../../data/route/admin.php#L638)<br>`DELETE {A}/dcim/flowpacket` → `admin/dcim/delFlowPacket`；规则 `app\admin\controller\Dcimcontroller::delflowpacket`；[源行](../../data/route/admin.php#L639)<br>`GET {A}/dcim/flowpacket` → `admin/dcim/listFlowPacket`；规则 `app\admin\controller\Dcimcontroller::listflowpacket`；[源行](../../data/route/admin.php#L640) | 未提取；新设计明确成功后重读受影响对象 |
| `0298b91a` / `changeSataus` | `"put"` `"dcim/flowpacket"` (data) | `PUT {A}/dcim/flowpacket` → `admin/dcim/editFlowPacket`；规则 `app\admin\controller\Dcimcontroller::editflowpacket`；[源行](../../data/route/admin.php#L638) | `getData` |
| `0298b91a` / `showDialog` | `未显式指定` `"dcim/flowpacket_page"` (无显式 data/params) | `GET {A}/dcim/flowpacket_page` → `admin/dcim/addFlowPacketPage`；规则 `app\admin\controller\Dcimcontroller::addflowpacketpage`；[源行](../../data/route/admin.php#L641) | 未提取；新设计明确成功后重读受影响对象 |
| `0298b91a` / `addTraffic` | `"post"` `"dcim/flowpacket"` (data) | `POST {A}/dcim/flowpacket` → `admin/dcim/addFlowPacket`；规则 `app\admin\controller\Dcimcontroller::addflowpacket`；[源行](../../data/route/admin.php#L637) | `getData` |
| `0298b91a` / `deleteTraffic` | `"delete"` `"dcim/flowpacket"` (data) | `DELETE {A}/dcim/flowpacket` → `admin/dcim/delFlowPacket`；规则 `app\admin\controller\Dcimcontroller::delflowpacket`；[源行](../../data/route/admin.php#L639) | `getData` |
| `0298b91a` / `showEditDialog` | `未显式指定` `"dcim/flowpacket_page/".concat(e)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `0298b91a` / `editTraffic` | `"put"` `"dcim/flowpacket"` (data) | `PUT {A}/dcim/flowpacket` → `admin/dcim/editFlowPacket`；规则 `app\admin\controller\Dcimcontroller::editflowpacket`；[源行](../../data/route/admin.php#L638) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p155"></a>

## DCIM 流量日志 `/dcim-traffic-log`

旧版证据：[P155](27-admin-built-page-evidence.md#p155)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“DCIM 流量日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `71f4/394e4117` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `产品 ($lang.product)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `时间 ($lang.time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `金额 ($lang.sum)` / `price` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `付款状态 ($lang.payment_status)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `支付方式 ($lang.payment_mode)` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `71f4/394e4117` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `71f4/394e4117` | `帮助文档 ($lang.help_document)` | `on.click → e.openDoc` | `无提取条件` |
| `71f4/394e4117` | `图标/动态文案，回查原证据` | `on.click → e.searchData` | `无提取条件` |
| `71f4/394e4117` | `删除` | `on.click → function(t){return e.deleteLog(n.id)}` | `scopedSlots; n.removable` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `394e4117` / `getData` | `未显式指定` `"dcim/buy_record"` (params) | `GET {A}/dcim/buy_record` → `admin/dcim/listBuyRecord`；规则 `app\admin\controller\Dcimcontroller::listbuyrecord`；[源行](../../data/route/admin.php#L643)<br>`DELETE {A}/dcim/buy_record` → `admin/dcim/delRecord`；规则 `app\admin\controller\Dcimcontroller::delrecord`；[源行](../../data/route/admin.php#L644) | 未提取；新设计明确成功后重读受影响对象 |
| `394e4117` / `deleteLog` | `"delete"` `"dcim/buy_record"` (data) | `DELETE {A}/dcim/buy_record` → `admin/dcim/delRecord`；规则 `app\admin\controller\Dcimcontroller::delrecord`；[源行](../../data/route/admin.php#L644) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p156"></a>

## DCIM 商品 `/dcim-product`

旧版证据：[P156](27-admin-built-page-evidence.md#p156)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“DCIM 商品”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9897/4c07c5a1` | `el-table-column` | `商品名称 ($lang.commodity_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `类型 ($lang.type)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `定价 ($lang.pricing)` / `pay_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `库存 ($lang.inventory)` / `qty` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `已开通/总数量 ($lang.available_total_quantity)` / `count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `自动开通 ($lang.automatic_opening)` / `auto_setup` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9897/4c07c5a1` | `el-dialog` | `-` / `-` / `添加商品 ($lang.add_commodity)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9897/4c07c5a1` | `el-form-item` | `商品名称 ($lang.commodity_name)` / `productname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9897/4c07c5a1` | `el-form-item` | `商品类型 ($lang.commodity_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9897/4c07c5a1` | `el-form-item` | `商品组 ($lang.commodity_group)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9897/4c07c5a1` | `el-dialog` | `-` / `-` / `复制商品 ($lang.copy_goods)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `9897/4c07c5a1` | `el-form-item` | `现有的商品 ($lang.available_goods)` / `existingproduct` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `9897/4c07c5a1` | `el-form-item` | `新商品名称 ($lang.new_product_name)` / `newproductname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9897/4c07c5a1` | `新增分组 ($lang.the_new_grouping)` | `on.click → t.goToAddGroup` | `无提取条件` |
| `9897/4c07c5a1` | `新增商品 ($lang.the_new_goods)` | `on.click → t.showAddProduct` | `无提取条件` |
| `9897/4c07c5a1` | `复制商品 ($lang.copy_goods)` | `on.click → t.showCopyProduct` | `无提取条件` |
| `9897/4c07c5a1` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.editGroup(n.id)}` | `scopedSlots; n.products` |
| `9897/4c07c5a1` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.deleteGroup(n.id)}` | `scopedSlots; n.products&&!n.products.length` |
| `9897/4c07c5a1` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.goToEditProduct(n.id)}` | `scopedSlots; else(n.products)` |
| `9897/4c07c5a1` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.deleteProduct(n.id)}` | `scopedSlots; else(n.products)` |
| `9897/4c07c5a1` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |
| `9897/4c07c5a1` | `取消 ($lang.cancel)` | `on.click → t.cancelAdd` | `无提取条件` |
| `9897/4c07c5a1` | `确定 ($lang.confirm)` | `on.click → t.copyProduct` | `无提取条件` |
| `9897/4c07c5a1` | `取消 ($lang.cancel)` | `on.click → t.cancelCopy` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `4c07c5a1` / `getData` | `未显式指定` `"product_list_page"` (params) | `GET {A}/product_list_page` → `admin/product/getProuductlistPage`；规则 `app\admin\controller\Productcontroller::getprouductlistpage`；[源行](../../data/route/admin.php#L409) | 未提取；新设计明确成功后重读受影响对象 |
| `4c07c5a1` / `deleteProduct` | `未显式指定` `"del_product"` (params) | `GET {A}/del_product` → `admin/product/delete`；规则 `app\admin\controller\Productcontroller::delete`；[源行](../../data/route/admin.php#L418) | `getData` |
| `4c07c5a1` / `deleteGroup` | `未显式指定` `"del_product_group"` (params) | `GET {A}/del_product_group` → `admin/product/deleteGroup`；规则 `app\admin\controller\Productcontroller::deletegroup`；[源行](../../data/route/admin.php#L419) | `getData` |
| `4c07c5a1` / `showAddProduct` | `未显式指定` `"add_product_page"` (params) | `GET {A}/add_product_page` → `admin/product/addPage`；规则 `app\admin\controller\Productcontroller::addpage`；[源行](../../data/route/admin.php#L421) | 未提取；新设计明确成功后重读受影响对象 |
| `4c07c5a1` / `submitForm` | `"post"` `"create_product"` (data) | `POST {A}/create_product` → `admin/product/create`；规则 `app\admin\controller\Productcontroller::create`；[源行](../../data/route/admin.php#L422) | 未提取；新设计明确成功后重读受影响对象 |
| `4c07c5a1` / `showCopyProduct` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |
| `4c07c5a1` / `copyProduct` | `"post"` `"product_duplicate"` (data) | `POST {A}/product_duplicate` → `admin/product/duplicate`；规则 `app\admin\controller\Productcontroller::duplicate`；[源行](../../data/route/admin.php#L424) | 未提取；新设计明确成功后重读受影响对象 |
| `4c07c5a1` / `rowDrag` | `"post"` `"update_productsort"` (data) | `POST {A}/update_productsort` → `admin/product/updateProductsort`；规则 `app\admin\controller\Productcontroller::updateproductsort`；[源行](../../data/route/admin.php#L412) | `getData` |
| `4c07c5a1` / `rowDrag` | `"post"` `"update_groupsort"` (data) | `POST {A}/update_groupsort` → `admin/product/updateGroupsort`；规则 `app\admin\controller\Productcontroller::updategroupsort`；[源行](../../data/route/admin.php#L411) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goToEditProduct: this.$router.push({path:"/edit-product",query:{id:t,prePage:"dcim"}})`
- 旧跳转：`editGroup: this.$router.push({path:"/add-product-group",query:{id:t,prePage:"dcim"}})`
- 旧跳转：`goToAddGroup: this.$router.push({path:"/add-product-group",query:{prePage:"dcim"}})`
- 旧跳转：`submitForm: t.$router.push({path:"/edit-product",query:{id:t.productId}})`
- 旧跳转：`copyProduct: t.$router.push({path:"/edit-product",query:{id:t.pid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p157"></a>

## 魔方云接口 `/zjmfcloud`

旧版证据：[P157](27-admin-built-page-evidence.md#p157)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“魔方云接口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f01c/04a66c5c` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-table-column` | `-` / `api_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-table-column` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-table-column` | `IP` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-table-column` | `服务器数量 ($lang.number_of_servers)` / `server_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `f01c/04a66c5c` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `f01c/04a66c5c` | `el-form-item` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `地址 ($lang.address)` / `hostname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `账号类型 ($lang.account_type)` / `account_type` / `-` | `1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `账号 ($lang.account_number)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `财务标识 ($lang.financial_mark)` / `user_prefix` / `-` | `1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `是否https ($lang.whether_https)` / `secure` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `重装是否收费 ($lang.whether_to_charge_for_reloading)` / `buy_times` / `-` | `1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-switch` | `-` / `-` / `-` | `1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `免费重装次数 ($lang.number_of_free_reloads)` / `reinstall_times` / `-` | `e.addServerFormData.buy_times&&1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `超出后重装单价 ($lang.after_exceeding_the_unit_price_of_reloading)` / `reinstall_price` / `-` | `e.addServerFormData.buy_times&&1==e.senior` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-form-item` | `是否启用 ($lang.whether_to_enable)` / `disabled` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f01c/04a66c5c` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `f01c/04a66c5c` | `新增接口 ($lang.the_new_interface)` | `on.click → e.clickAddShow` | `无提取条件` |
| `f01c/04a66c5c` | `图标/动态文案，回查原证据` | `on.click → e.searchData` | `无提取条件` |
| `f01c/04a66c5c` | `编辑` | `on.click → function(t){return e.clickUpdateShow(r)}` | `scopedSlots` |
| `f01c/04a66c5c` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteServer(r.id)}` | `scopedSlots` |
| `f01c/04a66c5c` | `图标/动态文案，回查原证据` | `on.change → e.buyTimesChange` | `1==e.senior` |
| `f01c/04a66c5c` | `取消 ($lang.cancel)` | `on.click → e.handelCancel` | `无提取条件` |
| `f01c/04a66c5c` | `确定 ($lang.confirm)` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `04a66c5c` / `getData` | `未显式指定` `"dcimcloud/server"` (params) | `POST {A}/dcimcloud/server` → `admin/dcimCloud/addServer`；规则 `app\admin\controller\DcimCloudcontroller::addserver`；[源行](../../data/route/admin.php#L713)<br>`PUT {A}/dcimcloud/server` → `admin/dcimCloud/editServer`；规则 `app\admin\controller\DcimCloudcontroller::editserver`；[源行](../../data/route/admin.php#L714)<br>`DELETE {A}/dcimcloud/server` → `admin/dcimCloud/delServer`；规则 `app\admin\controller\DcimCloudcontroller::delserver`；[源行](../../data/route/admin.php#L716)<br>`GET {A}/dcimcloud/server` → `admin/dcimCloud/serverList`；规则 `app\admin\controller\DcimCloudcontroller::serverlist`；[源行](../../data/route/admin.php#L717) | 未提取；新设计明确成功后重读受影响对象 |
| `04a66c5c` / `handelConfirm` | `"put"` `"dcimcloud/server"` (data) | `PUT {A}/dcimcloud/server` → `admin/dcimCloud/editServer`；规则 `app\admin\controller\DcimCloudcontroller::editserver`；[源行](../../data/route/admin.php#L714) | `getData` |
| `04a66c5c` / `handelConfirm` | `"post"` `"dcimcloud/server"` (data) | `POST {A}/dcimcloud/server` → `admin/dcimCloud/addServer`；规则 `app\admin\controller\DcimCloudcontroller::addserver`；[源行](../../data/route/admin.php#L713) | `getData` |
| `04a66c5c` / `deleteServer` | `"delete"` `"dcimcloud/server"` (data) | `DELETE {A}/dcimcloud/server` → `admin/dcimCloud/delServer`；规则 `app\admin\controller\DcimCloudcontroller::delserver`；[源行](../../data/route/admin.php#L716) | `getData` |
| `04a66c5c` / `getSingleStatus` | `未显式指定` `"dcimcloud/server/".concat(e,"/status")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goToView: this.$router.push({path:"/dcim-view",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p158"></a>

## 魔方云商品 `/zjmfcloud-product`

旧版证据：[P158](27-admin-built-page-evidence.md#p158)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“魔方云商品”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `916f/37c1e0e8` | `el-table-column` | `商品名称 ($lang.commodity_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `类型 ($lang.type)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `定价 ($lang.pricing)` / `pay_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `库存 ($lang.inventory)` / `qty` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `已开通/总数量 ($lang.available_total_quantity)` / `count` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `自动开通 ($lang.automatic_opening)` / `auto_setup` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `916f/37c1e0e8` | `el-dialog` | `-` / `-` / `添加商品 ($lang.add_commodity)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `916f/37c1e0e8` | `el-form-item` | `商品名称 ($lang.commodity_name)` / `productname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `916f/37c1e0e8` | `el-form-item` | `商品类型 ($lang.commodity_type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `916f/37c1e0e8` | `el-form-item` | `商品分组 ($lang.commodity_grouping)` / `gid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `916f/37c1e0e8` | `el-dialog` | `-` / `-` / `复制商品 ($lang.copy_goods)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `916f/37c1e0e8` | `el-form-item` | `现有的商品 ($lang.available_goods)` / `existingproduct` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `916f/37c1e0e8` | `el-form-item` | `新商品名称 ($lang.new_product_name)` / `newproductname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `916f/37c1e0e8` | `新增分组 ($lang.the_new_grouping)` | `on.click → t.goToAddGroup` | `无提取条件` |
| `916f/37c1e0e8` | `新增商品 ($lang.the_new_goods)` | `on.click → t.showAddProduct` | `无提取条件` |
| `916f/37c1e0e8` | `复制商品 ($lang.copy_goods)` | `on.click → t.showCopyProduct` | `无提取条件` |
| `916f/37c1e0e8` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.editGroup(r.id)}` | `scopedSlots; r.products` |
| `916f/37c1e0e8` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.deleteGroup(r.id)}` | `scopedSlots; r.products&&!r.products.length` |
| `916f/37c1e0e8` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.goToEditProduct(r.id)}` | `scopedSlots; else(r.products)` |
| `916f/37c1e0e8` | `图标/动态文案，回查原证据` | `on.click → function(e){return t.deleteProduct(r.id)}` | `scopedSlots; else(r.products)` |
| `916f/37c1e0e8` | `确定 ($lang.confirm)` | `on.click → t.submitForm` | `无提取条件` |
| `916f/37c1e0e8` | `取消 ($lang.cancel)` | `on.click → t.cancelAdd` | `无提取条件` |
| `916f/37c1e0e8` | `确定 ($lang.confirm)` | `on.click → t.copyProduct` | `无提取条件` |
| `916f/37c1e0e8` | `取消 ($lang.cancel)` | `on.click → t.cancelCopy` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `37c1e0e8` / `getData` | `未显式指定` `"product_list_page"` (params) | `GET {A}/product_list_page` → `admin/product/getProuductlistPage`；规则 `app\admin\controller\Productcontroller::getprouductlistpage`；[源行](../../data/route/admin.php#L409) | 未提取；新设计明确成功后重读受影响对象 |
| `37c1e0e8` / `deleteProduct` | `未显式指定` `"del_product"` (params) | `GET {A}/del_product` → `admin/product/delete`；规则 `app\admin\controller\Productcontroller::delete`；[源行](../../data/route/admin.php#L418) | `getData` |
| `37c1e0e8` / `deleteGroup` | `未显式指定` `"del_product_group"` (params) | `GET {A}/del_product_group` → `admin/product/deleteGroup`；规则 `app\admin\controller\Productcontroller::deletegroup`；[源行](../../data/route/admin.php#L419) | `getData` |
| `37c1e0e8` / `showAddProduct` | `未显式指定` `"add_product_page"` (params) | `GET {A}/add_product_page` → `admin/product/addPage`；规则 `app\admin\controller\Productcontroller::addpage`；[源行](../../data/route/admin.php#L421) | 未提取；新设计明确成功后重读受影响对象 |
| `37c1e0e8` / `submitForm` | `"post"` `"create_product"` (data) | `POST {A}/create_product` → `admin/product/create`；规则 `app\admin\controller\Productcontroller::create`；[源行](../../data/route/admin.php#L422) | 未提取；新设计明确成功后重读受影响对象 |
| `37c1e0e8` / `showCopyProduct` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |
| `37c1e0e8` / `copyProduct` | `"post"` `"product_duplicate"` (data) | `POST {A}/product_duplicate` → `admin/product/duplicate`；规则 `app\admin\controller\Productcontroller::duplicate`；[源行](../../data/route/admin.php#L424) | 未提取；新设计明确成功后重读受影响对象 |
| `37c1e0e8` / `rowDrag` | `"post"` `"update_productsort"` (data) | `POST {A}/update_productsort` → `admin/product/updateProductsort`；规则 `app\admin\controller\Productcontroller::updateproductsort`；[源行](../../data/route/admin.php#L412) | `getData` |
| `37c1e0e8` / `rowDrag` | `"post"` `"update_groupsort"` (data) | `POST {A}/update_groupsort` → `admin/product/updateGroupsort`；规则 `app\admin\controller\Productcontroller::updategroupsort`；[源行](../../data/route/admin.php#L411) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goToEditProduct: this.$router.push({path:"/edit-product",query:{id:t,prePage:"dcimcloud"}})`
- 旧跳转：`editGroup: this.$router.push({path:"/add-product-group",query:{id:t,prePage:"dcimcloud"}})`
- 旧跳转：`goToAddGroup: this.$router.push({path:"/add-product-group",query:{prePage:"dcimcloud"}})`
- 旧跳转：`submitForm: t.$router.push({path:"/edit-product",query:{id:t.productId}})`
- 旧跳转：`copyProduct: t.$router.push({path:"/edit-product",query:{id:t.pid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p159"></a>

## 手工资源 `/munual-resource`

旧版证据：[P159](27-admin-built-page-evidence.md#p159)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“手工资源”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7179/1c20a84a` | `el-form-item` | `主IP ($lang.lord_ip)` / `in_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7179/1c20a84a` | `el-form-item` | `供应商 ($lang.supplier)` / `pid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7179/1c20a84a` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7179/1c20a84a` | `el-table-column` | `重装/破解 ($lang.reload_crack)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `电源 ($lang.power_supply)` / `power_status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `配置 ($lang.configuration)` / `pz` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `备注 ($lang.remark)` / `mark` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `用户名/密码 ($lang.user_name_password)` / `root` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `供应商 ($lang.supplier)` / `uname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `成本 ($lang.cost)` / `total` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `关联客户（产品） ($lang.affiliated_customer_product)` / `names` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `到期时间 ($lang.expire_date)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7179/1c20a84a` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7179/1c20a84a` | `添加资源` | `on.click → e.toAddResource` | `无提取条件` |
| `7179/1c20a84a` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `7179/1c20a84a` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `无提取条件` |
| `7179/1c20a84a` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `无提取条件` |
| `7179/1c20a84a` | `" "+e._s(a.reinstallObj.cancel\|\|e.$lang.cancel_reload_crack)+" "` | `on.click → function(t){return e.cancelTask(a)}` | `scopedSlots; a.button.includes("reinstall")\|\|a.button.includes("crackPass"); else("{}"===JSON.stringify(a.reinstallObj))` |
| `7179/1c20a84a` | `" "+e._s(t.row.in_ip+"("+t.row.ipcount+")")` | `on.click → function(r){return e.goProduct(t.row)}` | `scopedSlots; t.row.ips; t.row.names` |
| `7179/1c20a84a` | `图标/动态文案，回查原证据` | `on.click → function(t){return e.goProduct(a)}` | `scopedSlots; a.name; (a.cname+a.name).toString().length<=20` |
| `7179/1c20a84a` | `图标/动态文案，回查原证据` | `on.click → function(t){return e.goProduct(a)}` | `scopedSlots; a.name; else((a.cname+a.name).toString().length<=20)` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goProduct: this.$router.push({path:"/customer-view/product-innerpage",query:{hid:t,id:e.uid}})`
- 旧跳转：`toAdd: this.$router.push({name:"upStreamEdit"})`
- 旧跳转：`toAddResource: this.$router.push({path:"addOrEdit-resource",query:{supplier:1,aid:this.$route.query.id}})`
- 旧跳转：`toAddResource: this.$router.push({name:"addOrEditResource"})`
- 旧跳转：`editUpStream: this.$router.push({path:"/upStream-edit",query:{id:t}})`
- 旧跳转：`editResource: this.$router.push({path:"/addOrEdit-resource",query:{supplier:1,aid:this.$route.query.id,id:t}})`
- 旧跳转：`editResource: this.$router.push({path:"/addOrEdit-resource",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p160"></a>

## 上游编辑 `/upStream-edit`

旧版证据：[P160](27-admin-built-page-evidence.md#p160)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“上游编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `94d8/41985f4d` | `el-form-item` | `上游名称 ($lang.upstream_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `94d8/41985f4d` | `el-form-item` | `联系方式 ($lang.contact_information)` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `94d8/41985f4d` | `el-form-item` | `备注 ($lang.remark)` / `bz` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `94d8/41985f4d` | `提交 ($lang.submit)` | `on.click → t.submitForm` | `无提取条件` |
| `94d8/41985f4d` | `返回 ($lang.get_back)` | `on.click → t.goBack` | `无提取条件` |
| `94d8/41985f4d` | `重置 ($lang.reset)` | `on.click → t.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `41985f4d` / `submitForm` | `"post"` `"upper/addpost"` (data) | `ANY {A}/upper/addpost` → `admin/upperReaches/addPost`；规则 `app\admin\controller\UpperReachescontroller::addpost`；[源行](../../data/route/admin.php#L721) | `editInit` |
| `41985f4d` / `submitForm` | `"post"` `"upper/edituppost"` (data) | `ANY {A}/upper/edituppost` → `admin/upperReaches/editupPost`；规则 `app\admin\controller\UpperReachescontroller::edituppost`；[源行](../../data/route/admin.php#L722) | `editInit` |
| `41985f4d` / `editInit` | `未显式指定` `"upper/index"` (params) | `ANY {A}/upper/index` → `admin/upperReaches/index`；规则 `app\admin\controller\UpperReachescontroller::index`；[源行](../../data/route/admin.php#L720) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: t.$router.push({name:"munualResource",params:{tabIndex:2}})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p161"></a>

## 手工资源编辑 `/addOrEdit-resource`

旧版证据：[P161](27-admin-built-page-evidence.md#p161)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“手工资源编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b002/6d9c50d6` | `el-form-item` | `主IP ($lang.lord_ip)` / `in_ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `附加IP ($lang.append_ip)` / `ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `备注 ($lang.remark)` / `mark` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `上游 ($lang.upstream)` / `pid` / `-` | `else(e.$route.query.supplier)` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `配置 ($lang.configuration)` / `pz` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `密码 ($lang.password)` / `password` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `成本 ($lang.cost)` / `total` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `到期时间 ($lang.expire_date)` / `paid_time` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `控制方式 ($lang.control_mode)` / `control_mode` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `IPMI IP` / `ipmi` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode; "ipmi"===e.formData.control_mode` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `版本 ($lang.versions)` / `ipmi_version` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode; "ipmi"===e.formData.control_mode` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `魔方DCIM客户端地址 ($lang.rubiks_cube_dcim_client_address)` / `dcim_client_url` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode; "dcim_client"===e.formData.control_mode` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `服务器ID ($lang.server_id)` / `dcim_client_id` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode; "dcim_client"===e.formData.control_mode` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `e.variableUserName+e.$lang.user_name` / `root` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode` | 分组表单；未知原值不置空 |
| `b002/6d9c50d6` | `el-form-item` | `e.variablePassWord+e.$lang.password` / `pwd` / `-` | `"ipmi"===e.formData.control_mode\|\|"dcim_client"===e.formData.control_mode` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `b002/6d9c50d6` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `b002/6d9c50d6` | `返回 ($lang.get_back)` | `on.click → e.goBack` | `无提取条件` |
| `b002/6d9c50d6` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `6d9c50d6` / `submitForm` | `"post"` `"upper/addupperpost"` (data) | `ANY {A}/upper/addupperpost` → `admin/upperReaches/addUpperPost`；规则 `app\admin\controller\UpperReachescontroller::addupperpost`；[源行](../../data/route/admin.php#L730) | 未提取；新设计明确成功后重读受影响对象 |
| `6d9c50d6` / `submitForm` | `"post"` `"upper/editupperpost"` (data) | `ANY {A}/upper/editupperpost` → `admin/upperReaches/editUpperPost`；规则 `app\admin\controller\UpperReachescontroller::editupperpost`；[源行](../../data/route/admin.php#L732) | 未提取；新设计明确成功后重读受影响对象 |
| `6d9c50d6` / `editInit` | `"get"` `"upper/upperindex"` (params) | `ANY {A}/upper/upperindex` → `admin/upperReaches/upperIndex`；规则 `app\admin\controller\UpperReachescontroller::upperindex`；[源行](../../data/route/admin.php#L724)<br>`ANY {A}/upper/upperindex` → `admin/upperReaches/upperIndex`；规则 `app\admin\controller\UpperReachescontroller::upperindex`；[源行](../../data/route/admin.php#L728) | `getUpStreamListData` |
| `6d9c50d6` / `getAddData` | `未显式指定` `"upper/addupperpage"` (无显式 data/params) | `ANY {A}/upper/addupperpage` → `admin/upperReaches/addUpperPage`；规则 `app\admin\controller\UpperReachescontroller::addupperpage`；[源行](../../data/route/admin.php#L729) | 未提取；新设计明确成功后重读受影响对象 |
| `6d9c50d6` / `getUpStreamListData` | `未显式指定` `"upper/index"` (params) | `ANY {A}/upper/index` → `admin/upperReaches/index`；规则 `app\admin\controller\UpperReachescontroller::index`；[源行](../../data/route/admin.php#L720) | 未提取；新设计明确成功后重读受影响对象 |
| `6d9c50d6` / `editPageData` | `未显式指定` `"upper/editupperpage"` (params) | `ANY {A}/upper/editupperpage` → `admin/upperReaches/editUpperPage`；规则 `app\admin\controller\UpperReachescontroller::editupperpage`；[源行](../../data/route/admin.php#L731) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submitForm: e.$router.push({name:"munualResource",params:{id:a.data.id,type:e.formData.control_mode}})`
- 旧跳转：`submitForm: e.$router.push({name:"munualResource",params:{id:e.formData.id,type:e.formData.control_mode}})`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p162"></a>

## 任务队列 `/task-queue`

旧版证据：[P162](27-admin-built-page-evidence.md#p162)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“任务队列”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `c95f/1eac8fe8` | `el-table-column` | `客户 ($lang.client)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `产品 ($lang.product)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `动作 ($lang.motion)` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `来源 ($lang.source)` / `from_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `状态 ($lang.state)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `最后操作时间 ($lang.last_operating_time)` / `last_execute_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `c95f/1eac8fe8` | `el-table-column` | `操作 ($lang.operation)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `c95f/1eac8fe8` | `搜索 ($lang.search)` | `on.click → t.searchClick` | `无提取条件` |
| `c95f/1eac8fe8` | `e.row.user` | `on.click → function(a){return t.goToView(e.row.user_id)}` | `scopedSlots` |
| `c95f/1eac8fe8` | `r.domain` | `on.click → function(e){return t.goToProduct(r.user_id,r.host_id)}` | `scopedSlots` |
| `c95f/1eac8fe8` | `重试 ($lang.tautology)` | `on.click → function(a){return t.handleClick(e.row)}` | `scopedSlots; 0===e.row.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1eac8fe8` / `handleClick` | `"post"` `"run_map/repeat_task"` (data) | `POST {A}/run_map/repeat_task` → `admin/RunMap/repeatTask`；规则 `app\admin\controller\RunMapcontroller::repeattask`；[源行](../../data/route/admin.php#L849) | 未提取；新设计明确成功后重读受影响对象 |
| `1eac8fe8` / `getData` | `未显式指定` `"run_map/list?query[".concat(e,"]=").concat(a)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `formType`、`activeType` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.row.user_id}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:r.user_id,hid:r.host_id,fa:"productList"}}`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p163"></a>

## 资源配置编辑 `/configure-edit`

旧版证据：[P163](27-admin-built-page-evidence.md#p163)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“资源配置编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `e04a/fee1c8d6` | `el-tab-pane` | `概览 ($lang.overview)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `e04a/fee1c8d6` | `el-tab-pane` | `商品列表 ($lang.commodity_list)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `e04a/fee1c8d6` | `el-tab-pane` | `产品列表 ($lang.product_list)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `e04a/fee1c8d6` | `el-tab-pane` | `服务器列表 ($lang.server_list)` / `-` / `-` | `"manual"==e.$route.query.type` | 主区导航；保留对象与选中项 |
| `e04a/fee1c8d6` | `el-tab-pane` | `任务队列 ($lang.task_queue)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `e04a/fee1c8d6` | `el-tab-pane` | `订单列表 ($lang.order_form_list)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

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

<a id="p164"></a>

## API 设置 `/api-setup`

旧版证据：[P164](27-admin-built-page-evidence.md#p164)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“API 设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fdb8/-` | `el-form-item` | `是否开启资源API` / `allow_resource_api` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-form-item` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-form-item` | `实名认证 ($lang.name_authentication)` / `allow_resource_api_realname` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-switch` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-form-item` | `是否需要绑定手机号 ($lang.binding_mobile_phone)` / `allow_resource_api_phone` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |
| `fdb8/-` | `el-switch` | `-` / `-` / `-` | `1==e.formData.allow_resource_api` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fdb8/-` | `保存更改 ($lang.save_the_changes)` | `on.click → e.submitForm` | `无提取条件` |
| `fdb8/-` | `取消更改 ($lang.cancel_changes)` | `on.click → e.resetForm` | `无提取条件` |

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

<a id="p165"></a>

## 统计任务队列 `/statistics-taskQueue`

旧版证据：[P165](27-admin-built-page-evidence.md#p165)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“统计任务队列”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0d1f/138faa3b` | `el-table-column` | `客户 ($lang.client)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `产品 ($lang.product)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `动作 ($lang.motion)` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `来源 ($lang.source)` / `from_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `状态 ($lang.state)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `最后操作时间 ($lang.last_operating_time)` / `last_execute_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `0d1f/138faa3b` | `el-table-column` | `操作 ($lang.operation)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `0d1f/138faa3b` | `搜索 ($lang.search)` | `on.click → t.searchClick` | `无提取条件` |
| `0d1f/138faa3b` | `e.row.user` | `on.click → function(a){return t.goToView(e.row.user_id)}` | `scopedSlots` |
| `0d1f/138faa3b` | `" "+t._s(r.name)+t._s(r.dedicatedip?"("+r.dedicatedip+")":"")` | `on.click → function(e){return t.goToProduct(r.user_id,r.host_id)}` | `scopedSlots` |
| `0d1f/138faa3b` | `重试 ($lang.tautology)` | `on.click → function(a){return t.handleClick(e.row)}` | `scopedSlots; 0===e.row.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `138faa3b` / `handleClick` | `"post"` `"run_map/repeat_task"` (data) | `POST {A}/run_map/repeat_task` → `admin/RunMap/repeatTask`；规则 `app\admin\controller\RunMapcontroller::repeattask`；[源行](../../data/route/admin.php#L849) | 未提取；新设计明确成功后重读受影响对象 |
| `138faa3b` / `getData` | `未显式指定` `"run_map/list?query[".concat(e,"]=").concat(a)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `formType`、`activeType` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.row.user_id}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:r.user_id,hid:r.host_id}}`
- 旧跳转：`goToProduct: this.$router.push({name:"productInnerpage",query:{id:t,hid:e}})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p166"></a>

## 上游商品列表 `/commodity-list`

旧版证据：[P166](27-admin-built-page-evidence.md#p166)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“上游商品列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p167"></a>

## 上游产品列表 `/commodity-product`

旧版证据：[P167](27-admin-built-page-evidence.md#p167)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“上游产品列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p168"></a>

## 上游任务队列 `/commodity-taskQueue`

旧版证据：[P168](27-admin-built-page-evidence.md#p168)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“上游任务队列”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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

<a id="p169"></a>

## 供应商编辑 `/add-supplier`

旧版证据：[P169](27-admin-built-page-evidence.md#p169)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“供应商编辑”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `ef86/-` | `el-form-item` | `供应商名称 ($lang.supplier_name)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `联系方式 ($lang.contact_information)` / `contact_way` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `备注 ($lang.remark)` / `des` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `接口类型 ($lang.interface_type)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `接口地址 ($lang.address_of_the_interface)` / `hostname` / `-` | `"zjmf_api"==a.formData.type\|\|"whmcs"==a.formData.type` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `用户名 ($lang.user_name)` / `username` / `-` | `"zjmf_api"==a.formData.type\|\|"whmcs"==a.formData.type` | 分组表单；未知原值不置空 |
| `ef86/-` | `el-form-item` | `API密钥 ($lang.api_secret_key)` / `password` / `-` | `"zjmf_api"==a.formData.type\|\|"whmcs"==a.formData.type` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `ef86/-` | `取消 ($lang.cancel)` | `on.click → function(t){return a.$router.push({path:"zjmf-api"})}` | `无提取条件` |
| `ef86/-` | `确定 ($lang.confirm)` | `on.click → a.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"zjmf_finance_api/".concat(a)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submit` | `"post"` `"zjmf_finance_api"` (data) | `POST {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/createApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::createapi`；[源行](../../data/route/admin.php#L752) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submit` | `"put"` `"zjmf_finance_api"` (data) | `PUT {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/modifyApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::modifyapi`；[源行](../../data/route/admin.php#L753) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: a.$router.push({name:"ZjmfApi",params:{refreshId:Number(s.data.id)}})`
- 旧跳转：`submit: a.$router.push({name:"ZjmfApi"})`
- 旧跳转：`submit: a.$router.push({name:"ZjmfApi",params:{refreshId:a.formData.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p171"></a>

## 魔方财务接口 `/zjmf-api`

旧版证据：[P171](27-admin-built-page-evidence.md#p171)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“魔方财务接口”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `1c84/f94ad29c` | `el-table-column` | `名称 ($lang.name_designation)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `类型 ($lang.type)` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `接口地址 ($lang.address_of_the_interface)` / `hostname` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `可售/已设置商品 ($lang.sold_set_up_goods)` / `product_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `产品数量(正常/总) ($lang.product_quantity)` / `active_host_num` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `余额 ($lang.remain_sum)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `描述 ($lang.describe)` / `des` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-table-column` | `管理 ($lang.management)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1c84/f94ad29c` | `el-dialog` | `-` / `-` / `t.formData.id?"编辑上游":"添加上游"` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `1c84/f94ad29c` | `el-form-item` | `接口类型` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `名称` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `联系方式` / `contact_way` / `-` | `"manual"==t.formData.type` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `接口地址(IP或者域名)` / `hostname` / `-` | `"zjmf_api"==t.formData.type` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `用户名` / `username` / `-` | `"zjmf_api"==t.formData.type` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `API密钥` / `password` / `-` | `"zjmf_api"==t.formData.type` | 分组表单；未知原值不置空 |
| `1c84/f94ad29c` | `el-form-item` | `描述` / `des` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `1c84/f94ad29c` | `添加供应商 ($lang.add_supplier)` | `on.click → t.toAdd` | `无提取条件` |
| `1c84/f94ad29c` | `r.name` | `on.click → function(e){return t.goToView(r)}` | `scopedSlots` |
| `1c84/f94ad29c` | `编辑` | `on.click → function(a){return t.toEdit(e.row)}` | `scopedSlots` |
| `1c84/f94ad29c` | `删除 ($lang.delete)` | `on.click → function(a){return t.deleteHandleClick(e.row)}` | `scopedSlots` |
| `1c84/f94ad29c` | `取消` | `on.click → function(e){t.dialogVisiable=!1}` | `无提取条件` |
| `1c84/f94ad29c` | `确定` | `on.click → t.submit` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `f94ad29c` / `getData` | `未显式指定` `"zjmf_finance_api"` (params) | `POST {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/createApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::createapi`；[源行](../../data/route/admin.php#L752)<br>`PUT {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/modifyApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::modifyapi`；[源行](../../data/route/admin.php#L753)<br>`GET {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/index`；规则 `app\admin\controller\ZjmfFinanceApicontroller::index`；[源行](../../data/route/admin.php#L756) | `refreashStatus` |
| `f94ad29c` / `getData` | `未显式指定` `"zjmf_finance_api/upstreamcredit"` (params) | `GET {A}/zjmf_finance_api/upstreamcredit` → `admin/zjmfFinanceApi/upstreamCredit`；规则 `app\admin\controller\ZjmfFinanceApicontroller::upstreamcredit`；[源行](../../data/route/admin.php#L777) | `refreashStatus` |
| `f94ad29c` / `getApiDetail` | `未显式指定` `"zjmf_finance_api/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `f94ad29c` / `submit` | `"post"` `"zjmf_finance_api"` (data) | `POST {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/createApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::createapi`；[源行](../../data/route/admin.php#L752) | `getData`、`refreashStatus` |
| `f94ad29c` / `submit` | `"put"` `"zjmf_finance_api"` (data) | `PUT {A}/zjmf_finance_api` → `admin/zjmfFinanceApi/modifyApi`；规则 `app\admin\controller\ZjmfFinanceApicontroller::modifyapi`；[源行](../../data/route/admin.php#L753) | `getData`、`refreashStatus` |
| `f94ad29c` / `deleteHandleClick` | `"delete"` `"zjmf_finance_api/".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `f94ad29c` / `refreashStatus` | `未显式指定` `"zjmf_finance_api/".concat(t,"/status")` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"configure-edit",query:{id:r.id,name:r.name,type:r.type}}`
- 旧跳转：`goToView: this.$router.push({path:"configure-edit",query:{id:t.id,name:t.name,type:t.type}})`
- 旧跳转：`toAdd: this.$router.push({path:"add-supplier"})`
- 旧跳转：`toEdit: this.$router.push({path:"add-supplier",query:{id:t.id}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p193"></a>

## DCIM 授权 `/dcim-authorization`

旧版证据：[P193](27-admin-built-page-evidence.md#p193)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“DCIM 授权”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `59d9/0f7f3f65` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `客户名称 ($lang.customer_name2)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `类型 ($lang.type)` / `authorize_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `版本 ($lang.versions)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `授权数量(已用) ($lang.authorized_quantity_used)` / `diver_sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `到期时间 ($lang.expire_date)` / `next_date` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `"list"===e.pageType` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `else("list"===e.pageType); "disable"===e.pageType` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `59d9/0f7f3f65` | `el-form-item` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `59d9/0f7f3f65` | `搜索` | `on.click → e.getData` | `无提取条件` |
| `59d9/0f7f3f65` | `图标/动态文案，回查原证据` | `on.click → function(t){return e.groupEdit(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteRow(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `重置 ($lang.reset)` | `on.click → function(t){return e.resetRow(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `恢复 ($lang.recovery)` | `on.click → function(t){return e.recoverRow(r)}` | `else("list"===e.pageType); "disable"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialog.show=!1}` | `无提取条件` |
| `59d9/0f7f3f65` | `确定 ($lang.confirm)` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0f7f3f65` / `deleteRow` | `"delete"` `"dcimauth"` (data) | `DELETE {A}/dcimauth` → `admin/dcimAuth/deleteAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L788) | 未提取；新设计明确成功后重读受影响对象 |
| `0f7f3f65` / `recoverRow` | `"put"` `"dcimauth/recover"` (data) | `PUT {A}/dcimauth/recover` → `admin/dcimAuth/recoverAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L789) | 未提取；新设计明确成功后重读受影响对象 |
| `0f7f3f65` / `handelConfirm` | `"put"` `"dcimauth/reset"` (data) | `PUT {A}/dcimauth/reset` → `admin/dcimAuth/resetAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L787) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.uid}}`
- 旧跳转：`render router-link: {name:"DcimAuthorizationUpdate",query:{id:r.id}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p194"></a>

## DCIM 授权停用页 `/dcim-authorization-disable`

旧版证据：[P194](27-admin-built-page-evidence.md#p194)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“DCIM 授权停用页”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `59d9/0f7f3f65` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `客户名称 ($lang.customer_name2)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `类型 ($lang.type)` / `authorize_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `版本 ($lang.versions)` / `version` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `授权数量(已用) ($lang.authorized_quantity_used)` / `diver_sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `到期时间 ($lang.expire_date)` / `next_date` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `"list"===e.pageType` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-table-column` | `操作 ($lang.operate)` / `-` / `-` | `else("list"===e.pageType); "disable"===e.pageType` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `59d9/0f7f3f65` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `59d9/0f7f3f65` | `el-form-item` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `59d9/0f7f3f65` | `搜索` | `on.click → e.getData` | `无提取条件` |
| `59d9/0f7f3f65` | `图标/动态文案，回查原证据` | `on.click → function(t){return e.groupEdit(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `删除 ($lang.delete)` | `on.click → function(t){return e.deleteRow(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `重置 ($lang.reset)` | `on.click → function(t){return e.resetRow(r)}` | `"list"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `恢复 ($lang.recovery)` | `on.click → function(t){return e.recoverRow(r)}` | `else("list"===e.pageType); "disable"===e.pageType; scopedSlots` |
| `59d9/0f7f3f65` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialog.show=!1}` | `无提取条件` |
| `59d9/0f7f3f65` | `确定 ($lang.confirm)` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `0f7f3f65` / `deleteRow` | `"delete"` `"dcimauth"` (data) | `DELETE {A}/dcimauth` → `admin/dcimAuth/deleteAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L788) | 未提取；新设计明确成功后重读受影响对象 |
| `0f7f3f65` / `recoverRow` | `"put"` `"dcimauth/recover"` (data) | `PUT {A}/dcimauth/recover` → `admin/dcimAuth/recoverAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L789) | 未提取；新设计明确成功后重读受影响对象 |
| `0f7f3f65` / `handelConfirm` | `"put"` `"dcimauth/reset"` (data) | `PUT {A}/dcimauth/reset` → `admin/dcimAuth/resetAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L787) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:r.uid}}`
- 旧跳转：`render router-link: {name:"DcimAuthorizationUpdate",query:{id:r.id}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p195"></a>

## DCIM 授权异常页 `/dcim-authorization-error`

旧版证据：[P195](27-admin-built-page-evidence.md#p195)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“DCIM 授权异常页”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `40d3/55c5649d` | `el-table-column` | `时间 ($lang.time)` / `date` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40d3/55c5649d` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40d3/55c5649d` | `el-table-column` | `授权信息 ($lang.authorization_information)` / `detail` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40d3/55c5649d` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40d3/55c5649d` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `remarks` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `40d3/55c5649d` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `40d3/55c5649d` | `el-form-item` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `40d3/55c5649d` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `40d3/55c5649d` | `取消 ($lang.cancel)` | `on.click → function(t){e.dialog.show=!1}` | `无提取条件` |
| `40d3/55c5649d` | `确定 ($lang.confirm)` | `on.click → e.handelConfirm` | `无提取条件` |

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

<a id="p196"></a>

## DCIM 调试日志 `/dcim-debug-log`

旧版证据：[P196](27-admin-built-page-evidence.md#p196)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“DCIM 调试日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4fa8/577e968e` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4fa8/577e968e` | `el-table-column` | `时间 ($lang.time)` / `create_date` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4fa8/577e968e` | `el-table-column` | `IP` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4fa8/577e968e` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4fa8/577e968e` | `el-table-column` | `操作人 ($lang.operator)` / `admin` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4fa8/577e968e` | `el-dialog` | `-` / `-` / `e.dialog.title` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `4fa8/577e968e` | `el-form-item` | `解密方式 ($lang.decryption_method)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4fa8/577e968e` | `el-form-item` | `加密数据 ($lang.encrypt_data)` / `data` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `4fa8/577e968e` | `el-form-item` | `-` / `-` / `-` | `e.formData.show` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4fa8/577e968e` | `解密信息 ($lang.decryption_info)` | `on.click → e.openDialog` | `无提取条件` |
| `4fa8/577e968e` | `搜索 ($lang.search)` | `on.click → e.getData` | `无提取条件` |
| `4fa8/577e968e` | `关闭 ($lang.shut_down)` | `on.click → function(t){e.dialog.show=!1}` | `无提取条件` |
| `4fa8/577e968e` | `解密 ($lang.decrypt)` | `on.click → e.handelConfirm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `577e968e` / `handelConfirm` | `"post"` `"dcimauth/debug"` (data) | `POST {A}/dcimauth/debug` → `admin/dcimAuth/debugDecrypt`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L798) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p197"></a>

## DCIM 授权更新页 `/dcim-authorization-update`

旧版证据：[P197](27-admin-built-page-evidence.md#p197)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“DCIM 授权更新页”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6aae/-` | `el-form-item` | `授权码 ($lang.auth_code)` / `license` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `客户 ($lang.client)` / `name` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `版本 ($lang.versions)` / `version` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `授权IP ($lang.authorized_ip)` / `ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `价格 ($lang.price)` / `price` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `授权类型 ($lang.authorized_type)` / `authorize_type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `部署类型 ($lang.bushu_type)` / `network_type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `授权数量 ($lang.authorized_num)` / `diver_sum` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `被控数量 ($lang.beikong_type)` / `max_accused` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `裸金属LMC数量 ($lang.ljs_lmc_num)` / `lmc_num` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `裸金属LC数量 ($lang.ljs_lc_num)` / `lc_num` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `被控数量 ($lang.beikong_type)` / `accused_num` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `服务器数量 ($lang.number_of_servers)` / `hardware` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `交换机数量 ($lang.jiaohuanji_num)` / `switch` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `PDU设备数量 ($lang.pdu_sb_num)` / `hardware_pdu` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `创建时间 ($lang.create_time)` / `create_date` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `到期时间 ($lang.expire_date)` / `next_date` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `附加产品 ($lang.additional_products)` / `addition` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `特殊产品 ($lang.teshu_products)` / `addons` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `扩展功能 ($lang.extended_functions)` / `expansion` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `备注 ($lang.remark)` / `remarks` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6aae/-` | `el-table-column` | `时间 ($lang.time)` / `date` / `-` | `e.tableData1.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `IP` / `ip` / `-` | `e.tableData1.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `授权信息 ($lang.authorization_information)` / `detail` / `-` | `e.tableData1.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `e.tableData1.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `失败原因 ($lang.fail_reason)` / `remarks` / `-` | `e.tableData1.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `时间 ($lang.time)` / `date` / `-` | `e.tableData2.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `IP` / `ip` / `-` | `e.tableData2.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6aae/-` | `el-table-column` | `操作详情 ($lang.opertion_detail)` / `description` / `-` | `e.tableData2.length>0` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6aae/-` | `提交 ($lang.submit)` | `on.click → e.submitForm` | `无提取条件` |
| `6aae/-` | `重置 ($lang.reset)` | `on.click → e.resetForm` | `无提取条件` |
| `6aae/-` | `推送更新(热) ($lang.push_update_hot)` | `on.click → function(t){return e.push("pushHotRes")}` | `无提取条件` |
| `6aae/-` | `推送更新(普通) ($lang.push_update_normal)` | `on.click → function(t){return e.push("pushHotCommonRes")}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"dcimauth/".concat(e.id)` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `submitForm` | `"put"` `"dcimauth"` (data) | `PUT {A}/dcimauth` → `admin/dcimAuth/editAuth`；规则 `需展开路由后核对`；[源行](../../data/route/admin.php#L791) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p198"></a>

## 资源池容器 `/resource-pool`

旧版证据：[P198](27-admin-built-page-evidence.md#p198)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“资源池容器”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `9aff/641d926e` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `客户 ($lang.client)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `姓名 ($lang.name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `公司/介绍 ($lang.company_introduction)` / `company` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `品牌 ($lang.brand)` / `brand` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `网址 ($lang.website)` / `website` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `电话/QQ ($lang.phone_qq)` / `phone` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `主营和优势产品 ($lang.main_products_and_advantages)` / `scope` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `申请时间 ($lang.apply_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `状态 ($lang.state)` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/641d926e` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `客户 ($lang.client)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `姓名 ($lang.name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `公司/介绍 ($lang.company_introduction)` / `company` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `品牌 ($lang.brand)` / `brand` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `网址 ($lang.website)` / `website` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `电话/QQ ($lang.phone_qq)` / `phone` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `主要需求产品 ($lang.main_demand_products)` / `demand_products` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `月业绩能力 ($lang.monthly_performance_capability)` / `achievement` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `申请时间 ($lang.apply_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `状态 ($lang.state)` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/8d65f132` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `9aff/28acb4f9` | `el-tab-pane` | `资源方 ($lang.resource_user)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `9aff/28acb4f9` | `el-tab-pane` | `代理商 ($lang.agent)` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `9aff/641d926e` | `搜索 ($lang.search)` | `on.click → e.btnSearch` | `无提取条件` |
| `9aff/641d926e` | `重置 ($lang.reset)` | `on.click → e.resetSearch` | `无提取条件` |
| `9aff/641d926e` | `n.username` | `on.click → function(t){return e.goUser(n.uid)}` | `scopedSlots` |
| `9aff/641d926e` | `n.website` | `on.click → function(t){return e.openUrl(n.website)}` | `scopedSlots` |
| `9aff/641d926e` | `通过 ($lang.pass)` | `on.click → function(t){return e.auditResource(n.id,"Active")}` | `scopedSlots; "Pending"===n.status` |
| `9aff/641d926e` | `驳回 ($lang.reject)` | `on.click → function(t){return e.auditResource(n.id,"Cancelled")}` | `scopedSlots; "Pending"===n.status` |
| `9aff/641d926e` | `停用 ($lang.disable)` | `on.click → function(t){return e.auditResource(n.id,"Suspended")}` | `scopedSlots; "Active"===n.status` |
| `9aff/641d926e` | `启用 ($lang.start_using)` | `on.click → function(t){return e.auditResource(n.id,"Active")}` | `scopedSlots; "Suspended"===n.status` |
| `9aff/8d65f132` | `搜索 ($lang.search)` | `on.click → e.btnSearch` | `无提取条件` |
| `9aff/8d65f132` | `重置 ($lang.reset)` | `on.click → e.resetSearch` | `无提取条件` |
| `9aff/8d65f132` | `n.username` | `on.click → function(t){return e.goUser(n.uid)}` | `scopedSlots` |
| `9aff/8d65f132` | `n.website` | `on.click → function(t){return e.openUrl(n.website)}` | `scopedSlots` |
| `9aff/8d65f132` | `通过 ($lang.pass)` | `on.click → function(t){return e.auditAgent(n.id,"Active")}` | `scopedSlots; "Pending"===n.status` |
| `9aff/8d65f132` | `驳回 ($lang.reject)` | `on.click → function(t){return e.auditAgent(n.id,"Cancelled")}` | `scopedSlots; "Pending"===n.status` |
| `9aff/8d65f132` | `停用 ($lang.disable)` | `on.click → function(t){return e.auditAgent(n.id,"Suspended")}` | `scopedSlots; "Active"===n.status` |
| `9aff/8d65f132` | `启用 ($lang.start_using)` | `on.click → function(t){return e.auditAgent(n.id,"Active")}` | `scopedSlots; "Suspended"===n.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `641d926e` / `getData` | `未显式指定` `"resource_party/resourcepartylist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `641d926e` / `auditResourceSend` | `"post"` `"resource_party/checkresourceparty"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `8d65f132` / `getData` | `未显式指定` `"agent/agentlist"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `8d65f132` / `auditAgentSend` | `"post"` `"agent/checkagent"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`goUser: this.$router.push({name:"abstract",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p216"></a>

## 资源池订单管理 `/order-management-list`

旧版证据：[P216](27-admin-built-page-evidence.md#p216)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池订单管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6012c/5ef01862` | `el-form-item` | `订单ID` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `商品名称/主机名` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `订单状态` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `订单类型` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `金额` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `订购时间` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `商品` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-form-item` | `商品名称:` / `-` / `-` | `scopedSlots; r.name` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `主机名:` / `-` / `-` | `scopedSlots; r.name` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-table-column` | `产品类型` / `product_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `卖家` / `supplier_username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `用户` / `agent_username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `订单状态/产品状态` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `订购时间` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `订单类型` / `invoice_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `金额` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `利润` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `付款方式` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/5ef01862` | `el-dialog` | `-` / `-` / `退款` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6012c/5ef01862` | `el-form-item` | `订单号：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `商品名称：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `退款金额：` / `amount` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `退款原因：` / `refundReason` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-dialog` | `-` / `-` / `申请平台介入` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6012c/5ef01862` | `el-form-item` | `订单号：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `商品名称：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `申请原因：` / `applyReason` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `上传图片：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `6012c/5ef01862` | `el-dialog` | `-` / `-` / `商品评价` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6012c/5ef01862` | `el-form-item` | `店铺名称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `评价` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `综合评价` / `score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `网络质量` / `netword_score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `硬件年限` / `hardware_score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `评价内容` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-form-item` | `上传图片` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/5ef01862` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `6012c/06b441b3` | `el-form-item` | `订单ID` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `商品名称/主机名` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `金额` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `订购时间` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `商品` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-form-item` | `商品名称:` / `-` / `-` | `scopedSlots; r.name` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `主机名:` / `-` / `-` | `scopedSlots; r.name` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-table-column` | `产品类型` / `product_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `卖家` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `用户` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `续费时间` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `金额` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `利润` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `付款方式` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-table-column` | `操作` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6012c/06b441b3` | `el-dialog` | `-` / `-` / `评价` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `6012c/06b441b3` | `el-form-item` | `店铺名称` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `评价` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `综合评价` / `score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `网络质量` / `netword_score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `硬件年限` / `hardware_score` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `评价内容` / `content` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-form-item` | `上传图片` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6012c/06b441b3` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `6012c/6ba261e4` | `el-tab-pane` | `订单` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `6012c/6ba261e4` | `el-tab-pane` | `续费订单` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6012c/5ef01862` | `e.showSearchArea?"收起搜索":"高级搜索"` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `6012c/5ef01862` | `搜索` | `on.click → e.handleSearch` | `e.showSearchArea` |
| `6012c/5ef01862` | `清空` | `on.click → e.handleDelete` | `e.showSearchArea` |
| `6012c/5ef01862` | `退款` | `on.click → function(t){return e.refund(r)}` | `scopedSlots; "信用额支付"!=r.payment&&"Refunding"!=r.status&&"Refunded"!=r.status&&r.invoiceid&&1==r.allow_refund` |
| `6012c/5ef01862` | `退款详情` | `on.click → function(t){return e.$router.push({path:"refund-detail",query:{id:r.invoiceid}})}` | `scopedSlots; r.r_status` |
| `6012c/5ef01862` | `申请售后` | `on.click → function(t){return e.applyAftersale(r)}` | `scopedSlots; e.$valIsNull(r.after_sale.id)` |
| `6012c/5ef01862` | `售后详情` | `on.click → function(t){return e.$router.push({path:"aftersale-detail",query:{id:r.after_sale.id}})}` | `scopedSlots; else(e.$valIsNull(r.after_sale.id))` |
| `6012c/5ef01862` | `撤销申请` | `on.click → function(t){return e.revoke(r)}` | `scopedSlots; else(e.$valIsNull(r.after_sale.id)\|\|"Cancelled"==r.after_sale.status)` |
| `6012c/5ef01862` | `评价` | `on.click → function(t){return e.handleIsEvaluation(r)}` | `scopedSlots; else(1!=r.sign_for_status\|\|r.evaluation_id)` |
| `6012c/5ef01862` | `取消` | `on.click → function(t){e.DialogVisiable=!1}` | `无提取条件` |
| `6012c/5ef01862` | `确定` | `on.click → e.submitForm` | `无提取条件` |
| `6012c/5ef01862` | `确定` | `on.click → e.submitFormTwo` | `无提取条件` |
| `6012c/5ef01862` | `取消` | `on.click → function(t){e.DialogVisiableTwo=!1}` | `无提取条件` |
| `6012c/5ef01862` | `保存` | `on.click → function(t){return e.handleEvaluation("evaluateRef")}` | `无提取条件` |
| `6012c/5ef01862` | `取消` | `on.click → function(t){e.evaluationDialogVisible=!1}` | `无提取条件` |
| `6012c/06b441b3` | `e.showSearchArea?"收起搜索":"高级搜索"` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `6012c/06b441b3` | `搜索` | `on.click → e.handleSearch` | `e.showSearchArea` |
| `6012c/06b441b3` | `重置` | `on.click → e.handleDelete` | `e.showSearchArea` |
| `6012c/06b441b3` | `评价` | `on.click → function(t){return e.handleIsEvaluation(r)}` | `scopedSlots; else(1!=r.sign_for_status\|\|r.evaluation_id)` |
| `6012c/06b441b3` | `确 定` | `on.click → function(t){return e.handleEvaluation("evaluateRef")}` | `无提取条件` |
| `6012c/06b441b3` | `取 消` | `on.click → function(t){e.evaluationDialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5ef01862` / `getSearchStatus` | `未显式指定` `"agent/ordersearchpage"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5ef01862` / `revoke` | `"post"` `"agent/unaftersale"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `5ef01862` / `submitFormTwo` | `"post"` `"agent/aftersale"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `5ef01862` / `submitForm` | `"post"` `"agent/refund"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `5ef01862` / `getData` | `未显式指定` `"agent/order"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5ef01862` / `handleEvaluation` | `"POST"` `"agent/evaluation"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `06b441b3` / `getData` | `未显式指定` `"agent/renew"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `06b441b3` / `getRenewSearchData` | `未显式指定` `"agent/renewsearchpage"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `06b441b3` / `handleEvaluation` | `"POST"` `"agent/evaluation"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/order-detail",query:{id:r.local_id}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p217"></a>

## 资源池退款详情 `/refund-detail`

旧版证据：[P217](27-admin-built-page-evidence.md#p217)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“资源池退款详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `f844/cd79c540` | `el-form-item` | `账单号:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `产品名称/主机名:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `IP:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `卖家:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `买家:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `产品状态/订购时间:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `f844/cd79c540` | `el-form-item` | `金额/周期:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `cd79c540` / `getData` | `未显式指定` `"agent/refundDetail?id=".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p218"></a>

## 资源池售后详情 `/aftersale-detail`

旧版证据：[P218](27-admin-built-page-evidence.md#p218)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“资源池售后详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `0299/6dc3df5f` | `el-form-item` | `账单号:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `产品名称/主机名:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `IP:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `卖家:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `买家:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `产品状态/订购时间:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `0299/6dc3df5f` | `el-form-item` | `金额/周期:` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `6dc3df5f` / `getData` | `未显式指定` `"agent/afterSaleDetail?id=".concat(t)` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p219"></a>

## 资源池业务管理 `/business-management`

旧版证据：[P219](27-admin-built-page-evidence.md#p219)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池业务管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `1e1f/23d8385b` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1e1f/23d8385b` | `el-table-column` | `商品名称/主机名` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1e1f/23d8385b` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1e1f/23d8385b` | `el-table-column` | `店铺名称` / `shop_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1e1f/23d8385b` | `el-table-column` | `状态/订购时间` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `1e1f/23d8385b` | `el-table-column` | `金额/周期` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `1e1f/23d8385b` | `搜索` | `on.click → t.getData` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `23d8385b` / `getData` | `未显式指定` `"agent/host"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:a.local_uid,hid:a.local_hostid}}`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p220"></a>

## 资源池任务队列 `/resourcePool-taskQueue`

旧版证据：[P220](27-admin-built-page-evidence.md#p220)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“资源池任务队列”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `49b0/10837ee4` | `el-table-column` | `客户 ($lang.client)` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `产品 ($lang.product)` / `domain` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `动作 ($lang.motion)` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `来源 ($lang.source)` / `from_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `状态 ($lang.state)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `最后操作时间 ($lang.last_operating_time)` / `last_execute_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `49b0/10837ee4` | `el-table-column` | `操作 ($lang.operation)` / `credit` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `49b0/10837ee4` | `搜索 ($lang.search)` | `on.click → t.searchClick` | `无提取条件` |
| `49b0/10837ee4` | `e.row.user` | `on.click → function(n){return t.goToView(e.row.user_id)}` | `scopedSlots` |
| `49b0/10837ee4` | `r.domain` | `on.click → function(e){return t.goToProduct(r.user_id,r.host_id)}` | `scopedSlots` |
| `49b0/10837ee4` | `重试 ($lang.tautology)` | `on.click → function(n){return t.handleClick(e.row)}` | `scopedSlots; 0===e.row.status` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `10837ee4` / `handleClick` | `"post"` `"run_map/repeat_task"` (data) | `POST {A}/run_map/repeat_task` → `admin/RunMap/repeatTask`；规则 `app\admin\controller\RunMapcontroller::repeattask`；[源行](../../data/route/admin.php#L849) | 未提取；新设计明确成功后重读受影响对象 |
| `10837ee4` / `getData` | `"get"` `"agent/runmaplists"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `formType`、`activeType` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.row.user_id}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:r.user_id,hid:r.host_id,fa:"productList"}}`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p221"></a>

## 资源池工单 `/resourcePool-workOrder`

旧版证据：[P221](27-admin-built-page-evidence.md#p221)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池工单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `422c/-` | `el-form-item` | `客户 ($lang.client)` / `uid` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `部门 ($lang.department)` / `dptid` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `优先级 ($lang.priority)` / `priority` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `工单标题/内容 ($lang.work_order_title_content)` / `content` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `工单编号 ($lang.work_order_num)` / `tid` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-form-item` | `" "` / `-` / `-` | `t.searchWarpper` | 分组表单；未知原值不置空 |
| `422c/-` | `el-table-column` | `id` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `主题` / `title` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `提交人` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `处理人` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `状态` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `提交时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `422c/-` | `el-table-column` | `上次回复` / `last_reply_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `422c/-` | `新建工单 ($lang.new_work_order)` | `on.click → t.newTicketHandleClick` | `无提取条件` |
| `422c/-` | `t.searchWarpper?t.$lang.pack_up_the_search:t.$lang.advanced_search` | `on.click → function(e){t.searchWarpper=!t.searchWarpper}` | `无提取条件` |
| `422c/-` | `查询 ($lang.demand)` | `on.click → t.searchHandleClick` | `t.searchWarpper` |
| `422c/-` | `清空 ($lang.empty)` | `on.click → t.resetHandleClick` | `t.searchWarpper` |
| `422c/-` | `e.row.tid` | `on.click → function(n){return t.toDetail(e.row.id,e.row.tid)}` | `scopedSlots` |
| `422c/-` | `e.row.user_name` | `on.click → function(n){return t.goToView(e.row.uid)}` | `scopedSlots; else(0===e.row.uid)` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getList` | `"get"` `"agent/tickets"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `getDepartmentData` | `未显式指定` `"getTicketDepartment"` (无显式 data/params) | `GET {A}/getTicketDepartment` → `admin/Public/getTicketDepartment`；规则 `app\admin\controller\Publiccontroller::getticketdepartment`；[源行](../../data/route/admin.php#L118) | 未提取；新设计明确成功后重读受影响对象 |
| `-` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/support-ticket-detail",query:{id:e.row.id,tid:e.row.tid}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.row.uid}}`
- 旧跳转：`toDetail: this.$router.push({path:"/support-ticket-detail",query:{id:t,tid:e}})`
- 旧跳转：`newTicketHandleClick: this.$router.push("/add-support-ticket")`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p222"></a>

## 资源池设置 `/resourcePool-set`

旧版证据：[P222](27-admin-built-page-evidence.md#p222)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“资源池设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `5228/5f26eb44` | `el-tab-pane` | `登录信息` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `5228/5f26eb44` | `el-form-item` | `账号` / `username` / `-` | `"first"==t.activeName` | 分组表单；未知原值不置空 |
| `5228/5f26eb44` | `el-form-item` | `资源池连接密钥` / `password` / `-` | `"first"==t.activeName` | 分组表单；未知原值不置空 |
| `5228/5f26eb44` | `el-form-item` | `""` / `-` / `-` | `"first"==t.activeName` | 分组表单；未知原值不置空 |
| `5228/5f26eb44` | `el-tab-pane` | `工单传递` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `5228/5f26eb44` | `el-form-item` | `工单传递：` / `-` / `-` | `"third"==t.activeName` | 分组表单；未知原值不置空 |
| `5228/5f26eb44` | `el-switch` | `-` / `-` / `-` | `"third"==t.activeName` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `5228/5f26eb44` | `保存` | `on.click → t.testUrl` | `"first"==t.activeName` |
| `5228/5f26eb44` | `图标/动态文案，回查原证据` | `on.change → t.changeOpen` | `"third"==t.activeName` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `5f26eb44` / `changeOpen` | `"post"` `"agent/resourceticketopen"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5f26eb44` / `getData` | `"get"` `"agent/resourceinfo"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5f26eb44` / `testUrl` | `"post"` `"agent/resourceinfo"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `5f26eb44` / `testUrl` | `"post"` `"agent/linktoresource"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p223"></a>

## 资源池统计 `/statistical-information`

旧版证据：[P223](27-admin-built-page-evidence.md#p223)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、统计口径与时间/币种筛选 → 服务端指标 → 图表 → 可核对的数据表。图表与明细使用同一筛选，不在前端混合币种或猜测指标。

**手机排版**：筛选 → 指标纵向或两列 → 图表 → 明细；图表图例可换行，宽明细仅在内部滚动。

**本页专项约束**：围绕“资源池统计”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `167c/-` | `el-tab-pane` | `信息概览` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |
| `167c/-` | `el-tab-pane` | `收入概览` / `-` / `-` | `无提取条件` | 主区导航；保留对象与选中项 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `54d29c10` / `getList` | `"get"` `"agent/consumption"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `54d29c10` / `getData` | `"get"` `"agent/baseinfo"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`toDetailPage: this.$router.push({path:"/bill-detail",query:{id:t,uid:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p224"></a>

## 资源池商品管理 `/commodity-management`

旧版证据：[P224](27-admin-built-page-evidence.md#p224)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池商品管理”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `29d6/38b9b688` | `el-table-column` | `商品名称 ($lang.commodity_name)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `定价 ($lang.pricing)` / `billingcycle_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `供应商库存 ($lang.inventory_local_upstream)` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `已开通/总数量 ($lang.available_total_quantity)` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `供应商 ($lang.supplier)` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `成本` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `售价` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `利润 ($lang.profit)` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `操作 ($lang.operation)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-dialog` | `-` / `-` / `代理商品信息` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `29d6/38b9b688` | `el-table-column` | `店铺名称` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `商品名称` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `利润比例（%）` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-table-column` | `本地名称` / `list` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `29d6/38b9b688` | `el-dialog` | `-` / `-` / `新增分组` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `29d6/38b9b688` | `el-form-item` | `分组类型` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `一级分组` / `gid` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `商品组名称` / `name` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `商品组标题` / `headline` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `商品组标语` / `tagline` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `访问别名` / `bm` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `订购表模板` / `-` / `-` | `"1"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `""` / `order_frm_tpl` / `-` | `"1"===t.createType; "custom"===t.addGroupForm.tpl_type` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `分组组名称` / `name` / `-` | `"2"===t.createType` | 分组表单；未知原值不置空 |
| `29d6/38b9b688` | `el-form-item` | `是否隐藏` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `29d6/38b9b688` | `新增分组` | `on.click → function(e){t.addGroupDialogVisible=!t.addGroupDialogVisible}` | `无提取条件` |
| `29d6/38b9b688` | `代理商品` | `on.click → function(e){return t.$router.push("resource-pool-shop")}` | `无提取条件` |
| `29d6/38b9b688` | `搜索` | `on.click → t.getData` | `无提取条件` |
| `29d6/38b9b688` | `删除 ($lang.delete)` | `on.click → function(e){return t.deleteProduct(n.id)}` | `scopedSlots; else(n.groups\|\|n.products)` |
| `29d6/38b9b688` | `取消` | `on.click → function(e){t.DialogVisiable=!1}` | `无提取条件` |
| `29d6/38b9b688` | `确定` | `on.click → t.submitForm` | `无提取条件` |
| `29d6/38b9b688` | `确定` | `on.click → function(e){return t.addGroupSubmit("addGroupFormRef")}` | `无提取条件` |
| `29d6/38b9b688` | `取消` | `on.click → function(e){t.addGroupDialogVisible=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `38b9b688` / `getGroupDialogData` | `未显式指定` `"edit_product_group_page"` (params) | `GET {A}/edit_product_group_page` → `admin/product/editGroupPage`；规则 `app\admin\controller\Productcontroller::editgrouppage`；[源行](../../data/route/admin.php#L415) | 未提取；新设计明确成功后重读受影响对象 |
| `38b9b688` / `bmVerify` | `"post"` `"check_product_as"` (data) | `POST {A}/check_product_as` → `admin/product/checkAlias`；规则 `app\admin\controller\Productcontroller::checkalias`；[源行](../../data/route/admin.php#L417) | 未提取；新设计明确成功后重读受影响对象 |
| `38b9b688` / `addGroupSubmit` | `"post"` `"save_product_group"` (data) | `POST {A}/save_product_group` → `admin/product/saveProductGroup`；规则 `app\admin\controller\Productcontroller::saveproductgroup`；[源行](../../data/route/admin.php#L416) | `getlist` |
| `38b9b688` / `addGroupSubmit` | `"post"` `"save_product_first_group"` (data) | `POST {A}/save_product_first_group` → `admin/product/saveProductFirstGroup`；规则 `app\admin\controller\Productcontroller::saveproductfirstgroup`；[源行](../../data/route/admin.php#L414) | `getlist` |
| `38b9b688` / `getlist` | `未显式指定` `"agent/products"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `38b9b688` / `deleteProduct` | `未显式指定` `"del_product"` (params) | `GET {A}/del_product` → `admin/product/delete`；规则 `app\admin\controller\Productcontroller::delete`；[源行](../../data/route/admin.php#L418) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/edit-product",query:{id:n.id,prePage:n.type}}`
- 旧跳转：`submitForm: this.$router.push({path:this.$route.path})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p225"></a>

## 资源池协助审核 `/ssistant-audit`

旧版证据：[P225](27-admin-built-page-evidence.md#p225)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池协助审核”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7e95/-` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7e95/-` | `el-table-column` | `买家` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7e95/-` | `el-table-column` | `IP` / `assignedips` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7e95/-` | `el-table-column` | `提交时间` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7e95/-` | `el-table-column` | `状态` / `status_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7e95/-` | `el-table-column` | `管理` / `active_type` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7e95/-` | `协查申请` | `on.click → t.assistApply` | `无提取条件` |
| `7e95/-` | `搜索` | `on.click → t.getData` | `无提取条件` |
| `7e95/-` | `查看` | `on.click → function(e){return t.toDetail(a.id)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `-` / `getData` | `未显式指定` `"agent/inspectionlists"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`assistApply: this.$router.push({path:"/assist-apply"})`
- 旧跳转：`toDetail: this.$router.push({path:"/assist-detail",query:{id:t}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p226"></a>

## 资源池协助申请 `/assist-apply`

旧版证据：[P226](27-admin-built-page-evidence.md#p226)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“资源池协助申请”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `2634/01cc5c59` | `el-form-item` | `警官姓名：` / `police` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-form-item` | `执法机构：` / `agency` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-form-item` | `调取IP：` / `ip` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-form-item` | `邮件地址：` / `email` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-form-item` | `联系电话：` / `phone` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-form-item` | `警官证：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `2634/01cc5c59` | `el-form-item` | `法律文书：` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `2634/01cc5c59` | `el-upload` | `-` / `-` / `-` | `无提取条件` | 对应字段组；上传结果与业务保存分开 |
| `2634/01cc5c59` | `el-dialog` | `-` / `-` / `提示` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `2634/01cc5c59` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2634/01cc5c59` | `el-table-column` | `订单号` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2634/01cc5c59` | `el-table-column` | `客户` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2634/01cc5c59` | `el-table-column` | `IP` / `assignedips` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2634/01cc5c59` | `el-table-column` | `订购时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `2634/01cc5c59` | `el-table-column` | `订单状态` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `2634/01cc5c59` | `提交` | `on.click → t.submit` | `无提取条件` |
| `2634/01cc5c59` | `返回` | `on.click → t.goBack` | `无提取条件` |
| `2634/01cc5c59` | `重置` | `on.click → t.reset` | `无提取条件` |
| `2634/01cc5c59` | `取消` | `on.click → function(e){t.DialogVisiable=!1}` | `无提取条件` |
| `2634/01cc5c59` | `确定` | `on.click → function(e){t.DialogVisiable=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `01cc5c59` / `inputBlur` | `未显式指定` `"agent/inspectionip"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |
| `01cc5c59` / `submit` | `"post"` `"agent/resourceinspection"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`submit: t.$router.go(-1)`
- 旧跳转：`goBack: this.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p227"></a>

## 资源池协助详情 `/assist-detail`

旧版证据：[P227](27-admin-built-page-evidence.md#p227)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“资源池协助详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `b8b5/1a9a77de` | `el-table-column` | `订单号` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `产品` / `buy` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `产品类型` / `type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `IP` / `dedicatedip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `订单状态/退款进度` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `订购时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `订单类型` / `invoice_type_zh` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `金额/周期` / `time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `付款方式` / `payment` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `描述` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `来源` / `orgin` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `用户名` / `user` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `b8b5/1a9a77de` | `el-table-column` | `IP地址` / `ipaddr` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `1a9a77de` / `getData` | `未显式指定` `"agent/inspectiondetail"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`back: this.$router.back()`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p228"></a>

## 资源池商店 `/resource-pool-shop`

旧版证据：[P228](27-admin-built-page-evidence.md#p228)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“资源池商店”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

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
| `3cad4e2e` / `生命周期:created` | `未显式指定` `"agent/token"` (无显式 data/params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p229"></a>

## 资源池日志 `/resourcePool-logs`

旧版证据：[P229](27-admin-built-page-evidence.md#p229)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与对象范围 → 时间/类型等已有筛选 → 日志表 → 分页；长正文点击展开，凭据脱敏，失败原因贴近对应行。清理/重发必须有独立接口依据。

**手机排版**：按时间、动作、结果逐项显示，正文折叠；技术字段可横向滚动，但时间/状态和返回入口始终可读。

**本页专项约束**：围绕“资源池日志”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `7903/18027a1e` | `el-form-item` | `时间` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7903/18027a1e` | `el-form-item` | `描述` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7903/18027a1e` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `7903/18027a1e` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `时间` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `描述` / `desc` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `来源` / `referer` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `用户名` / `active_name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `用户角色` / `user_type_cn` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `7903/18027a1e` | `el-table-column` | `IP地址` / `ip` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `7903/18027a1e` | `搜索` | `on.click → function(e){return t.getData()}` | `无提取条件` |
| `7903/18027a1e` | `清空` | `on.click → t.handleReset` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `18027a1e` / `getData` | `未显式指定` `"agent/agentLogs"` (params) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
