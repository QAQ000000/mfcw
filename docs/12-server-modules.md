# 服务器模块

## 1. 入口与职责

服务器模块把产品/主机生命周期映射到外部面板、虚拟化平台或资源供应商。主要 HTTP
入口为：

| 范围 | 方法与路径 | 作用 |
| --- | --- | --- |
| 后台 | `GET /provision/list` | 发现模块 |
| 后台 | `GET /provision/metadata` | 读取 `MetaData()` |
| 后台 | `GET /provision/:serverGroupId` | 读取产品配置字段 |
| 后台 | `POST /provision/default` | 执行开通、暂停、删除、电源等标准动作 |
| 后台 | `POST /provision/custom` | 执行已声明的后台自定义按钮 |
| 客户 | `POST /provision/default` | 执行允许客户使用的标准动作 |
| 客户 | `POST /provision/custom/:id`、`/provision/button` | 自定义函数/按钮 |
| 客户 | `GET /provision/chart/:id` | 读取图表数据 |
| 客户 | `GET /provision/custom/content` | 渲染模块客户区内容 |
| 客户 OpenAPI | `GET /v1/hosts/:id/module` | 返回当前主机可用模块能力 |
| 客户 OpenAPI | `PUT /v1/hosts/:id/module/{on,off,reboot,...}` | 电源、重装、密码、控制台等标准动作 |
| 客户 OpenAPI | `GET /v1/hosts/:id/module/{charts,custom,status}` | 图表、自定义区和状态查询 |
| 系统 API | `GET|POST /api/exec_module_func` | 无统一中间件的历史模块分发入口 |
| 系统 API | `GET /api/product/:id/resource` | 特定内置模块的资源包信息 |

后台由 `ProvisionController` 适配请求，客户入口由 Home 的 `ProvisionController` 处理；
产品状态、邮件和本地字段更新还经过 `app\common\logic\Host`。模块应只实现供应商适配，
不要另建绕过这些归属、状态和权限检查的公共控制器。

## 2. 发现、命名与配置契约

系统扫描两个位置：

```text
modules/servers/<module>/<module>.php
public/plugins/servers/<module>/<module>.php
```

目录名匹配 `^[a-z][a-z0-9]+$`，即以小写字母开头，后面至少一个小写字母或数字。文件
定义全局函数，前缀固定为 `<module>_`：

```php
function acme_MetaData() { ... }
function acme_ConfigOptions() { ... }
function acme_CreateAccount($params) { ... }
```

不要在两个根目录安装同名模块。发现过程会 `require_once` PHP 文件并调用
`<module>_MetaData()`；仅浏览后台模块列表就已经执行包内代码。

`MetaData()` 返回：

```php
[
    'DisplayName' => 'Acme Cloud',
    'APIVersion' => '1.0',
    'HelpDoc' => 'https://docs.example/module',
]
```

`ConfigOptions()` 最多读取 23 项。每项支持 `text`、`password`、`yesno`、`radio`、
`dropdown`、`textarea`，常用键为 `name`、`description`、`default`、`key`，文本类还可有
`placeholder`，选择类使用 `options`。稳定的 `key` 会把产品 `config_optionN` 或可配置项
映射到 `$params['configoptions'][$key]`。

## 3. 标准生命周期契约

系统通过 `function_exists()` 发现大多数能力：

| 分组 | 函数后缀 |
| --- | --- |
| 账号 | `CreateAccount`、`SuspendAccount`、`UnsuspendAccount`、`TerminateAccount` |
| 计费 | `Renew`、`ChangePackage` |
| 电源 | `On`、`Off`、`Reboot`、`HardOff`、`HardReboot` |
| 维护 | `Reinstall`、`CrackPassword`、`RescueSystem`、`Vnc`、`Sync` |
| 查询 | `Status`、`ManagePanel` |

除 `CrackPassword($params, $newPassword)` 外，标准函数通常只接收 `$params`。
`Reinstall` 会把选择写入 `reinstall_os`、`reinstall_os_name`；`ChangePackage` 额外得到
`old_configoptions`。不要直接读取 `$_POST` 来取得这些值。

返回值由 `Provision::execSupportFunc()` 归一化：

- `null`、字符串 `success` 或 `ok` 表示成功；
- 数组应使用 `status => success|error`，可附 `msg` 和 `data`；
- 其他标量会转换为失败消息；
- 方法不存在返回 `status=error` 且 `no_support_function=true`。

数组返回应始终显式设置 `status`。`Status()` 成功时通常在 `data.status` 返回 `on`、
`off` 或 `unknown`，并可附 `data.des`。不要混用供应商 HTTP 状态和模块业务状态。

