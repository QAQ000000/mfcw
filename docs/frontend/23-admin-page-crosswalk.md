# 后台两套路由的对应关系

PHP View* 是服务端模板入口；编译前端使用 Vue Router，有独立布局和客户子页。以下是静态业务对应，不是重定向关系，不表示可互换。前端全表见[229 条路由盘点](22-admin-route-inventory.md)。未列条目继续保留独立项，不能因名称相似直接合并。

编译路由之间的父/子、重定向、组件事件及实际 $router 跳转见[逐页结构证据](27-admin-built-page-evidence.md)。例如客户列表点击姓名带 query.id 进入 abstract，person 保存/取消回 abstract；详情标签切换保留 id/uid/currencyId。对应旧排版解读见[页面关系说明](28-admin-built-layout-reading.md)。这些关系仍不等于运行时菜单或权限。

## 核心对应

| 编译前端路径 | PHP View* 对应 | 数据线索 | 关系/限制 |
| --- | --- | --- | --- |
| `/login` | 无；Public::adPage | POST {A}/login | 独立登录，需核对部署 base/hash |
| `/home-page` | index | common、ad_index/report | 同领域；指标另查接口 |
| `/customer-list` | clients | client_list | 同业务，不同渲染 |
| `/customer-view/abstract`、abstractOld | clientssummary | summary | 新旧摘要并存，不直接合并 |
| `/customer-view/person` | clientsprofile | profile/:client_id、profile_post | 客户资料 |
| `/customer-view/product-list` | clientsservices | 客户服务接口 | 客户服务列表 |
| `/customer-view/product-innerpage` | clientsviewservices | clients_services/*、provision/default | 服务详情 |
| `/customer-view/bill` | clientsinvoices | user_invoice | 客户账单 |
| `/customer-view/transactions` | clientstransactions | 交易/余额接口 | 客户交易 |
| `/customer-view/credit` | clientscredit | credit_limit 与 CreditController | 编译页同时有余额 credit_line 和信用额编辑；新模板分区 |
| `/customer-view/tickets` | clientssupporttickets | client_ticket | 客户工单 |
| `/support-ticket-detail` | clientssupportticketdetail | GET list_ticket/:id | 工单详情 |
| `/customer-view/log` | clientslog | log_record | 操作日志 |
| `/customer-view/noticelog`、smslog、emaillog、station-letterlog | clientsnoticelog、clientsviewemail | 各消息接口 | 一对多，保留类型字段 |
| `/customer-view/annex` | clientsattach | 附件接口 | 附件 |
| `/customer-view/promotion_plan`、follow-status | clientsaffiliate、clientscrm | 推广/跟进接口 | 同领域，逐操作核对 |
| `/customer-add` | 无专用 View* | create_client、create_client_post | 独立新增客户页 |
| `/customer-authentication` | clientsauthentication | cerify_log_list 等 | 实名认证 |
| `/customer-resources` | clientsresources | client_list_resource | 客户资源池，非物理资源池 |
| `/resource-pool` | resourcepool | 资源方审核控制器 | View* 仍复用客户列表，业务待核对 |
| `/order-list`、order-detail、add-order | orders、orderdetail、ordersadd | order/search、orders/:id、order/create | 订单/代下单 |
| `/bill-management`、bill-detail | invoices、viewinvoices | invoice/index、invoice/summary/:id | 应收账单 |
| `/support-ticket`、support-statistics、add-support-ticket | supportticket、supportstatistics、createsupporttickets | list_ticket、ticket_statistics、add_ticket | 工单业务 |
| `/credit-management`、credit-setting | 无专用 View* | credit_limit/client_list、credit_limit/config | 全局信用额管理/配置 |
| `/product-server`、edit-product | configproducts | product_list_page、edit_product_page/:id、edit_product | 产品分组和编辑；dcim/zjmfcloud 专用页分别核对 |

部分数据线索尚未逐字段核验。完整页面对应和替代关系必须继续结合菜单、权限与浏览器导航冻结。

## View* 未覆盖的设置页

| 前端页/chunk | 编译页已有字段 | 新模板布局方案 | 接口边界 |
| --- | --- | --- | --- |
| `/base-info` / BaseInfo | main_phone,company_qq,main_address,record_no,www_logo,seo_keywords,seo_desc,company_profile,header,footer,login_header_footer,web_widgets | 基本信息、品牌、SEO、登录页头尾、嵌入内容五组；右侧预览，手机移到字段下 | POST config_general/getConfig/getConfigOption/newGeneral 经 controller 前缀映射 postGetConfig/postGetConfigOption/postNewGeneral，见接口文档 |
| `/theme-template` / ThemeTemplate | is_themes,themes_templates,clientarea_default_themes | 官网、客户中心主题独立预览/选择；购物车放独立设置组，不把新建议说成当前已有字段 | 目录选项由 ConfigGeneral trait 提供；请求同上；保存后重新读配置 |
| `/login-register` / LoginRegister | allow_login_register,allow_register_phone,allow_register_email,allow_email_register_code,clients_profoptional | 注册方式、验证码、必填资料分组 | 是登录注册规则设置，区别于 /login；旧显式 register_login_page/register_login 存在 |
| `/twice-confirm` / TwiceConfirm | second_verify_home,second_verify_action_home_type,second_verify_action_home,second_verify_admin,second_verify_action_admin | 前台/后台标签，动作清单、渠道、保存确认和回填 | 动作来自 app/app.php；二次验证不是通用确认弹窗 |
| `/third-login` / ThirdLogin | OAuth 插件/配置 | 插件列表、启停、参数编辑 | oauth 独立 API |

产物只作为路由、字段、调用线索。没有运行浏览器验收，也没有为了适配缺失方法修改业务代码。
