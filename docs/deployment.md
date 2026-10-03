# 部署与运行手册

本文描述当前分支的运行边界。站点实际目录、用户、PHP 路径、数据库和服务管理器必须
以部署主机配置为准；示例值不能直接照抄。

## 运行拓扑

```text
浏览器/API
    -> Web Server -> public/index.php -> PHP-FPM
    -> MySQL/MariaDB
    -> 缓存（会话、JWT、验证码、限流和同步状态）

Cron 调度 -> APP_PHP think cron / think cron:stock
队列服务 -> APP_PHP think queue:work -> 数据库 jobs 队列
```

每个财务实例都必须使用自己的数据库配置和队列 worker。不同实例不能共用队列连接，
否则可能消费或重试其他实例的邮件、短信和业务任务。

## PHP 运行时

站点 PHP-FPM、Cron 和队列 worker 使用同一个实际 PHP 二进制。当前 Shell 中的 `php`
即使是 PHP 8.x，也不代表站点运行时；ThinkPHP 5.1 在较新 PHP 上还可能触发框架弃用
API。部署前执行：

```sh
APP_PHP=/www/server/php/72/bin/php
"$APP_PHP" -v
"$APP_PHP" -m
```

确认 PHP-FPM pool 的二进制和站点用户后，再用同一路径执行控制台命令。不要通过修改
系统默认 `php` 来替代站点配置。

## Web 站点检查

- Web 根目录指向项目的 `public/`，入口为 `public/index.php`；不要把项目根目录直接
  暴露为静态站点。
- 配置 PHP-FPM、URL 重写和 HTTPS 后，检查首页、登录、客户中心、后台和一个 API 路由。
- PHP-FPM 用户必须能读取代码和 `vendor/`，并能按应用需要写入 `data/`、`uploads/`、
  `downloads/`、`public/upload/` 及运行时目录。权限应授予站点用户或组，不要把整个项目
  设为全局可写。
- 生产环境保持 `APP_DEBUG=false`，日志和错误响应不得暴露密钥、JWT、密码或完整支付数据。

## Cron

注册入口来自 `app/command.php`：

- `cron`：执行常规自动任务，并按配置运行每日、半小时、五分钟等任务；包含产品到期
  提醒、账单、主机状态、流量、合同、取消请求和模块任务等。
- `cron:stock`：每分钟同步上游商品库存，使用 `data/locks/cron/stock.lock` 防止并发，
  并把最近执行状态写入配置。

调度器应使用站点用户和实际 PHP：

```cron
* * * * * cd /www/wwwroot/实例目录 && /实际PHP路径/php think cron >> data/cron.log 2>&1
* * * * * cd /www/wwwroot/实例目录 && /实际PHP路径/php think cron:stock >> data/stock-cron.log 2>&1
```

同一实例不要同时配置多个 `cron` 调度器。Cron 自身有配置锁，但重复调度会增加数据库
和上游请求压力。修改 `cron_day_start_time` 或通知配置后，按实际时区验证一次每日任务。

## 队列 worker

使用仓库安装器部署独立 worker：

```sh
./bin/install-queue-service \
  --root /www/wwwroot/实例目录 \
  --php /实际PHP路径/php \
  --user <站点目录实际所有者>
```

安装器支持 systemd、Supervisor 和 OpenRC；可用 `--dry-run` 先检查生成的服务定义。
worker 默认消费 `default` 队列，失败任务最多重试 3 次，空闲等待 2 秒，内存上限 128 MB。
应用代码、队列配置或插件更新后重启常驻 worker。

检查命令：

```sh
PHP_BIN="$APP_PHP" ./bin/zjmf-queue-worker --check
systemctl status zjmf-queue-default.service   # 使用 systemd 时
```

容器或没有服务管理器的主机可以前台运行 worker；`--once` 只处理一个任务，适合低流量
备用场景，不应代替持续 worker。

## 升级与回滚

升级前备份数据库和完整站点，暂停 Cron、队列和写请求。按根目录
[`README.md`](../README.md) 的 3.7.6 → 3.7.7 流程执行：保留实例数据库配置、插件、上传、
下载和自定义主题，使用实际 PHP 执行 `public/upgrade/upgrade.php --run`，完成后清理
缓存并重启 PHP-FPM 和 worker。

升级失败时先保留升级日志、数据库备份和当前文件，不要反复执行未知 SQL。回滚应使用
经过验证的文件包和数据库备份，并在恢复后检查登录、客户数据、订单、队列和上游连接。

## 备份、日志和健康检查

- 数据库备份应覆盖业务库、配置和队列表；上传、下载、自定义主题和插件需要单独备份。
- 应用日志、Web/PHP-FPM 日志、Cron 日志和 worker 日志分别保留，按时间和实例区分。
- 每次发布后检查首页、登录、客户 API、后台登录、商品列表、创建测试订单（不实际支付）、
  队列 worker 状态和 `cron:stock` 最近执行状态。
- 发现队列堆积、Cron 锁长期存在、上游连续失败或写目录不可用时，先停止继续发布并保存
  日志和任务状态，再按对应模块排查。

## 部署完成标准

1. 记录 PHP-FPM、`APP_PHP`、站点用户、数据库、缓存和服务管理器的实际配置。
2. `"$APP_PHP" -v`、`"$APP_PHP" think route:list` 和队列 worker 检查通过。
3. Web、Cron、`cron:stock`、队列、数据库读写权限和日志均有一次真实验证。
4. 备份文件可读取，升级/回滚负责人和恢复步骤已明确。
