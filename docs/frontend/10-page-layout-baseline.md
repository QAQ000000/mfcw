# 逐页版式基线

本页记录主要前台模板与后台 PHP View* 入口的版式方案，不覆盖全部后台 Vue 页面或动态菜单。
它描述新模板的信息层级和操作区；首批尺寸见[组件规格](19-component-interaction-contract.md)，
文字线框见[实施样板](24-first-batch-page-specs.md)。尚未完成设计/业务核验的项目后续逐页冻结。

## 版式代码

| 代码 | 页面结构 |
| --- | --- |
| `PUBLIC` | 顶部导航 → 面包屑/标题 → 主内容 → 相关链接 → 页脚 |
| `AUTH` | Logo/品牌区 → 登录或注册表单 → 辅助入口 → 错误/验证提示 |
| `DASH` | 客户中心外壳 → 欢迎/摘要 → 统计卡片 → 待处理提醒 → 快捷入口 |
| `LIST` | 页面标题 → 筛选/搜索 → 工具栏 → 数据列表 → 分页/空态 |
| `DETAIL` | 返回和标题 → 状态摘要 → 详情分区 → 操作区 → 日志/关联数据 |
| `FORM` | 标题/说明 → 分组表单 → 校验提示 → 固定或底部提交栏 |
| `CHECKOUT` | 商品/配置主区 → 价格摘要 → 优惠/支付区 → 提交和结果 |
| `TIMELINE` | 标题/状态 → 时间线或消息流 → 回复/提交区 → 附件和操作 |
| `ADMIN-LIST` | 后台外壳 → 面包屑 → 筛选 → 表格/批量操作 → 分页 |
| `ADMIN-DETAIL` | 后台外壳 → 对象摘要 → 标签页/分组 → 保存或高风险操作 → 审计 |
| `ADMIN-DASH` | 后台外壳 → 统计卡片 → 趋势/告警 → 待处理队列 → 快捷入口 |

## 官网页面（34 个）

| 页面模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `index.html` | `PUBLIC` | 首屏、产品入口、卖点、公告/新闻、行动按钮；移动端首屏不溢出 |
| `about.html` | `PUBLIC` | 页面标题、公司介绍、能力/资质、联系入口 |
| `contact.html` | `PUBLIC` | 联系方式、地址/地图、表单或客服入口；提交结果可见 |
| `relation.html` | `PUBLIC` | 关联链接或合作信息、分组导航 |
| `map.html` | `PUBLIC` | 站点地图分组、产品和帮助入口 |
| `privacy.html` | `PUBLIC` | 法务标题、目录、长文本；移动端可读 |
| `tos.html` | `PUBLIC` | 服务条款标题、目录、长文本和更新时间 |
| `aup.html` | `PUBLIC` | 使用政策、限制条款、联系入口 |
| `safeguard.html` | `PUBLIC` | 安全能力、说明内容、相关服务入口 |
| `management.html` | `PUBLIC` | 管理/控制台能力介绍、产品入口 |
| `cloud.html` | `PUBLIC` | 云产品说明、特性、价格/购买入口 |
| `hosting.html` | `PUBLIC` | 主机产品说明、规格、购买入口 |
| `server.html` | `PUBLIC` | 服务器产品说明、规格、购买入口 |
| `dediserver.html` | `PUBLIC` | 独立服务器说明、规格、购买入口 |
| `colocation.html` | `PUBLIC` | 托管说明、资源和咨询入口 |
| `cdn.html` | `PUBLIC` | CDN 能力、节点/流量说明、购买入口 |
| `domain.html` | `PUBLIC` | 域名服务说明、查询/购买入口 |
| `ssl.html` | `PUBLIC` | SSL 产品说明、证书类型、购买入口 |
| `nat.html` | `PUBLIC` | NAT 产品说明、规格、购买入口 |
| `antiddos.html` | `PUBLIC` | 防护能力、规格和咨询/购买入口 |
| `transfer.html` | `PUBLIC` | 迁移服务说明、流程和咨询入口 |
| `news.html` | `LIST` | 新闻精选/分类入口、分页或更多链接 |
| `newscate.html` | `LIST` | 新闻分类标题、筛选、文章列表、分页 |
| `newscategory.html` | `LIST` | 分类导航、文章列表、分页和空态 |
| `newsarticle.html` | `DETAIL` | 文章标题、时间、正文、上一篇/下一篇、相关推荐 |
| `newscontent.html` | `DETAIL` | 内容标题、正文、附件/相关链接；富文本安全 |
| `newssearch.html` | `LIST` | 搜索框、关键词、结果列表、无结果提示 |
| `help.html` | `LIST` | 帮助分类、热门文章、搜索入口 |
| `helpcate.html` | `LIST` | 分类标题、文章列表、分页 |
| `helpcategory.html` | `LIST` | 分类导航、文章条目、空态 |
| `helparticle.html` | `DETAIL` | 帮助标题、正文、目录、相关问题 |
| `helpcontent.html` | `DETAIL` | 帮助正文、更新时间、反馈或相关链接 |
| `helpsearch.html` | `LIST` | 搜索框、结果列表、无结果和纠错入口 |
| `404.html` | `PUBLIC` | 错误说明、返回首页、客户中心入口 |

