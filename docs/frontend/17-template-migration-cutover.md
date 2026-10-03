# 新旧模板切换与回滚实施方案

本文只编写实施步骤，本次没有更改站点配置、安装新主题或发布资源。前台使用已有主题选择机制；后台没有已验证的新旧切换开关，必须先解决源码/入口问题。

## 真实配置和入口映射

| 分区 | 当前选择机制 | 首批新入口 | 回滚值 |
| --- | --- | --- | --- |
| 官网 | configuration: themes_templates | 首批不切换 | 保留原值 |
| 客户中心 | clientarea_default_themes；theme 参数/客户端 Cookie | 相同 /login、/clientarea、/viewbilling、/servicedetail、/viewticket，目标 ui-v1 子主题 | 发布前记录的旧主题值，不能默认旧值必为 default |
| 购物车 | order_page_style；商品 order_frm_tpl/tpl_type；carttheme/Cookie | 相同 /cart?action=configureproduct/viewcart/ordersummary/complete，目标 ui-v1 | 恢复全局、商品级选择和测试 Cookie |
| 后台 SPA | 编译入口、Vue Router、实际 base/hash、服务器 rewrite | 当前路径保留；新入口尚未实现 | 上一版完整 public/admin 制品及入口配置 |
| 后台 PHP View* | admin_default_theme + 两处模板解析 | 尚未验证，不用于生产灰度 | 保留现有部署 |

官网、客户中心、购物车是独立选择；只改客户中心主题不能保证购物车一起切换。参数/Cookie 预览不控制业务权限，也不是按角色灰度开关。当前没有证据表明仓库已有服务端按客户/角色分批选择主题的功能；需要这种灰度时另立实施任务。

## 隔离环境首批演练

1. 建立隔离站点、数据库和独立缓存/上传目录；关闭真实邮件短信、支付和上游写操作，使用测试适配器。
2. 记录实际 PHP-FPM、Cron、worker 路径，设置相同 APP_PHP；记录上述配置旧值、商品主题、后台入口和资源 hash。
3. 部署 ui-v1 目录。先以 theme/carttheme 参数预览，检查 Cookie、语言加载和未覆盖页的父主题回退。
4. 在隔离后台使用主题管理入口保存配置；对应 POST config_general/newGeneral 隐式映射 postNewGeneral，读取用 POST getConfig（param[] 配置键）。保存后重新读取键值，验证权限、目录与字段转换。入口不工作则记 BLOCKED 并核对部署。
5. 无痕窗口及已有会话分别验证所有首批页面，刷新、返回、深链接及后台直接路径；完成[验收用例](18-frontend-test-acceptance.md)。
6. 演练回滚，确认恢复旧样式后账单/工单/主机查询结果没有变化，再记录可发布结论。

## 缓存处理

主题静态文件使用主题自己的路径和版本号/文件 hash；新版本保留旧资源，防止打开中的旧页面加载失败。模板编译缓存、业务缓存、浏览器缓存和 CDN 缓存分别记录。没有 CDN 时该项 N/A，不凭配置文件推断已生效。

隔离站点模板缓存检查命令（执行前确认 APP_PHP 和所在目录）：

```sh
APP_PHP=/实际站点使用的/php
"$APP_PHP" -v
"$APP_PHP" think clear --cache
```

--cache 清 runtime/cache，不只模板；需要先评估业务缓存影响。清理后使用全新 HTTP 请求验证实际模板与资源版本。FPM OPcache 应通过当前部署管理重载或失效；不在共享机器上随意重启所有 PHP 实例。

## 前台回滚操作

触发条件：登录失败、本人数据不可读、金额/状态与旧模板不一致、提交丢字段、核心资源 404、越权或关键移动端操作不可达。权限/财务错误立即停止扩大范围；单次失败日志不足以自动判断业务最终状态。

1. 恢复发布前记录的客户中心、购物车配置和商品主题值，清除预览会话的主题 Cookie。
2. 同名主题被覆盖时，从完整上版制品恢复该主题目录及公共依赖；不要回退业务控制器或数据库来修 UI。
3. 清受影响的模板/资源缓存，保持旧资源可用。
4. 重跑登录、客户资料、商品报价、账单读取、工单和服务详情，检查已有队列/Cron 继续运行。

资源恢复前先预览（变量必须指向已核实的上一版制品，不含私有配置）：

```sh
PREVIOUS_RELEASE=/已核实的上版制品目录
test -d "$PREVIOUS_RELEASE/public/themes/clientarea/ui-v1"
rsync --archive --checksum --dry-run "$PREVIOUS_RELEASE/public/themes/clientarea/ui-v1/" "public/themes/clientarea/ui-v1/"
```

确认文件差异后执行同一 rsync 去掉 --dry-run；多余文件按制品清单单独处理。数据库配置、上传、日志和 runtime 不在该复制范围内。这里的路径是拟建主题，不是当前已存在的恢复包。

## 后台回滚门槛

必须取得实际入口文件、base/hash 路由方式、服务器 rewrite 和新旧完整资源包后才能冻结可执行回滚命令。当前无法证明仅修改 admin_default_theme 能回滚现有 SPA，后台发布状态为 BLOCKED。恢复完整后台制品后验证登录、菜单、客户列表/详情、工单及财务读取；不能只检查首页 HTTP 200。

## 数据边界

本批纯模板方案不新增业务表/字段，不做订单、账单、余额或库存迁移；主题配置属于发布记录。若另增 RBAC、菜单或功能开关，按[数据兼容](21-data-compatibility-migration.md)另记迁移，失败恢复不得覆盖本批上线后新增业务记录。
