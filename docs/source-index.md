# 源码索引与覆盖矩阵

本页用于维护文档与实现之间的对应关系。升级框架、替换插件或修改路由后，按本页逐项
复核；控制器注释和 `/document` 静态页面只能作为补充说明，不能替代实际路由和调用点。

## 1. 事实来源优先级

1. `data/route/*.php` 决定对外路径、HTTP 方法和中间件。
2. 控制器及 `app/common/logic/` 决定参数处理、权限、状态变化和返回值。
3. 插件加载器与调用方决定扩展契约；仓库自带插件只是可运行示例。
4. 数据库迁移、配置默认值和模板决定持久字段及最终页面行为。
5. 控制器注释、`app/openapi/documents/` 和历史插件说明可能滞后，修改前必须回到以上
   来源核对。

## 2. 文档到源码

| 文档 | 路由或入口 | 核心实现 | 扩展与示例 |
| --- | --- | --- | --- |
| [产品与业务模型](product.md) | 客户中心、购物车、订单和主机业务入口 | `app/common/logic/`、`app/home/controller/`、`app/openapi/controller/`、`app/admin/controller/` | `app/config/public.php`、`docs/` 各领域契约 |
| [系统架构](01-architecture.md) | `public/index.php`、`data/route/` | `app/app.php`、`app/config/`、`app/common/logic/`、`app/queue/` | `public/plugins/`、`public/themes/`、`public/upgrade/` |
| [数据库说明](database.md) | 安装库和版本升级入口 | `public/install/thinkcmf.sql`、`public/upgrade/*.sql`、模型与迁移调用方 | `tests/*database*`、隔离 MySQL/MariaDB 测试库 |
| [API](02-api.md) | `data/route/openapi.php`、`api.php`、`home.php`、`admin.php` | `app/http/middleware/`、`app/openapi/controller/`、`app/api/controller/`、`app/zjmf.php` | `app/openapi/documents/`、`docs/scripts/generate-openapi-route-reference.php` |
| [前端页面与主题](frontend.md) | `data/route/home.php`、`data/route/admin.php` | `app/home/controller/View*.php`、`app/home/controller/CartController.php`、`app/admin/controller/View*.php`、后台业务控制器 | `public/themes/`、`public/admin/`、`docs/frontend/13-page-api-contract.md`、`docs/frontend/16-frontend-architecture-build.md` |
| [后台静态盘点](frontend/22-admin-route-inventory.md) | 编译 Vue Router、PHP View*、controller 约定路由 | `public/admin/js/app~*.js`、`vendor/thinkphp/library/think/Route.php`、`data/route/admin.php`、`home.php` | `docs/scripts/generate-admin-page-inventory.cjs`；动态菜单/运行时优先级另验 |
| [重构首批与开工状态](frontend/25-rewrite-readiness.md) | 核心接口、权限、状态与主题切换 | CreditLimit、Reports、UserManage、Invoice、Ticket、Host、ConfigGeneral | [首批文字线框](frontend/24-first-batch-page-specs.md)、[隔离用例](frontend/18-frontend-test-acceptance.md)；尚无业务运行验收通过证据 |
| [后台实施样板](frontend/26-admin-pilot-contract.md) | login/login_page/second_verify_send/client_list/profile/profile_post/common | Public、UserManage、UserManageValidate、Common、AdminBase/GetUser | 资料字段/序列化及部分保存行为；副本 PHP/数据库只读预检、源码与环境阻塞项 |
| [旧后台逐页证据](frontend/27-admin-built-page-evidence.md) | Vue Router factory、Webpack 模块/导出、Vue render 与 CSS | `public/admin/js/`、`public/admin/css/`、`public/admin/lang/zh.js` | `docs/scripts/generate-admin-build-evidence.cjs`；[人工解读](frontend/28-admin-built-layout-reading.md)；静态提取不代替浏览器 |
| [旧后台浏览器观察](frontend/29-admin-browser-observations.md) | 副本 /admin123/ hash 页面与 login/client_list/profile 等实际请求 | WSL/Linux Chrome、Playwright CLI；旧部署编译资源与后台 PHP 接口 | 登录/读取/导航、布局实测与脱敏截图；没有客户写入或新工程验收 |
| [后台逐页设计契约](frontend/30-admin-page-contract-index.md) | 229条编译路由，按7个模块分别记录 | `docs/scripts/admin-page-designs.cjs`、`generate-admin-page-contracts.cjs`，复用已有AST及PHP路由盘点 | 新桌面/手机布局、旧控件条件和请求归属；schema/普通角色/全量运行尚未冻结 |
| [前台匿名页面实测](frontend/38-front-browser-observations.md) | 副本 /、login/register/pwreset/cart，匿名客户入口跳转 | WSL/Linux Chrome、实际加载的web/zjmf与clientarea/cart default资源 | 公开页面排版与缺图/字体问题；未登录客户中心或执行业务提交 |
| [部署与运行手册](deployment.md) | `public/index.php`、`app/command.php`、队列服务入口 | `app/admin/command/`、`bin/`、`deploy/queue/`、`app/config/queue.php` | PHP-FPM、Web Server、Cron 和实例部署配置 |
| [主题](03-themes.md) | `data/route/home.php` | `app/home/controller/ViewBaseController.php`、`ViewClientsController.php`、`ViewCartController.php` | `public/themes/web/`、`clientarea/`、`cart/` |
| [插件](04-plugins.md) | `data/route/admin.php`、`home.php` | `app/admin/controller/PluginController.php`、`PluginBaseController.php`、`app/admin/lib/Plugin.php` | `public/plugins/addons/demo_style/` |
| [Hook](05-hooks.md) | 应用启动时加载已启用监听器 | `app/home/controller/HooksController.php`、全仓 `hook(...)` 调用点 | Addon 主类方法及 `public/plugins/addons/*/hooks.php` |
| [实名认证](06-certification.md) | `data/route/home.php`、`openapi.php` | `app/home/controller/CertificationController.php`、`app/openapi/controller/UserController.php`、`app/home/model/CertificationModel.php` | `public/plugins/certification/` |
| [短信](07-sms.md) | 业务控制器与管理端异步入口 | `app/common/logic/Sms.php`、`app/queue/job/SendSms.php`、`app/common/job/SendSmsQueue.php` | `public/plugins/sms/` |
| [支付](08-payment.md) | `data/route/home.php`、`openapi.php` 及网关回调控制器 | `app/home/controller/PayController.php`、`app/openapi/controller/PayController.php`、`app/common/logic/PaymentGateways.php`、订单支付处理 | `public/plugins/gateways/` |
| [邮件](09-mail.md) | 业务控制器与管理端异步入口 | `app/common/logic/Email.php`、`app/queue/job/SendMail.php`、`app/admin/controller/EmailTemplateController.php` | `public/plugins/mail/` |
| [工单传递](10-ticket-transfer.md) | `data/route/home.php`、`openapi.php`、`api.php` | Home/OpenAPI/Admin 的 `TicketController.php`、`app/admin/controller/TicketDeliverController.php`、`app/api/controller/HostController.php`、`app/zjmf.php` | `app/common/model/TicketModel.php`、服务器模块的 `CreateTicket`/`ReplyTicket` |
| [第三方登录](11-oauth.md) | `data/route/home.php`、`admin.php` | `app/home/controller/OauthController.php`、`OauthBindController.php`、`app/home/model/OauthModel.php`、`app/admin/controller/OauthController.php` | `public/plugins/oauth/` |
| [服务器模块](12-server-modules.md) | `data/route/home.php`、`admin.php`、`openapi.php`、`api.php` | `app/common/logic/Provision.php`、`app/common/model/HostModel.php`、Home/Admin 的 `ProvisionController.php`、`app/openapi/controller/HostController.php` | `modules/servers/` 优先，`public/plugins/servers/` 回退 |
| [财务登录回调](13-finance-login-callback.md) | `data/route/api.php` 的 `/api/oauth/*` | `app/api/controller/OauthController.php`、客户登录与 JWT/缓存辅助函数 | 无标准 OAuth/OIDC Provider 插件层 |

