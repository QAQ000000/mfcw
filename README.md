# 魔方财务系统自维护版 3.7.7

本分支以 3.5.8 解密源码为维护基线，版本号为 3.7.7。它支持从未使用
v10 主机的官方 3.7.6 实例迁移，且不引入 v10 或 P3 插件功能。

## 从 3.7.6 手动升级

1. 备份数据库和完整站点，暂停 Cron、队列 worker 与写请求。
2. 备份实例的 `app/config/database.php`，使用本版本的 `app` 目录替换旧目录，
   然后恢复数据库配置。不要以合并复制方式保留 `app/v10.php` 或
   `app/home/controller/V10CartController.php`。
3. 只替换 `data/route`，不要覆盖实例的 `data/runtime`、日志或会话数据。
4. 更新根目录 `version`、`public/upgrade` 和
   `public/themes/cart/default/viewcart.tpl`，并复制发布包中的整个 `bin/` 与
   `deploy/queue/` 目录；确认 `bin/install-queue-service` 和
   `bin/zjmf-queue-worker` 保留可执行权限。保留实例自己的 `public/plugins`、
   `public/upload`、`uploads`、`downloads` 和自定义主题。
5. 在站点根目录执行 `php public/upgrade/upgrade.php --run`。不要使用后台自动升级页
   或 Web SQL 升级入口。3.7.6 会选择幂等的 `public/upgrade/3.7.7.sql`，该迁移
   保留既有 v10 数据库字段，仅增加本分支需要的日志可见性、商品缓存状态与索引。
6. 清理框架缓存和 schema 缓存，重启 PHP-FPM。每个实例必须有自己的数据库队列
   worker；可执行以下命令自动适配 systemd、Supervisor 或 OpenRC：

   ```sh
   ./bin/install-queue-service \
     --root /www/wwwroot/实例目录 \
     --php /usr/bin/php \
     --user www-data
   ```

   安装器会自动检测服务管理器；在宝塔安全策略阻止 systemd 直接切换到 Web
   用户时，会自动使用 `runuser` 兼容模式。完成后再恢复 Cron。详细说明见
   `deploy/queue/README.md`。

升级前必须确认没有活动的 v10 主机；如仍有 v10 商品或供应商接口，应先下架，
并清空遗留购物车数据。
