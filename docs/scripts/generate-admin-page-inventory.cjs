// Parse build artifacts without executing them; PHP mappings are static references only.
const fs = require('node:fs');
const path = require('node:path');
const crypto = require('node:crypto');
const acorn = require('acorn');
const root = path.resolve(__dirname, '../..');
const read = file => fs.readFileSync(path.join(root, file), 'utf8');
const link = (file, line = 1) => `[${file}:${line}](../../${file}#L${line})`;
const cell = value => String(value).replace(/\|/g, '\\|').replace(/\n/g, ' ');
const lineAt = (text, offset) => text.slice(0, offset).split('\n').length;
const normalize = value => value.replace(/_/g, '').toLowerCase();
function walk(node, visit, ancestors = []) {
  if (!node || typeof node !== 'object') return;
  if (node.type) visit(node, ancestors);
  const next = node.type ? [...ancestors, node] : ancestors;
  for (const value of Object.values(node)) {
    if (Array.isArray(value)) value.forEach(item => walk(item, visit, next));
    else if (value && typeof value === 'object') walk(value, visit, next);
  }
}
function prop(node, name) {
  return node.properties?.find(p => (p.key.name ?? p.key.value) === name)?.value;
}
function literal(node) { return node?.type === 'Literal' ? node.value : null; }
const jsFiles = fs.readdirSync(path.join(root, 'public/admin/js'))
  .filter(name => /^app~.*\.js$/.test(name)).sort();
