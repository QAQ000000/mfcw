// Inspect Webpack module AST and CSS rules without executing application artifacts.
const fs = require('node:fs');
const path = require('node:path');
const crypto = require('node:crypto');
const acorn = require('acorn');
const postcss = require('postcss');
const { router } = require('./generate-admin-page-inventory.cjs');
const root = path.resolve(__dirname, '../..');
const destination = path.join(root, 'docs/frontend/27-admin-built-page-evidence.md');
const read = file => fs.readFileSync(path.join(root, file), 'utf8');
const key = property => property?.key?.name ?? property?.key?.value;
const prop = (node, name) => node?.properties?.find(p => key(p) === name)?.value;
const literal = node => node?.type === 'Literal' ? node.value : undefined;
const fn = node => ['FunctionExpression', 'FunctionDeclaration', 'ArrowFunctionExpression'].includes(node?.type);
const hash = text => crypto.createHash('sha256').update(text).digest('hex');
const cell = text => String(text).replace(/\|/g, '\\|').replace(/[\r\n]+/g, ' ');
const code = text => '`' + cell(text).replace(/`/g, "'") + '`';
const link = (file, label = file) => `[${cell(label)}](../../${file}#L1)`;
function walk(node, visit) {
  if (!node || typeof node !== 'object') return;
  if (node.type) visit(node);
  for (const value of Object.values(node)) {
    if (Array.isArray(value)) value.forEach(child => walk(child, visit));
    else if (value && typeof value === 'object') walk(value, visit);
  }
}
function expression(node, source, limit = 180) {
  if (!node) return '-';
  const text = source.slice(node.start, node.end).replace(/[\r\n]+/g, ' ');
  return text.length > limit ? text.slice(0, limit) + ' ...' : text;
}
function unique(items) { return [...new Set(items)]; }
const language = new Map();
walk(acorn.parse(read('public/admin/lang/zh.js'), { ecmaVersion: 'latest' }), node => {
  if (node.type === 'VariableDeclarator' && node.id.name === 'lang_obj') {
    for (const p of node.init.properties) if (typeof literal(p.value) === 'string') language.set(key(p), literal(p.value));
  }
});
function label(node, source) {
  if (node?.type === 'MemberExpression' && node.object?.type === 'MemberExpression' && node.object.property.name === '$lang') {
    const name = node.computed ? literal(node.property) : node.property.name;
    return language.has(name) ? `${language.get(name)} ($lang.${name})` : expression(node, source);
  }
  return expression(node, source);
}
const jsFiles = fs.readdirSync(path.join(root, 'public/admin/js')).sort();
const cssFiles = fs.readdirSync(path.join(root, 'public/admin/css')).sort();
const modules = new Map();
const moduleVariants = new Map();
const parsedFiles = new Map();
const conflicts = new Set();
function parseFile(file) {
  if (parsedFiles.has(file)) return parsedFiles.get(file);
  const source = read(file);
  const ast = acorn.parse(source, { ecmaVersion: 'latest', sourceType: 'script' });
  const record = { file, source, hash: hash(source), moduleIds: [] };
  // Only the second argument of a Webpack JSONP payload is the module registry.
  walk(ast, node => {
    if (node.type !== 'CallExpression' || node.callee.type !== 'MemberExpression' || node.callee.property.name !== 'push') return;
    const payload = node.arguments[0];
    if (payload?.type !== 'ArrayExpression' || payload.elements[0]?.type !== 'ArrayExpression' || payload.elements[1]?.type !== 'ObjectExpression') return;
    for (const p of payload.elements[1].properties) {
      if (!fn(p.value)) continue;
      const id = String(key(p));
      const bodyHash = hash(source.slice(p.value.start, p.value.end));
      record.moduleIds.push(id);
      moduleVariants.set(`${file}:${id}`, { id, file, source, node: p.value, bodyHash });
      const previous = modules.get(id);
      if (previous && previous.bodyHash !== bodyHash) conflicts.add(id);
      if (!previous) modules.set(id, { id, file, source, node: p.value, bodyHash });
    }
  });
  parsedFiles.set(file, record);
  return record;
}
// Vendor chunks are excluded: page modules and bundled request helpers suffice
// for direct call evidence; unresolved vendor calls remain explicitly unresolved.
for (const name of jsFiles.filter(name => !name.startsWith('vendors~') && name.endsWith('.js'))) parseFile(`public/admin/js/${name}`);
const moduleInfo = new Map();
function info(id, file) {
  const cacheKey = `${file ?? ''}:${id}`;
  if (moduleInfo.has(cacheKey)) return moduleInfo.get(cacheKey);
  const module = moduleVariants.get(`${file}:${id}`) ?? (conflicts.has(id) ? null : modules.get(id));
  if (!module) return null;
  const bindings = new Map(), imports = new Map(), exports = new Map();
  const requireName = module.node.params[2]?.name;
  for (const statement of module.node.body.body) {
    if (statement.type === 'VariableDeclaration') for (const item of statement.declarations) {
      if (item.id.type === 'Identifier') bindings.set(item.id.name, item.init);
    }
    if (statement.type === 'FunctionDeclaration') bindings.set(statement.id.name, statement);
  }
  for (const [name, value] of bindings) {
    const node = value?.type === 'SequenceExpression' ? value.expressions.at(-1) : value;
    if (node?.type === 'CallExpression' && node.callee.name === requireName && typeof literal(node.arguments[0]) === 'string') imports.set(name, literal(node.arguments[0]));
  }
  walk(module.node.body, node => {
    if (node.type === 'CallExpression' && node.callee.type === 'MemberExpression' && node.callee.object.name === requireName && node.callee.property.name === 'd' && typeof literal(node.arguments[1]) === 'string') {
      const getter = node.arguments[2];
      const returned = getter?.body?.body?.find(s => s.type === 'ReturnStatement')?.argument;
      if (returned?.type === 'Identifier') exports.set(literal(node.arguments[1]), returned.name);
    }
  });
  const result = { ...module, bindings, imports, exports };
  moduleInfo.set(cacheKey, result);
  return result;
}
function resolve(node, module, visited = new Set()) {
  if (node?.type !== 'Identifier' || visited.has(node.name) || !module.bindings.has(node.name)) return node;
  return resolve(module.bindings.get(node.name), module, new Set([...visited, node.name]));
}
function importedCall(node, module) {
  let target = node.callee;
  if (target?.type === 'CallExpression' && target.callee.name === 'Object') target = target.arguments[0];
  if (target?.type === 'MemberExpression' && module.imports.has(target.object.name)) {
    const moduleId = module.imports.get(target.object.name);
    const exportName = target.computed ? literal(target.property) : target.property.name;
    const dependency = info(moduleId, module.file);
    const binding = dependency?.exports.get(exportName);
    return { moduleId, exportName, module: dependency, node: binding ? dependency.bindings.get(binding) : null };
  }
  if (target?.type === 'Identifier' && fn(module.bindings.get(target.name))) return { moduleId: module.id, exportName: target.name, module, node: module.bindings.get(target.name) };
  return null;
}
function requests(body, module, visited = new Set()) {
  const found = [], unresolved = [];
  walk(body, node => {
    if (node.type !== 'CallExpression') return;
    const target = importedCall(node, module);
    const callee = expression(node.callee, module.source);
    for (const config of node.arguments.filter(argument => argument?.type === 'ObjectExpression' && prop(argument, 'url'))) {
      if (!target && !/\$(?:http|axios)|\b(?:axios|request)\b/.test(callee)) continue;
      const url = prop(config, 'url');
      if (typeof literal(url) === 'string' || ['BinaryExpression', 'TemplateLiteral', 'CallExpression'].includes(url.type)) {
        const method = prop(config, 'method');
        found.push({ url: expression(url, module.source), method: method ? expression(method, module.source) : '未显式指定', location: `${module.file} / ${module.id}`, encoding: prop(config, 'data') ? 'data' : prop(config, 'params') ? 'params' : '无显式 data/params' });
      }
    }
    if (!target) return;
    const signature = `${target.moduleId}:${target.exportName}`;
    if (!target.node) { unresolved.push(signature); return; }
    if (visited.has(signature)) return;
    const next = requests(target.node.body, target.module, new Set([...visited, signature]));
    found.push(...next.found); unresolved.push(...next.unresolved);
  });
  return { found: [...new Map(found.map(item => [`${item.method}:${item.url}`, item])).values()], unresolved: unique(unresolved) };
}
function selfMember(node, aliases) {
  let base = node;
  while (base?.type === 'MemberExpression') base = base.object;
  return base?.type === 'ThisExpression' || (base?.type === 'Identifier' && aliases.has(base.name));
}
function walkSelf(node, visit, inherited = new Set()) {
  if (!node || typeof node !== 'object') return;
  let aliases = inherited;
  if (fn(node)) {
    aliases = new Set(inherited);
    for (const parameter of node.params) if (parameter.type === 'Identifier') aliases.delete(parameter.name);
    function declarations(child) {
      if (!child || typeof child !== 'object' || (child !== node && fn(child))) return;
      if (child.type === 'VariableDeclarator' && child.id.type === 'Identifier') {
        aliases.delete(child.id.name);
        if (child.init?.type === 'ThisExpression' || (child.init?.type === 'Identifier' && aliases.has(child.init.name))) aliases.add(child.id.name);
      }
      for (const value of Object.values(child)) {
        if (Array.isArray(value)) value.forEach(declarations);
        else if (value && typeof value === 'object') declarations(value);
      }
    }
    declarations(node);
  }
  if (node.type) visit(node, aliases);
  for (const value of Object.values(node)) {
    if (Array.isArray(value)) value.forEach(child => walkSelf(child, visit, aliases));
    else if (value && typeof value === 'object') walkSelf(value, visit, aliases);
  }
}
function cssEvidence(file) {
  const source = read(file), ast = postcss.parse(source, { from: file });
  const rules = [];
  ast.walkRules(rule => {
    const declarations = rule.nodes.filter(node => node.type === 'decl').map(node => `${node.prop}:${node.value}${node.important ? '!important' : ''}`);
    const contexts = [];
    for (let parent = rule.parent; parent; parent = parent.parent) if (parent.type === 'atrule') contexts.unshift(`@${parent.name} ${parent.params}`);
    rules.push({ selector: rule.selector, context: contexts.join(' > ') || '常规', declarations: declarations.join('; ') });
  });
  return { file, hash: hash(source), rules };
}
const cssCache = new Map();
function inspectComponent(module, options, render, scope, staticRenders) {
  const source = module.source;
  const methods = prop(options, 'methods')?.properties ?? [];
  const methodNames = new Set(methods.map(key));
  const components = prop(options, 'components')?.properties?.map(key) ?? [];
  const elements = [], navigation = [], conditions = [], lifecycle = [], states = [], watchers = [], rules = [];
  const staticArray = resolve(staticRenders, module);
  const renders = [resolve(render, module), ...(staticArray?.type === 'ArrayExpression' ? staticArray.elements : [])];
  for (const [renderIndex, renderNode] of renders.entries()) {
    if (!fn(renderNode)) continue;
    // Vue render aliases are bound to $createElement or _self._c.
    const aliases = new Set();
    walk(renderNode, node => {
      if (node.type === 'VariableDeclarator' && node.id.type === 'Identifier') {
        let renderer = false;
        walk(node.init, child => { if (child.type === 'MemberExpression' && ['$createElement', '_c'].includes(child.property.name)) renderer = true; });
        if (renderer || (node.init?.type === 'Identifier' && aliases.has(node.init.name))) aliases.add(node.id.name);
      }
    });
    function tree(node, depth = 0, context = '') {
      if (!node || typeof node !== 'object') return;
      if (node.type === 'ConditionalExpression') {
        const test = expression(node.test, source);
        conditions.push(test);
        tree(node.consequent, depth, `${context}${context ? '; ' : ''}${test}`);
        tree(node.alternate, depth, `${context}${context ? '; ' : ''}else(${test})`);
        return;
      }
      if (node.type === 'CallExpression' && node.callee.type === 'MemberExpression' && node.callee.property.name === '_l') {
        tree(node.arguments[1], depth, `${context}${context ? '; ' : ''}循环 ${expression(node.arguments[0], source)}`);
        return;
      }
      if (node.type === 'CallExpression' && aliases.has(node.callee.name)) {
        const tag = typeof literal(node.arguments[0]) === 'string' ? literal(node.arguments[0]) : expression(node.arguments[0], source);
        const config = node.arguments[1]?.type === 'ObjectExpression' ? node.arguments[1] : null;
        const attrs = prop(config, 'attrs');
        const properties = (attrs?.properties ?? []).filter(p => !['password', 'token', 'value'].includes(key(p))).map(p => `${key(p)}=${label(p.value, source)}`);
        for (const name of ['staticClass', 'class', 'staticStyle', 'style', 'ref', 'directives']) if (prop(config, name)) properties.push(`${name}=${expression(prop(config, name), source, 220)}`);
        if (prop(config, 'model')) properties.push(`model.expression=${expression(prop(prop(config, 'model'), 'expression'), source)}`);
        const events = ['on', 'nativeOn'].flatMap(name => prop(config, name)?.properties?.map(p => `${name}.${key(p)} → ${expression(p.value, source, 200)}`) ?? []);
        const text = [];
        const children = config ? node.arguments[2] : node.arguments[1];
        // Only direct text children belong to this element, not nested controls.
        for (const child of children?.elements ?? []) if (child?.type === 'CallExpression' && child.callee.property?.name === '_v') {
          const value = child.arguments[0];
          text.push(value?.type === 'CallExpression' && value.callee.property?.name === '_s' ? label(value.arguments[0], source) : label(value, source));
        }
        elements.push({ depth, tag, properties, events, text, context });
        if (prop(attrs, 'to')) navigation.push(`render ${tag}: ${expression(prop(attrs, 'to'), source, 280)}`);
        tree(children, depth + 1, context);
        if (prop(config, 'scopedSlots')) tree(prop(config, 'scopedSlots'), depth + 1, `${context}${context ? '; ' : ''}scopedSlots`);
        return;
      }
      for (const value of Object.values(node)) {
        if (Array.isArray(value)) value.forEach(child => tree(child, depth, context));
        else if (value && typeof value === 'object') tree(value, depth, context);
      }
    }
    tree(renderNode.body, 0, renderIndex ? `staticRenderFns[${renderIndex - 1}]（插入位置另查 _m）` : '');
  }
  const data = resolve(prop(options, 'data'), module);
  if (fn(data)) walk(data.body, node => {
    if (node.type !== 'ReturnStatement' || node.argument?.type !== 'ObjectExpression') return;
    for (const p of node.argument.properties) {
      states.push(String(key(p)));
      if (!/rules$/i.test(key(p)) || p.value.type !== 'ObjectExpression') continue;
      for (const field of p.value.properties) {
        const checks = field.value.type === 'ArrayExpression' ? field.value.elements : [field.value];
        for (const check of checks) {
          if (check?.type !== 'ObjectExpression') continue;
          rules.push({ group: key(p), field: key(field), constraints: check.properties.map(rule => `${key(rule)}=${fn(rule.value) ? '自定义函数（见产物）' : label(rule.value, source)}`) });
        }
      }
    }
  });
  for (const name of ['created', 'mounted', 'beforeMount', 'updated', 'beforeDestroy', 'activated', 'deactivated', 'beforeRouteEnter', 'beforeRouteLeave']) if (prop(options, name)) lifecycle.push(name);
  for (const p of prop(options, 'watch')?.properties ?? []) watchers.push(String(key(p)));
  const actions = methods.map(p => {
    const request = requests(p.value, module);
    const calls = [], effects = [], branches = [], feedback = [], validation = [];
    walkSelf(p.value, (node, aliases) => {
      if (node.type === 'CallExpression') {
        const target = node.callee;
        if (target.type === 'MemberExpression' && selfMember(target, aliases) && methodNames.has(target.property.name)) calls.push(target.property.name);
        if (target.type === 'MemberExpression' && ['push', 'replace', 'go', 'back'].includes(target.property.name) && expression(target.object, source).includes('$router')) navigation.push(`${key(p)}: ${expression(node, source, 320)}`);
        if (target.type === 'MemberExpression' && ['validate', 'validateField', 'resetFields', 'clearValidate'].includes(target.property.name)) validation.push(expression(node.callee, source));
        if (target.type === 'MemberExpression' && selfMember(target, aliases) && ['$message', '$confirm', '$alert', '$notify'].includes(target.property.name)) feedback.push(expression(node, source, 320));
      }
      if (node.type === 'AssignmentExpression' && node.left.type === 'MemberExpression' && selfMember(node.left, aliases)) effects.push(expression(node.left, source));
      if (node.type === 'IfStatement') branches.push(expression(node.test, source));
      if (node.type === 'ConditionalExpression') branches.push(expression(node.test, source));
    });
    return { name: key(p), calls: unique(calls), effects: unique(effects), branches: unique(branches), feedback: unique(feedback), validation: unique(validation), request };
  });
  const hookRequests = lifecycle.map(name => ({ name, ...requests(prop(options, name), module) }));
  return { module, scope, elements, components, rules, navigation: unique(navigation), conditions: unique(conditions), lifecycle, states: unique(states), watchers, actions, hookRequests };
}
const components = new Map();
function componentEvidence(id, file) {
  const cacheKey = `${file ?? ''}:${id}`;
  if (components.has(cacheKey)) return components.get(cacheKey);
  const module = info(id, file);
  if (!module) return [];
  const found = [], seen = new Set();
  walk(module.node.body, node => {
    if (node.type !== 'CallExpression' || node.arguments.length < 6) return;
    const options = resolve(node.arguments[0], module), render = resolve(node.arguments[1], module);
    if (options?.type !== 'ObjectExpression' || !fn(render)) return;
    const signature = `${options.start}:${render.start}`;
    if (seen.has(signature)) return;
    seen.add(signature);
    found.push(inspectComponent(module, options, render, literal(node.arguments[5]) ?? null, node.arguments[2]));
  });
  components.set(cacheKey, found);
  return found;
}
const pages = router.routes.map((route, index) => {
  const files = route.chunks.flatMap(chunk => jsFiles.filter(name => name.startsWith(chunk + '.') && name.endsWith('.js')).map(name => `public/admin/js/${name}`));
  const styles = route.chunks.flatMap(chunk => cssFiles.filter(name => name.startsWith(chunk + '.') && name.endsWith('.css')).map(name => `public/admin/css/${name}`));
  const direct = route.componentModules.flatMap(id => {
    const file = files.find(file => moduleVariants.has(`${file}:${id}`));
    return componentEvidence(id, file);
  });
  // If a route factory is not resolved, keep the candidates explicitly marked.
  const candidates = direct.length ? direct : files.filter(file => !path.basename(file).startsWith('vendors~')).flatMap(file => parseFile(file).moduleIds.flatMap(id => componentEvidence(id, file)));
  for (const file of styles.filter(file => !path.basename(file).startsWith('vendors~'))) if (!cssCache.has(file)) cssCache.set(file, cssEvidence(file));
  return { route, index: index + 1, files, styles, components: candidates, attribution: direct.length ? '路由 factory 指向模块' : candidates.length ? 'chunk 内候选，页面归属待人工确认' : '未定位组件', children: router.routes.filter(child => child.parent === route.path).map(child => child.path) };
});
const count = pages.filter(page => page.attribution === '路由 factory 指向模块').length;
const output = [
  '# 后台编译产物逐页结构与交互证据', '',
  '本文件由 `docs/scripts/generate-admin-build-evidence.cjs` 静态生成，不执行页面 JS、不请求业务接口。它记录旧产物中的结构和代码绑定，不是新布局建议，也不是浏览器验收。先阅读[旧后台解读](28-admin-built-layout-reading.md)，再与[新布局](12-admin-page-layout-details.md)和[样板契约](26-admin-pilot-contract.md)对照。', '',
  `路由 ${pages.length} 条；直接定位路由模块并提取组件 ${count} 条；候选/未定位 ${pages.length - count} 条。同 ID 源文本不同的模块 ${conflicts.size} 个（可能来自压缩变量命名差异，不直接判断语义冲突）。优先使用当前文件的模块；跨文件存在歧义的调用不自动合并。此计数包含父布局、错误页和重定向，不等于业务页面总数。`, '',
  `路由来源：${link(router.file)}，SHA256 ${code(router.hash)}。语言来源：${link('public/admin/lang/zh.js')}。`, '',
  '## 如何阅读', '',
  '- 结构表的层级按 Vue render 函数的子元素关系提取；条件/循环下会包含互斥分支，不代表它们同时显示。staticRenderFns 附列静态渲染段，插入位置另查 _m。动态标签、插槽和被引用子组件仍需追溯。',
  '- 字段/列/属性和事件按代码中的顺序记录；$lang 的简单键关联到简体语言文件，动态语言和服务端选项不猜值。model/directives 是数据绑定线索，不是服务端必填或权限保证。',
  '- 路由 factory 定位到 Webpack 模块；同模块中的多个 Vue 组件按 scope 分别列出，可能含内嵌组件，不把每个组件都当成独立页面。每个组件的最终默认导出和可见区域需人工核对。',
  '- 接口只从组件方法/生命周期调用追踪到同产物中的 Webpack 导出函数，不将共享模块里未调用的接口列作页面接口。未显式 method 不擅自写成 GET；未解析模块/export 单独保留（其中也有编译辅助函数，不全部视为接口）。此追踪是可能调用关系，不证明分支已运行。',
  '- 方法的状态赋值、分支、校验及通知是代码片段线索；只列属性名称，不导出 data 初始值。动态响应、错误码、销售/部门限制须与 PHP 实现核对。',
  '- CSS 表记录非 vendor 的对应 chunk 规则；共享公共 CSS、样式层叠和组件库默认值也会影响结果。声明值不是浏览器最终尺寸，媒体规则不是移动端可用性证明。',
  '- 每页仍需补：实际可见菜单、脱敏运行截图、桌面/手机效果、正常/拒绝/错误场景及新设计差异。未出现某事件/字段不代表能力不存在，可能来自子组件或运行时数据。', '',
  '## 页面索引', '',
  '| 编号 | 路由 | 父路由 | 直接子路由数 | 组件归属 |', '| --- | --- | --- | --- |',
  ...pages.map(page => `| [P${String(page.index).padStart(3, '0')}](#p${String(page.index).padStart(3, '0')}) | ${code(page.route.path)} | ${code(page.route.parent ?? '-')} | ${page.children.length} | ${page.attribution} |`), '',
];
for (const page of pages) {
  const { route } = page;
  output.push(`<a id="p${String(page.index).padStart(3, '0')}"></a>`, '', `## P${String(page.index).padStart(3, '0')} ${route.path}`, '',
    `路由名称 ${code(route.name)}；父路由 ${code(route.parent ?? '-')}；重定向 ${code(route.redirect ?? '-')}。`, '',
    `直接子路由：${page.children.map(code).join('、') || '无静态 children'}。`, '',
    `组件归属：${page.attribution}；模块 ${route.componentModules.map(code).join(', ') || '未从 factory 定位'}。`, '',
    `JS：${page.files.map(file => link(file)).join('；') || '同步/共享入口，需追溯'}。`, '',
    `CSS：${page.styles.map(file => link(file)).join('；') || '未发现对应独立 CSS，核对公共样式'}。`, '');
  if (!page.components.length) output.push('静态状态：未提取组件结构，需追溯同步组件/共享入口；不补造布局和交互。', '');
  for (const component of page.components) {
    output.push(`### 模块 ${component.module.id} / scope ${component.scope ?? '无'}`, '',
      `来源 ${link(component.module.file)}；scope ${code(component.scope ?? '-')}；SHA256 ${code(parsedFiles.get(component.module.file).hash)}。`, '',
      `注册子组件：${component.components.map(code).join('、') || '无显式注册'}。生命周期：${component.lifecycle.map(code).join('、') || '未提取'}；watch：${component.watchers.map(code).join('、') || '未提取'}。`, '',
      `data 字段名：${component.states.map(code).join('、') || '未提取'}。`, '',
      '#### 渲染结构与事件', '',
      '| 层级 | 元素/组件 | 字段、列与布局属性 | 文本 | 条件分支 | 事件绑定 |', '| --- | --- | --- | --- | --- | --- |',
      ...component.elements.map(element => `| ${element.depth} | ${code(element.tag)} | ${element.properties.map(code).join('<br>') || '-'} | ${element.text.map(code).join('<br>') || '-'} | ${code(element.context || '-')} | ${element.events.map(code).join('<br>') || '-'} |`), '',
      '#### 本地表单校验', '',
      '| 规则组 | 字段 | 校验声明 |', '| --- | --- | --- |',
      ...component.rules.map(rule => `| ${code(rule.group)} | ${code(rule.field)} | ${rule.constraints.map(code).join('<br>')} |`),
      ...(component.rules.length ? [] : ['| - | - | 未提取 data 返回对象中的本地 rules；核对子组件/动态规则及后端校验 |']), '',
      '#### 页面方法与请求链', '',
      '| 方法 | 同组件方法调用 | 状态赋值目标 | 分支/校验 | 提示/确认 | 请求函数证据 | 未解析调用 |', '| --- | --- | --- | --- | --- | --- | --- |',
      ...component.actions.map(action => `| ${code(action.name)} | ${action.calls.map(code).join('<br>') || '-'} | ${action.effects.map(code).join('<br>') || '-'} | ${[...action.branches, ...action.validation].map(code).join('<br>') || '-'} | ${action.feedback.map(code).join('<br>') || '-'} | ${action.request.found.map(request => `${code(request.method)} ${code(request.url)} (${request.encoding})；${code(request.location)}`).join('<br>') || '未提取直接请求'} | ${action.request.unresolved.map(code).join('<br>') || '-'} |`), '',
      ...component.hookRequests.filter(hook => hook.found.length || hook.unresolved.length).map(hook => `生命周期 ${code(hook.name)}：${hook.found.map(request => `${code(request.method)} ${code(request.url)}`).join('；') || '未提取请求'}；未解析 ${hook.unresolved.map(code).join(', ') || '无'}。`), '',
      '#### 跳转与上下文', '',
      ...component.navigation.map(item => `- ${code(item)}`),
      ...(component.navigation.length ? [] : ['未提取直接跳转；核对外壳/子组件和运行时导航。']), '');
  }
  output.push('### 对应 CSS 声明', '',
    `CSS SHA256：${page.styles.filter(file => cssCache.has(file)).map(file => `${code(path.basename(file))} ${code(cssCache.get(file).hash)}`).join('；') || '无已解析的独立 CSS'}。`, '',
    '| 资源 | 条件 | 选择器 | 声明 |', '| --- | --- | --- | --- |');
  let ruleCount = 0;
  for (const file of page.styles) {
    const style = cssCache.get(file);
    if (!style) continue;
    for (const rule of style.rules) { ruleCount++; output.push(`| ${link(file, path.basename(file))} | ${code(rule.context)} | ${code(rule.selector)} | ${code(rule.declarations)} |`); }
  }
  if (!ruleCount) output.push('| - | - | - | 无对应非 vendor CSS 规则；需核对公共样式 |');
  output.push('', '运行验证：NOT RUN；新设计差异由对应页面契约另列。', '');
}
output.push('## 再生成与检查', '', '临时解析依赖不加入应用工程：', '', '```sh',
  'npm install --prefix /tmp/zjmf-doc-parser acorn@8 postcss@8 --ignore-scripts --no-audit --no-fund',
  'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-build-evidence.cjs --write',
  'NODE_PATH=/tmp/zjmf-doc-parser/node_modules node docs/scripts/generate-admin-build-evidence.cjs --check', '```', '',
  '动态路由、插件菜单、运行时权限、网络错误及最终渲染不在自动静态提取范围内。', '');
const result = output.join('\n');
if (require.main === module) {
  if (process.argv.includes('--write')) fs.writeFileSync(destination, result);
  else if (process.argv.includes('--check')) {
    if (read('docs/frontend/27-admin-built-page-evidence.md') !== result) throw new Error('Build evidence is stale');
  } else process.stdout.write(result);
  if (process.argv.includes('--write') || process.argv.includes('--check')) console.log(`Build evidence: ${pages.length} routes, ${count} direct components, ${pages.length - count} unresolved/candidate records, ${conflicts.size} module text variants`);
}
module.exports = { pages, cssCache, resolve, walkSelf, selfMember, language };
