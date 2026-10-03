# 后台逐页设计契约索引

本轮为229条编译路由建立唯一模块归属和明确的新版式草案，并将控件/条件/请求按模块scope关联。路由含容器、错误页、兼容页，不能当作229个独立业务页面。

每页现在有：父子/默认落点、桌面/手机排版、专项限制、旧字段/弹层/按钮条件、方法与请求、PHP/权限匹配候选、跳转/反馈与验收要求。方案来自人工维护的admin-page-designs.cjs，旧事实来自Acorn解析，禁止执行产物。

**未完成部分**：实际参数/返回schema及普通角色rule id没有全量冻结；候选组件、共享子组件和未匹配请求继续保留缺口；运行截图只覆盖29文档列出的旧核心页面。不能把每页生成一节当成全站业务开发放行。资源池/扩展标题为工作分类，业务含义仍以字段/接口与运行观察确认。

| 模块 | 路由记录 | 文档 |
| --- | --- | --- |
| 客户与客户详情 | 35 | [逐页契约](31-admin-customer-contracts.md) |
| 商品、服务与资源 | 54 | [逐页契约](32-admin-product-resource-contracts.md) |
| 订单与代下单 | 7 | [逐页契约](33-admin-order-contracts.md) |
| 财务、信用额、合同与报表 | 20 | [逐页契约](34-admin-finance-contracts.md) |
| 工单与客服 | 12 | [逐页契约](35-admin-ticket-contracts.md) |
| 系统设置、内容与通知 | 69 | [逐页契约](36-admin-setting-content-contracts.md) |
| 外壳、插件与扩展 | 32 | [逐页契约](37-admin-extension-shell-contracts.md) |

## 使用方式

1. 从模块页打开目标路由，读取新版式及旧控件表；同一scope之外的字段不得直接并入主表单。
2. 结合13/14/15/26文档与PHP实现确认接口schema、状态及权限；未匹配或未知条件列入该页缺口，不造接口。
3. 做桌面/手机视觉稿与工程实现，每个写按钮落实请求、前置条件、结果重读和异常恢复。
4. 在隔离fixture上验收，回填运行观察；未通过页面保持DRAFT，不因其他页面通过自动放行。

## 维护与检查

```sh
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-contracts.cjs --write
NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-contracts.cjs --check
```

路由新增/删除或重复分类会中止生成；更新人工设计配置后再生成。不要手改生成文档的字段表。实际视觉稿、运行观察和新工程记录独立维护。
