# 首批页面布局线框与实施样板

本文件给出新模板的文字线框、字段位置和交互方案。不是当前页面截图或高保真稿，也不是运行验收报告。首阶段前台采用子主题；后台先恢复可维护工程或完成入口技术验证。接口、权限和状态分别以 [13](13-page-api-contract.md)、[14](14-admin-permission-matrix.md)、[15](15-domain-state-action-matrix.md) 为准，不用线框新增业务能力。

## 公共尺寸和阅读顺序

沿用[组件规格](19-component-interaction-contract.md)：桌面顶栏 56px、侧栏 224px，内容边距/栏距 24px；平板侧栏 64px；手机 <768px，边距 16px、单列、抽屉导航。正文 14px，页标题 22px，分区标题 16px；正文列 min-width:0。表格内滚动，页面不横向溢出。

标题栏按“返回、标题/编号、状态、主要动作”排序。错误紧跟其字段或请求区域，加载/空态/错误不改变公共导航。窄屏先显示对象身份和主要状态，再内容、金额摘要、操作；高风险操作不默认置于最显眼按钮。

## F01 前台登录

入口 GET/POST `/login`，`ViewClients::login` → `login.tpl`；POST 模板 action=phone_code/phone/其他分别调用手机号验证码、手机号密码、邮箱密码登录。异步接口使用 login_pass_email/login_pass_phone 的真实字段。

```text
桌面：公共品牌头部
      400px 宽登录表单，最大宽 calc(100% - 32px)
      登录方式分段控件
      邮箱/手机号 + 国家区号
      密码 / 短信验证码
      按配置出现的图形/二次验证码、字段错误
      登录按钮
      注册、找回密码、实际启用的第三方登录
手机：相同阅读顺序；字段和主按钮 44px；不使用双栏宣传区
```

字段显示由 `$Login.allow_login_email/allow_login_phone/allow_id/is_captcha` 和二次验证标志决定，国家区号来自 `$SmsCountry`，OAuth 来自 `$Oauth`。禁用的方式不展示，不因缺字段自行开启。验证码图片/发送沿用现有接口和配置，验证码失败只清相应验证码，密码不回显。模板成功设置登录 Cookie 并跳 clientarea；异步分支也须复查登录态。

验收：L01，错误凭据、启用/关闭的登录方式、验证码、会话刷新和手机长错误。实际语言、维护和第三方分支额外核实。

## F02 商品配置

入口 `/cart?action=configureproduct&pid=<pid>`；ViewCart 选购物车主题与 configureproduct.tpl。`/store/:alias`、`/buy/:alias` 是同控制器入口，不能当作另一套 API。

```text
桌面：标题 + 商品身份
      配置主列（剩余宽度）             | 订单摘要 320px
      周期/区域/系统、按配置组排字段     | 已选配置、安装费/周期价/币种
      必填自定义字段                   | 数量、后端合计、加入购物车
      字段错误和绑定/实名要求           | 报价更新/失败提示
手机：标题 → 配置 → 必填资料 → 摘要 → 提交，摘要解除 sticky
```

GET get_product_config 的 data.products 对应商品和库存提示，product_pricings 对应周期，config_groups/config_links/advanced 对应关联配置，customfields 对应补充输入。POST get_total 返回顶层 currency/products；products.child 放已选明细，total/setupfee_total 及销售折扣分支由适配器按现有协议显示，不用浮点乘法推算最终价格。

配置变更使旧报价失效，更新完成前禁用提交；请求序号丢弃旧响应，数量用步进器/数值输入，选项用 radio/select，二值用 checkbox/toggle。必填失败保留其他字段并聚焦第一个错误。add_to_shop 成功重新读取购物车；绑定/实名要求使用服务器提示与真实入口。

验收：Q01/Q02，不同币种/周期、必填和联动、库存 0、连续变更后的最终价格。

## F03 购物车与结算