外部“创建成功”和本地 host 更新要设计成可恢复流程。现有模块有的自行写 host，有的由
`Host` 逻辑更新；新模块必须确认每个动作的本地状态责任，避免供应商已开通而本地仍是
Pending，或重试后重复创建资源。

## 4. 其他能力

按需实现以下函数：

| 函数 | 用途 |
| --- | --- |
| `TestLink($serverParams)` | 后台服务器连接测试 |
| `ClientArea($params)` / `ClientAreaOutput($params, $key)` | 客户区标签与内容 |
| `AdminArea($params)` | 后台附加信息 |
| `ClientButton($params)` / `AdminButton($params)` | 声明可见的自定义按钮 |
| `AdminButtonHide($params)` | 隐藏指定标准/自定义按钮 |
| `ClientAreaMainOutput` / `AdminAreaMainOutput` | 页面主区域扩展 |
| `Chart()` / `ChartData($params)` | 图表定义和数据 |
| `UsageUpdate` / `TrafficUsage` | 用量更新与区间流量 |
| `FlowPacketPaid($params)` | 流量包支付后同步 |
| `AdminSave($params)` | 后台保存主机后的通知 |
| `AllowFunction()` | 客户/后台非按钮自定义函数允许列表 |
| `CreateTicket($params)` / `ReplyTicket($params)` | 将产品工单事件通知模块 |

自定义按钮必须先由 `ClientButton()` 或 `AdminButton()` 声明，核心才允许按函数名执行。
普通自定义函数必须出现在 `AllowFunction()` 对应的 `client` 或 `admin` 列表中，并且实现
`<module>_<name>`。函数名仍需服务端固定允许列表，不能把请求值直接拼接后调用任意函数。

`ClientArea()` 返回以 tab key 为键的数组；每项可声明 `name`、`template` 或 `html`。
`ClientAreaOutput()` 可以返回原始字符串，或：

```php
[
    'template' => 'templates/index.html',
    'vars' => ['resource' => $resource],
]
```

模板必须位于模块目录。核心渲染时注入 `MODULE_CUSTOM_API`，指向当前主机的自定义 API
入口。该 URL 只是路由辅助，不替代请求中的客户归属检查。

## 5. `$params` 数据契约

`HostModel::getProvisionParams()` 组装的参数包含：

- `hostid`、`productid`、`uid`、`serverid`、域名、账期、到期日和 `domainstatus`；
- 主机 `username`、解密后的 `password`、IP、系统和暂停信息；
- 产品 `config_option1` 至 `config_option24` 及上游产品信息；
- `server_ip`、`server_host`、`server_username`、解密后的 `server_password`、
  `accesshash`、`port`、`secure`、`server_http_prefix`；
- 完整 `user_info` 客户记录；
- `customfields`；
- 当前 `configoptions` 和 `configoptions_upgrade`。

模块应只读取实现动作所需的最少字段，不复制整个数组到日志、缓存、异常或供应商请求。
客户密码、服务器密码、access hash 和完整客户资料都属于高敏感数据。

`TestLink()` 接收的是服务器配置而非完整主机参数，成功示例为
`['status'=>200, 'data'=>['server_status'=>1]]`。连接失败应给 `server_status=0` 和脱敏
消息，不能通过测试接口回显凭证。

## 6. 调用生命周期

```text
配置服务器组
  -> Provision 扫描并加载模块 PHP
  -> MetaData() / ConfigOptions()
  -> 后台保存 servers 与产品 config_optionN

创建或管理主机
  -> HTTP/Cron/订单事件进入 Host 逻辑
  -> HostModel 从 host + products + servers 组装并解密 params
  -> Provision 检查模块函数和可选授权函数
  -> <module>_<Capability>(params)
  -> 归一化结果、写活动日志并更新本地业务状态

客户自定义操作
  -> 路由校验登录、主机归属及 Active 状态
  -> ClientButton/AllowFunction 确认能力已声明
  -> 调模块函数
  -> 返回受控 JSON 或渲染受信模板
```

开通、暂停、删除、续费和升降级可能由后台、订单支付、Cron 和 API 多处触发。每个外部
写操作必须使用稳定幂等键，并能在供应商超时后查询最终状态再决定是否重试。

## 7. 模块资源包接口

`GET /api/product/:id/resource` 调用 `Provision::downloadResource()`，当前只对服务器类型
`dcimcloud` 和 `dcim` 返回固定的 `mf_finance/data/abc.zip` 或
`mf_finance_dcim/data/abc.zip`。其他模块返回“不支持该代理”。

