# 队列 worker 部署

登录邮件和短信通知使用数据库队列。每个魔方财务实例都必须运行自己的 worker，
因为队列连接从该实例的 `app/config/database.php` 加载。

## 宝塔一键安装

```sh
cd /www/wwwroot/实例目录
./bin/install-queue-service \
  --root /www/wwwroot/实例目录 \
  --php /www/server/php/72/bin/php \
  --user www
```

命令会自动检测 systemd、Supervisor 或 OpenRC，并安装、启用和启动服务。在宝塔
安全策略阻止 systemd 直接使用 `www` 用户时，安装器会自动切换到 `runuser`
兼容模式。重复执行同一命令可更新已有服务配置。

执行前确认发布包中的整个 `bin/` 和 `deploy/queue/` 已复制到实例，至少应包含：

- `bin/install-queue-service`
- `bin/zjmf-queue-worker`
- `bin/zjmf-queue-bootstrap.php`
- `deploy/queue/systemd.service.in`
- `deploy/queue/supervisor.conf.in`
- `deploy/queue/openrc.init.in`

`bin/install-queue-service` 和 `bin/zjmf-queue-worker` 需要可执行权限：

```sh
chmod 755 bin/install-queue-service bin/zjmf-queue-worker
```

如果项目目录、PHP CLI 路径或站点用户不是示例值，应传入实际值。可用以下命令
核对：

```sh
pwd
command -v php
stat -c '%U:%G' .
```

通用发行版示例：

```sh
./bin/install-queue-service \
  --root /var/www/zjmf \
  --php /usr/bin/php \
  --user <站点目录实际所有者>
```

一台主机同时安装了多个服务管理器时，可增加 `--manager systemd`、
`--manager supervisor` 或 `--manager openrc`。可用 `--name` 和 `--queue` 指定
独立的服务名和队列名。

## 容器与 Cron 备用方案

容器应将 `bin/zjmf-queue-worker` 作为独立的前台进程运行。没有服务管理器的主机
可以定时执行 `bin/zjmf-queue-worker --once`，但每次最多处理一个任务，只适合低
流量备用场景。

应用代码更新后需要重启队列服务，使常驻 worker 加载新 PHP 文件。
