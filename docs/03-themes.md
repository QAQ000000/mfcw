# 主题开发

## 1. 三套主题

| 类型 | 路径 | 默认/示例 | 选择配置 |
| --- | --- | --- | --- |
| 官网 | `public/themes/web/<name>/` | `clientareaonly`、`zjmf` | `configuration('themes_templates')` |
| 客户中心 | `public/themes/clientarea/<name>/` | `default`、`child-theme-example` | `configuration('clientarea_default_themes')` |
| 购物车 | `public/themes/cart/<name>/` | `default`、`area`、`province` | 商品/请求主题和 Cookie |

官网模板通常为 `.html`，客户中心和购物车主要为 `.tpl`。渲染入口分别在
`ViewController`、`ViewClientsController` 和 `ViewCartController`，公共处理在
`ViewBaseController`。

不要直接修改 `default`。升级包可能替换内置主题；应复制最小覆盖文件并声明父主题。
父主题回退由仓库定制的 Think 模板驱动实现：当前主题缺少 `.tpl` 时，模板驱动会
尝试父主题中的同名文件。

## 2. 创建客户中心子主题

```text
public/themes/clientarea/acme/
├── theme.config
├── custom.css
├── language/
│   ├── chinese.php
│   └── english.php
└── clientarea.tpl
```

`theme.config`：

```text
name:"acme"
description:"Acme 客户中心"
author:"Acme"
config-parent-theme:"default"
```

只复制需要覆盖的模板。未提供的 `.tpl` 由父主题 `default` 处理；完整示例位于
`public/themes/clientarea/child-theme-example`。父主题配置也会影响部分设置和资源路径，
所以在后台选择新客户中心主题后仍要验证登录、首页、产品详情、账单、支付和工单页面。

开发环境可用 `?theme=acme` 临时选择客户主题，系统会写入 `clientarea_theme`
Cookie。不要把这个入口当作生产权限边界，也不要允许任意目录名；控制器只接受实际
主题目录列表中的名称。

## 3. 创建购物车子主题

```text
public/themes/cart/acme-cart/
├── theme.config
├── configureproduct.tpl
└── assets/
```

配置示例：

```text
name:"acme-cart"
description:"Acme 购物车"
author:"Acme"
config-parent-theme:"default"
loggedheader:clientarea
nologinheader:clientarea
```

关键属性：

| 属性 | 含义 |
| --- | --- |
| `config-parent-theme` | 找不到模板时使用的父主题 |
| `loggedheader` | 已登录购物车使用 `web` 还是 `clientarea` 头尾 |
| `nologinheader` | 未登录购物车使用的头尾 |
| `bootstrap`、`jquery`、`fontawesome` | 内置主题用于记录依赖版本的扁平键；运行时不解析层级 |

虽然内置购物车主题把 `properties:`、`provides:` 和缩进子项写得像 YAML，实际的
`view_tpl_yaml()` 不是 YAML 解析器。它只按 CRLF（`\r\n`）分行，再按第一个冒号
读取扁平键值；缩进没有层级含义，值中也不能安全包含冒号。新配置应使用 CRLF 和简单
`key:"value"` 行，不要依赖嵌套结构，也不要改成只有 LF 的换行格式。

`?carttheme=<name>` 或商品配置可切换购物车主题，并写入 `cart_theme` Cookie。产品
配置、配置项价格、优惠码、数量修改和结算表单必须一起测试，不能只检查首屏样式。

## 4. 官网主题

官网主题位于 `public/themes/web`，路由通常由 `ViewController` 按页面名查找
`<page>.html`。内置 `zjmf` 展示了首页、产品分类、新闻、帮助中心和静态内容页面的
完整结构。

模板可以通过 `{tagdata ...}` 声明需要由 `ViewModel` 提供的数据。公共头尾使用：

```html
{include file="common/header" /}
{tagdata name="newsList[num:5|order:desc]"}
```

`ViewBaseController::viewOutData()` 会解析 `tagdata`，按声明获取数据。不要在模板中
拼接未经转义的请求参数或直接查询数据库。

## 5. 模板变量

页面控制器会按场景增加业务数据，公共变量主要包括：

| 变量 | 内容 |
| --- | --- |
| `$Setting` | 系统设置、站点 URL 和当前头部类型 |
| `$Userinfo` | 当前客户资料、安全设置和销售人员信息 |
| `$Lang` | 系统语言与主题语言合并结果 |
| `$Language`、`$LanguageCheck` | 可用语言和当前语言 |
| `$Nav` | 客户中心导航 |
| `$CartShopData` | 当前购物车会话 |
| `$Get`、`$Post` | 处理后的查询与表单参数 |
| `$TplName`、`$RouteName` | 当前模板/路由名 |
| `$Ver` | 静态资源缓存版本 |

在模板中使用 `{debug}` 可显示当前模板数据，但它可能暴露客户和系统信息，只能在隔离
开发环境使用，发布前必须移除。

## 6. 多语言

主题语言目录为 `<theme>/language/*.php`。文件沿用现有格式，设置 `$_LANG`：

```php
<?php

$_LANG['display_name'] = '简体中文';
$_LANG['display_flag'] = 'CN';
$_LANG['acme_welcome'] = '欢迎';
```

主题语言会与 `public/language/<language>.php` 合并。键名应加主题前缀，避免覆盖系统
键；至少提供后台启用的全部语言文件。

## 7. 静态资源

- 使用主题自身的相对目录，不修改 `public/static` 中的共享依赖。
- 资源 URL 附加 `?v={$Ver}`，便于版本发布后失效缓存。
- 不重复加载主题已声明的 jQuery/Bootstrap，避免插件冲突。
- 客户输入和后台富文本不要直接写入 `<script>`、事件属性或 CSS URL。
- 图片和字体应设置稳定尺寸，分别验证桌面端和移动端。

## 8. 覆盖清单

客户中心 `default` 中的重要模板：

| 场景 | 文件 |
| --- | --- |
| 布局 | `header.tpl`、`footer.tpl`、`includes/head.tpl`、`includes/menu.tpl` |
| 登录注册 | `login.tpl`、`register.tpl`、`pwreset.tpl`、`bind.tpl` |
| 首页与产品 | `clientarea.tpl`、`service*.tpl`、`servicedetail*.tpl` |
| 账单支付 | `invoicelist.tpl`、`viewbilling.tpl`、`includes/pay*.tpl` |
| 工单 | `supporttickets.tpl`、`submitticket.tpl`、`viewticket.tpl` |
| 实名 | `verified*.tpl`、`security.tpl` |

购物车 `default` 的关键文件为 `product.tpl`、`configureproduct.tpl`、
`viewcart.tpl`、`ordersummary.tpl` 和 `complete.tpl`。

## 9. 发布检查

1. 子主题只包含有意覆盖的文件，父主题名称存在。
2. 登录前后头尾选择正确，官网与客户中心资源不重复加载。
3. 所有语言均无未定义键，长文本和移动端不溢出。
4. 商品配置、金额、数量、优惠码和支付按钮不因样式覆盖而丢字段。
5. 表单保留框架需要的 Token、隐藏字段和 HTTP 方法。
6. 无 `{debug}`、测试域名、源映射密钥或管理员数据泄漏。
7. 清理模板缓存后再做完整验收。
