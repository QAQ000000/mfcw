# 前端重构测试与验收用例

本文给出首批可复现的数据准备与步骤。本次文档修订没有创建测试账号、种入业务数据或运行浏览器；以下业务用例当前均为 NOT RUN，不能作为运行通过证据。2026-10-03 已执行 PHP 独立静态回归和副本只读数据库预检，结果见[后台样板契约](26-admin-pilot-contract.md)，不替代下表用例。

## 环境准备顺序

1. 建立独立站点和隔离 MySQL/MariaDB，安装/升级到当前源码所需版本；独立配置、runtime、文件缓存、上传及队列。不要只换域名仍连接生产库。
2. 先补齐部署实际扩展及路由 include，确认后台入口/API 可达。缺失 app/res/route/res.php 未解决时，对应用例 BLOCKED。设置 API 使用已定位的 controller 隐式路由，不按注释方法名直找 action。
3. 与站点 FPM 使用同一 PHP 设置 APP_PHP，并记录其版本、扩展、Cron/worker 路径；系统默认 php 版本不作为应用验收结论。
4. 关闭真实短信邮件、支付和上游写入，配置沙箱网关/模块。若没有测试模块，主机动作记 BLOCKED，可先验收详情读取。
5. 按下表通过现有管理页面/受支持 API 建数据。将真实 ID 和基线金额记录到隔离环境 fixture 清单；测试账号凭据单独管理。

副本当前可连接数据库，CLI/FPM/worker 使用 PHP 7.2，但两条 Cron 定义仍调用指向 PHP 8.0 的默认 php；Session 初始化还固定 /tmp/session，生产源码同样使用该路径。先落实统一 PHP、Session/Cookie 与外部副作用隔离，再执行登录和写入。登录及公共 GET 也可能维护数据库/模板，不能把它们当只读探针。

## 固定数据集 UI-FIXTURE-1

| 标识 | 准备操作/数据 | 记录与用途 |
| --- | --- | --- |
| CA/CB/CD | 新建两名普通客户 CA/CB 和一名停用客户 CD；用保留测试域名邮件，禁止使用真实客户 | 记录 uid、状态、币种；CA/CB 的数据互不共享 |
| AR/AE/AN | 普通角色的 ui-read/ui-edit/ui-denied，按权限文档授权并重新登录 | 记录规则 name/ID、菜单、角色，不能用超级管理员替代拒绝测试 |
| DA/DB | 两个工单部门；给 AE 配置 DA，不授 DB | 区分 API 规则拒绝和部门范围拒绝 |
| P1 | 本地测试商品，默认币种、月付 10.00、安装费 0，库存控制开，库存 2；自动开通关闭 | 记录 pid/currencyid/billingcycle 及后端报价；用非上游商品隔离价格变化 |
| P2 | 另一个测试商品库存 0；配置项测试商品增加一个实际可选项和一个必填自定义字段 | 记录字段/配置选项真实 ID；不要把 10.00 写入前端价格逻辑 |
| IU/IP/IC | 为 CA 各生成未付/已付/取消账单；已付只通过沙箱流程操作一次 | 记录 invoice.id、账户交易 accounts.id、金额/流水；两种 id 不可混用 |
| HP/HA/HS | CA 的 Pending/Active/Suspended 测试主机，CB 另有一台 | 用沙箱模块生成目标状态；记录 host.id/domainstatus。无模块时动作测试 BLOCKED |
| TA/TB/TC | CA 向 DA 创建工单 TA，向 DB 创建 TB，CB 创建 TC；TA 附一个允许格式的小附件 | 同时记录内部 id 和对外 tid、部门、初始状态和回复数 |
| CL | 支持专业版信用额的环境给 CA 配置额度/出账日，预存余额另设已知值 | 记录两套金额与配置；无版本支持时信用额成功路径 BLOCKED，仍验证拒绝展示 |
| VC | CA/CB 各有测试抬头、地址及已付可开票账单；CA 同时有个人/公司抬头、非默认地址；隔离环境配置收费和零费用两套发票 fixture | 记录 voucher.id、源 invoice_ids、费用 invoice_id、税率/快递价格；预置 Unpaid/Pending/Reject/Send 申请，快递不触发真实邮寄；创建渠道不可用时相关用例 BLOCKED |

准备完拍摄基线截图或导出脱敏响应。每个写入用例使用数据集副本/快照恢复，避免上一用例影响后续状态。测试数据库的具体连接参数不写进文档。

## 首批步骤与预期

