<?php


use Backend\Classes\Controller;
use ctibor\project\models\Project;
use ctibor\project\http\controllers\ProjectsController;

Route::post("api/create-project",[ProjectsController::class, "create_project"]);
Route::get("api/projects{$id}",[ProjectsController::class, "get_project"]);
Route::get("api/projects",[ProjectsController::class, "get_all_projects"]);
Route::put("api/projects{$id}",[ProjectsController::class, "update_project"]);
Route::post("api/projects{$id}",[ProjectsController::class, "complete_project"]);
Route::delete("api/projects{$id}",[ProjectsController::class, "delete_project"]);
