# 当前模板与页面目录

本目录用于重做模板前的基线盘点。文件清单来自当前仓库；路由清单以
`data/route/home.php`、`data/route/admin.php` 为准。新增、删除或合并页面时必须更新本页。

## 官网主题 `public/themes/web/zjmf/`

首页和内容页：`index.html`、`about.html`、`contact.html`、`relation.html`、`map.html`、
`privacy.html`、`tos.html`、`aup.html`、`safeguard.html`、`management.html`。

产品与服务页：`cloud.html`、`hosting.html`、`server.html`、`dediserver.html`、
`colocation.html`、`cdn.html`、`domain.html`、`ssl.html`、`nat.html`、`antiddos.html`、
`transfer.html`。

新闻和帮助页：`news.html`、`newscate.html`、`newscategory.html`、`newsarticle.html`、
`newscontent.html`、`newssearch.html`、`help.html`、`helpcate.html`、
`helpcategory.html`、`helparticle.html`、`helpcontent.html`、`helpsearch.html`。

异常页：`404.html`。官网公共头尾和 SEO 数据由控制器与主题配置共同提供。

## 客户中心主题 `public/themes/clientarea/default/`

公共布局：`header.tpl`、`footer.tpl`、`clientarea.tpl`、`maintenance.tpl`、`404.tpl`。

登录和账户：`login.tpl`、`loginaccesstoken.tpl`、`register.tpl`、`pwreset.tpl`、
`bind.tpl`、`details.tpl`、`security.tpl`、`message.tpl`、`verified.tpl`、
`verifiedpersonal.tpl`、`verifiedenterprises.tpl`。

服务：`service.tpl`、`servicedetail.tpl`、`service_product.tpl`、`service_hosting.tpl`、
`service_server.tpl`、`service_cloud.tpl`、`service_cloud_server.tpl`、`service_cdn.tpl`、
`service_domain.tpl`、`service_sms.tpl`、`service_soft.tpl`、`service_ssl.tpl`。

财务：`billing.tpl`、`viewbilling.tpl`、`invoicelist.tpl`、`invoiceapply.tpl`、
`invoicecompany.tpl`、`invoiceaddress.tpl`、`addfunds.tpl`、`transaction.tpl`、
`credit.tpl`、`creditdetail.tpl`、`combinebilling.tpl`、`mulitrenew.tpl`。

支持和内容：`supporttickets.tpl`、`submitticket.tpl`、`viewticket.tpl`、`news.tpl`、
`newslist.tpl`、`newsview.tpl`、`knowledgebase.tpl`、`knowledgebaselist.tpl`、
`knowledgebaseview.tpl`、`downloads.tpl`、`downloadscate.tpl`。

扩展页面：`affiliates.tpl`、`apimanage.tpl`、`apilog.tpl`、`loginlog.tpl`、
`systemlog.tpl`、`contract.tpl`、`contracthost.tpl`。`apps`、`authorDown` 等路由可能由
插件或控制器动态提供，当前默认主题目录未找到同名模板，重做前必须从实际部署和控制器
确认最终模板。

## 购物车主题 `public/themes/cart/default/`

`product.tpl`、`configureproduct.tpl`、`ordersummary.tpl`、`viewcart.tpl`、`complete.tpl`、
`sidebar-categories.tpl`。`theme.config` 和主题图不属于页面布局，但属于主题发布内容。

## 后台 PHP 页面入口（局部清单）

后台页面由 `data/route/admin.php` 以 `admin_application` 配置的前缀提供，主要分组如下：

| 分组 | 当前页面入口 |
| --- | --- |
| 仪表盘/插件 | `index`、`plugins` |
| 客户 | `clients`、`clientsauthentication`、`clientsresources`、`resourcepool`、`salesstatistics`、`affiliates`、`massmailsms`、`configclientgroups`、`configauthentication`、`configclientscustomfields`、`configaffiliates`、`configclientslevel` |
| 客户详情 | `clientssummary`、`clientsprofile`、`clientsservices`、`clientsinvoices`、`clientstransactions`、`clientscredit`、`clientssupporttickets`、`clientslog`、`clientsnoticelog`、`clientsattach`、`clientsaffiliate`、`clientscrm`、`clientsviewservices`、`clientssupportticketdetail`、`viewinvoices`、`ordersadd`、`createsupporttickets`、`clientsviewemail` |
| 业务 | `orders`、`orderdetail`、`trafficorder`、`productlist`、`cancelrequests` |
| 财务 | `transactions`、`invoices`、`withdrawdeposits`、`receipt`、`configgateways`、`configpromotions`、`configpromotionsadd`、`configcurrencies`、`configfund`、`configreceipt` |
| 工单 | `supportticket`、`supportstatistics`、`configticketdepartments`、`configticketdepartmentsadd`、`configticketstatuses`、`configticketpass` |
| 商品 | `configproducts`、`configproductoptionsedit`、`configproductoptionsaddon`、`configtraffic`、`configservermodule`、`configservermoduleedit`、`configdcimmoodule`、`configdcimmooduleedit`、`configzjmfcloud`、`configproductoptions`、`configproductoptionsgroup`、`configproduct` |
| 统计 | `annualstatistics`、`newcustomer`、`productrevenue`、`revenueranking` |
| 资源 | `munualresource`、`addOrEditresource`、`upStreamedit`、`zjmfapi` |

以上仅是 76 个 PHP View* 入口。当前后台编译产物另有 229 条 Vue Router 路由记录，含布局、子页、错误页和重定向。完整静态记录见[路由盘点](22-admin-route-inventory.md)，重点页面对应及额外设置页见[对应关系](23-admin-page-crosswalk.md)。动态插件菜单、权限可见性和真实浏览器路径尚未验证，不能宣称后台页面全量盘点完成。
