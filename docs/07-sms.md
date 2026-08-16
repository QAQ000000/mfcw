# 短信插件

## 1. 入口与分层

业务代码不应直接实例化具体供应商。统一入口是 `app\common\logic\Sms`：

| 方法 | 用途 |
| --- | --- |
| `sendSms($type, $phone, $param, ...)` | 按系统消息类型发送国内或国际短信 |
| `sendSmsForMarerking($phone, $msgid, $param, ...)` | 按指定模板发送营销短信 |
| `send($param, $templateParam, $rangeType)` | 选择供应商并调用插件的底层分发器 |

后台入口集中在 `data/route/admin.php` 的 `config_message/*` 路由：

- `GET|POST config_message/config_mobile*` 配置开关和供应商；
- `template_list`、`create_template`、`update_template*`、`delete_template` 管理模板；
- `set_sms*` 绑定业务消息类型与模板；
- `POST config_message/send_sms` 发送测试短信。

这些路由由 `ConfigMessageController` 处理。插件可以提供供应商模板 CRUD，但不能新增
绕过管理员权限的公共发送入口。

## 2. 插件契约

插件位于 `public/plugins/sms/<name>/`，主类继承 `app\admin\lib\Plugin` 并实现
`install()`、`uninstall()`。系统根据下列方法是否存在判断能力：

| 范围 | 模板方法 | 发送方法 |
| --- | --- | --- |
| 国内 `rangeType=0` | `getCnTemplate`、`createCnTemplate`、`putCnTemplate`、`deleteCnTemplate` | `sendCnSms` |
| 国际 `rangeType=1` | `getGlobalTemplate`、`createGlobalTemplate`、`putGlobalTemplate`、`deleteGlobalTemplate` | `sendGlobalSms` |
| 营销 `rangeType=2` | `getCnProTemplate`、`createCnProTemplate`、`putCnProTemplate`、`deleteCnProTemplate` | `sendCnProSms` |

发送方法接收一个数组：

```php
[
    'template_id' => '供应商模板 ID',
    'content' => '本地模板内容',
    'mobile' => '规范化后的号码',
    'templateParam' => ['code' => '123456'],
    'config' => [/* 当前插件配置 */],
]
```

成功返回 `['status' => 'success', 'content' => '最终发送内容']`；失败返回
`['status' => 'error', 'msg' => '可诊断但不泄密的原因', 'content' => '...']`。
核心以字符串 `success` 判断，不要改成 HTTP 风格整数状态。

模板 CRUD 的参数由后台控制器组装，插件必须保留本地模板和供应商模板 ID 的对应关系。
查询或创建结果中的模板应至少提供 `template.template_id`，审核状态统一映射为：
`1` 审核中、`2` 已通过、`3` 已拒绝。只有状态 `2` 的模板会进入正常发送选择。

## 3. 配置

全局配置保存在 `configuration` 表：

| 配置项 | 作用 |
| --- | --- |
| `shd_allow_sms_send` | 国内短信总开关 |
| `shd_allow_sms_send_global` | 国际短信总开关 |
| `shd_allow_sms_send_queue` | 使用 `SendSms` 数据库队列 |
| `sms_operator` | 国内默认供应商目录名 |
| `sms_operator_global` | 国际默认供应商目录名 |

供应商密钥存放在各插件 `config.php` 对应的 `plugin.config`：

- 阿里云：`AccessKeyId`、`AccessKeySecret`、`SignName`；
- IDCsmart / IDCsmart Pro：`api`、`key`、`sign`；
- 腾讯云：`SmsSdkAppId`、`AppKey`、`SecretId`、`SecretKey`、`SignName`；
- 短信宝：`user`、`pass`、`sign`；
- Submail：国内与国际各自的 app ID、app key、签名。

`plugin.config` 是普通 JSON，不是密文保险箱。后台读取应遮蔽密钥，保存空的脱敏占位符时
不得覆盖旧密钥。

## 4. 调用生命周期

```text
业务调用 Sms::sendSms(type, phone, params)
  -> 根据号码判断国内/国际
  -> 检查对应总开关和客户 send_close
  -> 可选推送 app\queue\job\SendSms
  -> 根据 sms_operator(_global) 选择已安装供应商
  -> 查 message_template_link + 审核通过的 message_template
  -> 合并系统、客户、产品和调用方模板变量
  -> 规范化手机号
  -> zjmfhook(<operator>, sms, <payload>, send*Sms)
  -> 写 message_log 和应用日志
```

队列 worker 调用对应的 `*Final()` 方法。只有处理过程抛出异常时，`SendSms` 才会最多
尝试 3 次，每次间隔 10 秒；达到上限后删除任务。worker 不检查 `handle()` 返回值，因而
返回 `false` 或业务失败结果的任务也会直接删除。插件应明确区分可重试异常与最终业务
失败，并对供应商超时和重复请求实现幂等或使用供应商侧唯一请求号。

模板生命周期为：后台创建本地记录 -> 插件提交供应商 -> 状态为 `1` -> 后台查询并映射
供应商审核结果 -> 状态 `2` 后绑定业务类型 -> 发送。删除模板时应先处理供应商结果，
再清理 `message_template` 和 `message_template_link`，并对部分失败给出可重试状态。

## 5. 安全风险与加固要求

- `AliyunPlugin` 的现存请求关闭 TLS 证书校验；IDCsmart 使用 HTTP；短信宝把账号、
  密码和内容放在 HTTP 查询串；Submail 也使用 HTTP 并以 app key 参与简单签名。
  新实现必须使用 HTTPS、验证主机和证书，并优先采用供应商当前官方 SDK。
- `Sms::sendBatchSms()` 无参数调用需要 `$rangeType` 的 `getSmsOperator()`，当前批量路径
  可能直接报错。启用批量发送前应修复并分别测试国内、国际及混合号码列表。
- 核心会记录号码、模板参数、最终内容和供应商响应。验证码、临时密码、重置链接、
  客户地址等可能进入日志；应按消息类型脱敏，并设置短保留期和严格读取权限。
- 号码分类仅靠正则。调用方仍要规范化国家码、验证允许地区和发送目的，避免把格式
  异常的国内号码误送到国际通道造成资费或合规问题。
- 模板变量必须按供应商规则编码，不能用字符串拼接构造 JSON、签名串或 URL。错误信息
  不得包含密钥、完整供应商响应或签名原文。
- 验证码发送要在业务入口做账号/IP/号码频率限制、用途绑定、过期和一次性消费；短信
  插件的发送成功不代表验证码流程安全。
- 营销短信必须遵守同意、退订、时间段和地区规则，并为重试设置去重键。

## 6. 实现检查

1. 测试插件停用、缺配置、未审核模板、国内/国际开关关闭和供应商超时。
2. 对三种能力逐一检查方法发现、模板 CRUD、状态映射和返回结构。
3. 同时运行同步与队列路径，验证返回失败时直接删除、抛异常时第 1、2、3 次重试及成功
   后的任务删除。
4. 检查号码和模板参数不会以明文出现在通用应用日志或异常页。
5. 使用供应商沙箱验证 Unicode、长短信、国家码、变量缺失和重复请求。

## 7. 权威源码

- 分发、模板选择和日志：`app/common/logic/Sms.php`。
- 队列重试：`app/queue/job/SendSms.php`。
- 后台配置与模板生命周期：`app/admin/controller/ConfigMessageController.php`。
- 后台路由：`data/route/admin.php`。
- 示例实现：`public/plugins/sms/aliyun/`、`idcsmart/`、`idcsmartpro/`、
  `qcloudsms/`、`smsbao/`、`submail/`。
