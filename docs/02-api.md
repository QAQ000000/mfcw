# API 开发与调用

## 1. API 面划分

| API 面 | 路由来源 | 主要调用方 | 认证 |
| --- | --- | --- | --- |
| 客户 OpenAPI `/v1/*` | `data/route/openapi.php` | SPA、APP、客户集成 | 公开组使用 `UserCheck`；业务组使用 `Check` |
| 系统 API `/api/*` | `data/route/api.php` | 安装器、服务器模块、上下游回传 | 每条路由分别决定，不能假定统一认证 |
| Home 业务接口 | `data/route/home.php` | 内置客户主题、上游财务实例 | `UserCheck`/`Check` 或接口自身校验 |
| 管理 API | `data/route/admin.php` | 内置管理端 | `AdminCheck`/管理员会话 |
| 上游调用封装 | `app/zjmf.php` | 当前实例调用另一财务实例 | `/zjmf_api_login` 后 Bearer JWT |

## 2. 客户 OpenAPI

### 2.1 基础地址与格式

```text
https://finance.example.com/v1
Content-Type: application/json
Authorization: JWT <jwt>
```

代码只取 `Authorization` 中空格后的第二段，历史客户端也可能发送其他 scheme；新
接入统一使用 `JWT`。登录 Cookie 存在时，中间件会优先采用 Cookie 中的 JWT。

典型响应：

```json
{
  "status": 200,
  "msg": "success",
  "data": {}
}
```

不能只按 HTTP 200 判断成功，必须同时检查 JSON `status`。常见业务状态：

| `status` | 含义 |
| --- | --- |
| `200` | 成功 |
| `400`/`406` | 参数或业务校验失败 |
| `401` | 子账户权限不足 |
| `405` | 未登录、会话失效或需要重新登录 |
| `409` | 状态冲突，刷新数据后重试 |
| `503` | 维护模式 |
| `1001` | 部分接口中的幂等成功/Token 验证通过，须结合具体接口 |

### 2.2 登录

普通客户登录：

```bash
curl -X POST 'https://finance.example.com/v1/login' \
  -H 'Content-Type: application/json' \
  -d '{"email":{"email":"user@example.com","password":"secret123"}}'
```

请求体按登录方式使用 `email`、`phone` 或 `phone_code` 子对象。图形验证码启用时还
需提交 `captcha` 和 `idtoken`。成功响应包含 `jwt`；开启二次验证时应先按响应提示
完成 `/v1/second_verify`。

财务上下游 API 账号登录：

```bash
curl -X POST 'https://finance.example.com/v1/login_api' \
  -H 'Content-Type: application/json' \
  -d '{"account":"user@example.com","password":"API_KEY"}'
```

它使用客户后台生成的 API 密钥，不是客户登录密码，并要求后台开启资源 API、客户
状态正常且 `api_open=1`。成功返回：

```json
{"jwt":"<jwt>","status":200,"msg":"login successful"}
```

当前 `api_password` 使用源码固定密钥的 DES-CBC 可逆保存，客户和管理接口还会解密后
展示。数据库与源码同时泄露即可还原全部 API 密钥。生产改造应生成高熵、只显示一次的
密钥，只保存带独立 salt 的慢哈希或专用 Token 哈希；迁移期间应轮换旧密钥并保留吊销、
最后使用时间和审计能力。

### 2.3 已认证请求

```bash
curl 'https://finance.example.com/v1/user' \
  -H 'Authorization: JWT <jwt>'
```

JWT 默认有效期 7200 秒，但仅签名和时间有效还不够：缓存中的登录映射必须存在，
密码修改时间、账号状态和可选 IP 绑定也会使 Token 失效。

### 2.4 路由分组

完整清单见 [OpenAPI 路由索引](api/openapi-routes.md)。主要资源如下：

| 资源 | 路径示例 | 操作 |
| --- | --- | --- |
| 登录注册 | `/v1/login`、`/v1/register`、`/v1/pwreset` | 登录、注册、找回密码 |
| 用户与实名 | `/v1/user`、`/v1/real_name_auth/*` | 资料、安全设置、实名认证 |
| 购物车 | `/v1/goods*`、`/v1/cart*` | 商品配置、购物车、优惠码、结算 |
| 产品/服务 | `/v1/products*`、`/v1/hosts*` | 列表、续费、升降级、模块操作 |
| 账单支付 | `/v1/invoices*`、`/v1/pay`、`/v1/funds` | 账单、余额、支付 |
| 工单 | `/v1/tickets*` | 创建、详情、回复 |
| 内容 | `/v1/news*`、`/v1/knowledgebase*`、`/v1/downloads*` | 公告、知识库、下载 |
| 日志消息 | `/v1/log/*`、`/v1/message*` | 客户日志和系统消息 |

### 2.5 内置接口文档

`GET /document` 由 `app/openapi/controller/DocumentController.php` 渲染文档页。当前
入口读取 `app/openapi/documents/config.php` 列出的静态 PHP 文档数组，并没有调用
仓库中现存的反射解析器实时扫描控制器。因此它是“提交时快照”，不是现行接口的
唯一事实来源。它适合开发环境核对，不应无保护暴露在生产公网。

新增或修改 OpenAPI 时，应先以路由和控制器实现为准，再同步静态文档数据及控制器
注释。历史解析器只支持位置型注释，而现有控制器还使用 `.name:id` 风格，不能假定
注释能被自动可靠重建。常见注释形式为：

