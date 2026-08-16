# 实名认证插件

## 1. 入口与职责

实名认证同时存在 JSON 接口和主题页面两条入口，均要求客户登录：

| 方法与路径 | 处理器 | 作用 |
| --- | --- | --- |
| `GET /certifi` | `CertificationController::certifi()` | 返回当前状态及支持当前认证类型的插件 |
| `POST /person_certifi_post` | `CertificationController::personCertifiPost()` | 校验并保存个人认证资料 |
| `POST /company_certifi_post` | `CertificationController::companyCertifiPost()` | 校验并保存企业认证资料 |
| `GET /certifi_ping` | `CertificationController::ping()` | 轮询插件侧认证结果 |
| `GET|POST /verified` | `ViewClientsController::verified()` | 主题页面、收费账单及插件启动入口 |

客户 OpenAPI 还提供一组强制 JWT 认证的 `/v1` 入口：

| 方法与路径 | 处理器 | 作用 |
| --- | --- | --- |
| `GET /v1/real_name_auth` | `UserController::realNameAuth()` | 返回认证配置、状态和插件字段 |
| `POST /v1/real_name_auth/person` | `UserController::personRealNameAuth()` | 提交个人认证 |
| `POST /v1/real_name_auth/company` | `UserController::companyRealNameAuth()` | 提交企业认证 |
| `GET /v1/real_name_auth/status` | `UserController::realNameAuthStatus()` | 查询并同步插件认证结果 |

OpenAPI 控制器实现了自己的提交、上传、收费和状态同步流程，并非对 Home 控制器的简单
转发。修改认证规则时必须同时回归两组入口，避免状态、免费次数或上传校验发生偏差。

`data/route/home.php` 还登记了 `POST /person_query_post`、
`POST /company_query_post` 和 `POST /person_to_company`。当前控制器只实现了
`personToCompany()`，前两个路由没有对应方法，不能视为可用接口。插件如需额外回调
控制器，应继续验证登录、认证记录归属和回调签名，不能只依赖动态插件路由。

## 2. 插件契约

插件放在 `public/plugins/certification/<name>/`，主类遵循：

```php
namespace certification\acme;

use app\admin\lib\Plugin;

class AcmePlugin extends Plugin
{
    public $info = [/* name、title、description、status、author、version */];

    public function install() {}
    public function uninstall() {}
}
```

系统通过方法是否存在判断能力：

| 方法 | 必需 | 契约 |
| --- | --- | --- |
| `personal(array $certifi)` | 否 | 存在即表示支持个人认证，返回插件页面内容或 HTML 结果 |
| `company(array $certifi)` | 否 | 存在即表示支持企业认证，参数结构与个人认证相同 |
| `collectionInfo()` | 否 | 声明认证表单自定义字段，最多读取 10 项 |
| `getStatus(array $certifi)` | 否 | 接收 `certify_id`，用于前端轮询异步结果 |

`personal()`/`company()` 接收的系统字段包括 `name`、`card`、`phone`、`bank`、
`company_name` 和 `company_organ_code`。`phone`、`bank` 只有在采集配置和提交数据中
存在时才可靠；插件必须处理缺失值。自定义字段以 `collectionInfo()` 声明的 `field`
为键合并进参数，文件字段传给插件的是服务器绝对路径。

插件不能只返回成功而不落状态。同步或异步结果应调用：

```php
updatePersonalCertifiStatus([
    'status' => 1,
    'auth_fail' => '',
    'certify_id' => $providerId,
]);
```

企业认证对应 `updateCompanyCertifiStatus()`。轮询型实现的 `getStatus()` 返回
`['status' => 1|2|4, 'msg' => '...']`：`1` 通过，`2` 失败，`4` 仍在处理。

## 3. 自定义采集与配置

`collectionInfo()` 支持 `text`、`file`、`select` 三类字段。每项至少应明确 `field`、
`title`、`type`、`required`；`select` 还要提供 `options`。字段名必须稳定，升级时不能
复用旧字段存放另一种证件数据。

插件根目录的 `config.php` 使用通用插件表单格式。收费认证依赖两个约定字段：

| 配置 | 含义 |
| --- | --- |
| `amount` | 超出免费次数后生成账单的单次金额 |
| `free` | 免费认证次数，现有逻辑把 `0` 作为无免费次数处理 |

现有实现还提供以下配置示例：

