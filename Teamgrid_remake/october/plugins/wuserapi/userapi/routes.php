<?php

Route::group([
    'prefix' => config('wuserapi.userapi::routes.prefix'),
    'middleware' => config('wuserapi.userapi::routes.middlewares', [])
], function () {
    $actions = config('wuserapi.userapi::routes.actions', []);
    foreach ($actions as $action) {
        $methods = $action['method'];
        if (!is_array($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            Route::{$method}($action['route'], $action['controller'])->middleware($action['middlewares']);
        }
    }
});