## 客户中心页面（默认主题 59 个模板）

### 公共和认证

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `header.tpl` / `footer.tpl` | `PUBLIC` | Logo、导航、语言、账户、页脚；登录前后和移动端都正确 |
| `clientarea.tpl` | `DASH` | 欢迎、服务/账单统计、提醒、快捷入口 |
| `maintenance.tpl` / `404.tpl` | `PUBLIC` | 维护/错误说明、返回入口，不泄露调试信息 |
| `login.tpl` | `AUTH` | 登录方式、验证码、二次验证、OAuth、注册/找回入口 |
| `loginaccesstoken.tpl` | `AUTH` | 登录授权提示、回调确认和错误状态 |
| `register.tpl` | `AUTH` | 注册字段、协议、验证码、成功/重复账号提示 |
| `pwreset.tpl` | `AUTH` | 邮箱/手机找回、验证码、新密码、过期状态 |
| `bind.tpl` | `AUTH` | 账号绑定、验证方式、冲突提示 |

### 账户和认证

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `details.tpl` | `FORM` | 个人/公司资料、联系方式、保存结果 |
| `security.tpl` | `FORM` | 密码、手机/邮箱、二次验证、登录提醒 |
| `message.tpl` | `LIST` | 消息筛选、未读状态、阅读/删除 |
| `verified.tpl` | `DETAIL` | 认证总状态、个人/企业入口、审核提示 |
| `verifiedpersonal.tpl` | `FORM` | 个人认证字段、证件上传、审核状态 |
| `verifiedenterprises.tpl` | `FORM` | 企业认证字段、证件/授权资料、审核状态 |

### 服务和产品

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `service.tpl` | `LIST` | 服务筛选、状态、到期日、进入详情/续费 |
| `servicedetail.tpl` | `DETAIL` | 服务摘要、凭据、模块操作、流量/账单/日志 |
| `service_product.tpl` | `DETAIL` | 通用产品信息、配置、操作按钮 |
| `service_hosting.tpl` | `DETAIL` | 主机信息、资源用量、控制入口 |
| `service_server.tpl` | `DETAIL` | 服务器信息、IP/登录信息、控制入口 |
| `service_cloud.tpl` | `DETAIL` | 云主机资源、流量、控制入口 |
| `service_cloud_server.tpl` | `DETAIL` | 云服务器信息、控制台和异步任务 |
| `service_cdn.tpl` | `DETAIL` | CDN 状态、流量、节点和配置操作 |
| `service_domain.tpl` | `DETAIL` | 域名信息、续费/解析/证书相关入口 |
| `service_sms.tpl` | `DETAIL` | 短信产品状态、用量和续费入口 |
| `service_soft.tpl` | `DETAIL` | 软件产品信息、授权/下载入口 |
| `service_ssl.tpl` | `DETAIL` | 证书状态、验证/下载/续费入口 |

