<?php

require_once dirname(__DIR__) . '/app/common/logic/ClientActivityLog.php';

use app\common\logic\ClientActivityLog;

function assertActivityLogOrder($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }
}

assertActivityLogOrder(
    ClientActivityLog::buildPaginationOrder('id', 'DESC', 'create_time') === 'id DESC',
    'default system log ordering must not append create_time after the unique id'
);
assertActivityLogOrder(
    ClientActivityLog::buildPaginationOrder('`id`', 'asc', 'id') === '`id` asc',
    'quoted id ordering must not append a duplicate id'
);
assertActivityLogOrder(
    ClientActivityLog::buildPaginationOrder('activity_log.id', 'DESC', 'id') === 'activity_log.id DESC',
    'qualified id ordering must not append a duplicate id'
);
assertActivityLogOrder(
    ClientActivityLog::buildPaginationOrder('user', 'ASC', 'create_time') === 'user ASC,create_time DESC',
    'custom system log ordering must preserve the create_time tie-breaker'
);
assertActivityLogOrder(
    ClientActivityLog::buildPaginationOrder('create_time', 'ASC', 'id') === 'create_time ASC,id DESC',
    'custom host log ordering must preserve the id tie-breaker'
);

$expectedCalls = [
    'app/home/controller/RecordLogController.php' => 2,
    'app/openapi/controller/LogController.php' => 1,
    'app/openapi/controller/HostController.php' => 1,
];
foreach ($expectedCalls as $relativePath => $expectedCount) {
    $source = file_get_contents(dirname(__DIR__) . '/' . $relativePath);
    assertActivityLogOrder(
        substr_count($source, 'ClientActivityLog::buildPaginationOrder(') === $expectedCount,
        $relativePath . ' must use the optimized activity log ordering'
    );
}

$userController = file_get_contents(dirname(__DIR__) . '/app/home/controller/UserController.php');
assertActivityLogOrder(
    strpos($userController, '->page($page, $limit)->order($orderby, $sort)->select()') !== false,
    'the single-order user login log contract must remain unchanged'
);

echo "activity log order regression passed\n";
