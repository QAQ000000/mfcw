# 页面总表

本表是页面设计契约的入口。路由和方法以 `data/route/home.php`、`data/route/admin.php`
为准；模板和控制器变更后应同步更新本表。

| 分组 | 关键路由/入口 | 模板或资源 | 认证 |
| --- | --- | --- | --- |
| 官网 | `/`、`.html` | `public/themes/web/<theme>/*.html` | 公开 |
| 登录注册 | `/login`、`/register`、`/pwreset`、`/bind` | `clientarea/{theme}/login.tpl` 等 | 登录前 |
| 客户中心 | `/clientarea`、`/details`、`/security`、`/verified` | `clientarea/{theme}/*.tpl` | 客户 |
| 服务管理 | `/service`、`/servicedetail`、`/host/*`、`/provision/*` | `service*.tpl`、`servicedetail.tpl` | 客户且校验主机归属 |
| 购物车 | `/cart`、`/store/:alias`、`/buy/:alias` | `cart/{theme}/*.tpl` | 公开/客户按操作区分 |
| 财务 | `/billing`、`/viewbilling`、`/invoicelist`、`/credit*` | 账单、充值和交易模板 | 客户 |
| 工单 | `/supporttickets`、`/submitticket`、`/viewticket`、`/ticket/*` | 工单模板 | 客户且校验工单归属 |
| 内容 | `/news*`、`/knowledgebase*`、`/downloads` | 内容模板 | 多数公开 |
| 后台 | 配置 `admin_application` 下的 `/index`、`/clients`、`/orders`、`/invoices` 等 | `public/admin/` 编译资源 | 管理员和功能权限 |

## 页面记录模板

新增或重做页面时，至少补充以下字段：

```md
页面：
路由和方法：
角色/权限：
控制器和模板：
布局区域：
数据接口和字段：
加载/空/错误/无权限状态：
提交成功、失败和重复提交行为：
桌面端/移动端规则：
验收条件：
```

## 当前重点

优先补齐详细契约的页面是登录注册、客户中心首页、商品配置与购物车、账单支付、服务
详情、工单详情和后台商品/订单/客户管理。新闻、帮助、下载等内容页面先保持模板清单。
