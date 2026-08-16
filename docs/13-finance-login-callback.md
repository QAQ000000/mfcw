# 使用智简魔方财务系统登录并回调

## 1. 能力定位

当前仓库提供 `/api/oauth/*` 兼容接口，让另一个站点使用本财务系统的客户账号登录，
再把临时 `access_token` 带回调用方。它不是标准 OAuth 2.0/OIDC：没有
`client_id`、固定回调注册、授权码、PKCE、scope、标准 Token 端点或 ID Token。

若目标是接入 QQ、微信、支付宝等第三方登录，请使用
[第三方登录插件](11-oauth.md)，不是本章接口。

## 2. 接口清单

路由定义在 `data/route/api.php`，实现位于
`app/api/controller/OauthController.php`。

| 方法与路径 | 作用 |
| --- | --- |
| `GET /api/oauth/logined` | 获取财务登录能力；已有客户会话时生成自动授权票据 |
| `POST /api/oauth/accountGetAccessToken` | 在财务系统完成账号登录，生成临时 Token 和回调 URL |
| `POST /api/oauth/automaticGetAccessToken` | 已登录客户使用自动授权票据生成临时 Token |
| `POST /api/oauth/accountGetAccessTokenDirect` | 使用账号密码直接换 Token 的兼容接口 |
| `GET /api/oauth/getUserInfo` | 用临时 Token 获取客户资料和实名状态 |

Token TTL 为 3600 秒。用户资料可能包含 `username`、`phonenumber`、`email`、
`credit`、`user_certifi` 和 `real_name`，调用方必须按敏感个人信息处理。

## 3. 交互式登录流程

```text
业务站点                 财务系统                    客户
   |                       |                         |
   |-- 打开财务授权页 ---->|                         |
   |                       |<-- 输入账号/验证码 -----|
   |                       |-- 校验并建立客户 JWT -->|
   |<-- redirect_url?access_token=T ----------------|
   |-- GET /api/oauth/getUserInfo?access_token=T -->|
   |<-- 客户资料 -----------------------------------|
   |-- 建立本站会话                                  |
```

### 3.1 查询登录方式

```bash
curl 'https://finance.example.com/api/oauth/logined'
```

响应 `data.Login` 给出允许的邮箱、手机号、验证码及二次验证能力；`data.SmsCountry`
是手机号国家区号。若浏览器已登录财务系统，响应还包含一小时有效的
`authorize_json_web_token`，以及未脱敏的 `username`、`phonenumber`、`email`。

### 3.2 账号登录并生成回调

```bash
curl -X POST 'https://finance.example.com/api/oauth/accountGetAccessToken' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  --data-urlencode 'redirect_url=https://app.example.com/auth/callback' \
  --data-urlencode 'action=email' \
  --data-urlencode 'email=user@example.com' \
  --data-urlencode 'password=secret123'
```

`action` 的分派规则来自当前实现：

| `action` | 财务登录处理器 | 典型字段 |
| --- | --- | --- |
| `phone_code` | 手机验证码登录 | `phone`、`phone_code`、`code`，以及按配置要求的验证码字段 |
| `phone` | 手机密码登录 | `phone`、`phone_code`、`password`，以及按配置要求的验证码字段 |
| 其他值 | 邮箱/账号密码登录 | `email`/账号字段、`password`，以及按配置要求的验证码字段 |

成功响应不会直接发 302，而是返回要跳转的地址：

```json
{
  "status": 200,
  "msg": "success",
  "data": {
    "redirect_url": "https://app.example.com/auth/callback?access_token=<token>"
  }
}
```

前端读取后再跳转。调用方回调页必须从 URL 取出 Token，立即在服务端换取用户信息，
然后清除浏览器地址中的 Token。

### 3.3 已登录客户自动授权

先在同一浏览器会话请求 `/api/oauth/logined`，取得
`authorize_json_web_token`，再提交：

```bash
curl -X POST 'https://finance.example.com/api/oauth/automaticGetAccessToken' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  --data-urlencode 'redirect_url=https://app.example.com/auth/callback' \
  --data-urlencode 'authorize_json_web_token=<ticket>' \
  -b '<财务系统客户 Cookie>'
```

此流程依赖财务系统 Cookie，跨站前端还会受 SameSite、CORS 和浏览器第三方 Cookie
策略影响。推荐采用顶层页面跳转，不依赖跨域 AJAX 携带 Cookie。

### 3.4 换取用户资料

```bash
curl 'https://finance.example.com/api/oauth/getUserInfo?access_token=<token>' \
  -b '<财务系统客户 Cookie>'
```

交互式/自动模式下，当前实现仍通过财务 Cookie 找到客户会话；因此这个请求应在原
浏览器会话中完成。直接账号模式会把用户快照缓存到 `a.t.<token>`，不依赖 Cookie。

## 4. 直接账号模式

```bash
curl -X POST 'https://finance.example.com/api/oauth/accountGetAccessTokenDirect' \
  -H 'Content-Type: application/json' \
  -d '{"account":"user@example.com","password":"secret123"}'
```

成功返回 `data.access_token`。该模式会让业务站点接触客户的财务密码，无法实现最小
授权，也不支持标准撤销。仅用于受控的历史兼容场景，新系统不得采用。

## 5. 当前实现的上线风险

以下不是理论建议，而是当前控制器的实际边界：

1. `redirect_url` 只校验非空，没有注册或域名白名单，存在开放重定向和 Token 泄漏
   风险。
2. `access_token` 使用全局缓存键保存“最后一个 Token”，并发授权会互相覆盖；不
   适合多用户生产流量。
3. `authorize_json_web_token` 同样使用全局缓存键，不与用户、客户端、回调地址或
   浏览器会话绑定。
4. Token 放在查询字符串，可能进入浏览器历史、Referer、代理和访问日志。
5. 交互模式的 `getUserInfo` 同时依赖 Token 和财务 Cookie，不是真正的服务端
   Token 交换。
6. 没有 `state`、PKCE、scope、客户端认证、一次性消费和标准撤销机制。
7. `accountGetAccessTokenDirect` 直接接收财务账号密码，扩大凭据暴露面。
8. 直接账号模式没有检查客户账号停用状态，不能作为账号状态控制的替代入口。

因此，保持现状时只能部署在双方完全受控、HTTPS、低并发且有额外网络隔离的环境。
不能把这些接口直接作为公网统一登录平台。

## 6. 推荐的生产改造

应新增一套版本化授权码流程，而不是继续扩展全局缓存 Token：

```text
GET  /oauth2/authorize?client_id=...&redirect_uri=...&state=...&code_challenge=...
POST /oauth2/token {grant_type=authorization_code, code, code_verifier, client_id}
GET  /oauth2/userinfo  Authorization: Bearer <opaque_access_token>
POST /oauth2/revoke
```

最低要求：

- 后台登记 `client_id`、回调地址精确白名单和允许的 scope。
- 授权码使用至少 128 bit CSPRNG，保存哈希，只能使用一次，TTL 不超过 5 分钟。
- 授权码绑定客户、客户端、回调地址和 PKCE challenge。
- Access Token 每次授权唯一，数据库/缓存键包含 Token 哈希，不使用全局键。
- 用户资料端点只依据 Bearer Token，不依赖浏览器 Cookie。
- 回调保留并验证 `state`；所有错误也回到已登记地址且不泄漏凭据。
- 记录授权、换 Token、撤销审计日志，但只记录 Token 指纹。

在完成上述改造前，建议由受信业务后端做兼容接口代理，并在代理层实现固定回调
白名单、单用户互斥、一次性消费、短 TTL 和日志脱敏。
