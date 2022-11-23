<?php

use Backend\Classes\Controller;

use Ctibor\Task\Http\Controllers\TimeTrackerController;
use Ctibor\Task\Http\Controllers\TasksController;
use Ctibor\Task\Task;
use Ctibor\Core\Config;
use WUserApi\UserApi\Http\Middlewares;

Route::prefix('api')->group(function () {
    // group routes by middleware
    Route::middleware('WUserApi\UserApi\Http\Middlewares\Authenticate')->group(function () {
        Route::post('Tasks', [TasksController::class, 'store']);
        Route::get('Tasks/{id}', [TasksController::class, 'show']);
        Route::get('Tasks', [TasksController::class, 'index']);
        Route::put('Tasks/{id}', [TasksController::class, 'update']);
        Route::delete('Tasks/{id}', [TasksController::class, 'delete']);
        Route::post('Tasks/{id}/start_tracking', [TimeTrackerController::class, 'start_tracking']);
        Route::post('Tasks/{id}/stop_tracking', [TimeTrackerController::class, 'stop_tracking']);

        Route::get("time_trackings", [TimeTrackerController::class, 'index']);
        Route::get("time_trackings/{id}", [TimeTrackerController::class, 'show']);
        Route::post("time_trackings", [TimeTrackerController::class, 'store']);
        Route::put("time_trackings/{id}", [TimeTrackerController::class, 'update']);
        Route::delete("time_trackings/{id}", [TimeTrackerController::class, 'delete']);
    });
});








