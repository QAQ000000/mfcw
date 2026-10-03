# 后台登录、客户列表与资料编辑样板契约

截至 2026-10-03，本页补充 A01–A03 的实现与环境证据。样板目标是以普通管理员完成登录、客户检索、打开资料、修改非敏感字段、重新读取确认，并验证拒绝、异常、手机和资源回滚。**目前完成源码追踪、环境预检及旧副本部分登录/读取/导航观察，尚未实现新后台工程或跑通完整样板。** 旧页面实测与脱敏截图见[浏览器观察](29-admin-browser-observations.md)。

布局采用[首批文字线框](24-first-batch-page-specs.md)和[组件尺寸](19-component-interaction-contract.md)；权限采用[权限契约](14-admin-permission-matrix.md)。本页的字段规则优先于泛化的“失败即未保存”描述。

## 工程交付门槛

只读检查 `public/admin/admin_SwLSA.tar.gz` 的目录：共 970 个条目，包含 JS/CSS、图片、语言、themes、TinyMCE、config.js 和 index.html；未发现应用 src、应用 package.json、锁文件或 Vue/Webpack/Vite 构建配置。仅有 TinyMCE 自带 package.json。当前 checkout 和副本也未找到可维护后台工程。这个包可以保留为编译资源线索，不能作为恢复源码成功的证据。

2026-10-03 用户确认原后台没有工程源码，工程方向确定为新建可维护后台。旧编译页面用于提取排版与交互，PHP 路由、控制器和业务层用于确认数据、权限与状态；不再等待找回原工程。

| 方案 | 开发前必须交付 | 通过依据 |
| --- | --- | --- |
| 新建可维护工程 | 框架版本、源码目录、依赖锁定、请求/Session/RBAC 适配、独立预览入口和制品路径 | 实际 install/build/check 可复现，普通角色完成同一业务链 |

新工程先按逐页布局/交互契约设计，在首个样板中验证 API 适配并落实框架版本和工具链；本文不声明任何 npm script、工程目录或后台切换开关已存在。具体技术选择、逐页设计流程与构建要求见[构建文档](16-frontend-architecture-build.md)。

当前 `public/admin/index.html` 没有直接引用 config.js；编译请求基址取 `window.global || "."`，并设置 withCredentials。因此需要从实际部署入口查清全局变量注入、相对 URL、API 前缀、Router base/hash 和 rewrite。仅修改 config.js 不能证明 API 地址已切换。新预览入口及全部请求必须指向隔离环境，浏览器网络记录用于验证最终地址。

旧副本本次实际页面为 `/admin123/` 的 hash 路由，观察到的登录/客户读取请求均指向同源 `/admin123/`，加载脚本列表未见 config.js。此结果只确认旧页面本次请求目标，不代表新入口的适配或环境隔离已完成。

## 环境预检记录

本轮只读检查目标为 `/www/wwwroot/zjmf-manger-decoded-副本`；文档与静态回归目标为当前 checkout。未修改副本站点或生产配置。

