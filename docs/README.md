# 魔方财务 3.7.7 开发文档

本文档以当前仓库源码为准，面向二次开发、接口接入和模块维护。仓库是以
3.5.8 解密源码为维护基线的 3.7.7 自维护分支，不包含 v10/P3 功能。运行和升级
约束仍以项目根目录的 [README](../README.md) 为准。

文档中的 `APP_PHP` 表示站点实际使用的 PHP CLI 路径，应与 PHP-FPM 和队列 worker
保持一致，例如 `APP_PHP=/www/server/php/72/bin/php`。如果系统默认 `php` 指向其他
版本，也不要用它替代 `APP_PHP` 执行 ThinkPHP 控制台命令。

## 阅读顺序

| 文档 | 解决的问题 |
| --- | --- |
| [项目协作规则](../AGENTS.md) | AI/开发者应遵循的目录边界、运行时和完成标准 |
| [产品与业务模型](product.md) | 客户、商品、订单、账单、主机、工单和上游系统的关系 |
| [财务系统开发指南](01-architecture.md) | 应用分层、请求链路、配置、数据库、队列和开发约束 |
| [数据库说明](database.md) | 核心表、状态、事务、迁移和数据变更规则 |
| [API 开发与调用](02-api.md) | `/v1`、`/api`、上游财务 API 的边界、认证和错误处理 |
| [部署与运行手册](deployment.md) | PHP-FPM、Cron、库存同步、队列、升级、回滚和健康检查 |
| [前端页面与主题](frontend.md) | 官网、客户中心、购物车、后台的页面路由、主题、接口、权限、状态、构建、迁移和验收 |
| [重构开工状态](frontend/25-rewrite-readiness.md) | 已确认源码契约、首批样板及尚未完成的运行/构建门槛 |
| [后台实施样板](frontend/26-admin-pilot-contract.md) | 登录→客户列表→资料编辑的请求/字段、失败重查、权限及副本环境预检 |
| [旧后台页面解读](frontend/28-admin-built-layout-reading.md) | 旧产物的布局/交互事实、与新设计的区别，以及全量静态证据入口 |
| [旧后台浏览器观察](frontend/29-admin-browser-observations.md) | 副本登录、列表/资料导航与桌面/手机实测、脱敏截图和验证边界 |
| [后台逐页设计契约](frontend/30-admin-page-contract-index.md) | 229条路由的模块归属、新布局草案、控件/条件/跳转及接口匹配候选；不代表全量开工放行 |
| [前台匿名页面实测](frontend/38-front-browser-observations.md) | 官网、认证和商品入口实测；已登录客户页面与业务提交未验收 |
| [主题开发](03-themes.md) | 官网、客户中心、购物车主题及父子主题覆盖 |
| [插件开发](04-plugins.md) | addons 和各类接口插件的目录、生命周期、配置与菜单 |
| [HOOK 开发](05-hooks.md) | Hook 的发现、命名、参数、返回值和调试方法 |
| [实名认证接口](06-certification.md) | 个人/企业认证插件契约与业务状态 |
| [短信接口](07-sms.md) | 国内/国际短信插件、模板和发送链路 |
| [支付接口](08-payment.md) | 网关契约、支付发起、同步/异步回调和入账 |
| [邮件接口](09-mail.md) | 邮件插件、模板变量、附件和队列发送 |
| [工单传递](10-ticket-transfer.md) | 上下游部门映射、创建、回复和回传链路 |
| [第三方登录](11-oauth.md) | OAuth 登录插件、绑定策略和回调处理 |
| [服务器模块](12-server-modules.md) | 开通、暂停、续费、控制台及自定义按钮契约 |
| [使用财务系统登录并回调](13-finance-login-callback.md) | 财务系统作为身份源时的现有接口、接入流程和安全边界 |
| [安全审计暂不修复项](security-accepted-risks.md) | 已接受风险、不修原因、缓解要求和重新评估条件 |
| [OpenAPI 路由索引](api/openapi-routes.md) | 当前 `data/route/openapi.php` 的 `/v1` 路由清单 |
| [源码索引与覆盖矩阵](source-index.md) | 每类文档对应的权威实现与维护检查项 |

## 三类接口不要混用

```text
浏览器/客户端  -- /v1/* + 客户 JWT --> 本系统 OpenAPI
下游财务系统  -- /zjmf_api_login + JWT --> 本系统 Home 业务接口
本系统        -- zjmfCurl() + JWT ----> 上游财务系统
基础设施      -- /api/* -------------> 安装、模块同步、工单回传等系统接口
```

- `/v1/*` 是客户中心开放接口，主要路由在 `data/route/openapi.php`。
- `/api/*` 是历史系统集成接口，不是统一认证、统一版本的公共 OpenAPI。
- `zjmfCurl()` 是本系统调用另一套魔方财务实例的客户端封装，不是给浏览器使用的
  SDK。
- `/oauth/*` 是 QQ、微信等第三方身份插件入口；`/api/oauth/*` 则是让当前财务
  系统充当身份源的兼容接口，两者含义不同。

## 文档约定

- 示例域名统一使用 `https://finance.example.com`。
- JSON 中的 `status` 是业务状态，不等同于 HTTP 状态码。
- 标为“兼容接口”的能力按现状记录，不表示符合 OAuth、OpenAPI 等行业标准。
- 源码、路由和数据库迁移是最终事实来源。升级后应按
  [覆盖矩阵](source-index.md) 重新核对文档。
