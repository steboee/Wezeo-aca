<?php

namespace Ctibor\Task\Http\Controllers;
use Ctibor\Task\Models\Task;
use Ctibor\Task\Http\Resources\TaskResource;
use Backend\Classes\Controller;
use Illuminate\Support\Facades\Auth;
use WuserApi\Userapi\Facades\JWTAuth;



class TasksController extends Controller
{



    

    // Create a new task
    // [POST] api/tasks
    //
    public function store(){
        $user = JWTAuth::parseToken()->authenticate();
        $task = new Task;
        $task->fill(request()->all());
        $task->user_id = $user->id;
        $task->save();
        return new TaskResource($task);
    }
    






    // Return task by id 
    // [GET] api/tasks/{id}
    //
    public function show($id){
        return new TaskResource(Task::find($id));
    }
    





    // Return all tasks for all projects
    // [GET] api/tasks/
    //
    public function index(){  
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
    // [PUT] /api/tasks/{id}
    //
    public function update($id)
    {
        // only user can update their task
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::findOrFail($id);

        if ($user->id != $task->user_id) {
            return \Response::make("You are not allowed to update this task", 403);
        }

        $task->fill(request()->all());

        $task->save();
        return new TaskResource($task);
    }



    // DELETE task
    // [DELETE] /api/tasks/{id}
    // 
    public function delete($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::findOrFail($id);
        if ($user->id!= $task->user_id) {
            return \Response::make("You are not allowed to delete this task", 403);
        }        
        $task = Task::find($id);
        $task->delete();
        return new TaskResource($task);
    }


}