### 财务和合同

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `billing.tpl` | `LIST` | 待付账单、状态筛选、批量支付入口 |
| `viewbilling.tpl` | `DETAIL` | 账单摘要、项目明细、金额、支付区 |
| `invoicelist.tpl` | `LIST` | 发票列表、筛选、申请/查看入口 |
| `invoiceapply.tpl` | `FORM` | 发票申请、抬头/地址选择、提交结果 |
| `invoicecompany.tpl` | `FORM` | 企业抬头字段、保存和默认项 |
| `invoiceaddress.tpl` | `FORM` | 收货地址列表、编辑、默认地址 |
| `addfunds.tpl` | `CHECKOUT` | 充值金额、支付方式、结果 |
| `transaction.tpl` | `LIST` | 交易筛选、金额方向、时间和分页 |
| `credit.tpl` | `DASH` | 信用额度、已用/剩余额度、生成日/还款日、信用额还款账单 |
| `creditdetail.tpl` | `DETAIL` | 信用额已用明细或还款账单详情，按 action 区分 |
| `combinebilling.tpl` | `CHECKOUT` | 合并账单选择、金额汇总、提交 |
| `mulitrenew.tpl` | `CHECKOUT` | 多服务续费选择、周期价格、支付 |
| `contract.tpl` | `LIST` | 合同列表、状态、签署/查看/下载 |
| `contracthost.tpl` | `DETAIL` | 合同关联服务、签署状态和操作 |

### 工单、内容和扩展

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `supporttickets.tpl` | `LIST` | 工单筛选、状态、未读、进入详情 |
| `submitticket.tpl` | `FORM` | 部门、服务、标题、正文、附件、提交 |
| `viewticket.tpl` | `TIMELINE` | 工单状态、消息时间线、回复、附件、关闭 |
| `news.tpl` / `newslist.tpl` | `LIST` | 新闻分类、列表、分页和空态 |
| `newsview.tpl` | `DETAIL` | 新闻标题、正文、时间、相关内容 |
| `knowledgebase.tpl` / `knowledgebaselist.tpl` | `LIST` | 分类、搜索、文章列表 |
| `knowledgebaseview.tpl` | `DETAIL` | 文章正文、目录、相关文章 |
| `downloads.tpl` / `downloadscate.tpl` | `LIST` | 下载分类、文件列表、权限和下载结果 |
| `affiliates.tpl` | `DASH` | 推广摘要、链接、记录和提现入口 |
| `apimanage.tpl` | `DETAIL` | API 凭据、权限、生成/重置和安全提示 |
| `apilog.tpl` / `loginlog.tpl` / `systemlog.tpl` | `LIST` | 日志筛选、时间、结果和脱敏展示 |

## 购物车页面（默认主题 6 个模板）

| 模板 | 版式 | 主区块和验收点 |
| --- | --- | --- |
| `product.tpl` | `LIST` | 分类、商品卡片、账期、库存、购买入口 |
| `configureproduct.tpl` | `FORM` | 配置项、必填校验、价格实时摘要 |
| `ordersummary.tpl` | `DETAIL` | 商品明细、周期、优惠、税费和总额 |
| `viewcart.tpl` | `CHECKOUT` | 商品列表、数量、删除、优惠、结算 |
| `complete.tpl` | `DETAIL` | 订单号、账单/支付状态、下一步入口 |
| `sidebar-categories.tpl` | `LIST` | 分类导航、当前分类和移动端折叠 |

## 后台 PHP View* 页面（76 个入口）

该数仅覆盖 PHP View* 路由，不代表完整后台页面盘点。编译前端另有 229 条路由记录，见[路由静态盘点](22-admin-route-inventory.md)与[页面对应关系](23-admin-page-crosswalk.md)。

后台所有页面都套用后台外壳；下表只补充每页的主版式和业务区块。接口、权限和字段以
`data/route/admin.php` 及对应控制器为准。

