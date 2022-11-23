<?php

use Backend\Classes\Controller;
use Ctibor\Project\Models\Project;
use Ctibor\Project\Http\Controllers\ProjectsController;
use WUserApi\UserApi\Http\Middlewares\Authenticate;

// middleware mi nebralo tak , tak som ho zatial dal len takto
Route::prefix('api')->group(function () {
    // group routes by middleware
    Route::middleware('WUserApi\UserApi\Http\Middlewares\Authenticate')->group(function () {
        Route::post('projects', [ProjectsController::class, 'store']);
        Route::get('projects/{id}', [ProjectsController::class, 'show']);
        Route::get('projects', [ProjectsController::class, 'index']);
        Route::put('projects/{id}', [ProjectsController::class, 'update']);
        Route::delete('projects/{id}', [ProjectsController::class, 'delete']);
        Route::get('projects/{id}/tasks', [ProjectsController::class, 'show_tasks']);
    });
});