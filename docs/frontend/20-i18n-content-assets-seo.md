# 国际化、内容、资源与 SEO 契约

## 国际化

语言键按业务域和页面分组，禁止在模板中散落硬编码按钮、状态和错误文案。新键需要记录中文、英文、繁体中文（若启用）、变量说明和回退语言。金额、日期、时区、手机号和文件大小按后端区域/客户语言格式化，不改变原始数值。

状态文案必须与后端状态值建立映射表；未知状态显示“未知状态”并记录日志，不能直接把数据库枚举当作可读文案。

## 首批已有语言键

下表来自 `public/language/chinese.php`，前台通过 `$Lang` 使用。键存在不代表各语言已翻译齐全；英文/繁体要检查同键及缺失回退。后台编译 `$lang` 有另一套来源，不直接套前台 `$_LANG`。

| 页面/文案 | 已有键 | 适用边界 |
| --- | --- | --- |
| 登录邮箱/手机/密码 | email_address、phone_number、password、login_password | phone_number 存在重复赋值，取 PHP 最后生效值；不从首个匹配推断最终文案 |
| 提交/重新提交 | submit、re_submit | 按命令语义使用，提交中禁用保持宽度 |
| 商品配置/已选配置 | product_configuration、configuration_option、selected_configuration | 选项名称仍来自商品数据 |
| 金额 | subtotal、total、total_price | 数值/币种来自后端，不以语言文件改变金额 |
| 账单支付 | payment_method、pay_immediately、payee_information、payer_information | 已付/未知状态不显示错误的支付命令 |
| 工单表头 | tablelist_tickets_id、tablelist_tickets_title、tablelist_tickets_status、tablelist_tickets_cid | 具体状态名来自 ticket_status 配置 |
| 信用额账单 | invoice_type_credit_limit、credit_limit_invoice_payment_status_paid/unpaid/prepayment/overdue | 后四项各是完整键，不把 / 分隔串用作键；不能当预存余额状态 |

本批不引入新的强制语言键或删除旧键。需要新“处理中/重试”等文案时，在主题语言包新增并检查所有启用语言，未翻译则记录缺口；客户中心预览 Cookie 与语言读取配置主题的差异须验收。

## 内容和资源

- Logo、图标、字体、插画、产品图和编辑器资源记录来源、授权、尺寸和主题归属。
- 主题私有资源放主题目录；不要修改共享 `public/static` 来解决单一页面问题。
- 资源引用使用版本参数或构建清单，发布时保留上一版资源用于回滚。
- 图片提供尺寸、懒加载、替代文本和失败占位；图标提供可访问名称。
- 语言包、邮件模板、短信模板和帮助文章的变量均要经过转义和安全审查。

## 官网 SEO 和 URL

公开页面重构必须保持或明确变更：页面标题、描述、Canonical、Open Graph、结构化数据、语言替代链接、robots、站点地图、分页 URL、文章分类和 404。旧文章、产品和帮助 URL 若改变，建立逐条 301 映射并验证查询参数、语言和尾斜杠策略。

客户中心和后台页面默认禁止被搜索引擎索引，不在 HTML、Source Map 或错误页泄露客户、管理员和配置数据。

## 首批 URL 保持表

| 对象 | 保持 URL/参数 | SEO/链接处理 |
| --- | --- | --- |
| 登录/客户中心 | /login、/clientarea | 不新建公开索引页；是否实际输出 noindex 需浏览器/响应验证 |
| 商品与购物车 | /cart?action=configureproduct&pid=…、action=viewcart/ordersummary/complete；/store/:alias、/buy/:alias | 本批不改 URL、不新增 301；alias 仍由现有路由解释 |
| 账单/服务 | /viewbilling?id=…、/servicedetail?id=… | 保留业务 ID/查询参数，私有页面不产生公开 sitemap 项 |
| 工单 | /viewticket?tid=…；后台内部数字 id | tid/id 不互换，不把访客 c 写入公开 URL 清单 |
| 官网文章/帮助 | 首批不改现有 URL | 后续官网批次再冻结 canonical/301/robots；现有 SEO 不能凭原则文档判 PASS |

本批不需要 URL 数据迁移；后台 Vue 路径是否带 hash、实际后台前缀仍按部署验证。模板新增标题/描述不得包含账单金额、客户姓名或凭据。

## 内容验收

每个主题至少检查缺失语言键、长标题、长错误、RTL/特殊字符（若启用）、图片加载失败、富文本链接、移动端换行和打印/下载场景。SEO 检查必须在真实域名和 HTTPS 下执行，不能只检查静态截图。
