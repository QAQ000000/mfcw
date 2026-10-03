# 订单与代下单逐页设计契约

本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。

[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)

| 页面 | 版式 | 静态归属 |
| --- | --- | --- |
| [商品订购设置](#p024) `/order-product` | `form` | 路由 factory 指向模块 |
| [订单列表](#p062) `/order-list` | `list` | 路由 factory 指向模块 |
| [新增订单](#p063) `/add-order` | `wizard` | 路由 factory 指向模块 |
| [订单详情](#p064) `/order-detail` | `detail` | 路由 factory 指向模块 |
| [续费订单](#p065) `/renewal-order` | `list` | 路由 factory 指向模块 |
| [供应商续费订单](#p066) `/supplier-renewal-order` | `list` | 路由 factory 指向模块 |
| [供应商订单](#p170) `/supplier-order-list` | `list` | 路由 factory 指向模块 |

<a id="p024"></a>

## 商品订购设置 `/order-product`

旧版证据：[P024](27-admin-built-page-evidence.md#p024)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题、返回与对象范围 → 按已有字段语义分组的表单 → 保存/取消区。标签在上，常规字段两至三列、最长文本整行；参数元数据未加载时保留原值并阻止误提交。

**手机排版**：全部字段单列；控件44px，保存区为正文末尾或预留高度的固定底栏；键盘及错误提示不得被遮挡。

**本页专项约束**：围绕“商品订购设置”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `68d0/241daf87` | `el-form-item` | `购买时强制手机绑定 ($lang.phone_binding)` / `custom_invoice_id_start` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `68d0/241daf87` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `68d0/241daf87` | `el-form-item` | `购买时强制实名认证 ($lang.compulsory_real_name_authentication)` / `certifi_isrealname` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `68d0/241daf87` | `el-switch` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `68d0/241daf87` | `保存更改 ($lang.save_the_changes)` | `on.click → t.submitForm` | `无提取条件` |
| `68d0/241daf87` | `取消更改 ($lang.cancel_changes)` | `on.click → t.resetForm` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `241daf87` / `submitForm` | `"post"` `"config_general/newGeneral"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | `getData` |
| `241daf87` / `getData` | `"post"` `"config_general/getConfig"` (data) | 无静态匹配；核对隐式/trait/插件路由，不猜方法或权限 | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p062"></a>

## 订单列表 `/order-list`

旧版证据：[P062](27-admin-built-page-evidence.md#p062)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“订单列表”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `4707/bff68e4a` | `el-tab-pane` | `e.label` / `-` / `-` | `循环 e.typeOptions` | 主区导航；保留对象与选中项 |
| `4707/bff68e4a` | `el-form-item` | `订单ID ($lang.order_id)` / `id` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `客户 ($lang.client)` / `username` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `销售 ($lang.sell)` / `sale_id` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `付款状态 ($lang.payment_status)` / `pay_status` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `时间 ($lang.time)` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `付款方式 ($lang.payment_term)` / `payment` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `4707/bff68e4a` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `产品 ($lang.product)` / `hosts` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `IP` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `下单时间 ($lang.place_order_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `付款状态/付款方式 ($lang.payment_status_method)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `客户备注 ($lang.customer_remarks)` / `order_notes` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `4707/bff68e4a` | `el-table-column` | `提成/销售 ($lang.commission_sales)` / `sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `4707/bff68e4a` | `帮助文档 ($lang.help_document)` | `on.click → e.openDoc` | `无提取条件` |
| `4707/bff68e4a` | `添加新订单` | `on.click → e.creatOrderHandleClick` | `无提取条件` |
| `4707/bff68e4a` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `4707/bff68e4a` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `e.showSearchArea` |
| `4707/bff68e4a` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `4707/bff68e4a` | `t.row.id` | `on.click → function(a){return e.toDetailPage(t.row.id)}` | `scopedSlots` |
| `4707/bff68e4a` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots; t.row.notes` |
| `4707/bff68e4a` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots; else(t.row.notes)` |
| `4707/bff68e4a` | `核验通过` | `on.click → e.examPassHandleClick` | `无提取条件` |
| `4707/bff68e4a` | `取消订单` | `on.click → e.cancelOrderHandleClick` | `无提取条件` |
| `4707/bff68e4a` | `删除订单` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `bff68e4a` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `bff68e4a` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `bff68e4a` / `getSum` | `"post"` `"order/order_commission"` (data) | `POST {A}/order/order_commission` → `admin/order/indexPost`；规则 `app\admin\controller\Ordercontroller::indexpost`；[源行](../../data/route/admin.php#L516) | 未提取；新设计明确成功后重读受影响对象 |
| `bff68e4a` / `getAdSum` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `bff68e4a` / `orderSearchPage` | `未显式指定` `"order/search_page"` (params) | `GET {A}/order/search_page` → `admin/order/searchPage`；规则 `app\admin\controller\Ordercontroller::searchpage`；[源行](../../data/route/admin.php#L514) | 未提取；新设计明确成功后重读受影响对象 |
| `bff68e4a` / `getData` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | `getAdSum`、`getSum` |
| `bff68e4a` / `getData` | `未显式指定` `"order/search"` (params) | `GET {A}/order/search` → `admin/order/index`；规则 `app\admin\controller\Ordercontroller::index`；[源行](../../data/route/admin.php#L515) | `getAdSum`、`getSum` |
| `bff68e4a` / `examPassHandleClick` | `未显式指定` `"order/check"` (params) | `GET {A}/order/check` → `admin/order/check`；规则 `app\admin\controller\Ordercontroller::check`；[源行](../../data/route/admin.php#L518) | `getData` |
| `bff68e4a` / `cancelOrderHandleClick` | `未显式指定` `"order/cancel"` (params) | `GET {A}/order/cancel` → `admin/order/cancel`；规则 `app\admin\controller\Ordercontroller::cancel`；[源行](../../data/route/admin.php#L519) | `getData` |
| `bff68e4a` / `deleteOrderHandleClick` | `"delete"` `"orders/delete"` (params) | `DELETE {A}/orders/delete` → `admin/order/delete`；规则 `app\admin\controller\Ordercontroller::delete`；[源行](../../data/route/admin.php#L520) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/order-detail",query:{id:t.row.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:a.uid,hid:a.hostid,fa:"product-list"}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:t.row.hosts[0].uid,hid:t.row.hosts.length?t.row.hosts[0].hostid:"",fa:"productList"}}`
- 旧跳转：`adSearch: t.$router.replace({query:o})`
- 旧跳转：`creatOrderHandleClick: this.$router.push("/add-order")`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`toDetailPage: this.$router.push({path:"/order-detail",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p063"></a>

## 新增订单 `/add-order`

旧版证据：[P063](27-admin-built-page-evidence.md#p063)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与返回 → 步骤/进度 → 当前步骤输入 → 当前对象/金额摘要 → 上一步/下一步/最终确认。只按已有流程划分步骤，禁止在切换步骤时隐式提交业务。

**手机排版**：步骤缩为当前位置，内容单列，摘要紧靠最终确认；重复点击不产生重复请求。

**本页专项约束**：先选客户/币种，再选商品与配置，服务端报价后确认；预存余额、信用额、账单与订单ID分开，失败后核对已生成对象，不自动重复下单。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `a673/646ecb1a` | `el-form-item` | `客户 ($lang.client)` / `uid` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `支付方式 ($lang.payment_mode)` / `payment` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `优惠码 ($lang.promotion_code)` / `promo_code` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `""` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `产品/服务 ($lang.product_service)` / `"pid["+t.id+"+]"` / `-` | `循环 e.productArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `付款周期 ($lang.payment_period)` / `"cycle["+t.id+"+]"` / `-` | `循环 e.productArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `数量 ($lang.amount)` / `""` / `-` | `循环 e.productArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `内部价格(首次) ($lang.inside_price_first)` / `""` / `-` | `循环 e.productArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `内部价格(续费) ($lang.inside_price_renew)` / `""` / `-` | `循环 e.productArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `o.option_name` / `-` / `-` | `循环 e.productArr; 循环 t.optionArr; 20!=o.option_type` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `o.option_name` / `-` / `-` | `循环 e.productArr; 循环 t.optionArr; 20===o.option_type` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `o.option_name` / `-` / `-` | `循环 e.productArr; 循环 t.optionArr; 20===o.option_type; 循环 o.son` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `t.fieldname` / `-` / `-` | `循环 e.productArr; 循环 t.customFieldsArr` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `魔方DCIM操作系统 ($lang.dcim_operating_system)` / `-` / `-` | `循环 e.productArr; t.dcimOsOptions.length` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `-` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-dialog` | `-` / `-` / `添加优惠码 ($lang.add_promotion_code)` | `无提取条件` | 独立弹层；加载/校验/关闭保留草稿 |
| `a673/646ecb1a` | `el-form-item` | `优惠码 ($lang.promotion_code)` / `code` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `类型 ($lang.type)` / `type` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `价值 ($lang.value)` / `value` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `循环优惠 ($lang.circulation_favorable)` / `recurring` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `a673/646ecb1a` | `el-form-item` | `-` / `""` / `-` | `无提取条件` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `a673/646ecb1a` | `添加优惠码` | `on.click → function(t){e.promo_codeDialogVisiable=!0}` | `无提取条件` |
| `a673/646ecb1a` | `添加其他产品 ($lang.add_other_products)` | `on.click → e.addOtherProduct` | `无提取条件` |
| `a673/646ecb1a` | `提交订单 ($lang.sub_order)` | `on.click → e.submitOrder` | `无提取条件` |
| `a673/646ecb1a` | `点此自动生成优惠码 ($lang.create_promotion_code)` | `on.click → function(t){return e.randomPromo(8)}` | `无提取条件` |
| `a673/646ecb1a` | `确定 ($lang.confirm)` | `on.click → e.sureHandleClick` | `无提取条件` |
| `a673/646ecb1a` | `取消 ($lang.cancel)` | `on.click → function(t){e.promo_codeDialogVisiable=!1}` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `646ecb1a` / `getLinkAgeListTwo` | `未显式指定` `"adminGetLinkAgeList"` (params) | `GET {A}/adminGetLinkAgeList` → `admin/clients_services/adminGetLinkAgeList`；规则 `app\admin\controller\ClientsServicescontroller::admingetlinkagelist`；[源行](../../data/route/admin.php#L612) | `orderGetTotal` |
| `646ecb1a` / `getLinkAgeList` | `未显式指定` `"adminGetLinkAgeList"` (params) | `GET {A}/adminGetLinkAgeList` → `admin/clients_services/adminGetLinkAgeList`；规则 `app\admin\controller\ClientsServicescontroller::admingetlinkagelist`；[源行](../../data/route/admin.php#L612) | `orderGetTotal` |
| `646ecb1a` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `getOrderCreatePageInfo` | `未显式指定` `"order/create_page"` (params) | `GET {A}/order/create_page` → `admin/order/createPage`；规则 `app\admin\controller\Ordercontroller::createpage`；[源行](../../data/route/admin.php#L521) | `orderGetTotal` |
| `646ecb1a` / `promoCodePage` | `未显式指定` `"order/promo_code_page"` (无显式 data/params) | `GET {A}/order/promo_code_page` → `admin/Order/customPromoPage`；规则 `app\admin\controller\Ordercontroller::custompromopage`；[源行](../../data/route/admin.php#L531) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `getPromo` | `未显式指定` `"auto_promo_code"` (无显式 data/params) | `GET {A}/auto_promo_code` → `admin/promo_code/autoPromoCode`；规则 `app\admin\controller\PromoCodecontroller::autopromocode`；[源行](../../data/route/admin.php#L452) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `sureHandleClick` | `"post"` `"order/save_promo_code"` (data) | `POST {A}/order/save_promo_code` → `admin/Order/customPromo`；规则 `app\admin\controller\Ordercontroller::custompromo`；[源行](../../data/route/admin.php#L532) | `getOrderCreatePageInfo`、`orderGetTotal` |
| `646ecb1a` / `productSelectChange` | `未显式指定` `"orders/set_config"` (params) | `GET {A}/orders/set_config` → `admin/Order/setConfig`；规则 `app\admin\controller\Ordercontroller::setconfig`；[源行](../../data/route/admin.php#L524) | `getOrderCreatePageInfo`、`dcimSelectChange` |
| `646ecb1a` / `orderGetTotal` | `"post"` `"get_total"` (data) | `POST {A}/get_total` → `admin/Order/getMultiTotal`；规则 `app\admin\controller\Ordercontroller::getmultitotal`；[源行](../../data/route/admin.php#L526) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `submitOrder` | `"post"` `"order/create"` (data) | `POST {A}/order/create` → `admin/order/save`；规则 `app\admin\controller\Ordercontroller::save`；[源行](../../data/route/admin.php#L523) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `getGetways` | `未显式指定` `"common/get_getways"` (无显式 data/params) | `GET {A}/common/get_getways` → `admin/common/getGetways`；规则 `app\admin\controller\Commoncontroller::getgetways`；[源行](../../data/route/admin.php#L95) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `getPromoList` | `未显式指定` `"common/get_promo_code"` (params) | `GET {A}/common/get_promo_code` → `admin/common/getPromoCode`；规则 `app\admin\controller\Commoncontroller::getpromocode`；[源行](../../data/route/admin.php#L99) | 未提取；新设计明确成功后重读受影响对象 |
| `646ecb1a` / `getProductList` | `未显式指定` `"common/get_product_list"` (params) | `GET {A}/common/get_product_list` → `admin/common/getProductList`；规则 `app\admin\controller\Commoncontroller::getproductlist`；[源行](../../data/route/admin.php#L98) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/payment-interface"}`
- 旧跳转：`render router-link: {path:"product-server"}`
- 旧跳转：`getOrderCreatePageInfo: o.$router.go(-1)`
- 旧跳转：`submitOrder: e.$router.push({path:"order-detail",query:{id:a.data.orderid}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p064"></a>

## 订单详情 `/order-detail`

旧版证据：[P064](27-admin-built-page-evidence.md#p064)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：返回列表和对象标识 → 状态/金额等摘要 → 已有标签或分区内容 → 操作记录。主内容与320px摘要栏分列；操作针对当前对象，保留子页上下文。

**手机排版**：摘要 → 主要操作 → 标签/分区 → 记录；次要摘要移至正文，不把桌面侧栏留在手机。

**本页专项约束**：围绕“订单详情”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `6c3c/b808318a` | `el-form-item` | `客户 ($lang.client)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `订单号 ($lang.order_mark)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `时间 ($lang.time)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `优惠码 ($lang.promotion_code)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `IP地址 ($lang.ip_address)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `账单信息 ($lang.billing_info)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `付款方式 ($lang.payment_term)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `金额 ($lang.sum)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `客户备注 ($lang.customer_remarks)` / `-` / `-` | `无提取条件` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `条目 ($lang.clauses_subclauses)` / `name` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `描述 ($lang.describe)` / `description` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `付款周期 ($lang.payment_period)` / `billingcycle` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `状态 ($lang.state)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `付款状态 ($lang.payment_status)` / `invoice_id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-table-column` | `操作 ($lang.operation)` / `""` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `6c3c/b808318a` | `el-form-item` | `-` / `-` / `-` | `scopedSlots; 0===a.serverid` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `服务器:` / `-` / `-` | `scopedSlots; else(0===a.serverid)` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `-` / `-` / `-` | `scopedSlots; else(0===a.serverid)` | 分组表单；未知原值不置空 |
| `6c3c/b808318a` | `el-form-item` | `-` / `-` / `-` | `scopedSlots; else(0===a.serverid)` | 分组表单；未知原值不置空 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `6c3c/b808318a` | `e.orderDetail.username` | `on.click → function(t){return e.toCustomerDetail(e.orderDetail.uid)}` | `无提取条件` |
| `6c3c/b808318a` | `e.orderDetail.invoiceid_zh` | `on.click → function(t){return e.toBillDetail(e.orderDetail.invoiceid,e.orderDetail.uid)}` | `e.orderDetail.invoiceid` |
| `6c3c/b808318a` | `t.row.name` | `on.click → function(r){return e.toProductDetail(t.row.id)}` | `scopedSlots` |
| `6c3c/b808318a` | `核验通过 ($lang.check_by)` | `on.click → e.examPassHandleClick` | `无提取条件` |
| `6c3c/b808318a` | `取消订单 ($lang.cancellation_order)` | `on.click → e.cancelOrderHandleClick` | `无提取条件` |
| `6c3c/b808318a` | `删除订单 ($lang.delete_order)` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `b808318a` / `getOrderDetail` | `未显式指定` `"orders/"+e` (无显式 data/params) | `DELETE {A}/orders/delete` → `admin/order/delete`；规则 `app\admin\controller\Ordercontroller::delete`；[源行](../../data/route/admin.php#L520)<br>`GET {A}/orders/set_config` → `admin/Order/setConfig`；规则 `app\admin\controller\Ordercontroller::setconfig`；[源行](../../data/route/admin.php#L524)<br>`GET {A}/orders/:id` → `admin/Order/read`；规则 `app\admin\controller\Ordercontroller::read`；[源行](../../data/route/admin.php#L527)<br>`POST {A}/orders/notes` → `admin/Order/notes`；规则 `app\admin\controller\Ordercontroller::notes`；[源行](../../data/route/admin.php#L528)<br>`POST {A}/orders/active` → `admin/Order/active`；规则 `app\admin\controller\Ordercontroller::active`；[源行](../../data/route/admin.php#L529)<br>`POST {A}/orders/change_status` → `admin/Order/changeStatus`；规则 `app\admin\controller\Ordercontroller::changestatus`；[源行](../../data/route/admin.php#L530) | 未提取；新设计明确成功后重读受影响对象 |
| `b808318a` / `changeStatus` | `"post"` `"orders/change_status"` (data) | `POST {A}/orders/change_status` → `admin/Order/changeStatus`；规则 `app\admin\controller\Ordercontroller::changestatus`；[源行](../../data/route/admin.php#L530) | `getOrderDetail` |
| `b808318a` / `examPassHandleClick` | `"post"` `"orders/active"` (data) | `POST {A}/orders/active` → `admin/Order/active`；规则 `app\admin\controller\Ordercontroller::active`；[源行](../../data/route/admin.php#L529) | `getOrderDetail` |
| `b808318a` / `cancelOrderHandleClick` | `未显式指定` `"order/cancel"` (params) | `GET {A}/order/cancel` → `admin/order/cancel`；规则 `app\admin\controller\Ordercontroller::cancel`；[源行](../../data/route/admin.php#L519) | `getOrderDetail` |
| `b808318a` / `deleteOrderHandleClick` | `"delete"` `"orders/delete"` (params) | `DELETE {A}/orders/delete` → `admin/order/delete`；规则 `app\admin\controller\Ordercontroller::delete`；[源行](../../data/route/admin.php#L520) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:e.orderDetail.uid}}`
- 旧跳转：`render router-link: {path:"/bill-detail",query:{id:e.orderDetail.invoiceid,uid:e.orderDetail.uid}}`
- 旧跳转：`render router-link: {path:"/customer-view/product-innerpage",query:{id:e.orderDetail.uid,hid:t.row.id}}`
- 旧跳转：`toBillDetail: this.$router.push({path:"/bill-detail",query:{id:e,uid:t}})`
- 旧跳转：`toCustomerDetail: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`toProductDetail: this.$router.push({path:"/customer-view/product-innerpage",query:{id:this.orderDetail.uid,hid:e}})`
- 旧跳转：`deleteOrderHandleClick: e.$router.go(-1)`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p065"></a>

## 续费订单 `/renewal-order`

旧版证据：[P065](27-admin-built-page-evidence.md#p065)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“续费订单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `d2a8/2b6a0bf7` | `el-form-item` | `客户 ($lang.client)` / `username` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `d2a8/2b6a0bf7` | `el-form-item` | `时间 ($lang.time)` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `d2a8/2b6a0bf7` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `d2a8/2b6a0bf7` | `el-form-item` | `付款方式 ($lang.payment_term)` / `payment` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `d2a8/2b6a0bf7` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `d2a8/2b6a0bf7` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `产品 ($lang.product)` / `hosts` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `IP` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `续费时间 ($lang.renewal_time)` / `paid_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `d2a8/2b6a0bf7` | `el-table-column` | `付款方式 ($lang.payment_term)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `d2a8/2b6a0bf7` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `d2a8/2b6a0bf7` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `e.showSearchArea` |
| `d2a8/2b6a0bf7` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `d2a8/2b6a0bf7` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `2b6a0bf7` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `2b6a0bf7` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `2b6a0bf7` / `orderSearchPage` | `未显式指定` `"order/search_page"` (params) | `GET {A}/order/search_page` → `admin/order/searchPage`；规则 `app\admin\controller\Ordercontroller::searchpage`；[源行](../../data/route/admin.php#L514) | 未提取；新设计明确成功后重读受影响对象 |
| `2b6a0bf7` / `getData` | `"get"` `"invoice/renew"` (params) | `GET {A}/invoice/renew` → `admin/invoice/renew`；规则 `app\admin\controller\Invoicecontroller::renew`；[源行](../../data/route/admin.php#L557) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:t.row.uid,hid:t.row.hostid}}`
- 旧跳转：`adSearch: t.$router.replace({query:o})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`toDetailPage: this.$router.push({path:"/order-detail",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p066"></a>

## 供应商续费订单 `/supplier-renewal-order`

旧版证据：[P066](27-admin-built-page-evidence.md#p066)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“供应商续费订单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `035f/066aab56` | `el-form-item` | `时间 ($lang.time)` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `035f/066aab56` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `035f/066aab56` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `产品 ($lang.product)` / `hosts` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `IP` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `续费时间 ($lang.renewal_time)` / `nextduedate` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `付款方式 ($lang.payment_term)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `035f/066aab56` | `el-table-column` | `成本 ($lang.cost)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `035f/066aab56` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `035f/066aab56` | `搜索` | `on.click → e.searchHandeClick` | `e.showSearchArea` |
| `035f/066aab56` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `035f/066aab56` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `066aab56` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `066aab56` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `066aab56` / `orderSearchPage` | `未显式指定` `"order/search_page"` (params) | `GET {A}/order/search_page` → `admin/order/searchPage`；规则 `app\admin\controller\Ordercontroller::searchpage`；[源行](../../data/route/admin.php#L514) | 未提取；新设计明确成功后重读受影响对象 |
| `066aab56` / `getData` | `"get"` `"zjmf_finance_api/renew"` (params) | `GET {A}/zjmf_finance_api/renew` → `admin/zjmfFinanceApi/getRenew`；规则 `app\admin\controller\ZjmfFinanceApicontroller::getrenew`；[源行](../../data/route/admin.php#L767) | 未提取；新设计明确成功后重读受影响对象 |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:t.row.uid,hid:t.row.hostid}}`
- 旧跳转：`adSearch: t.$router.replace({query:i})`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`toDetailPage: this.$router.push({path:"/order-detail",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。

<a id="p170"></a>

## 供应商订单 `/supplier-order-list`

旧版证据：[P170](27-admin-built-page-evidence.md#p170)；归属：路由 factory 指向模块。本节是新布局草案，仍需核对可见分支与接口响应。

**页面关系**：父容器 `/`；默认重定向 `-`；子页 无静态children。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。

**桌面排版**：标题与模块导航 → 已加载筛选字段 → 工具栏 → 数据表 → 分页。标题区只放有依据的页面操作，行操作保留在对应对象行；表格列按下文顺序映射，未知字段不擅自增加。

**手机排版**：筛选折叠为面板；主字段、状态、金额/时间在卡片优先显示，其余通过展开或表格自身横向滚动查看；禁止整页横向溢出。

**本页专项约束**：围绕“供应商订单”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。

### 区域、字段和对话框依据

下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。

| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |
| --- | --- | --- | --- | --- |
| `fb63/9febc440` | `el-tab-pane` | `e.label` / `-` / `-` | `循环 e.typeOptions` | 主区导航；保留对象与选中项 |
| `fb63/9febc440` | `el-form-item` | `订单ID ($lang.order_id)` / `id` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `客户 ($lang.client)` / `username` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `销售 ($lang.sell)` / `sale_id` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `付款状态 ($lang.payment_status)` / `pay_status` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `时间 ($lang.time)` / `time` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `状态 ($lang.state)` / `status` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `金额 ($lang.sum)` / `amount` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `付款方式 ($lang.payment_term)` / `payment` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-form-item` | `" "` / `-` / `-` | `e.showSearchArea` | 分组表单；未知原值不置空 |
| `fb63/9febc440` | `el-table-column` | `-` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `ID` / `id` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `客户名 ($lang.client_name)` / `username` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `产品 ($lang.product)` / `hosts` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `IP` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `下单时间 ($lang.place_order_time)` / `create_time` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `金额 ($lang.sum)` / `amount` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `付款状态/付款方式 ($lang.payment_status_method)` / `-` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `状态 ($lang.state)` / `status` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `客户备注 ($lang.customer_remarks)` / `order_notes` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |
| `fb63/9febc440` | `el-table-column` | `提成/销售 ($lang.commission_sales)` / `sum` / `-` | `无提取条件` | 主数据区；窄屏优先级按对象/状态/金额设置 |

### 按钮、可用条件和点击行为

以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。

| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |
| --- | --- | --- | --- |
| `fb63/9febc440` | `帮助文档 ($lang.help_document)` | `on.click → e.openDoc` | `无提取条件` |
| `fb63/9febc440` | `添加新订单 ($lang.add_new_order)` | `on.click → e.creatOrderHandleClick` | `无提取条件` |
| `fb63/9febc440` | `" "+e._s(e.showSearchArea?e.$lang.pack_up_the_search:e.$lang.advanced_search)+" "` | `on.click → function(t){e.showSearchArea=!e.showSearchArea}` | `无提取条件` |
| `fb63/9febc440` | `搜索 ($lang.search)` | `on.click → e.searchHandeClick` | `e.showSearchArea` |
| `fb63/9febc440` | `清空 ($lang.empty)` | `on.click → e.clearSearchHandleClick` | `e.showSearchArea` |
| `fb63/9febc440` | `t.row.id` | `on.click → function(a){return e.toDetailPage(t.row.id)}` | `scopedSlots` |
| `fb63/9febc440` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots; t.row.notes` |
| `fb63/9febc440` | `t.row.username` | `on.click → function(a){return e.goToView(t.row.uid)}` | `scopedSlots; else(t.row.notes)` |
| `fb63/9febc440` | `核验通过 ($lang.check_by)` | `on.click → e.examPassHandleClick` | `无提取条件` |
| `fb63/9febc440` | `取消订单 ($lang.cancellation_order)` | `on.click → e.cancelOrderHandleClick` | `无提取条件` |
| `fb63/9febc440` | `删除订单` | `on.click → e.deleteOrderHandleClick` | `无提取条件` |

### 方法、接口及结果确认

| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |
| --- | --- | --- | --- |
| `9febc440` / `adSearch` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `9febc440` / `querySearchAsync` | `未显式指定` `"order/getclients"` (params) | `GET {A}/order/getclients` → `admin/order/getClients`；规则 `app\admin\controller\Ordercontroller::getclients`；[源行](../../data/route/admin.php#L522) | 未提取；新设计明确成功后重读受影响对象 |
| `9febc440` / `getSum` | `"post"` `"zjmf_finance_api/order_commission"` (data) | `POST {A}/zjmf_finance_api/order_commission` → `admin/zjmfFinanceApi/apiOrderCom`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apiordercom`；[源行](../../data/route/admin.php#L766) | 未提取；新设计明确成功后重读受影响对象 |
| `9febc440` / `getAdSum` | `"post"` `"searchfornamelist"` (data) | `POST {A}/searchfornamelist` → `admin/index/searchfornameList`；规则 `app\admin\controller\Indexcontroller::searchfornamelist`；[源行](../../data/route/admin.php#L124) | 未提取；新设计明确成功后重读受影响对象 |
| `9febc440` / `orderSearchPage` | `未显式指定` `"order/search_page"` (params) | `GET {A}/order/search_page` → `admin/order/searchPage`；规则 `app\admin\controller\Ordercontroller::searchpage`；[源行](../../data/route/admin.php#L514) | 未提取；新设计明确成功后重读受影响对象 |
| `9febc440` / `getData` | `未显式指定` `"zjmf_finance_api/order"` (params) | `GET {A}/zjmf_finance_api/order` → `admin/zjmfFinanceApi/apiOrder`；规则 `app\admin\controller\ZjmfFinanceApicontroller::apiorder`；[源行](../../data/route/admin.php#L765) | `getSum` |
| `9febc440` / `examPassHandleClick` | `未显式指定` `"order/check"` (params) | `GET {A}/order/check` → `admin/order/check`；规则 `app\admin\controller\Ordercontroller::check`；[源行](../../data/route/admin.php#L518) | `getData` |
| `9febc440` / `cancelOrderHandleClick` | `未显式指定` `"order/cancel"` (params) | `GET {A}/order/cancel` → `admin/order/cancel`；规则 `app\admin\controller\Ordercontroller::cancel`；[源行](../../data/route/admin.php#L519) | `getData` |
| `9febc440` / `deleteOrderHandleClick` | `"delete"` `"orders/delete"` (params) | `DELETE {A}/orders/delete` → `admin/order/delete`；规则 `app\admin\controller\Ordercontroller::delete`；[源行](../../data/route/admin.php#L520) | `getData` |

PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。

### 跳转、反馈与验收

- 旧跳转：`render router-link: {path:"/order-detail",query:{id:t.row.id}}`
- 旧跳转：`render router-link: {path:"/customer-view/abstract",query:{id:t.row.uid}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:a.uid,hid:a.hostid,fa:"product-list"}}`
- 旧跳转：`render router-link: {name:"productInnerpage",query:{id:t.row.hosts[0].uid,hid:t.row.hosts.length?t.row.hosts[0].hostid:"",fa:"productList"}}`
- 旧跳转：`adSearch: t.$router.replace({query:o})`
- 旧跳转：`creatOrderHandleClick: this.$router.push("/add-order")`
- 旧跳转：`goToView: this.$router.push({path:"/customer-view/abstract",query:{id:e}})`
- 旧跳转：`toDetailPage: this.$router.push({path:"/order-detail",query:{id:e}})`
- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。
- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。
- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。
- 当前运行状态：NOT RUN；本节未新增浏览器验收。
