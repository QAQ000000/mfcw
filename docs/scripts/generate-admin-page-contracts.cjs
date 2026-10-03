const fs = require('node:fs');
const path = require('node:path');
const acorn = require('acorn');
const { pages, language } = require('./generate-admin-build-evidence.cjs');
const { declarations, implicit } = require('./generate-admin-page-inventory.cjs');
const { groups, layouts, details } = require('./admin-page-designs.cjs');
const root = path.resolve(__dirname, '../..');
const unique = items => [...new Set(items)];
const code = value => '`' + String(value ?? '-').replace(/`/g, "'").replace(/\|/g, '\\|').replace(/[\r\n]/g, ' ') + '`';
const anchor = page => 'p' + String(page.index).padStart(3, '0');
const ownership = new Map();
for (const group of groups) for (const [route, title, kind] of group.entries) {
  if (ownership.has(route)) throw new Error(`Duplicate design: ${route}`);
  if (!layouts[kind]) throw new Error(`Unknown layout: ${kind}`);
  ownership.set(route, { group, title, kind });
}
for (const page of pages) if (!ownership.has(page.route.path)) throw new Error(`Design missing: ${page.route.path}`);
for (const route of ownership.keys()) if (!pages.some(page => page.route.path === route)) throw new Error(`Stale design: ${route}`);
const runtime = new Set(['/login', '/home-page', '/customer-list', '/customer-view', '/customer-view/abstract', '/customer-view/person']);

function textLabel(value) {
  if (!value || value.includes(' ($lang.')) return value ?? '-';
  function read(node) {
    if (node.type === 'Literal') return String(node.value);
    if (node.type === 'MemberExpression' && node.object.type === 'MemberExpression' && node.object.property.name === '$lang') return language.get(node.property.name ?? node.property.value) ?? null;
    if (node.type === 'CallExpression' && node.callee.type === 'MemberExpression' && node.callee.property.name === '_s' && node.arguments.length === 1) return read(node.arguments[0]);
    if (node.type === 'BinaryExpression' && node.operator === '+') { const left = read(node.left), right = read(node.right); return left !== null && right !== null ? left + right : null; }
    return null;
  }
  try { const result = read(acorn.parseExpressionAt(value, 0, { ecmaVersion: 'latest' })); return result?.trim() || value; } catch { return value; }
}
function property(element, name) { return textLabel(element.properties.find(value => value.startsWith(name + '='))?.slice(name.length + 1)); }
function constantUrl(expression) {
  try {
    const node = acorn.parseExpressionAt(expression, 0, { ecmaVersion: 'latest' });
    if (node.type === 'Literal' && typeof node.value === 'string') return { prefix: node.value, exact: true };
    let left = node;
    while (left.type === 'BinaryExpression' && left.operator === '+') left = left.left;
    return left.type === 'Literal' && typeof left.value === 'string' ? { prefix: left.value, exact: false } : null;
  } catch { return null; }
}
function phpMatches(request) {
  const url = constantUrl(request.url);
  if (!url || !url.prefix || /^https?:/i.test(url.prefix)) return [];
  const method = request.method.replace(/["']/g, '').toUpperCase();
  return [...declarations, ...implicit].filter(route => {
    if (!route.url.startsWith('{A}/')) return false;
    const target = route.url.slice(4);
    const match = url.exact ? target === url.prefix.replace(/^\//, '') : target.startsWith(url.prefix.replace(/^\//, ''));
    return match && (request.method === '未显式指定' || ['RULE', 'ANY', 'RESOURCE'].includes(route.method) || route.method === method);
  });
}
function ruleFor(route) {
  if (!route.file || !route.action || ['RESOURCE', 'CONTROLLER'].includes(route.method)) return '需展开路由后核对';
  const controller = path.basename(route.file).replace(/Controller\.php$/, '');
  return `app\\admin\\controller\\${controller}controller::${route.action.toLowerCase()}`;
}
function pageDocument(page) {
  const { route } = page, design = ownership.get(route.path), { kind } = design;
  const unresolved = page.attribution !== '路由 factory 指向模块';
  const output = [`<a id="${anchor(page)}"></a>`, '', `## ${design.title} ${code(route.path)}`, '',
    `旧版证据：[${anchor(page).toUpperCase()}](27-admin-built-page-evidence.md#${anchor(page)})；归属：${page.attribution}。本节是新布局草案，${unresolved ? '组件归属未冻结，不能据此进入业务实现' : '仍需核对可见分支与接口响应'}。`, '',
    '**页面关系**：父容器 ' + code(route.parent) + '；默认重定向 ' + code(route.redirect) + '；子页 ' + (page.children.map(code).join('、') || '无静态children') + '。入口菜单和query对象值须按授权会话确认，不把父子关系当权限。', '',
    '**桌面排版**：' + layouts[kind][0], '', '**手机排版**：' + layouts[kind][1], '',
    '**本页专项约束**：' + (details[route.path] ?? `围绕“${design.title}”展示下文已提取字段/操作；不因页面标题添加导出、审批、删除或批量功能。旧条件分支逐条核对，新设计仅改变展示方式。`), '',
    '### 区域、字段和对话框依据', '',
    '下表保持模块/scope归属。它包含条件分支及内嵌组件，不能全部合并为主页面；动态字段与子组件详情回查原证据。', '',
    '| 模块 / scope | 区域或控件 | 标签 / 字段 | 旧显示条件 | 新位置或处理 |', '| --- | --- | --- | --- | --- |'];
  let fields = 0;
  for (const component of page.components) for (const element of component.elements) {
    if (!['el-table-column', 'el-form-item', 'el-dialog', 'el-drawer', 'el-tab-pane', 'el-switch', 'el-upload'].includes(element.tag)) continue;
    fields++;
    const position = element.tag === 'el-table-column' ? '主数据区；窄屏优先级按对象/状态/金额设置' : /dialog|drawer/.test(element.tag) ? '独立弹层；加载/校验/关闭保留草稿' : element.tag === 'el-tab-pane' ? '主区导航；保留对象与选中项' : element.tag === 'el-upload' ? '对应字段组；上传结果与业务保存分开' : '分组表单；未知原值不置空';
    output.push(`| ${code(component.module.id + '/' + (component.scope ?? '-'))} | ${code(element.tag)} | ${code(property(element, 'label'))} / ${code(property(element, 'prop'))} / ${code(property(element, 'title'))} | ${code(element.context || '无提取条件')} | ${position} |`);
  }
  if (!fields) output.push('| - | - | 未提取上述控件，核对布局/子组件 | - | 不补造字段 |');
  output.push('', '### 按钮、可用条件和点击行为', '',
    '以下为旧绑定依据；显示条件不等于接口授权。新版每个业务按钮必须同时满足真实权限、对象状态和参数已加载；未知条件先不开放写入。', '',
    '| 模块 / scope | 可见文字线索 | 触发绑定 | 显示条件 |', '| --- | --- | --- | --- |');
  let buttons = 0;
  for (const component of page.components) for (const element of component.elements) {
    if (!element.events.length || !['el-button', 'el-link', 'router-link', 'a', 'el-switch', 'el-upload', 'el-dropdown-item'].includes(element.tag)) continue;
    buttons++;
    output.push(`| ${code(component.module.id + '/' + (component.scope ?? '-'))} | ${code(element.text.map(textLabel).join(' / ') || '图标/动态文案，回查原证据')} | ${element.events.map(code).join('<br>')} | ${code(element.context || '无提取条件')} |`);
  }
  if (!buttons) output.push('| - | 未提取可点击控件 | 核对外壳/动态子组件 | 不新增假操作 |');
  output.push('', '### 方法、接口及结果确认', '',
    '| scope / 页面方法 | JS请求与编码 | PHP静态匹配候选 / 权限规则候选 | 方法内部调用（时序另查） |', '| --- | --- | --- | --- |');
  let count = 0;
  for (const component of page.components) {
    const actions = [...component.actions, ...component.hookRequests.map(hook => ({ name: '生命周期:' + hook.name, request: hook, calls: [] }))];
    for (const action of actions) for (const request of action.request.found) {
      count++;
      const matches = phpMatches(request);
      const php = matches.map(route => `${code(route.method + ' ' + route.url)} → ${code(route.target)}；规则 ${code(ruleFor(route))}；[源行](../../${implicit.includes(route) ? route.file : route.routeFile}#L${route.line})`).join('<br>') || '无静态匹配；核对隐式/trait/插件路由，不猜方法或权限';
      output.push(`| ${code(component.scope)} / ${code(action.name)} | ${code(request.method)} ${code(request.url)} (${request.encoding}) | ${php} | ${action.calls.map(code).join('、') || '未提取；新设计明确成功后重读受影响对象'} |`);
    }
  }
  if (!count) output.push('| - | 未提取直接请求 | 不代表无接口；禁止自行编造 | 核对子组件/生命周期 |');
  output.push('', 'PHP匹配只是字面量/CONTROLLER候选，未展开RESOURCE、trait或动态插件；权限字符串由现有AdminBase规则构造，仅作为核对输入，未取得真实rule id或普通角色授权。参数/响应/拒绝码按[接口契约](13-page-api-contract.md)、[权限矩阵](14-admin-permission-matrix.md)及PHP实现冻结；未冻结字段不能标记API完成。', '',
    '### 跳转、反馈与验收', '',
    ...unique(page.components.flatMap(component => component.navigation)).map(item => '- 旧跳转：' + code(item)),
    '- 读取失败保持页面标题/对象范围并提供重试；空数据与无权限分别显示。写入提交中禁止重复，业务错误/超时保留安全草稿并重读，不自动重试。',
    '- 关联标签、分页与返回保留对象ID和筛选；切换对象丢弃过期响应。弹窗关闭、删除/审核/发送等只保留有请求依据的动作，确认后也需验证目标状态。',
    '- 验收：1440/768/390/320px首次进入、直接子页进入及动态缩屏；按上表核对列/字段/按钮，覆盖读取成功、空、拒绝、错误及每个写入分支。角色和数据来自UI-FIXTURE-1，截图脱敏。',
    `- 当前运行状态：${runtime.has(route.path) ? '旧页面部分已观察，范围见[29文档](29-admin-browser-observations.md)；新布局/写入/普通角色仍NOT RUN' : 'NOT RUN；本节未新增浏览器验收'}。`, '');
  return output;
}
function render() {
  const output = new Map();
  for (const group of groups) {
    const selected = pages.filter(page => ownership.get(page.route.path).group.id === group.id);
    output.set(group.file, ['# ' + group.title + '逐页设计契约', '',
      '本文件由人工维护的页面归属/版式方案与编译AST证据生成。每页明确新桌面/手机版式，并列出旧控件、条件、方法、跳转与PHP匹配候选；属于可审查设计草案，不是接口schema或运行验收通过。静态字段含内嵌组件，必须按scope核对。', '',
      '[全量索引](30-admin-page-contract-index.md) · [旧版证据](27-admin-built-page-evidence.md) · [公共尺寸](19-component-interaction-contract.md)', '',
      '| 页面 | 版式 | 静态归属 |', '| --- | --- | --- |',
      ...selected.map(page => `| [${ownership.get(page.route.path).title}](#${anchor(page)}) ${code(page.route.path)} | ${code(ownership.get(page.route.path).kind)} | ${page.attribution} |`), '',
      ...selected.flatMap(pageDocument)].join('\n'));
  }
  output.set('30-admin-page-contract-index.md', ['# 后台逐页设计契约索引', '',
    `本轮为${pages.length}条编译路由建立唯一模块归属和明确的新版式草案，并将控件/条件/请求按模块scope关联。路由含容器、错误页、兼容页，不能当作${pages.length}个独立业务页面。`, '',
    '每页现在有：父子/默认落点、桌面/手机排版、专项限制、旧字段/弹层/按钮条件、方法与请求、PHP/权限匹配候选、跳转/反馈与验收要求。方案来自人工维护的admin-page-designs.cjs，旧事实来自Acorn解析，禁止执行产物。', '',
    '**未完成部分**：实际参数/返回schema及普通角色rule id没有全量冻结；候选组件、共享子组件和未匹配请求继续保留缺口；运行截图只覆盖29文档列出的旧核心页面。不能把每页生成一节当成全站业务开发放行。资源池/扩展标题为工作分类，业务含义仍以字段/接口与运行观察确认。', '',
    '| 模块 | 路由记录 | 文档 |', '| --- | --- | --- |',
    ...groups.map(group => `| ${group.title} | ${group.entries.length} | [逐页契约](${group.file}) |`), '',
    '## 使用方式', '',
    '1. 从模块页打开目标路由，读取新版式及旧控件表；同一scope之外的字段不得直接并入主表单。',
    '2. 结合13/14/15/26文档与PHP实现确认接口schema、状态及权限；未匹配或未知条件列入该页缺口，不造接口。',
    '3. 做桌面/手机视觉稿与工程实现，每个写按钮落实请求、前置条件、结果重读和异常恢复。',
    '4. 在隔离fixture上验收，回填运行观察；未通过页面保持DRAFT，不因其他页面通过自动放行。', '',
    '## 维护与检查', '', '```sh',
    'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-contracts.cjs --write',
    'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-contracts.cjs --check',
    '```', '',
    '路由新增/删除或重复分类会中止生成；更新人工设计配置后再生成。不要手改生成文档的字段表。实际视觉稿、运行观察和新工程记录独立维护。', ''].join('\n'));
  return output;
}
if (require.main === module) {
  for (const [file, content] of render()) {
    const destination = path.join(root, 'docs/frontend', file);
    if (process.argv.includes('--write')) fs.writeFileSync(destination, content);
    else if (process.argv.includes('--check')) { if (fs.readFileSync(destination, 'utf8') !== content) throw new Error(`Stale contract: ${file}`); }
    else console.log(content);
  }
  console.log(`Page contracts: ${ownership.size} routes, ${groups.length} modules; schemas and runtime checks are not inferred`);
}
module.exports = { ownership, textLabel, constantUrl, phpMatches, ruleFor, render };
