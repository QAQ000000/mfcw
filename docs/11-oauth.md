# 第三方登录 OAuth 插件

## 1. 范围与入口

本章描述 QQ、微信、微博、支付宝等身份提供商登录插件。它们把供应商用户标识绑定到
本地 `clients`，与财务系统之间的 `/api/oauth/*` 身份兼容接口不是同一协议。后者见
[财务登录兼容回调](13-finance-login-callback.md)，不要复用本章插件的 `openid` 作为
跨财务系统访问令牌。

客户入口：

| 方法与路径 | 作用 |
| --- | --- |
| `GET /oauth` | 列出已启用且已配置的登录插件 |
| `GET /oauth/url/:dirName` | 生成供应商授权 URL 并跳转 |
| `GET /oauth/callback/:dirName` | 处理授权回调，登录、绑定或进入补充联系方式流程 |
| `GET /oauth/callbackInfo` | 返回当前补充绑定模式 |
| `POST /oauth/bind_login_email` | 验证邮箱验证码后绑定或注册 |
| `POST /oauth/bind_login_phone` | 验证短信验证码后绑定或注册 |
| `GET /oauthBind` | 登录后列出当前绑定 |
| `POST /oauthBind/untie/:dirName` | 解绑当前客户的供应商账号 |

后台通过 `GET /oauth` 和 `oauth/active`、`oauth/config`、`oauth/config_post`、
`oauth/suspend` 完成发现、安装、配置与启停。

## 2. 插件契约

目录、文件和类名必须使用相同的小写名称：

```text
public/plugins/oauth/acme/acme.php

namespace oauth\acme;
class acme { ... }
```

OAuth 插件不继承通用 `Plugin` 主类，固定实现四个方法：

| 方法 | 返回 | 契约 |
| --- | --- | --- |
| `meta()` | 一维数组 | `name`、`description`、`author`、`logo_url`、`version` |
| `config()` | 二维数组 | 声明后台配置字段 |
| `url(array $params)` | string | 创建授权 URL 并保存一次性状态 |
| `callback(array $params)` | array|string | 验证回调、换 token、查询用户；成功返回标准身份，内置插件失败时可能返回字符串 |

`config()` 每项以显示标签为键，值包含 `type`、`name`、`desc`。当前后台只约定
`text` 和 `textarea`；`name` 会成为传给 `url()`、`callback()` 的配置键。

`url()` 接收全部配置以及：

```php
[
    'name' => 'acme',
    'callback' => 'https://billing.example/oauth/callback/acme',
]
```

`callback()` 还会合并供应商回调查询参数，成功返回：

```php
[
    'openid' => '供应商内稳定且不可变的用户主体 ID',
    'data' => [
        'username' => '昵称',
        'sex' => 1,             // 1 男、2 女，其他值省略或归一为 0
        'province' => '省',
        'city' => '市',
        'avatar' => 'HTTPS URL',
    ],
    'callbackBind' => 'all',    // all|bind_mobile|bind_email|login
]
```

内置插件失败时会返回 `error` 或 `error,...` 字符串；核心没有统一的结构化错误契约，
只检查结果中是否存在 `openid` 后跳回客户页面。新插件应保持成功数组兼容，并避免在失败
字符串中泄露 token、密钥或供应商原始响应。

`openid` 必须是当前应用/租户下稳定的 provider subject，绝不能使用 access token、
refresh token、昵称或邮箱。失败应返回结构化错误或抛出受控异常；不要把供应商原始响应
和 token 返回浏览器。

`callbackBind=login` 会允许系统创建邮箱和手机号为空的新客户，属于高风险产品决策。
插件不能自行选择它，除非部署明确接受无联系方式账号，并已补齐风控与账号恢复流程。

## 3. 配置、会话与绑定数据

插件配置以普通 JSON 保存在 `plugin.config`。`clients_oauth` 保存：

- `type`：插件目录名；
- `uid`：本地客户 ID；
- `openid`：供应商稳定标识；
- `oauth`：昵称、头像等展示资料 JSON。

授权发起端使用 PHP Session 保存各插件的 `state`，核心 Session 还保存绑定后的跳转目标、
插件名、`openid`、用户资料和 `callbackBind`。插件必须使用密码学安全随机数，为每次授权
创建独立 state，绑定发起会话和插件，回调时恒定时间比较，并在首次使用后立即删除。

回调地址由系统登记域名固定构造，不接受请求参数覆盖。供应商后台必须精确登记 HTTPS
地址 `/oauth/callback/<name>`；不要使用通配回调域。