const candidates = [];
for (const name of jsFiles) {
  const file = `public/admin/js/${name}`;
  const text = read(file);
  const ast = acorn.parse(text, { ecmaVersion: 'latest', sourceType: 'script' });
  const arrays = [];
  const isFunction = node => ['FunctionExpression', 'FunctionDeclaration', 'ArrowFunctionExpression'].includes(node.type);
  walk(ast, (node, ancestors) => {
    if (node.type === 'ArrayExpression' && node.elements.some(e => literal(prop(e || {}, 'path')) === '/login')) {
      arrays.push({ node, scope: [...ancestors].reverse().find(isFunction) ?? ast });
    }
  });
  for (const { node: array, scope } of arrays) {
    if (!array.elements.some(e => prop(e || {}, 'children'))) continue;
    const declarations = new Map();
    walk(scope, (node, ancestors) => {
      if (ancestors.some(parent => parent !== scope && isFunction(parent))) return;
      if (node.type === 'VariableDeclarator' && node.id.type === 'Identifier') declarations.set(node.id.name, node.init);
    });
    const routes = [];
    function collect(array, parent = '') {
      for (const node of array.elements) {
        if (node?.type !== 'ObjectExpression') continue;
        const routePath = literal(prop(node, 'path'));
        if (typeof routePath !== 'string') continue;
        const full = routePath.startsWith('/') ? routePath : `${parent}/${routePath}`.replace(/\/+/g, '/');
        const component = prop(node, 'component');
        const chunks = [];
        const componentModules = [];
        walk(declarations.get(component?.name), n => {
          if (n.type === 'CallExpression' && n.callee.type === 'MemberExpression' && n.callee.property.name === 'e') {
            const name = literal(n.arguments[0]);
            if (typeof name === 'string') chunks.push(name);
          }
          if (n.type === 'CallExpression' && n.callee.type === 'MemberExpression' && n.callee.property.name === 'bind') {
            const moduleId = literal(n.arguments[1]);
            if (typeof moduleId === 'string') componentModules.push(moduleId);
          }
        });
        routes.push({ path: full, parent: parent || null, name: literal(prop(node, 'name')) ?? component?.name ?? '', redirect: literal(prop(node, 'redirect')), chunks, componentModules });
        const children = prop(node, 'children');
        if (children?.type === 'ArrayExpression') collect(children, full);
      }
    }
    collect(array);
    candidates.push({ file, routes, hash: crypto.createHash('sha256').update(text).digest('hex') });
  }
}
if (candidates.length !== 1) throw new Error(`Expected one route table, found ${candidates.length}; inspect artifacts before regenerating`);
const router = candidates[0];
function phpRoutes(area) {
  const file = `data/route/${area}.php`;
  const text = read(file);
  const rows = [];
  const pattern = /Route::(get|post|put|delete|patch|any|rule|resource|controller)\(\s*(?:\$domain\s*\.\s*)?["']([^"']*)["']\s*,\s*["']([^"']+)["']/gi;
  for (const m of text.matchAll(pattern)) {
    const parts = m[3].replace(/\/+$/, '').split('/');
    const fileName = parts[1]?.split('_').map(p => p.charAt(0).toUpperCase() + p.slice(1)).join('');
    const dir = path.join(root, `app/${parts[0]}/controller`);
    const found = fs.existsSync(dir) ? fs.readdirSync(dir).find(f => normalize(f) === normalize(`${fileName}Controller.php`)) : null;
    rows.push({ method: m[1].toUpperCase(), url: `${area === 'admin' ? '{A}/' : '/'}${m[2].replace(/^\//, '')}`, target: m[3], key: normalize(`${parts[1]}/${parts[2] ?? ''}`), file: found ? `app/${parts[0]}/controller/${found}` : null, action: parts[2], line: lineAt(text, m.index), routeFile: file });
  }
  return rows;
}
const declarations = [...phpRoutes('admin'), ...phpRoutes('home')];
const implicit = [];
for (const declaration of declarations.filter(r => r.method === 'CONTROLLER' && r.file)) {
  const source = read(declaration.file);
  for (const method of source.matchAll(/public\s+function\s+((get|post|put|delete|patch)(\w+))\s*\(/gi)) {
    const target = `${declaration.target}/${method[1]}`;
    implicit.push({ ...declaration, method: method[2].toUpperCase(), url: `${declaration.url}/${method[3]}`, target, key: normalize(`${declaration.target.split('/')[1]}/${method[1]}`), action: method[1], line: lineAt(source, method.index) });
  }
}
const routes = [...declarations, ...implicit];
const views = routes.filter(r => /\/(view[a-z]*)\//i.test(r.target));
function methodSource(route) {
  if (!route.file) return null;
  const text = read(route.file);
  const functions = [...text.matchAll(/(?:public|protected|private)\s+function\s+(\w+)\s*\(/g)];
  const index = functions.findIndex(m => normalize(m[1]) === normalize(route.action ?? ''));
  if (index < 0) return null;
  const start = functions[index].index;
  return { body: text.slice(start, functions[index + 1]?.index ?? text.length), line: lineAt(text, start) };
}
const output = [
  '# 后台前端路由与服务端页面静态盘点', '',
  '本文件由 `docs/scripts/generate-admin-page-inventory.cjs` 生成。解析 JavaScript AST，不执行编译资源。前端路由与 PHP 页面是两套入口，不能相加后宣称页面完整；隐藏、重定向、插件动态菜单和部署路径仍须浏览器验证。', '',
  `前端产物：${link(router.file)}；SHA256：\`${router.hash}\`。`, '',
  `路由记录 ${router.routes.length} 条（包含父布局、重定向、错误页）；PHP View* 路由声明 ${views.length} 条，其中后台 ${views.filter(r => r.target.startsWith('admin/')).length} 条、前台 ${views.filter(r => r.target.startsWith('home/')).length} 条（含不同 HTTP 方法）。字面量路由声明 ${declarations.length} 条，CONTROLLER 方法推导候选 ${implicit.length} 条，不相加作为运行时端点数。\`{A}\` 代表实际后台前缀。`, '',
  '## 前端路由表', '',
  '| 前端路由 | name | 重定向 | 延迟加载 chunk |', '| --- | --- | --- | --- |',
  ...router.routes.map(r => `| \`${cell(r.path)}\` | \`${cell(r.name)}\` | ${cell(r.redirect ?? '-')} | ${cell(r.chunks.join(', ') || '同步/共享组件，须人工追溯')} |`), '',
  '## PHP 页面到业务控制器的直接调用', '',
  '这里只提取方法体中的 controller() 直接调用。它不是完整调用图：ViewModel、tagdata、逻辑层、资源接口和前端请求另行核对。“占位”仅指视图方法，不代表业务接口缺失。', '',
  '| 页面与方法 | 视图源码 | 直接调用及匹配的路由 |', '| --- | --- | --- |',
];
for (const view of views) {
  const source = methodSource(view);
  const refs = [];
  if (source) {
    const vars = new Map([...source.body.matchAll(/\$(\w+)\s*=\s*controller\(["'](\w+)["']\)/g)].map(m => [m[1], m[2]]));
    for (const m of source.body.matchAll(/\$(\w+)->(\w+)\(/g)) {
      if (!vars.has(m[1])) continue;
      const target = `${vars.get(m[1])}/${m[2]}`;
      const matched = routes.filter(r => r.key === normalize(target) && r.target.startsWith(view.target.split('/')[0] + '/'));
      refs.push(`${target}: ${matched.map(r => `${r.method} ${r.url}`).join(', ') || '无显式路由匹配，继续追溯'}`);
    }
    if (/\["data"\]\s*=\s*"test"/.test(source.body)) refs.push('视图占位 test；另查业务 API');
  }
  output.push(`| ${view.method} \`${cell(view.url)}\` | ${view.file && source ? link(view.file, source.line) : '未定位'} | ${cell([...new Set(refs)].join('; ') || '无 controller() 直接调用；需核对 ViewModel/模板/前端请求')} |`);
}
output.push('', '## 字面量业务路由声明', '',
  '该表逐条保留 admin/home 路由的字面量声明及源行；RESOURCE 未展开，CONTROLLER 的公有方法候选另表列出，RULE/ANY 不代表仅 GET。当前 admin 外层采用 {A} 前缀，home 所扫描的 group 前缀为空。被 include 的路由、插件和运行时注册未计入。此表不是参数/返回 schema，也不是运行时 route:list。', '',
  '| 声明方法 | URL / 声明前缀 | 控制器目标 | 路由来源 |', '| --- | --- | --- | --- |',
  ...declarations.filter(r => !views.includes(r)).map(r => `| ${r.method} | \`${cell(r.url)}\` | \`${cell(r.target)}\` | ${link(r.routeFile, r.line)} |`), '',
  '## CONTROLLER 公有方法推导候选', '',
  '按 vendor/thinkphp/library/think/Route.php 的默认 get/post/put/delete/patch 前缀，提取本控制器文件内公有方法。未包含继承/trait 方法、运行时前缀修改、参数 pattern 和显式路由优先级；URL 大小写/下划线别名须运行验证。候选不等于 HTTP 可达证据，也不并入字面量声明计数。', '',
  '| 方法 | 推导 URL | 实际方法 | 源码 |', '| --- | --- | --- | --- |',
  ...implicit.map(r => `| ${r.method} | \`${cell(r.url)}\` | \`${cell(r.target)}\` | ${link(r.file, r.line)} |`), '',
  '## 再生成', '',
  '仅安装静态文档解析依赖到临时目录，不修改应用依赖：', '',
  '```sh', 'npm install --prefix /tmp/zjmf-doc-parser acorn@8 --ignore-scripts --no-audit --no-fund',
  'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --write',
  'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-page-inventory.cjs --check', '```', '',
);
const result = output.join('\n');
const destination = path.join(root, 'docs/frontend/22-admin-route-inventory.md');
if (require.main === module) {
  if (process.argv.includes('--write')) fs.writeFileSync(destination, result);
  else if (process.argv.includes('--check')) {
    if (fs.readFileSync(destination, 'utf8') !== result) throw new Error('Static inventory is stale');
    console.log(`Inventory verified: ${router.routes.length} frontend records, ${declarations.length} PHP declarations, ${implicit.length} controller candidates`);
  } else process.stdout.write(result);
}
module.exports = { router, declarations, implicit };
