# 前端页面与主题说明

前台由 ThinkPHP 控制器、服务端模板、主题资源和页面 JavaScript 组成；后台还包含独立的
Vue Router 编译页面，与 PHP View* 入口并存。页面路由、权限、模板变量和业务接口需要分别
核对，不能仅以 View* 入口数量认定后台完整。修改前先确认实际部署使用的入口与数据来源。

目前文档提供源码事实、布局方案及首批实施步骤，**尚未通过完整运行验收，也不具备全量页面批量开工条件**。详见[开工状态与阻塞项](frontend/25-rewrite-readiness.md)。

页面二开使用以下设计契约：

- [全局设计规范](frontend/00-design-system.md)
- [页面总表](frontend/01-page-index.md)
- [客户中心页面](frontend/02-clientarea-pages.md)
- [购物车与结算](frontend/03-cart-checkout-pages.md)
- [服务与主机页面](frontend/04-service-pages.md)
- [财务页面](frontend/05-finance-pages.md)
- [工单页面](frontend/06-ticket-pages.md)
- [后台页面](frontend/07-admin-pages.md)
- [当前模板与页面目录](frontend/08-current-template-catalog.md)
- [新模板重做契约](frontend/09-template-rewrite-contract.md)
- [逐页版式基线](frontend/10-page-layout-baseline.md)
- [页面排版详细描述](frontend/11-page-layout-details.md)
- [后台逐页排版与交互契约](frontend/12-admin-page-layout-details.md)
- [页面接口契约与数据映射](frontend/13-page-api-contract.md)
- [后台权限与角色矩阵](frontend/14-admin-permission-matrix.md)
- [业务状态与页面操作矩阵](frontend/15-domain-state-action-matrix.md)
- [前端架构、源码与构建发布](frontend/16-frontend-architecture-build.md)
- [新旧模板迁移、灰度与回滚](frontend/17-template-migration-cutover.md)
- [前端重构测试与验收用例](frontend/18-frontend-test-acceptance.md)
- [组件与交互契约](frontend/19-component-interaction-contract.md)
- [国际化、内容、资源与 SEO 契约](frontend/20-i18n-content-assets-seo.md)
- [模板重构的数据与兼容迁移](frontend/21-data-compatibility-migration.md)
- [后台编译路由与 PHP 调用静态盘点](frontend/22-admin-route-inventory.md)
- [后台两套路由对应及额外设置页](frontend/23-admin-page-crosswalk.md)
- [首批页面布局线框与实施样板](frontend/24-first-batch-page-specs.md)
- [重构开工状态与阻塞项](frontend/25-rewrite-readiness.md)
- [后台登录、客户列表与资料编辑样板契约](frontend/26-admin-pilot-contract.md)
- [后台编译产物逐页结构与交互证据](frontend/27-admin-built-page-evidence.md)
- [旧后台排版、页面关系与交互解读](frontend/28-admin-built-layout-reading.md)
- [副本旧后台浏览器观察与脱敏截图](frontend/29-admin-browser-observations.md)
- [后台逐页设计契约索引](frontend/30-admin-page-contract-index.md)
- [客户与客户详情逐页契约](frontend/31-admin-customer-contracts.md)
- [商品、服务与资源逐页契约](frontend/32-admin-product-resource-contracts.md)
- [订单与代下单逐页契约](frontend/33-admin-order-contracts.md)
- [财务、信用额、合同与报表逐页契约](frontend/34-admin-finance-contracts.md)
- [工单与客服逐页契约](frontend/35-admin-ticket-contracts.md)
- [系统设置、内容与通知逐页契约](frontend/36-admin-setting-content-contracts.md)
- [外壳、插件与扩展逐页契约](frontend/37-admin-extension-shell-contracts.md)
- [副本前台匿名页面实测](frontend/38-front-browser-observations.md)

## 页面分区

| 分区 | 路由/入口 | 模板目录 | 认证边界 |
| --- | --- | --- | --- |
| 官网 | `/`、`.html` 页面 | `public/themes/web/<theme>/` | 公开内容；部分跳转到登录或客户中心 |
| 客户中心 | `/clientarea`、`/service`、`/billing`、`/supporttickets` 等 | `public/themes/clientarea/<theme>/` | 登录客户；`ViewBaseController` 检查客户会话和状态 |
| 购物车 | `/cart`、`/store/:alias`、`/buy/:alias` | `public/themes/cart/<theme>/` | 商品浏览可公开，配置、结算和客户数据按路由检查 |
| 后台 | 配置项 `admin_application`；SPA 另有前端路径 | `public/admin/` 编译资源 + `app/admin` 页面控制器 | API 使用 AdminBase 的 Session/RBAC；ViewAdminBase 未继承同一链；按入口分别验收 |

客户中心页面由 `data/route/home.php` 和 `app/home/controller/ViewClientsController.php`
驱动；购物车由 `ViewCartController`、`app/home/controller/CartController.php` 和
`app/common/logic/Cart.php`
共同驱动；官网页面由 `ViewController` 根据主题文件查找。后台路由的前缀不是写死的，
以 `config("database.admin_application")` 为准。

## 客户中心页面地图

