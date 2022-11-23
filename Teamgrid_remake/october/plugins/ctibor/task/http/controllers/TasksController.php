<?php

namespace ctibor\task\http\controllers;
use ctibor\task\models\Task;
use ctibor\task\http\resources\TaskResource;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Auth;
use WuserApi\Userapi\Facades\JWTAuth;



class TasksController extends Controller
{



    

    // Create a new task
    // [POST] api/create task
    //
    public function create_task(){
        $user = JWTAuth::parseToken()->authenticate();

        $task = new Task;
        $task->name = request("name");
        $task->description = request("description");
        $task->project_id = request("project_id");
        $task->user_id = $user->id;
        $task->completed = request("completed");
        $task->due_date = request("due_date");
        $task->planned_start_date = request("planned_start_date");
        $task->planned_end_date = request("planned_end_date");
        $task->tracking = request("tracking");
        $task->save();
        return new TaskResource($task);
    }
    






    // Return task by id 
    // [GET] api/tasks/{id}
    //
    public function get_task($id){
        return new TaskResource(Task::find($id));
    }
    





    // Return all tasks for all projects
    // [GET] api/tasks/
    //
    public function get_all_tasks(){  
        return TaskResource::collection(Task::all()); 
    }







    // Return tasks of logged user
    // [GET] /api/my-tasks
    //
    public function get_my_tasks()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $tasks = Task::where('user_id', $user->id)->get();

        return TaskResource::collection($tasks);
    }







    // Edit task , only owner can edit this task
    // [PUT] /api/my-tasks/{id}
    //
    public function update_task($id)
    {
        // only user can update their task
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::find($id);

        if ($user->id != $task->user_id) {
            return \Response::make("You are not allowed to update this task", 403);
        }

        $task->name = request("name");
        $task->description = request("description");
        $task->project_id = request("project_id");
        $task->user_id = request("user_id");
        $task->completed = request("completed");
        $task->due_date = request("due_date");
        $task->planned_start_date = request("planned_start_date");
        $task->planned_end_date = request("planned_end_date");
        $task->tracking = request("tracking");
        $task->save();
        return new TaskResource($task);
    }





    // Complete Task , Doesn't delete 
    // [PUT] /api/tasks/{id}/complete
    //
    public function complete_task($id)
    {
        $task = Task::find($id);
        $task->completed = true;
        $task->save();
        return new TaskResource($task);
    }
    



    // DELETE task, only owner can delete
    // [DELETE] /api/tasks/{id}
    // 
    public function delete_task($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::find($id);
        if ($user->id!= $task->user_id) {
            return \Response::make("You are not allowed to delete this task", 403);
        }        
        $task = Task::find($id);
        $task->delete();
        return new TaskResource($task);
    }




    // GET all tasks from project 
    // [GET] /api/project_tasks/{id}
    //
    public function get_project_tasks($id)
    {
        return TaskResource::collection(Task::where("project_id", $id)->get());
    }
    




}