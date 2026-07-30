<?php
http_response_code(503);
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, max-age=0');
header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; base-uri 'none'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>数据库升级未完成</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            color: #24292f;
            background: #f6f8fa;
            font: 15px/1.6 -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        main {
            width: min(640px, 100%);
            padding: 32px;
            border: 1px solid #d0d7de;
            border-radius: 8px;
            background: #fff;
        }
        h1 { margin: 0 0 12px; font-size: 22px; }
        p { margin: 10px 0; }
        code {
            display: block;
            margin: 18px 0;
            padding: 14px 16px;
            overflow-wrap: anywhere;
            border: 1px solid #afb8c1;
            border-radius: 6px;
            color: #0a3069;
            background: #f6f8fa;
            font: 14px/1.5 ui-monospace, SFMono-Regular, Consolas, monospace;
        }
    </style>
</head>
<body>
<main>
    <h1>数据库升级未完成</h1>
    <p>请登录服务器，在站点根目录执行：</p>
    <code>php public/upgrade/upgrade.php --run</code>
    <p>命令成功结束后重新打开后台。此页面不会执行任何数据库或文件修改。</p>
</main>
</body>
</html>
