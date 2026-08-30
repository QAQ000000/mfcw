<?php

function assertPublicViewQuery($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$viewBase = file_get_contents($root . '/app/home/controller/ViewBaseController.php');
$viewModel = file_get_contents($root . '/app/home/model/ViewModel.php');
$menu = file_get_contents($root . '/app/common/logic/Menu.php');

$clientGuard = strpos($viewBase, 'if ($uid > 0) {');
$clientQuery = strpos($viewBase, '$clients = \think\Db::name("clients")', $clientGuard);
assertPublicViewQuery(
    $clientGuard !== false && $clientQuery !== false && $clientQuery - $clientGuard < 160,
    'anonymous page initialization must not query clients for existence'
);
$statusGuard = strpos($viewBase, 'if ($uid) {', $clientQuery);
$statusQuery = strpos($viewBase, '$client_status = \think\Db::name("clients")', $statusGuard);
assertPublicViewQuery(
    $statusGuard !== false && $statusQuery !== false && $statusQuery - $statusGuard < 160,
    'anonymous page initialization must not query client status'
);
assertPublicViewQuery(
    strpos($viewModel, 'field("type,COUNT(*) AS unread_num")') !== false
        && strpos($viewModel, '->group("type")->select()->toArray()') !== false,
    'unread message counts must use one grouped query'
);
assertPublicViewQuery(
    preg_match('/if \(\$uid\) \{\s*\$unread_rows =/s', $viewModel) === 1,
    'anonymous page initialization must skip unread message queries'
);
assertPublicViewQuery(
    strpos($menu, '$is_open_credit_limit = $uid ?') !== false,
    'anonymous navigation must not query client credit status'
);

preg_match('/public function getDisplayNav\(\).*?(?=\s*public function getVerisonDisplayNav)/s', $menu, $displayNav);
preg_match('/public function getVerisonDisplayNav\(\).*?(?=\s*public function proGetNavId)/s', $menu, $versionNav);
assertPublicViewQuery(!empty($displayNav[0]), 'getDisplayNav must remain discoverable');
assertPublicViewQuery(!empty($versionNav[0]), 'getVerisonDisplayNav must remain discoverable');
assertPublicViewQuery(
    substr_count($displayNav[0], '->column("id")') === 1,
    'display navigation URL filters must use one batched lookup'
);
assertPublicViewQuery(
    substr_count($versionNav[0], '->column("id")') === 1,
    'edition navigation URL filters must use one batched lookup'
);

echo "public view query regression tests passed\n";