| 页面入口 | 版式 | 页面主区块 |
| --- | --- | --- |
| `index` | `ADMIN-DASH` | 业务统计、告警、待处理事项、快捷入口 |
| `plugins` | `ADMIN-LIST` | 插件列表、启停、配置和版本信息 |
| `clients` | `ADMIN-LIST` | 客户搜索、筛选、批量操作和详情入口 |
| `clientsauthentication` | `ADMIN-LIST` | 认证状态、审核筛选和处理入口 |
| `clientsresources` / `resourcepool` | `ADMIN-LIST` | 客户资源、资源池、状态和分配 |
| `salesstatistics` | `ADMIN-DASH` | 销售统计、筛选、图表和明细 |
| `affiliates` | `ADMIN-LIST` | 推广客户、佣金、记录和状态 |
| `massmailsms` | `FORM` | 群发对象、模板、预览、发送进度 |
| `configclientgroups` / `configclientslevel` | `ADMIN-LIST` | 分组/等级列表、规则、编辑 |
| `configauthentication` / `configclientscustomfields` | `FORM` | 认证和客户字段配置 |
| `configaffiliates` | `FORM` | 推广规则、比例、结算和保存 |
| `clientssummary` / `clientsprofile` | `ADMIN-DETAIL` | 客户摘要、资料、状态和操作 |
| `clientsservices` / `clientsviewservices` | `ADMIN-LIST` | 客户服务、状态、续费/暂停/控制 |
| `clientsinvoices` / `viewinvoices` | `ADMIN-LIST` | 客户账单、项目、支付和详情 |
| `clientstransactions` | `ADMIN-LIST` | 交易、收入/支出、手续费、审计 |
| `clientscredit` | `ADMIN-DETAIL` | 信用额度、已用/剩余、还款周期、账单和调整日志 |
| `clientssupporttickets` / `clientssupportticketdetail` | `TIMELINE` | 客户工单、回复、附件和状态 |
| `clientslog` / `clientsnoticelog` / `clientsviewemail` | `ADMIN-LIST` | 活动、通知和邮件日志，敏感字段脱敏 |
| `clientsattach` / `clientsaffiliate` / `clientscrm` | `ADMIN-DETAIL` | 附件、推广和 CRM 信息 |
| `ordersadd` / `createsupporttickets` | `FORM` | 管理员代客户下单/提交工单 |
| `orders` / `orderdetail` | `ADMIN-LIST` / `ADMIN-DETAIL` | 订单筛选、金额、状态、项目和操作 |
| `trafficorder` / `productlist` | `ADMIN-LIST` | 流量订单、产品、库存和上游关联 |
| `cancelrequests` | `ADMIN-LIST` | 取消申请、原因、审核和执行结果 |
| `transactions` / `invoices` | `ADMIN-LIST` | 交易/账单筛选、支付、退款、导出 |
| `withdrawdeposits` / `receipt` | `ADMIN-LIST` | 提现、收款、审核和凭证 |
| `configgateways` / `configpromotions` / `configpromotionsadd` | `FORM` | 支付网关、优惠规则和编辑 |
| `configcurrencies` / `configfund` / `configreceipt` | `FORM` | 货币、余额和发票配置 |
| `addhelp` | `FORM` | 帮助内容编辑、分类、发布状态 |
| `permissionsmanagment` | `ADMIN-LIST` | 角色、权限树、授权和保存 |
| `smstemplateindex` | `ADMIN-LIST` | 短信模板、变量、状态和编辑 |
| `supportticket` / `supportstatistics` | `ADMIN-LIST` / `ADMIN-DASH` | 工单处理、统计、筛选和批量动作 |
| `configticketdepartments` / `configticketdepartmentsadd` | `FORM` | 部门、邮箱、转发和权限 |
| `configticketstatuses` / `configticketpass` | `FORM` | 状态、自动关闭、转发规则 |
| `configproducts` / `configproduct` | `ADMIN-LIST` / `ADMIN-DETAIL` | 产品列表、基本信息、计费和发布 |
| `configproductoptions` / `configproductoptionsedit` / `configproductoptionsaddon` | `ADMIN-LIST` / `FORM` | 配置组、选项、子项和价格 |
| `configproductoptionsgroup` | `FORM` | 配置组排序、关联产品和保存 |
| `configtraffic` | `FORM` | 流量规则、计费和产品关联 |
| `configservermodule` / `configservermoduleedit` | `ADMIN-LIST` / `FORM` | 服务器模块、能力、参数和生命周期 |
| `configdcimmoodule` / `configdcimmooduleedit` | `ADMIN-LIST` / `FORM` | DCIM 模块、授权和配置 |
| `configzjmfcloud` | `FORM` | 魔方云配置、连接和状态 |
| `annualstatistics` / `newcustomer` | `ADMIN-DASH` | 时间筛选、统计卡片、图表和明细 |
| `productrevenue` / `revenueranking` | `ADMIN-DASH` | 产品收入、排名、筛选和导出 |
| `munualresource` / `addOrEditresource` | `ADMIN-LIST` / `FORM` | 手工资源、录入、编辑和分配 |
| `upStreamedit` / `zjmfapi` | `ADMIN-DETAIL` / `ADMIN-LIST` | 上游配置、连接状态、同步和日志 |

## 逐页验收要求

每一行页面在新模板交付时都要补充真实截图或线框、字段清单、接口清单、角色矩阵和验收
记录。只有表格中的一句版式摘要时，页面仍属于“结构基线”，不能标记为视觉设计完成。
