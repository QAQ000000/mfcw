<?php

think\facade\Route::pattern(["name" => "\\w+", "id" => "\\d+", "page" => "\\d+", "size" => "\\d+", "limit" => "\\d+"]);
$domain = config("database.admin_application") ?? "admin";
think\facade\Route::group("api", function () {
    think\facade\Route::post("api/host_server", "api/host/getDcimServerSetting");
    think\facade\Route::post("api/host", "api/host/editDcimHost");
    think\facade\Route::post("api/host/free", "api/host/freeDcimHost");
})->middleware("ApiCheck");
think\facade\Route::post("api/host/sync", "api/host/syncInfo");
think\facade\Route::post("api/ticket_reply/sync", "api/host/syncTicketReply");
think\facade\Route::rule("api/exec_module_func", "api/host/execProvision", "GET|POST");
think\facade\Route::get("api/install/version", "api/install/sysVersion");
think\facade\Route::get("api/install/envmonitor", "api/install/envMonitor");
think\facade\Route::post("api/install/dbmonitor", "api/install/dbMonitor");
think\facade\Route::post("api/install/codemonitor", "api/install/codeMonitor");
think\facade\Route::post("api/install/envsystem", "api/install/envSystem");
think\facade\Route::post("api/install/installing", "api/install/install");
think\facade\Route::post("api/install/setdbconfig", "api/install/setDbConfig");
think\facade\Route::post("api/install/setsite", "api/install/setSite");
think\facade\Route::post("api/install/installapphooks", "api/install/installAppHooks");
think\facade\Route::post("api/install/installappuseractions", "api/install/installAppUserActions");
think\facade\Route::post("api/install/steplast", "api/install/stepLast");
think\facade\Route::group($domain . "/upgrade", function () {
    think\facade\Route::get("version", "api/upgradeSystem/sysVersion");
    think\facade\Route::post("autoupdate", "api/upgradeSystem/getAutoUpdate");
    think\facade\Route::get("checkautoupdate", "api/upgradeSystem/getCheckAutoUpdate");
    think\facade\Route::post("checkupdateunzip", "api/upgradeSystem/getCheckUpdateUnzip");
    think\facade\Route::post("checkupdatecopy", "api/upgradeSystem/getCheckUpdateCopy");
})->middleware("AdminCheck");
think\facade\Route::get("api/oauth/logined", "api/oauth/logined");
think\facade\Route::post("api/oauth/accountGetAccessTokenDirect", "api/oauth/accountGetAccessTokenDirect");
think\facade\Route::post("api/oauth/accountGetAccessToken", "api/oauth/accountGetAccessToken");
think\facade\Route::post("api/oauth/automaticGetAccessToken", "api/oauth/automaticGetAccessToken");
think\facade\Route::get("api/oauth/getUserInfo", "api/oauth/getUserInfo");
think\facade\Route::post("api/botMessage", "api/Bot/botMessage");
    think\facade\Route::get("api/product/proinfo", "api/product/proInfo")->middleware("Check");
    think\facade\Route::get("api/product/prodetail", "api/product/proDetail")->middleware("Check");
think\facade\Route::get("api/product/list", "api/product/proList");
think\facade\Route::get("api/product/upgrade_product", "api/product/getUpgradeProduct")->middleware("Check");
think\facade\Route::get("api/product/:id", "api/product/detail")->middleware("Check");
think\facade\Route::get("api/product/:id/resource", "api/product/downloadResource");
think\facade\Route::get("api/flow_packet", "api/flowPacket/flowPacketList");
think\facade\Route::get("api/flow_packet/:id", "api/flowPacket/flowPacketIndex");

?>
