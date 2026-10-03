# 前端架构、源码与构建发布

## 当前事实与首阶段选择

首阶段前台继续使用 ThinkPHP `.tpl`，通过客户中心和购物车子主题覆盖，不改变 Session、业务 API 和数据库模型。模板、CSS、页面 JS 即源码制品；此路线不需要 Node 编译或 `composer update`。

后台现有编译资源是 Vue Router 页面，PHP View* 是另一套模板入口。2026-10-03 用户确认后台没有工程源码，实施方向确定为：**根据现有页面的排版、交互及真实业务接口，设计并新建可维护后台工程**。原工程恢复不再是开工前置条件。具体框架版本、依赖、锁文件、构建与预览入口由新工程落实，不能把本文示意目录当作已创建工程。

当前根目录及副本未找到完整后台前端工程、可用的包管理清单及对应构建命令。2026-10-03 只读检查未跟踪的 `public/admin/admin_SwLSA.tar.gz`：970 个条目，均为入口/编译资源及附带组件，未发现应用 src、应用 package.json、锁文件或构建配置；TinyMCE 自带 package.json 不是后台工程。不能将这个包认定为已恢复源码或可复现构建。`public/admin` 压缩 JS 是事实线索，不手工修改并作为源码维护。

## 路径与制品边界

| 分区 | 当前路径/来源 | 首批目标（方案，尚未创建） | 构建 |
| --- | --- | --- | --- |
| 客户中心 | `public/themes/clientarea/default`、child-theme-example | `public/themes/clientarea/ui-v1`，父 default | 模板和资源直接发布；验证模板编译和父级 include |
| 购物车 | `public/themes/cart/default`，其他购物车主题 | `public/themes/cart/ui-v1`，父 default | 直接发布；配置/购物车动作分别回退验证 |
| 官网 | `public/themes/web` | 首批保留当前主题 | 后续单独做内容和 SEO 批次 |
| 后台 SPA | `public/admin/js`、css、配置和入口资源 | 新建可维护工程，拟用 `frontend/admin`；在副本实现/验证 | 工程尚未创建，无已验证 build/dev/install 命令 |
| 后台 PHP View* | ViewAdminBase + Think 驱动 | 用于核对既有入口、字段和兼容关系 | 与新后台无自动替换关系，不作为新工程必需载体 |

子主题配置沿用仓库扁平格式，例如：

```text
name:"ui-v1"
description:"UI rewrite"
author:""
config-parent-theme:"default"
```

拷贝需要覆盖的模板及引用的公共文件，并保留现有语言、隐藏字段和脚本协议。模板回退只证明文件可找到，不证明 CSS/JS、语言加载和父主题 header/footer 正常。详情页子模板和 transaction 子目录也要记录实际来源。

## 已有入口与缺口

- 前台配置键：官网 `themes_templates`，客户中心 `clientarea_default_themes`，购物车全局 `order_page_style` 及商品订单主题设置。开发预览参数 `theme/carttheme` 和 Cookie `clientarea_theme/cart_theme` 是现有机制。
- 客户中心语言按配置主题加载，可能不跟随预览 Cookie；预览须同时检查语言来源。
- Think 模板驱动的后台路径是 `public/<adminAddress>/themes/<theme>`，而 `app/common.php::view_tpl_file()` 固定查 `themes/web/<theme>`。ViewAdminBase 先读取后者再 fetch，必须验证两者，不能只设置 `admin_default_theme` 就认为新后台可运行。
- 编译设置 chunk 调用 `config_general/getConfig/getConfigOption/newGeneral`，通过 Route::controller 的 POST 前缀分别映射 postGetConfig/postGetConfigOption/postNewGeneral，已定位实现。`data/route/admin.php` 另 include 仓库缺失的 `app/res/route/res.php`；需核对部署扩展。
- `public/admin/config.js` 含固定接口地址/目录，但当前 index.html 未直接引用它；编译请求基址为 window.global 或相对地址，withCredentials=true。部署时追踪实际入口注入、API 前缀、base/hash 与 rewrite，不能只改 config.js 就认定生效。不得把其中测试地址复制到新主题。

