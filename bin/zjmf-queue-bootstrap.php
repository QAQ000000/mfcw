<?php

namespace think;

$pidFile = getenv('ZJMF_QUEUE_PID_FILE');
if (is_string($pidFile) && $pidFile !== '') {
    $written = @file_put_contents($pidFile, getmypid() . PHP_EOL, LOCK_EX);
    if ($written === false) {
        fwrite(\STDERR, "Unable to write queue worker PID file\n");
        exit(1);
    }
}

$root = dirname(__DIR__) . '/';
define('APP_DEBUG', true);
define('CMF_ROOT', $root);
define('CMF_DATA', CMF_ROOT . 'data/');
define('WEB_ROOT', CMF_ROOT . 'public/');
define('APP_PATH', CMF_ROOT . 'app/');
define('RUNTIME_PATH', CMF_ROOT . 'data/runtime_cli/');

require CMF_ROOT . 'vendor/thinkphp/base.php';

Container::get('app', [APP_PATH])->initialize();
Console::init();