入口 `/cart?action=viewcart`，`viewcart.tpl`；ordersummary/complete 是 ViewCart 的其他动作。先以 get_shop_data 读取，不用商品 ID 替代购物车位置 i/pos。

```text
桌面：标题 + 选中数量
      商品列表（主列）                 | 摘要 320px
      选择、商品/周期/配置、数量、删除   | 小计、安装费、优惠、合计
      优惠输入及逐项失败               | 实际支付方式、余额、结算
手机：商品逐项单列 → 优惠 → 金额明细 → 支付方式 → 结算
```

data.cart_products 是商品行，currency 提供币种，promo/total_desc 是服务端摘要，gateway_list/default_gateway 决定付款方式，credit 是预存余额。数量 POST modify_product_qty，删除 POST remove_product，优惠 POST add_promo/remove_promo；成功都重查整车。结算 POST settle 带 payment,checkout,use_credit,pos，成功后的 invoiceid/后续结果按分支处理，不能只显示“已开通”。

每个行操作提交中锁该行，结算锁全表/主要按钮；409 显示需核对并重查，不自动重复扣款/下单。空购物车显示可到现有商品列表的入口；部分选择的总额不能沿用整车旧摘要。先查看新结果，再释放按钮。

验收：Q02/B01，选择集合、改数量、无效优惠、库存并发、旧窗口刷新和结算后订单数量。

## F04 前台账单详情

入口 GET `/viewbilling?id=<invoiceid>`，ViewClients → viewbilling.tpl；API GET get_invoices_detail。模板未找到本人账单时回 billing，API 对不存在/非本人返回 400。

```text
桌面：返回账单列表 | 账单编号 | 状态
      收款/付款信息（两列）            | 摘要/支付 320px
      项目表：说明、金额               | 金额、余额抵扣、待付、支付方式
      交易历史、备注、关联服务         | 支付按钮/已付结果
手机：编号状态 → 收付款 → 项目 → 金额 → 支付 → 历史
```

$ViewBilling 来自 data，data.payee/detail/invoice_items/currency/accounts 分别映射上述区块。支付 POST start_pay(invoiceid,payment,flag)，沿用 pay 子模板与真实网关返回；余额与信用额单独标识。历史支付记录出现收入/退款方向，复制交易号按权限，金额保持服务端单位和小数。

状态读取成功后决定支付按钮；已付显示交易结果，未付显示允许的渠道，未知状态禁止自动推断。支付超时/回跳显示核对中并重查，本地 Paid 才能显示完成。部分退款按实际状态/流水说明，不新增“部分退款”枚举。

验收：B01/B02，三类账单、本人/非本人、沙箱回调、打印（若保留）、长项目说明。

## F05 前台服务详情

入口 GET/POST `/servicedetail?id=<hostid>`，ViewClients → servicedetail.tpl，分类型/动作 include。`$Detail` 来自 Host::getHeader.data，`$Cancel/$Renew/$SecondVerify/$ForceContract` 按现状保留。

```text
桌面：返回服务列表 | 产品/实例 | 状态 | 续费
      基本信息/连接字段                | 计费/到期 320px
      类型功能标签（实际模块支持项）    | 续费、取消申请/已有申请
      当前标签内容、操作结果、日志      | 合同/验证提示（配置启用时）
手机：身份状态 → 计费 → 基本信息 → 功能标签 → 操作/日志
```

Detail.host_data 放实例/到期等信息，模块功能只展示实际返回支持项。GET action=log_page/billing_page/renew/upgrade_page/upgrade_configoption_page 分别加载已有子模板；POST cancel/delete_cancel/upgrade 等保持原 action 协议。首批不统一造 /host/:id REST 地址。

凭据默认遮罩，显式查看/复制；主机操作权限、二次验证和强制合同由真实后端字段决定，不把 Active 当作所有按钮的唯一条件。提交后重新读取 Detail.host_data.domainstatus，host_data.status 是另一个账单相关值，不能替代主机状态；消息与状态分别展示。没有 task_id 时仍通过状态/日志核对。模块失败保留参数但清敏感密码。

