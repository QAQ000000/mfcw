const fs = require('node:fs');
const path = require('node:path');
const root = path.resolve(__dirname, '../..');
function markdownFiles(directory) {
  return fs.readdirSync(directory, { withFileTypes: true }).flatMap(entry => {
    const file = path.join(directory, entry.name);
    return entry.isDirectory() ? markdownFiles(file) : entry.name.endsWith('.md') ? [file] : [];
  });
}
const files = [
  ...markdownFiles(path.join(root, 'docs')),
  ...['README.md', 'AGENTS.md', 'deploy/queue/README.md'].map(file => path.join(root, file)),
].filter(file => fs.existsSync(file));
let links = 0;
const failures = [];
const linesIn = new Map();
for (const file of files) {
  const source = fs.readFileSync(file, 'utf8');
  const relative = path.relative(root, file);
  source.split('\n').forEach((line, index) => {
    if (/[\t ]+$/.test(line) && !/ {2}$/.test(line)) failures.push(`${relative}:${index + 1}: trailing whitespace`);
  });
  // Code examples can contain regex syntax resembling Markdown links.
  const text = source.replace(/^(```|~~~)[^\n]*\n[\s\S]*?^\1[^\n]*$/gm, '')
    .replace(/(?<!`)(`+)(?!`)[\s\S]*?(?<!`)\1(?!`)/g, '');
  for (const match of text.matchAll(/!?\[[^\]\n]*\]\((<[^>\n]+>|[^\s)]+)(?:\s+"[^"\n]*")?\)/g)) {
    const url = match[1].replace(/^<|>$/g, '');
    if (/^(?:[a-z][a-z0-9+.-]*:|#|\/\/)/i.test(url)) continue;
    links++;
    const [pathname, fragment] = url.split('#');
    let target;
    try {
      target = path.resolve(path.dirname(file), decodeURIComponent(pathname.split('?')[0]));
    } catch {
      failures.push(`${relative}: invalid URL ${url}`);
      continue;
    }
    if (!fs.existsSync(target)) failures.push(`${relative}: missing ${url}`);
    else if (/^L\d+$/.test(fragment ?? '') && fs.statSync(target).isFile()) {
      if (!linesIn.has(target)) linesIn.set(target, fs.readFileSync(target, 'utf8').split('\n').length);
      if (Number(fragment.slice(1)) > linesIn.get(target)) failures.push(`${relative}: source line outside file ${url}`);
    }
  }
}
if (failures.length) {
  process.stderr.write(failures.join('\n') + '\n');
  process.exitCode = 1;
} else console.log(`Docs verified: ${files.length} Markdown files, ${links} local inline links; named heading anchors and runtime URLs not checked`);