| 检查 | 结果 | 证据及剩余条件 |
| --- | --- | --- |
| 副本站点 PHP-FPM | PASS（配置/进程） | Nginx 站点加载 enable-php-72.conf，连接 /tmp/php-cgi-72.sock；FPM 为 /www/server/php/72/sbin/php-fpm。未执行 HTTP PHP 探针 |
| 副本 CLI 与队列 | PASS（版本/进程） | APP_PHP=/www/server/php/72/bin/php，CLI 7.2.33；队列进程 cwd 为副本，使用该二进制运行 think queue:work |
| CLI 扩展 | PASS（列明范围） | pdo_mysql、mysqli、mbstring、openssl、curl、bcmath、gd、fileinfo、json、pcntl 已加载；不代替 FPM 扩展/禁用函数验证 |
| 副本 Cron | FAIL（路径一致性） | 两条任务脚本以裸 php 执行 think cron、think cron:stock；其 PATH 优先 /bin、/usr/bin；/usr/bin/php 当前指向 /www/server/php/80/bin/php。尚未修订或运行任务 |
| 数据库连接 | PASS（只读） | 使用副本既有配置，以 PDO 只读事务连接并检查 clients/user/role_user/auth_rule/auth_access/configuration/jobs 表，随后回滚；没有启动应用或写入数据 |
| 数据库隔离 | PARTIAL | 副本与生产配置的 hostname/port/database 组合不同；尚未核实账号权限、跨库依赖及真实业务数据来源，不能认定为可随意写入的测试库 |
| Session/外部副作用 | BLOCKED | 副本和生产源码均固定 session path=/tmp/session；副本已有活动 worker。登录可发送通知，部分 GET/登录有维护写入；还需隔离 Session、Cookie、缓存、队列及外部服务 |
| 部署依赖 | PARTIAL（缺口待追溯） | 当前 checkout 和副本都缺 app/res/route/res.php，但 admin.php 无条件 include；后续旧副本登录/客户读取 HTTP 已成功，缺口未阻断所测路径。其他路径与实际生效原因未确认，不删除 include 代替核对 |
| 新后台工程 | NOT STARTED | 新建方向已确定；工程、构建和独立预览入口尚未建立 |
| 新后台切换/回滚 | BLOCKED | 实际入口切换及完整旧制品恢复方式尚未实施/演练 |
| 旧后台浏览器观察 | PARTIAL | 用户授权既有账号登录后，已读列表/资料、展开搜索、切换/取消及观察桌面/手机；登录窄屏和资料缩屏有问题，见 29 文档 |
| 新后台业务样板 | NOT RUN | 未创建角色/客户、未发客户保存请求，未做普通角色、新工程或切换/回滚验收 |

两条 Cron 定义位于服务器 `/www/server/cron/ccaaa7d2cbd276ab7c406efb89754f2a` 与 `/www/server/cron/2334a8aefa579109987432a9d341c6d1`。上述状态只反映本轮所读定义，不证明最近一次调度已成功或失败。修订时通过任务管理入口配置实际 PHP 路径，并复核生成脚本；本轮没有改任务。

后续 PHP 检查使用：

```sh
APP_PHP=/www/server/php/72/bin/php
"$APP_PHP" -v
```

主 checkout 没有实例 `app/config/database.php`，不能直接在此启动应用测试。保持私有配置在环境中；不要为了验收把副本的数据库配置提交到仓库。Session 路径由 sessionInit 强制覆盖，只改 php.ini 或普通 session 配置可能无效，隔离方案需要检查最终生效值。

## 请求顺序与读取契约

`{A}` 为实际 admin_application。页面入口与 API URL 独立记录，不把 SPA /customer-list 当作客户数据接口。

| 顺序 | 请求 | 输入/返回 | 实现要求 |
| --- | --- | --- | --- |
| 1 | GET `{A}/login_page` | data.second_verify_admin、data.second_verify_action_admin | 判断是否显示 code/发送验证入口；此方法包含历史模板维护写入，不作为只读健康检查 |
| 1a | GET `{A}/verify?name=allow_login_admin_captcha`（图形验证） | 启用时为验证码图像；未启用返回业务 400 | 与登录使用同一会话，刷新时更换请求时间戳；图像和 JSON 错误分开处理 |
| 2 | POST `{A}/second_verify_send`（按配置） | action=login、username、password；status/msg | 只发送到隔离邮件通道，遵守发送限频，凭据不记录到证据 |
| 3 | POST `{A}/login` | username/password/captcha，按需 code；成功 data.user/rule/user_tastes | 只把明确成功和有效会话作为登录完成；205 为插件接管，单独处理 |
| 4 | GET `{A}/common`（外壳需要时） | data.config/rule/sale/gateway 等 | 菜单由真实会话/权限读取；该方法也可能维护模板版本，须在隔离环境执行 |
| 5 | POST `{A}/client_list`（PHP 声明为 RULE） | page/limit/order/sort 和筛选，以 qs.stringify 表单编码；顶层 list/total/search/level_search/api_status/seachData/allow_resource_api | 保留 seachData 拼写；条件改变回 page=1；过期响应不覆盖新筛选 |
| 6 | GET `{A}/profile/:client_id` | 顶层 profile/sale/language/client_status/custom/custom_value | 从选中客户 ID 加载，切换客户丢弃旧异步结果；缺对象或异常响应不显示为默认空表单 |
| 7 | GET `{A}/common/get_getways`、`common/get_client_groups`、`common/get_sms_country` | 分别顶层 gateway/client_groups/sms_country | 准确保留 get_getways 拼写；加载失败不把原选择清空或改默认值 |
| 8 | POST `{A}/profile_post` | client_id 与资料字段、自定义字段；成功 status=200/msg | 保存完整已加载资料中的允许字段；按下节处理失败/超时 |
| 9 | GET profile；按页面需要 GET `{A}/summary?client_id=...`、POST client_list | 资料/摘要/列表实际值 | 读取最终状态再显示保存结果；摘要需要独立权限，无摘要权限不阻断已授权资料读取 |

