# Hook 开发

## 1. Hook 来源与注册

系统 Hook 白名单由 `app/home/controller/HooksController.php` 的方法动态生成，并额外
加入客户中心头部、尾部等模板 Hook。该控制器的注释是 Hook 名称和预期参数的第一
索引，但开发时还必须查找真实 `hook('<name>', ...)` 调用点确认参数与返回协议。

安装 Addon 时，框架把插件主类方法转为 snake_case，与系统白名单及 `hook` 表取
交集，写入 `hook_plugin`。请求启动时只加载已启用记录，并按 `list_order` 注册：

```php
class AcmeToolsPlugin extends Plugin
{
    // 对应 before_create_ticket
    public function beforeCreateTicket($params)
    {
        return null;
    }
}
```

主类方法是首选方式。启用的 Addon 若存在 `hooks.php`，启动阶段也会直接 `include`；
其中可调用 `hook_add('hook_name', $callable)`，但只能注册白名单内 Hook。由于这是任意
PHP 执行入口，只安装受信代码，并避免在文件加载阶段执行数据库写入或外部请求。

`public/plugins/behavior/*` 的旧式匿名行为自动加载已因安全原因被注释，不应把它当作
当前有效扩展方式。

## 2. 执行规则

全局 `hook()` 最终调用 ThinkPHP `Hook::listen()`：

- Hook 名从 snake_case 转为 camelCase 插件方法名。
- 默认执行全部监听器，返回值按监听器顺序组成数组。
- 某个监听器严格返回 `false` 时，框架停止执行后续监听器。
- 需要第一个非 `null` 结果时调用 `hook_one()`；全局 `hook()` 只接收 Hook 名和参数。
- 启停插件会同步启停其 `hook_plugin` 记录。

严格 `false` 只控制监听器链是否继续，不自动回滚业务，也不代表调用方一定会中止。
返回协议由每个调用点决定。

## 3. 常见返回协议

| 类型 | 示例 | 调用方如何处理 |
| --- | --- | --- |
| 通知 | `invoice_paid`、`client_login` | 通常忽略返回值；监听器自行处理副作用 |
| 模块前置 | `before_module_create` 等 | 数组会合并进模块参数；`exit_module` 为真时中止操作 |
| 工单前置 | `before_create_ticket` | 任一结果为 `['status' => 400, ...]` 时拒绝创建 |
| 管理登录 | `auth_admin_login` | 结果中 `status === false` 时拒绝登录 |
| 模板输出 | `client_area_head_output` 等 | 返回字符串数组，模板逐项原样输出 |

不能编写一个通用的“返回 false 阻断业务”约定。每次实现前执行：

```bash
rg -n "hook\(['\"]before_create_ticket" app public
```

并阅读调用点如何遍历结果、检查哪些键以及何时发生数据库写入。

## 4. 参数与兼容性

同一业务在历史代码中可能使用不同键名，例如账单 ID 可能出现 `invoiceid` 或
`invoice_id`。插件应按真实调用点兼容需要支持的版本：

```php
public function invoicePaid(array $params)
{
    $invoiceId = (int) ($params['invoiceid'] ?? $params['invoice_id'] ?? 0);
    if ($invoiceId <= 0) {
        return null;
    }

    // 使用本地数据库重新读取金额、客户和状态，不信任 Hook 参数中的敏感字段。
    return null;
}
```

不要修改传入数组并期待引用生效；需要改变后续参数的 Hook 必须按该调用点约定返回
数组。新增字段保持可选，读取时使用默认值，避免升级后因未定义索引中断主流程。

## 5. 模块前置 Hook

服务器模块在 create、suspend、unsuspend、terminate、sync、on、off、reboot 等操作
前后触发 Hook。前置 Hook 可补充模块参数或中断：

```php
public function beforeModuleCreate(array $payload)
{
    $params = $payload['params'] ?? [];
    if (!$this->allowProvision($params)) {
        return ['exit_module' => true];
    }

    return ['custom_region' => 'cn-east'];
}
```

返回数组会被合并到模块参数，多个插件后执行的同名键可能覆盖先执行结果。插件排序
因此是业务行为的一部分；避免使用宽泛键名，并记录拒绝原因，但不要记录密码或模块
密钥。

## 6. 模板 Hook

客户中心模板会原样输出以下 Hook 的返回字符串：

- `client_area_head_output`
- `client_area_footer_output`
- `template_after_servicedetail_suspended`
- `template_after_service_domainstatus_selected`

示例：

```php
public function templateAfterServicedetailSuspended(array $params)
{
    $hostId = (int) ($params['hostid'] ?? 0);
    if ($hostId <= 0) {
        return '';
    }

    $url = shd_addon_url('AcmeTools://Index/detail', ['id' => $hostId], true);
    return '<a class="btn btn-secondary" href="'
        . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">详情</a>';
}
```

模板不会再转义 Hook HTML。只拼接服务端生成且正确转义的数据，不允许客户输入、上游
返回或插件配置直接进入标签、属性、脚本和 CSS。模板 Hook 等同受信代码边界。

## 7. 副作用与可靠性

- 通知 Hook 可能在数据库事务内、事务后或 HTTP 响应前触发，逐调用点确认时序。
- 网络请求设置短超时；耗时工作投递现有队列，不阻塞登录、支付、工单和 Cron。
- 使用业务唯一键保证幂等，尤其是账单支付、订单创建、工单同步和每日任务。
- 一个插件异常可能中断主请求；捕获可恢复的外部异常并记录脱敏上下文。
- 不依赖监听器顺序解决数据一致性；必须依赖时，在后台固定 `list_order` 并写回归测试。
- 禁用与卸载后检查 `hook_plugin`，尤其是升级中删除过 Hook 方法的插件。

## 8. 调试与测试

1. 从 `HooksController` 找 Hook 名和注释，再从全仓真实调用点确认参数与返回值。
2. 安装插件后检查 `plugin.hooks` 与 `hook_plugin` 的 hook、status、list_order。
3. 分别测试无返回、正常返回、严格 `false`、异常和多个监听器排序。
4. 前置 Hook 测试允许与阻断分支；模板 Hook 检查 HTML 转义和权限。
5. 启停插件后重新请求，确认监听器加载状态变化。
6. Cron Hook 必须通过实际 CLI 入口测试，不能只在浏览器请求中验证。
7. 查看日志时只记录 Hook 名、插件名、业务 ID、耗时和结果类别，不记录令牌、密码或
   完整个人信息。