| 编号 | 页面/操作步骤 | 必须观察的结果 |
| --- | --- | --- |
| L01 | 前台退出后访问 login，按配置选邮箱/手机；错误密码一次，再用 CA 正确凭据；刷新客户首页 | 错误不跳转；成功真实 Session 生效。密码/验证码不写日志；CD 的拒绝按现状核实 |
| L02 | 后台登录 AR，记录菜单及核心读取；退出再登录 AN，直接打开客户路径 | UI 拒绝与 API 401 一致；View* 页面单独核实，不能用空列表代替权限错误；未登录 API 405 |
| C01 | AR 在客户列表按 CA 邮箱搜索、翻页、改每页条数、刷新/返回 | 参数与 client_list 协议一致，读取顶层 list/total；筛选恢复，空搜索显示无结果 |
| C02 | AE 读取 CA 资料和辅助选项，改一个非敏感字段保存；再输入重复邮箱或无效字段；AR 尝试同一保存 | 保留原币种/语言/网关，表单编码正确；成功重查 profile及有权读取的summary；失败保留安全输入并核对服务器值；AR 无写权限时拒绝 |
| C03 | AE 同时改非敏感主字段与无效必填自定义字段；收到错误后重新读取；恢复 fixture，再验证超时/无变化提交 | 识别可能部分保存，不把 400 等同于回滚；草稿不覆盖重查基线，超时不自动重试，无变化不发 POST；不提交未读取的 city/region/avatar |
| Q01 | CA 打开 P1 配置，先漏必填项再填写；依次改配置/周期/数量，快速连改两次 | 校验后提交；报价读取顶层 currency/products，旧请求不覆盖新结果；金额来自服务端 |
| Q02 | P1 数量 1 加购物车，改为 2，删一项/使用无效优惠；打开 P2；重复点击结算 | GET get_shop_data 重新读取；库存不足失败；409 显示需核对，检查订单/账单数量，不仅检查 toast |
| Q03 | 隔离环境加入两条不同商品/配置的可售购物车行，记录订单/账单基线；取消所有勾选，分别点击结算、按 Enter、调用 UI 的提交处理 | 选中 0 项，结算禁用；提交处理也拦截；settle 请求 0 次，订单/账单数不变。不能以空数组/省略 pos 发请求并期待后端拒绝 |
| Q04 | 同上，选择一项；通过前端测试替身把选择置为全部无效索引，再置为一个有效与一个无效索引，分别尝试提交 | 任意失效均中止，重读整车并清空无法确认的选择；不降级全车/有效子集；settle 请求 0 次、订单/账单不增加。不得直接向真实业务接口发送危险 pos 来测试 UI |
| Q05 | 使用三条可区分的可售行 A/B/C，选择 B 后删除 A，刷新；再模拟旧选择仍指向旧索引但该索引现在为 C | 重新核对索引与商品/配置/数量；即使索引仍存在也拒绝错位集合，清空并重新勾选 B；确认所选摘要后只结算 B，核对订单项目和数量、剩余购物车仅 C，已删除的 A 不恢复 |
| Q06 | 两窗口打开同一购物车；窗口二删除/改数量，窗口一恢复激活并尝试结算；另测试所选摘要加载失败和旧摘要晚到 | 最新整车变化使选择失效，未确认/摘要失败时请求 0 次；旧响应不启用按钮；最终核对后再发生跨窗口修改属于当前服务端版本校验缺口，单独记风险/BLOCKED，不宣称 UI 已消除竞争 |
| B01 | CA 打开 IU/IP/IC，检查项目、币种、流水；通过沙箱支付 IU，回跳刷新 | 支付选项随真实状态变化；回跳不直接显示已付；get_invoices_detail 的服务端状态确定结果 |
| B02 | CB 尝试读取 CA 账单和服务；CA 请求不存在对象；网络中断后恢复 | 不显示他人数据；账单非本人/不存在 400；错误态有重试，不能显示 0 金额成功态 |
| H01 | CA 查看 HP/HA/HS；在沙箱暂停 HA，再恢复；测试模块失败和响应超时 | 页面先显示处理中，重查 domainstatus；失败不预改状态；没有 task_id 也能核对最终结果 |
| T01 | CA 用 TA.tid 打开 viewticket，回复文本+附件；模拟附件失败/超时；重新查时间线 | 成功回复数增加一次/status=3；失败保留正文；超时先核对，不能自动重复发送 |
| T02 | AE 用 TA.id 打开后台详情并回复，读 TB；再关闭 TA/批量包含未授权对象 | 成功 status=2、客户未读；无部门权限 406；批量逐项核对，200 不等于全部成功 |
| F01 | 支持信用额时读取/修改/关闭 CA 额度；同时查看预存余额和还款账单 | credit_limit 与余额分区；关闭只改开关、不清欠款；日志/到期日按源码副作用核对 |
| I01 | CA 打开发票列表→申请账单选择→单笔/多笔开具；分别验证空候选、空选、账单 ID 搜索、翻页/刷新；切个人/公司抬头、非默认地址及快递 | 四个分支布局和字段独立；无候选/空选不开具；候选来自 voucherrequest；提交 type_id/post_id/express_id/invoice_ids[]；地址/抬头缺失提供管理入口；手机邮寄信息完整可读 |
| I02 | 使用 VC 收费 fixture 提交一次，沙箱支付后重查；恢复快照，用零费用 fixture 提交；模拟 400/超时/重复点击；查看 Reject/Send 详情 | 收费 200 读取费用 invoice_id，开票总额仍取源账单 subtotal 合计；1001 不访问缺失字段；付款后核对 Pending，驳回/已发出按实际枚举；失败不跳转，超时先核对，不能重复申请 |
| I03 | CA/CB 交叉读取申请/地址/抬头，并尝试提交他人、不合资格或重复申请的源账单及编辑他人抬头；仅在授权隔离环境执行，测试后恢复快照 | 归属和资格必须由服务端拒绝；当前申请写入/抬头详情与编辑存在源码校验缺口，不能因 UI 隐藏而记 PASS；返回他人数据或发生写入时记 FAIL 并阻止真实开票上线；已有申请引用的地址/抬头删除失败保留原行 |
| R01 | 读取五个报表端点，选当前及上一年月，验证空数据和退款数据 | 比较源表/脱敏基线；product_income 取 data[]/groups_count/years；不显示无依据统计维度 |
| V01 | 在 1440×900、1024×768、768×1024、390×844 逐个跑首批页主要操作，再用 320px 宽长文案检查 | 按组件断点重排；页面无横向溢出，表格只在内部滚动；弹窗/输入/分页不遮挡 |
| M01 | 按迁移文档切新主题、刷新旧窗口、回滚旧主题后再跑 L01/C01/Q01/B01/T01 | 旧资源可用、回退页正确；业务数据不因 UI 回滚变化 |

