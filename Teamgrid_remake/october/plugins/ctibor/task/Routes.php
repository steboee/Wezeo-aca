<?php

use Backend\Classes\Controller;

use ctibor\task\http\controllers\TimeTrackerController;
use ctibor\task\Http\Controllers\TasksController;
use ctibor\task\Task;
use ctibor\Core\Config;



Route::middleware(["auth"])->group (function() {
  Route::post("api/create_task",[TasksController::class, "create_task"]);
  Route::get("api/tasks/{id}",[TasksController::class, "get_task"]);
  Route::get("api/project_tasks/{id}",[TasksController::class, "get_project_tasks"]);
  Route::get("api/tasks",[TasksController::class, "get_all_tasks"]);
  Route::put("api/tasks/{id}",[TasksController::class, "update_task"]);
  Route::put("api/tasks/{id}",[TasksController::class, "complete_task"]);
  Route::delete("api/tasks/{id}",[TasksController::class, "delete_task"]);
});


Route::post("api/start_tracking/{id}",[TimeTrackerController::class, "start_tracking"]);
Route::post("api/stop_tracking/{id}",[TimeTrackerController::class, "stop_tracking"]);
Route::get("api/tracking/{id}",[TimeTrackerController::class, "get_task_trackings"]);
Route::get("api/tracking",[TimeTrackerController::class, "get_all_trackings"]);
Route::put("api/tracking/{id}",[TimeTrackerController::class, "update_tracking"]);



