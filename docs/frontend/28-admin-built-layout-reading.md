# 旧后台排版、页面关系与交互解读

本页主要是 2026-10-03 从编译 JS/CSS 读取的旧版现状说明；提取过程不执行产物或请求业务接口，所列 CSS 声明不能视作实测。随后已对副本登录、客户列表、摘要/资料导航做浏览器核对，实测与脱敏截图见[浏览器观察](29-admin-browser-observations.md)，字段分组据此校正。新设计见 12/19/24/26 文档，旧代码的缺陷不作为必须保留的交互。

## 全量证据与覆盖范围

[逐页证据](27-admin-built-page-evidence.md)为 229 条编译路由逐条记录父子关系、重定向、JS/CSS、组件渲染层级、字段/列、事件、表单校验、方法调用、请求、反馈和跳转参数。每项可回查模块、scope 和资源 SHA256。路由记录包含外壳、历史页、错误页与重定向，不等于 229 个独立业务页。

当前 222 条记录直接定位到路由模块并提取 Vue 组件；7 条尚未完成直接归属：

| 路由 | 当前提取状态 | 后续核对 |
| --- | --- | --- |
| /forbidden | 未定位组件 | 纯模板/模块导出形式 |
| /set | 未定位组件 | 同步布局和默认子页 customer-custom |
| /sms-template | 未定位组件 | 同步父容器及 sms/email 子页 |
| /general-settings | 未定位组件 | 同步父容器及 13 个子路由 |
| /customer-view/product-innerpage | chunk 内候选 | 多个共享/分拆组件与实际默认导出的关系 |
| /edit-product | chunk 内候选 | 多 chunk 与实际商品编辑容器/子组件 |
| /menu_manage | chunk 内候选 | 同步/共享组件及路由 factory 的归属 |

同一模块可能同时包含主组件和内嵌组件，scope 用于区别，不把多个组件都当成独立页。共享模块的压缩文本可能因变量名不同而变化；提取器优先使用当前文件内的实现，跨文件有歧义则保留未解析记录。

## 页面关系的现状

| 起点/容器 | 子页或目标 | 关系与上下文 |
| --- | --- | --- |
| /login | 登录后后台入口 | 独立登录路由；API/base/hash 和部署入口需实际核对 |
| / | home-page，以及客户、财务、工单、设置等根级 children | 后台外壳容器，默认重定向 home-page，不是客户列表本身 |
| /customer-list | /customer-view/abstract | goToView(id) 通过 query.id 传入选中客户 |
| /customer-list | /customer-add | 新增客户是独立路由 |
| /customer-view | abstract/person/product-list/bill/transactions/credit/tickets/log 等 | 同一客户的详情子路由，外壳内 router-view 切换内容 |
| /customer-view | person 等客户标签目标 | 窄屏 handleClick 按 route[name] 跳转并保留 id/uid/currencyId，navIndex 写入 sessionStorage |
| /customer-view/person | /customer-view/abstract | 保存成功或取消后返回摘要，携带 id |

这是 Router children 和代码跳转关系。菜单显示、授权、销售/部门范围不是由 children 推导；动态插件菜单仍需单独盘点。完整 PHP/SPA 对应见[页面映射](23-admin-page-crosswalk.md)。

## 登录页

来源：[Login JS](../../public/admin/js/Login~f71cff67.f285f1fa.js)、[Login CSS](../../public/admin/css/Login~f71cff67.f34aca91.css)。模块 9ed6 中有验证码组件 scope=1a5f00d6 和登录主体 scope=7d93d0fc。

旧布局为铺满容器的背景图，登录块宽 400px，绝对定位 left/top=50%，translate(-50%,-50%) 居中。白色表单 padding=60px 40px，圆角 4px；标题下方按行排列账号、密码、图形验证码、条件显示的二次验证码和登录操作。背景引用 log_bj.7ac0a826.jpg，验证码图片可点击刷新。

表单绑定 formLabelAlign，ref=loginFormRef。账号、密码在本地规则中必填、blur 校验；code 有独立规则，其区域仅在 second_verify_admin=1 且动作包含 login 时渲染；captcha 区域还受 formLabelAlignCaptcha 控制。二次验证和验证码是否启用仍需与后台配置核对。