## 仓库已有检查命令及实际能力

文档检查不加载应用：

```sh
node docs/scripts/check-doc-links.cjs
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --check
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-build-evidence.cjs --check
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node tests/admin_build_evidence_regression.cjs
git diff --check
```

以下是已有的独立回归脚本，在确认 PHP 路径后按受影响范围运行。它们不能代替 UI/Session 验收：

```sh
APP_PHP=/实际站点使用的/php
"$APP_PHP" -v
"$APP_PHP" tests/public_view_query_regression.php
"$APP_PHP" tests/billing_authority_regression.php
"$APP_PHP" tests/contract_contacts_access_control_regression.php
"$APP_PHP" tests/cart_cache_regression.php
```

前三个检查源码约束；cart_cache 使用临时测试目录和测试替身验证缓存/锁，不操作真实业务库。改动 PHP 时另对实际文件执行 -l；.tpl 需经真实模板编译/渲染，PHP -l 不能验证 Think 模板语法。

MySQL 并发脚本会建写临时表，必须显式传隔离配置（默认可能读取实例配置）：

```sh
RUN_MYSQL_INTEGRATION=1 ZJMF_DB_CONFIG=/隔离环境/database.php "$APP_PHP" tests/integration_cart_concurrency_mysql.php
```

需 PDO MySQL/pcntl 等脚本依赖。该脚本验证库存 SQL 竞争和回滚，不是完整结算 HTTP 测试。默认输出 SKIP 时不能记 PASS。2026-10-03 使用 APP_PHP=/www/server/php/72/bin/php 执行前三条静态回归，均通过；cart_cache 与 MySQL 并发脚本本轮未运行。只读 PDO 预检不等于数据库写入/集成用例通过。

## 证据记录

每条用例记录源码/制品版本、APP_PHP 实际路径、浏览器/屏幕、fixture ID、执行时间、操作、脱敏请求与响应、截图、结果 PASS/FAIL/BLOCKED/NOT RUN 和缺陷。不得保存明文密码、Session Cookie、Token 或完整网关凭据。测试账号创建和记录模板的存在不等于验收完成。