后台配置接口当前会返回已保存值，包括 secret 和私钥。安全实现应只返回掩码及
“已配置”状态；保存掩码时保留旧值，并对配置读取、修改和导出单独审计。

## 4. 调用生命周期

```text
GET /oauth
  -> 查询 plugin(module=oauth, status=1, config 非空)
  -> meta() 读取名称与 logo

GET /oauth/url/<name>
  -> 读取插件配置并构造固定 callback
  -> 插件 url() 创建 state 和供应商授权 URL
  -> 保存固定登录/客户中心返回位置
  -> 302 到供应商

GET /oauth/callback/<name>
  -> 插件 callback() 校验 state 和 code/auth_code
  -> 后端换取 token，再查询稳定 subject 和最小资料
  -> 当前已登录：绑定到当前 uid
  -> 已有 openid 绑定：签发本地 JWT/Cookie 并登录
  -> 无绑定：进入邮箱/手机验证码绑定
  -> callbackBind=login：注册空联系方式客户并绑定

GET /oauthBind / POST untie
  -> 按当前 request.uid 查询或删除 clients_oauth
```

绑定必须在数据库事务中执行“一个本地客户每种 provider 最多一个绑定”和“一个 provider
subject 最多绑定一个本地客户”两项约束。应用层先查再插不能抵御并发。

## 5. 安全风险与加固要求

- QQ、微信、微博示例关闭 TLS peer 和 host 校验，使授权码、access token 和用户身份可被
  中间人替换。应使用验证证书的 HTTPS 客户端、合理超时和供应商精确主机白名单。
- 微博插件把 `access_token` 作为 `openid` 保存。token 轮换会改变身份，还会把敏感 token
  长期写入数据库；必须改用响应中的稳定 `uid`，并迁移现有错误绑定。
- 示例的授权 URL 手工拼接键值，未统一 URL 编码。回调 URL、scope 或 state 中的特殊字符
  可能破坏参数边界；统一使用 `http_build_query(..., PHP_QUERY_RFC3986)`。
- `/oauth/url/:name` 和 `/oauth/callback/:name` 查询插件时没有要求 `status=1`。已配置但
  停用的插件仍可能被直接调用；运行入口必须同时检查安装、启用、配置完整和允许列表。
- 安装 SQL 只给 `clients_oauth` 的 `type`、`uid`、`openid` 建普通索引，没有
  `(type, uid)` 和 `(type, openid)` 唯一约束。并发绑定可能产生重复或账号串绑。
- `OauthModel::bind()` 使用 `sex != 1 || sex != 2`，该条件恒真，所有性别都会被归零；
  应改为集合校验并测试缺失、字符串和未知值。
- 多个回调分支调用 `bind()` 后忽略返回结果就重定向；`oauthBind/bind/:dirName` 路由还没有
  对应控制器方法。绑定失败可能表现为成功页面，需修复路由并统一检查结果。
- 插件 SVG logo 由服务器读取后直接返回。只允许随可信包安装的静态图，拒绝外链、脚本、
  事件属性和可变上传；更稳妥的是按图片 MIME 以静态资源响应。
- 头像 URL 和昵称来自供应商，进入本地资料前要限制长度、协议和主机并做输出转义；不要
  由服务器无约束抓取头像造成 SSRF。
- state 只解决登录 CSRF。现代供应商支持时还应使用 PKCE、nonce、最小 scope，并验证
  issuer、audience、签名和时间声明。

## 6. 实现检查

1. 覆盖 state 缺失、错误、重放、跨插件混用，以及 code 缺失和供应商错误响应。
2. 验证停用和未配置插件的 URL、callback 都不可直接访问。
3. 并发绑定同一 uid 和同一 subject，确认数据库唯一约束阻止重复。
4. 覆盖现有绑定登录、登录后绑定、邮箱绑定、手机绑定、解绑和客户已删除。
5. 确认日志、Session dump、错误页和后台配置响应不泄漏 code、token、secret 或私钥。

## 7. 权威源码

- 客户路由：`data/route/home.php`。
- 授权、回调和补充绑定：`app/home/controller/OauthController.php`。
- 登录后绑定列表/解绑：`app/home/controller/OauthBindController.php`。
- 绑定数据规则：`app/home/model/OauthModel.php`。
- 后台安装与配置：`app/admin/controller/OauthController.php`、`data/route/admin.php`。
- 官方契约：`public/plugins/oauth/README.md`。
- 可审查示例：`public/plugins/oauth/qq/qq.php`、`weixin/weixin.php`、
  `weibo/weibo.php`、`alipay/alipay.php`。
- 表结构：`public/install/thinkcmf.sql` 中的 `clients_oauth`。