登录方法通过 POST login 提交，显式维护 loginLoading，成功分支显示通知；请求链还涉及用户信息读取。请求器中的统一错误处理、205 插件接管、验证码刷新后的 Session 关联和成功落点要运行验证。对应业务请求与异常要求见[样板契约](26-admin-pilot-contract.md)。

对应 Login CSS 未提取到独立手机 media 规则；后续浏览器确认 390px 下左右各超出 5px、320px 下各超出 40px，详见[实测](29-admin-browser-observations.md)。新设计应采用有最大宽度的自适应布局，手机效果需验收。

## 后台外壳

来源：[Home JS](../../public/admin/js/Home~f71cff67.2d110421.js)、[Home CSS](../../public/admin/css/Home~f71cff67.091ec3e2.css)。菜单、侧栏与内容容器在同模块内有多个组件，主外壳 scope=60e995b6。

CSS 中顶栏导航高度为 60px，手机菜单固定在 top=60px、延伸到底部并独立滚动；未折叠菜单宽 200px。主内容 height=calc(100vh - 60px)、padding=25px 20px；max-width:600px 时主内容 padding=0。侧栏/主区有独立折叠与过渡状态。

渲染代码按 screenWidth>=1170、showAside、listener、leftAllShow 等条件决定侧栏分支。router-view 分为 noCardPage 与其他页面两种容器结构，不能把所有业务页都描述成同一种外层卡片。

菜单含 license_type、页面标识和数据驱动条件；静态代码不能证明某实例当前菜单。新版外壳的 56px 顶栏、224px 侧栏等是 19/24 文档中的新尺寸方案，与这里的旧版 60px/200px 分别记录。

## 客户列表

来源：[CustomerList JS](../../public/admin/js/CustomerList~31ecd969.a488bd54.js)、[CustomerList CSS](../../public/admin/css/CustomerList~31ecd969.df74bb52.css)。模块 41f5、scope=3a7c7393。

旧页面按渲染顺序为：顶部说明/帮助入口 → 新增与筛选工具 → 可展开筛选表单 → 客户表格 → 分页/条数控制。筛选表单 inline，绑定 search，label-width=120px。姓名、公司、邮件、手机、状态、API 状态、组和销售等筛选定义来自服务器，不是全部硬编码在页面。

表格声明的列顺序及宽度：

| 顺序 | 字段/列 | 声明宽度或条件 |
| --- | --- | --- |
| 1 | id / ID | 70，居中、自定义排序 |
| 2 | username / 姓名 | 未单独指定固定宽度；点击进入客户摘要 |
| 3 | phonenumber / 手机号/邮箱 | min-width=100，单元格内容另有分支 |
| 4 | host_total / 服务 | min-width=70 |
| 5 | amount_in / 收入/支出 | 115；包含收入/支出展示 |
| 6 | credit / 余额 | min-width=90，自定义排序 |
| 7 | group_name / 客户分组 | 135，居中 |
| 8 | status / 状态 | 85，居中、自定义排序 |
| 9 | user_nickname / 销售 | 未单独指定固定宽度 |
| 10 | credit_limit / 信用额（已用/总计） | 200；不能与余额列混同 |
| 11 | create_time / API开通时间 | 135，allow_resource_api!=字符串0 时出现 |

这是旧 render 的列声明，不是按 View* 文字方案推测的字段集合。动态单元格、弹出内容和条件分支详见逐页证据。

旧 CSS 把表格 td 设为 height=45px、padding=0。顶部工具区常规为 max-content；max-width:800px 时改为 grid 的两列，每列 48%，gap=15px 0；max-width:768px 时按钮、输入和选择控件宽 32vw。这些数值是否造成拥挤/溢出未实测，不要求新设计照搬。

交互代码包括展开/收起、搜索、清空、页码/每页条数、排序、客户跳转以及新增跳转。getData 普通分支经 qs.stringify 编码后 POST client_list，特定高级搜索分支还会调用 POST searchfornamelist；返回读取 list/total/search/level_search/seachData 等。原文档把旧客户端写成 GET 已纠正，PHP 路由本身声明 RULE，不代表仅 GET。

