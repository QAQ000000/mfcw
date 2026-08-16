<?php

$root = dirname(__DIR__, 2);
$routeFile = $root . '/data/route/openapi.php';
$outputFile = $root . '/docs/api/openapi-routes.md';
$source = file($routeFile, FILE_IGNORE_NEW_LINES);

if ($source === false) {
    fwrite(STDERR, "Unable to read {$routeFile}\n");
    exit(1);
}

$routes = [];
$group = null;
foreach ($source as $lineNumber => $line) {
    if (preg_match(
        "~Route::group\\(\\s*([\"'])(.*?)\\1\\s*,\\s*function\\s*\\(~i",
        $line,
        $match
    )) {
        if ($group !== null) {
            fwrite(STDERR, "Nested route groups are not supported at line " . ($lineNumber + 1) . "\n");
            exit(1);
        }
        $group = [
            'prefix' => $match[2],
            'routes' => [],
            'line' => $lineNumber + 1,
        ];
        continue;
    }

    $method = null;
    $path = null;
    $handler = null;
    if (preg_match(
        "~Route::(get|post|put|delete|patch|any)\\(\\s*([\"'])(.*?)\\2\\s*,\\s*([\"'])(.*?)\\4~i",
        $line,
        $match
    )) {
        $method = strtoupper($match[1]);
        $path = $match[3];
        $handler = $match[5];
    } elseif (preg_match(
        "~Route::rule\\(\\s*([\"'])(.*?)\\1\\s*,\\s*([\"'])(.*?)\\3\\s*,\\s*([\"'])(.*?)\\5~i",
        $line,
        $match
    )) {
        $method = strtoupper($match[6]);
        $path = $match[2];
        $handler = $match[4];
    }

    if ($method !== null) {
        if ($group !== null) {
            $prefix = trim($group['prefix'], '/');
            $path = ($prefix === '' ? '' : $prefix . '/') . ltrim($path, '/');
        }
        $route = [
            'method' => $method,
            'path' => '/' . ltrim($path, '/'),
            'handler' => $handler,
            'middleware' => 'none',
            'line' => $lineNumber + 1,
        ];
        if ($group === null) {
            $routes[] = $route;
        } else {
            $group['routes'][] = $route;
        }
    }

    if ($group !== null && preg_match('/^\s*}\)\s*(?:->|;)/', $line)) {
        $middleware = 'none';
        if (preg_match(
            "~->middleware\\(\\s*([\"'])(.*?)\\1\\s*\\)~i",
            $line,
            $match
        )) {
            $middleware = $match[2];
        }
        foreach ($group['routes'] as $route) {
            $route['middleware'] = $middleware;
            $routes[] = $route;
        }
        $group = null;
    }
}

if ($group !== null) {
    fwrite(STDERR, "Unclosed route group starting at line {$group['line']}\n");
    exit(1);
}

$sections = [
    'none' => '独立路由',
    'UserCheck' => '公开或可选登录路由（UserCheck）',
    'Check' => '必须登录路由（Check）',
];
foreach ($routes as $route) {
    if (!isset($sections[$route['middleware']])) {
        $sections[$route['middleware']] = "中间件 {$route['middleware']}";
    }
}

$markdown = "# OpenAPI 路由索引\n\n";
$markdown .= "> 此文件由 `php docs/scripts/generate-openapi-route-reference.php` 从 ";
$markdown .= "`data/route/openapi.php` 生成，请勿手工修改。\n\n";
$markdown .= "方括号参数（如 `[:pid]`）为可选参数，冒号参数（如 `:id`）为必填动态参数。";
$markdown .= "请求字段和返回值应以当前控制器实现为准；控制器注释和 `/document` ";
$markdown .= "是可能滞后的历史快照。\n\n";

foreach ($sections as $middleware => $title) {
    $items = array_values(array_filter($routes, function ($route) use ($middleware) {
        return $route['middleware'] === $middleware;
    }));
    $markdown .= "## {$title}\n\n";
    $markdown .= "| 方法 | 路径 | 控制器 | 源码行 |\n";
    $markdown .= "| --- | --- | --- | ---: |\n";
    foreach ($items as $route) {
        $markdown .= sprintf(
            "| `%s` | `%s` | `%s` | %d |\n",
            $route['method'],
            $route['path'],
            $route['handler'],
            $route['line']
        );
    }
    $markdown .= "\n";
}
$markdown = rtrim($markdown) . "\n";

if (!is_dir(dirname($outputFile)) && !mkdir(dirname($outputFile), 0755, true)) {
    fwrite(STDERR, "Unable to create output directory\n");
    exit(1);
}
if (file_put_contents($outputFile, $markdown) === false) {
    fwrite(STDERR, "Unable to write {$outputFile}\n");
    exit(1);
}

fwrite(STDOUT, count($routes) . " routes written to {$outputFile}\n");
