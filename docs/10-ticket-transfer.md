# 工单上游转发

## 1. 入口与数据模型

工单转发不是独立插件类型，而是客户工单、上游财务 API 和产品映射之间的集成层。

客户侧接收入口：

| 方法与路径 | 处理器 | 用途 |
| --- | --- | --- |
| `POST /ticket/create` | `TicketController::createTicket()` | 创建本地工单，也接收下游转发 |
| `POST /ticket/reply` | `TicketController::replyTicket()` | 创建本地回复，也接收下游回复 |
| `POST /v1/tickets` | `openapi/TicketController::createTicket()` | OpenAPI 创建工单并触发同一转发函数 |
| `POST /v1/tickets/:id/reply` | `openapi/TicketController::replyTicket()` | OpenAPI 回复并触发同一转发函数 |
| `POST /upload_image` | 上传控制器 | 接收先行上传的附件 |
| `POST /api/ticket_reply/sync` | `HostController::syncTicketReply()` | 上游管理员回复推回下游的兼容入口 |

后台配置路由为 `get_ticket_deliver`、`add_ticket_deliver`、`save_ticket_deliver`、
`delete_ticket_deliver`、`list_ticket_deliver`。`GET
common/get_upstream_ticket_department_list` 登录上游并读取 `/ticket/department`。

核心表及职责：

| 表 | 职责 |
| --- | --- |
| `ticket_department_upstream` | `(api_id, dptid)` 到 `upstream_dptid` 的部门映射 |
| `ticket_deliver` | 自动回复与关键字屏蔽配置 |
| `ticket_deliver_department` | 一条规则适用的本地部门 |
| `ticket_deliver_products` | 一条规则适用的产品 |
| `ticket` | `upstream_tid`、`is_deliver`、`is_receive` 保存转发状态 |
| `ticket_reply` | `is_deliver`、`is_receive` 保存回复方向状态 |

## 2. 转发与扩展契约

本地代码通过两个全局函数启动转发：

```php
ticketDeliver(int $ticketId): bool;
ticketReplyDeliver(int $ticketReplyId): bool;
```

创建工单必须同时满足：工单关联产品和部门命中同一条规则、产品是上游 API 产品、主机
存在大于 0 的 `dcimid`、部门对该 API 配置了 `upstream_dptid`。回复还要求原工单已经
保存非空 `upstream_tid`。

核心在执行前兼容两个可选全局扩展函数：

```php
resourceTicketDeliver($ticketId);
resourceTicketReplyDeliver($ticketReplyId);
```

它们只通过 `function_exists()` 发现，返回值会被忽略，并且调用后标准转发仍继续执行。
当前仓库未找到实现。不要把它们当作可替换核心流程的稳定插件 API；如需扩展，应先定义
明确的返回契约、错误传播、是否继续和幂等语义。

上游 HTTP 契约为：

```text
POST /ticket/create
Authorization: Bearer <JWT>

dptid=<upstream department>
hostid=<upstream host id / local dcimid>
title=<title>
content=<content>
attachment[]=<upstream saved names>
priority=<priority>
is_api=1
```

成功响应需要 `status=200` 和 `data.tid`。回复使用 `POST /ticket/reply`，字段为 `tid`、
`content`、`attachment`、`is_api=1`。接收端根据 `is_api` 的存在把记录标成
`is_receive=1`；该标志只是当前实现的方向标记，不是认证凭据。

## 3. 配置

部门编辑时设置 `is_related_upstream=1`，并为每个 `zjmf_finance_api` 选择一个
`upstream_dptid`。上游连接使用 `zjmf_finance_api.hostname`、`username` 和加密保存的
`password`；资源接口还受 `is_resource` 和 `ticket_open` 控制。

转发规则包含：

- `departments`：本地部门列表；
- `products`：`api_type=zjmf_api` 的产品列表；
- `is_open_auto_reply`：创建后是否增加本地自动回复；
- `bz`：自动回复正文；
- `mask_keywords`：按换行分隔，标题或正文命中时不向上游发送。

规则、部门映射和上游连接应作为一个发布单元验证。只打开 `is_related_upstream` 而没有
对应 API 部门映射，会使查询结果为空并静默跳过转发。

## 4. 调用生命周期

```text
客户创建本地工单
  -> TicketController 写 ticket
  -> ticketDeliver(ticket.id)
  -> 按产品 + 部门 + dcimid 查询规则及上游映射
  -> 非资源上游登录 /zjmf_api_login
     或资源上游登录 /resource_login
  -> 检查 mask_keywords
  -> 逐个 POST /upload_image
  -> Bearer POST /ticket/create
  -> 保存 data.tid 到 upstream_tid，is_deliver=1

客户回复本地工单
  -> TicketController 写 ticket_reply 并提交本地事务
  -> ticketReplyDeliver(reply.id)
  -> 使用原工单 upstream_tid
  -> 登录 /zjmf_api_login
  -> 上传附件并 Bearer POST /ticket/reply
  -> ticket_reply.is_deliver=1
```