```php
/**
 * @title 接口标题
 * @description 业务说明
 * @url /resource/:id
 * @method POST
 * @param .name:id type:int require:1 desc:资源 ID
 * @return .field:'字段说明'
 */
```

## 3. 系统 API

`data/route/api.php` 混合了安装、升级、模块同步、工单回传、商品读取和身份兼容
接口。它没有统一的版本、认证或响应契约，接入前必须逐条检查路由中间件和控制器。

重点接口：

| 路径 | 用途 | 约束 |
| --- | --- | --- |
| `/api/host/sync` | 下游主机信息同步 | 使用弱签名兼容校验，见下方风险说明 |
| `/api/ticket_reply/sync` | 上游工单回复回传 | 仅按工单映射定位；当前没有接口认证 |
| `/api/exec_module_func` | 历史供应模块动态分发 | 无路由中间件，依赖模块 `ApiAuth()` 且行为受加载顺序影响 |
| `/api/oauth/*` | 财务系统身份源兼容接口 | 见专门文档，当前不是标准 OAuth 2.0 |
| `/api/install/*` | 安装流程 | 安装完成后必须从网络层限制 |
| `/<admin>/upgrade/*` | 升级操作 | `AdminCheck` |

不要把 `/api/*` 整体加入匿名 CORS，也不要以路径前缀替代逐接口鉴权。

`ApiCheck` 分组在 `group("api")` 内又声明了以 `api/` 开头的路径。框架实际注册的
三个 URL 是 `/api/api/host_server`、`/api/api/host`、`/api/api/host/free`，不是
控制器注释中容易推断出的单 `/api` 路径。应以 `php think route:list` 为准。

当前已确认的悬空路由包括：

- `/v1/hosts/:id/actions/upgradeconfig/select` 指向不存在的
  `HostController::upgradeConfigSelect()`；
- `/api/botMessage` 指向仓库中不存在的 `BotController`；
- `/person_query_post`、`/company_query_post` 指向实名认证控制器中不存在的方法；
- `/oauthBind/bind/:dirName` 指向第三方绑定控制器中不存在的 `bind()`。

在实现补齐前，接入方不能依赖这些接口。修改路由后应增加自动检查，确认每个控制器类和
公开方法真实存在。

### 3.1 现有系统 API 安全边界

- `/api/ticket_reply/sync` 路由没有中间件，控制器也没有签名或 Token 校验；部署时
  必须先在反向代理限制可信来源，并尽快补应用层认证。
- 主机同步签名只覆盖 `id`、`token`、`rand_str` 的大写 MD5，不含时间戳、持久
  nonce 和其他业务字段，不能抵御重放和载荷替换。
- `ApiCheck` 使用 Base64 编码的账号密码、MD5 比对和 IP 白名单，是历史兼容认证，
  不能等同于安全的请求签名。
- `/api/exec_module_func` 不在 `ApiCheck` 分组，只尝试模块自定义 `ApiAuth()`；其前置
  `function_exists()` 条件还会在模块已被当前进程提前加载时错误拒绝合法函数，导致行为
  受加载顺序影响。修复时必须同时增加统一服务认证和固定能力白名单，不能只调整条件后
  直接开放。
- `userSetCookie()` 使用旧式 `setcookie()` 参数，没有显式设置 `Secure`、`HttpOnly` 和
  `SameSite`。生产登录 Cookie 应仅经 HTTPS 发送、禁止脚本读取，并按同站/跨站登录流程
  选择明确的 SameSite 策略；同时回归退出登录和自定义 Cookie 域。
- `app/zjmf.php` 的历史 HTTP 封装关闭 TLS 证书和主机校验；完成修复前只能在受控
  网络使用，不能把忽略证书错误作为部署步骤。

## 4. 调用上游财务 API

业务代码使用：

```php
$result = zjmfCurl(
    $apiId,
    'host/header',
    ['host_id' => $upstreamHostId],
    10,
    'GET'
);

if (($result['status'] ?? 0) !== 200) {
    // 记录脱敏上下文，并按业务决定重试或回滚
}
```

`zjmfCurl()` 从 `zjmf_finance_api` 读取上游地址和加密密码，登录
`/zjmf_api_login`，缓存 JWT，并携带 `Authorization: Bearer <jwt>` 调用目标路径。
返回 `405` 时刷新 JWT 后只重试一次。上传附件必须使用 `zjmfCurlHasFile()`。

外部调用规范：

- 给连接、整体请求分别设置有限超时；不要无限重试。
- 只重试可幂等请求，写操作使用业务幂等键。
- 日志记录上游 API ID、路径、耗时和业务状态，不记录密码、JWT 或完整实名数据。
- 上游失败时不要伪造成功；明确返回本地降级、待重试或业务失败。

## 5. API 变更检查表

1. 路由方法、中间件和控制器方法一致。
2. 不接受客户端提供的 `uid`、价格、权限、`is_api` 作为可信事实。
3. 列表接口限制 `page`/`limit`，避免 `max` 或无界导出绕过权限。
4. 写接口具备幂等、事务、并发和重复回调策略。
5. 上传接口执行文件类型、大小、路径和归属校验。
6. 错误响应不返回堆栈、SQL、密钥或上游凭据。
7. 更新控制器注释、路由索引和至少一个成功/失败回归测试。
