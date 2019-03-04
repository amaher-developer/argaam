<?php


foreach (File::allFiles(__DIR__ . '/Admin') as $route) {
    require_once $route->getPathname();
}

Route::get('onesignal/devices', 'Admin\OneSignalController@scanDevices');