依据：[路由](../../data/route/admin.php)、[Public](../../app/admin/controller/PublicController.php)、[Common](../../app/admin/controller/CommonController.php)、[UserManage](../../app/admin/controller/UserManageController.php)。Captcha 是否启用由现有配置决定，verify 的 name 必须与登录校验使用的 allow_login_admin_captcha 一致，不能用静态图片替代有效验证。图像响应、会话关联及刷新行为须在样板中核对。

登录错误有分支缺 status，也可能包含原请求字段。请求适配器不能假定所有响应都满足统一错误 schema；不可把原响应整体记录到日志/截图，尤其要过滤 password/code/captcha。网络失败、非 JSON、HTTP 错误、业务错误分别展示，禁止自动重复登录。登录前的维护逻辑、登录日志、Token 更新、通知和插件 Hook 都是副作用。

## 资料表单字段与序列化

现有 CustomerPerson 编译组件通过 qs.stringify 提交 form-urlencoded，并把 custom_value[] 按 id 转成 custom[id]。新适配器须验证数组/字典编码后 PHP 收到的结构；仅把对象转成字符串不能代替这个协议。资料保存不是按差异字段提交的 PATCH。

| 字段组 | 处理规则 |
| --- | --- |
| 定位/必填 | client_id 为当前客户；username 必填且最长 50；status 必填且只能 0/1/2，不用布尔值替代 |
| 联系方式 | email 或 phonenumber 至少一个；邮箱格式有效且不可与其他客户重复；手机号最长 30 且不可重复；phone_code 保留原值/有效选项，不随意数字化 |
| 元数据 | currency 保留读到的有效币种；余额大于 0 时服务端拒绝改币种。defaultgateway 对应启用网关 name；groupid 为有效组或 0；language 从返回 language 的键选择，不硬编码 zh_cn |
| 已读可编辑资料 | sex、profession、signature、companyname、country、province、address1、postcode、notes、qq、sale_id、know_us、marketing_emails_opt_in、send_close：按 profile 原值建白名单表单，明确修改时才改变 |
| 推介人 | 读取 aff_id_uid；第一版只展示，提交时省略，避免触发关联更新。若开放更改，需要补 profile/getclients/:client_id 的查询/权限和关联副作用验收；不提交显示字段 aff_id_username |
| 自定义字段 | custom 定义描述类型/选项/required/正则；custom_value 给已有值。维护 custom[id]，空值和数组形式须做实际往返验证，不能静默丢掉不可见字段 |
| 未加载字段 | profile SELECT 没有 city/region/avatar，虽然旧组件尝试读取。第一版不展示其默认空值、不凭空提交；avatar 仅在明确更换且上传契约验证后提交 |
| 密码 | 可选，设置时 6–20；第一版样板只改非敏感资料，省略 password；不回显、保存或重试密码 |

请求完整白名单还包含 password/avatar/city/region；“接口允许接收”不等于“本页已取得原值”。不要直接复制整个响应作为 POST：profile 计算字段、诊断字段、元数据不是可写资料。详细长度/校验依据：[UserManageValidate::scenePut](../../app/admin/validate/UserManageValidate.php)。

只读角色展示字段值；有资料读取但无元数据接口权限时，显示原值与加载拒绝，禁止用空选项覆盖。有资料编辑权限并不自动获得所有辅助接口的权限。

## 保存结果与失败处理

profilePost 当前执行顺序包括校验主字段、可选推介关系更新、更新 clients、调用 client_edit Hook，然后校验并保存自定义字段。没有包围整段方法的事务；Hook 还读取了已 unset 的 params.client_id。新 UI 需要把这个兼容风险纳入验证，后端修复应另立任务。