验收：H01/B02，各服务类型至少选择实际支持的一个模块；无测试模块时只完成读取，不宣称控制链路通过。

## F06 前台工单详情

入口 GET/POST `/viewticket?tid=<对外编号>`，ViewClients → viewticket.tpl，`$ViewTicket=data`；异步 GET ticket/detail 与 POST ticket/reply/close。模板 POST 成功现状跳 supporttickets，异步新布局方案成功留详情并重查，需验收两种提交方式。

```text
桌面：返回 | 主题/编号 | 状态 | 关闭
      对话时间线（主列）               | 元信息 280px
      正文/发送人/时间/授权附件         | 部门、关联产品、优先级
      回复编辑器、附件、字段错误       | 评价/反馈（实际返回时）
      回复按钮
手机：主题状态 → 元信息折叠 → 时间线 → 编辑器/附件 → 发送
```

data.ticket 放身份/状态/部门，data.list 放消息，evaluate/feedback_request 放评价区。客户内容转义或按富文本白名单处理；附件通过既有授权入口，不造公开永久地址。发送中保持编辑器高度并禁提交，失败保留正文/附件，超时先查时间线。返回工单列表不丢检索条件。

状态名取配置，前台回复写 3，关闭写 4；源码未统一限制关闭后回复，按钮政策另行确认。tid 和后台内部 id 分开记录，访客 c 分支只在现有允许配置下呈现。

验收：T01，CA/CB 边界、附件失败、长正文和关闭后实际表现。

## A01 后台登录与公共外壳

编译路由 /login 对应 Public 登录体系，POST `{A}/login`；login_page 为数据入口，实际页面 base/hash 与服务器路由部署验证。布局采用 400px 登录表单，不用后台业务侧栏；字段 username/password/captcha，二次 code 按配置出现。成功后加载 data.user/rule/user_tastes，205 插件接管按实际协议处理。

后台外壳固定顶栏 56px、侧栏 224px（平板 64px），菜单来自实例权限，主内容无额外装饰卡片。手机侧栏抽屉且内容保持 min-width:0；导航进入详情保留来源列表状态。接口 401 显示拒绝、405 回登录、307 显示系统不可用提示，不能作为普通空态。

验收：L02/V01；按已确定的新建方向建立可维护工程，当前不具备编译验收证据。

## A02 客户列表

编译 /customer-list ↔ PHP /clients（同业务、不同渲染），RULE `{A}/client_list`；旧编译组件实际使用 POST 和 qs.stringify 表单编码。

```text
桌面：页标题                          [新增客户（有权限）]
      常用筛选：姓名/公司/邮箱/手机号/状态；展开高级条件
      选中数 + 实际支持的批量动作
      表格：ID、客户、联系方式、状态、分组/销售、操作
      总数 + 分页/每页条数
手机：标题/主动作 → 筛选抽屉 → 核心列或内部滚动表格 → 分页
```

读取顶层 list/total；search/level_search/api_status/seachData 提供筛选选项，按真实返回键渲染。金额/服务数仅在接口确有返回且权限允许时列出，不新增无依据列。状态/分组 select，高级条件折叠，列表行高最小 44px。点击客户进入带真实 uid 的详情，来源筛选保存在页面/路由状态。

批量动作只能使用另行映射的实际接口；规则不明的导出不显示为已可用按钮。401/销售范围限制与空列表分开。每次筛选回 page=1，避免切换条件仍在旧末页。

验收：C01/L02/V01，空列表/空搜索、长公司名、无读取权限、销售范围与重新登录。

## A03 客户摘要与资料

编译 /customer-view/abstract、abstractOld、person ↔ PHP clientssummary/clientsprofile；摘要新旧两个组件保持独立记录，暂不直接合并。

```text
桌面：返回客户列表 | 客户ID/姓名/状态 | 受权操作
      客户子页 tabs
      当前表单/摘要（主列）            | 联系/归属摘要 320px
      资料分组：基本、联系、地址、自定义 | 不混淆余额/信用额
      字段错误、保存/取消              | 相关读取/日志入口
手机：身份 → 横向 tabs → 摘要 → 单列表单 → 保存区
```