| 功能 | 页面示例 | 相关接口/控制器 |
| --- | --- | --- |
| 登录注册 | `/login`、`/register`、`/pwreset`、`/bind` | `ViewClientsController`、`home/login`、`home/register` |
| 首页与服务 | `/clientarea`、`/service`、`/servicedetail` | `ViewClientsController`、`home/Host`、`home/provision` |
| 账单与支付 | `/billing`、`/viewbilling`、`/invoicelist`、`/pay` | `home/pay`、`home/user_invoice` |
| 账户 | `/details`、`/security`、`/verified`、`/message` | `home/user`、`home/certification`、系统消息 |
| 工单 | `/supporttickets`、`/submitticket`、`/viewticket` | `home/ticket`、`home/viewClients` |
| 购物车 | `/cart`、`/store/:alias`、`/buy/:alias` | `ViewCartController`、`home/cart` |
| 内容 | `/news*`、`/knowledgebase*`、`/downloads` | `home/News`、`home/knowledge_base`、`home/down` |
| 开发者和扩展 | `/apimanage`、`/oauth*`、`/contract*` | OpenAPI 管理、OAuth、合同控制器 |

完整路由事实以 `data/route/home.php` 为准，页面名称和文件名不能代替真实 HTTP 路由。

## 主题选择和继承

- 官网主题由 `configuration('themes_templates')` 选择。
- 客户中心主题由 `configuration('clientarea_default_themes')` 选择，也可在开发时通过
  `?theme=<name>` 或 `clientarea_theme` Cookie 临时切换实际存在的主题目录。
- 购物车主题由商品/请求参数和 `cart_theme` Cookie 共同影响；`?carttheme=<name>` 会
  写入 Cookie。它不能作为生产权限控制。
- 子主题只覆盖需要修改的文件，缺失模板由父主题回退。父主题、目录名和语言文件必须
  在发布前检查存在性。

主题配置和模板格式的细节见 [主题开发](03-themes.md)。购物车 `theme.config` 使用项目
 现有的扁平行格式，不能把它当作完整 YAML 解析。

## 数据和交互边界

模板变量由控制器提供，常见变量包括 `$Setting`、`$Userinfo`、`$Lang`、`$Nav`、
`$CartShopData`、`$Get`、`$Post`、`$TplName` 和 `$Ver`。模板不能直接查询数据库，
也不能把请求参数、客户资料、支付结果或上游响应未经转义写入 HTML、JavaScript、CSS
或跳转地址。

页面提交遵循当前控制器的 HTTP 方法、Token、隐藏字段和重复提交保护。金额、优惠、库存、
客户 ID、主机 ID 和权限由服务端重新计算或校验，前端显示值不能作为业务事实。

页面异步请求常见返回结构为 `{status, msg, data}`；其中 `status` 是业务状态，不能直接
当成 HTTP 状态码。支付、开通、续费、主机控制和工单发送都要处理加载、成功、失败、超时、
重复提交和页面刷新后的最终状态。

## 页面状态清单

开发或验收一个页面时至少检查：

- 未登录、已登录、客户被停用/关闭和维护模式。
- 初始加载、空数据、加载中、接口失败、权限失败和过期会话。
- 商品库存不足、配置项缺失、优惠码失效、账单未支付/已支付/已取消。
- 主机 `Pending`、`Active`、`Suspended`、`Deleted` 等状态，以及上游处理中或失败。
- 工单无附件、有附件、重复回复和下载权限。
- 成功操作后的刷新、返回、重复点击和浏览器后退。

## 响应式和资源规则

- 桌面和移动端都要验证导航、表格、支付区域、弹窗、表单和长文本，不只检查首页。
- 使用主题自身的资源目录和 `$Ver` 版本参数；不要修改共享 `public/static` 来解决单一
  主题问题。
- 不重复加载主题已有的 jQuery、Bootstrap 等依赖；新增脚本要考虑旧浏览器和现有插件冲突。
- 上传、富文本、复制、二维码、图表和弹窗等交互要验证失败路径，不能只验证视觉效果。
- 生产页面不得保留 `{debug}`、测试域名、源映射密钥、管理员数据或完整凭据。

## 后台前端边界

`public/admin/` 主要是已编译的静态资源，页面入口仍由 `data/route/admin.php` 和
`app/admin/controller/View*.php` 提供。后台页面变更必须同时核对：

1. 页面路由前缀和登录/二次验证入口。
2. 管理员权限、菜单显示和后端接口权限是否一致。
3. 列表筛选、分页、批量操作、表单校验、错误提示和成功后的重新加载。
4. 编译资源的文件名、引用路径和缓存版本；不要只替换一个无法追溯来源的压缩文件。

后台没有原工程源码，已确定根据旧页面的排版、交互及真实接口新建可维护工程。逐页设计覆盖编译路由和 PHP 入口，分别记录现状与新方案；实际开发/验证在副本进行。旧编译资源保留作对照与回滚，静态资源检查不代表真实页面交互已验证。工程和逐页设计要求见[构建文档](frontend/16-frontend-architecture-build.md)。

## 前端变更验收

1. 从 `data/route/*.php` 确认真实路由、方法和中间件。
2. 从控制器确认模板名、变量、接口、权限和状态分支。
3. 在默认主题和受影响的子主题中检查模板回退、语言和资源路径。
4. 使用真实登录会话验收客户页面；使用有权限和无权限管理员各验收一次后台功能。
5. 检查桌面/移动端、空态/错误态、重复提交、刷新和后退行为。
6. 清理模板缓存，运行相关回归脚本，并检查 `git diff --check` 和敏感信息泄漏。