`nokvm_downloadResource()` 虽然存在，但没有发现通用核心分发器调用
`<module>_downloadResource()`。因此它不是可依赖的通用升级 Hook。扩展资源包机制前应先
定义签名校验、版本、下载授权、完整性哈希、回滚和所有模块的统一分发契约。

`/api/exec_module_func` 不在 `ApiCheck` 分组内，只依赖模块实现
`<module>_ApiAuth()`。当前控制器在 `checkAndRequire()` 加载模块前使用了反向的
`function_exists($func)` 条件：普通新请求中函数尚未加载，随后仍可进入鉴权和调用；若模块
已被同一进程提前加载，则会错误返回“方法不属于模块”。修复这个不一致条件时，还必须
增加统一的服务认证、固定能力白名单和请求级防重放，不能只调整动态函数判断。

## 8. 安全风险与加固要求

- 模块与核心进程同权限运行，没有沙箱；发现阶段已执行 PHP。只安装经过代码审计、签名
  和来源验证的包，生产目录不可由 Web 用户写入。
- `$params` 暴露解密后的服务器和主机凭证以及完整客户资料。禁止通用参数日志；供应商
  请求按动作建立显式字段白名单，异常时清除 URL 查询中的秘密。
- `wlkanglepro` 强制 HTTP 并把密码、签名等放入查询串；`bthosts` 可使用 HTTP 且关闭
  TLS 证书验证；`nokvm_Curl()` 关闭证书验证并自动跟随重定向。上线前必须改成验证证书
  的 HTTPS、精确主机白名单和受限重定向策略。
- 客户区允许模块返回原始 HTML 或模板变量。模块输出属于受信代码，但供应商响应和客户
  字段仍是不可信数据；按 HTML/属性/URL 上下文转义，禁止远端脚本注入。
- 自定义函数可能直接读取全局 `input('post.')`。权限取决于具体 dispatcher；函数内部仍
  应使用服务端 `$params['hostid']`、`uid` 和固定 schema 校验，不能信任请求中的主机 ID。
- `/api/exec_module_func` 没有路由中间件，模块名和方法名来自请求，模块级 `ApiAuth()`
  也没有统一契约。即使修复当前不可达分支，也不得直接暴露公网；应改为显式路由到固定
  能力，并使用标准服务身份、时间戳、nonce、载荷签名和审计。
- `Provision::createTicket()` 和 `replyTicket()` 直接 `call_user_func()`，没有先检查目标函数
  是否存在。被业务调用但未实现对应函数的模块可能产生致命错误；核心应补能力检查。
- 模块可自行写数据库，外部 API 又不能纳入本地事务。要用状态机/outbox 记录意图、供应商
  ID 和重试状态，不能用跨网络长事务制造锁等待。
- 电源、重装、删除和密码重置属于高危动作。客户端入口需要主机归属、状态、近期二次
  验证、CSRF/重放保护和速率限制，后台入口需要细粒度权限与完整审计。
- endpoint、端口和跳转必须限制，避免模块配置被用于 SSRF 扫描内网、云元数据地址或
  非预期协议。

## 9. 实现检查

1. 全新配置和升级配置分别验证 23 项上限、默认值、`key` 映射和可配置项覆盖。
2. 每个能力覆盖成功、业务失败、HTTP 超时、供应商已成功但本地超时及重复调用。
3. 比较后台、客户、Cron 和系统 API 入口的归属与权限，确认未声明函数不可执行。
4. 检查所有日志、错误页、模板和队列载荷不包含解密凭证或完整 `user_info`。
5. 对客户区 HTML、模板、图表、自定义按钮和工单 Hook 做缺失函数与恶意数据测试。

## 10. 权威源码

- 发现、配置、能力分发和渲染：`app/common/logic/Provision.php`。
- 参数组装：`app/common/model/HostModel.php`。
- 主机业务生命周期：`app/common/logic/Host.php`。
- 后台入口：`app/admin/controller/ProvisionController.php`、`data/route/admin.php`。
- 客户及系统路由：`data/route/home.php`、`data/route/openapi.php`、
  `data/route/api.php`。
- 客户 OpenAPI 适配：`app/openapi/controller/HostController.php`。
- 资源包入口：`app/api/controller/ProductController.php`。
- 可审查示例：`public/plugins/servers/bthosts/bthosts.php`、
  `nokvm/nokvm.php`、`wlkanglepro/wlkanglepro.php`。