GET summary(client_id)；GET profile/:client_id 返回顶层 profile/sale/language/client_status/custom/custom_value。表单按字段类型和 required 展示，POST profile_post 使用 client_id（内部变量叫 uid，不能误作请求字段），提交后重读资料/摘要。只读角色展示标签和值，不仅灰化保存按钮；409 范围拒绝不泄露残留客户内容。切换客户前清旧表单/异步数据。

保存使用已加载资料白名单和正确表单编码，保留有效 currency/language/defaultgateway 等原值；不把未返回的 city/region/avatar 补空提交。自定义字段校验可能在主资料写入后才失败，400/超时保留草稿并重查，页面需要显示待核对/部分保存提示；无变化时不发请求。辅助选项接口也须授权。完整实现与样板用例见[后台样板契约](26-admin-pilot-contract.md)。

信用额页为独立客户子页，额度、已用/剩余、周期、还款账单与日志放各区；已有 CustomerCredit 还包含余额工具，新方案必须分别接 CreditLimit 和 Credit 两套接口，不把 clientscredit 做成余额冻结页。

验收：C02/F01，原值保存、字段校验、重复邮箱、权限/销售范围、信用额日志。

## A04 后台商品列表与编辑

编译 `/product-server` 与 `/edit-product` 分别对应产品/编辑组件，另有 `/dcim-product`、`/zjmfcloud-product` 专用页，不直接合并；PHP configproducts 是列表说明。产品编辑读取 GET `{A}/edit_product_page/:id`，保存 POST edit_product。

```text
列表：标题/实际新增动作 → 一级/二级分组树 + 商品行 → 操作结果
编辑：返回 | 商品名/ID | 保存
      标签：基本、价格、模块、配置项、自定义字段、升级/推广
      选中分区表单（2列，字段最大合理宽） | 保存影响摘要 320px
      字段错误与底部保存
手机：分组折叠；编辑 tabs 内滚动、字段单列、摘要下移
```

product_list_page 顶层 data 是一级分组→groups→products，不当普通平铺页。编辑 data.product 放身份/type/gid/hidden/stock_control/qty/pay_method/auto_setup，pricing/currencies 是币种×周期矩阵，modules/server_group 是模块，config_groups/config_links 是关联组，customfields 是字段，upgrade_product_ids 是升级关联。

POST 不是原样回传 data.product：id/type/gid/name/pay_type/pay_method/api_type 等采用 ProductsValidate 协议，定价 currency[币种ID][周期或安装费]，未启用周期沿用 -1 约定；按钮和 checkbox 使用实际 0/1/on 规则逐字段适配。首批仅本地 P1 商品，资源/上游另分支尚未完整冻结。上游 GET 编辑可能请求外部配置，失败不得用本地示例价格代替。

保存后重读 edit_product_page 和前台 get_total，验收修改影响到新下单报价；现有服务价格不由 UI 自动重算。字段完整校验、不同币种和未启用周期提交样例仍需隔离响应证据。

## A05 后台账单详情

编译 /bill-detail ↔ PHP /viewinvoices；GET `{A}/invoice/summary/:id` 返回顶层 invoices/invoice_items/accounts/exists_pay，不是前台 data.detail。

```text
桌面：返回 | 账单ID/客户 | 状态 | 常用受权操作
      项目表 + 交易/余额/信用额明细       | 账单摘要 320px
      备注与审计入口                     | 时间、已付/待付、实际抵扣
      操作结果                           | 人工入账/退款（受权且可执行）
手机：身份状态 → 金额摘要 → 项目 → 交易 → 受权操作
```

invoices.status/status_zh,subtotal,pay_amount,surplus_zh,credit_zh 用于摘要，invoice_items.description/amount 放项目。accounts.type 区分 account/credit/credit_limit；is_refund/diff_amount 用于退款可用提示，实际退款仍服务端核验。POST refund 的 id 是 accounts.id，确认显示交易/账单/客户/金额/类型，不能输入账单编号作为该 id。