| 结果 | 页面动作 | 必须查询的事实 |
| --- | --- | --- |
| 明确 200 | 禁止重复提交，重读资料后更新基线/列表 | 主资料和自定义字段确实符合本次提交 |
| 400/409 等错误 | 保留安全草稿，显示字段/范围提示；写请求失败后在权限允许时重读 | 400 可能发生在主资料已经写入后；不能统一宣称“所有修改均未保存” |
| 超时/断网/非 JSON | 显示结果待核对，禁止自动重试，恢复网络后先读取 | 对比原值、草稿与服务器值，由用户决定后续操作 |
| 没有实际修改 | 在客户端检测后不发 POST | 同秒无变化更新可能影响 affected rows 并返回 UPDATE FAIL，不能以此判定接口失效 |
| 重查失败/无权限 | 保留草稿和待核对提示，避免覆盖 | 写响应不足以证明当前页面已同步；不得用本地表单充当服务器确认 |

特别用例：修改非敏感主资料并提交一个无效必填自定义字段，观察 400 后重新读取主资料和 custom_value。是否部分保存以实际读取为准；测试结束恢复 fixture。资源回滚只恢复旧 UI，不能撤销这种业务写入。

## 普通角色与规则落地

必须核对客户 list/profile/profilepost、实际使用的 summary，以及 Common::common/getgetways/getclientgroups/getsmscountry 的权限。它们由 AdminBase/GetUser 链校验，按运行时 action 小写构造规则；完整名称见[权限文档](14-admin-permission-matrix.md)。

本轮只读查询副本规则名称发现：clientlist 对应存储名称 `app\admin\controller\UserManageController::clientList`；profile 对应 `app\admin\controller\UserManagecontroller::profile`；profilepost 对应 `app\admin\controller\UserManagecontroller::profilePost`；summary 有两条匹配记录。数据库普通等值查询能够匹配这些大小写差异，但尚未核对列排序规则及运行时授权组合。不要因为源码大小写不同就直接新增规则，也不能假定 name 到 ID 一对一。

验收前导出实际 rule id/name/url/pid/is_display、auth_access、角色启用状态及销售范围，去除凭据和个人数据；核对重复记录与角色缓存后退出重登。AR/AE/AN 普通角色分别验证读取、编辑、拒绝；ID=1/role_id=1 的成功不能代替普通角色。辅助接口授权、菜单显示、直接访问和保存分别验收。

## 放行步骤与证据

1. 冻结工程方案，实际构建，列出预览入口/API/制品目录及旧入口恢复方式。
2. 在副本落实隔离 Session/Cookie、数据库权限、runtime/cache/上传/队列、外部通知与模块；Cron 使用同一实际 PHP。确认缺失部署扩展，再做应用启动验证。
3. 在隔离环境建立 AR/AE/AN 与客户 CA/CB 的受控 fixture，授权辅助接口，记录原值；首轮资料更改仅用非敏感字段。
4. 跑登录错误/成功、列表检索/返回、资料更改/重查、普通角色拒绝、重复联系方式、自定义字段失败、超时和无变化提交；按[验收文档](18-frontend-test-acceptance.md)记录。
5. 在桌面 1440×900、平板 768×1024、手机 390×844 与 320px 长文案宽度核对列表、单列表单、菜单/错误/保存区；截图须脱敏。
6. 按最终实施的后台入口方案切换并恢复完整旧制品，确认旧登录/客户读取恢复且业务数据保持；未决定入口开关前回滚为 BLOCKED，不能套用前台主题 Cookie。

每项记录源码与制品版本、APP_PHP、角色/规则、脱敏请求、最终读取、截图与 PASS/FAIL/BLOCKED/NOT RUN。样板全部通过后仅放行已落实契约的模块批次，不代表其他页面自动通过。

## 本轮已执行检查

此前预检轮 APP_PHP=/www/server/php/72/bin/php 下的 public_view_query_regression、billing_authority_regression、contract_contacts_access_control_regression 均通过；它们是独立静态源码回归，不启动 ThinkPHP 或验证浏览器权限。PDO 只读检查只验证所列库表可读，没有业务写入。后续浏览器轮已登录旧副本，完成本页所列部分读取/导航及布局观察；未调用 PHP/应用命令，也未运行新后台构建、客户写入、普通角色或回滚。文档链接、盘点一致性和 git diff 检查另见[开工状态](25-rewrite-readiness.md)。