- `phonethree`：`app_code`、`amount`、`free`；
- `ali`：`app_id`、`public_key`、`private_key`、`biz_code`；
- `idcsmartali`：`api`、`key`、`biz_code`、`amount`、`free`。

配置最终以 JSON 保存在 `plugin.config`，不是加密存储。私钥和 API 密钥不得写入日志、
认证记录、前端模板或 URL；后台显示时应脱敏。

## 4. 调用生命周期

```text
GET /certifi
  -> getPluginsList(certification, personal|enterprises)
  -> 返回启用且实现对应能力的插件

POST 认证资料
  -> 校验认证开关、用户、证件、自定义字段和上传
  -> 写 certifi_person/certifi_company 与 certifi_log
  -> 人工审核状态为 3；插件认证状态为 4
  -> 达到收费条件时创建认证账单

GET /verified?...&step=authstart&plugin=<name>
  -> 确认资料存在且账单条件满足
  -> zjmfhook(<name>, certification, <identity>, personal|company)
  -> 渲染插件字符串，或渲染 {type: html, data: ...}

GET /certifi_ping?type=<name>
  -> 读取当前客户最新认证记录
  -> zjmfhook(<name>, certification, {certify_id}, getStatus)
  -> 更新认证表与 certifi_log
```

数据库状态在现有流程中的含义为：`1` 个人认证通过，`2` 未通过，`3` 人工待审；企业
插件通过后也会转换为 `3`，由现有企业审核语义继续处理；`4` 表示资料已提交或等待
插件结果。开发时不要脱离具体表和认证类型单独解释数值 `3`。

## 5. 安全风险与加固要求

- 认证参数包含身份证号、手机号、银行卡号、营业执照和上传文件绝对路径，第三方插件
  与供应商都处于高敏感信任边界；必须最小化传输字段、使用 HTTPS 并限制数据留存。
- `public/plugins/certification/idcsmartali/logic/Idcsmartali.php` 现存调用使用 HTTP；
  `app/home/model/CertificationModel.php` 的旧请求还关闭 TLS 校验。上线前应替换为正确
  验证证书的 HTTPS，不能复制这些实现作为模板。
- `ViewClientsController::verified()` 组装插件参数时把 `phone` 赋成了
  `auth_card_number`。插件不能依赖该值；修复核心映射并增加身份证号不会进入手机号
  字段的回归测试。
- 插件返回的字符串和 `type=html` 数据会进入主题输出。只安装可信插件，并对供应商
  返回内容做固定模板映射；不要直接展示远端可控脚本或事件属性。
- 上传校验必须覆盖扩展名、MIME、文件头、大小、保存目录和下载授权。绝对路径不得
  回传浏览器或写入可公开访问的日志。
- 轮询结果必须绑定当前客户、认证类型和本地 `certify_id`。供应商回调还要验签、校验
  时间窗并防重放，不能根据可猜测的认证 ID 修改其他用户状态。
- 收费次数和账单创建逻辑存在个人、企业分支差异；修改时应覆盖第 0 次、边界次数、
  未支付账单和并发提交，避免重复账单或未付款即调用供应商。

## 6. 实现检查

1. 全新安装、升级和卸载均可重复执行，停用后不再出现在 `/certifi`。
2. 分别测试个人、企业、人工审核、同步结果和异步轮询。
3. 覆盖必填文本、非法下拉、空文件、伪造 MIME、超限文件和 10 字段上限。
4. 覆盖免费次数边界、支付失败、重复提交、供应商超时和重复回调。
5. 确认错误响应、活动日志和供应商日志均不包含完整证件或密钥。

## 7. 权威源码

- 路由：`data/route/home.php`、`data/route/openapi.php`。
- 认证状态、提交校验和轮询：`app/home/controller/CertificationController.php`。
- OpenAPI 提交与状态：`app/openapi/controller/UserController.php`。
- 页面、收费判断和插件调用：`app/home/controller/ViewClientsController.php`。
- 状态更新函数：`app/common.php` 中的 `updatePersonalCertifiStatus()`、
  `updateCompanyCertifiStatus()`。
- 官方历史契约：`public/plugins/certification/certification_document.md`。
- 可审查示例：`public/plugins/certification/phonethree/`、
  `public/plugins/certification/ali/`、`public/plugins/certification/idcsmartali/`。
