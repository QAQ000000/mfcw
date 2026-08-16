# 插件开发

## 1. 插件类型与加载位置

系统登记的通用插件类型包括 `addons`、`gateways`、`certification`、`sms`、`automatic`
和 `mail`。只有支付网关会同时从 `modules/gateways/<name>/` 与
`public/plugins/gateways/<name>/` 发现；其余类型从
`public/plugins/<type>/<name>/` 发现。OAuth 和服务器模块另有独立加载契约，分别见对应
文档。当前仓库的可读示例主要位于 `public/plugins/`。

`PluginModel` 还接受历史类型 `firewall`，但当前仓库没有对应目录或根命名空间配置，
不能把它当作可运行模板。OAuth 虽也登记在 `plugin` 表中，但不继承本章的通用主类，
应按第三方登录文档开发。

类名遵循以下映射：

```text
目录：public/plugins/addons/acme_tools/
类：  addons\acme_tools\AcmeToolsPlugin
文件：AcmeToolsPlugin.php
```

目录使用 snake_case，插件名和主类使用 PascalCase。主类必须继承
`app\admin\lib\Plugin`，并实现 `install()`、`uninstall()`。

## 2. Addon 目录

```text
public/plugins/addons/acme_tools/
├── AcmeToolsPlugin.php
├── config.php                 # 可选，后台配置定义
├── hooks.php                  # 可选，启用时直接加载
├── menu.php                   # 可选，后台菜单
├── menuclientarea.php         # 可选，客户中心菜单
├── controller/
│   ├── AdminIndexController.php
│   └── clientarea/IndexController.php
├── template/
│   ├── admin/index.tpl
│   └── clientarea/index.tpl
├── lang/
│   ├── zh-cn.php
│   └── en-us.php
└── vendor/autoload.php        # 可选，插件私有依赖
```

可运行的页面结构参考 `public/plugins/addons/demo_style`。不要复制仓库中 ionCube 编码
插件作为开发模板，因为无法审查它们的安装、权限和错误处理逻辑。

## 3. 主类

```php
<?php

namespace addons\acme_tools;

use app\admin\lib\Plugin;

class AcmeToolsPlugin extends Plugin
{
    public $info = [
        'name' => 'AcmeTools',
        'title' => 'Acme Tools',
        'description' => '示例业务插件',
        'status' => 1,
        'author' => 'Acme',
        'version' => '1.0.0',
        'module' => 'addons',
    ];

    public function install()
    {
        // 使用幂等迁移创建插件自有表或初始数据。
        return true;
    }

    public function uninstall()
    {
        // 明确保留还是删除业务数据，并使重复执行可控。
        return true;
    }
}
```

`$info` 至少包含 `name`、`title`、`description`、`status`、`author`、`version`。
安装入口会反射主类方法，自动登记与系统 Hook 同名的方法，并保存默认配置。

安装过程不是覆盖所有步骤的单一事务：插件 `install()` 成功后，授权检查、插件记录或
菜单导入仍可能失败。安装逻辑必须幂等，并准备清理部分安装状态；不要假设框架会自动
回滚插件自行创建的表、文件或外部资源。

## 4. 配置

根目录 `config.php` 返回表单定义。常用字段为 `title`、`type`、`value`、`tip`、
`options`，还可用 `rule`、`message` 做服务端验证：

```php
<?php

return [
    'endpoint' => [
        'title' => '接口地址',
        'type' => 'text',
        'value' => '',
        'tip' => '必须使用 HTTPS',
        'rule' => ['require' => true, 'url' => true],
    ],
    'mode' => [
        'title' => '运行模式',
        'type' => 'select',
        'options' => ['test' => '测试', 'live' => '生产'],
        'value' => 'test',
    ],
];
```

未保存时，`Plugin::getConfig()` 从 `config.php` 提取默认 `value`；保存后以 `plugin`
表的 JSON 配置为准。密钥只放插件配置，不写入源码、模板、URL 或日志。若字段需要
真正的密文存储，应在插件中另外实现加密，不能把数据库 JSON 误认为加密存储。

## 5. 控制器、模板与 URL

后台控制器继承 `PluginAdminBaseController`，客户中心控制器继承
`PluginHomeBaseController`。模板根目录会分别附加 `template/admin` 和
`template/clientarea`。

插件内部链接使用：

```php
$adminUrl = shd_addon_url('AcmeTools://AdminIndex/index');
$homeUrl = shd_addon_url('AcmeTools://Index/index', [], true);
```

实际请求会转换为：

```text
/<后台地址>/addons?_plugin=acme_tools&_controller=admin_index&_action=index
/addons?_plugin=<插件数字 ID>&_controller=index&_action=index
```

后台基类会检查管理员权限及插件启用状态。前台路由使用 `UserCheck`，但分发器本身没有
与后台同等明确的启用状态检查；敏感操作仍须在控制器中校验登录客户、资源归属、插件
状态和 CSRF/重放条件，不能只依赖菜单隐藏或难以猜测的 URL。

## 6. 菜单与多语言

后台菜单放在 `menu.php`，管理端会在运行时读取，不写入 `nav` 表。客户中心菜单放在
`menuclientarea.php`，安装和更新时递归导入 `nav`，卸载时按插件名删除。两类菜单动作
都必须与控制器方法一致，并通过既有权限体系限制入口。

插件语言放在 `lang/zh-cn.php`、`lang/en-us.php`。基类当前把 `chinese_tw` 也映射到
`zh-cn`；需要繁体差异时必须实测并在插件层显式处理，不能仅增加一个未被加载的文件。

## 7. 生命周期与升级

| 操作 | 框架行为 | 插件要求 |
| --- | --- | --- |
| 发现 | 合并磁盘目录与 `plugin` 表，未安装项状态为 3 | 类名、目录名和 `$info` 一致 |
| 安装 | 调用 `install()`、登记 Hook、保存配置、导入客户菜单 | 幂等、失败可清理 |
| 启停 | 同步 `plugin.status` 和 `hook_plugin.status` | 请求入口仍做业务授权 |
| 配置 | 按 `config.php` 验证后保存 JSON | 兼容缺失字段和旧配置 |
| 更新 | 重导客户菜单、合并默认配置、增补 Hook | 提供向前兼容迁移 |
| 卸载 | 删除插件记录、Hook、菜单并调用 `uninstall()` | 明确数据保留策略 |

当前更新逻辑删除旧 Hook 的差集计算存在缺陷，移除主类方法后旧的 `hook_plugin` 记录
可能残留。发布更新时检查并清理该插件的 Hook 记录，同时不要直接编辑其他插件记录。

## 8. 发布检查

1. 在全新库和已安装旧版本上分别执行安装、更新、停用、启用、卸载。
2. 检查配置默认值、验证错误、密钥日志脱敏和旧字段兼容。
3. 后台每个动作验证管理员权限，前台每个资源验证客户归属。
4. 外部请求设置连接和总超时；写操作有幂等键，回调验签并防重放。
5. 菜单卸载干净，Hook 无残留，插件停用后已知 URL 不能继续执行敏感动作。
6. 对所有 PHP 文件运行 `php -l`，对模板做登录前后及多语言回归。
