<?php

namespace ctibor\task\http\controllers;
use ctibor\task\models\Task;
use ctibor\task\http\resources\TaskResource;
use Backend\Classes\Controller;



class TasksController extends Controller
{
    public function create_task()
    {
        $task = new Task;
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
    
    public function get_task($id)
    {
        return new TaskResource(Task::find($id));
    }
    
    public function get_all_tasks()
    {   
        echo("okay");
        
    }
    
    public function update_task($id)
    {
        $task = Task::find($id);
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
    
    public function complete_task($id)
    {
        $task = Task::find($id);
        $task->completed = true;
        $task->save();
        return new TaskResource($task);
    }
    
    public function delete_task($id)
    {
        $task = Task::find($id);
        $task->delete();
        return new TaskResource($task);
    }

    public function get_project_tasks($id)
    {
        return TaskResource::collection(Task::where("project_id", $id)->get());
    }
    




}