接收端收到 `is_api=1` 后把工单或回复标为 `is_receive=1`，但仍会调用相同的
`ticketDeliver()`/`ticketReplyDeliver()`。正确的拓扑设计和代码防环都必须考虑这一点。

另一条兼容链路用于供应方管理员向下游推送回复：

```text
上游管理员回复工单
  -> pushTicketReply(ticket_reply.id)
  -> 从关联主机 stream_info 读取 downstream_url/token/id
  -> 上传附件并 POST <downstream>/api/ticket_reply/sync
  -> 下游按 ticket.upstream_tid 查本地工单
  -> 插入 is_receive=1 的管理员回复并通知客户
```

发送数据包含 `createSign()` 生成的签名字段，但当前
`HostController::syncTicketReply()` 没有读取或验证签名、Token、时间戳或 nonce；路由也
没有中间件。该兼容入口不能视为已认证回调。

转发在客户请求内同步执行，调用方通常不检查布尔返回值。本地工单可能已成功创建，而
上游仍未收到；`is_deliver=0` 只说明没有记录成功，不代表任务正在重试。

## 5. 安全风险与加固要求

- `curlUpload()` 上传附件时没有发送 Bearer JWT，而创建/回复请求有认证头。若上游上传
  接口需要认证，附件会静默丢失；若无需认证，则公网任意上传本身是风险。应让上传与
  业务请求使用同一认证、超时、TLS 和审计客户端。
- `/api/ticket_reply/sync` 可匿名调用，且只凭可猜测或泄露的上游工单 ID 定位记录。
  必须在应用层验证覆盖完整原始载荷的 MAC/签名、发送方身份、时间窗和持久 nonce；在
  修复发布前至少由反向代理限制精确可信来源。
- `pushTicketReply()` 调用 `commonCurl()` 后不检查 HTTP 或业务响应就写
  `ticket_reply.is_deliver=1`。应只在对端幂等接收成功后标记，并把失败保存到可重试的
  outbox，不能依赖人工猜测哪些回复已经丢失。
- 创建路径支持资源上游的 `/resource_login`，回复路径始终使用 `/zjmf_api_login`，
  资源型工单可能创建成功但无法转发回复。两条路径需要共享上游类型判断。
- 同步 HTTP 失败不会回滚本地工单，调用方也忽略返回值；当前没有可见的持久化重试
  队列。应增加 outbox/任务表、指数退避、最终失败告警和管理员手动重试。
- `mask_keywords` 使用大小写敏感的原始子串匹配，没有 trim、Unicode 归一化或规则版本。
  它不能作为敏感数据防泄漏机制；应使用结构化数据分类和发送前审计策略。
- `is_api` 是请求字段，接收控制器只按“存在”设置 `is_receive`。认证和来源判断必须来自
  有效 JWT 的服务身份，不能信任该标志；普通客户也不应能伪造内部方向状态。
- 接收记录仍调用转发函数，核心函数也没有显式排除 `is_receive=1`。只靠部署映射可能
  形成 A -> B -> A 循环。应携带不可伪造的来源系统 ID、全局事件 ID 和 hop 限制，并在
  数据库建立去重记录。
- 标准函数调用可选 `resourceTicket*` 后仍继续，可能重复向两个通道发送。扩展生效前
  应定义互斥或组合规则，并为每个目标保存独立状态。
- 附件文件名和路径必须防目录穿越、软链接逃逸和恶意 MIME；上游返回的 `savename`
  只能当作不透明 ID，不能直接拼成本地路径。
- 上游地址和凭证属于 SSRF/密钥边界。只允许管理员配置的 HTTPS 精确域名，验证证书，
  禁止重定向到内网或非预期主机，日志中不得记录 JWT 和明文密码。

## 6. 实现检查

1. 覆盖无规则、缺部门映射、无 `dcimid`、屏蔽词命中和资源接口关闭。
2. 模拟登录、附件上传、创建、回复各阶段超时，并确认可观测、可重试且不会重复工单。
3. 建立 A/B 双向测试，确认 `is_receive`、事件 ID 和 hop 限制能阻止循环。
4. 验证多附件部分失败的策略，不能在不告知的情况下只转发正文。
5. 检查客户不能伪造 `is_api`，JWT 服务身份只能访问其被授权的上游主机和工单。

## 7. 权威源码

- 转发函数与上传 helper：`app/common.php` 中的 `ticketDeliver()`、
  `ticketReplyDeliver()`、`curlUpload()`。
- 下游回复推送：`app/zjmf.php` 中的 `pushTicketReply()`。
- 接收路由：`data/route/home.php`。
- 兼容回传路由与接收实现：`data/route/api.php`、
  `app/api/controller/HostController.php`。
- 工单创建与回复：`app/home/controller/TicketController.php`、
  `app/openapi/controller/TicketController.php`。
- 规则管理：`app/admin/controller/TicketDeliverController.php`。
- 部门映射：`app/admin/controller/TicketDepartmentController.php`。
- 上游部门查询：`app/admin/controller/CommonController.php`。
- 后台路由：`data/route/admin.php`。