changeSort 的旧升序分支写入字符串 AESC，降序写 DESC。这里记录旧代码拼写；新适配器应明确使用合法排序值并核对后端，不能因照抄产物而延续错误。当前没有发排序请求或判断运行是否报错。

## 客户详情容器

来源：[CustomerView JS](../../public/admin/js/CustomerView~f71cff67.74e75181.js)、[CustomerView CSS](../../public/admin/css/CustomerView~f71cff67.50f2e472.css)。客户摘要浮层 scope=7e24bb4d，主容器 scope=36f8db60。

宽度 screenWidth>992 时用水平 el-menu/菜单项导航，否则用 el-tabs/el-tab-pane。下方 router-view 加载当前客户子页。菜单项高度 40px，垂直/水平居中；选中项边框高亮，导航与内容之间 margin-bottom=20px。

客户身份摘要定位在右上角，内容最大宽 200px、单行省略；对应 CSS 在 max-width:993px 时改摘要 top=-22px。代码导航断点 992 与 CSS 993 并不相同，交界宽度要实测。菜单左右 padding 还随 1400/1600px 区间变化。

标签包括摘要、个人资料、产品服务、账单、交易、信用管理、工单、日志、API 概览、通知、附件、推广和跟进等；部分区域按 edition/license_type、showPromanPlan、developer 条件出现。标签与具体 API 权限不能仅按标题推断。

## 客户资料页

来源：[CustomerPerson JS](../../public/admin/js/CustomerPerson~f71cff67.abc0d2f9.js)、[CustomerPerson CSS](../../public/admin/css/CustomerPerson~f71cff67.36a7d3df.css)。模块 5899d、scope=f40d8fe4。

页面以 inline el-form 绑定 customerForm，标签位置 top、label-width 随 labelWidth 变化。外层 row gutter=10，三块 col span=24；块内使用 max-1200/ml-23 等公共类，标题通过 data-title 表示。以下按后续浏览器核对校正分组，自定义字段来自静态条件分支：

| 分组 | render 中可见的字段 |
| --- | --- |
| 个人资料 | 姓名、性别、公司、国家、省、地址、邮编、自定义字段、了解途径 |
| 账户信息 | 手机、邮箱、QQ、密码 |
| 其他设置 | 支付方式、推荐人、语言、销售、客户分组、状态、接收营销信息、关闭发送邮件短信 |

自定义字段按 text/link/password/dropdown/tickbox 等 fieldtype 渲染，required 来自字段定义。主表单本地规则含姓名必填、邮箱格式、邮编和手机号正则，触发主要为 blur；这些规则与 PHP 长度/格式限制不完全一致，接口校验为最终业务依据。

主容器 height=calc(100vh - 225px)、overflow-y=auto、overflow-x=hidden、padding-bottom=30px。自动完成框宽 200px；max-width:768px 时调整绑定提示的定位。后续浏览器首次缩屏观察到侧栏未收起导致字段裁切，后续缩屏又出现桌面导航换行；手机宽度重新加载后显示 tabs、单列表单并能滚至末尾。响应式状态有进入路径差异，内层滚动与手机键盘的关系尚未验证，见[实测](29-admin-browser-observations.md)。

editCustomer 先组装 custom[id]，没有新头像时把表单 avatar 置空，调用表单 validate，设置 btnLoading 后 POST profile_post。明确 200 时提示成功、跳到 abstract，并更新 navIndex；业务失败分支显示 msg。取消操作 resetFields 后返回 abstract。

旧成功分支没有在该方法内重读 profile；新样板要求重读并确认最终状态。旧表单对未返回 city/region/avatar 的读取也不能照抄为空值覆盖；后端可能在主资料写入后因自定义字段错误返回 400，因此新版必须保留草稿、核对服务器值和避免自动重试。详见[资料保存契约](26-admin-pilot-contract.md)。

## 新设计如何使用这些证据

每个页面依次填写“旧版结构/交互证据 → 保留的业务行为 → 新桌面/手机布局 → 调整原因 → 接口/权限/异常 → 验收”。先以登录、客户列表、资料编辑做完整样板，再按模块推进。

全量证据覆盖的是静态提取；仍有动态数据、混入/子组件、部署、角色和真实渲染待核对。不能把已生成 229 条记录解释为 229 个页面已经全部完成设计或运行验收。
