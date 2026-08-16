# 邮件插件

## 1. 入口与分层

业务代码统一调用 `app\common\logic\Email`，不要直接依赖 SMTP 或具体供应商：

| 方法 | 用途 |
| --- | --- |
| `sendEmailDirct($email, $subject, $message, ...)` | 直接向明确地址发送 |
| `sendEmailDiy($relid, $subject, ..., $type)` | 按关联对象解析收件人并发送自定义内容 |
| `sendEmailBase($relid, $name, $type, ...)` | 按模板名称发送，可进入数据库队列 |
| `sendEmail($templateId, $relid, ...)` | 按模板 ID 发送 |
| `sendEmailCode($email, $code, ...)` | 发送验证码模板 |

后台模板入口位于 `data/route/admin.php` 的 `email_template/*`：列表、创建、编辑、多语言、
启停、删除和供应商切换由 `EmailTemplateController` 处理。测试和批量发送还分别出现在
`config_general/send_email`、`config_general/batch_send_email` 和
`config_message/send_email`。

业务入口负责确认收件对象和发送目的；邮件插件只负责传输，不能提供绕过业务权限的
任意收件人公共接口。

## 2. 插件契约

插件位于 `public/plugins/mail/<name>/`，主类继承 `app\admin\lib\Plugin`，实现
`install()`、`uninstall()` 和：

```php
public function send(array $params): array
```

`$params` 的稳定字段为：

```php
[
    'email' => 'recipient@example.com',
    'subject' => '主题',
    'content' => '<p>HTML 正文</p>',
    'attachments' => 'stored^name.pdf,stored2^name2.png',
    'config' => [/* 当前邮件插件配置 */],
]
```

成功返回 `['status' => 'success']`；失败返回
`['status' => 'error', 'msg' => '可诊断但不泄密的原因']`。核心以字符串 `success`
判断结果。插件应抛出可重试的传输异常，或返回明确业务失败，不能把供应商拒绝伪装成
成功。

附件字段是逗号分隔的存储名，现有插件从 `public/upload/common/email/` 读取，并用
`^` 后的部分作为原文件名。开发新插件时应通过受控附件服务解析，校验真实路径位于
允许目录内；不要直接拼接调用方传入的文件名。

当前插件参数没有传递结构化 `cc`/`bcc`，尽管核心模板和日志保存了 `copyto`、
`blind_copy_to`。若扩展该契约，需要同步修改所有传输插件、队列序列化和测试，不能让
单个插件自行从全局请求读取抄送人。

## 3. 模板、类型与配置

模板保存在 `email_templates`，支持以下关联类型：

- `general`：客户；
- `product`：产品/主机；
- `invoice`：账单关联产品；
- `support`：工单；
- `admin`：管理员；
- `notification`：通知对象；
- `credit_limit`：信用额账单，查模板时按 `invoice` 兼容。

发送前核心根据 `relid` 解析 `uid` 和邮箱，选择客户语言模板，替换系统、客户、产品、
账单或工单变量，然后触发 `before_email_send` Hook。Hook 参数只有 `email`、`subject`
和 `content`，Hook 修改行为应通过测试确认，不能假设引用修改一定回写。

全局 `email_operator` 指定启用的邮件插件，`shd_allow_email_send_queue` 控制
`SendMail` 队列。供应商配置示例：

| 插件 | 配置字段 |
| --- | --- |
| SMTP | `charset`、`port`、`host`、`username`、`password`、`smtpsecure`、`fromname`、`systememail` |
| Ali mail | `accessKeyId`、`accessKeySecret`、`accountName`、`fromAlias` |
| IDCsmart mail | `api`、`key`、`from`、`from_name` |
| Submail | `AppId`、`AppKey`、`fromname`、`systememail` |

配置保存于 `plugin.config`。SMTP 密码、API key 和 access secret 必须脱敏显示，日志及
异常不能包含完整连接串或认证头。

## 4. 调用生命周期

