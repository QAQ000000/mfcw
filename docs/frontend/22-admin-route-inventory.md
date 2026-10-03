# 后台前端路由与服务端页面静态盘点

本文件由 `docs/scripts/generate-admin-page-inventory.cjs` 生成。解析 JavaScript AST，不执行编译资源。前端路由与 PHP 页面是两套入口，不能相加后宣称页面完整；隐藏、重定向、插件动态菜单和部署路径仍须浏览器验证。

前端产物：[public/admin/js/app~5a11b65b.94a330a1.js:1](../../public/admin/js/app~5a11b65b.94a330a1.js#L1)；SHA256：`0d3d40ab4e88b974a0fbf03f82c0daf9b3ca7ff1d0b04568c3e9de0a6182f6d2`。

路由记录 229 条（包含父布局、重定向、错误页）；PHP View* 路由声明 158 条，其中后台 76 条、前台 82 条（含不同 HTTP 方法）。字面量路由声明 1234 条，CONTROLLER 方法推导候选 206 条，不相加作为运行时端点数。`{A}` 代表实际后台前缀。

## 前端路由表

| 前端路由 | name | 重定向 | 延迟加载 chunk |
| --- | --- | --- | --- |
| `/login` | `login` | - | vendors~Login~987e6011, Login~f71cff67 |
| `/forbidden` | `Forbidden` | - | Forbidden~f71cff67 |
| `/404` | `404` | - | notFound~f71cff67 |
| `/500` | `500` | - | serverError~f71cff67 |
| `/edit-configurable-option1` | `editConfigurableOption1` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, EditConfigurableOption1~31ecd969 |
| `/email-log-detail1` | `emailLogDetail1` | - | EmailLogDetail1~f71cff67 |
| `/balance-details1` | `balanceDetails1` | - | BalanceDetails1~f71cff67 |
| `/email-preview` | `EmailPreview` | - | EmailPreview~3a12634d |
| `/senior-config` | `SeniorConfig` | - | SeniorConfig~31ecd969 |
| `/system-updata` | `systemUpdata` | - | SystemMessage~31ecd969 |
| `/` | `home` | home-page | Home~31ecd969, Home~f71cff67 |
| `/home-page` | `homePage` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, homePage~31ecd969 |
| `/app-detail` | `appDetail` | - | vendors~appDetail~appInner~c706400c, appDetail~appInner~f71cff67, appDetail~d2563bb7 |
| `/app-store` | `appStoreNew` | - | appStore~f71cff67 |
| `/app-store/app-inner` | `appInner` | - | vendors~CustomerProductInnerpage~SupportTicket~appInner~appStoreNew~myApp~690b702c, vendors~appDetail~appInner~c706400c, appDetail~appInner~f71cff67, appInner~appStoreNew~31ecd969, appInner~f71cff67 |
| `/app-store/app-leaderboard` | `appLeaderboard` | - | appLeaderboard~31ecd969 |
| `/app-store/app-list` | `appList` | - | appList~31ecd969 |
| `/app-store/my-app` | `myApp` | - | vendors~CustomerProductInnerpage~SupportTicket~appInner~appStoreNew~myApp~690b702c, myApp~31ecd969 |
| `/install-progress` | `installProgress` | - | installProgress~f71cff67 |
| `/customer-list` | `customerList` | - | CustomerList~31ecd969 |
| `/base-info` | `baseInfo` | - | BaseInfo~31ecd969 |
| `/theme-template` | `themeTemplate` | - | ThemeTemplate~f71cff67 |
| `/login-register` | `loginRegister` | - | LoginRegister~31ecd969 |
| `/order-product` | `orderProduct` | - | OrderProduct~f71cff67 |
| `/twice-confirm` | `twiceConfirm` | - | TwiceConfirm~31ecd969 |
| `/third-login` | `thirdLogin` | - | ThirdLogin~31ecd969 |
| `/customer-view` | `customerView` | - | CustomerView~f71cff67 |
| `/customer-view/abstract` | `abstract` | - | CustomerAbstract~31ecd969 |
| `/customer-view/station-letterlog` | `customerStationLetterList` | - | CustomerStationLetterList~31ecd969 |
| `/customer-view/developer` | `developer` | - | CustomerDeveloper~31ecd969 |
| `/customer-view/abstractOld` | `abstractOld` | - | CustomerAbstractOld~f71cff67 |
| `/customer-view/bill` | `bill` | - | CustomerBill~31ecd969 |
| `/customer-view/transactions` | `transactions` | - | CustomerTransactions~31ecd969 |
| `/customer-view/credit` | `credit` | - | CustomerCredit~31ecd969 |
| `/customer-view/tickets` | `tickets` | - | CustomerTickets~31ecd969 |
| `/customer-view/log` | `log` | - | CustomerLog~31ecd969 |
| `/customer-view/noticelog` | `noticelog` | - | CustomerNoticelog~31ecd969 |
| `/customer-view/annex` | `annex` | - | CustomerAnnex~31ecd969 |
| `/customer-view/smslog` | `smslog` | - | CustomerSmsLog~31ecd969 |
| `/customer-view/emaillog` | `emaillog` | - | CustomerEmailLog~31ecd969 |
| `/customer-view/person` | `person` | - | CustomerPerson~f71cff67 |
| `/customer-view/product-innerpage` | `productInnerpage` | - | vendors~CustomerProductInnerpage~SupportTicket~appInner~appStoreNew~myApp~690b702c, ConfigureEdit~CustomerProductInnerpage~MunualResource~31ecd969, CustomerProductInnerpage~31ecd969, CustomerProductInnerpage~852bc656, CustomerProductInnerpage~7d49c497 |
| `/customer-view/product-list` | `productList` | - | CustomerProductList~31ecd969 |
| `/customer-view/promotion_plan` | `promotion_plan` | - | promotionPlan~31ecd969 |
| `/customer-view/follow-status` | `FollowStatus` | - | FollowStatus~31ecd969 |
| `/customer-view/api-overview` | `CustomerApiOverview` | - | CustomerAdd~31ecd969 |
| `/set` | `Set` | customer-custom | 同步/共享组件，须人工追溯 |
| `/customer-add` | `customerAdd` | - | CustomerAdd~31ecd969 |
| `/customer-group` | `customerGroup` | - | CustomerGroup~31ecd969 |
| `/customer-custom` | `customerCustom` | - | CustomerCustom~f71cff67 |
| `/customer-product` | `customerProduct` | - | CustomerProduct~31ecd969 |
| `/customer-authentication` | `CustomerAuthentication` | - | CustomerAuthentication~31ecd969 |
| `/add-records` | `AddRecords` | - | AddRecords~31ecd969 |
| `/cancel-request` | `cancelRequest` | - | CancelRequest~f71cff67 |
| `/sales-management` | `salesManagement` | - | SalesManagement~f71cff67 |
| `/sales-statistics` | `SalesStatistics` | - | SalesStatistics~31ecd969 |
| `/customer-promotionplan` | `CustomerPromotionplan` | - | CustomerPromotionplan~31ecd969 |
| `/customer-withdrawal` | `WithdrawalAudit` | - | WithdrawalAudit~f71cff67 |
| `/customer-cancelreq` | `CustomerCancelReq` | - | CustomerCancelReq~31ecd969 |
| `/customer-resources` | `CustomerResources` | - | CustomerResources~31ecd969 |
| `/customer-level` | `CustomerLevel` | - | CustomerLevel~31ecd969 |
| `/order-list` | `orderList` | - | OrderList~31ecd969 |
| `/add-order` | `addOrder` | - | AddOrder~31ecd969 |
| `/order-detail` | `orderDetail` | - | OrderDetail~31ecd969 |
| `/renewal-order` | `renewalOrder` | - | RenewalOrder~31ecd969 |
| `/supplier-renewal-order` | `supplierRenewalOrder` | - | RenewalOrder~31ecd969 |
| `/business-statement` | `businessStatement` | - | BusinessStatement~31ecd969 |
| `/bill-management` | `billManagement` | - | BillManagement~31ecd969 |
| `/bill-detail` | `billDetail` | - | BillDetail~31ecd969 |
| `/preset-reply` | `presetReply` | - | PresetReply~31ecd969 |
| `/addedit-pre-reply` | `addeditPreReply` | - | AddeditPreReply~f71cff67 |
| `/support-ticket` | `supportTicket` | - | vendors~CustomerProductInnerpage~SupportTicket~appInner~appStoreNew~myApp~690b702c, SupportTicket~31ecd969 |
| `/add-support-ticket` | `addSupportTicket` | - | AddSupportTicket~f71cff67 |
| `/support-ticket-detail` | `supportTicketDetail` | - | SupportTicketDetail~31ecd969 |
| `/support-statistics` | `SupportStatistics` | - | SupportStatistics~31ecd969 |
| `/news-list` | `newsList` | - | NewsList~f71cff67 |
| `/add-news` | `addNews` | - | AddNews~31ecd969 |
| `/news-category` | `newsCategory` | - | NewsCategory~31ecd969 |
| `/help-list` | `helpList` | - | HelpList~f71cff67 |
| `/add-help` | `addHelp` | - | AddHelp~31ecd969 |
| `/help-category` | `helpCategory` | - | HelpCategory~31ecd969 |
| `/custom-template-fields` | `customTemplateFields` | - | CustomTemplateFields~f71cff67 |
| `/add-custom-template-fields` | `addCustomTemplateFields` | - | AddCustomTemplateFields~f71cff67 |
| `/sms-template` | `smsTemplate` | - | SmsTemplate~50ce0b08 |
| `/sms-template/sms` | `sms` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, SmsTemplateI~31ecd969 |
| `/sms-template/email` | `email` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, Email~31ecd969 |
| `/sms-template-index` | `smsTemplateIndex` | - | SmsTemplateIndex~31ecd969 |
| `/sms-create-template` | `smsCreateTemplate` | - | SmsCreateTemplate~31ecd969 |
| `/sms-send-settings` | `smsSendSettings` | - | SmsSendSettings~31ecd969 |
| `/system-log` | `systemLog` | - | SystemLog~31ecd969 |
| `/station-letter-log` | `StationLetterLog` | - | StationLetterLog~31ecd969 |
| `/system-admin-log` | `systemAdminLog` | - | SystemAdminLog~31ecd969 |
| `/inform-log` | `informLog` | - | InformLog~31ecd969 |
| `/email-log` | `emailLog` | - | EmailLog~31ecd969 |
| `/sms-log` | `smsLog` | - | SmsLog~31ecd969 |
| `/api-log` | `ApiLog` | - | ApiLog~31ecd969 |
| `/log-cleanup` | `LogCleanup` | - | LogCleanup~f71cff67 |
| `/automatic-task-log` | `automaticTaskLog` | - | automaticTaskLog~31ecd969 |
| `/system-message` | `systemMessage` | - | SystemMessage~31ecd969 |
| `/php-message` | `phpMessage` | - | PhpMessage~f71cff67 |
| `/database-message` | `databaseMessage` | - | vendors~DatabaseMessage~987e6011, DatabaseMessage~f71cff67 |
| `/data-migration` | `DataMigration` | - | DataMigration~f71cff67 |
| `/about` | `about` | - | About~f71cff67 |
| `/general-settings` | `generalSettings` | - | generalSettings~1afc0759 |
| `/general-settings/general` | `general` | - | General~31ecd969 |
| `/general-settings/local` | `local` | - | Local~f71cff67 |
| `/general-settings/support` | `support` | - | Support~f71cff67 |
| `/general-settings/promote` | `promote` | - | Promote~f71cff67 |
| `/general-settings/safe` | `safe` | - | Safe~f71cff67 |
| `/general-settings/other` | `other` | - | Other~f71cff67 |
| `/general-settings/invoice` | `invoice` | - | Invoice~f71cff67 |
| `/general-settings/login-setting` | `loginSetting` | - | LoginPage~31ecd969 |
| `/general-settings/captcha` | `captcha` | - | Captcha~f71cff67 |
| `/general-settings/finance` | `finance` | - | Finance~f71cff67 |
| `/general-settings/order` | `OrderGoods` | - | OrderGoods~31ecd969 |
| `/general-settings/class` | `class` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, Class~31ecd969 |
| `/general-settings/source-api` | `sourceApi` | - | SourceApi~f71cff67 |
| `/second` | `second` | - | Second~31ecd969 |
| `/voucher-setting` | `InvoiceSetting` | - | InvoiceSetting~31ecd969 |
| `/invoice-audit` | `InvoiceAudit` | - | InvoiceAudit~31ecd969 |
| `/admin-management` | `adminManagement` | - | AdminManagement~f71cff67 |
| `/admin-edit` | `adminEdit` | - | AdminEdit~31ecd969 |
| `/black-list` | `blackList` | - | blackList~f71cff67 |
| `/email-list` | `emailList` | - | EmailList~31ecd969 |
| `/email-edit` | `emailEdit` | - | EmailEdit~31ecd969 |
| `/currency-settings` | `currencySettings` | - | CurrencySettings~31ecd969 |
| `/permissions-managment` | `permissionsManagment` | - | PermissionsManagment~f71cff67 |
| `/permissions-edit` | `permissionsEdit` | - | PermissionsEdit~31ecd969 |
| `/automatic-tasks` | `automaticTasks` | - | TimingResults~31ecd969, AutomaticTasks~3dfaf398 |
| `/timing-results` | `timingResults` | - | TimingResults~31ecd969 |
| `/promotion_plan` | `PromotionPlan` | - | PromotionPlan~f71cff67 |
| `/module-plugin` | `modulePlugin` | - | ModulePlugin~f71cff67 |
| `/authentication-setting` | `authenticationSetting` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, authenticationSetting~31ecd969 |
| `/payment-interface` | `paymentInterface` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, PaymentInterface~f71cff67 |
| `/promo-code` | `promoCode` | - | PromoCode~31ecd969 |
| `/promo-code-add` | `promoCodeAdd` | - | PromoCodeAdd~31ecd969 |
| `/work-order-dept` | `workOrderDept` | - | WorkOrderDept~f71cff67 |
| `/new-work-order-dept` | `newWorkOrderDept` | - | NewWorkOrderDept~31ecd969 |
| `/add-custom-fields` | `addCustomFields` | - | AddCustomFields~f71cff67 |
| `/work-order-status` | `workOrderStatus` | - | WorkOrderStatus~f71cff67 |
| `/work-order-rules` | `WorkOrderRules` | - | WorkOrderRules~31ecd969 |
| `/product-server` | `productServer` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, ProductServer~31ecd969 |
| `/add-product-group` | `addProductGroup` | - | AddProductGroup~f71cff67 |
| `/edit-product` | `editProduct` | - | EditProduct~31ecd969, EditProduct~ca2dc83e, EditProduct~3b812b8f |
| `/configurable-option` | `configurableOption` | - | ConfigurableOption~31ecd969 |
| `/edit-configurable-option-group` | `editConfigurableOptionGroup` | - | EditConfigurableOptionGroup~31ecd969 |
| `/server-settings` | `serverSettings` | - | ServerSettings~31ecd969 |
| `/add-server` | `addServer` | - | AddServer~31ecd969 |
| `/group-list` | `groupList` | - | GroupList~f71cff67 |
| `/add-group` | `addGroup` | - | AddGroup~31ecd969 |
| `/add-interface` | `addInterface` | - | AddInterface~31ecd969 |
| `/dcim` | `dcim` | - | DcimServer~31ecd969 |
| `/dcim-view` | `dcimView` | - | DcimServerView~f71cff67 |
| `/dcim-traffic` | `dcimTraffic` | - | DcimTraffic~31ecd969 |
| `/dcim-traffic-log` | `dcimLog` | - | DcimLog~31ecd969 |
| `/dcim-product` | `productManagement` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, ProductManagement~f71cff67 |
| `/zjmfcloud` | `zjmfcloud` | - | CloudServer~31ecd969 |
| `/zjmfcloud-product` | `zjmfcloudProduct` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, DCloudProduct~31ecd969 |
| `/munual-resource` | `munualResource` | - | ConfigureEdit~CustomerProductInnerpage~MunualResource~31ecd969, MunualResource~e74b0f58 |
| `/upStream-edit` | `upStreamEdit` | - | UpStreamEdit~31ecd969 |
| `/addOrEdit-resource` | `addOrEditResource` | - | AddOrEditResource~31ecd969 |
| `/task-queue` | `TaskQueue` | - | TaskQueue~31ecd969 |
| `/configure-edit` | `ConfigureEdit` | - | ConfigureEdit~CustomerProductInnerpage~MunualResource~31ecd969, ConfigureEdit~taskQueue~31ecd969, MunualResource~e74b0f58, ConfigureEdit~commodityList~31ecd969, ConfigureEdit~f71cff67 |
| `/api-setup` | `ApiSetUp` | - | ApiSetUp~f71cff67 |
| `/statistics-taskQueue` | `statisticstaskQueue` | - | statisticstaskQueue~31ecd969 |
| `/commodity-list` | `commodityList` | - | ConfigureEdit~commodityList~31ecd969, commodityList~31ecd969 |
| `/commodity-product` | `commodityProduct` | - | productList~31ecd969 |
| `/commodity-taskQueue` | `commodityTaskQueue` | - | ConfigureEdit~taskQueue~31ecd969, taskQueue~31ecd969 |
| `/add-supplier` | `addSupplier` | - | addSupplier~f71cff67 |
| `/supplier-order-list` | `supplierOrderList` | - | ConfigureEdit~taskQueue~31ecd969, taskQueue~31ecd969 |
| `/zjmf-api` | `ZjmfApi` | - | ZjmfApi~31ecd969 |
| `/official-setting` | `OfficialSetting` | - | OfficialSetting~f71cff67 |
| `/menu_manage` | `MenuManage` | - | MenuManage~31ecd969 |
| `/create_menu` | `CreateMenu` | - | vendors~CreateMenu~knowledgeBase~253ae210, CreateMenu~31ecd969 |
| `/create_menu_www` | `CreateMenuWww` | - | CreateMenuWww~31ecd969 |
| `/friendly_link` | `Friendlylink` | - | MenuManage~31ecd969 |
| `/marketing-push` | `MarketingPush` | - | MarketingPush~31ecd969 |
| `/message-write` | `MessageWrite` | - | MessageWrite~31ecd969 |
| `/annual-statistics` | `AnnualStatistics` | - | AnnualStatistics~31ecd969 |
| `/service-support` | `ServiceSupport` | - | ServiceSupport~f71cff67 |
| `/file` | `File` | - | File~31ecd969 |
| `/new-customer` | `NewCustomer` | - | NewCustomer~f71cff67 |
| `/product-revenue` | `ProductRevenue` | - | ProductRevenue~f71cff67 |
| `/revenue-ranking` | `RevenueRanking` | - | RevenueRanking~f71cff67 |
| `/edit-person` | `EditPerson` | - | EditPerson~31ecd969 |
| `/customer-developer` | `customerDeveloperList` | - | customerDeveloperList~31ecd969 |
| `/application-list` | `applicationList` | - | appCheckList~31ecd969 |
| `/application-detail` | `applicationDetail` | - | applicationDetail~f71cff67 |
| `/appcheck-list` | `appCheckList` | - | appCheckList~31ecd969 |
| `/comment-list` | `commentList` | - | commentList~31ecd969 |
| `/hot-app` | `hotApp` | - | hotApp~31ecd969 |
| `/highly-recommended` | `highlyRecommended` | - | highlyRecommended~31ecd969 |
| `/dcim-authorization` | `DcimAuthorization` | - | dcim~31ecd969 |
| `/dcim-authorization-disable` | `DcimAuthorizationDisable` | - | dcim~31ecd969 |
| `/dcim-authorization-error` | `DcimAuthorizationErrorLog` | - | dcim~31ecd969 |
| `/dcim-debug-log` | `DcimDebugErrorLog` | - | dcim~31ecd969 |
| `/dcim-authorization-update` | `DcimAuthorizationUpdate` | - | dcim~31ecd969 |
| `/resource-pool` | `ResourceRool` | - | ResourceRool~31ecd969 |
| `/credit-management` | `CreditManagement` | - | CreditManagement~31ecd969 |
| `/credit-setting` | `CreditSrtting` | - | CreditSetting~f71cff67 |
| `/notify_list` | `notifyList` | - | ResourceRool~31ecd969 |
| `/Instruction_query` | `InstructionQuery` | - | ResourceRool~31ecd969 |
| `/auto_reply_setting` | `AutoReplySetting` | - | ResourceRool~31ecd969 |
| `/functional-module` | `FunctionalModule` | - | ResourceRool~31ecd969 |
| `/add_functional_module` | `AddFunctionalModule` | - | ResourceRool~31ecd969 |
| `/keyword-manage` | `KeyWords` | - | ResourceRool~31ecd969 |
| `/special-reply` | `SpecialReply` | - | ResourceRool~31ecd969 |
| `/add_keywords` | `AddKeywords` | - | ResourceRool~31ecd969 |
| `/cate-management` | `cateManagement` | - | cateManagement~f71cff67 |
| `/knowledge-base` | `knowledgeBase` | - | vendors~CreateMenu~knowledgeBase~253ae210, knowledgeBase~f71cff67 |
| `/plug-management` | `PlugManagement` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, DCloudProduct~31ecd969 |
| `/plug-management/plug-export` | `plugExport` | - | vendors~Class~DCloudProduct~EditConfigurableOption1~Email~PaymentInterface~ProductManagement~Product~647dbc3e, DCloudProduct~31ecd969 |
| `/contracts_audit` | `contractsAudit` | - | ConfigureEdit~taskQueue~31ecd969, taskQueue~31ecd969 |
| `/contracts_setting` | `contractsSetting` | - | ConfigureEdit~taskQueue~31ecd969, taskQueue~31ecd969 |
| `/add_contract` | `addContract` | - | ConfigureEdit~taskQueue~31ecd969, taskQueue~31ecd969 |
| `/order-management-list` | `orderManagementList` | - | orderManagementList~31ecd969 |
| `/refund-detail` | `refundDetail` | - | refundDetail~f71cff67 |
| `/aftersale-detail` | `aftersaleDetail` | - | refundDetail~f71cff67 |
| `/business-management` | `businessManagement` | - | businessManagement~31ecd969 |
| `/resourcePool-taskQueue` | `resourcePoolTaskQueue` | - | resourcePoolTaskQueue~31ecd969 |
| `/resourcePool-workOrder` | `resourcePoolWorkOrder` | - | resourcePoolWorkOrder~31ecd969 |
| `/resourcePool-set` | `resourcePoolSet` | - | resourcePoolSet~f71cff67 |
| `/statistical-information` | `statisticalInformation` | - | statisticalInformation~31ecd969 |
| `/commodity-management` | `commodityManagement` | - | commodityManagement~31ecd969 |
| `/ssistant-audit` | `ssistantAudit` | - | ssistantAudit~31ecd969 |
| `/assist-apply` | `assistApply` | - | assistApply~f71cff67 |
| `/assist-detail` | `assistDetail` | - | assistDetail~f71cff67 |
| `/resource-pool-shop` | `resourcePoolShop` | - | resourcePoolShop~f71cff67 |
| `/resourcePool-logs` | `journalManagement` | - | journalManagement~f71cff67 |

## PHP 页面到业务控制器的直接调用

这里只提取方法体中的 controller() 直接调用。它不是完整调用图：ViewModel、tagdata、逻辑层、资源接口和前端请求另行核对。“占位”仅指视图方法，不代表业务接口缺失。

| 页面与方法 | 视图源码 | 直接调用及匹配的路由 |
| --- | --- | --- |
| GET `{A}/index` | [app/admin/controller/ViewAdminController.php:7](../../app/admin/controller/ViewAdminController.php#L7) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/plugins` | [app/admin/controller/ViewPluginsController.php:8](../../app/admin/controller/ViewPluginsController.php#L8) | Plugin/plIndex: GET {A}/pl_index/[:moduleName]/ |
| GET `{A}/clients` | [app/admin/controller/ViewClientsController.php:18](../../app/admin/controller/ViewClientsController.php#L18) | UserManage/clientList: RULE {A}/client_list |
| GET `{A}/clientsauthentication` | [app/admin/controller/ViewClientsController.php:41](../../app/admin/controller/ViewClientsController.php#L41) | UserManage/cerifyLogList: GET {A}/cerify_log_list |
| GET `{A}/clientsresources` | [app/admin/controller/ViewClientsController.php:63](../../app/admin/controller/ViewClientsController.php#L63) | common/saleList: GET {A}/common/sale_list; UserManage/clientListRe: GET {A}/client_list_resource |
| GET `{A}/resourcepool` | [app/admin/controller/ViewClientsController.php:86](../../app/admin/controller/ViewClientsController.php#L86) | UserManage/clientList: RULE {A}/client_list |
| GET `{A}/salesstatistics` | [app/admin/controller/ViewClientsController.php:109](../../app/admin/controller/ViewClientsController.php#L109) | sale/saleUsers: GET {A}/sale/sale_users; sale/getTimetype: ANY {A}/sale/get_timetype; sale/saleStatistics: GET {A}/sale/sale_statistics; sale/saleRecordsNew: ANY {A}/sale/sale_records |
| GET `{A}/affiliates` | [app/admin/controller/ViewClientsController.php:144](../../app/admin/controller/ViewClientsController.php#L144) | affiliate/index: GET {A}/aff |
| GET `{A}/massmailsms` | [app/admin/controller/ViewClientsController.php:162](../../app/admin/controller/ViewClientsController.php#L162) | sendMessageBatch/getSearchParams: GET {A}/sm_type; common/common: GET {A}/common |
| GET `{A}/configclientgroups` | [app/admin/controller/ViewClientsController.php:187](../../app/admin/controller/ViewClientsController.php#L187) | ClientGroup/index: 无显式路由匹配，继续追溯; product/groupList: GET {A}/product/productgroup |
| GET `{A}/configauthentication` | [app/admin/controller/ViewClientsController.php:220](../../app/admin/controller/ViewClientsController.php#L220) | config_certifi/detail: GET {A}/certifi_alipay_detail; config_certifi/alipay_three_type: GET {A}/certifi_three_type; config_certifi/types: GET {A}/certifi_types; config_certifi/type: GET {A}/certifi_type; config_certifi/alipay_biz_code: GET {A}/certifi_alipay_biz_code |
| GET `{A}/configclientscustomfields` | [app/admin/controller/ViewClientsController.php:247](../../app/admin/controller/ViewClientsController.php#L247) | set/getCustomFields: GET {A}/custom_fields |
| GET `{A}/configaffiliates` | [app/admin/controller/ViewClientsController.php:262](../../app/admin/controller/ViewClientsController.php#L262) | config_general/getAffiliate: GET {A}/config_general/affiliate, GET {A}/config_general/Affiliate |
| GET `{A}/configclientslevel` | [app/admin/controller/ViewClientsController.php:276](../../app/admin/controller/ViewClientsController.php#L276) | UserLevel/getList: GET {A}/user_level/List |
| GET `{A}/clientssummary` | [app/admin/controller/ViewClientsController.php:296](../../app/admin/controller/ViewClientsController.php#L296) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/clientsprofile` | [app/admin/controller/ViewClientsController.php:313](../../app/admin/controller/ViewClientsController.php#L313) | common/getGetways: GET {A}/common/get_getways; common/getClientGroups: GET {A}/common/get_client_groups; common/getSmsCountry: GET {A}/common/get_sms_country; UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/clientsservices` | [app/admin/controller/ViewClientsController.php:351](../../app/admin/controller/ViewClientsController.php#L351) | UserManage/hostByUid: GET {A}/hostbyuid |
| GET `{A}/clientsinvoices` | [app/admin/controller/ViewClientsController.php:378](../../app/admin/controller/ViewClientsController.php#L378) | invoice/searchPage: GET {A}/invoice/search_page; UserManage/userInvoice: GET {A}/user_invoice |
| GET `{A}/clientstransactions` | [app/admin/controller/ViewClientsController.php:420](../../app/admin/controller/ViewClientsController.php#L420) | account/index: GET {A}/accounts; account/create: GET {A}/accounts/create |
| GET `{A}/clientscredit` | [app/admin/controller/ViewClientsController.php:455](../../app/admin/controller/ViewClientsController.php#L455) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/clientssupporttickets` | [app/admin/controller/ViewClientsController.php:472](../../app/admin/controller/ViewClientsController.php#L472) | ticket/getClientTicketPage: GET {A}/client_ticket |
| GET `{A}/clientslog` | [app/admin/controller/ViewClientsController.php:501](../../app/admin/controller/ViewClientsController.php#L501) | UserManage/logRecord: GET {A}/log_record |
| GET `{A}/clientsnoticelog` | [app/admin/controller/ViewClientsController.php:522](../../app/admin/controller/ViewClientsController.php#L522) | logRecord/getSmsLog: GET {A}/log_record/smslog; logRecord/getEmailLog: GET {A}/log_record/emaillog; logRecord/getSystemMessageLog: GET {A}/log_record/system_message_log |
| GET `{A}/clientsattach` | [app/admin/controller/ViewClientsController.php:565](../../app/admin/controller/ViewClientsController.php#L565) | Downloads/getUserDownList: GET {A}/downloads/userdownlist, GET {A}/downloads/UserDownList |
| GET `{A}/clientsaffiliate` | [app/admin/controller/ViewClientsController.php:592](../../app/admin/controller/ViewClientsController.php#L592) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/clientscrm` | [app/admin/controller/ViewClientsController.php:609](../../app/admin/controller/ViewClientsController.php#L609) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/clientsviewservices` | [app/admin/controller/ViewClientsController.php:626](../../app/admin/controller/ViewClientsController.php#L626) | common/getProductList: GET {A}/common/get_product_list; common/getPromoCode: GET {A}/common/get_promo_code; common/getGetways: GET {A}/common/get_getways; common/getHostList: GET {A}/common/host_list; ClientsServices/index: GET {A}/clients_services |
| GET `{A}/clientssupportticketdetail` | [app/admin/controller/ViewClientsController.php:648](../../app/admin/controller/ViewClientsController.php#L648) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/viewinvoices` | [app/admin/controller/ViewClientsController.php:665](../../app/admin/controller/ViewClientsController.php#L665) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/ordersadd` | [app/admin/controller/ViewClientsController.php:682](../../app/admin/controller/ViewClientsController.php#L682) | common/getGetways: GET {A}/common/get_getways; common/getPromoCode: GET {A}/common/get_promo_code; common/getProductList: GET {A}/common/get_product_list; order/getClients: GET {A}/order/getclients; UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/createsupporttickets` | [app/admin/controller/ViewClientsController.php:709](../../app/admin/controller/ViewClientsController.php#L709) | ticket/createPage: GET {A}/add_ticket_page; order/getClients: GET {A}/order/getclients |
| GET `{A}/clientsviewemail` | [app/admin/controller/ViewClientsController.php:731](../../app/admin/controller/ViewClientsController.php#L731) | UserManage/profile: GET {A}/profile/:client_id |
| GET `{A}/orders` | [app/admin/controller/ViewBusinessController.php:15](../../app/admin/controller/ViewBusinessController.php#L15) | order/searchPage: GET {A}/order/search_page; order/index: GET {A}/order/search; order/indexPost: POST {A}/order/order_commission |
| GET `{A}/orderdetail` | [app/admin/controller/ViewBusinessController.php:322](../../app/admin/controller/ViewBusinessController.php#L322) | Order/read: GET {A}/orders/:id |
| GET `{A}/trafficorder` | [app/admin/controller/ViewBusinessController.php:124](../../app/admin/controller/ViewBusinessController.php#L124) | dcim/listBuyRecord: GET {A}/dcim/buy_record |
| GET `{A}/productlist` | [app/admin/controller/ViewBusinessController.php:167](../../app/admin/controller/ViewBusinessController.php#L167) | host/getTimetype: GET {A}/host/get_timetype, GET {A}/host/Timetype; host/getList: GET {A}/host/List |
| GET `{A}/cancelrequests` | [app/admin/controller/ViewBusinessController.php:275](../../app/admin/controller/ViewBusinessController.php#L275) | UserManage/requestCancelList: GET {A}/request_cancel_list |
| GET `{A}/transactions` | [app/admin/controller/ViewFinanceController.php:15](../../app/admin/controller/ViewFinanceController.php#L15) | account/searchPage: GET {A}/search_page; account/create: GET {A}/accounts/create; order/getclients: GET {A}/order/getclients; account/index: GET {A}/accounts |
| GET `{A}/invoices` | [app/admin/controller/ViewFinanceController.php:82](../../app/admin/controller/ViewFinanceController.php#L82) | invoice/searchPage: GET {A}/invoice/search_page; order/getclients: GET {A}/order/getclients; invoice/index: GET {A}/invoice/index |
| GET `{A}/withdrawdeposits` | [app/admin/controller/ViewFinanceController.php:145](../../app/admin/controller/ViewFinanceController.php#L145) | affiliate/affiwithdrawrecord: ANY {A}/aff/affiwithdraw_record |
| GET `{A}/receipt` | [app/admin/controller/ViewFinanceController.php:191](../../app/admin/controller/ViewFinanceController.php#L191) | voucher/getVoucherList: GET {A}/voucher/VoucherList |
| GET `{A}/configgateways` | [app/admin/controller/ViewFinanceController.php:238](../../app/admin/controller/ViewFinanceController.php#L238) | Plugin/plIndex: GET {A}/pl_index/[:moduleName]/ |
| GET `{A}/configpromotions` | [app/admin/controller/ViewFinanceController.php:251](../../app/admin/controller/ViewFinanceController.php#L251) | promoCode/getList: GET {A}/list_promo_code |
| GET `{A}/configpromotionsadd` | [app/admin/controller/ViewFinanceController.php:282](../../app/admin/controller/ViewFinanceController.php#L282) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/configcurrencies` | [app/admin/controller/ViewFinanceController.php:293](../../app/admin/controller/ViewFinanceController.php#L293) | currency/currencyList: GET {A}/currency/currency_list |
| GET `{A}/configfund` | [app/admin/controller/ViewFinanceController.php:307](../../app/admin/controller/ViewFinanceController.php#L307) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/configreceipt` | [app/admin/controller/ViewFinanceController.php:320](../../app/admin/controller/ViewFinanceController.php#L320) | voucher/getExpressList: GET {A}/voucher/ExpressList |
| GET `{A}/addhelp` | [app/admin/controller/ViewSystemController.php:12](../../app/admin/controller/ViewSystemController.php#L12) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/permissionsmanagment` | [app/admin/controller/ViewSystemController.php:38](../../app/admin/controller/ViewSystemController.php#L38) | Rbac/index: GET {A}/rbac; 视图占位 test；另查业务 API |
| GET `{A}/smstemplateindex` | [app/admin/controller/ViewSystemController.php:49](../../app/admin/controller/ViewSystemController.php#L49) | ConfigMessage/configMobile: GET {A}/config_message/config_mobile; ConfigMessage/templateList: GET {A}/config_message/template_list; ConfigMessage/updateTemStatus: GET {A}/config_message/update_tem_status; 视图占位 test；另查业务 API |
| GET `{A}/supportticket` | [app/admin/controller/ViewWorkorderController.php:15](../../app/admin/controller/ViewWorkorderController.php#L15) | Public/getTicketDepartment: GET {A}/getTicketDepartment; Ticket/getList: GET {A}/list_ticket |
| GET `{A}/supportstatistics` | [app/admin/controller/ViewWorkorderController.php:64](../../app/admin/controller/ViewWorkorderController.php#L64) | Ticket/ticketStatistics: GET {A}/ticket_statistics |
| GET `{A}/configticketdepartments` | [app/admin/controller/ViewWorkorderController.php:81](../../app/admin/controller/ViewWorkorderController.php#L81) | TicketDepartment/getList: GET {A}/list_ticket_department |
| GET `{A}/configticketdepartmentsadd` | [app/admin/controller/ViewWorkorderController.php:95](../../app/admin/controller/ViewWorkorderController.php#L95) | TicketDepartment/getDetail: GET {A}/list_ticket_department/:id; TicketDepartment/addPage: GET {A}/get_ticket_department; Common/getUpstreamTicketDepartmentList: GET {A}/common/get_upstream_ticket_department_list |
| GET `{A}/configticketstatuses` | [app/admin/controller/ViewWorkorderController.php:134](../../app/admin/controller/ViewWorkorderController.php#L134) | TicketStatus/getList: GET {A}/list_ticket_status |
| GET `{A}/configticketpass` | [app/admin/controller/ViewWorkorderController.php:148](../../app/admin/controller/ViewWorkorderController.php#L148) | TicketDeliver/getList: GET {A}/list_ticket_deliver |
| GET `{A}/configproducts` | [app/admin/controller/ViewGoodController.php:15](../../app/admin/controller/ViewGoodController.php#L15) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/configproductoptionsedit` | [app/admin/controller/ViewGoodController.php:25](../../app/admin/controller/ViewGoodController.php#L25) | 视图占位 test；另查业务 API |
| GET `{A}/configproductoptionsaddon` | [app/admin/controller/ViewGoodController.php:33](../../app/admin/controller/ViewGoodController.php#L33) | 视图占位 test；另查业务 API |
| GET `{A}/configtraffic` | [app/admin/controller/ViewGoodController.php:41](../../app/admin/controller/ViewGoodController.php#L41) | dcim/listFlowPacket: GET {A}/dcim/flowpacket |
| GET `{A}/configservermodule` | [app/admin/controller/ViewGoodController.php:84](../../app/admin/controller/ViewGoodController.php#L84) | 视图占位 test；另查业务 API |
| GET `{A}/configservermoduleedit` | [app/admin/controller/ViewGoodController.php:92](../../app/admin/controller/ViewGoodController.php#L92) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/configdcimmoodule` | [app/admin/controller/ViewGoodController.php:101](../../app/admin/controller/ViewGoodController.php#L101) | dcim/serverList: GET {A}/dcim/server |
| GET `{A}/configdcimmooduleedit` | [app/admin/controller/ViewGoodController.php:138](../../app/admin/controller/ViewGoodController.php#L138) | 视图占位 test；另查业务 API |
| GET `{A}/configzjmfcloud` | [app/admin/controller/ViewGoodController.php:146](../../app/admin/controller/ViewGoodController.php#L146) | dcimCloud/serverList: GET {A}/dcimcloud/server |
| GET `{A}/configproductoptions` | [app/admin/controller/ViewGoodController.php:180](../../app/admin/controller/ViewGoodController.php#L180) | ConfigOptions/groupsList: GET {A}/options/groups_list |
| GET `{A}/configproductoptionsgroup` | [app/admin/controller/ViewGoodController.php:207](../../app/admin/controller/ViewGoodController.php#L207) | 视图占位 test；另查业务 API |
| GET `{A}/configproduct` | [app/admin/controller/ViewGoodController.php:215](../../app/admin/controller/ViewGoodController.php#L215) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `{A}/annualstatistics` | [app/admin/controller/ViewStatisticsController.php:15](../../app/admin/controller/ViewStatisticsController.php#L15) | 视图占位 test；另查业务 API |
| GET `{A}/newcustomer` | [app/admin/controller/ViewStatisticsController.php:23](../../app/admin/controller/ViewStatisticsController.php#L23) | 视图占位 test；另查业务 API |
| GET `{A}/productrevenue` | [app/admin/controller/ViewStatisticsController.php:31](../../app/admin/controller/ViewStatisticsController.php#L31) | 视图占位 test；另查业务 API |
| GET `{A}/revenueranking` | [app/admin/controller/ViewStatisticsController.php:39](../../app/admin/controller/ViewStatisticsController.php#L39) | 视图占位 test；另查业务 API |
| GET `{A}/munualresource` | [app/admin/controller/ViewResourceController.php:15](../../app/admin/controller/ViewResourceController.php#L15) | upperReaches/index: ANY {A}/upper/index; upperReaches/upperIndex: ANY {A}/upper/upperindex, ANY {A}/upper/upperindex |
| GET `{A}/addOrEditresource` | [app/admin/controller/ViewResourceController.php:54](../../app/admin/controller/ViewResourceController.php#L54) | upperReaches/index: ANY {A}/upper/index; upperReaches/addupperpage: ANY {A}/upper/addupperpage |
| GET `{A}/upStreamedit` | [app/admin/controller/ViewResourceController.php:79](../../app/admin/controller/ViewResourceController.php#L79) | 视图占位 test；另查业务 API |
| GET `{A}/zjmfapi` | [app/admin/controller/ViewResourceController.php:87](../../app/admin/controller/ViewResourceController.php#L87) | 视图占位 test；另查业务 API |
| GET `/logout` | [app/home/controller/ViewClientsController.php:277](../../app/home/controller/ViewClientsController.php#L277) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| POST `/logout` | [app/home/controller/ViewClientsController.php:277](../../app/home/controller/ViewClientsController.php#L277) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/page` | [app/home/controller/ViewClientsController.php:11](../../app/home/controller/ViewClientsController.php#L11) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/login` | [app/home/controller/ViewClientsController.php:15](../../app/home/controller/ViewClientsController.php#L15) | Login/mobileLoginVerify: POST /mobile_login; Login/phonePassLogin: POST /login_pass_phone; Login/emailLogin: POST /login_pass_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index; Oauth/listing: GET /oauth |
| POST `/login` | [app/home/controller/ViewClientsController.php:15](../../app/home/controller/ViewClientsController.php#L15) | Login/mobileLoginVerify: POST /mobile_login; Login/phonePassLogin: POST /login_pass_phone; Login/emailLogin: POST /login_pass_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index; Oauth/listing: GET /oauth |
| GET `/register` | [app/home/controller/ViewClientsController.php:154](../../app/home/controller/ViewClientsController.php#L154) | Register/registerPhone: POST /register_phone; Register/registerEmail: POST /register_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index |
| POST `/register` | [app/home/controller/ViewClientsController.php:154](../../app/home/controller/ViewClientsController.php#L154) | Register/registerPhone: POST /register_phone; Register/registerEmail: POST /register_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index |
| GET `/pwreset` | [app/home/controller/ViewClientsController.php:208](../../app/home/controller/ViewClientsController.php#L208) | Register/passPhoneReset: POST /reset_phone; Register/passEmailReset: POST /reset_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index |
| POST `/pwreset` | [app/home/controller/ViewClientsController.php:208](../../app/home/controller/ViewClientsController.php#L208) | Register/passPhoneReset: POST /reset_phone; Register/passEmailReset: POST /reset_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index |
| GET `/bind` | [app/home/controller/ViewClientsController.php:244](../../app/home/controller/ViewClientsController.php#L244) | Oauth/bindLoginPhone: POST /oauth/bind_login_phone; Oauth/bindLoginEmail: POST /oauth/bind_login_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index; Oauth/callbackInfo: GET /oauth/callbackInfo |
| POST `/bind` | [app/home/controller/ViewClientsController.php:244](../../app/home/controller/ViewClientsController.php#L244) | Oauth/bindLoginPhone: POST /oauth/bind_login_phone; Oauth/bindLoginEmail: POST /oauth/bind_login_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index; Oauth/callbackInfo: GET /oauth/callbackInfo |
| GET `/details` | [app/home/controller/ViewClientsController.php:325](../../app/home/controller/ViewClientsController.php#L325) | User/update: PUT /user_info; User/getAreas: GET /get_areas |
| POST `/details` | [app/home/controller/ViewClientsController.php:325](../../app/home/controller/ViewClientsController.php#L325) | User/update: PUT /user_info; User/getAreas: GET /get_areas |
| GET `/security` | [app/home/controller/ViewClientsController.php:545](../../app/home/controller/ViewClientsController.php#L545) | OauthBind/listing: GET /oauthBind; Login/mobileLoginVerifyPage: GET /mobile_login_page |
| GET `/verified` | [app/home/controller/ViewClientsController.php:342](../../app/home/controller/ViewClientsController.php#L342) | Certification/certifi: GET /certifi; Certification/personCertifiPost: POST /person_certifi_post; Certification/companyCertifiPost: POST /company_certifi_post |
| POST `/verified` | [app/home/controller/ViewClientsController.php:342](../../app/home/controller/ViewClientsController.php#L342) | Certification/certifi: GET /certifi; Certification/personCertifiPost: POST /person_certifi_post; Certification/companyCertifiPost: POST /company_certifi_post |
| GET `/message` | [app/home/controller/ViewClientsController.php:584](../../app/home/controller/ViewClientsController.php#L584) | SystemMessage/getMessageList: GET /sys_messgage; SystemMessage/getUnreadList: GET /sys_messgage_unread |
| GET `/systemlog` | [app/home/controller/ViewClientsController.php:1134](../../app/home/controller/ViewClientsController.php#L1134) | RecordLog/getUserLogs: GET /user_logs |
| GET `/loginlog` | [app/home/controller/ViewClientsController.php:1158](../../app/home/controller/ViewClientsController.php#L1158) | User/user_action_log: GET /user_action_log/[:page]/ |
| GET `/apilog` | [app/home/controller/ViewClientsController.php:1185](../../app/home/controller/ViewClientsController.php#L1185) | ZjmfFinanceApi/apiLog: 无显式路由匹配，继续追溯 |
| GET `/billing` | [app/home/controller/ViewClientsController.php:612](../../app/home/controller/ViewClientsController.php#L612) | UserInvoice/getInvoices: GET /get_invoices; UserInvoice/getCombineInvoices: GET /get_combine_invoices |
| ANY `/combinebilling` | [app/home/controller/ViewClientsController.php:641](../../app/home/controller/ViewClientsController.php#L641) | UserInvoice/getCombineInvoices: GET /get_combine_invoices; UserInvoice/combineInvoices: POST /combine_invoices |
| GET `/viewbilling` | [app/home/controller/ViewClientsController.php:665](../../app/home/controller/ViewClientsController.php#L665) | UserInvoice/getInvoicesDetail: GET /get_invoices_detail; Pay/startPay: POST /start_pay; Pay/applyCreditLimit: POST /apply_credit_limit; Pay/useCreditPage: GET /use_credit_page |
| GET `/transaction` | [app/home/controller/ViewClientsController.php:782](../../app/home/controller/ViewClientsController.php#L782) | UserInvoice/accountsRecord: GET /accounts_record; UserInvoice/creditRecord: GET /credit_record; CreditLimit/list: GET /credit_limit/list; UserInvoice/rechargeRecord: GET /recharge_record; UserInvoice/refundRecord: GET /refund_record; UserInvoice/withdrawRecord: GET /withdraw_record |
| GET `/invoicelist` | [app/home/controller/ViewClientsController.php:1212](../../app/home/controller/ViewClientsController.php#L1212) | Voucher/postIssueVoucher: POST /voucher/IssueVoucher; Voucher/getCurrency: GET /voucher/Currency; Voucher/getVoucherDetail: GET /voucher/VoucherDetail; Voucher/getVoucherRequest: GET /voucher/VoucherRequest; Voucher/getIssueVoucher: GET /voucher/IssueVoucher; Voucher/getVoucherList: GET /voucher/VoucherList |
| POST `/invoicelist` | [app/home/controller/ViewClientsController.php:1212](../../app/home/controller/ViewClientsController.php#L1212) | Voucher/postIssueVoucher: POST /voucher/IssueVoucher; Voucher/getCurrency: GET /voucher/Currency; Voucher/getVoucherDetail: GET /voucher/VoucherDetail; Voucher/getVoucherRequest: GET /voucher/VoucherRequest; Voucher/getIssueVoucher: GET /voucher/IssueVoucher; Voucher/getVoucherList: GET /voucher/VoucherList |
| GET `/invoicecompany` | [app/home/controller/ViewClientsController.php:1274](../../app/home/controller/ViewClientsController.php#L1274) | Voucher/deleteVoucherInfo: DELETE /voucher/VoucherInfo; Voucher/postVoucherInfo: POST /voucher/VoucherInfo; Voucher/getVoucherInfo: GET /voucher/VoucherInfo; Voucher/getVoucherInfoList: GET /voucher/VoucherInfoList |
| POST `/invoicecompany` | [app/home/controller/ViewClientsController.php:1274](../../app/home/controller/ViewClientsController.php#L1274) | Voucher/deleteVoucherInfo: DELETE /voucher/VoucherInfo; Voucher/postVoucherInfo: POST /voucher/VoucherInfo; Voucher/getVoucherInfo: GET /voucher/VoucherInfo; Voucher/getVoucherInfoList: GET /voucher/VoucherInfoList |
| GET `/invoiceaddress` | [app/home/controller/ViewClientsController.php:1321](../../app/home/controller/ViewClientsController.php#L1321) | Voucher/deleteVoucherPost: DELETE /voucher/VoucherPost; Voucher/postVoucherPost: POST /voucher/VoucherPost; Voucher/getVoucherPost: GET /voucher/VoucherPost; Voucher/getAreaList: GET /voucher/AreaList; Voucher/getVoucherPostList: GET /voucher/VoucherPostList |
| POST `/invoiceaddress` | [app/home/controller/ViewClientsController.php:1321](../../app/home/controller/ViewClientsController.php#L1321) | Voucher/deleteVoucherPost: DELETE /voucher/VoucherPost; Voucher/postVoucherPost: POST /voucher/VoucherPost; Voucher/getVoucherPost: GET /voucher/VoucherPost; Voucher/getAreaList: GET /voucher/AreaList; Voucher/getVoucherPostList: GET /voucher/VoucherPostList |
| GET `/addfunds` | [app/home/controller/ViewClientsController.php:603](../../app/home/controller/ViewClientsController.php#L603) | Pay/rechargePage: GET /recharge_page |
| GET `/supporttickets` | [app/home/controller/ViewClientsController.php:946](../../app/home/controller/ViewClientsController.php#L946) | Ticket/getList: GET /ticket/list |
| GET `/submitticket` | [app/home/controller/ViewClientsController.php:993](../../app/home/controller/ViewClientsController.php#L993) | Ticket/createTicket: POST /ticket/create; Ticket/getOpenTicketPage: GET /ticket/ticket_page; Ticket/getDepartmentList: GET /ticket/department |
| GET `/viewticket` | [app/home/controller/ViewClientsController.php:967](../../app/home/controller/ViewClientsController.php#L967) | Ticket/replyTicket: POST /ticket/reply; Ticket/ticketDetail: GET /ticket/detail |
| POST `/viewticket` | [app/home/controller/ViewClientsController.php:967](../../app/home/controller/ViewClientsController.php#L967) | Ticket/replyTicket: POST /ticket/reply; Ticket/ticketDetail: GET /ticket/detail |
| POST `/submitticket` | [app/home/controller/ViewClientsController.php:993](../../app/home/controller/ViewClientsController.php#L993) | Ticket/createTicket: POST /ticket/create; Ticket/getOpenTicketPage: GET /ticket/ticket_page; Ticket/getDepartmentList: GET /ticket/department |
| GET `/affiliates` | [app/home/controller/ViewClientsController.php:1031](../../app/home/controller/ViewClientsController.php#L1031) | UserAffiliate/affpage: GET /affpage; UserAffiliate/affindex: GET /affindex; UserAffiliate/affbuyrecord: ANY /affbuyrecord; UserAffiliate/withdrawrecord: ANY /withdrawrecord; UserAffiliate/useraffilist: GET /useraffi_list |
| GET `/apps` | [app/home/controller/ViewClientsController.php:1372](../../app/home/controller/ViewClientsController.php#L1372) | Developer/deleteDeveloperApp: 无显式路由匹配，继续追溯; Developer/postDeveloperApp: 无显式路由匹配，继续追溯; Developer/getDeveloperApp: 无显式路由匹配，继续追溯; Developer/getDeveloperAppList: 无显式路由匹配，继续追溯 |
| POST `/apps` | [app/home/controller/ViewClientsController.php:1372](../../app/home/controller/ViewClientsController.php#L1372) | Developer/deleteDeveloperApp: 无显式路由匹配，继续追溯; Developer/postDeveloperApp: 无显式路由匹配，继续追溯; Developer/getDeveloperApp: 无显式路由匹配，继续追溯; Developer/getDeveloperAppList: 无显式路由匹配，继续追溯 |
| GET `/appincome` | [app/home/controller/ViewClientsController.php:1418](../../app/home/controller/ViewClientsController.php#L1418) | Developer/getDeveloperAppIncome: 无显式路由匹配，继续追溯 |
| GET `/apptransaction` | [app/home/controller/ViewClientsController.php:1427](../../app/home/controller/ViewClientsController.php#L1427) | Developer/getAppAccounts: 无显式路由匹配，继续追溯 |
| GET `/applog` | [app/home/controller/ViewClientsController.php:1450](../../app/home/controller/ViewClientsController.php#L1450) | Developer/getDeveloperAppLogs: 无显式路由匹配，继续追溯 |
| GET `/clientarea` | [app/home/controller/ViewClientsController.php:283](../../app/home/controller/ViewClientsController.php#L283) | Index/index: GET /index; Host/getList: GET /host/List |
| GET `/service` | [app/home/controller/ViewClientsController.php:1583](../../app/home/controller/ViewClientsController.php#L1583) | Host/getList: GET /host/List |
| GET `/servicedetail` | [app/home/controller/ViewClientsController.php:1651](../../app/home/controller/ViewClientsController.php#L1651) | Host/getHeader: GET /host/Header; Host/postCancel: POST /host/Cancel; Host/deleteCancel: DELETE /host/Cancel; Upgrade/upgradeProductPost: POST /upgrade/upgrade_product_post; Upgrade/getUpgradeProductPage: GET /upgrade/upgrade_product_page; Upgrade/addPromoToProduct: POST /upgrade/add_promo_code_product; Upgrade/RemovePromoFromProduct: POST /upgrade/remove_promo_code_product; Host/postRenew: POST /host/Renew; Upgrade/upgradeConfigPost: POST /upgrade/upgrade_config_post; Upgrade/getUpgradeConfigPage: GET /upgrade/upgrade_config_page; Upgrade/addPromoCodeToConfig: POST /upgrade/add_promo_code; Upgrade/removePromoCodeFromConfig: POST /upgrade/remove_promo_code; RecordLog/getUserLogDcs: ANY /user_logdcims; Host/getHostRecharge: GET /host/HostRecharge; Upgrade/upgradeProduct: GET /upgrade/upgrade_product/:hid; Upgrade/index: GET /upgrade/index/:hid; Host/getRenewPageView: GET /host/RenewPageView; Host/getCancel: GET /host/Cancel; Host/getRenewPage: GET /host/RenewPage; User/getSecondVerifyPage: GET /second_verify_page |
| POST `/servicedetail` | [app/home/controller/ViewClientsController.php:1651](../../app/home/controller/ViewClientsController.php#L1651) | Host/getHeader: GET /host/Header; Host/postCancel: POST /host/Cancel; Host/deleteCancel: DELETE /host/Cancel; Upgrade/upgradeProductPost: POST /upgrade/upgrade_product_post; Upgrade/getUpgradeProductPage: GET /upgrade/upgrade_product_page; Upgrade/addPromoToProduct: POST /upgrade/add_promo_code_product; Upgrade/RemovePromoFromProduct: POST /upgrade/remove_promo_code_product; Host/postRenew: POST /host/Renew; Upgrade/upgradeConfigPost: POST /upgrade/upgrade_config_post; Upgrade/getUpgradeConfigPage: GET /upgrade/upgrade_config_page; Upgrade/addPromoCodeToConfig: POST /upgrade/add_promo_code; Upgrade/removePromoCodeFromConfig: POST /upgrade/remove_promo_code; RecordLog/getUserLogDcs: ANY /user_logdcims; Host/getHostRecharge: GET /host/HostRecharge; Upgrade/upgradeProduct: GET /upgrade/upgrade_product/:hid; Upgrade/index: GET /upgrade/index/:hid; Host/getRenewPageView: GET /host/RenewPageView; Host/getCancel: GET /host/Cancel; Host/getRenewPage: GET /host/RenewPage; User/getSecondVerifyPage: GET /second_verify_page |
| ANY `/mulitrenew` | [app/home/controller/ViewClientsController.php:1903](../../app/home/controller/ViewClientsController.php#L1903) | Host/postBatchRenewPage: POST /host/BatchRenewPage; Host/postBatchRenew: POST /host/BatchRenew |
| POST `/pay` | [app/home/controller/ViewClientsController.php:1925](../../app/home/controller/ViewClientsController.php#L1925) | Pay/recharge: POST /recharge; Pay/startPay: POST /start_pay; Pay/invoicesidCreateTmp: 无显式路由匹配，继续追溯; UserInvoice/getInvoicesDetail: GET /get_invoices_detail; Pay/applyCreditLimit: POST /apply_credit_limit; Pay/invoicesidTmp: 无显式路由匹配，继续追溯; Pay/useCreditPage: GET /use_credit_page; Pay/applyCredit: POST /apply_credit |
| GET `/verify` | [app/home/controller/ViewClientsController.php:2281](../../app/home/controller/ViewClientsController.php#L2281) | Login/verify: GET /verify |
| GET `/news` | [app/home/controller/ViewClientsController.php:846](../../app/home/controller/ViewClientsController.php#L846) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/newslist` | 未定位 | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/newsview` | [app/home/controller/ViewClientsController.php:885](../../app/home/controller/ViewClientsController.php#L885) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/knowledgebase` | [app/home/controller/ViewClientsController.php:896](../../app/home/controller/ViewClientsController.php#L896) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/knowledgebase/:alias` | [app/home/controller/ViewClientsController.php:896](../../app/home/controller/ViewClientsController.php#L896) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/knowledgebaselist` | 未定位 | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/knowledgebaseview` | [app/home/controller/ViewClientsController.php:935](../../app/home/controller/ViewClientsController.php#L935) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/downloads` | [app/home/controller/ViewClientsController.php:1091](../../app/home/controller/ViewClientsController.php#L1091) | Down/productFile: GET /download/product_file; Down/cates: GET /download/cates |
| GET `/creditlimit` | 未定位 | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/apimanage` | [app/home/controller/ViewClientsController.php:2294](../../app/home/controller/ViewClientsController.php#L2294) | ZjmfFinanceApi/summary: GET /zjmf_finance_api/summary |
| GET `/contracthost` | [app/home/controller/ViewClientsController.php:2321](../../app/home/controller/ViewClientsController.php#L2321) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/contract` | [app/home/controller/ViewClientsController.php:2339](../../app/home/controller/ViewClientsController.php#L2339) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/authorDown` | [app/home/controller/ViewClientsController.php:533](../../app/home/controller/ViewClientsController.php#L533) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/cart` | [app/home/controller/ViewCartController.php:12](../../app/home/controller/ViewCartController.php#L12) | cart/getShopDataPage: GET /cart/get_shop_data; cart/globalSearch: GET /cart/global_search |
| POST `/cart` | [app/home/controller/ViewCartController.php:12](../../app/home/controller/ViewCartController.php#L12) | cart/getShopDataPage: GET /cart/get_shop_data; cart/globalSearch: GET /cart/global_search |
| ANY `/store/:alias` | [app/home/controller/ViewCartController.php:12](../../app/home/controller/ViewCartController.php#L12) | cart/getShopDataPage: GET /cart/get_shop_data; cart/globalSearch: GET /cart/global_search |
| ANY `/buy/:alias` | [app/home/controller/ViewCartController.php:12](../../app/home/controller/ViewCartController.php#L12) | cart/getShopDataPage: GET /cart/get_shop_data; cart/globalSearch: GET /cart/global_search |
| GET `/credit` | [app/home/controller/ViewClientsController.php:1475](../../app/home/controller/ViewClientsController.php#L1475) | CreditLimit/index: GET /credit_limit; CreditLimit/userInvoice: GET /credit_limit/user_invoice |
| GET `/creditdetail` | [app/home/controller/ViewClientsController.php:1499](../../app/home/controller/ViewClientsController.php#L1499) | CreditLimit/creditLimitUsed: 无显式路由匹配，继续追溯; CreditLimit/creditLimitInvoice: GET /credit_limit/user_invoice_detail, GET /credit_limit/user_invoice_detail; Pay/startPay: POST /start_pay; Pay/useCreditPage: GET /use_credit_page |
| GET `/getLinkAgeList` | [app/home/controller/ViewCartController.php:647](../../app/home/controller/ViewCartController.php#L647) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/` | [app/home/controller/ViewController.php:13](../../app/home/controller/ViewController.php#L13) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/[:html]` | [app/home/controller/ViewController.php:13](../../app/home/controller/ViewController.php#L13) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/[:html]/[:html2]` | [app/home/controller/ViewController.php:13](../../app/home/controller/ViewController.php#L13) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| GET `/[:html]/[:html2]/[:html3]` | [app/home/controller/ViewController.php:13](../../app/home/controller/ViewController.php#L13) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| ANY `/product_divert/pushserver` | [app/home/controller/ViewProductDivertController.php:18](../../app/home/controller/ViewProductDivertController.php#L18) | ProductDivert/divertInvoice: 无显式路由匹配，继续追溯 |
| GET `/product_divert/pushpulllist` | [app/home/controller/ViewProductDivertController.php:88](../../app/home/controller/ViewProductDivertController.php#L88) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| ANY `/product_divert/pullserver` | [app/home/controller/ViewProductDivertController.php:111](../../app/home/controller/ViewProductDivertController.php#L111) | ProductDivert/divertInvoice: 无显式路由匹配，继续追溯 |
| ANY `/product_divert/servicedetail` | [app/home/controller/ViewClientsController.php:1651](../../app/home/controller/ViewClientsController.php#L1651) | Host/getHeader: GET /host/Header; Host/postCancel: POST /host/Cancel; Host/deleteCancel: DELETE /host/Cancel; Upgrade/upgradeProductPost: POST /upgrade/upgrade_product_post; Upgrade/getUpgradeProductPage: GET /upgrade/upgrade_product_page; Upgrade/addPromoToProduct: POST /upgrade/add_promo_code_product; Upgrade/RemovePromoFromProduct: POST /upgrade/remove_promo_code_product; Host/postRenew: POST /host/Renew; Upgrade/upgradeConfigPost: POST /upgrade/upgrade_config_post; Upgrade/getUpgradeConfigPage: GET /upgrade/upgrade_config_page; Upgrade/addPromoCodeToConfig: POST /upgrade/add_promo_code; Upgrade/removePromoCodeFromConfig: POST /upgrade/remove_promo_code; RecordLog/getUserLogDcs: ANY /user_logdcims; Host/getHostRecharge: GET /host/HostRecharge; Upgrade/upgradeProduct: GET /upgrade/upgrade_product/:hid; Upgrade/index: GET /upgrade/index/:hid; Host/getRenewPageView: GET /host/RenewPageView; Host/getCancel: GET /host/Cancel; Host/getRenewPage: GET /host/RenewPage; User/getSecondVerifyPage: GET /second_verify_page |
| ANY `/product_divert/pushrefuse` | [app/home/controller/ViewProductDivertController.php:157](../../app/home/controller/ViewProductDivertController.php#L157) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| ANY `/product_divert/pullrefuse` | [app/home/controller/ViewProductDivertController.php:134](../../app/home/controller/ViewProductDivertController.php#L134) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |
| ANY `/product_divert/verificationResult` | [app/home/controller/ViewProductDivertController.php:175](../../app/home/controller/ViewProductDivertController.php#L175) | ProductDivert/checkPayStatus: 无显式路由匹配，继续追溯 |
| ANY `/loginAccessToken` | [app/home/controller/ViewClientsController.php:81](../../app/home/controller/ViewClientsController.php#L81) | Login/mobileLoginVerify: POST /mobile_login; Login/phonePassLogin: POST /login_pass_phone; Login/emailLogin: POST /login_pass_email; Login/mobileLoginVerifyPage: GET /mobile_login_page; Login/LoginRegisterIndex: GET /login_register_index |
| GET `/news/:alias` | [app/home/controller/ViewClientsController.php:846](../../app/home/controller/ViewClientsController.php#L846) | 无 controller() 直接调用；需核对 ViewModel/模板/前端请求 |

## 字面量业务路由声明

该表逐条保留 admin/home 路由的字面量声明及源行；RESOURCE 未展开，CONTROLLER 的公有方法候选另表列出，RULE/ANY 不代表仅 GET。当前 admin 外层采用 {A} 前缀，home 所扫描的 group 前缀为空。被 include 的路由、插件和运行时注册未计入。此表不是参数/返回 schema，也不是运行时 route:list。

| 声明方法 | URL / 声明前缀 | 控制器目标 | 路由来源 |
| --- | --- | --- | --- |
| GET | `{A}/login_page` | `admin/Public/adPage` | [data/route/admin.php:83](../../data/route/admin.php#L83) |
| POST | `{A}/login` | `admin/Public/ad_login` | [data/route/admin.php:84](../../data/route/admin.php#L84) |
| GET | `{A}/get_verify_code` | `admin/Public/getVerifyCode` | [data/route/admin.php:85](../../data/route/admin.php#L85) |
| POST | `{A}/second_verify_send` | `admin/Public/secondVerifySend` | [data/route/admin.php:86](../../data/route/admin.php#L86) |
| GET | `{A}/app_store/set_token` | `admin/appStore/setToken` | [data/route/admin.php:87](../../data/route/admin.php#L87) |
| GET | `{A}/app_store/check_token` | `admin/appStore/checkToken` | [data/route/admin.php:88](../../data/route/admin.php#L88) |
| POST | `{A}/app_store/app/:id/install` | `admin/appStore/install` | [data/route/admin.php:89](../../data/route/admin.php#L89) |
| GET | `{A}/agent/checktoken` | `admin/public/checkToken` | [data/route/admin.php:90](../../data/route/admin.php#L90) |
| GET | `{A}/verify` | `admin/Public/verify` | [data/route/admin.php:92](../../data/route/admin.php#L92) |
| GET | `{A}/common` | `admin/common/common` | [data/route/admin.php:93](../../data/route/admin.php#L93) |
| GET | `{A}/common/info_notice` | `admin/common/infoNotice` | [data/route/admin.php:94](../../data/route/admin.php#L94) |
| GET | `{A}/common/get_getways` | `admin/common/getGetways` | [data/route/admin.php:95](../../data/route/admin.php#L95) |
| GET | `{A}/common/get_email_tem` | `admin/common/getEmailTem` | [data/route/admin.php:96](../../data/route/admin.php#L96) |
| GET | `{A}/common/get_client_groups` | `admin/common/getClientGroups` | [data/route/admin.php:97](../../data/route/admin.php#L97) |
| GET | `{A}/common/get_product_list` | `admin/common/getProductList` | [data/route/admin.php:98](../../data/route/admin.php#L98) |
| GET | `{A}/common/get_promo_code` | `admin/common/getPromoCode` | [data/route/admin.php:99](../../data/route/admin.php#L99) |
| GET | `{A}/common/host_list` | `admin/common/getHostList` | [data/route/admin.php:100](../../data/route/admin.php#L100) |
| GET | `{A}/common/get_sms_country` | `admin/common/getSmsCountry` | [data/route/admin.php:101](../../data/route/admin.php#L101) |
| GET | `{A}/common/product_config_options` | `admin/common/getProductConfigOptions` | [data/route/admin.php:102](../../data/route/admin.php#L102) |
| GET | `{A}/common/sale_list` | `admin/common/saleList` | [data/route/admin.php:103](../../data/route/admin.php#L103) |
| GET | `{A}/common/get_upstream_ticket_department_list` | `admin/common/getUpstreamTicketDepartmentList` | [data/route/admin.php:104](../../data/route/admin.php#L104) |
| POST | `{A}/order/getTotal` | `admin/order/getTotal/` | [data/route/admin.php:105](../../data/route/admin.php#L105) |
| RULE | `{A}/test` | `admin/test/index` | [data/route/admin.php:106](../../data/route/admin.php#L106) |
| RULE | `{A}/testview` | `admin/test/testview` | [data/route/admin.php:107](../../data/route/admin.php#L107) |
| RULE | `{A}/test2` | `admin/test/test2` | [data/route/admin.php:108](../../data/route/admin.php#L108) |
| POST | `{A}/async_sms_message` | `admin/Public/asyncSmsMessage` | [data/route/admin.php:109](../../data/route/admin.php#L109) |
| POST | `{A}/async_email_message` | `admin/Public/asyncEmailMessage` | [data/route/admin.php:110](../../data/route/admin.php#L110) |
| POST | `{A}/async_system_message` | `admin/Public/asyncSystemMessage` | [data/route/admin.php:111](../../data/route/admin.php#L111) |
| POST | `{A}/async` | `admin/Public/asyncEmail` | [data/route/admin.php:112](../../data/route/admin.php#L112) |
| POST | `{A}/async_sms` | `admin/Public/asyncSms` | [data/route/admin.php:113](../../data/route/admin.php#L113) |
| POST | `{A}/async_create` | `admin/Public/asyncCreateAccount` | [data/route/admin.php:114](../../data/route/admin.php#L114) |
| POST | `{A}/async_curl_multi` | `admin/Public/asyncCurlMulti` | [data/route/admin.php:115](../../data/route/admin.php#L115) |
| GET | `{A}/logout` | `admin/Public/ad_logout` | [data/route/admin.php:116](../../data/route/admin.php#L116) |
| GET | `{A}/getClient` | `admin/Public/getClient` | [data/route/admin.php:117](../../data/route/admin.php#L117) |
| GET | `{A}/getTicketDepartment` | `admin/Public/getTicketDepartment` | [data/route/admin.php:118](../../data/route/admin.php#L118) |
| GET | `{A}/ad_login` | `admin/Public/login` | [data/route/admin.php:119](../../data/route/admin.php#L119) |
| GET | `{A}/searchlist` | `admin/index/search` | [data/route/admin.php:120](../../data/route/admin.php#L120) |
| GET | `{A}/searchlist1` | `admin/index/search1` | [data/route/admin.php:121](../../data/route/admin.php#L121) |
| GET | `{A}/tablelist` | `admin/index/tableList` | [data/route/admin.php:122](../../data/route/admin.php#L122) |
| GET | `{A}/namelist` | `admin/index/nameList` | [data/route/admin.php:123](../../data/route/admin.php#L123) |
| POST | `{A}/searchfornamelist` | `admin/index/searchfornameList` | [data/route/admin.php:124](../../data/route/admin.php#L124) |
| GET | `{A}/editlog` | `admin/index/editLog` | [data/route/admin.php:125](../../data/route/admin.php#L125) |
| GET | `{A}/ad_index` | `admin/index/ad_index` | [data/route/admin.php:126](../../data/route/admin.php#L126) |
| GET | `{A}/new_cap` | `admin/Captcha/index` | [data/route/admin.php:127](../../data/route/admin.php#L127) |
| GET | `{A}/rbac` | `admin/rbac/index` | [data/route/admin.php:128](../../data/route/admin.php#L128) |
| GET | `{A}/rbac/role_page` | `admin/rbac/addRolePage` | [data/route/admin.php:129](../../data/route/admin.php#L129) |
| POST | `{A}/rbac` | `admin/rbac/addRole` | [data/route/admin.php:130](../../data/route/admin.php#L130) |
| GET | `{A}/rbac/:id` | `admin/rbac/editRolePage` | [data/route/admin.php:131](../../data/route/admin.php#L131) |
| POST | `{A}/rbac/edit` | `admin/rbac/editRole` | [data/route/admin.php:132](../../data/route/admin.php#L132) |
| DELETE | `{A}/rbac/:id/` | `admin/rbac/delete` | [data/route/admin.php:133](../../data/route/admin.php#L133) |
| POST | `{A}/rbac/copyRole` | `admin/rbac/copyRole` | [data/route/admin.php:134](../../data/route/admin.php#L134) |
| GET | `{A}/rbacpage` | `admin/rbacPage/index` | [data/route/admin.php:135](../../data/route/admin.php#L135) |
| GET | `{A}/rbacpage/role_page` | `admin/rbacPage/addRolePage` | [data/route/admin.php:136](../../data/route/admin.php#L136) |
| POST | `{A}/rbacpage` | `admin/rbacPage/addRole` | [data/route/admin.php:137](../../data/route/admin.php#L137) |
| GET | `{A}/rbacpage/:id` | `admin/rbacPage/editRolePage` | [data/route/admin.php:138](../../data/route/admin.php#L138) |
| POST | `{A}/rbacpage/edit` | `admin/rbacPage/editRole` | [data/route/admin.php:139](../../data/route/admin.php#L139) |
| DELETE | `{A}/rbacpage/:id/` | `admin/rbacPage/delete` | [data/route/admin.php:140](../../data/route/admin.php#L140) |
| GET | `{A}/authorize/:id` | `admin/rbac/ad_authorize` | [data/route/admin.php:141](../../data/route/admin.php#L141) |
| POST | `{A}/authorize` | `admin/rbac/ad_authorizePost` | [data/route/admin.php:142](../../data/route/admin.php#L142) |
| GET | `{A}/adminuser` | `admin/user/adminList` | [data/route/admin.php:143](../../data/route/admin.php#L143) |
| GET | `{A}/create_page` | `admin/user/createPage` | [data/route/admin.php:144](../../data/route/admin.php#L144) |
| POST | `{A}/adminuser` | `admin/user/create` | [data/route/admin.php:145](../../data/route/admin.php#L145) |
| GET | `{A}/adminuser/:id` | `admin/user/updatePage` | [data/route/admin.php:146](../../data/route/admin.php#L146) |
| POST | `{A}/adminuser/update` | `admin/user/update` | [data/route/admin.php:147](../../data/route/admin.php#L147) |
| DELETE | `{A}/adminuser/:id/` | `admin/user/delete` | [data/route/admin.php:148](../../data/route/admin.php#L148) |
| GET | `{A}/ban/:id/` | `admin/user/ban` | [data/route/admin.php:149](../../data/route/admin.php#L149) |
| GET | `{A}/cancelBan/:id/` | `admin/user/cancelBan` | [data/route/admin.php:150](../../data/route/admin.php#L150) |
| GET | `{A}/user/edit_self_info_page` | `admin/user/editSelfInfoPage` | [data/route/admin.php:151](../../data/route/admin.php#L151) |
| POST | `{A}/user/edit_self_info` | `admin/user/editSelfInfo` | [data/route/admin.php:152](../../data/route/admin.php#L152) |
| GET | `{A}/user/get_black_list` | `admin/user/getBlackList` | [data/route/admin.php:153](../../data/route/admin.php#L153) |
| POST | `{A}/user/remove_black_list` | `admin/user/removeBlackList` | [data/route/admin.php:154](../../data/route/admin.php#L154) |
| POST | `{A}/tastes/editUserTanstes` | `admin/userTastes/editUserTanstes` | [data/route/admin.php:155](../../data/route/admin.php#L155) |
| GET | `{A}/pl_index/[:moduleName]/` | `admin/plugin/plIndex` | [data/route/admin.php:156](../../data/route/admin.php#L156) |
| POST | `{A}/pl_sort/[:moduleName]/` | `admin/plugin/plSort` | [data/route/admin.php:157](../../data/route/admin.php#L157) |
| POST | `{A}/pl_copy` | `admin/plugin/plCopy` | [data/route/admin.php:158](../../data/route/admin.php#L158) |
| POST | `{A}/pl_install` | `admin/plugin/plInstall` | [data/route/admin.php:159](../../data/route/admin.php#L159) |
| POST | `{A}/pl_uninstall` | `admin/plugin/plUninstall` | [data/route/admin.php:160](../../data/route/admin.php#L160) |
| POST | `{A}/pl_toggle` | `admin/plugin/plToggle` | [data/route/admin.php:161](../../data/route/admin.php#L161) |
| GET | `{A}/pl_setting/[:module]/:id` | `admin/plugin/plSetting` | [data/route/admin.php:162](../../data/route/admin.php#L162) |
| POST | `{A}/pl_setting_post` | `admin/plugin/plSettingPost` | [data/route/admin.php:163](../../data/route/admin.php#L163) |
| POST | `{A}/default_gateway` | `admin/plugin/defaultGateway` | [data/route/admin.php:164](../../data/route/admin.php#L164) |
| POST | `{A}/pl_update` | `admin/plugin/plUpdate` | [data/route/admin.php:165](../../data/route/admin.php#L165) |
| GET | `{A}/oauth` | `admin/oauth/listing` | [data/route/admin.php:166](../../data/route/admin.php#L166) |
| POST | `{A}/oauth/active` | `admin/oauth/active` | [data/route/admin.php:167](../../data/route/admin.php#L167) |
| GET | `{A}/oauth/config` | `admin/oauth/config` | [data/route/admin.php:168](../../data/route/admin.php#L168) |
| POST | `{A}/oauth/config_post` | `admin/oauth/configSave` | [data/route/admin.php:169](../../data/route/admin.php#L169) |
| POST | `{A}/oauth/suspend` | `admin/oauth/suspend` | [data/route/admin.php:170](../../data/route/admin.php#L170) |
| GET | `{A}/get_user` | `admin/user_manage/getUser` | [data/route/admin.php:171](../../data/route/admin.php#L171) |
| RULE | `{A}/client_list` | `admin/user_manage/clientList` | [data/route/admin.php:172](../../data/route/admin.php#L172) |
| GET | `{A}/client_list_resource` | `admin/user_manage/clientListRe` | [data/route/admin.php:173](../../data/route/admin.php#L173) |
| ANY | `{A}/bind_sale` | `admin/user_manage/hostBindSale` | [data/route/admin.php:174](../../data/route/admin.php#L174) |
| GET | `{A}/summary` | `admin/user_manage/summary` | [data/route/admin.php:175](../../data/route/admin.php#L175) |
| GET | `{A}/hostbyuid` | `admin/user_manage/hostByUid` | [data/route/admin.php:176](../../data/route/admin.php#L176) |
| GET | `{A}/cerify_list` | `admin/user_manage/cerify_list` | [data/route/admin.php:177](../../data/route/admin.php#L177) |
| GET | `{A}/cerify_log_list` | `admin/user_manage/cerifyLogList` | [data/route/admin.php:178](../../data/route/admin.php#L178) |
| GET | `{A}/cerify_history_log` | `admin/user_manage/getCerifyHistoryLog` | [data/route/admin.php:179](../../data/route/admin.php#L179) |
| GET | `{A}/certifi_person_detail/:client_id` | `admin/user_manage/certifiPersonDetail` | [data/route/admin.php:180](../../data/route/admin.php#L180) |
| GET | `{A}/certifi_company_detail/:client_id` | `admin/user_manage/certifiCompanyDetail` | [data/route/admin.php:181](../../data/route/admin.php#L181) |
| GET | `{A}/certifi_person_download` | `admin/user_manage/certifiPersonDownload` | [data/route/admin.php:182](../../data/route/admin.php#L182) |
| GET | `{A}/certifi_download` | `admin/user_manage/certifiDownload` | [data/route/admin.php:183](../../data/route/admin.php#L183) |
| POST | `{A}/certifi_status` | `admin/user_manage/certifiStatus` | [data/route/admin.php:184](../../data/route/admin.php#L184) |
| RESOURCE | `{A}/client_group` | `admin/ClientGroup` | [data/route/admin.php:185](../../data/route/admin.php#L185) |
| GET | `{A}/relation_user_list` | `admin/user_manage/relationUserList` | [data/route/admin.php:186](../../data/route/admin.php#L186) |
| GET | `{A}/user_invoice` | `admin/user_manage/userInvoice` | [data/route/admin.php:187](../../data/route/admin.php#L187) |
| GET | `{A}/user_productinvoice` | `admin/user_manage/userProductInvoice` | [data/route/admin.php:188](../../data/route/admin.php#L188) |
| GET | `{A}/user_productaccounts` | `admin/user_manage/userProductaccounts` | [data/route/admin.php:189](../../data/route/admin.php#L189) |
| POST | `{A}/add_user_invoice` | `admin/user_manage/addUserInvoice` | [data/route/admin.php:190](../../data/route/admin.php#L190) |
| POST | `{A}/add_record_log` | `admin/user_manage/addRecordLog` | [data/route/admin.php:191](../../data/route/admin.php#L191) |
| POST | `{A}/add_remark_log` | `admin/user_manage/addRemarkLog` | [data/route/admin.php:192](../../data/route/admin.php#L192) |
| GET | `{A}/track_record` | `admin/user_manage/getTrackRecord` | [data/route/admin.php:193](../../data/route/admin.php#L193) |
| POST | `{A}/track_status` | `admin/user_manage/clientTrackStatus` | [data/route/admin.php:194](../../data/route/admin.php#L194) |
| GET | `{A}/profile/getclients/:client_id` | `admin/user_manage/getclients` | [data/route/admin.php:195](../../data/route/admin.php#L195) |
| GET | `{A}/profile/:client_id` | `admin/user_manage/profile` | [data/route/admin.php:196](../../data/route/admin.php#L196) |
| POST | `{A}/profile_post` | `admin/user_manage/profilePost` | [data/route/admin.php:197](../../data/route/admin.php#L197) |
| GET | `{A}/create_client` | `admin/user_manage/createClient` | [data/route/admin.php:198](../../data/route/admin.php#L198) |
| POST | `{A}/create_client_post` | `admin/user_manage/createClientPost` | [data/route/admin.php:199](../../data/route/admin.php#L199) |
| GET | `{A}/close_client/:uid` | `admin/user_manage/closeClient` | [data/route/admin.php:200](../../data/route/admin.php#L200) |
| GET | `{A}/delete_client/:uid` | `admin/user_manage/deleteClient` | [data/route/admin.php:201](../../data/route/admin.php#L201) |
| GET | `{A}/log_record` | `admin/user_manage/logRecord` | [data/route/admin.php:202](../../data/route/admin.php#L202) |
| POST | `{A}/certifi_person_modify` | `admin/user_manage/certifiPersonModify` | [data/route/admin.php:203](../../data/route/admin.php#L203) |
| POST | `{A}/certifi_company_modify` | `admin/user_manage/certifiCompanyModify` | [data/route/admin.php:204](../../data/route/admin.php#L204) |
| GET | `{A}/login_by_user/:uid` | `admin/user_manage/loginByUser` | [data/route/admin.php:205](../../data/route/admin.php#L205) |
| POST | `{A}/add_recharge_invoice/:uid` | `admin/user_manage/addRechargeInvoice` | [data/route/admin.php:206](../../data/route/admin.php#L206) |
| GET | `{A}/request_cancel_list` | `admin/user_manage/requestCancelList` | [data/route/admin.php:207](../../data/route/admin.php#L207) |
| DELETE | `{A}/request_cancel_list/:id` | `admin/user_manage/deleteCancelRequest` | [data/route/admin.php:208](../../data/route/admin.php#L208) |
| GET | `{A}/request_cancel_reason` | `admin/user_manage/requestCancelReason` | [data/route/admin.php:209](../../data/route/admin.php#L209) |
| POST | `{A}/request_cancel_reason_post` | `admin/user_manage/requestCancelReasonPost` | [data/route/admin.php:210](../../data/route/admin.php#L210) |
| GET | `{A}/del_reason` | `admin/user_manage/DelReason` | [data/route/admin.php:211](../../data/route/admin.php#L211) |
| GET | `{A}/get_client_notes` | `admin/user_manage/getClientNotes` | [data/route/admin.php:212](../../data/route/admin.php#L212) |
| POST | `{A}/post_client_notes` | `admin/user_manage/postClientNotes` | [data/route/admin.php:213](../../data/route/admin.php#L213) |
| GET | `{A}/authorInfo` | `admin/user_manage/authorInfo` | [data/route/admin.php:214](../../data/route/admin.php#L214) |
| POST | `{A}/authorSubmit` | `admin/user_manage/authorSubmit` | [data/route/admin.php:215](../../data/route/admin.php#L215) |
| GET | `{A}/provision/list` | `admin/provision/getModules` | [data/route/admin.php:216](../../data/route/admin.php#L216) |
| GET | `{A}/provision/metadata` | `admin/provision/getMetaData` | [data/route/admin.php:217](../../data/route/admin.php#L217) |
| GET | `{A}/provision/:id` | `admin/provision/getModuleConfig` | [data/route/admin.php:218](../../data/route/admin.php#L218) |
| POST | `{A}/provision/default` | `admin/provision/execute` | [data/route/admin.php:219](../../data/route/admin.php#L219) |
| POST | `{A}/provision/custom` | `admin/provision/execAdmin` | [data/route/admin.php:220](../../data/route/admin.php#L220) |
| POST | `{A}/password_reset` | `admin/set/passwordPost` | [data/route/admin.php:221](../../data/route/admin.php#L221) |
| GET | `{A}/clear_cache` | `admin/set/clearCache` | [data/route/admin.php:222](../../data/route/admin.php#L222) |
| GET | `{A}/custom_fields` | `admin/set/getCustomFields` | [data/route/admin.php:223](../../data/route/admin.php#L223) |
| POST | `{A}/custom_fields` | `admin/set/postCustomFields` | [data/route/admin.php:224](../../data/route/admin.php#L224) |
| POST | `{A}/del_custom_fields` | `admin/set/delCustomFields` | [data/route/admin.php:225](../../data/route/admin.php#L225) |
| GET | `{A}/database_backup` | `admin/set/databaseBackups` | [data/route/admin.php:226](../../data/route/admin.php#L226) |
| POST | `{A}/backup_ftp` | `admin/set/backupDatabaseFtp` | [data/route/admin.php:227](../../data/route/admin.php#L227) |
| POST | `{A}/deactivete_ftp` | `admin/set/deactivateFtp` | [data/route/admin.php:228](../../data/route/admin.php#L228) |
| POST | `{A}/backup_email` | `admin/set/backupEmail` | [data/route/admin.php:229](../../data/route/admin.php#L229) |
| POST | `{A}/deactivete_email` | `admin/set/deactivateEmail` | [data/route/admin.php:230](../../data/route/admin.php#L230) |
| GET | `{A}/servers_list` | `admin/config_servers/serverList` | [data/route/admin.php:231](../../data/route/admin.php#L231) |
| GET | `{A}/groups_list` | `admin/config_servers/groupsList` | [data/route/admin.php:232](../../data/route/admin.php#L232) |
| GET | `{A}/servers_add` | `admin/config_servers/addServers` | [data/route/admin.php:233](../../data/route/admin.php#L233) |
| POST | `{A}/servers_add_post` | `admin/config_servers/addServersPost` | [data/route/admin.php:234](../../data/route/admin.php#L234) |
| GET | `{A}/edit_servers/:id` | `admin/config_servers/editServers` | [data/route/admin.php:235](../../data/route/admin.php#L235) |
| POST | `{A}/edit_servers_post` | `admin/config_servers/editServersPost` | [data/route/admin.php:236](../../data/route/admin.php#L236) |
| GET | `{A}/delete_servers/:id` | `admin/config_servers/deleteServers` | [data/route/admin.php:237](../../data/route/admin.php#L237) |
| GET | `{A}/create_groups` | `admin/config_servers/createGroups` | [data/route/admin.php:238](../../data/route/admin.php#L238) |
| POST | `{A}/create_groups_post` | `admin/config_servers/createGroupsPost` | [data/route/admin.php:239](../../data/route/admin.php#L239) |
| GET | `{A}/edit_server_groups/:id` | `admin/config_servers/editServerGroups` | [data/route/admin.php:240](../../data/route/admin.php#L240) |
| POST | `{A}/edit_server_groups_post` | `admin/config_servers/editServerGroupsPost` | [data/route/admin.php:241](../../data/route/admin.php#L241) |
| GET | `{A}/delete_server_groups/:id` | `admin/config_servers/deleteServerGroups` | [data/route/admin.php:242](../../data/route/admin.php#L242) |
| GET | `{A}/server_test_link/:id` | `admin/config_servers/testLink` | [data/route/admin.php:243](../../data/route/admin.php#L243) |
| POST | `{A}/get_modules_group` | `admin/config_servers/getModulesGroup` | [data/route/admin.php:244](../../data/route/admin.php#L244) |
| GET | `{A}/options/groups_list` | `admin/config_options/groupsList` | [data/route/admin.php:245](../../data/route/admin.php#L245) |
| GET | `{A}/options/search_page` | `admin/config_options/searchPage` | [data/route/admin.php:246](../../data/route/admin.php#L246) |
| GET | `{A}/options/create_groups` | `admin/config_options/createGroups` | [data/route/admin.php:247](../../data/route/admin.php#L247) |
| POST | `{A}/options/create_groups_post` | `admin/config_options/createGroupsPost` | [data/route/admin.php:248](../../data/route/admin.php#L248) |
| GET | `{A}/options/edit_groups/:gid` | `admin/config_options/editGroups` | [data/route/admin.php:249](../../data/route/admin.php#L249) |
| POST | `{A}/options/edit_groups_post` | `admin/config_options/editGroupsPost` | [data/route/admin.php:250](../../data/route/admin.php#L250) |
| GET | `{A}/options/add_options_page` | `admin/config_options/addOptionsPage` | [data/route/admin.php:251](../../data/route/admin.php#L251) |
| POST | `{A}/options/add_options` | `admin/config_options/addOptions` | [data/route/admin.php:252](../../data/route/admin.php#L252) |
| GET | `{A}/options/delete_sub_options/:subid` | `admin/config_options/deleteSubOptions` | [data/route/admin.php:253](../../data/route/admin.php#L253) |
| GET | `{A}/options/delete_options/:cid` | `admin/config_options/deleteOptions` | [data/route/admin.php:254](../../data/route/admin.php#L254) |
| GET | `{A}/options/delete_groups/:gid` | `admin/config_options/deleteGroups` | [data/route/admin.php:255](../../data/route/admin.php#L255) |
| GET | `{A}/options/duplicate_groups` | `admin/config_options/duplicateGroups` | [data/route/admin.php:256](../../data/route/admin.php#L256) |
| POST | `{A}/options/duplicate_groups_post` | `admin/config_options/duplicateGroupsPost` | [data/route/admin.php:257](../../data/route/admin.php#L257) |
| GET | `{A}/options/config_options_check_os` | `admin/config_options/configOptionsCheckOs` | [data/route/admin.php:258](../../data/route/admin.php#L258) |
| POST | `{A}/options/config_options_check_os/:pid` | `admin/config_options/configOptionsOs` | [data/route/admin.php:259](../../data/route/admin.php#L259) |
| GET | `{A}/options/edit_config/:cid` | `admin/config_options/editConfig` | [data/route/admin.php:260](../../data/route/admin.php#L260) |
| POST | `{A}/options/edit_config_post` | `admin/config_options/editConfigPost` | [data/route/admin.php:261](../../data/route/admin.php#L261) |
| POST | `{A}/options/saveLinkAgeLevel` | `admin/config_options/saveLinkAgeLevel` | [data/route/admin.php:262](../../data/route/admin.php#L262) |
| POST | `{A}/options/saveLinkAgeOrder` | `admin/config_options/saveLinkAgeOrder` | [data/route/admin.php:263](../../data/route/admin.php#L263) |
| POST | `{A}/options/delLinkAgeSub` | `admin/config_options/delLinkAgeSub` | [data/route/admin.php:264](../../data/route/admin.php#L264) |
| POST | `{A}/options/saveConfigOptionInfo` | `admin/config_options/saveConfigOptionInfo` | [data/route/admin.php:265](../../data/route/admin.php#L265) |
| GET | `{A}/options/getNextLinkAgeList` | `admin/config_options/getNextLinkAgeList` | [data/route/admin.php:266](../../data/route/admin.php#L266) |
| GET | `{A}/currency/currency_list` | `admin/currency/currencyList` | [data/route/admin.php:267](../../data/route/admin.php#L267) |
| POST | `{A}/currency/add_currency` | `admin/currency/addCurrency` | [data/route/admin.php:268](../../data/route/admin.php#L268) |
| GET | `{A}/currency/edit_currency/:id` | `admin/currency/editCurrency` | [data/route/admin.php:269](../../data/route/admin.php#L269) |
| POST | `{A}/currency/edit_currency_post` | `admin/currency/editCurrencyPost` | [data/route/admin.php:270](../../data/route/admin.php#L270) |
| GET | `{A}/currency/delete_currency/:id` | `admin/currency/deleteCurrency` | [data/route/admin.php:271](../../data/route/admin.php#L271) |
| GET | `{A}/currency/update_rate` | `admin/currency/updateRate` | [data/route/admin.php:272](../../data/route/admin.php#L272) |
| GET | `{A}/currency/default_currency/:id` | `admin/currency/defaultCurrency` | [data/route/admin.php:273](../../data/route/admin.php#L273) |
| GET | `{A}/currency/update_price` | `admin/currency/updatePrice` | [data/route/admin.php:274](../../data/route/admin.php#L274) |
| GET | `{A}/email_template/send_email` | `admin/email_template/sendEmail` | [data/route/admin.php:275](../../data/route/admin.php#L275) |
| GET | `{A}/email_template/email_list` | `admin/email_template/emailList` | [data/route/admin.php:276](../../data/route/admin.php#L276) |
| POST | `{A}/email_template/operator_switch` | `admin/email_template/emailOperatorSwitch` | [data/route/admin.php:277](../../data/route/admin.php#L277) |
| GET | `{A}/email_template/create_template` | `admin/email_template/createTemplate` | [data/route/admin.php:278](../../data/route/admin.php#L278) |
| POST | `{A}/email_template/create_template_post` | `admin/email_template/createTemplatePost` | [data/route/admin.php:279](../../data/route/admin.php#L279) |
| GET | `{A}/email_template/edit_template/:id` | `admin/email_template/editTemplate` | [data/route/admin.php:280](../../data/route/admin.php#L280) |
| POST | `{A}/email_template/edit_template_post` | `admin/email_template/editTemplatePost` | [data/route/admin.php:281](../../data/route/admin.php#L281) |
| GET | `{A}/email_template/manage_language` | `admin/email_template/manageLanguages` | [data/route/admin.php:282](../../data/route/admin.php#L282) |
| POST | `{A}/email_template/manage_language_post` | `admin/email_template/manageLanguagesPost` | [data/route/admin.php:283](../../data/route/admin.php#L283) |
| POST | `{A}/email_template/disabled` | `admin/email_template/disabled` | [data/route/admin.php:284](../../data/route/admin.php#L284) |
| GET | `{A}/email_template/delete_template/:id` | `admin/email_template/deleteTemplate` | [data/route/admin.php:285](../../data/route/admin.php#L285) |
| POST | `{A}/email_template/disabled_template` | `admin/email_template/disabledTemplate` | [data/route/admin.php:286](../../data/route/admin.php#L286) |
| GET | `{A}/knowledge_base/index` | `admin/knowledge_base/index` | [data/route/admin.php:287](../../data/route/admin.php#L287) |
| GET | `{A}/knowledge_base/category_list/:cid` | `admin/knowledge_base/categoryList` | [data/route/admin.php:288](../../data/route/admin.php#L288) |
| POST | `{A}/knowledge_base/tags_list` | `admin/knowledge_base/tagsList` | [data/route/admin.php:289](../../data/route/admin.php#L289) |
| POST | `{A}/knowledge_base/add_category` | `admin/knowledge_base/addCategory` | [data/route/admin.php:290](../../data/route/admin.php#L290) |
| POST | `{A}/knowledge_base/add_article` | `admin/knowledge_base/addArticle` | [data/route/admin.php:291](../../data/route/admin.php#L291) |
| GET | `{A}/knowledge_base/edit_article/:id` | `admin/knowledge_base/editArticle` | [data/route/admin.php:292](../../data/route/admin.php#L292) |
| POST | `{A}/knowledge_base/edit_article_post` | `admin/knowledge_base/editArticlePost` | [data/route/admin.php:293](../../data/route/admin.php#L293) |
| POST | `{A}/knowledge_base/upload` | `admin/knowledge_base/uploadHandle` | [data/route/admin.php:294](../../data/route/admin.php#L294) |
| GET | `{A}/knowledge_base/delete_article/:id` | `admin/knowledge_base/deleteArticle` | [data/route/admin.php:295](../../data/route/admin.php#L295) |
| GET | `{A}/knowledge_base/edit_category/:id` | `admin/knowledge_base/editCategory` | [data/route/admin.php:296](../../data/route/admin.php#L296) |
| POST | `{A}/knowledge_base/edit_category_post` | `admin/knowledge_base/editCategoryPost` | [data/route/admin.php:297](../../data/route/admin.php#L297) |
| GET | `{A}/knowledge_base/delete_category/:id` | `admin/knowledge_base/deleteCategory` | [data/route/admin.php:298](../../data/route/admin.php#L298) |
| CONTROLLER | `{A}/config_general` | `admin/ConfigGeneral` | [data/route/admin.php:299](../../data/route/admin.php#L299) |
| GET | `{A}/config_general/header` | `admin/config_general/getHeader` | [data/route/admin.php:300](../../data/route/admin.php#L300) |
| GET | `{A}/config_general/new_login` | `admin/config_general/getNewLoginPage` | [data/route/admin.php:301](../../data/route/admin.php#L301) |
| POST | `{A}/config_general/new_login` | `admin/config_general/postNewLoginPage` | [data/route/admin.php:302](../../data/route/admin.php#L302) |
| GET | `{A}/config_general/affiliate` | `admin/config_general/getAffiliate` | [data/route/admin.php:303](../../data/route/admin.php#L303) |
| ANY | `{A}/config_general/postaffiliate` | `admin/config_general/postAffiliate` | [data/route/admin.php:304](../../data/route/admin.php#L304) |
| GET | `{A}/affladder` | `admin/config_general/ladderList` | [data/route/admin.php:305](../../data/route/admin.php#L305) |
| ANY | `{A}/aff/add_affladder` | `admin/config_general/addAffLadder` | [data/route/admin.php:306](../../data/route/admin.php#L306) |
| GET | `{A}/aff/edit_affladderpage` | `admin/config_general/editAffLadderPage` | [data/route/admin.php:307](../../data/route/admin.php#L307) |
| ANY | `{A}/aff/edit_affladder` | `admin/config_general/editAffLadder` | [data/route/admin.php:308](../../data/route/admin.php#L308) |
| GET | `{A}/aff/del_affladder` | `admin/config_general/delAffLadder` | [data/route/admin.php:309](../../data/route/admin.php#L309) |
| GET | `{A}/config_general/invoice` | `admin/config_general/getInvoice` | [data/route/admin.php:310](../../data/route/admin.php#L310) |
| POST | `{A}/config_general/invoice` | `admin/config_general/postInvoice` | [data/route/admin.php:311](../../data/route/admin.php#L311) |
| GET | `{A}/config_general/email_index` | `admin/config_general/emailIndex` | [data/route/admin.php:312](../../data/route/admin.php#L312) |
| POST | `{A}/config_general/email_index_post` | `admin/config_general/emailIndexPost` | [data/route/admin.php:313](../../data/route/admin.php#L313) |
| POST | `{A}/config_general/send_email` | `admin/config_general/sendEmailTest` | [data/route/admin.php:314](../../data/route/admin.php#L314) |
| GET | `{A}/config_general/certifi_index` | `admin/config_general/certifiIndex` | [data/route/admin.php:315](../../data/route/admin.php#L315) |
| POST | `{A}/config_general/certifi_index_post` | `admin/config_general/certifiIndexPost` | [data/route/admin.php:316](../../data/route/admin.php#L316) |
| GET | `{A}/config_general/mobile_index` | `admin/config_general/mobileIndex` | [data/route/admin.php:317](../../data/route/admin.php#L317) |
| POST | `{A}/config_general/mobile_index_post` | `admin/config_general/mobileIndexPost` | [data/route/admin.php:318](../../data/route/admin.php#L318) |
| GET | `{A}/config_general/lang_list` | `admin/config_general/langList` | [data/route/admin.php:319](../../data/route/admin.php#L319) |
| POST | `{A}/config_general/set_admin_lang` | `admin/config_general/setAdminLang` | [data/route/admin.php:320](../../data/route/admin.php#L320) |
| GET | `{A}/config_general/support_indeuploadFilex` | `admin/config_general/supportIndex` | [data/route/admin.php:321](../../data/route/admin.php#L321) |
| POST | `{A}/config_general/batch_send_email` | `admin/config_general/batchSendEmail` | [data/route/admin.php:322](../../data/route/admin.php#L322) |
| POST | `{A}/config_general/submail_send_message` | `admin/config_general/SubmailSendMessage` | [data/route/admin.php:323](../../data/route/admin.php#L323) |
| GET | `{A}/config_general/register_login_page` | `admin/config_general/registerLoginPage` | [data/route/admin.php:324](../../data/route/admin.php#L324) |
| POST | `{A}/config_general/register_login` | `admin/config_general/registerLogin` | [data/route/admin.php:325](../../data/route/admin.php#L325) |
| GET | `{A}/config_general/captcha_page` | `admin/config_general/getcaptcha_page` | [data/route/admin.php:326](../../data/route/admin.php#L326) |
| POST | `{A}/config_general/register_login_captcha` | `admin/config_general/postregister_login_captcha` | [data/route/admin.php:327](../../data/route/admin.php#L327) |
| GET | `{A}/config_general/invoice_page` | `admin/config_general/invoicePage` | [data/route/admin.php:328](../../data/route/admin.php#L328) |
| POST | `{A}/config_general/invoice_post` | `admin/config_general/invoicePost` | [data/route/admin.php:329](../../data/route/admin.php#L329) |
| GET | `{A}/config_general/productgroup_page` | `admin/config_general/productgroupPage` | [data/route/admin.php:330](../../data/route/admin.php#L330) |
| GET | `{A}/config_general/productgroup_list` | `admin/config_general/productgroupList` | [data/route/admin.php:331](../../data/route/admin.php#L331) |
| POST | `{A}/config_general/productgroup` | `admin/config_general/productGroupPost` | [data/route/admin.php:332](../../data/route/admin.php#L332) |
| GET | `{A}/config_general/navgrouporder` | `admin/config_general/navGroupOrder` | [data/route/admin.php:333](../../data/route/admin.php#L333) |
| GET | `{A}/config_general/buy_product_page` | `admin/config_general/getBuyProductPage` | [data/route/admin.php:334](../../data/route/admin.php#L334) |
| POST | `{A}/config_general/buy_product` | `admin/config_general/postBuyProduct` | [data/route/admin.php:335](../../data/route/admin.php#L335) |
| GET | `{A}/config_market/app_manage_index` | `admin/config_market/appManageIndex` | [data/route/admin.php:336](../../data/route/admin.php#L336) |
| POST | `{A}/config_market/app_manage_index_post` | `admin/config_market/appManageIndexPost` | [data/route/admin.php:337](../../data/route/admin.php#L337) |
| GET | `{A}/config_market/withdraw_manage_index` | `admin/config_market/withdrawManageIndex` | [data/route/admin.php:338](../../data/route/admin.php#L338) |
| POST | `{A}/config_market/withdraw_manage_index_post` | `admin/config_market/withdrawManageIndexPost` | [data/route/admin.php:339](../../data/route/admin.php#L339) |
| GET | `{A}/config_market/activity_banner_list` | `admin/config_market/activityBannerList` | [data/route/admin.php:340](../../data/route/admin.php#L340) |
| POST | `{A}/config_market/activity_banner` | `admin/config_market/postActivityBanner` | [data/route/admin.php:341](../../data/route/admin.php#L341) |
| PUT | `{A}/config_market/activity_banner` | `admin/config_market/putActivityBanner` | [data/route/admin.php:342](../../data/route/admin.php#L342) |
| DELETE | `{A}/config_market/activity_banner` | `admin/config_market/deleteActivityBanner` | [data/route/admin.php:343](../../data/route/admin.php#L343) |
| GET | `{A}/certifi_alipay_detail` | `admin/config_certifi/detail` | [data/route/admin.php:344](../../data/route/admin.php#L344) |
| GET | `{A}/certifi_alipay_biz_code` | `admin/config_certifi/alipay_biz_code` | [data/route/admin.php:345](../../data/route/admin.php#L345) |
| GET | `{A}/certifi_three_type` | `admin/config_certifi/alipay_three_type` | [data/route/admin.php:346](../../data/route/admin.php#L346) |
| GET | `{A}/certifi_type` | `admin/config_certifi/type` | [data/route/admin.php:347](../../data/route/admin.php#L347) |
| GET | `{A}/certifi_types` | `admin/config_certifi/types` | [data/route/admin.php:348](../../data/route/admin.php#L348) |
| PUT | `{A}/certifi_alipay` | `admin/config_certifi/update` | [data/route/admin.php:349](../../data/route/admin.php#L349) |
| GET | `{A}/config_certifi/setting` | `admin/config_certifi/setting` | [data/route/admin.php:350](../../data/route/admin.php#L350) |
| POST | `{A}/config_certifi/setting` | `admin/config_certifi/settingPost` | [data/route/admin.php:351](../../data/route/admin.php#L351) |
| POST | `{A}/upload_author` | `admin/upload/uploadAuthor` | [data/route/admin.php:352](../../data/route/admin.php#L352) |
| POST | `{A}/uploadCertificate` | `admin/upload/uploadCertificate` | [data/route/admin.php:353](../../data/route/admin.php#L353) |
| GET | `{A}/config_certifi/authorDown` | `admin/config_certifi/authorDown` | [data/route/admin.php:354](../../data/route/admin.php#L354) |
| GET | `{A}/config_certifi/authorDel` | `admin/config_certifi/authorDel` | [data/route/admin.php:355](../../data/route/admin.php#L355) |
| GET | `{A}/config_message/config_mobile` | `admin/config_message/configMobile` | [data/route/admin.php:356](../../data/route/admin.php#L356) |
| POST | `{A}/config_message/config_mobile_post` | `admin/config_message/configMobilePost` | [data/route/admin.php:357](../../data/route/admin.php#L357) |
| GET | `{A}/config_message/template_list` | `admin/config_message/templateList` | [data/route/admin.php:358](../../data/route/admin.php#L358) |
| GET | `{A}/config_message/create_template_page` | `admin/config_message/createTemplatePage` | [data/route/admin.php:359](../../data/route/admin.php#L359) |
| POST | `{A}/config_message/create_template` | `admin/config_message/createTemplate` | [data/route/admin.php:360](../../data/route/admin.php#L360) |
| GET | `{A}/config_message/update_template/:id` | `admin/config_message/updateTemplate` | [data/route/admin.php:361](../../data/route/admin.php#L361) |
| POST | `{A}/config_message/update_template_post` | `admin/config_message/updateTemplatePost` | [data/route/admin.php:362](../../data/route/admin.php#L362) |
| GET | `{A}/config_message/update_tem_status` | `admin/config_message/updateTemStatus` | [data/route/admin.php:363](../../data/route/admin.php#L363) |
| POST | `{A}/config_message/check_post` | `admin/config_message/checkPost` | [data/route/admin.php:364](../../data/route/admin.php#L364) |
| GET | `{A}/config_message/delete_template` | `admin/config_message/deleteTemplate` | [data/route/admin.php:365](../../data/route/admin.php#L365) |
| GET | `{A}/config_message/set_sms` | `admin/config_message/SetSmsTemplate` | [data/route/admin.php:366](../../data/route/admin.php#L366) |
| POST | `{A}/config_message/set_sms_post` | `admin/config_message/SetSmsTemplatePost` | [data/route/admin.php:367](../../data/route/admin.php#L367) |
| POST | `{A}/config_message/test_message_template` | `admin/config_message/testMessageTemplate` | [data/route/admin.php:368](../../data/route/admin.php#L368) |
| GET | `{A}/config_message/test_message_template_page` | `admin/config_message/testMessageTemplatePage` | [data/route/admin.php:369](../../data/route/admin.php#L369) |
| POST | `{A}/config_message/send_sms` | `admin/config_message/sendSmsTest` | [data/route/admin.php:370](../../data/route/admin.php#L370) |
| GET | `{A}/config_message/mobiletemplate_list` | `admin/config_message/mobiletemplateList` | [data/route/admin.php:371](../../data/route/admin.php#L371) |
| GET | `{A}/email_template/emailtemplate_list` | `admin/config_message/emailtemplateList` | [data/route/admin.php:372](../../data/route/admin.php#L372) |
| POST | `{A}/config_message/sendmessage_post` | `admin/config_message/sendMessagePost` | [data/route/admin.php:373](../../data/route/admin.php#L373) |
| POST | `{A}/config_message/send_email` | `admin/config_message/sendEmailTest` | [data/route/admin.php:374](../../data/route/admin.php#L374) |
| GET | `{A}/config_message/get_template_desc` | `admin/config_message/getTemplateDesc` | [data/route/admin.php:375](../../data/route/admin.php#L375) |
| GET | `{A}/client_care/search_condition` | `admin/client_care/searchCondition` | [data/route/admin.php:376](../../data/route/admin.php#L376) |
| GET | `{A}/client_care/care_list` | `admin/client_care/careList` | [data/route/admin.php:377](../../data/route/admin.php#L377) |
| GET | `{A}/client_care/create_care` | `admin/client_care/createCare` | [data/route/admin.php:378](../../data/route/admin.php#L378) |
| POST | `{A}/client_care/create_care_post` | `admin/client_care/createCarePost` | [data/route/admin.php:379](../../data/route/admin.php#L379) |
| GET | `{A}/client_care/edit_care/:id` | `admin/client_care/editCare` | [data/route/admin.php:380](../../data/route/admin.php#L380) |
| POST | `{A}/client_care/edit_care_post` | `admin/client_care/editCare` | [data/route/admin.php:381](../../data/route/admin.php#L381) |
| GET | `{A}/client_care/delete_care/:id` | `admin/client_care/deleteCare` | [data/route/admin.php:382](../../data/route/admin.php#L382) |
| GET | `{A}/client_care/test` | `admin/client_care/test` | [data/route/admin.php:383](../../data/route/admin.php#L383) |
| GET | `{A}/contract/setting` | `admin/contract/setting` | [data/route/admin.php:384](../../data/route/admin.php#L384) |
| POST | `{A}/contract/setting` | `admin/contract/settingPost` | [data/route/admin.php:385](../../data/route/admin.php#L385) |
| GET | `{A}/contract/detail/[:id]` | `admin/contract/detail` | [data/route/admin.php:386](../../data/route/admin.php#L386) |
| POST | `{A}/contract/detail/[:id]` | `admin/contract/detailPost` | [data/route/admin.php:387](../../data/route/admin.php#L387) |
| GET | `{A}/contract/tpl` | `admin/contract/tpl` | [data/route/admin.php:388](../../data/route/admin.php#L388) |
| DELETE | `{A}/contract/tpl/:id` | `admin/contract/deleteTpl` | [data/route/admin.php:389](../../data/route/admin.php#L389) |
| GET | `{A}/contract/contract` | `admin/contract/contract` | [data/route/admin.php:390](../../data/route/admin.php#L390) |
| POST | `{A}/contract/cancel` | `admin/contract/cancel` | [data/route/admin.php:391](../../data/route/admin.php#L391) |
| GET | `{A}/contract/download/:id` | `admin/contract/download` | [data/route/admin.php:392](../../data/route/admin.php#L392) |
| POST | `{A}/contract/contract/:id` | `admin/contract/contractPost` | [data/route/admin.php:393](../../data/route/admin.php#L393) |
| POST | `{A}/contract/cancel_post/:id` | `admin/contract/cancelPost` | [data/route/admin.php:394](../../data/route/admin.php#L394) |
| POST | `{A}/contract/check` | `admin/contract/check` | [data/route/admin.php:395](../../data/route/admin.php#L395) |
| POST | `{A}/contract/delete` | `admin/contract/delete` | [data/route/admin.php:396](../../data/route/admin.php#L396) |
| GET | `{A}/contract/contract_page` | `admin/contract/contractPage` | [data/route/admin.php:397](../../data/route/admin.php#L397) |
| POST | `{A}/contract/contract_page/:id` | `admin/contract/contractPagePost` | [data/route/admin.php:398](../../data/route/admin.php#L398) |
| GET | `{A}/report/base_info` | `admin/report/baseInfo` | [data/route/admin.php:399](../../data/route/admin.php#L399) |
| GET | `{A}/report/get_base_module` | `admin/report/getSystemInfoModulesList` | [data/route/admin.php:400](../../data/route/admin.php#L400) |
| POST | `{A}/report/update_base_module` | `admin/report/updateSystemInfoModulesSort` | [data/route/admin.php:401](../../data/route/admin.php#L401) |
| GET | `{A}/year_reports` | `admin/reports/getYearIncomeStatistics` | [data/route/admin.php:402](../../data/route/admin.php#L402) |
| GET | `{A}/year_reports_chart` | `admin/reports/getYearIncomeStatisticsForChart` | [data/route/admin.php:403](../../data/route/admin.php#L403) |
| GET | `{A}/new_client` | `admin/reports/getNewClientStatistics` | [data/route/admin.php:404](../../data/route/admin.php#L404) |
| GET | `{A}/forward_client` | `admin/reports/rankForwardClient` | [data/route/admin.php:405](../../data/route/admin.php#L405) |
| GET | `{A}/product_income` | `admin/reports/productIncome` | [data/route/admin.php:406](../../data/route/admin.php#L406) |
| GET | `{A}/servers_list` | `admin/config_servers/serversList` | [data/route/admin.php:407](../../data/route/admin.php#L407) |
| GET | `{A}/servers_list` | `admin/config_servers/serversList` | [data/route/admin.php:408](../../data/route/admin.php#L408) |
| GET | `{A}/product_list_page` | `admin/product/getProuductlistPage` | [data/route/admin.php:409](../../data/route/admin.php#L409) |
| POST | `{A}/update_firstgroupsort` | `admin/product/updateFirstGroupsort` | [data/route/admin.php:410](../../data/route/admin.php#L410) |
| POST | `{A}/update_groupsort` | `admin/product/updateGroupsort` | [data/route/admin.php:411](../../data/route/admin.php#L411) |
| POST | `{A}/update_productsort` | `admin/product/updateProductsort` | [data/route/admin.php:412](../../data/route/admin.php#L412) |
| GET | `{A}/edit_product_first_group_page` | `admin/product/editFirstGroupPage` | [data/route/admin.php:413](../../data/route/admin.php#L413) |
| POST | `{A}/save_product_first_group` | `admin/product/saveProductFirstGroup` | [data/route/admin.php:414](../../data/route/admin.php#L414) |
| GET | `{A}/edit_product_group_page` | `admin/product/editGroupPage` | [data/route/admin.php:415](../../data/route/admin.php#L415) |
| POST | `{A}/save_product_group` | `admin/product/saveProductGroup` | [data/route/admin.php:416](../../data/route/admin.php#L416) |
| POST | `{A}/check_product_as` | `admin/product/checkAlias` | [data/route/admin.php:417](../../data/route/admin.php#L417) |
| GET | `{A}/del_product` | `admin/product/delete` | [data/route/admin.php:418](../../data/route/admin.php#L418) |
| GET | `{A}/del_product_group` | `admin/product/deleteGroup` | [data/route/admin.php:419](../../data/route/admin.php#L419) |
| GET | `{A}/del_product_first_group` | `admin/product/deleteFirstGroup` | [data/route/admin.php:420](../../data/route/admin.php#L420) |
| GET | `{A}/add_product_page` | `admin/product/addPage` | [data/route/admin.php:421](../../data/route/admin.php#L421) |
| POST | `{A}/create_product` | `admin/product/create` | [data/route/admin.php:422](../../data/route/admin.php#L422) |
| GET | `{A}/product_duplicate_page` | `admin/product/duplicatePage` | [data/route/admin.php:423](../../data/route/admin.php#L423) |
| POST | `{A}/product_duplicate` | `admin/product/duplicate` | [data/route/admin.php:424](../../data/route/admin.php#L424) |
| GET | `{A}/edit_product_page/:id` | `admin/product/editPage` | [data/route/admin.php:425](../../data/route/admin.php#L425) |
| POST | `{A}/edit_product` | `admin/product/edit` | [data/route/admin.php:426](../../data/route/admin.php#L426) |
| ANY | `{A}/edit_stock` | `admin/product/editStock` | [data/route/admin.php:427](../../data/route/admin.php#L427) |
| POST | `{A}/product_manage_downloads` | `admin/product/managedownloads` | [data/route/admin.php:428](../../data/route/admin.php#L428) |
| GET | `{A}/product_downloadcates` | `admin/product/downloadcates` | [data/route/admin.php:429](../../data/route/admin.php#L429) |
| GET | `{A}/product_selectcates` | `admin/product/selectcates` | [data/route/admin.php:430](../../data/route/admin.php#L430) |
| POST | `{A}/product_del_custom` | `admin/product/delCustomField` | [data/route/admin.php:431](../../data/route/admin.php#L431) |
| GET | `{A}/get_api_list` | `admin/product/getApiList` | [data/route/admin.php:432](../../data/route/admin.php#L432) |
| GET | `{A}/get_upstream_products` | `admin/product/getUpstreamProducts` | [data/route/admin.php:433](../../data/route/admin.php#L433) |
| GET | `{A}/product/productgroup` | `admin/product/groupList` | [data/route/admin.php:434](../../data/route/admin.php#L434) |
| GET | `{A}/product/add_productgrouppage` | `admin/product/addProductgroupPage` | [data/route/admin.php:435](../../data/route/admin.php#L435) |
| ANY | `{A}/product/add_productgroup` | `admin/product/addProductgroup` | [data/route/admin.php:436](../../data/route/admin.php#L436) |
| GET | `{A}/product/edit_productgrouppage` | `admin/product/editProductgroupPage` | [data/route/admin.php:437](../../data/route/admin.php#L437) |
| ANY | `{A}/product/edit_productgroup` | `admin/product/editProductgroup` | [data/route/admin.php:438](../../data/route/admin.php#L438) |
| GET | `{A}/product/del_productgroup` | `admin/product/delProductgroup` | [data/route/admin.php:439](../../data/route/admin.php#L439) |
| GET | `{A}/product/zklist_page` | `admin/product/zklistPage` | [data/route/admin.php:440](../../data/route/admin.php#L440) |
| ANY | `{A}/product/edit_userproductgroup` | `admin/product/editUserProductgroup` | [data/route/admin.php:441](../../data/route/admin.php#L441) |
| GET | `{A}/product/select_type` | `admin/product/selectType` | [data/route/admin.php:442](../../data/route/admin.php#L442) |
| POST | `{A}/product/sync_product_info` | `admin/product/syncProductInfo` | [data/route/admin.php:443](../../data/route/admin.php#L443) |
| GET | `{A}/product/get_upstream_price` | `admin/product/getUpstreamPrice` | [data/route/admin.php:444](../../data/route/admin.php#L444) |
| GET | `{A}/add_promo_code/page` | `admin/promo_code/addPage` | [data/route/admin.php:445](../../data/route/admin.php#L445) |
| POST | `{A}/add_promo_code` | `admin/promo_code/add` | [data/route/admin.php:446](../../data/route/admin.php#L446) |
| GET | `{A}/save_promo_code/page` | `admin/promo_code/savePage` | [data/route/admin.php:447](../../data/route/admin.php#L447) |
| POST | `{A}/save_promo_code` | `admin/promo_code/save` | [data/route/admin.php:448](../../data/route/admin.php#L448) |
| POST | `{A}/delete_promo_code` | `admin/promo_code/delete` | [data/route/admin.php:449](../../data/route/admin.php#L449) |
| POST | `{A}/expired_promo_code` | `admin/promo_code/expireImmediately` | [data/route/admin.php:450](../../data/route/admin.php#L450) |
| GET | `{A}/list_promo_code` | `admin/promo_code/getList` | [data/route/admin.php:451](../../data/route/admin.php#L451) |
| GET | `{A}/auto_promo_code` | `admin/promo_code/autoPromoCode` | [data/route/admin.php:452](../../data/route/admin.php#L452) |
| GET | `{A}/list_promo_code/:id` | `admin/promo_code/getDetail` | [data/route/admin.php:453](../../data/route/admin.php#L453) |
| GET | `{A}/get_ticket_department` | `admin/ticket_department/addPage` | [data/route/admin.php:454](../../data/route/admin.php#L454) |
| POST | `{A}/add_ticket_department` | `admin/ticket_department/add` | [data/route/admin.php:455](../../data/route/admin.php#L455) |
| POST | `{A}/save_ticket_department` | `admin/ticket_department/save` | [data/route/admin.php:456](../../data/route/admin.php#L456) |
| POST | `{A}/delete_ticket_department` | `admin/ticket_department/delete` | [data/route/admin.php:457](../../data/route/admin.php#L457) |
| POST | `{A}/movedown_ticket_department` | `admin/ticket_department/moveDown` | [data/route/admin.php:458](../../data/route/admin.php#L458) |
| POST | `{A}/moveup_ticket_department` | `admin/ticket_department/moveUp` | [data/route/admin.php:459](../../data/route/admin.php#L459) |
| GET | `{A}/list_ticket_department` | `admin/ticket_department/getList` | [data/route/admin.php:460](../../data/route/admin.php#L460) |
| GET | `{A}/list_ticket_department/:id` | `admin/ticket_department/getDetail` | [data/route/admin.php:461](../../data/route/admin.php#L461) |
| POST | `{A}/add_ticket_status` | `admin/ticket_status/add` | [data/route/admin.php:462](../../data/route/admin.php#L462) |
| POST | `{A}/save_ticket_status` | `admin/ticket_status/save` | [data/route/admin.php:463](../../data/route/admin.php#L463) |
| POST | `{A}/delete_ticket_status` | `admin/ticket_status/delete` | [data/route/admin.php:464](../../data/route/admin.php#L464) |
| GET | `{A}/list_ticket_status` | `admin/ticket_status/getList` | [data/route/admin.php:465](../../data/route/admin.php#L465) |
| GET | `{A}/list_ticket_status/:id` | `admin/ticket_status/getDetail` | [data/route/admin.php:466](../../data/route/admin.php#L466) |
| GET | `{A}/get_custom_param_type` | `admin/ticket_department/getCustomParamType` | [data/route/admin.php:467](../../data/route/admin.php#L467) |
| GET | `{A}/add_ticket_custom_param` | `admin/ticket_department/addTicketCustomParam` | [data/route/admin.php:468](../../data/route/admin.php#L468) |
| GET | `{A}/get_ticket_param_val` | `admin/ticket_department/getTicketParamVal` | [data/route/admin.php:469](../../data/route/admin.php#L469) |
| GET | `{A}/edit_ticket_custom_param` | `admin/ticket_department/editTicketCustomParam` | [data/route/admin.php:470](../../data/route/admin.php#L470) |
| GET | `{A}/del_ticket_custom_param` | `admin/ticket_department/delTicketCustomParam` | [data/route/admin.php:471](../../data/route/admin.php#L471) |
| GET | `{A}/get_ticket_deliver` | `admin/ticket_deliver/addPage` | [data/route/admin.php:472](../../data/route/admin.php#L472) |
| POST | `{A}/add_ticket_deliver` | `admin/ticket_deliver/add` | [data/route/admin.php:473](../../data/route/admin.php#L473) |
| POST | `{A}/save_ticket_deliver` | `admin/ticket_deliver/save` | [data/route/admin.php:474](../../data/route/admin.php#L474) |
| POST | `{A}/delete_ticket_deliver` | `admin/ticket_deliver/delete` | [data/route/admin.php:475](../../data/route/admin.php#L475) |
| GET | `{A}/list_ticket_deliver` | `admin/ticket_deliver/getList` | [data/route/admin.php:476](../../data/route/admin.php#L476) |
| GET | `{A}/ticket_prereply_list` | `admin/ticket_prereply/replyList` | [data/route/admin.php:477](../../data/route/admin.php#L477) |
| POST | `{A}/add_ticket_prereply_category` | `admin/ticket_prereply/addCategory` | [data/route/admin.php:478](../../data/route/admin.php#L478) |
| GET | `{A}/add_ticket_prereply_category/page` | `admin/ticket_prereply/editCategoryPage` | [data/route/admin.php:479](../../data/route/admin.php#L479) |
| POST | `{A}/save_ticket_prereply_category` | `admin/ticket_prereply/editCategory` | [data/route/admin.php:480](../../data/route/admin.php#L480) |
| GET | `{A}/delete_ticket_prereply_category/:id` | `admin/ticket_prereply/deleteCategory` | [data/route/admin.php:481](../../data/route/admin.php#L481) |
| GET | `{A}/add_ticket_prereply/page` | `admin/ticket_prereply/addPrereplyPage` | [data/route/admin.php:482](../../data/route/admin.php#L482) |
| POST | `{A}/add_ticket_prereply` | `admin/ticket_prereply/addPrereply` | [data/route/admin.php:483](../../data/route/admin.php#L483) |
| GET | `{A}/save_ticket_prereply/page` | `admin/ticket_prereply/savePrereplyPage` | [data/route/admin.php:484](../../data/route/admin.php#L484) |
| POST | `{A}/save_ticket_prereply` | `admin/ticket_prereply/savePrereply` | [data/route/admin.php:485](../../data/route/admin.php#L485) |
| POST | `{A}/search_ticket_prereply` | `admin/ticket_prereply/searchPrereply` | [data/route/admin.php:486](../../data/route/admin.php#L486) |
| DELETE | `{A}/ticket_prereply/:id/` | `admin/ticket_prereply/deletePrereply` | [data/route/admin.php:487](../../data/route/admin.php#L487) |
| GET | `{A}/add_ticket_page` | `admin/ticket/createPage` | [data/route/admin.php:488](../../data/route/admin.php#L488) |
| POST | `{A}/add_ticket` | `admin/ticket/add` | [data/route/admin.php:489](../../data/route/admin.php#L489) |
| GET | `{A}/list_ticket` | `admin/ticket/getList` | [data/route/admin.php:490](../../data/route/admin.php#L490) |
| GET | `{A}/ticket_detail_host` | `admin/ticket/getTicketDetailHost` | [data/route/admin.php:491](../../data/route/admin.php#L491) |
| POST | `{A}/reply_ticket` | `admin/ticket/reply` | [data/route/admin.php:492](../../data/route/admin.php#L492) |
| POST | `{A}/merge_ticket` | `admin/ticket/mergeTicket` | [data/route/admin.php:493](../../data/route/admin.php#L493) |
| POST | `{A}/close_ticket` | `admin/ticket/closeTicket` | [data/route/admin.php:494](../../data/route/admin.php#L494) |
| POST | `{A}/delete_ticket` | `admin/ticket/deleteTicket` | [data/route/admin.php:495](../../data/route/admin.php#L495) |
| POST | `{A}/add_ticket_note` | `admin/ticket/addNote` | [data/route/admin.php:496](../../data/route/admin.php#L496) |
| POST | `{A}/save_ticket_reply` | `admin/ticket/saveReply` | [data/route/admin.php:497](../../data/route/admin.php#L497) |
| POST | `{A}/delete_ticket_note` | `admin/ticket/deleteNote` | [data/route/admin.php:498](../../data/route/admin.php#L498) |
| POST | `{A}/delete_ticket_reply` | `admin/ticket/deleteReply` | [data/route/admin.php:499](../../data/route/admin.php#L499) |
| POST | `{A}/delete_ticket_attachment` | `admin/ticket/deleteAttachment` | [data/route/admin.php:500](../../data/route/admin.php#L500) |
| GET | `{A}/download_ticket_attachment` | `admin/ticket/downloadAttachment` | [data/route/admin.php:501](../../data/route/admin.php#L501) |
| GET | `{A}/list_ticket/:id` | `admin/ticket/ticketDetail` | [data/route/admin.php:502](../../data/route/admin.php#L502) |
| POST | `{A}/save_ticket` | `admin/ticket/saveTicket` | [data/route/admin.php:503](../../data/route/admin.php#L503) |
| GET | `{A}/client_ticket` | `admin/ticket/getClientTicketPage` | [data/route/admin.php:504](../../data/route/admin.php#L504) |
| GET | `{A}/ticket_statistics` | `admin/ticket/ticketStatistics` | [data/route/admin.php:505](../../data/route/admin.php#L505) |
| PUT | `{A}/ticket_receive` | `admin/ticket/ticketReceive` | [data/route/admin.php:506](../../data/route/admin.php#L506) |
| GET | `{A}/ticket_transfer_list` | `admin/ticket/ticketTransferList` | [data/route/admin.php:507](../../data/route/admin.php#L507) |
| PUT | `{A}/ticket_transfer` | `admin/ticket/ticketTransfer` | [data/route/admin.php:508](../../data/route/admin.php#L508) |
| GET | `{A}/cron_page` | `admin/cron/detail` | [data/route/admin.php:509](../../data/route/admin.php#L509) |
| POST | `{A}/save_cron` | `admin/cron/saveCron` | [data/route/admin.php:510](../../data/route/admin.php#L510) |
| POST | `{A}/invoices_createnew` | `admin/invoice/createRenew` | [data/route/admin.php:511](../../data/route/admin.php#L511) |
| GET | `{A}/get_combine_invoices` | `admin/invoice/getCombineInvoices` | [data/route/admin.php:512](../../data/route/admin.php#L512) |
| POST | `{A}/combine_invoices` | `admin/invoice/combineInvoices` | [data/route/admin.php:513](../../data/route/admin.php#L513) |
| GET | `{A}/order/search_page` | `admin/order/searchPage` | [data/route/admin.php:514](../../data/route/admin.php#L514) |
| GET | `{A}/order/search` | `admin/order/index` | [data/route/admin.php:515](../../data/route/admin.php#L515) |
| POST | `{A}/order/order_commission` | `admin/order/indexPost` | [data/route/admin.php:516](../../data/route/admin.php#L516) |
| GET | `{A}/order/saleorder` | `admin/order/indexSale` | [data/route/admin.php:517](../../data/route/admin.php#L517) |
| GET | `{A}/order/check` | `admin/order/check` | [data/route/admin.php:518](../../data/route/admin.php#L518) |
| GET | `{A}/order/cancel` | `admin/order/cancel` | [data/route/admin.php:519](../../data/route/admin.php#L519) |
| DELETE | `{A}/orders/delete` | `admin/order/delete` | [data/route/admin.php:520](../../data/route/admin.php#L520) |
| GET | `{A}/order/create_page` | `admin/order/createPage` | [data/route/admin.php:521](../../data/route/admin.php#L521) |
| GET | `{A}/order/getclients` | `admin/order/getClients` | [data/route/admin.php:522](../../data/route/admin.php#L522) |
| POST | `{A}/order/create` | `admin/order/save` | [data/route/admin.php:523](../../data/route/admin.php#L523) |
| GET | `{A}/orders/set_config` | `admin/Order/setConfig` | [data/route/admin.php:524](../../data/route/admin.php#L524) |
| POST | `{A}/orders_search` | `admin/Order/search` | [data/route/admin.php:525](../../data/route/admin.php#L525) |
| POST | `{A}/get_total` | `admin/Order/getMultiTotal` | [data/route/admin.php:526](../../data/route/admin.php#L526) |
| GET | `{A}/orders/:id` | `admin/Order/read` | [data/route/admin.php:527](../../data/route/admin.php#L527) |
| POST | `{A}/orders/notes` | `admin/Order/notes` | [data/route/admin.php:528](../../data/route/admin.php#L528) |
| POST | `{A}/orders/active` | `admin/Order/active` | [data/route/admin.php:529](../../data/route/admin.php#L529) |
| POST | `{A}/orders/change_status` | `admin/Order/changeStatus` | [data/route/admin.php:530](../../data/route/admin.php#L530) |
| GET | `{A}/order/promo_code_page` | `admin/Order/customPromoPage` | [data/route/admin.php:531](../../data/route/admin.php#L531) |
| POST | `{A}/order/save_promo_code` | `admin/Order/customPromo` | [data/route/admin.php:532](../../data/route/admin.php#L532) |
| GET | `{A}/invoice/search_page` | `admin/invoice/searchPage` | [data/route/admin.php:533](../../data/route/admin.php#L533) |
| GET | `{A}/invoice/index` | `admin/invoice/index` | [data/route/admin.php:534](../../data/route/admin.php#L534) |
| GET | `{A}/invoice/paid` | `admin/invoice/paid` | [data/route/admin.php:535](../../data/route/admin.php#L535) |
| GET | `{A}/invoice/unpaid` | `admin/invoice/unpaid` | [data/route/admin.php:536](../../data/route/admin.php#L536) |
| GET | `{A}/invoice/cancelled` | `admin/invoice/cancelled` | [data/route/admin.php:537](../../data/route/admin.php#L537) |
| DELETE | `{A}/invoice/delete` | `admin/invoice/delete` | [data/route/admin.php:538](../../data/route/admin.php#L538) |
| GET | `{A}/invoice/duplicate` | `admin/invoice/duplicate` | [data/route/admin.php:539](../../data/route/admin.php#L539) |
| GET | `{A}/invoice/summary/:id` | `admin/invoice/summary` | [data/route/admin.php:540](../../data/route/admin.php#L540) |
| GET | `{A}/invoice/addpay_page/:id` | `admin/invoice/addPayPage` | [data/route/admin.php:541](../../data/route/admin.php#L541) |
| POST | `{A}/invoice/addpay` | `admin/invoice/addPay` | [data/route/admin.php:542](../../data/route/admin.php#L542) |
| GET | `{A}/invoice/option_page/:id` | `admin/invoice/optionPage` | [data/route/admin.php:543](../../data/route/admin.php#L543) |
| POST | `{A}/invoice/option` | `admin/invoice/option` | [data/route/admin.php:544](../../data/route/admin.php#L544) |
| GET | `{A}/invoice/add_pay_invoice_page/:id` | `admin/invoice/addPayInvoicePage` | [data/route/admin.php:545](../../data/route/admin.php#L545) |
| POST | `{A}/invoice/add_pay_invoice` | `admin/invoice/addPayInvoice` | [data/route/admin.php:546](../../data/route/admin.php#L546) |
| POST | `{A}/invoice/apply_credit_limit` | `admin/invoice/applyCreditLimit` | [data/route/admin.php:547](../../data/route/admin.php#L547) |
| POST | `{A}/invoice/delete_pay_invoice` | `admin/invoice/deletePayInvoice` | [data/route/admin.php:548](../../data/route/admin.php#L548) |
| GET | `{A}/invoice/refund_page` | `admin/invoice/refundPage` | [data/route/admin.php:549](../../data/route/admin.php#L549) |
| POST | `{A}/invoice/refund` | `admin/invoice/refund` | [data/route/admin.php:550](../../data/route/admin.php#L550) |
| GET | `{A}/invoice/notes_page` | `admin/invoice/notesPage` | [data/route/admin.php:551](../../data/route/admin.php#L551) |
| POST | `{A}/invoice/notes` | `admin/invoice/notes` | [data/route/admin.php:552](../../data/route/admin.php#L552) |
| POST | `{A}/invoice/email` | `admin/Invoice/invoceEmail` | [data/route/admin.php:553](../../data/route/admin.php#L553) |
| POST | `{A}/invoice/edit_item` | `admin/invoice/editItem` | [data/route/admin.php:554](../../data/route/admin.php#L554) |
| DELETE | `{A}/invoice/delete_item` | `admin/invoice/deleteItems` | [data/route/admin.php:555](../../data/route/admin.php#L555) |
| DELETE | `{A}/invoice/delete_account/:id` | `admin/invoice/delAccount` | [data/route/admin.php:556](../../data/route/admin.php#L556) |
| GET | `{A}/invoice/renew` | `admin/invoice/renew` | [data/route/admin.php:557](../../data/route/admin.php#L557) |
| GET | `{A}/invoice/log_list` | `admin/invoice/invoiceLog` | [data/route/admin.php:558](../../data/route/admin.php#L558) |
| GET | `{A}/search_page` | `admin/account/searchPage` | [data/route/admin.php:559](../../data/route/admin.php#L559) |
| GET | `{A}/accounts` | `admin/account/index` | [data/route/admin.php:560](../../data/route/admin.php#L560) |
| GET | `{A}/accounts/create` | `admin/account/create` | [data/route/admin.php:561](../../data/route/admin.php#L561) |
| GET | `{A}/accounts/createinvoice` | `admin/account/createInvoice` | [data/route/admin.php:562](../../data/route/admin.php#L562) |
| POST | `{A}/accounts` | `admin/account/save` | [data/route/admin.php:563](../../data/route/admin.php#L563) |
| GET | `{A}/accounts/:id` | `admin/account/read` | [data/route/admin.php:564](../../data/route/admin.php#L564) |
| PUT | `{A}/accounts/:id` | `admin/account/update` | [data/route/admin.php:565](../../data/route/admin.php#L565) |
| DELETE | `{A}/accounts/:id` | `admin/account/delete` | [data/route/admin.php:566](../../data/route/admin.php#L566) |
| POST | `{A}/accounts_search` | `admin/account/search` | [data/route/admin.php:567](../../data/route/admin.php#L567) |
| RESOURCE | `{A}/credit` | `admin/Credit` | [data/route/admin.php:568](../../data/route/admin.php#L568) |
| POST | `{A}/credit/reduce` | `admin/credit/reduce` | [data/route/admin.php:569](../../data/route/admin.php#L569) |
| GET | `{A}/credit_limit` | `admin/credit_limit/index` | [data/route/admin.php:570](../../data/route/admin.php#L570) |
| GET | `{A}/credit_limit/log` | `admin/credit_limit/log` | [data/route/admin.php:571](../../data/route/admin.php#L571) |
| POST | `{A}/credit_limit` | `admin/credit_limit/save` | [data/route/admin.php:572](../../data/route/admin.php#L572) |
| PUT | `{A}/credit_limit` | `admin/credit_limit/update` | [data/route/admin.php:573](../../data/route/admin.php#L573) |
| DELETE | `{A}/credit_limit` | `admin/credit_limit/delete` | [data/route/admin.php:574](../../data/route/admin.php#L574) |
| GET | `{A}/credit_limit/list` | `admin/credit_limit/list` | [data/route/admin.php:575](../../data/route/admin.php#L575) |
| GET | `{A}/credit_limit/user_invoice` | `admin/credit_limit/userInvoice` | [data/route/admin.php:576](../../data/route/admin.php#L576) |
| GET | `{A}/credit_limit/user_invoice_detail` | `admin/credit_limit/creditLimitInvoice` | [data/route/admin.php:577](../../data/route/admin.php#L577) |
| GET | `{A}/credit_limit/client_list` | `admin/credit_limit/clientList` | [data/route/admin.php:578](../../data/route/admin.php#L578) |
| GET | `{A}/credit_limit/config` | `admin/credit_limit/getConfig` | [data/route/admin.php:579](../../data/route/admin.php#L579) |
| POST | `{A}/credit_limit/config` | `admin/credit_limit/postConfig` | [data/route/admin.php:580](../../data/route/admin.php#L580) |
| RESOURCE | `{A}/user_remark` | `admin/UserRemark` | [data/route/admin.php:581](../../data/route/admin.php#L581) |
| CONTROLLER | `{A}/downloads` | `admin/Downloads` | [data/route/admin.php:582](../../data/route/admin.php#L582) |
| DELETE | `{A}/downloads/cat/:id` | `admin/Downloads/deleteCat` | [data/route/admin.php:583](../../data/route/admin.php#L583) |
| GET | `{A}/downloads/edit/:id` | `admin/Downloads/getEdit` | [data/route/admin.php:584](../../data/route/admin.php#L584) |
| DELETE | `{A}/downloads/file` | `admin/Downloads/deleteFile` | [data/route/admin.php:585](../../data/route/admin.php#L585) |
| GET | `{A}/downloads/file/id/:id` | `admin/Downloads/getFile` | [data/route/admin.php:586](../../data/route/admin.php#L586) |
| POST | `{A}/downloads/savefile` | `admin/Downloads/postSaveFile` | [data/route/admin.php:587](../../data/route/admin.php#L587) |
| GET | `{A}/downloads/userdownlist` | `admin/Downloads/getUserDownList` | [data/route/admin.php:588](../../data/route/admin.php#L588) |
| GET | `{A}/downloads/getuserfile` | `admin/Downloads/getUserFile` | [data/route/admin.php:589](../../data/route/admin.php#L589) |
| POST | `{A}/downloads/uploaduserfile` | `admin/Downloads/postUploadUserFile` | [data/route/admin.php:590](../../data/route/admin.php#L590) |
| GET | `{A}/downloads/userfile` | `admin/Downloads/deleteUserFile` | [data/route/admin.php:591](../../data/route/admin.php#L591) |
| POST | `{A}/downloads/adduserfile` | `admin/Downloads/postAddUserFile` | [data/route/admin.php:592](../../data/route/admin.php#L592) |
| GET | `{A}/downloads/userfilepage` | `admin/Downloads/getUserFilePage` | [data/route/admin.php:593](../../data/route/admin.php#L593) |
| POST | `{A}/downloads/saveuserfile` | `admin/Downloads/postSaveUserFile` | [data/route/admin.php:594](../../data/route/admin.php#L594) |
| CONTROLLER | `{A}/announce` | `admin/Announce` | [data/route/admin.php:595](../../data/route/admin.php#L595) |
| CONTROLLER | `{A}/news` | `admin/News` | [data/route/admin.php:596](../../data/route/admin.php#L596) |
| CONTROLLER | `{A}/demo` | `admin/Demo` | [data/route/admin.php:597](../../data/route/admin.php#L597) |
| CONTROLLER | `{A}/clients_services` | `admin/ClientsServices` | [data/route/admin.php:598](../../data/route/admin.php#L598) |
| GET | `{A}/clients_services` | `admin/ClientsServices/index` | [data/route/admin.php:599](../../data/route/admin.php#L599) |
| GET | `{A}/clients_services/get_product_list` | `admin/clients_services/getProductList` | [data/route/admin.php:600](../../data/route/admin.php#L600) |
| GET | `{A}/clients_services/host_renew` | `admin/clients_services/hostRenew` | [data/route/admin.php:601](../../data/route/admin.php#L601) |
| POST | `{A}/clients_services/host_batch_renew_page` | `admin/clients_services/postBatchRenewPage` | [data/route/admin.php:602](../../data/route/admin.php#L602) |
| POST | `{A}/clients_services/host_batch_renew` | `admin/clients_services/postBatchRenew` | [data/route/admin.php:603](../../data/route/admin.php#L603) |
| GET | `{A}/clients_services/apply_credit_page` | `admin/clients_services/getApplyCreditPage` | [data/route/admin.php:604](../../data/route/admin.php#L604) |
| POST | `{A}/clients_services/apply_credit` | `admin/clients_services/applyCredit` | [data/route/admin.php:605](../../data/route/admin.php#L605) |
| GET | `{A}/clients_services/host_suspend` | `admin/clients_services/suspendPage` | [data/route/admin.php:606](../../data/route/admin.php#L606) |
| POST | `{A}/clients_services/host_suspend` | `admin/clients_services/suspend` | [data/route/admin.php:607](../../data/route/admin.php#L607) |
| POST | `{A}/clients_services/upgrade_config` | `admin/clients_services/upgradeConfig` | [data/route/admin.php:608](../../data/route/admin.php#L608) |
| POST | `{A}/clients_services/upgrade_product` | `admin/clients_services/upgradeProduct` | [data/route/admin.php:609](../../data/route/admin.php#L609) |
| GET | `{A}/clients_services/refund_page` | `admin/clients_services/getRefundPage` | [data/route/admin.php:610](../../data/route/admin.php#L610) |
| POST | `{A}/clients_services/refund` | `admin/clients_services/refund` | [data/route/admin.php:611](../../data/route/admin.php#L611) |
| GET | `{A}/adminGetLinkAgeList` | `admin/clients_services/adminGetLinkAgeList` | [data/route/admin.php:612](../../data/route/admin.php#L612) |
| CONTROLLER | `{A}/cancel_request` | `admin/CancelRequest` | [data/route/admin.php:613](../../data/route/admin.php#L613) |
| CONTROLLER | `{A}/host` | `admin/Host` | [data/route/admin.php:614](../../data/route/admin.php#L614) |
| GET | `{A}/host/get_timetype` | `admin/Host/getTimetype` | [data/route/admin.php:615](../../data/route/admin.php#L615) |
| POST | `{A}/host/userInfo` | `admin/Host/userInfo` | [data/route/admin.php:616](../../data/route/admin.php#L616) |
| CONTROLLER | `{A}/send_message` | `admin/SendMessage` | [data/route/admin.php:617](../../data/route/admin.php#L617) |
| CONTROLLER | `{A}/client_contacts` | `admin/ClientsContacts` | [data/route/admin.php:618](../../data/route/admin.php#L618) |
| CONTROLLER | `{A}/system` | `admin/System` | [data/route/admin.php:619](../../data/route/admin.php#L619) |
| GET | `{A}/log_record/systemlog` | `admin/log_record/getSystemLog` | [data/route/admin.php:620](../../data/route/admin.php#L620) |
| GET | `{A}/log_record/cronsystemlog` | `admin/log_record/getCronSystemLog` | [data/route/admin.php:621](../../data/route/admin.php#L621) |
| GET | `{A}/log_record/adminlog` | `admin/log_record/getAdminLog` | [data/route/admin.php:622](../../data/route/admin.php#L622) |
| GET | `{A}/log_record/userlog` | `admin/log_record/getUserLog` | [data/route/admin.php:623](../../data/route/admin.php#L623) |
| GET | `{A}/log_record/notifylog` | `admin/log_record/getNotifyLog` | [data/route/admin.php:624](../../data/route/admin.php#L624) |
| GET | `{A}/log_record/emaillog` | `admin/log_record/getEmailLog` | [data/route/admin.php:625](../../data/route/admin.php#L625) |
| GET | `{A}/log_record/emaildetail/:id` | `admin/log_record/getEmailDetail` | [data/route/admin.php:626](../../data/route/admin.php#L626) |
| GET | `{A}/log_record/smslog` | `admin/log_record/getSmsLog` | [data/route/admin.php:627](../../data/route/admin.php#L627) |
| GET | `{A}/log_record/smslogm` | `admin/log_record/getSmsLogM` | [data/route/admin.php:628](../../data/route/admin.php#L628) |
| GET | `{A}/log_record/system_message_log` | `admin/log_record/getSystemMessageLog` | [data/route/admin.php:629](../../data/route/admin.php#L629) |
| GET | `{A}/log_record/api_log` | `admin/log_record/getApiLog` | [data/route/admin.php:630](../../data/route/admin.php#L630) |
| GET | `{A}/log_record/delete_log_page` | `admin/log_record/getDeleteLogPage` | [data/route/admin.php:631](../../data/route/admin.php#L631) |
| GET | `{A}/log_record/affirm_delete_log_page` | `admin/log_record/getAffirmDeleteLogPage` | [data/route/admin.php:632](../../data/route/admin.php#L632) |
| DELETE | `{A}/log_record/delete_log` | `admin/log_record/deleteLog` | [data/route/admin.php:633](../../data/route/admin.php#L633) |
| POST | `{A}/upload` | `admin/upload/upload` | [data/route/admin.php:634](../../data/route/admin.php#L634) |
| POST | `{A}/upload_image` | `admin/upload/uploadImage` | [data/route/admin.php:635](../../data/route/admin.php#L635) |
| POST | `{A}/upload_file` | `admin/upload/uploadFile` | [data/route/admin.php:636](../../data/route/admin.php#L636) |
| POST | `{A}/dcim/flowpacket` | `admin/dcim/addFlowPacket` | [data/route/admin.php:637](../../data/route/admin.php#L637) |
| PUT | `{A}/dcim/flowpacket` | `admin/dcim/editFlowPacket` | [data/route/admin.php:638](../../data/route/admin.php#L638) |
| DELETE | `{A}/dcim/flowpacket` | `admin/dcim/delFlowPacket` | [data/route/admin.php:639](../../data/route/admin.php#L639) |
| GET | `{A}/dcim/flowpacket` | `admin/dcim/listFlowPacket` | [data/route/admin.php:640](../../data/route/admin.php#L640) |
| GET | `{A}/dcim/flowpacket_page` | `admin/dcim/addFlowPacketPage` | [data/route/admin.php:641](../../data/route/admin.php#L641) |
| GET | `{A}/dcim/flowpacket_page/:id` | `admin/dcim/editFlowPacketPage` | [data/route/admin.php:642](../../data/route/admin.php#L642) |
| GET | `{A}/dcim/buy_record` | `admin/dcim/listBuyRecord` | [data/route/admin.php:643](../../data/route/admin.php#L643) |
| DELETE | `{A}/dcim/buy_record` | `admin/dcim/delRecord` | [data/route/admin.php:644](../../data/route/admin.php#L644) |
| POST | `{A}/dcim/server` | `admin/dcim/addServer` | [data/route/admin.php:645](../../data/route/admin.php#L645) |
| PUT | `{A}/dcim/server` | `admin/dcim/editServer` | [data/route/admin.php:646](../../data/route/admin.php#L646) |
| GET | `{A}/dcim/server/:id` | `admin/dcim/serverDetail` | [data/route/admin.php:647](../../data/route/admin.php#L647) |
| DELETE | `{A}/dcim/server` | `admin/dcim/delServer` | [data/route/admin.php:648](../../data/route/admin.php#L648) |
| GET | `{A}/dcim/server` | `admin/dcim/serverList` | [data/route/admin.php:649](../../data/route/admin.php#L649) |
| GET | `{A}/dcim/server/:id/status` | `admin/dcim/refreshServerStatus` | [data/route/admin.php:650](../../data/route/admin.php#L650) |
| GET | `{A}/dcim/server/status` | `admin/dcim/refreshAllServerStatus` | [data/route/admin.php:651](../../data/route/admin.php#L651) |
| POST | `{A}/dcim/on` | `admin/dcim/on` | [data/route/admin.php:652](../../data/route/admin.php#L652) |
| POST | `{A}/dcim/off` | `admin/dcim/off` | [data/route/admin.php:653](../../data/route/admin.php#L653) |
| POST | `{A}/dcim/reboot` | `admin/dcim/reboot` | [data/route/admin.php:654](../../data/route/admin.php#L654) |
| POST | `{A}/dcim/bmc` | `admin/dcim/bmc` | [data/route/admin.php:655](../../data/route/admin.php#L655) |
| POST | `{A}/dcim/kvm` | `admin/dcim/kvm` | [data/route/admin.php:656](../../data/route/admin.php#L656) |
| POST | `{A}/dcim/ikvm` | `admin/dcim/ikvm` | [data/route/admin.php:657](../../data/route/admin.php#L657) |
| GET | `{A}/dcim/download` | `admin/dcim/download` | [data/route/admin.php:658](../../data/route/admin.php#L658) |
| POST | `{A}/dcim/reinstall` | `admin/dcim/reinstall` | [data/route/admin.php:659](../../data/route/admin.php#L659) |
| GET | `{A}/dcim/resintall_status` | `admin/dcim/getReinstallStatus` | [data/route/admin.php:660](../../data/route/admin.php#L660) |
| POST | `{A}/dcim/rescue` | `admin/dcim/rescue` | [data/route/admin.php:661](../../data/route/admin.php#L661) |
| POST | `{A}/dcim/crack_pass` | `admin/dcim/crackPass` | [data/route/admin.php:662](../../data/route/admin.php#L662) |
| GET | `{A}/dcim/traffic_usage` | `admin/dcim/getTrafficUsage` | [data/route/admin.php:663](../../data/route/admin.php#L663) |
| POST | `{A}/dcim/cancel_task` | `admin/dcim/cancelReinstall` | [data/route/admin.php:664](../../data/route/admin.php#L664) |
| POST | `{A}/dcim/unsuspend_reinstall` | `admin/dcim/unsuspendReload` | [data/route/admin.php:665](../../data/route/admin.php#L665) |
| POST | `{A}/dcim/traffic` | `admin/dcim/traffic` | [data/route/admin.php:666](../../data/route/admin.php#L666) |
| POST | `{A}/dcim/novnc` | `admin/dcim/novnc` | [data/route/admin.php:667](../../data/route/admin.php#L667) |
| GET | `{A}/dcim/novnc` | `admin/dcim/novncPage` | [data/route/admin.php:668](../../data/route/admin.php#L668) |
| GET | `{A}/dcim/detail` | `admin/dcim/detail` | [data/route/admin.php:669](../../data/route/admin.php#L669) |
| GET | `{A}/dcim/sales` | `admin/dcim/getSalesServer` | [data/route/admin.php:670](../../data/route/admin.php#L670) |
| POST | `{A}/dcim/assign` | `admin/dcim/assignServer` | [data/route/admin.php:671](../../data/route/admin.php#L671) |
| DELETE | `{A}/dcim/delete` | `admin/dcim/delete` | [data/route/admin.php:672](../../data/route/admin.php#L672) |
| POST | `{A}/dcim/refresh_power_status` | `admin/dcim/refreshPowerStatus` | [data/route/admin.php:673](../../data/route/admin.php#L673) |
| GET | `{A}/api` | `admin/api/index` | [data/route/admin.php:674](../../data/route/admin.php#L674) |
| POST | `{A}/api` | `admin/api/add` | [data/route/admin.php:675](../../data/route/admin.php#L675) |
| DELETE | `{A}/api` | `admin/api/delete` | [data/route/admin.php:676](../../data/route/admin.php#L676) |
| GET | `{A}/salegroup` | `admin/sale/groupList` | [data/route/admin.php:677](../../data/route/admin.php#L677) |
| GET | `{A}/sale/add_salegrouppage` | `admin/sale/addSalegroupPage` | [data/route/admin.php:678](../../data/route/admin.php#L678) |
| ANY | `{A}/sale/add_salegroup` | `admin/sale/addSalegroup` | [data/route/admin.php:679](../../data/route/admin.php#L679) |
| GET | `{A}/sale/edit_salegrouppage` | `admin/sale/editSalegroupPage` | [data/route/admin.php:680](../../data/route/admin.php#L680) |
| ANY | `{A}/sale/edit_salegroup` | `admin/sale/editSalegroup` | [data/route/admin.php:681](../../data/route/admin.php#L681) |
| GET | `{A}/sale/del_salegroup` | `admin/sale/delSalegroup` | [data/route/admin.php:682](../../data/route/admin.php#L682) |
| GET | `{A}/sale/edit_delproduct` | `admin/sale/editDelproduct` | [data/route/admin.php:683](../../data/route/admin.php#L683) |
| ANY | `{A}/sale/get_timetype` | `admin/sale/getTimetype` | [data/route/admin.php:684](../../data/route/admin.php#L684) |
| GET | `{A}/saleladder` | `admin/sale/ladderList` | [data/route/admin.php:685](../../data/route/admin.php#L685) |
| POST | `{A}/sale/add_saleladder` | `admin/sale/addSaleLadder` | [data/route/admin.php:686](../../data/route/admin.php#L686) |
| GET | `{A}/sale/edit_saleladderpage` | `admin/sale/editSaleLadderPage` | [data/route/admin.php:687](../../data/route/admin.php#L687) |
| POST | `{A}/sale/edit_saleladder` | `admin/sale/editSaleLadder` | [data/route/admin.php:688](../../data/route/admin.php#L688) |
| GET | `{A}/sale/del_saleladder` | `admin/sale/delSaleLadder` | [data/route/admin.php:689](../../data/route/admin.php#L689) |
| GET | `{A}/sale/sale_statistics` | `admin/sale/saleStatistics` | [data/route/admin.php:690](../../data/route/admin.php#L690) |
| ANY | `{A}/sale/sale_records` | `admin/sale/saleRecordsNew` | [data/route/admin.php:691](../../data/route/admin.php#L691) |
| GET | `{A}/sale/sale_users` | `admin/sale/saleUsers` | [data/route/admin.php:692](../../data/route/admin.php#L692) |
| ANY | `{A}/sale/sale_userslist` | `admin/sale/saleUsersList` | [data/route/admin.php:693](../../data/route/admin.php#L693) |
| GET | `{A}/sale/adminlist` | `admin/sale/adminList` | [data/route/admin.php:694](../../data/route/admin.php#L694) |
| ANY | `{A}/sale/edit_adminlist` | `admin/sale/editAdminList` | [data/route/admin.php:695](../../data/route/admin.php#L695) |
| ANY | `{A}/sale/get_sale_enble` | `admin/sale/getSaleEnble` | [data/route/admin.php:696](../../data/route/admin.php#L696) |
| ANY | `{A}/sale/sale_enble` | `admin/sale/saleEnblePost` | [data/route/admin.php:697](../../data/route/admin.php#L697) |
| GET | `{A}/sale/test` | `admin/sale/Test` | [data/route/admin.php:698](../../data/route/admin.php#L698) |
| GET | `{A}/aff` | `admin/affiliate/index` | [data/route/admin.php:699](../../data/route/admin.php#L699) |
| GET | `{A}/aff/useraffi_page` | `admin/affiliate/useraffiPage` | [data/route/admin.php:700](../../data/route/admin.php#L700) |
| GET | `{A}/aff/useraffi_list` | `admin/affiliate/useraffilist` | [data/route/admin.php:701](../../data/route/admin.php#L701) |
| GET | `{A}/aff/useraffi_record` | `admin/affiliate/useraffirecord` | [data/route/admin.php:702](../../data/route/admin.php#L702) |
| GET | `{A}/aff/useraffibuy_record` | `admin/affiliate/useraffibuyrecord` | [data/route/admin.php:703](../../data/route/admin.php#L703) |
| ANY | `{A}/aff/get_timetype` | `admin/affiliate/getTimetype` | [data/route/admin.php:704](../../data/route/admin.php#L704) |
| ANY | `{A}/aff/useraffi_post` | `admin/affiliate/useraffiPost` | [data/route/admin.php:705](../../data/route/admin.php#L705) |
| ANY | `{A}/aff/useraffi_balance` | `admin/affiliate/useraffibalance` | [data/route/admin.php:706](../../data/route/admin.php#L706) |
| GET | `{A}/aff/productaffi_page` | `admin/affiliate/productaffiPage` | [data/route/admin.php:707](../../data/route/admin.php#L707) |
| ANY | `{A}/aff/productaffi_post` | `admin/affiliate/productaffiPost` | [data/route/admin.php:708](../../data/route/admin.php#L708) |
| ANY | `{A}/aff/affiwithdraw_record` | `admin/affiliate/affiwithdrawrecord` | [data/route/admin.php:709](../../data/route/admin.php#L709) |
| ANY | `{A}/aff/affiwithdrawsh` | `admin/affiliate/affiwithdrawsh` | [data/route/admin.php:710](../../data/route/admin.php#L710) |
| ANY | `{A}/aff/gateway_list` | `admin/affiliate/gatewaylist` | [data/route/admin.php:711](../../data/route/admin.php#L711) |
| ANY | `{A}/aff/test` | `admin/affiliate/test` | [data/route/admin.php:712](../../data/route/admin.php#L712) |
| POST | `{A}/dcimcloud/server` | `admin/dcimCloud/addServer` | [data/route/admin.php:713](../../data/route/admin.php#L713) |
| PUT | `{A}/dcimcloud/server` | `admin/dcimCloud/editServer` | [data/route/admin.php:714](../../data/route/admin.php#L714) |
| GET | `{A}/dcimcloud/server/:id` | `admin/dcimCloud/serverDetail` | [data/route/admin.php:715](../../data/route/admin.php#L715) |
| DELETE | `{A}/dcimcloud/server` | `admin/dcimCloud/delServer` | [data/route/admin.php:716](../../data/route/admin.php#L716) |
| GET | `{A}/dcimcloud/server` | `admin/dcimCloud/serverList` | [data/route/admin.php:717](../../data/route/admin.php#L717) |
| GET | `{A}/dcimcloud/server/:id/status` | `admin/dcimCloud/refreshServerStatus` | [data/route/admin.php:718](../../data/route/admin.php#L718) |
| GET | `{A}/dcimcloud/server/status` | `admin/dcimCloud/refreshAllServerStatus` | [data/route/admin.php:719](../../data/route/admin.php#L719) |
| ANY | `{A}/upper/index` | `admin/upperReaches/index` | [data/route/admin.php:720](../../data/route/admin.php#L720) |
| ANY | `{A}/upper/addpost` | `admin/upperReaches/addPost` | [data/route/admin.php:721](../../data/route/admin.php#L721) |
| ANY | `{A}/upper/edituppost` | `admin/upperReaches/editupPost` | [data/route/admin.php:722](../../data/route/admin.php#L722) |
| ANY | `{A}/upper/del` | `admin/upperReaches/delup` | [data/route/admin.php:723](../../data/route/admin.php#L723) |
| ANY | `{A}/upper/upperindex` | `admin/upperReaches/upperIndex` | [data/route/admin.php:724](../../data/route/admin.php#L724) |
| ANY | `{A}/upper/upperaddpost` | `admin/upperReaches/upperAddpost` | [data/route/admin.php:725](../../data/route/admin.php#L725) |
| ANY | `{A}/upper/uppereditpost` | `admin/upperReaches/upperEditpost` | [data/route/admin.php:726](../../data/route/admin.php#L726) |
| ANY | `{A}/upper/upperdel` | `admin/upperReaches/upperDel` | [data/route/admin.php:727](../../data/route/admin.php#L727) |
| ANY | `{A}/upper/upperindex` | `admin/upperReaches/upperIndex` | [data/route/admin.php:728](../../data/route/admin.php#L728) |
| ANY | `{A}/upper/addupperpage` | `admin/upperReaches/addUpperPage` | [data/route/admin.php:729](../../data/route/admin.php#L729) |
| ANY | `{A}/upper/addupperpost` | `admin/upperReaches/addUpperPost` | [data/route/admin.php:730](../../data/route/admin.php#L730) |
| ANY | `{A}/upper/editupperpage` | `admin/upperReaches/editUpperPage` | [data/route/admin.php:731](../../data/route/admin.php#L731) |
| ANY | `{A}/upper/editupperpost` | `admin/upperReaches/editUpperPost` | [data/route/admin.php:732](../../data/route/admin.php#L732) |
| ANY | `{A}/upper/delupper` | `admin/upperReaches/delUpper` | [data/route/admin.php:733](../../data/route/admin.php#L733) |
| POST | `{A}/upper/allotupper` | `admin/upperReaches/allotUpper` | [data/route/admin.php:734](../../data/route/admin.php#L734) |
| POST | `{A}/upper/emptyupper` | `admin/upperReaches/emptyUpper` | [data/route/admin.php:735](../../data/route/admin.php#L735) |
| GET | `{A}/upper/ipmi/status` | `admin/upperReaches/ipmiStatus` | [data/route/admin.php:736](../../data/route/admin.php#L736) |
| POST | `{A}/upper/ipmi/on` | `admin/upperReaches/ipmiOn` | [data/route/admin.php:737](../../data/route/admin.php#L737) |
| POST | `{A}/upper/ipmi/off` | `admin/upperReaches/ipmiOff` | [data/route/admin.php:738](../../data/route/admin.php#L738) |
| POST | `{A}/upper/ipmi/reboot` | `admin/upperReaches/ipmiReboot` | [data/route/admin.php:739](../../data/route/admin.php#L739) |
| POST | `{A}/upper/ipmi/vnc` | `admin/upperReaches/ipmiVnc` | [data/route/admin.php:740](../../data/route/admin.php#L740) |
| GET | `{A}/upper/dcim_client/status` | `admin/upperReaches/dcimClientStatus` | [data/route/admin.php:741](../../data/route/admin.php#L741) |
| POST | `{A}/upper/dcim_client/on` | `admin/upperReaches/dcimClientOn` | [data/route/admin.php:742](../../data/route/admin.php#L742) |
| POST | `{A}/upper/dcim_client/off` | `admin/upperReaches/dcimClientOff` | [data/route/admin.php:743](../../data/route/admin.php#L743) |
| POST | `{A}/upper/dcim_client/reboot` | `admin/upperReaches/dcimClientReboot` | [data/route/admin.php:744](../../data/route/admin.php#L744) |
| POST | `{A}/upper/dcim_client/vnc` | `admin/upperReaches/dcimClientVnc` | [data/route/admin.php:745](../../data/route/admin.php#L745) |
| GET | `{A}/upper/dcim_client/vnc` | `admin/upperReaches/dcimClientVncPage` | [data/route/admin.php:746](../../data/route/admin.php#L746) |
| POST | `{A}/upper/dcim_client/reinstall` | `admin/upperReaches/dcimClientReinstall` | [data/route/admin.php:747](../../data/route/admin.php#L747) |
| POST | `{A}/upper/dcim_client/crack_pass` | `admin/upperReaches/dcimClientCrackPass` | [data/route/admin.php:748](../../data/route/admin.php#L748) |
| POST | `{A}/upper/dcim_client/cancel_task` | `admin/upperReaches/dcimClientCancelReinstall` | [data/route/admin.php:749](../../data/route/admin.php#L749) |
| POST | `{A}/upper/dcim_client/resintall_status` | `admin/upperReaches/dcimClientReinstallStatus` | [data/route/admin.php:750](../../data/route/admin.php#L750) |
| POST | `{A}/upper/dcim_client/get_os` | `admin/upperReaches/dcimClientGetOs` | [data/route/admin.php:751](../../data/route/admin.php#L751) |
| POST | `{A}/zjmf_finance_api` | `admin/zjmfFinanceApi/createApi` | [data/route/admin.php:752](../../data/route/admin.php#L752) |
| PUT | `{A}/zjmf_finance_api` | `admin/zjmfFinanceApi/modifyApi` | [data/route/admin.php:753](../../data/route/admin.php#L753) |
| GET | `{A}/zjmf_finance_api/:id` | `admin/zjmfFinanceApi/detail` | [data/route/admin.php:754](../../data/route/admin.php#L754) |
| DELETE | `{A}/zjmf_finance_api/:id` | `admin/zjmfFinanceApi/deleteApi` | [data/route/admin.php:755](../../data/route/admin.php#L755) |
| GET | `{A}/zjmf_finance_api` | `admin/zjmfFinanceApi/index` | [data/route/admin.php:756](../../data/route/admin.php#L756) |
| GET | `{A}/zjmf_finance_api/:id/status` | `admin/zjmfFinanceApi/refreshStatus` | [data/route/admin.php:757](../../data/route/admin.php#L757) |
| GET | `{A}/zjmf_finance_api/summary` | `admin/zjmfFinanceApi/summary` | [data/route/admin.php:758](../../data/route/admin.php#L758) |
| POST | `{A}/zjmf_finance_api/reset` | `admin/zjmfFinanceApi/resetApiPwd` | [data/route/admin.php:759](../../data/route/admin.php#L759) |
| POST | `{A}/zjmf_finance_api/toggle` | `admin/zjmfFinanceApi/apiToggle` | [data/route/admin.php:760](../../data/route/admin.php#L760) |
| GET | `{A}/zjmf_finance_api/freepage` | `admin/zjmfFinanceApi/apiFreePage` | [data/route/admin.php:761](../../data/route/admin.php#L761) |
| POST | `{A}/zjmf_finance_api/freepage` | `admin/zjmfFinanceApi/apiFreePost` | [data/route/admin.php:762](../../data/route/admin.php#L762) |
| DELETE | `{A}/zjmf_finance_api/freepage` | `admin/zjmfFinanceApi/apiFreeDelete` | [data/route/admin.php:763](../../data/route/admin.php#L763) |
| GET | `{A}/zjmf_finance_api/products` | `admin/zjmfFinanceApi/apiProducts` | [data/route/admin.php:764](../../data/route/admin.php#L764) |
| GET | `{A}/zjmf_finance_api/order` | `admin/zjmfFinanceApi/apiOrder` | [data/route/admin.php:765](../../data/route/admin.php#L765) |
| POST | `{A}/zjmf_finance_api/order_commission` | `admin/zjmfFinanceApi/apiOrderCom` | [data/route/admin.php:766](../../data/route/admin.php#L766) |
| GET | `{A}/zjmf_finance_api/renew` | `admin/zjmfFinanceApi/getRenew` | [data/route/admin.php:767](../../data/route/admin.php#L767) |
| GET | `{A}/zjmf_finance_api/host` | `admin/zjmfFinanceApi/apiHost` | [data/route/admin.php:768](../../data/route/admin.php#L768) |
| GET | `{A}/zjmf_finance_api/downstream_summary` | `admin/zjmfFinanceApi/downstreamSummary` | [data/route/admin.php:769](../../data/route/admin.php#L769) |
| GET | `{A}/zjmf_finance_api/logs` | `admin/zjmfFinanceApi/apiLog` | [data/route/admin.php:770](../../data/route/admin.php#L770) |
| POST | `{A}/zjmf_finance_api/open` | `admin/zjmfFinanceApi/apiOpen` | [data/route/admin.php:771](../../data/route/admin.php#L771) |
| GET | `{A}/zjmf_finance_api/addpage` | `admin/zjmfFinanceApi/addPage` | [data/route/admin.php:772](../../data/route/admin.php#L772) |
| POST | `{A}/zjmf_finance_api/inputproduct` | `admin/zjmfFinanceApi/inputProduct` | [data/route/admin.php:773](../../data/route/admin.php#L773) |
| POST | `{A}/zjmf_finance_api/upstreamhost` | `admin/zjmfFinanceApi/upstreamHost` | [data/route/admin.php:774](../../data/route/admin.php#L774) |
| GET | `{A}/zjmf_finance_api/manualhost` | `admin/zjmfFinanceApi/getManualHost` | [data/route/admin.php:775](../../data/route/admin.php#L775) |
| POST | `{A}/zjmf_finance_api/manualhost` | `admin/zjmfFinanceApi/postManualHost` | [data/route/admin.php:776](../../data/route/admin.php#L776) |
| GET | `{A}/zjmf_finance_api/upstreamcredit` | `admin/zjmfFinanceApi/upstreamCredit` | [data/route/admin.php:777](../../data/route/admin.php#L777) |
| GET | `{A}/sm_type` | `admin/sendMessageBatch/getSearchParams` | [data/route/admin.php:778](../../data/route/admin.php#L778) |
| GET | `{A}/getSendMethod` | `admin/sendMessageBatch/getSendMethod` | [data/route/admin.php:779](../../data/route/admin.php#L779) |
| ANY | `{A}/searchlist` | `admin/sendMessageBatch/searchList` | [data/route/admin.php:780](../../data/route/admin.php#L780) |
| GET | `{A}/mobiletemplate_list` | `admin/sendMessageBatch/mobiletemplateList` | [data/route/admin.php:781](../../data/route/admin.php#L781) |
| GET | `{A}/emailtemplate_list` | `admin/sendMessageBatch/emailtemplateList` | [data/route/admin.php:782](../../data/route/admin.php#L782) |
| GET | `{A}/email_template_params` | `admin/sendMessageBatch/getEmailTemplateParams` | [data/route/admin.php:783](../../data/route/admin.php#L783) |
| GET | `{A}/edit_template` | `admin/sendMessageBatch/editTemplate` | [data/route/admin.php:784](../../data/route/admin.php#L784) |
| ANY | `{A}/sendmessage_post` | `admin/sendMessageBatch/sendMessagePost` | [data/route/admin.php:785](../../data/route/admin.php#L785) |
| GET | `{A}/get_progress` | `admin/sendMessageBatch/getProgress` | [data/route/admin.php:786](../../data/route/admin.php#L786) |
| PUT | `{A}/dcimauth/reset` | `admin/dcimAuth/resetAuth` | [data/route/admin.php:787](../../data/route/admin.php#L787) |
| DELETE | `{A}/dcimauth` | `admin/dcimAuth/deleteAuth` | [data/route/admin.php:788](../../data/route/admin.php#L788) |
| PUT | `{A}/dcimauth/recover` | `admin/dcimAuth/recoverAuth` | [data/route/admin.php:789](../../data/route/admin.php#L789) |
| GET | `{A}/dcimauth/used` | `admin/dcimAuth/getUsedData` | [data/route/admin.php:790](../../data/route/admin.php#L790) |
| PUT | `{A}/dcimauth` | `admin/dcimAuth/editAuth` | [data/route/admin.php:791](../../data/route/admin.php#L791) |
| PUT | `{A}/dcimauth/hotfix` | `admin/dcimAuth/hotfixPush` | [data/route/admin.php:792](../../data/route/admin.php#L792) |
| PUT | `{A}/dcimauth/update` | `admin/dcimAuth/updatePush` | [data/route/admin.php:793](../../data/route/admin.php#L793) |
| GET | `{A}/dcimauth/:id` | `admin/dcimAuth/detail` | [data/route/admin.php:794](../../data/route/admin.php#L794) |
| GET | `{A}/dcimauth` | `admin/dcimAuth/list` | [data/route/admin.php:795](../../data/route/admin.php#L795) |
| GET | `{A}/dcimauth/disabled` | `admin/dcimAuth/disabledList` | [data/route/admin.php:796](../../data/route/admin.php#L796) |
| GET | `{A}/dcimauth/errorLog` | `admin/dcimAuth/errorLogList` | [data/route/admin.php:797](../../data/route/admin.php#L797) |
| POST | `{A}/dcimauth/debug` | `admin/dcimAuth/debugDecrypt` | [data/route/admin.php:798](../../data/route/admin.php#L798) |
| GET | `{A}/dcimauth/debugLog` | `admin/dcimAuth/debugLogList` | [data/route/admin.php:799](../../data/route/admin.php#L799) |
| GET | `{A}/app_store/new_version` | `admin/appStore/getNewVersion` | [data/route/admin.php:800](../../data/route/admin.php#L800) |
| GET | `{A}/advanced_options/page` | `admin/AdvancedOptions/page` | [data/route/admin.php:801](../../data/route/admin.php#L801) |
| POST | `{A}/advanced_options/create` | `admin/AdvancedOptions/create` | [data/route/admin.php:802](../../data/route/admin.php#L802) |
| DELETE | `{A}/advanced_options/deletecondition` | `admin/AdvancedOptions/deleteCondition` | [data/route/admin.php:803](../../data/route/admin.php#L803) |
| DELETE | `{A}/advanced_options/deleteresult` | `admin/AdvancedOptions/deleteResult` | [data/route/admin.php:804](../../data/route/admin.php#L804) |
| POST | `{A}/advanced_options/addcondition` | `admin/AdvancedOptions/addCondition` | [data/route/admin.php:805](../../data/route/admin.php#L805) |
| POST | `{A}/advanced_options/addresult` | `admin/AdvancedOptions/addResult` | [data/route/admin.php:806](../../data/route/admin.php#L806) |
| RESOURCE | `{A}/advanced_options` | `admin/AdvancedOptions` | [data/route/admin.php:807](../../data/route/admin.php#L807) |
| CONTROLLER | `{A}/user_level` | `admin/UserLevel` | [data/route/admin.php:808](../../data/route/admin.php#L808) |
| CONTROLLER | `{A}/voucher` | `admin/Voucher` | [data/route/admin.php:809](../../data/route/admin.php#L809) |
| GET | `{A}/menu/position_page` | `admin/menu/managePositionPage` | [data/route/admin.php:810](../../data/route/admin.php#L810) |
| GET | `{A}/menu/setting_page` | `admin/menu/menuManagePage` | [data/route/admin.php:811](../../data/route/admin.php#L811) |
| POST | `{A}/menu/save_position` | `admin/menu/savePosition` | [data/route/admin.php:812](../../data/route/admin.php#L812) |
| POST | `{A}/menu/create` | `admin/menu/createMenu` | [data/route/admin.php:813](../../data/route/admin.php#L813) |
| POST | `{A}/menu/edit` | `admin/menu/editMenu` | [data/route/admin.php:814](../../data/route/admin.php#L814) |
| DELETE | `{A}/menu/delete` | `admin/menu/deleteMenu` | [data/route/admin.php:815](../../data/route/admin.php#L815) |
| POST | `{A}/menu/create_nav` | `admin/menu/createNav` | [data/route/admin.php:816](../../data/route/admin.php#L816) |
| DELETE | `{A}/menu/delete_nav` | `admin/menu/deleteNav` | [data/route/admin.php:817](../../data/route/admin.php#L817) |
| POST | `{A}/menus/getMenu` | `admin/menus/getMenu` | [data/route/admin.php:818](../../data/route/admin.php#L818) |
| POST | `{A}/menus/getMenuList` | `admin/menus/getMenuList` | [data/route/admin.php:819](../../data/route/admin.php#L819) |
| POST | `{A}/menus/setNavList` | `admin/menus/setNavList` | [data/route/admin.php:820](../../data/route/admin.php#L820) |
| POST | `{A}/menus/addCustomPage` | `admin/menus/addCustomPage` | [data/route/admin.php:821](../../data/route/admin.php#L821) |
| POST | `{A}/menus/addProductPage` | `admin/menus/addProductPage` | [data/route/admin.php:822](../../data/route/admin.php#L822) |
| POST | `{A}/menus/getProductList` | `admin/menus/getProductList` | [data/route/admin.php:823](../../data/route/admin.php#L823) |
| POST | `{A}/menus/getMenuType` | `admin/menus/getMenuType` | [data/route/admin.php:824](../../data/route/admin.php#L824) |
| POST | `{A}/menus/addMenu` | `admin/menus/addMenu` | [data/route/admin.php:825](../../data/route/admin.php#L825) |
| POST | `{A}/menus/editMenu` | `admin/menus/editMenu` | [data/route/admin.php:826](../../data/route/admin.php#L826) |
| POST | `{A}/menus/delMenu` | `admin/menus/delMenu` | [data/route/admin.php:827](../../data/route/admin.php#L827) |
| POST | `{A}/menus/delTwoMenu` | `admin/menus/delTwoMenu` | [data/route/admin.php:828](../../data/route/admin.php#L828) |
| POST | `{A}/menus/getTypeAllMenu` | `admin/menus/getTypeAllMenu` | [data/route/admin.php:829](../../data/route/admin.php#L829) |
| POST | `{A}/menus/editMenuActive` | `admin/menus/editMenuActive` | [data/route/admin.php:830](../../data/route/admin.php#L830) |
| POST | `{A}/menus/getSystemNav` | `admin/menus/getSystemNav` | [data/route/admin.php:831](../../data/route/admin.php#L831) |
| POST | `{A}/menus/getNavType` | `admin/menus/getNavType` | [data/route/admin.php:832](../../data/route/admin.php#L832) |
| POST | `{A}/menus/getLang` | `admin/menus/getLang` | [data/route/admin.php:833](../../data/route/admin.php#L833) |
| POST | `{A}/menus/getDefaultSenior` | `admin/menus/getDefaultSenior` | [data/route/admin.php:834](../../data/route/admin.php#L834) |
| POST | `{A}/menus/setWebNavList` | `admin/menus/setWebNavList` | [data/route/admin.php:835](../../data/route/admin.php#L835) |
| POST | `{A}/menus/createWebPage` | `admin/menus/createWebPage` | [data/route/admin.php:836](../../data/route/admin.php#L836) |
| GET | `{A}/menus/getCreateWebData` | `admin/menus/getCreateWebData` | [data/route/admin.php:837](../../data/route/admin.php#L837) |
| POST | `{A}/menus/getOtherMenu` | `admin/menus/getOtherMenu` | [data/route/admin.php:838](../../data/route/admin.php#L838) |
| POST | `{A}/ruleManage/getMenuList` | `admin/RuleManage/getMenuList` | [data/route/admin.php:839](../../data/route/admin.php#L839) |
| POST | `{A}/ruleManage/addMenu` | `admin/RuleManage/addMenu` | [data/route/admin.php:840](../../data/route/admin.php#L840) |
| POST | `{A}/ruleManage/editMenu` | `admin/RuleManage/editMenu` | [data/route/admin.php:841](../../data/route/admin.php#L841) |
| POST | `{A}/ruleManage/saveMenuList` | `admin/RuleManage/saveMenuList` | [data/route/admin.php:842](../../data/route/admin.php#L842) |
| POST | `{A}/ruleMiddle/getMenuList` | `admin/RuleMiddle/getMenuList` | [data/route/admin.php:843](../../data/route/admin.php#L843) |
| POST | `{A}/ruleMiddle/addMenu` | `admin/RuleMiddle/addMenu` | [data/route/admin.php:844](../../data/route/admin.php#L844) |
| POST | `{A}/ruleMiddle/editMenu` | `admin/RuleMiddle/editMenu` | [data/route/admin.php:845](../../data/route/admin.php#L845) |
| POST | `{A}/ruleMiddle/saveMenuList` | `admin/RuleMiddle/saveMenuList` | [data/route/admin.php:846](../../data/route/admin.php#L846) |
| POST | `{A}/ruleMiddle/getNav` | `admin/RuleMiddle/getNav` | [data/route/admin.php:847](../../data/route/admin.php#L847) |
| GET | `{A}/run_map/list` | `admin/RunMap/runMapList` | [data/route/admin.php:848](../../data/route/admin.php#L848) |
| POST | `{A}/run_map/repeat_task` | `admin/RunMap/repeatTask` | [data/route/admin.php:849](../../data/route/admin.php#L849) |
| GET | `{A}/run_cron/trend` | `admin/RunMap/runCronTrend` | [data/route/admin.php:850](../../data/route/admin.php#L850) |
| GET | `{A}/run_cron/list` | `admin/RunMap/runCronList` | [data/route/admin.php:851](../../data/route/admin.php#L851) |
| GET | `{A}/system/systemAuthRuleLanguage` | `admin/System/getSystemAuthRuleLanguage` | [data/route/admin.php:852](../../data/route/admin.php#L852) |
| GET | `{A}/community/configLang` | `admin/community/systemLangConfig` | [data/route/admin.php:853](../../data/route/admin.php#L853) |
| GET | `{A}/community/clientConfigLang` | `admin/community/clientLangConfig` | [data/route/admin.php:854](../../data/route/admin.php#L854) |
| POST | `{A}/menus/saveLinks` | `admin/menus/saveLinks` | [data/route/admin.php:855](../../data/route/admin.php#L855) |
| POST | `{A}/menus/deleteLinks` | `admin/menus/deleteLinks` | [data/route/admin.php:856](../../data/route/admin.php#L856) |
| GET | `{A}/menus/allLinks` | `admin/menus/allLinks` | [data/route/admin.php:857](../../data/route/admin.php#L857) |
| GET | `{A}/interflow/templateParams` | `admin/InterflowSeting/templateParams` | [data/route/admin.php:858](../../data/route/admin.php#L858) |
| GET | `{A}/interflow/seting` | `admin/InterflowSeting/seting` | [data/route/admin.php:859](../../data/route/admin.php#L859) |
| POST | `{A}/interflow/seting` | `admin/InterflowSeting/setingPost` | [data/route/admin.php:860](../../data/route/admin.php#L860) |
| GET | `{A}/interflow/userMap` | `admin/InterflowSeting/userMap` | [data/route/admin.php:861](../../data/route/admin.php#L861) |
| GET | `{A}/interflow/executeMap` | `admin/InterflowSeting/executeMap` | [data/route/admin.php:862](../../data/route/admin.php#L862) |
| GET | `{A}/interflow/botAccount` | `admin/InterflowSeting/botAccount` | [data/route/admin.php:863](../../data/route/admin.php#L863) |
| POST | `{A}/interflow/botAccountPost` | `admin/InterflowSeting/botAccountPost` | [data/route/admin.php:864](../../data/route/admin.php#L864) |
| POST | `{A}/interflow/botAccountDelete` | `admin/InterflowSeting/botAccountDelete` | [data/route/admin.php:865](../../data/route/admin.php#L865) |
| POST | `{A}/interflow/botAccountLogin` | `admin/InterflowSeting/botAccountLogin` | [data/route/admin.php:866](../../data/route/admin.php#L866) |
| POST | `{A}/interflow/botAccountLoginOut` | `admin/InterflowSeting/botAccountLoginOut` | [data/route/admin.php:867](../../data/route/admin.php#L867) |
| GET | `{A}/interflow/botCheckStatus` | `admin/InterflowSeting/botCheckStatus` | [data/route/admin.php:868](../../data/route/admin.php#L868) |
| GET | `{A}/interflow/funcLoadList` | `admin/InterflowSeting/funcLoadList` | [data/route/admin.php:869](../../data/route/admin.php#L869) |
| GET | `{A}/interflow/funcLoadContent` | `admin/InterflowSeting/funcLoadContent` | [data/route/admin.php:870](../../data/route/admin.php#L870) |
| POST | `{A}/interflow/funcRegister` | `admin/InterflowSeting/funcRegister` | [data/route/admin.php:871](../../data/route/admin.php#L871) |
| GET | `{A}/interflow/funcRegisterList` | `admin/InterflowSeting/funcRegisterList` | [data/route/admin.php:872](../../data/route/admin.php#L872) |
| GET | `{A}/interflow/keywordList` | `admin/InterflowSeting/keywordList` | [data/route/admin.php:873](../../data/route/admin.php#L873) |
| POST | `{A}/interflow/keywordExecuteSwitch` | `admin/InterflowSeting/keywordExecuteSwitch` | [data/route/admin.php:874](../../data/route/admin.php#L874) |
| POST | `{A}/interflow/keywordSave` | `admin/InterflowSeting/keywordSave` | [data/route/admin.php:875](../../data/route/admin.php#L875) |
| GET | `{A}/interflow/keywordInfo` | `admin/InterflowSeting/keywordInfo` | [data/route/admin.php:876](../../data/route/admin.php#L876) |
| POST | `{A}/interflow/keywordDel` | `admin/InterflowSeting/keywordDel` | [data/route/admin.php:877](../../data/route/admin.php#L877) |
| CONTROLLER | `{A}/agent` | `admin/Agent` | [data/route/admin.php:878](../../data/route/admin.php#L878) |
| GET | `{A}/link_cause/list` | `admin/LinkCause/index` | [data/route/admin.php:879](../../data/route/admin.php#L879) |
| GET | `{A}/link_cause/edit` | `admin/LinkCause/edit` | [data/route/admin.php:880](../../data/route/admin.php#L880) |
| POST | `{A}/link_cause/save` | `admin/LinkCause/save` | [data/route/admin.php:881](../../data/route/admin.php#L881) |
| GET | `{A}/link_cause/create` | `admin/LinkCause/create` | [data/route/admin.php:882](../../data/route/admin.php#L882) |
| POST | `{A}/link_cause/add` | `admin/LinkCause/add` | [data/route/admin.php:883](../../data/route/admin.php#L883) |
| GET | `{A}/link_cause/delete` | `admin/LinkCause/delete` | [data/route/admin.php:884](../../data/route/admin.php#L884) |
| GET | `{A}/link_knowledge/list` | `admin/LinkKnowledge/index` | [data/route/admin.php:885](../../data/route/admin.php#L885) |
| GET | `{A}/link_knowledge/edit` | `admin/LinkKnowledge/edit` | [data/route/admin.php:886](../../data/route/admin.php#L886) |
| POST | `{A}/link_knowledge/save` | `admin/LinkKnowledge/save` | [data/route/admin.php:887](../../data/route/admin.php#L887) |
| GET | `{A}/link_knowledge/create` | `admin/LinkKnowledge/create` | [data/route/admin.php:888](../../data/route/admin.php#L888) |
| POST | `{A}/link_knowledge/add` | `admin/LinkKnowledge/add` | [data/route/admin.php:889](../../data/route/admin.php#L889) |
| GET | `{A}/link_knowledge/delete` | `admin/LinkKnowledge/delete` | [data/route/admin.php:890](../../data/route/admin.php#L890) |
| POST | `{A}/upload_file` | `admin/upload/uploadFile` | [data/route/admin.php:892](../../data/route/admin.php#L892) |
| GET | `{A}/cron/exec` | `admin/CronUrl/index` | [data/route/admin.php:893](../../data/route/admin.php#L893) |
| GET | `/link_list` | `home/cart/getLinkAgeListJson` | [data/route/home.php:75](../../data/route/home.php#L75) |
| GET | `/demo/[:pid]/` | `home/demo/demo/` | [data/route/home.php:81](../../data/route/home.php#L81) |
| GET | `/index` | `home/index/index` | [data/route/home.php:83](../../data/route/home.php#L83) |
| GET | `/user_info` | `home/user/index` | [data/route/home.php:84](../../data/route/home.php#L84) |
| PUT | `/user_info` | `home/user/update` | [data/route/home.php:85](../../data/route/home.php#L85) |
| POST | `/toggle_second_verify` | `home/user/toggleSecondVerify` | [data/route/home.php:86](../../data/route/home.php#L86) |
| GET | `/second_verify_page` | `home/user/getSecondVerifyPage` | [data/route/home.php:87](../../data/route/home.php#L87) |
| POST | `/second_verify_send` | `home/user/secondVerifySend` | [data/route/home.php:88](../../data/route/home.php#L88) |
| GET | `/get_api_pwd` | `home/user/getApiPwd` | [data/route/home.php:89](../../data/route/home.php#L89) |
| POST | `/modify_api_pwd` | `home/user/modifyApiPwd` | [data/route/home.php:90](../../data/route/home.php#L90) |
| GET | `/auto_api_pwd` | `home/user/autoApiPwd` | [data/route/home.php:91](../../data/route/home.php#L91) |
| GET | `/get_areas` | `home/user/getAreas` | [data/route/home.php:92](../../data/route/home.php#L92) |
| POST | `/modify_password` | `home/user/modifyPassword` | [data/route/home.php:93](../../data/route/home.php#L93) |
| GET | `/user_action_log/[:page]/` | `home/user/user_action_log` | [data/route/home.php:94](../../data/route/home.php#L94) |
| GET | `/logOut` | `home/user/logOut` | [data/route/home.php:95](../../data/route/home.php#L95) |
| GET | `/sys_messgage` | `home/system_message/getMessageList` | [data/route/home.php:96](../../data/route/home.php#L96) |
| GET | `/sys_messgage_unread` | `home/system_message/getUnreadList` | [data/route/home.php:97](../../data/route/home.php#L97) |
| GET | `/read_messgage` | `home/system_message/readSystemMessage` | [data/route/home.php:98](../../data/route/home.php#L98) |
| GET | `/delete_messgage` | `home/system_message/deleteSystemMessage` | [data/route/home.php:99](../../data/route/home.php#L99) |
| GET | `/check_origin_phone` | `home/user/checkOriginPhone` | [data/route/home.php:100](../../data/route/home.php#L100) |
| POST | `/bind_phone` | `home/user/bind_phone_send` | [data/route/home.php:101](../../data/route/home.php#L101) |
| POST | `/bind_phone_handle` | `home/user/bind_phone_handle` | [data/route/home.php:102](../../data/route/home.php#L102) |
| GET | `/bind_phone_code` | `home/user/bind_phone_code` | [data/route/home.php:103](../../data/route/home.php#L103) |
| POST | `/bind_phone_change` | `home/user/bind_phone_change` | [data/route/home.php:104](../../data/route/home.php#L104) |
| POST | `/login_sms_reminder` | `home/user/loginSmsReminder` | [data/route/home.php:105](../../data/route/home.php#L105) |
| POST | `/login_email_reminder` | `home/user/loginEmailReminder` | [data/route/home.php:106](../../data/route/home.php#L106) |
| GET | `/remind_send` | `home/user/remindSend` | [data/route/home.php:107](../../data/route/home.php#L107) |
| GET | `/remind_email_send` | `home/user/remindEmailSend` | [data/route/home.php:108](../../data/route/home.php#L108) |
| GET | `/bind_wechat` | `home/user/bind_wechat` | [data/route/home.php:109](../../data/route/home.php#L109) |
| GET | `/bind_wechat_handle/:id/` | `home/user/bind_wechat_handle` | [data/route/home.php:110](../../data/route/home.php#L110) |
| POST | `/bind_email` | `home/user/bind_email` | [data/route/home.php:111](../../data/route/home.php#L111) |
| POST | `/bind_email_handle` | `home/user/bind_email_handle` | [data/route/home.php:112](../../data/route/home.php#L112) |
| POST | `/change_email` | `home/user/change_email` | [data/route/home.php:113](../../data/route/home.php#L113) |
| POST | `/change_email_handle` | `home/user/change_email_handle` | [data/route/home.php:114](../../data/route/home.php#L114) |
| GET | `/affpage` | `home/user_affiliate/affpage` | [data/route/home.php:115](../../data/route/home.php#L115) |
| GET | `/activation` | `home/user_affiliate/activation` | [data/route/home.php:116](../../data/route/home.php#L116) |
| GET | `/affindex` | `home/user_affiliate/affindex` | [data/route/home.php:117](../../data/route/home.php#L117) |
| GET | `/useraffi_list` | `home/user_affiliate/useraffilist` | [data/route/home.php:118](../../data/route/home.php#L118) |
| POST | `/withdraw` | `home/user_affiliate/withdraw` | [data/route/home.php:119](../../data/route/home.php#L119) |
| ANY | `/withdrawrecord` | `home/user_affiliate/withdrawrecord` | [data/route/home.php:120](../../data/route/home.php#L120) |
| ANY | `/affbuyrecord` | `home/user_affiliate/affbuyrecord` | [data/route/home.php:121](../../data/route/home.php#L121) |
| GET | `/certifi` | `home/certification/Certifi` | [data/route/home.php:122](../../data/route/home.php#L122) |
| POST | `/person_certifi_post` | `home/certification/personCertifiPost` | [data/route/home.php:123](../../data/route/home.php#L123) |
| POST | `/person_query_post` | `home/certification/personQueryPost` | [data/route/home.php:124](../../data/route/home.php#L124) |
| POST | `/company_certifi_post` | `home/certification/companyCertifiPost` | [data/route/home.php:125](../../data/route/home.php#L125) |
| POST | `/company_query_post` | `home/certification/companyQueryPost` | [data/route/home.php:126](../../data/route/home.php#L126) |
| POST | `/person_to_company` | `home/certification/personToCompany` | [data/route/home.php:127](../../data/route/home.php#L127) |
| GET | `/certifi_ping` | `home/certification/ping` | [data/route/home.php:128](../../data/route/home.php#L128) |
| GET | `/contract/host` | `home/contract/host` | [data/route/home.php:129](../../data/route/home.php#L129) |
| POST | `/contract/base_info` | `home/contract/contractBaseInfo` | [data/route/home.php:130](../../data/route/home.php#L130) |
| POST | `/contract/contract` | `home/contract/contractCreate` | [data/route/home.php:131](../../data/route/home.php#L131) |
| GET | `/contract/contract_page` | `home/contract/contract` | [data/route/home.php:132](../../data/route/home.php#L132) |
| POST | `/contract/contract_sign` | `home/contract/contractSign` | [data/route/home.php:133](../../data/route/home.php#L133) |
| POST | `/contract/contract/:id` | `home/contract/contractPost` | [data/route/home.php:134](../../data/route/home.php#L134) |
| GET | `/contract/contract` | `home/contract/contractList` | [data/route/home.php:135](../../data/route/home.php#L135) |
| GET | `/contract/download/:id` | `home/contract/download` | [data/route/home.php:136](../../data/route/home.php#L136) |
| GET | `/contract/post/:id` | `home/contract/postPage` | [data/route/home.php:137](../../data/route/home.php#L137) |
| POST | `/contract/post/:id` | `home/contract/postPost` | [data/route/home.php:138](../../data/route/home.php#L138) |
| GET | `/contract/post_cancel/:id` | `home/contract/postCancel` | [data/route/home.php:139](../../data/route/home.php#L139) |
| GET | `/contract/cancel/:id` | `home/contract/cancel` | [data/route/home.php:140](../../data/route/home.php#L140) |
| DELETE | `/contract/delete/:id` | `home/contract/delete` | [data/route/home.php:141](../../data/route/home.php#L141) |
| GET | `/contract/mail/:id` | `home/contract/mail` | [data/route/home.php:142](../../data/route/home.php#L142) |
| POST | `/orders` | `home/order/orders` | [data/route/home.php:143](../../data/route/home.php#L143) |
| POST | `/check_order` | `home/order/checkOrder` | [data/route/home.php:144](../../data/route/home.php#L144) |
| POST | `/queryMerchantOrder` | `plugin/wx_pay/index/queryMerchantOrder` | [data/route/home.php:145](../../data/route/home.php#L145) |
| GET | `/get_gateways/[:module]/` | `home/pay/getGatewayList` | [data/route/home.php:146](../../data/route/home.php#L146) |
| GET | `/recharge_page` | `home/pay/rechargePage` | [data/route/home.php:147](../../data/route/home.php#L147) |
| POST | `/recharge` | `home/pay/recharge` | [data/route/home.php:148](../../data/route/home.php#L148) |
| GET | `/order_list` | `home/pay/orderList` | [data/route/home.php:149](../../data/route/home.php#L149) |
| POST | `/start_pay` | `home/pay/startPay` | [data/route/home.php:150](../../data/route/home.php#L150) |
| GET | `/use_credit_page` | `home/pay/useCreditPage` | [data/route/home.php:151](../../data/route/home.php#L151) |
| POST | `/invoice_page` | `home/pay/invoicePage` | [data/route/home.php:152](../../data/route/home.php#L152) |
| POST | `/apply_credit` | `home/pay/applyCredit` | [data/route/home.php:153](../../data/route/home.php#L153) |
| POST | `/apply_credit_limit` | `home/pay/applyCreditLimit` | [data/route/home.php:154](../../data/route/home.php#L154) |
| POST | `/ticket/evaluate` | `home/ticket/evaluate` | [data/route/home.php:155](../../data/route/home.php#L155) |
| GET | `/ticket/list` | `home/ticket/getList` | [data/route/home.php:156](../../data/route/home.php#L156) |
| POST | `/cart/settle` | `home/cart/settle` | [data/route/home.php:157](../../data/route/home.php#L157) |
| GET | `/cartgateway` | `home/Cart/getGateway` | [data/route/home.php:158](../../data/route/home.php#L158) |
| RESOURCE | `/invoices` | `home/user_invoice` | [data/route/home.php:159](../../data/route/home.php#L159) |
| DELETE | `/invoices/:id` | `home/user_invoice/deleteOrder` | [data/route/home.php:160](../../data/route/home.php#L160) |
| GET | `/get_invoices` | `home/user_invoice/getInvoices` | [data/route/home.php:161](../../data/route/home.php#L161) |
| GET | `/get_invoices_detail` | `home/user_invoice/getInvoicesDetail` | [data/route/home.php:162](../../data/route/home.php#L162) |
| GET | `/finance_record` | `home/user_invoice/financeRecord` | [data/route/home.php:163](../../data/route/home.php#L163) |
| GET | `/accounts_record` | `home/user_invoice/accountsRecord` | [data/route/home.php:164](../../data/route/home.php#L164) |
| GET | `/credit_record` | `home/user_invoice/creditRecord` | [data/route/home.php:165](../../data/route/home.php#L165) |
| GET | `/consume_record` | `home/user_invoice/consumeRecord` | [data/route/home.php:166](../../data/route/home.php#L166) |
| GET | `/recharge_record` | `home/user_invoice/rechargeRecord` | [data/route/home.php:167](../../data/route/home.php#L167) |
| GET | `/refund_record` | `home/user_invoice/refundRecord` | [data/route/home.php:168](../../data/route/home.php#L168) |
| GET | `/withdraw_record` | `home/user_invoice/withdrawRecord` | [data/route/home.php:169](../../data/route/home.php#L169) |
| GET | `/get_combine_invoices` | `home/user_invoice/getCombineInvoices` | [data/route/home.php:170](../../data/route/home.php#L170) |
| POST | `/combine_invoices` | `home/user_invoice/combineInvoices` | [data/route/home.php:171](../../data/route/home.php#L171) |
| CONTROLLER | `/host` | `home/Host` | [data/route/home.php:172](../../data/route/home.php#L172) |
| GET | `/getHostStatus` | `home/Host/getHostStatus` | [data/route/home.php:173](../../data/route/home.php#L173) |
| GET | `/credit_limit` | `home/credit_limit/index` | [data/route/home.php:174](../../data/route/home.php#L174) |
| GET | `/credit_limit/list` | `home/credit_limit/list` | [data/route/home.php:175](../../data/route/home.php#L175) |
| GET | `/credit_limit/user_invoice` | `home/credit_limit/userInvoice` | [data/route/home.php:176](../../data/route/home.php#L176) |
| GET | `/credit_limit/user_invoice_detail` | `home/credit_limit/creditLimitInvoice` | [data/route/home.php:177](../../data/route/home.php#L177) |
| GET | `/credit_limit/user_invoice_detail` | `home/credit_limit/creditLimitInvoice` | [data/route/home.php:178](../../data/route/home.php#L178) |
| POST | `/credit_limit/prepayment` | `home/credit_limit/creditLimitPrepayment` | [data/route/home.php:179](../../data/route/home.php#L179) |
| GET | `/contacts/index` | `home/contacts/index` | [data/route/home.php:180](../../data/route/home.php#L180) |
| POST | `/contacts/save` | `home/contacts/save` | [data/route/home.php:181](../../data/route/home.php#L181) |
| DELETE | `/contacts/del` | `home/contacts/delete` | [data/route/home.php:182](../../data/route/home.php#L182) |
| GET | `/user_logs` | `home/record_log/getUserLogs` | [data/route/home.php:183](../../data/route/home.php#L183) |
| ANY | `/user_logdcims` | `home/record_log/getUserLogDcs` | [data/route/home.php:184](../../data/route/home.php#L184) |
| GET | `/ticket/department` | `home/ticket/getDepartmentList` | [data/route/home.php:185](../../data/route/home.php#L185) |
| GET | `/ticket/get_custom` | `home/ticket/getTicketCustom` | [data/route/home.php:186](../../data/route/home.php#L186) |
| GET | `/ticket/ticket_page` | `home/ticket/getOpenTicketPage` | [data/route/home.php:187](../../data/route/home.php#L187) |
| POST | `/ticket/create` | `home/ticket/createTicket` | [data/route/home.php:188](../../data/route/home.php#L188) |
| GET | `/ticket/detail` | `home/ticket/ticketDetail` | [data/route/home.php:189](../../data/route/home.php#L189) |
| POST | `/ticket/reply` | `home/ticket/replyTicket` | [data/route/home.php:190](../../data/route/home.php#L190) |
| POST | `/ticket/close` | `home/ticket/closeTicket` | [data/route/home.php:191](../../data/route/home.php#L191) |
| POST | `/ticket/download` | `home/ticket/downloadAttachment` | [data/route/home.php:192](../../data/route/home.php#L192) |
| GET | `/upgrade/index/:hid` | `home/upgrade/index` | [data/route/home.php:193](../../data/route/home.php#L193) |
| POST | `/upgrade/upgrade_config_post` | `home/upgrade/upgradeConfigPost` | [data/route/home.php:194](../../data/route/home.php#L194) |
| GET | `/upgrade/upgrade_config_page` | `home/upgrade/getUpgradeConfigPage` | [data/route/home.php:195](../../data/route/home.php#L195) |
| POST | `/upgrade/add_promo_code` | `home/upgrade/addPromoCodeToConfig` | [data/route/home.php:196](../../data/route/home.php#L196) |
| POST | `/upgrade/remove_promo_code` | `home/upgrade/removePromoCodeFromConfig` | [data/route/home.php:197](../../data/route/home.php#L197) |
| POST | `/upgrade/checkout_config_upgrade` | `home/upgrade/checkoutConfigUpgrade` | [data/route/home.php:198](../../data/route/home.php#L198) |
| GET | `/upgrade/upgrade_product/:hid` | `home/upgrade/upgradeProduct` | [data/route/home.php:199](../../data/route/home.php#L199) |
| POST | `/upgrade/upgrade_product_post` | `home/upgrade/upgradeProductPost` | [data/route/home.php:200](../../data/route/home.php#L200) |
| GET | `/upgrade/upgrade_product_page` | `home/upgrade/getUpgradeProductPage` | [data/route/home.php:201](../../data/route/home.php#L201) |
| POST | `/upgrade/add_promo_code_product` | `home/upgrade/addPromoToProduct` | [data/route/home.php:202](../../data/route/home.php#L202) |
| POST | `/upgrade/remove_promo_code_product` | `home/upgrade/RemovePromoFromProduct` | [data/route/home.php:203](../../data/route/home.php#L203) |
| POST | `/upgrade/checkout_upgrade_product` | `home/upgrade/checkoutProductUpgrade` | [data/route/home.php:204](../../data/route/home.php#L204) |
| POST | `/dcim/buy_flow_packet` | `home/dcim/buyFlowPacket` | [data/route/home.php:205](../../data/route/home.php#L205) |
| POST | `/dcim/check_reinstall` | `home/dcim/checkReinstall` | [data/route/home.php:206](../../data/route/home.php#L206) |
| POST | `/dcim/buy_reinstall_times` | `home/dcim/buyReinstallTimes` | [data/route/home.php:207](../../data/route/home.php#L207) |
| POST | `/dcim/on` | `home/dcim/on` | [data/route/home.php:208](../../data/route/home.php#L208) |
| POST | `/dcim/off` | `home/dcim/off` | [data/route/home.php:209](../../data/route/home.php#L209) |
| POST | `/dcim/reboot` | `home/dcim/reboot` | [data/route/home.php:210](../../data/route/home.php#L210) |
| POST | `/dcim/bmc` | `home/dcim/bmc` | [data/route/home.php:211](../../data/route/home.php#L211) |
| POST | `/dcim/kvm` | `home/dcim/kvm` | [data/route/home.php:212](../../data/route/home.php#L212) |
| POST | `/dcim/ikvm` | `home/dcim/ikvm` | [data/route/home.php:213](../../data/route/home.php#L213) |
| POST | `/dcim/reinstall` | `home/dcim/reinstall` | [data/route/home.php:214](../../data/route/home.php#L214) |
| GET | `/dcim/resintall_status` | `home/dcim/getReinstallStatus` | [data/route/home.php:215](../../data/route/home.php#L215) |
| POST | `/dcim/rescue` | `home/dcim/rescue` | [data/route/home.php:216](../../data/route/home.php#L216) |
| POST | `/dcim/crack_pass` | `home/dcim/crackPass` | [data/route/home.php:217](../../data/route/home.php#L217) |
| GET | `/dcim/traffic_usage` | `home/dcim/getTrafficUsage` | [data/route/home.php:218](../../data/route/home.php#L218) |
| POST | `/dcim/cancel_task` | `home/dcim/cancelReinstall` | [data/route/home.php:219](../../data/route/home.php#L219) |
| POST | `/dcim/unsuspend_reinstall` | `home/dcim/unsuspendReload` | [data/route/home.php:220](../../data/route/home.php#L220) |
| POST | `/dcim/refresh_all_power_status` | `home/dcim/refreshPowerStatus` | [data/route/home.php:221](../../data/route/home.php#L221) |
| POST | `/dcim/traffic` | `home/dcim/traffic` | [data/route/home.php:222](../../data/route/home.php#L222) |
| POST | `/dcim/novnc` | `home/dcim/novnc` | [data/route/home.php:223](../../data/route/home.php#L223) |
| POST | `/dcim/check_all_status` | `home/dcim/checkAllReinstallStatus` | [data/route/home.php:224](../../data/route/home.php#L224) |
| GET | `/dcim/detail` | `home/dcim/detail` | [data/route/home.php:225](../../data/route/home.php#L225) |
| POST | `/dcim/hide_result` | `home/dcim/hideLastResult` | [data/route/home.php:226](../../data/route/home.php#L226) |
| POST | `/dcim/refresh_power_status` | `home/dcim/refreshServerPowerStatus` | [data/route/home.php:227](../../data/route/home.php#L227) |
| POST | `/provision/default` | `home/provision/execute` | [data/route/home.php:228](../../data/route/home.php#L228) |
| POST | `/provision/custom/:id` | `home/provision/customFunc` | [data/route/home.php:229](../../data/route/home.php#L229) |
| GET | `/provision/chart/:id` | `home/provision/getChartData` | [data/route/home.php:230](../../data/route/home.php#L230) |
| POST | `/provision/button` | `home/provision/execCustomButton` | [data/route/home.php:231](../../data/route/home.php#L231) |
| POST | `/provision/sslCertFunc` | `home/provision/sslCertCustomButton` | [data/route/home.php:232](../../data/route/home.php#L232) |
| GET | `/provision/certDown/:orderNo` | `home/provision/sslCertDown` | [data/route/home.php:233](../../data/route/home.php#L233) |
| POST | `/zjmf_api/provision/custom/content` | `home/provision/postClientAreaContent` | [data/route/home.php:234](../../data/route/home.php#L234) |
| GET | `/navindex` | `home/common/index` | [data/route/home.php:235](../../data/route/home.php#L235) |
| GET | `/addindex_page` | `home/common/addindexPage` | [data/route/home.php:236](../../data/route/home.php#L236) |
| POST | `/addindex_post` | `home/common/addindexPost` | [data/route/home.php:237](../../data/route/home.php#L237) |
| POST | `/addindex_del` | `home/common/addindexDel` | [data/route/home.php:238](../../data/route/home.php#L238) |
| GET | `/create_list` | `home/index/createList` | [data/route/home.php:239](../../data/route/home.php#L239) |
| POST | `/cart/clear` | `home/cart/clearCart` | [data/route/home.php:240](../../data/route/home.php#L240) |
| POST | `/uploads` | `home/upload/upload` | [data/route/home.php:241](../../data/route/home.php#L241) |
| POST | `/upper/dcim_client/reinstall` | `home/upperReaches/dcimClientReinstall` | [data/route/home.php:242](../../data/route/home.php#L242) |
| POST | `/upper/dcim_client/crack_pass` | `home/upperReaches/dcimClientCrackPass` | [data/route/home.php:243](../../data/route/home.php#L243) |
| POST | `/upper/dcim_client/cancel_task` | `home/upperReaches/dcimClientCancelReinstall` | [data/route/home.php:244](../../data/route/home.php#L244) |
| POST | `/upper/dcim_client/resintall_status` | `home/upperReaches/dcimClientReinstallStatus` | [data/route/home.php:245](../../data/route/home.php#L245) |
| POST | `/upper/dcim_client/get_os` | `home/upperReaches/dcimClientGetOs` | [data/route/home.php:246](../../data/route/home.php#L246) |
| GET | `/oauthBind` | `home/oauthBind/listing` | [data/route/home.php:247](../../data/route/home.php#L247) |
| POST | `/oauthBind/bind/[:dirName]` | `home/oauthBind/bind` | [data/route/home.php:248](../../data/route/home.php#L248) |
| POST | `/oauthBind/untie/[:dirName]` | `home/oauthBind/untie` | [data/route/home.php:249](../../data/route/home.php#L249) |
| CONTROLLER | `/voucher` | `home/Voucher` | [data/route/home.php:250](../../data/route/home.php#L250) |
| POST | `/product_divert/postNameToUser` | `home/productDivert/postNameToUser` | [data/route/home.php:254](../../data/route/home.php#L254) |
| POST | `/change_paymt` | `home/pay/changePaymt` | [data/route/home.php:259](../../data/route/home.php#L259) |
| POST | `/zjmf_finance_api/reset` | `home/ZjmfFinanceApi/resetApiPwd` | [data/route/home.php:260](../../data/route/home.php#L260) |
| POST | `/zjmf_finance_api/open` | `home/ZjmfFinanceApi/apiOpen` | [data/route/home.php:261](../../data/route/home.php#L261) |
| GET | `/zjmf_finance_api/summary` | `home/ZjmfFinanceApi/summary` | [data/route/home.php:262](../../data/route/home.php#L262) |
| GET | `/interflow/accountbind` | `home/interflow/interflowAccountBindInfo` | [data/route/home.php:263](../../data/route/home.php#L263) |
| POST | `/interflow/accountbind` | `home/interflow/interflowAccountBind` | [data/route/home.php:264](../../data/route/home.php#L264) |
| GET | `/common_list` | `home/index/common_list` | [data/route/home.php:267](../../data/route/home.php#L267) |
| GET | `/login_register_index` | `home/login/LoginRegisterIndex` | [data/route/home.php:268](../../data/route/home.php#L268) |
| POST | `/register_phone_send` | `home/register/registerPhoneSend` | [data/route/home.php:269](../../data/route/home.php#L269) |
| POST | `/register_email_send` | `home/register/registerEmailSend` | [data/route/home.php:270](../../data/route/home.php#L270) |
| POST | `/register_phone` | `home/register/registerPhone` | [data/route/home.php:271](../../data/route/home.php#L271) |
| POST | `/register_email` | `home/register/registerEmail` | [data/route/home.php:272](../../data/route/home.php#L272) |
| POST | `/reset_phone_send` | `home/register/resetPhoneSend` | [data/route/home.php:273](../../data/route/home.php#L273) |
| POST | `/reset_email_send` | `home/register/resetEmailSend` | [data/route/home.php:274](../../data/route/home.php#L274) |
| POST | `/reset_phone` | `home/register/passPhoneReset` | [data/route/home.php:275](../../data/route/home.php#L275) |
| POST | `/reset_email` | `home/register/passEmailReset` | [data/route/home.php:276](../../data/route/home.php#L276) |
| GET | `/wechat_login` | `home/wechat/index` | [data/route/home.php:277](../../data/route/home.php#L277) |
| GET | `/get_wechat_config` | `home/wechat/get_wechat_config` | [data/route/home.php:278](../../data/route/home.php#L278) |
| GET | `/wechat_login_handle` | `home/wechat/login_handle` | [data/route/home.php:279](../../data/route/home.php#L279) |
| GET | `/mobile_login_page` | `home/login/mobileLoginVerifyPage` | [data/route/home.php:280](../../data/route/home.php#L280) |
| POST | `/login_send` | `home/login/mobileSend` | [data/route/home.php:281](../../data/route/home.php#L281) |
| POST | `/mobile_login` | `home/login/mobileLoginVerify` | [data/route/home.php:282](../../data/route/home.php#L282) |
| POST | `/login_pass_phone` | `home/login/phonePassLogin` | [data/route/home.php:283](../../data/route/home.php#L283) |
| POST | `/login_pass_email` | `home/login/emailLogin` | [data/route/home.php:284](../../data/route/home.php#L284) |
| POST | `/zjmf_api_login` | `home/login/zjmfApiLogin` | [data/route/home.php:285](../../data/route/home.php#L285) |
| GET | `/cart/all` | `home/cart/getProducts` | [data/route/home.php:287](../../data/route/home.php#L287) |
| GET | `/cart/get_product_config` | `home/cart/getProductConfig` | [data/route/home.php:288](../../data/route/home.php#L288) |
| GET | `/cart/summary` | `home/Cart/summary` | [data/route/home.php:289](../../data/route/home.php#L289) |
| GET | `/cart/ontrialmax` | `home/Cart/ontrialAndMax` | [data/route/home.php:290](../../data/route/home.php#L290) |
| GET | `/cart/hostinfo` | `home/Cart/hostInfo` | [data/route/home.php:291](../../data/route/home.php#L291) |
| GET | `/cart/credit` | `home/Cart/getCredit` | [data/route/home.php:292](../../data/route/home.php#L292) |
| GET | `/cart/stock_control` | `home/Cart/getQty` | [data/route/home.php:293](../../data/route/home.php#L293) |
| POST | `/cart/resource_product` | `home/Cart/postResourceProduct` | [data/route/home.php:294](../../data/route/home.php#L294) |
| POST | `/cart/createproducts` | `home/Cart/postCreateProducts` | [data/route/home.php:295](../../data/route/home.php#L295) |
| POST | `/cart/productsgroups` | `home/Cart/postProductGroups` | [data/route/home.php:296](../../data/route/home.php#L296) |
| GET | `/cart/global_search` | `home/cart/globalSearch` | [data/route/home.php:297](../../data/route/home.php#L297) |
| GET | `/cart/index` | `home/cart/index` | [data/route/home.php:298](../../data/route/home.php#L298) |
| GET | `/cart/set_config` | `home/cart/setConfig` | [data/route/home.php:299](../../data/route/home.php#L299) |
| GET | `/cart/advanced_config` | `home/cart/advancedConfig` | [data/route/home.php:300](../../data/route/home.php#L300) |
| GET | `/cart/set_config_post` | `home/cart/setConfigPost` | [data/route/home.php:301](../../data/route/home.php#L301) |
| POST | `/cart/get_total` | `home/cart/getTotal` | [data/route/home.php:302](../../data/route/home.php#L302) |
| POST | `/cart/add_to_shop` | `home/cart/addToShop` | [data/route/home.php:303](../../data/route/home.php#L303) |
| POST | `/cart/modify_product_qty` | `home/cart/modifyProductQty` | [data/route/home.php:304](../../data/route/home.php#L304) |
| GET | `/cart/edit_to_shop_page` | `home/cart/editToShopPage` | [data/route/home.php:305](../../data/route/home.php#L305) |
| POST | `/cart/edit_to_shop` | `home/cart/editToShop` | [data/route/home.php:306](../../data/route/home.php#L306) |
| GET | `/cart/get_shop_data` | `home/cart/getShopDataPage` | [data/route/home.php:307](../../data/route/home.php#L307) |
| POST | `/cart/add_promo` | `home/cart/addPromoToShop` | [data/route/home.php:308](../../data/route/home.php#L308) |
| POST | `/cart/remove_promo` | `home/cart/removePromoToShop` | [data/route/home.php:309](../../data/route/home.php#L309) |
| POST | `/cart/remove_product` | `home/cart/removeProduct` | [data/route/home.php:310](../../data/route/home.php#L310) |
| GET | `/cart/shop` | `home/test/cartPage` | [data/route/home.php:311](../../data/route/home.php#L311) |
| GET | `/cart/check_promo_code` | `home/test/checkPromoCode` | [data/route/home.php:312](../../data/route/home.php#L312) |
| GET | `/cart/check_page` | `home/cart/checkoutPage` | [data/route/home.php:313](../../data/route/home.php#L313) |
| GET | `/cart/prolist` | `home/cart/proList` | [data/route/home.php:314](../../data/route/home.php#L314) |
| CONTROLLER | `/news` | `home/News` | [data/route/home.php:315](../../data/route/home.php#L315) |
| GET | `/news/list` | `home/News/getList` | [data/route/home.php:316](../../data/route/home.php#L316) |
| GET | `/news/notice` | `home/News/getNotice` | [data/route/home.php:317](../../data/route/home.php#L317) |
| GET | `/news/content` | `home/News/getContent` | [data/route/home.php:318](../../data/route/home.php#L318) |
| GET | `/news/catelist` | `home/News/getCateList` | [data/route/home.php:319](../../data/route/home.php#L319) |
| GET | `/notice/list` | `home/News/getNoticeList` | [data/route/home.php:320](../../data/route/home.php#L320) |
| GET | `/notice/content` | `home/News/getNoticeContent` | [data/route/home.php:321](../../data/route/home.php#L321) |
| GET | `/areas/[:pid]/` | `home/user/areas` | [data/route/home.php:323](../../data/route/home.php#L323) |
| GET | `/country` | `home/user/country` | [data/route/home.php:324](../../data/route/home.php#L324) |
| GET | `/knowledge_base/index` | `home/knowledge_base/index` | [data/route/home.php:325](../../data/route/home.php#L325) |
| POST | `/knowledge_base/search_article` | `home/knowledge_base/searchArticle` | [data/route/home.php:326](../../data/route/home.php#L326) |
| POST | `/knowledge_base/tags_list` | `home/knowledge_base/tagsList` | [data/route/home.php:327](../../data/route/home.php#L327) |
| GET | `/knowledge_base/view_article/:id` | `home/knowledge_base/viewArticle` | [data/route/home.php:328](../../data/route/home.php#L328) |
| GET | `/sale_list` | `home/index/SaleList` | [data/route/home.php:329](../../data/route/home.php#L329) |
| GET | `/ticket/download` | `home/ticket/download` | [data/route/home.php:330](../../data/route/home.php#L330) |
| GET | `/get_saler` | `home/user/getSaler` | [data/route/home.php:331](../../data/route/home.php#L331) |
| POST | `/set_saler` | `home/user/setSaler` | [data/route/home.php:332](../../data/route/home.php#L332) |
| GET | `/dcim/download` | `home/dcim/download` | [data/route/home.php:333](../../data/route/home.php#L333) |
| GET | `/dcim/novnc` | `home/dcim/novncPage` | [data/route/home.php:334](../../data/route/home.php#L334) |
| GET | `/product_list_page` | `home/login/getProuductlistPage` | [data/route/home.php:335](../../data/route/home.php#L335) |
| GET | `/config_general/header` | `home/index/getHeader` | [data/route/home.php:336](../../data/route/home.php#L336) |
| POST | `/upload_image` | `home/upload/uploadImage` | [data/route/home.php:337](../../data/route/home.php#L337) |
| POST | `/home/upload_file` | `home/upload/uploadFile` | [data/route/home.php:338](../../data/route/home.php#L338) |
| GET | `/download/product_file` | `home/down/productFile` | [data/route/home.php:339](../../data/route/home.php#L339) |
| GET | `/download/cates` | `home/down/cates` | [data/route/home.php:340](../../data/route/home.php#L340) |
| POST | `/download/search` | `home/down/search` | [data/route/home.php:341](../../data/route/home.php#L341) |
| GET | `/login/second_verify_page` | `home/login/getSecondVerifyPage` | [data/route/home.php:342](../../data/route/home.php#L342) |
| POST | `/login/second_verify_send` | `home/login/secondVerifySend` | [data/route/home.php:343](../../data/route/home.php#L343) |
| GET | `/cart/market_app` | `home/cart/getMarketApp` | [data/route/home.php:344](../../data/route/home.php#L344) |
| GET | `/oauth` | `home/oauth/listing` | [data/route/home.php:345](../../data/route/home.php#L345) |
| GET | `/oauth/url/[:dirName]` | `home/oauth/url` | [data/route/home.php:346](../../data/route/home.php#L346) |
| GET | `/oauth/callback/[:dirName]` | `home/oauth/callback` | [data/route/home.php:347](../../data/route/home.php#L347) |
| GET | `/oauth/callbackInfo` | `home/oauth/callbackInfo` | [data/route/home.php:348](../../data/route/home.php#L348) |
| POST | `/oauth/bind_login_email` | `home/oauth/bindLoginEmail` | [data/route/home.php:349](../../data/route/home.php#L349) |
| POST | `/oauth/bind_login_phone` | `home/oauth/bindLoginPhone` | [data/route/home.php:350](../../data/route/home.php#L350) |
| POST | `/oauth/bind_email_send` | `home/oauth/bindEmailSend` | [data/route/home.php:351](../../data/route/home.php#L351) |
| POST | `/oauth/bind_phone_send` | `home/oauth/bindPhoneSend` | [data/route/home.php:352](../../data/route/home.php#L352) |
| GET | `/config_general/friendlyLinks` | `home/index/getFriendlyLinks` | [data/route/home.php:353](../../data/route/home.php#L353) |
| GET | `/verify` | `home/login/verify` | [data/route/home.php:355](../../data/route/home.php#L355) |
| GET | `/aff/[:identy]` | `home/login/aff` | [data/route/home.php:356](../../data/route/home.php#L356) |
| GET | `/provision/custom/content` | `home/provision/getClientAreaContent` | [data/route/home.php:357](../../data/route/home.php#L357) |
| ANY | `/demots` | `home/test/demo_ts` | [data/route/home.php:358](../../data/route/home.php#L358) |
| ANY | `/shell` | `home/test/shell_scipt` | [data/route/home.php:359](../../data/route/home.php#L359) |

## CONTROLLER 公有方法推导候选

按 vendor/thinkphp/library/think/Route.php 的默认 get/post/put/delete/patch 前缀，提取本控制器文件内公有方法。未包含继承/trait 方法、运行时前缀修改、参数 pattern 和显式路由优先级；URL 大小写/下划线别名须运行验证。候选不等于 HTTP 可达证据，也不并入字面量声明计数。

| 方法 | 推导 URL | 实际方法 | 源码 |
| --- | --- | --- | --- |
| GET | `{A}/config_general/NewLoginPage` | `admin/ConfigGeneral/getNewLoginPage` | [app/admin/controller/ConfigGeneralController.php:19](../../app/admin/controller/ConfigGeneralController.php#L19) |
| POST | `{A}/config_general/NewLoginPage` | `admin/ConfigGeneral/postNewLoginPage` | [app/admin/controller/ConfigGeneralController.php:25](../../app/admin/controller/ConfigGeneralController.php#L25) |
| GET | `{A}/config_general/Header` | `admin/ConfigGeneral/getHeader` | [app/admin/controller/ConfigGeneralController.php:286](../../app/admin/controller/ConfigGeneralController.php#L286) |
| GET | `{A}/config_general/General` | `admin/ConfigGeneral/getGeneral` | [app/admin/controller/ConfigGeneralController.php:353](../../app/admin/controller/ConfigGeneralController.php#L353) |
| POST | `{A}/config_general/NewGeneral` | `admin/ConfigGeneral/postNewGeneral` | [app/admin/controller/ConfigGeneralController.php:391](../../app/admin/controller/ConfigGeneralController.php#L391) |
| POST | `{A}/config_general/GetConfig` | `admin/ConfigGeneral/postGetConfig` | [app/admin/controller/ConfigGeneralController.php:441](../../app/admin/controller/ConfigGeneralController.php#L441) |
| POST | `{A}/config_general/GetConfigOption` | `admin/ConfigGeneral/postGetConfigOption` | [app/admin/controller/ConfigGeneralController.php:466](../../app/admin/controller/ConfigGeneralController.php#L466) |
| POST | `{A}/config_general/General` | `admin/ConfigGeneral/postGeneral` | [app/admin/controller/ConfigGeneralController.php:570](../../app/admin/controller/ConfigGeneralController.php#L570) |
| GET | `{A}/config_general/Local` | `admin/ConfigGeneral/getLocal` | [app/admin/controller/ConfigGeneralController.php:818](../../app/admin/controller/ConfigGeneralController.php#L818) |
| POST | `{A}/config_general/Local` | `admin/ConfigGeneral/postLocal` | [app/admin/controller/ConfigGeneralController.php:853](../../app/admin/controller/ConfigGeneralController.php#L853) |
| GET | `{A}/config_general/Support` | `admin/ConfigGeneral/getSupport` | [app/admin/controller/ConfigGeneralController.php:887](../../app/admin/controller/ConfigGeneralController.php#L887) |
| POST | `{A}/config_general/Support` | `admin/ConfigGeneral/postSupport` | [app/admin/controller/ConfigGeneralController.php:913](../../app/admin/controller/ConfigGeneralController.php#L913) |
| GET | `{A}/config_general/Affiliate` | `admin/ConfigGeneral/getAffiliate` | [app/admin/controller/ConfigGeneralController.php:954](../../app/admin/controller/ConfigGeneralController.php#L954) |
| POST | `{A}/config_general/Affiliate` | `admin/ConfigGeneral/postAffiliate` | [app/admin/controller/ConfigGeneralController.php:988](../../app/admin/controller/ConfigGeneralController.php#L988) |
| GET | `{A}/config_general/Safe` | `admin/ConfigGeneral/getSafe` | [app/admin/controller/ConfigGeneralController.php:1368](../../app/admin/controller/ConfigGeneralController.php#L1368) |
| POST | `{A}/config_general/Safe` | `admin/ConfigGeneral/postSafe` | [app/admin/controller/ConfigGeneralController.php:1393](../../app/admin/controller/ConfigGeneralController.php#L1393) |
| GET | `{A}/config_general/Other` | `admin/ConfigGeneral/getOther` | [app/admin/controller/ConfigGeneralController.php:1422](../../app/admin/controller/ConfigGeneralController.php#L1422) |
| POST | `{A}/config_general/Other` | `admin/ConfigGeneral/postOther` | [app/admin/controller/ConfigGeneralController.php:1463](../../app/admin/controller/ConfigGeneralController.php#L1463) |
| GET | `{A}/config_general/Recharge` | `admin/ConfigGeneral/getRecharge` | [app/admin/controller/ConfigGeneralController.php:1505](../../app/admin/controller/ConfigGeneralController.php#L1505) |
| POST | `{A}/config_general/Recharge` | `admin/ConfigGeneral/postRecharge` | [app/admin/controller/ConfigGeneralController.php:1534](../../app/admin/controller/ConfigGeneralController.php#L1534) |
| GET | `{A}/config_general/Invoice` | `admin/ConfigGeneral/getInvoice` | [app/admin/controller/ConfigGeneralController.php:1600](../../app/admin/controller/ConfigGeneralController.php#L1600) |
| POST | `{A}/config_general/Invoice` | `admin/ConfigGeneral/postInvoice` | [app/admin/controller/ConfigGeneralController.php:1629](../../app/admin/controller/ConfigGeneralController.php#L1629) |
| POST | `{A}/config_general/LoginErrorMax` | `admin/ConfigGeneral/postLoginErrorMax` | [app/admin/controller/ConfigGeneralController.php:1829](../../app/admin/controller/ConfigGeneralController.php#L1829) |
| GET | `{A}/config_general/captcha_page` | `admin/ConfigGeneral/getcaptcha_page` | [app/admin/controller/ConfigGeneralController.php:1848](../../app/admin/controller/ConfigGeneralController.php#L1848) |
| POST | `{A}/config_general/register_login_captcha` | `admin/ConfigGeneral/postregister_login_captcha` | [app/admin/controller/ConfigGeneralController.php:1898](../../app/admin/controller/ConfigGeneralController.php#L1898) |
| GET | `{A}/config_general/ApiConfig` | `admin/ConfigGeneral/getApiConfig` | [app/admin/controller/ConfigGeneralController.php:2267](../../app/admin/controller/ConfigGeneralController.php#L2267) |
| POST | `{A}/config_general/ApiConfig` | `admin/ConfigGeneral/postApiConfig` | [app/admin/controller/ConfigGeneralController.php:2280](../../app/admin/controller/ConfigGeneralController.php#L2280) |
| GET | `{A}/config_general/SecondVerify` | `admin/ConfigGeneral/getSecondVerify` | [app/admin/controller/ConfigGeneralController.php:2305](../../app/admin/controller/ConfigGeneralController.php#L2305) |
| POST | `{A}/config_general/SecondVerify` | `admin/ConfigGeneral/postSecondVerify` | [app/admin/controller/ConfigGeneralController.php:2332](../../app/admin/controller/ConfigGeneralController.php#L2332) |
| GET | `{A}/config_general/BuyProductPage` | `admin/ConfigGeneral/getBuyProductPage` | [app/admin/controller/ConfigGeneralController.php:2380](../../app/admin/controller/ConfigGeneralController.php#L2380) |
| POST | `{A}/config_general/BuyProduct` | `admin/ConfigGeneral/postBuyProduct` | [app/admin/controller/ConfigGeneralController.php:2400](../../app/admin/controller/ConfigGeneralController.php#L2400) |
| GET | `{A}/config_general/DebugModel` | `admin/ConfigGeneral/getDebugModel` | [app/admin/controller/ConfigGeneralController.php:2419](../../app/admin/controller/ConfigGeneralController.php#L2419) |
| POST | `{A}/config_general/DebugModel` | `admin/ConfigGeneral/postDebugModel` | [app/admin/controller/ConfigGeneralController.php:2433](../../app/admin/controller/ConfigGeneralController.php#L2433) |
| GET | `{A}/downloads/List` | `admin/Downloads/getList` | [app/admin/controller/DownloadsController.php:27](../../app/admin/controller/DownloadsController.php#L27) |
| POST | `{A}/downloads/Create` | `admin/Downloads/postCreate` | [app/admin/controller/DownloadsController.php:71](../../app/admin/controller/DownloadsController.php#L71) |
| GET | `{A}/downloads/Edit` | `admin/Downloads/getEdit` | [app/admin/controller/DownloadsController.php:113](../../app/admin/controller/DownloadsController.php#L113) |
| POST | `{A}/downloads/Update` | `admin/Downloads/postUpdate` | [app/admin/controller/DownloadsController.php:144](../../app/admin/controller/DownloadsController.php#L144) |
| POST | `{A}/downloads/UpdateSort` | `admin/Downloads/postUpdateSort` | [app/admin/controller/DownloadsController.php:191](../../app/admin/controller/DownloadsController.php#L191) |
| DELETE | `{A}/downloads/Cat` | `admin/Downloads/deleteCat` | [app/admin/controller/DownloadsController.php:273](../../app/admin/controller/DownloadsController.php#L273) |
| POST | `{A}/downloads/AddFile` | `admin/Downloads/postAddFile` | [app/admin/controller/DownloadsController.php:323](../../app/admin/controller/DownloadsController.php#L323) |
| GET | `{A}/downloads/FilePage` | `admin/Downloads/getFilePage` | [app/admin/controller/DownloadsController.php:403](../../app/admin/controller/DownloadsController.php#L403) |
| POST | `{A}/downloads/SaveFile` | `admin/Downloads/postSaveFile` | [app/admin/controller/DownloadsController.php:449](../../app/admin/controller/DownloadsController.php#L449) |
| POST | `{A}/downloads/UploadFile` | `admin/Downloads/postUploadFile` | [app/admin/controller/DownloadsController.php:558](../../app/admin/controller/DownloadsController.php#L558) |
| DELETE | `{A}/downloads/File` | `admin/Downloads/deleteFile` | [app/admin/controller/DownloadsController.php:602](../../app/admin/controller/DownloadsController.php#L602) |
| GET | `{A}/downloads/File` | `admin/Downloads/getFile` | [app/admin/controller/DownloadsController.php:646](../../app/admin/controller/DownloadsController.php#L646) |
| GET | `{A}/downloads/UserDownList` | `admin/Downloads/getUserDownList` | [app/admin/controller/DownloadsController.php:680](../../app/admin/controller/DownloadsController.php#L680) |
| GET | `{A}/downloads/UserFile` | `admin/Downloads/getUserFile` | [app/admin/controller/DownloadsController.php:702](../../app/admin/controller/DownloadsController.php#L702) |
| POST | `{A}/downloads/UploadUserFile` | `admin/Downloads/postUploadUserFile` | [app/admin/controller/DownloadsController.php:727](../../app/admin/controller/DownloadsController.php#L727) |
| DELETE | `{A}/downloads/UserFile` | `admin/Downloads/deleteUserFile` | [app/admin/controller/DownloadsController.php:766](../../app/admin/controller/DownloadsController.php#L766) |
| POST | `{A}/downloads/AddUserFile` | `admin/Downloads/postAddUserFile` | [app/admin/controller/DownloadsController.php:812](../../app/admin/controller/DownloadsController.php#L812) |
| GET | `{A}/downloads/UserFilePage` | `admin/Downloads/getUserFilePage` | [app/admin/controller/DownloadsController.php:863](../../app/admin/controller/DownloadsController.php#L863) |
| POST | `{A}/downloads/SaveUserFile` | `admin/Downloads/postSaveUserFile` | [app/admin/controller/DownloadsController.php:884](../../app/admin/controller/DownloadsController.php#L884) |
| GET | `{A}/announce/List` | `admin/Announce/getList` | [app/admin/controller/AnnounceController.php:23](../../app/admin/controller/AnnounceController.php#L23) |
| DELETE | `{A}/announce/List` | `admin/Announce/deleteList` | [app/admin/controller/AnnounceController.php:41](../../app/admin/controller/AnnounceController.php#L41) |
| GET | `{A}/announce/Manage` | `admin/Announce/getManage` | [app/admin/controller/AnnounceController.php:80](../../app/admin/controller/AnnounceController.php#L80) |
| POST | `{A}/announce/Save` | `admin/Announce/postSave` | [app/admin/controller/AnnounceController.php:114](../../app/admin/controller/AnnounceController.php#L114) |
| GET | `{A}/news/List` | `admin/News/getList` | [app/admin/controller/NewsController.php:46](../../app/admin/controller/NewsController.php#L46) |
| GET | `{A}/news/CatsPage` | `admin/News/getCatsPage` | [app/admin/controller/NewsController.php:112](../../app/admin/controller/NewsController.php#L112) |
| GET | `{A}/news/CateList` | `admin/News/getCateList` | [app/admin/controller/NewsController.php:145](../../app/admin/controller/NewsController.php#L145) |
| GET | `{A}/news/CatData` | `admin/News/getCatData` | [app/admin/controller/NewsController.php:180](../../app/admin/controller/NewsController.php#L180) |
| POST | `{A}/news/EditCat` | `admin/News/postEditCat` | [app/admin/controller/NewsController.php:205](../../app/admin/controller/NewsController.php#L205) |
| GET | `{A}/news/Checkalias` | `admin/News/getCheckalias` | [app/admin/controller/NewsController.php:256](../../app/admin/controller/NewsController.php#L256) |
| DELETE | `{A}/news/Cat` | `admin/News/deleteCat` | [app/admin/controller/NewsController.php:278](../../app/admin/controller/NewsController.php#L278) |
| GET | `{A}/news/Content` | `admin/News/getContent` | [app/admin/controller/NewsController.php:329](../../app/admin/controller/NewsController.php#L329) |
| POST | `{A}/news/EditContent` | `admin/News/postEditContent` | [app/admin/controller/NewsController.php:361](../../app/admin/controller/NewsController.php#L361) |
| DELETE | `{A}/news/Content` | `admin/News/deleteContent` | [app/admin/controller/NewsController.php:445](../../app/admin/controller/NewsController.php#L445) |
| GET | `{A}/news/GetCustomParam` | `admin/News/getGetCustomParam` | [app/admin/controller/NewsController.php:469](../../app/admin/controller/NewsController.php#L469) |
| GET | `{A}/news/AddCustomParam` | `admin/News/getAddCustomParam` | [app/admin/controller/NewsController.php:499](../../app/admin/controller/NewsController.php#L499) |
| GET | `{A}/news/UpdateCustomParam` | `admin/News/getUpdateCustomParam` | [app/admin/controller/NewsController.php:525](../../app/admin/controller/NewsController.php#L525) |
| GET | `{A}/news/DelCustomParam` | `admin/News/getDelCustomParam` | [app/admin/controller/NewsController.php:552](../../app/admin/controller/NewsController.php#L552) |
| GET | `{A}/news/GetCustomUpdateVal` | `admin/News/getGetCustomUpdateVal` | [app/admin/controller/NewsController.php:573](../../app/admin/controller/NewsController.php#L573) |
| GET | `{A}/clients_services/ProductList` | `admin/ClientsServices/getProductList` | [app/admin/controller/ClientsServicesController.php:520](../../app/admin/controller/ClientsServicesController.php#L520) |
| POST | `{A}/clients_services/Info` | `admin/ClientsServices/postInfo` | [app/admin/controller/ClientsServicesController.php:560](../../app/admin/controller/ClientsServicesController.php#L560) |
| POST | `{A}/clients_services/Transfer` | `admin/ClientsServices/postTransfer` | [app/admin/controller/ClientsServicesController.php:807](../../app/admin/controller/ClientsServicesController.php#L807) |
| DELETE | `{A}/clients_services/Host` | `admin/ClientsServices/deleteHost` | [app/admin/controller/ClientsServicesController.php:864](../../app/admin/controller/ClientsServicesController.php#L864) |
| POST | `{A}/clients_services/BatchRenewPage` | `admin/ClientsServices/postBatchRenewPage` | [app/admin/controller/ClientsServicesController.php:965](../../app/admin/controller/ClientsServicesController.php#L965) |
| POST | `{A}/clients_services/BatchRenew` | `admin/ClientsServices/postBatchRenew` | [app/admin/controller/ClientsServicesController.php:1085](../../app/admin/controller/ClientsServicesController.php#L1085) |
| GET | `{A}/clients_services/ApplyCreditPage` | `admin/ClientsServices/getApplyCreditPage` | [app/admin/controller/ClientsServicesController.php:1122](../../app/admin/controller/ClientsServicesController.php#L1122) |
| POST | `{A}/clients_services/SearchClient` | `admin/ClientsServices/postSearchClient` | [app/admin/controller/ClientsServicesController.php:1307](../../app/admin/controller/ClientsServicesController.php#L1307) |
| GET | `{A}/clients_services/RefundPage` | `admin/ClientsServices/getRefundPage` | [app/admin/controller/ClientsServicesController.php:1417](../../app/admin/controller/ClientsServicesController.php#L1417) |
| GET | `{A}/cancel_request/List` | `admin/CancelRequest/getList` | [app/admin/controller/CancelRequestController.php:31](../../app/admin/controller/CancelRequestController.php#L31) |
| DELETE | `{A}/cancel_request/List` | `admin/CancelRequest/deleteList` | [app/admin/controller/CancelRequestController.php:65](../../app/admin/controller/CancelRequestController.php#L65) |
| GET | `{A}/cancel_request/CancelList` | `admin/CancelRequest/getCancelList` | [app/admin/controller/CancelRequestController.php:93](../../app/admin/controller/CancelRequestController.php#L93) |
| GET | `{A}/host/List` | `admin/Host/getList` | [app/admin/controller/HostController.php:82](../../app/admin/controller/HostController.php#L82) |
| GET | `{A}/host/Timetype` | `admin/Host/getTimetype` | [app/admin/controller/HostController.php:227](../../app/admin/controller/HostController.php#L227) |
| POST | `{A}/send_message/EmailPage` | `admin/SendMessage/postEmailPage` | [app/admin/controller/SendMessageController.php:32](../../app/admin/controller/SendMessageController.php#L32) |
| POST | `{A}/send_message/SendEmail` | `admin/SendMessage/postSendEmail` | [app/admin/controller/SendMessageController.php:86](../../app/admin/controller/SendMessageController.php#L86) |
| GET | `{A}/client_contacts/Page` | `admin/ClientsContacts/getPage` | [app/admin/controller/ClientsContactsController.php:51](../../app/admin/controller/ClientsContactsController.php#L51) |
| POST | `{A}/client_contacts/Save` | `admin/ClientsContacts/postSave` | [app/admin/controller/ClientsContactsController.php:110](../../app/admin/controller/ClientsContactsController.php#L110) |
| DELETE | `{A}/client_contacts/Contact` | `admin/ClientsContacts/deleteContact` | [app/admin/controller/ClientsContactsController.php:169](../../app/admin/controller/ClientsContactsController.php#L169) |
| GET | `{A}/system/commoninfo` | `admin/System/getcommoninfo` | [app/admin/controller/SystemController.php:25](../../app/admin/controller/SystemController.php#L25) |
| GET | `{A}/system/UpdateContent` | `admin/System/getUpdateContent` | [app/admin/controller/SystemController.php:38](../../app/admin/controller/SystemController.php#L38) |
| GET | `{A}/system/Info` | `admin/System/getInfo` | [app/admin/controller/SystemController.php:87](../../app/admin/controller/SystemController.php#L87) |
| GET | `{A}/system/LastVersion` | `admin/System/getLastVersion` | [app/admin/controller/SystemController.php:128](../../app/admin/controller/SystemController.php#L128) |
| GET | `{A}/system/PhpInfo` | `admin/System/getPhpInfo` | [app/admin/controller/SystemController.php:163](../../app/admin/controller/SystemController.php#L163) |
| GET | `{A}/system/DatabaseInfo` | `admin/System/getDatabaseInfo` | [app/admin/controller/SystemController.php:198](../../app/admin/controller/SystemController.php#L198) |
| POST | `{A}/system/OptimizeTables` | `admin/System/postOptimizeTables` | [app/admin/controller/SystemController.php:231](../../app/admin/controller/SystemController.php#L231) |
| POST | `{A}/system/DownDataBackup` | `admin/System/postDownDataBackup` | [app/admin/controller/SystemController.php:249](../../app/admin/controller/SystemController.php#L249) |
| POST | `{A}/system/ToggleVersion` | `admin/System/postToggleVersion` | [app/admin/controller/SystemController.php:276](../../app/admin/controller/SystemController.php#L276) |
| GET | `{A}/system/AutoUpdate` | `admin/System/getAutoUpdate` | [app/admin/controller/SystemController.php:296](../../app/admin/controller/SystemController.php#L296) |
| GET | `{A}/system/CheckAutoUpdate` | `admin/System/getCheckAutoUpdate` | [app/admin/controller/SystemController.php:363](../../app/admin/controller/SystemController.php#L363) |
| GET | `{A}/system/Authorize` | `admin/System/getAuthorize` | [app/admin/controller/SystemController.php:553](../../app/admin/controller/SystemController.php#L553) |
| PUT | `{A}/system/License` | `admin/System/putLicense` | [app/admin/controller/SystemController.php:576](../../app/admin/controller/SystemController.php#L576) |
| GET | `{A}/system/DataMigrate` | `admin/System/getDataMigrate` | [app/admin/controller/SystemController.php:614](../../app/admin/controller/SystemController.php#L614) |
| GET | `{A}/system/SystemAuthRuleLanguage` | `admin/System/getSystemAuthRuleLanguage` | [app/admin/controller/SystemController.php:629](../../app/admin/controller/SystemController.php#L629) |
| GET | `{A}/user_level/List` | `admin/UserLevel/getList` | [app/admin/controller/UserLevelController.php:33](../../app/admin/controller/UserLevelController.php#L33) |
| GET | `{A}/user_level/LevelPage` | `admin/UserLevel/getLevelPage` | [app/admin/controller/UserLevelController.php:75](../../app/admin/controller/UserLevelController.php#L75) |
| POST | `{A}/user_level/Level` | `admin/UserLevel/postLevel` | [app/admin/controller/UserLevelController.php:120](../../app/admin/controller/UserLevelController.php#L120) |
| DELETE | `{A}/user_level/Level` | `admin/UserLevel/deleteLevel` | [app/admin/controller/UserLevelController.php:163](../../app/admin/controller/UserLevelController.php#L163) |
| GET | `{A}/voucher/Rate` | `admin/Voucher/getRate` | [app/admin/controller/VoucherController.php:22](../../app/admin/controller/VoucherController.php#L22) |
| POST | `{A}/voucher/Rate` | `admin/Voucher/postRate` | [app/admin/controller/VoucherController.php:36](../../app/admin/controller/VoucherController.php#L36) |
| GET | `{A}/voucher/ExpressList` | `admin/Voucher/getExpressList` | [app/admin/controller/VoucherController.php:80](../../app/admin/controller/VoucherController.php#L80) |
| GET | `{A}/voucher/Express` | `admin/Voucher/getExpress` | [app/admin/controller/VoucherController.php:98](../../app/admin/controller/VoucherController.php#L98) |
| POST | `{A}/voucher/Express` | `admin/Voucher/postExpress` | [app/admin/controller/VoucherController.php:121](../../app/admin/controller/VoucherController.php#L121) |
| DELETE | `{A}/voucher/Express` | `admin/Voucher/deleteExpress` | [app/admin/controller/VoucherController.php:175](../../app/admin/controller/VoucherController.php#L175) |
| GET | `{A}/voucher/VoucherList` | `admin/Voucher/getVoucherList` | [app/admin/controller/VoucherController.php:242](../../app/admin/controller/VoucherController.php#L242) |
| GET | `{A}/voucher/VoucherDetail` | `admin/Voucher/getVoucherDetail` | [app/admin/controller/VoucherController.php:312](../../app/admin/controller/VoucherController.php#L312) |
| POST | `{A}/voucher/VoucherStatus` | `admin/Voucher/postVoucherStatus` | [app/admin/controller/VoucherController.php:370](../../app/admin/controller/VoucherController.php#L370) |
| GET | `{A}/agent/ResourceInfo` | `admin/Agent/getResourceInfo` | [app/admin/controller/AgentController.php:22](../../app/admin/controller/AgentController.php#L22) |
| POST | `{A}/agent/ResourceInfo` | `admin/Agent/postResourceInfo` | [app/admin/controller/AgentController.php:42](../../app/admin/controller/AgentController.php#L42) |
| POST | `{A}/agent/ResourceTicketOpen` | `admin/Agent/postResourceTicketOpen` | [app/admin/controller/AgentController.php:76](../../app/admin/controller/AgentController.php#L76) |
| POST | `{A}/agent/LinkToResource` | `admin/Agent/postLinkToResource` | [app/admin/controller/AgentController.php:95](../../app/admin/controller/AgentController.php#L95) |
| GET | `{A}/agent/Products` | `admin/Agent/getProducts` | [app/admin/controller/AgentController.php:164](../../app/admin/controller/AgentController.php#L164) |
| GET | `{A}/agent/OrderSearchPage` | `admin/Agent/getOrderSearchPage` | [app/admin/controller/AgentController.php:389](../../app/admin/controller/AgentController.php#L389) |
| GET | `{A}/agent/Order` | `admin/Agent/getOrder` | [app/admin/controller/AgentController.php:448](../../app/admin/controller/AgentController.php#L448) |
| GET | `{A}/agent/RenewSearchPage` | `admin/Agent/getRenewSearchPage` | [app/admin/controller/AgentController.php:537](../../app/admin/controller/AgentController.php#L537) |
| GET | `{A}/agent/Renew` | `admin/Agent/getRenew` | [app/admin/controller/AgentController.php:570](../../app/admin/controller/AgentController.php#L570) |
| GET | `{A}/agent/AfterSaleDetail` | `admin/Agent/getAfterSaleDetail` | [app/admin/controller/AgentController.php:641](../../app/admin/controller/AgentController.php#L641) |
| GET | `{A}/agent/RefundDetail` | `admin/Agent/getRefundDetail` | [app/admin/controller/AgentController.php:658](../../app/admin/controller/AgentController.php#L658) |
| GET | `{A}/agent/Host` | `admin/Agent/getHost` | [app/admin/controller/AgentController.php:705](../../app/admin/controller/AgentController.php#L705) |
| GET | `{A}/agent/InspectionLists` | `admin/Agent/getInspectionLists` | [app/admin/controller/AgentController.php:745](../../app/admin/controller/AgentController.php#L745) |
| POST | `{A}/agent/Upload` | `admin/Agent/postUpload` | [app/admin/controller/AgentController.php:763](../../app/admin/controller/AgentController.php#L763) |
| POST | `{A}/agent/ResourceInspection` | `admin/Agent/postResourceInspection` | [app/admin/controller/AgentController.php:797](../../app/admin/controller/AgentController.php#L797) |
| GET | `{A}/agent/InspectionIp` | `admin/Agent/getInspectionIp` | [app/admin/controller/AgentController.php:856](../../app/admin/controller/AgentController.php#L856) |
| GET | `{A}/agent/InspectionDetail` | `admin/Agent/getInspectionDetail` | [app/admin/controller/AgentController.php:918](../../app/admin/controller/AgentController.php#L918) |
| POST | `{A}/agent/Refund` | `admin/Agent/postRefund` | [app/admin/controller/AgentController.php:938](../../app/admin/controller/AgentController.php#L938) |
| POST | `{A}/agent/AfterSale` | `admin/Agent/postAfterSale` | [app/admin/controller/AgentController.php:957](../../app/admin/controller/AgentController.php#L957) |
| POST | `{A}/agent/UnAfterSale` | `admin/Agent/postUnAfterSale` | [app/admin/controller/AgentController.php:1000](../../app/admin/controller/AgentController.php#L1000) |
| GET | `{A}/agent/BaseInfo` | `admin/Agent/getBaseInfo` | [app/admin/controller/AgentController.php:1026](../../app/admin/controller/AgentController.php#L1026) |
| GET | `{A}/agent/AgentLogs` | `admin/Agent/getAgentLogs` | [app/admin/controller/AgentController.php:1072](../../app/admin/controller/AgentController.php#L1072) |
| GET | `{A}/agent/Consumption` | `admin/Agent/getConsumption` | [app/admin/controller/AgentController.php:1178](../../app/admin/controller/AgentController.php#L1178) |
| GET | `{A}/agent/Income` | `admin/Agent/getIncome` | [app/admin/controller/AgentController.php:1293](../../app/admin/controller/AgentController.php#L1293) |
| GET | `{A}/agent/HostLists` | `admin/Agent/getHostLists` | [app/admin/controller/AgentController.php:1347](../../app/admin/controller/AgentController.php#L1347) |
| GET | `{A}/agent/Tickets` | `admin/Agent/getTickets` | [app/admin/controller/AgentController.php:1409](../../app/admin/controller/AgentController.php#L1409) |
| GET | `{A}/agent/RunMapLists` | `admin/Agent/getRunMapLists` | [app/admin/controller/AgentController.php:1500](../../app/admin/controller/AgentController.php#L1500) |
| POST | `{A}/agent/Evaluation` | `admin/Agent/postEvaluation` | [app/admin/controller/AgentController.php:1552](../../app/admin/controller/AgentController.php#L1552) |
| GET | `{A}/agent/Token` | `admin/Agent/getToken` | [app/admin/controller/AgentController.php:1595](../../app/admin/controller/AgentController.php#L1595) |
| GET | `/host/UpgradeHost` | `home/Host/getUpgradeHost` | [app/home/controller/HostController.php:24](../../app/home/controller/HostController.php#L24) |
| GET | `/host/List` | `home/Host/getList` | [app/home/controller/HostController.php:72](../../app/home/controller/HostController.php#L72) |
| POST | `/host/Remark` | `home/Host/postRemark` | [app/home/controller/HostController.php:268](../../app/home/controller/HostController.php#L268) |
| POST | `/host/SaveCate` | `home/Host/postSaveCate` | [app/home/controller/HostController.php:295](../../app/home/controller/HostController.php#L295) |
| DELETE | `/host/Cate` | `home/Host/deleteCate` | [app/home/controller/HostController.php:324](../../app/home/controller/HostController.php#L324) |
| POST | `/host/TransferCate` | `home/Host/postTransferCate` | [app/home/controller/HostController.php:351](../../app/home/controller/HostController.php#L351) |
| GET | `/host/Details` | `home/Host/getDetails` | [app/home/controller/HostController.php:457](../../app/home/controller/HostController.php#L457) |
| GET | `/host/Product` | `home/Host/getProduct` | [app/home/controller/HostController.php:709](../../app/home/controller/HostController.php#L709) |
| GET | `/host/Down` | `home/Host/getDown` | [app/home/controller/HostController.php:796](../../app/home/controller/HostController.php#L796) |
| GET | `/host/Cancel` | `home/Host/getCancel` | [app/home/controller/HostController.php:824](../../app/home/controller/HostController.php#L824) |
| GET | `/host/CloudOs` | `home/Host/getCloudOs` | [app/home/controller/HostController.php:852](../../app/home/controller/HostController.php#L852) |
| GET | `/host/Chart` | `home/Host/getChart` | [app/home/controller/HostController.php:906](../../app/home/controller/HostController.php#L906) |
| GET | `/host/Moudle` | `home/Host/getMoudle` | [app/home/controller/HostController.php:958](../../app/home/controller/HostController.php#L958) |
| GET | `/host/Flowpacket` | `home/Host/getFlowpacket` | [app/home/controller/HostController.php:1093](../../app/home/controller/HostController.php#L1093) |
| GET | `/host/Header` | `home/Host/getHeader` | [app/home/controller/HostController.php:1283](../../app/home/controller/HostController.php#L1283) |
| POST | `/host/NameToUser` | `home/Host/postNameToUser` | [app/home/controller/HostController.php:1820](../../app/home/controller/HostController.php#L1820) |
| POST | `/host/Transfer` | `home/Host/postTransfer` | [app/home/controller/HostController.php:1859](../../app/home/controller/HostController.php#L1859) |
| POST | `/host/CancelTranfer` | `home/Host/postCancelTranfer` | [app/home/controller/HostController.php:1911](../../app/home/controller/HostController.php#L1911) |
| POST | `/host/ReceiveTranfer` | `home/Host/postReceiveTranfer` | [app/home/controller/HostController.php:1936](../../app/home/controller/HostController.php#L1936) |
| POST | `/host/RefuseTranfer` | `home/Host/postRefuseTranfer` | [app/home/controller/HostController.php:1967](../../app/home/controller/HostController.php#L1967) |
| GET | `/host/RenewPage` | `home/Host/getRenewPage` | [app/home/controller/HostController.php:2000](../../app/home/controller/HostController.php#L2000) |
| GET | `/host/RenewPageView` | `home/Host/getRenewPageView` | [app/home/controller/HostController.php:2120](../../app/home/controller/HostController.php#L2120) |
| GET | `/host/HostRecharge` | `home/Host/getHostRecharge` | [app/home/controller/HostController.php:2206](../../app/home/controller/HostController.php#L2206) |
| POST | `/host/Renew` | `home/Host/postRenew` | [app/home/controller/HostController.php:2286](../../app/home/controller/HostController.php#L2286) |
| POST | `/host/AutoRenew` | `home/Host/postAutoRenew` | [app/home/controller/HostController.php:2314](../../app/home/controller/HostController.php#L2314) |
| POST | `/host/BatchRenewPage` | `home/Host/postBatchRenewPage` | [app/home/controller/HostController.php:2358](../../app/home/controller/HostController.php#L2358) |
| POST | `/host/BatchRenew` | `home/Host/postBatchRenew` | [app/home/controller/HostController.php:2479](../../app/home/controller/HostController.php#L2479) |
| POST | `/host/HourDayRenew` | `home/Host/postHourDayRenew` | [app/home/controller/HostController.php:2516](../../app/home/controller/HostController.php#L2516) |
| POST | `/host/CycleToMonYear` | `home/Host/postCycleToMonYear` | [app/home/controller/HostController.php:2597](../../app/home/controller/HostController.php#L2597) |
| GET | `/host/CancelPage` | `home/Host/getCancelPage` | [app/home/controller/HostController.php:2691](../../app/home/controller/HostController.php#L2691) |
| POST | `/host/Cancel` | `home/Host/postCancel` | [app/home/controller/HostController.php:2731](../../app/home/controller/HostController.php#L2731) |
| DELETE | `/host/Cancel` | `home/Host/deleteCancel` | [app/home/controller/HostController.php:2786](../../app/home/controller/HostController.php#L2786) |
| GET | `/host/TrafficUsage` | `home/Host/getTrafficUsage` | [app/home/controller/HostController.php:2814](../../app/home/controller/HostController.php#L2814) |
| POST | `/host/SecondVerify` | `home/Host/postSecondVerify` | [app/home/controller/HostController.php:2878](../../app/home/controller/HostController.php#L2878) |
| POST | `/host/SetDownStream` | `home/Host/postSetDownStream` | [app/home/controller/HostController.php:2891](../../app/home/controller/HostController.php#L2891) |
| GET | `/host/DedicatedServer` | `home/Host/getDedicatedServer` | [app/home/controller/HostController.php:3020](../../app/home/controller/HostController.php#L3020) |
| GET | `/host/HostStatus` | `home/Host/getHostStatus` | [app/home/controller/HostController.php:3346](../../app/home/controller/HostController.php#L3346) |
| GET | `/voucher/AreaList` | `home/Voucher/getAreaList` | [app/home/controller/VoucherController.php:21](../../app/home/controller/VoucherController.php#L21) |
| GET | `/voucher/Currency` | `home/Voucher/getCurrency` | [app/home/controller/VoucherController.php:35](../../app/home/controller/VoucherController.php#L35) |
| GET | `/voucher/VoucherList` | `home/Voucher/getVoucherList` | [app/home/controller/VoucherController.php:67](../../app/home/controller/VoucherController.php#L67) |
| GET | `/voucher/VoucherDetail` | `home/Voucher/getVoucherDetail` | [app/home/controller/VoucherController.php:120](../../app/home/controller/VoucherController.php#L120) |
| GET | `/voucher/VoucherRequest` | `home/Voucher/getVoucherRequest` | [app/home/controller/VoucherController.php:174](../../app/home/controller/VoucherController.php#L174) |
| GET | `/voucher/IssueVoucher` | `home/Voucher/getIssueVoucher` | [app/home/controller/VoucherController.php:240](../../app/home/controller/VoucherController.php#L240) |
| POST | `/voucher/IssueVoucher` | `home/Voucher/postIssueVoucher` | [app/home/controller/VoucherController.php:290](../../app/home/controller/VoucherController.php#L290) |
| GET | `/voucher/VoucherInfoList` | `home/Voucher/getVoucherInfoList` | [app/home/controller/VoucherController.php:373](../../app/home/controller/VoucherController.php#L373) |
| GET | `/voucher/VoucherInfo` | `home/Voucher/getVoucherInfo` | [app/home/controller/VoucherController.php:409](../../app/home/controller/VoucherController.php#L409) |
| POST | `/voucher/VoucherInfo` | `home/Voucher/postVoucherInfo` | [app/home/controller/VoucherController.php:438](../../app/home/controller/VoucherController.php#L438) |
| DELETE | `/voucher/VoucherInfo` | `home/Voucher/deleteVoucherInfo` | [app/home/controller/VoucherController.php:482](../../app/home/controller/VoucherController.php#L482) |
| GET | `/voucher/VoucherPostList` | `home/Voucher/getVoucherPostList` | [app/home/controller/VoucherController.php:519](../../app/home/controller/VoucherController.php#L519) |
| GET | `/voucher/VoucherPost` | `home/Voucher/getVoucherPost` | [app/home/controller/VoucherController.php:549](../../app/home/controller/VoucherController.php#L549) |
| POST | `/voucher/VoucherPost` | `home/Voucher/postVoucherPost` | [app/home/controller/VoucherController.php:579](../../app/home/controller/VoucherController.php#L579) |
| DELETE | `/voucher/VoucherPost` | `home/Voucher/deleteVoucherPost` | [app/home/controller/VoucherController.php:633](../../app/home/controller/VoucherController.php#L633) |
| POST | `/voucher/VoucherDefaultPost` | `home/Voucher/postVoucherDefaultPost` | [app/home/controller/VoucherController.php:663](../../app/home/controller/VoucherController.php#L663) |
| GET | `/news/List` | `home/News/getList` | [app/home/controller/NewsController.php:65](../../app/home/controller/NewsController.php#L65) |
| GET | `/news/Notice` | `home/News/getNotice` | [app/home/controller/NewsController.php:120](../../app/home/controller/NewsController.php#L120) |
| GET | `/news/Content` | `home/News/getContent` | [app/home/controller/NewsController.php:152](../../app/home/controller/NewsController.php#L152) |
| GET | `/news/CateList` | `home/News/getCateList` | [app/home/controller/NewsController.php:201](../../app/home/controller/NewsController.php#L201) |
| GET | `/news/NoticeList` | `home/News/getNoticeList` | [app/home/controller/NewsController.php:250](../../app/home/controller/NewsController.php#L250) |
| GET | `/news/NoticeContent` | `home/News/getNoticeContent` | [app/home/controller/NewsController.php:316](../../app/home/controller/NewsController.php#L316) |

## 再生成

仅安装静态文档解析依赖到临时目录，不修改应用依赖：

```sh
npm install --prefix /tmp/zjmf-doc-parser acorn@8 --ignore-scripts --no-audit --no-fund
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --write
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --check
```
