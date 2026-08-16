# 财务系统开发指南

## 1. 技术基线

- 产品版本：`3.7.7`，根目录 `version` 为发布版本来源。
- 框架：ThinkPHP 5.1 系列 + ThinkCMF 5.1 风格组件。
- 主要运行时：PHP、MySQL、框架缓存、数据库队列 worker。
- 模板：ThinkPHP 模板语法，文件扩展名主要为 `.tpl`。
- 客户认证：HS256 JWT，同时要求缓存中存在
  `client_user_login_token_<JWT>` 会话映射。

根目录没有用于重新解析依赖的 `composer.json`/`composer.lock`。不要在生产实例中
直接运行 `composer update`；现有 `vendor/` 应视作发布包的一部分。

## 2. 目录与职责

| 路径 | 职责 |
| --- | --- |
| `data/route/` | Admin、Home、OpenAPI 和系统 API 的显式路由 |
| `app/admin/` | 管理端控制器、验证器、模型、Cron 命令 |
| `app/home/` | 客户中心页面及内部业务接口 |
| `app/openapi/` | `/v1` 客户 OpenAPI 和内置文档生成器 |
| `app/api/` | 安装、升级、服务器同步、OAuth 兼容等系统接口 |
| `app/common/logic/` | 跨控制器的订单、商品、支付、短信、邮件等业务逻辑 |
| `app/http/middleware/` | JWT、管理员、跨域和应用认证 |
| `app/queue/`、`app/common/job/` | 数据库队列任务 |
| `public/plugins/` | Addons 与实名、短信、支付、邮件、登录、服务器插件 |
| `public/themes/` | 官网、客户中心和购物车主题 |
| `public/upgrade/` | 当前分支的版本数据库变更 |
| `tests/` | 当前以可直接执行的 PHP 回归脚本为主 |

框架在 `app/app.php` 中注册额外根命名空间。历史发布包还可能在根目录
`modules/{gateways,servers,oauth}` 提供同类模块；当前仓库主要使用
`public/plugins/*`。开发新模块应优先放入现有插件目录，不要同时安装两个同名实现。

## 3. 请求链路

### 3.1 客户 OpenAPI

```text
data/route/openapi.php
  -> UserCheck（公开/可选登录接口）或 Check（必须登录接口）
  -> app/openapi/controller/*
  -> app/common/logic/* / model / Db
  -> JSON {status,msg,data}
```

`Check` 会优先读取客户 Cookie，并覆盖 `Authorization` 请求头。通过验证后在请求
对象写入 `uid`、`contactid`、`uname`、`is_api`。业务代码应使用这些服务端属性，
不能信任客户端提交的同名字段。

### 3.2 页面渲染

```text
data/route/home.php -> View*Controller -> ViewModel/业务控制器
                    -> public/themes/{web,clientarea,cart}/<主题>/*.tpl
```

官网、客户中心、购物车分别有独立主题选择项。父主题回退规则和模板变量见
[主题开发](03-themes.md)。

### 3.3 上下游财务调用

```text
业务逻辑 -> zjmfCurl(api_id, path, data, timeout, method)
        -> /zjmf_api_login 获取或刷新 JWT
        -> Authorization: Bearer <JWT>
        -> 上游业务接口
```

JWT 按 `zjmf_finance_jwt_<api_id>` 缓存 5400 秒；上游返回业务状态 `405` 时会强制
重新登录并重试一次。文件请求使用 `zjmfCurlHasFile()`。

## 4. 配置与状态

- 文件配置位于 `app/config/*.php`；实例数据库连接文件不应提交或覆盖。
- 大量后台配置保存在 `configuration` 表，通过 `configuration()` 和
  `updateConfiguration()` 读写。
- 插件安装、状态和序列化配置保存在 `plugin` 表。
- 缓存不是纯性能层：JWT 会话、验证码、限流、同步状态都依赖缓存。切换缓存驱动
  前必须验证 TTL、原子增减和多进程可见性。
- Cron 入口为 `php think cron`；登录通知等异步任务还需要独立数据库队列 worker，
  部署见 `deploy/queue/README.md`。

## 5. 数据库与事务

控制器中既有模型，也有大量 `think\Db` 直接查询。新增跨表写入时应遵循：

1. 在做外部 HTTP 请求之前完成输入和权限校验。
2. 不在数据库事务中等待上游接口，除非确实需要锁住本地状态且有明确超时。
3. 订单、库存、余额和发票写入使用事务，并在所有异常路径回滚。
4. 迁移必须幂等，写入 `public/upgrade/` 的现有版本迁移体系，并提供重复执行测试。
5. 不根据客户端提交的价格、`uid`、`is_api`、上游 ID 直接记账。

## 6. 新功能的放置规则

| 需求 | 推荐位置 |
| --- | --- |
| 新客户 API | `data/route/openapi.php` + `app/openapi/controller/` |
| 新管理 API | `data/route/admin.php` + `app/admin/controller/` |
| 跨入口业务规则 | `app/common/logic/` |
| 可安装业务功能 | `public/plugins/addons/<name>/` |
| 外部服务适配 | 对应的 `public/plugins/<type>/<name>/` |
| 页面视觉覆盖 | 新主题或子主题，不直接改 `default` |
| 异步重试任务 | `app/queue/job/` 或现有 Job 体系 |

控制器只负责请求适配、权限和响应；可被 Home、OpenAPI、Cron 同时调用的规则应下沉
到逻辑层。外部服务的密钥必须进入插件配置，不可写死在代码、模板或前端资源里。

## 7. 开发与验证流程

1. 从路由确认真实 HTTP 方法、路径和中间件。
2. 从控制器确认输入、业务状态及副作用，再查看逻辑层和插件调用。
3. 对写操作增加成功、重复请求、外部超时、权限失败和事务回滚测试。
4. 对插件至少测试未配置、停用、异常返回、超时和回调重放。
5. PHP 文件运行 `php -l`，回归脚本按 `php tests/<name>.php` 执行。
6. 更新 API 后同步维护 `app/openapi/documents/config.php` 引用的静态文档数据、
   控制器注释和路由索引；访问 `/document` 只用于检查最终静态快照。

## 8. 安全底线

- 所有回调先验签，再依据本地订单查询金额和币种；不要信任回调金额。
- URL 回调和跳转地址必须使用后台登记的精确白名单。
- JWT、支付密钥、短信/邮件密钥不得出现在 URL、日志和异常响应中。
- HTML 输出按来源净化；只有经过明确权限控制的管理员富文本才能进入信任边界。
- 上传同时校验扩展名、MIME、文件头、大小和保存路径，禁止脚本落入 Web 可执行目录。
- 服务器模块操作必须校验主机归属，不能只凭客户端传入的 `hostid`。