```text
业务调用 sendEmailBase(relid, templateName, type, ...)
  -> shd_allow_email_send_queue ? 推送 SendMail : 直接执行
  -> 根据 type + relid 解析 uid 和收件邮箱
  -> 按客户语言查找启用模板，缺失时回退默认语言
  -> 替换主题和正文变量
  -> 组装附件存储名
  -> hook(before_email_send)
  -> 检查 email_operator 对应插件已启用
  -> zjmfhook(<operator>, mail, <payload>, send)
  -> 写邮件日志
```

`SendMail` 调用 `sendEmailBaseFinal()`；只有处理过程抛出异常时才会最多尝试 3 次，每次
间隔 10 秒，达到上限后删除任务。worker 不检查 `handle()` 返回值，返回 `false` 或业务
失败结果时也会直接删除。插件应明确哪些失败需要抛出可重试异常，并使用稳定的消息标识
或供应商幂等能力，避免“供应商已接收但本地超时”导致重复邮件。

`sendEmailDiy(..., $sync=true)` 走另一套历史 `SendActivationMarketing` 延迟队列，而
`sendEmailBase()` 才受 `shd_allow_email_send_queue` 控制。调用方要确认使用的是哪条队列
链路，不要把参数名 `$sync` 理解成统一的同步/异步开关。

## 5. 安全风险与加固要求

- `IdcsmartmailPlugin` 把 API 凭证、邮件内容和附件发送到 HTTP 地址；Submail 和 Ali
  mail 的现存 cURL 代码关闭 TLS 证书校验。必须改为验证主机及证书的 HTTPS，并限制
  允许的供应商 endpoint。
- `SmtpPlugin::send()` 把主收件人同时添加为 To、CC 和 BCC，会造成重复投递且没有实现
  核心模板的真实抄送意图。应只添加一次 To，并通过明确的新契约处理经授权的 CC/BCC。
- `sendEmailBase()` 推送 `SendMail` 时没有序列化 `adminid` 和 `ip`，但 worker 支持这些
  字段。队列模式可能退回管理员 ID 1 或使用 worker IP，导致审计和模板内容与直发不同。
- 模板会被 `htmlspecialchars_decode()` 后作为 HTML 发送。只有受信管理员可编辑模板，
  所有来自工单、客户、产品等变量应按 HTML 上下文转义，URL 属性还要单独验证协议。
- 邮件日志可能保存完整正文、地址、抄送人和错误。验证码、临时密码、token、账单信息
  应最小化记录并设置保留期；管理员查阅日志需要独立权限。
- 附件路径来自数据库字符串。必须拒绝 `../`、绝对路径、软链接逃逸和不存在文件，校验
  文件大小及 MIME，并在发送前检查当前业务对象仍有权访问该附件。
- 发件地址、Return-Path 和域名要与 SPF、DKIM、DMARC 配置一致。不能允许请求参数覆盖
  发件人或供应商 API endpoint。
- 队列重试对验证码等时效消息尤其危险；worker 发送前应确认验证码未过期，且业务已
  撤销的消息不再投递。

## 6. 实现检查

1. 覆盖插件停用、配置缺失、连接/读取超时、认证失败、配额拒绝和供应商 5xx。
2. 比较直发、`SendMail` 与历史延迟队列的收件人、变量、管理员和 IP 是否一致。
3. 测试模板语言回退、禁用模板、恶意 HTML 变量和不存在的关联对象。
4. 测试多附件、Unicode 文件名、目录穿越、超限文件和队列执行前附件被删除。
5. 确认 To/CC/BCC、邮件日志、重试次数和供应商去重行为符合预期。

## 7. 权威源码

- 模板解析、分发、Hook 和日志：`app/common/logic/Email.php`。
- 队列重试：`app/queue/job/SendMail.php`。
- 后台模板管理：`app/admin/controller/EmailTemplateController.php`。
- 后台路由：`data/route/admin.php`。
- 可审查传输插件：`public/plugins/mail/smtp/`、`alimail/`、`idcsmartmail/`、
  `subemail/`。