后台工程方案和登录→客户列表→资料编辑的请求链、环境预检及放行条件见[后台样板契约](26-admin-pilot-contract.md)。新建方向已确定，工程技术栈/目录/入口细节及实际构建尚未落实。

## 新后台逐页设计流程

1. 以 229 条编译路由记录与 76 个 PHP View* 入口共同建立页面映射；区分布局容器、详情子页、重定向、历史重复页和独立业务页。每条记录要有保留、合并、替代或不纳入本批的明确去向，不能把记录数当作业务页数。
2. 从可访问旧页面及编译组件提取现状：页面区域、表格列、筛选、表单、弹窗、按钮、导航及成功/失败反馈。已有[逐页产物证据](27-admin-built-page-evidence.md)和[核心解读](28-admin-built-layout-reading.md)；实际排版和交互需运行观察，无法观察的状态标明未验证，不补成既有事实。
3. 为每个业务页交付桌面与手机布局、字段/列、操作步骤、加载/空/拒绝/异常/提交状态、API/权限映射和验收步骤。先写现状，再写新设计；视觉结构可以重设计，业务能力必须有后端实现依据。
4. 在副本新建工程，以登录→客户列表→客户资料编辑为首个完整样板；先验证路由、Session、普通角色、请求编码和失败重查，再把通过的外壳、表格、表单与弹窗推广到后续页面。
5. 按模块冻结设计与开发批次；每批核对页面映射、接口和状态后实施，运行验收通过再放行下一批。现有文字布局是设计输入，全量页面仍需逐页补充真实交互与接口依据。

逐页契约应能回答：页面从哪里进入、各区域放什么、字段来自哪里、按钮何时可用、点击发送什么请求、结果如何确认、失败如何恢复，以及手机如何重排。新工程默认保留现有 PHP 业务层与数据库模型；新增业务能力或后端修复单独记录。

依据：[ViewBase](../../app/home/controller/ViewBaseController.php)、[ViewCart](../../app/home/controller/ViewCartController.php#L704)、[Think 驱动](../../vendor/thinkphp/library/think/view/driver/Think.php#L53)、[主题说明](../03-themes.md)。

## 可执行静态文档检查

在项目根目录运行（不加载 PHP 应用）：

```sh
node --check docs/scripts/generate-admin-page-inventory.cjs
npm install --prefix /tmp/zjmf-doc-parser acorn@8 postcss@8 --ignore-scripts --no-audit --no-fund
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --check
node --check docs/scripts/generate-admin-build-evidence.cjs
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-build-evidence.cjs --check
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node tests/admin_build_evidence_regression.cjs
node docs/scripts/check-doc-links.cjs
git diff --check
```

Acorn/PostCSS 是文档解析工具依赖，临时目录不加入应用仓库。后台产物变化后先审核，再用相应生成器 --write 更新盘点/证据；不能用重新生成替代人工业务核验。测试验证页面层级、局部请求归属、表格插槽事件、本地校验、CSS 断点及变量遮蔽，不执行页面代码或业务请求。

## 新后台工程的构建门槛

交付新工程源码、Node/包管理器版本、锁文件、实际 install/dev/build/lint/test 命令、环境变量说明、制品目录及 hash 清单后，补录到本文。生产脚本输出的目录应与新后台入口引用一致，source map 的发布范围需明确。每项命令必须在隔离构建环境实际执行，本文不预填不存在的 npm scripts。旧后台完整制品用于并行对照和回滚，不要求用新工程复现旧资源 hash。

## 发布制品

前台按主题目录发布完整版本，保留上版同名主题和父主题版本。后台保留完整入口、配置及所有 JS/CSS/字体资源；不能只替换一个哈希文件。制品清单包含 Git 版本、文件 SHA256、旧主题键值、入口/缓存配置和验收记录。

模板缓存清理使用站点实际 `APP_PHP`。ThinkPHP 的 `think clear --cache` 清整个 runtime/cache，可能影响业务缓存，先在隔离环境确认范围并记录；不能用无参数 clear 清日志来掩盖错误。FPM OPcache 和 CDN 缓存由部署管理分别处理，CLI 清理不证明它们失效。
