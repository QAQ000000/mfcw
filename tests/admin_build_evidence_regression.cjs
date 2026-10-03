const assert = require('node:assert/strict');
const acorn = require('acorn');
const { pages, cssCache, walkSelf, selfMember } = require('../docs/scripts/generate-admin-build-evidence.cjs');
const page = route => {
  const found = pages.find(item => item.route.path === route);
  assert.ok(found, `Missing route: ${route}`);
  return found;
};
assert.equal(pages.length, 229);
const list = page('/customer-list');
assert.equal(list.route.parent, '/');
assert.equal(list.attribution, '路由 factory 指向模块');
const listComponent = list.components.find(component => component.scope === '3a7c7393');
assert.ok(listComponent);
const load = listComponent.actions.find(action => action.name === 'getData');
assert.ok(load.request.found.some(request => request.url === '"client_list"' && request.method === '"post"'));
assert.ok(!load.request.found.some(request => request.url === '"create_client_post"'));
assert.ok(load.effects.includes('e.tableLoading'));
assert.ok(!load.effects.includes('t.next'));
assert.ok(listComponent.navigation.some(item => item.includes('/customer-view/abstract') && item.includes('query:{id:e}')));
const columns = listComponent.elements.filter(element => element.tag === 'el-table-column');
assert.ok(columns.some(element => element.properties.includes('prop="credit_limit"')));
assert.ok(listComponent.elements.some(element => element.context.includes('scopedSlots') && element.events.some(event => event.includes('goToView'))));
const listStyles = list.styles.flatMap(file => cssCache.get(file)?.rules ?? []);
assert.ok(listStyles.some(rule => rule.context.includes('max-width:800px') && rule.declarations.includes('grid-template-columns:repeat(2,48%)')));
const customer = page('/customer-view');
assert.ok(customer.children.includes('/customer-view/person'));
assert.ok(customer.components.some(component => component.elements.some(element => element.tag === 'el-tabs' && element.context.includes('else(e.screenWidth>992)'))));
const person = page('/customer-view/person');
assert.equal(person.route.parent, '/customer-view');
const edit = person.components.flatMap(component => component.actions).find(action => action.name === 'editCustomer');
assert.ok(edit.request.found.some(request => request.url === '"profile_post"' && request.method === '"post"'));
assert.ok(!edit.request.found.some(request => request.url === '"client_list"'));
assert.ok(edit.feedback.some(text => text.includes('update_success')));
assert.ok(person.components.some(component => component.rules.some(rule => rule.field === 'username' && rule.constraints.includes('required=!0'))));
assert.equal(page('/set').attribution, '未定位组件');

// A nested generator parameter can shadow the captured Vue instance alias.
const fixture = acorn.parse('(function(){var e=this;e.loading=true;function state(e){e.next=1;e.loading=false;}function callback(){e.done=true;}})', { ecmaVersion: 'latest' });
const assigned = [];
walkSelf(fixture, (node, aliases) => {
  if (node.type === 'AssignmentExpression' && selfMember(node.left, aliases)) assigned.push(node.left.property.name);
});
assert.deepEqual(assigned, ['loading', 'done']);
console.log('PASS admin build evidence: route hierarchy, local request attribution, controls, CSS and lexical shadowing');