## 3. 接口契约检查点

| 能力 | 修改时必须复核 |
| --- | --- |
| OpenAPI | 路由方法、中间件、JWT 缓存校验、业务状态码、静态文档快照和生成路由索引 |
| 主题 | 主题选择配置、父主题回退、模板文件名、语言合并、Hook HTML 输出和移动端页面 |
| 插件/Hook | 发现路径、类名映射、安装幂等性、启停状态、配置兼容、Hook 参数及调用方返回协议 |
| 实名 | 个人/企业字段、收费账单、状态 1/2/3/4、人工审核、查询接口和敏感信息日志 |
| 短信/邮件 | 模板变量、国内外通道、同步/队列模式、重试、附件、退订或营销标记及日志脱敏 |
| 支付 | 金额和币种来源、订单号唯一性、同步/异步回调验签、重复通知幂等、入账与退款 |
| 工单传递 | 部门映射、上下游 ID、附件搬运、回复方向、签名/Token、防重放和循环回传 |
| 第三方登录 | `state`、回调地址、唯一身份键、绑定冲突、停用账号、解绑和会话建立 |
| 服务器模块 | 参数映射、支持函数、返回规范、超时、生命周期幂等、按钮白名单、模板转义和 Cron |
| 财务登录回调 | 回调白名单、授权票据隔离、一次性消费、Token 传输、Cookie 依赖和并发授权 |

## 4. 发布前覆盖审计

1. 使用站点实际 PHP 二进制（例如 `APP_PHP=/www/server/php/72/bin/php`）运行
   `"$APP_PHP" docs/scripts/generate-openapi-route-reference.php`，确认生成结果无意外差异。
2. 使用同一个二进制运行 `"$APP_PHP" think route:list`，核对嵌套分组后的真实路径，
   特别是 `/api/api/host*`；不要用系统默认 `php` 代替。
3. 对文档提及的控制器、方法、插件类和模板执行路径存在性检查。
4. 检查新增或删除的 `data/route/*.php` 路由是否已同步到 API 文档。
5. 检查 `public/plugins/` 及部署时可能存在的 `modules/` 是否改变了插件契约。
6. 对变更 PHP 文件运行 `"$APP_PHP" -l`，再执行与队列、支付、工单和模块生命周期相关的回归。
7. 用 `node docs/scripts/check-doc-links.cjs` 检查本文档的本地路径/源行和空白；按盘点文档运行生成器 --check 验证幂等性。运行时 URL 和命名标题锚点另验，再随源码在同一提交发布。