人工标记为 Paid/Unpaid/Cancelled 是当前有副作用 GET，按钮显式确认，禁止作为 link 预取或自动重试。接口成功后重查摘要、流水和服务最终结果，不承诺幂等；只读账号不渲染写入动作。200 批量结果需要逐项核对。

验收：B01 的后台读取、财务有/无权限、隔离退款/人工入账；无沙箱时不运行真实扣退。

## A06 后台服务详情

编译 /customer-view/product-innerpage ↔ PHP /clientsviewservices；保持当前客户与 host 身份上下文。读取来源按 View* 直接调用和编译 chunk 对照，模块写入 POST provision/default。

布局沿用 F05，后台增加客户摘要、模块配置/日志与操作结果，敏感凭据置独立受权区。顶部主操作按真实功能支持、权限和状态矩阵决定；终止放危险动作菜单，显示具体影响。模块开通成功提示与 domainstatus 分开，不用订单 Active 替代主机 Active。

服务详情各模块字段/参数差异较大，当前只冻结公共布局和已查生命周期动作；完整读取 schema 和真实任务/日志查询仍待模块样例，不能按一个通用 JSON 批量实现全部模块。

验收：H01 与普通管理员权限；首批一个沙箱模块，其他类型保留旧入口。

## A07 后台工单详情

编译 /support-ticket-detail ↔ PHP /clientssupportticketdetail；GET `{A}/list_ticket/:id`（内部 id）读 data.list/ticket/user/customfields。

```text
桌面：返回 | 编号/主题 | 状态 | 实际处理动作
      对话时间线、内部可见内容、附件     | 客户摘要/部门/产品 320px
      回复/已有备注方式                  | 自定义字段
      编辑器、附件、发送结果             | 实际转派/状态操作
手机：身份 → 摘要折叠 → 对话 → 编辑器 → 操作
```

POST reply_ticket(id,content,attachment[]) 成功写 status=2，重读详情并更新未读。POST close_ticket 使用 id[] 和已存在的 status，操作后核对所选对象实际状态；无部门权限 406 不显示残留数据。内部备注/转派等动作在真实接口与权限未映射前只作为后续位置，不做虚假按钮。

编辑区与时间线不互相套浮动卡片，附件显示名/大小/状态，下载遵循现有授权。发送成功后清编辑器，失败保留输入；读详情会清 admin_unread。

验收：T02，角色规则、部门、未合并条件、回复/关闭及手机输入法。

## A08 基本信息、主题与二次验证设置

额外设置页完整字段线索见[两套页面对应](23-admin-page-crosswalk.md)。getConfig/getConfigOption/newGeneral 都已有隐式 POST 实现，按分区 param[] 读取、顶层键保存，不把它们标为缺失。

基本信息用标签分基本/品牌/SEO/嵌入内容；左表单右预览 360px，手机预览下移。主题页并列官网和客户中心的可用目录/预览，保存显示作用域；购物车主题是另一设置来源。二次验证以前台/后台 tabs 显示启用 toggle、真实动作 checkbox、渠道选项；当前配置未启用则折叠动作，保存后重新读取。

确认弹窗不是邮件二次验证；实际 action 与权限按文档14。脚本/富文本配置由受权管理员管理，预览须隔离，不能直接在设置外壳执行任意配置 HTML。

## 样板完成门槛

以上每页已有文字布局、核心来源与操作边界。旧后台核心路径的局部实测见[后台观察](29-admin-browser-observations.md)，前台匿名页面见[前台观察](38-front-browser-observations.md)；完整响应样本、视觉稿、新工程、隔离角色及写入验收仍未交付。实现任务须引用对应编号及[验收用例](18-frontend-test-acceptance.md)，对缺口明确 BLOCKED，不以截图、路由记录或文档存在替代业务运行结果。
