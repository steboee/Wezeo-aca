<?php

use Backend\Classes\Controller;

use ctibor\task\http\controllers\TimeTrackerController;
use ctibor\task\Http\Controllers\TasksController;
use ctibor\task\Task;
use ctibor\Core\Config;
use WUserApi\UserApi\Http\Middlewares;

Route::prefix('api')->group(function () {
    // group routes by middleware
    Route::middleware('WUserApi\UserApi\Http\Middlewares\Authenticate')->group(function () {
        Route::post('tasks', [TasksController::class, 'store']);
        Route::get('tasks/{id}', [TasksController::class, 'show']);
        Route::get('tasks', [TasksController::class, 'index']);
        Route::put('tasks/{id}', [TasksController::class, 'update']);
        Route::delete('tasks/{id}', [TasksController::class, 'delete']);
        Route::post('tasks/{id}/start_tracking', [TimeTrackerController::class, 'start_tracking']);
        Route::post('tasks/{id}/stop_tracking', [TimeTrackerController::class, 'stop_tracking']);

        Route::get("time_trackings", [TimeTrackerController::class, 'index']);
        Route::get("time_trackings/{id}", [TimeTrackerController::class, 'show']);
        Route::post("time_trackings", [TimeTrackerController::class, 'store']);
        Route::put("time_trackings/{id}", [TimeTrackerController::class, 'update']);
        Route::delete("time_trackings/{id}", [TimeTrackerController::class, 'delete']);
    });
});








