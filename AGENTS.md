# AGENTS.md

## 项目

这是魔方财务 3.7.7 自维护分支，基线为 3.5.8 解密源码，面向客户中心、订单计费、
主机服务和上游财务接口的二次开发。项目使用 ThinkPHP 5.1/ThinkCMF 风格组件，模板
主要是 ThinkPHP `.tpl`，数据层是 MySQL/MariaDB。

## 运行时

站点 PHP-FPM、Cron 和队列 worker 必须使用同一个实际 PHP 二进制。系统默认的 `php`
可能指向另一版本，不能据此判断应用兼容性。执行应用命令前先设置实际路径：

```sh
APP_PHP=/实际站点使用的/php
"$APP_PHP" -v
```

应用命令使用 `"$APP_PHP" think ...`。队列服务安装时把同一路径传给
`bin/install-queue-service --php`。独立的静态回归脚本可以使用兼容的 PHP，但凡加载
ThinkPHP 应用、数据库配置或控制台的检查，都使用 `APP_PHP`。

## 代码边界

- `data/route/`：真实路由和 HTTP 方法的来源。
- `app/admin/`、`app/home/`、`app/openapi/`、`app/api/`：后台、客户中心、客户 OpenAPI
  和系统集成入口。
- `app/common/logic/`、`app/common/model/`：跨入口业务规则和模型。
- `app/queue/`、`app/common/job/`：异步任务。
- `public/plugins/`：插件和外部服务适配；`public/themes/`：官网、客户中心、购物车主题。
- `public/install/thinkcmf.sql`：安装库结构；`public/upgrade/`：版本迁移。
- `tests/`：PHP 回归脚本和少量 Shell 服务脚本。

新增功能前先看 [架构文档](docs/01-architecture.md)、[产品模型](docs/product.md)、
[数据库说明](docs/database.md) 或 [部署说明](docs/deployment.md) 中与任务相关的部分。
不要为了遵循附件示例而引入 Go、Next.js、React 或 PostgreSQL 文档。

## 开发规则

- 以路由、控制器、逻辑层、插件调用方和迁移为事实来源；控制器注释和静态 `/document`
  页面可能滞后。
- 保持任务范围，不重写无关模块，不在生产目录运行 `composer update`。
- 不提交实例私有的数据库配置、密钥、上传文件、运行时缓存或日志。
- 外部请求前完成权限和输入校验；订单、余额、库存、发票写入必须考虑事务、重复请求和
  回滚；回调必须验签并以本地订单金额为准。
- 页面改动优先使用主题或子主题覆盖；插件改动保持安装、启停和配置兼容。

## 完成标准

任务完成前至少执行与改动匹配的检查：

1. PHP 文件执行 `"$APP_PHP" -l <file>`，Shell 文件执行 `sh -n <file>`。
2. 运行相关 `tests/<name>.php` 或 `tests/<name>.sh`；需要数据库的测试使用隔离测试库。
3. API 或路由变更后重新生成 `docs/api/openapi-routes.md` 并核对静态文档。
4. 检查 `git diff --check`、文档链接和迁移的幂等性。
5. 在交付说明中记录实际使用的 PHP 路径、执行的检查和未覆盖的真实环境验证。
