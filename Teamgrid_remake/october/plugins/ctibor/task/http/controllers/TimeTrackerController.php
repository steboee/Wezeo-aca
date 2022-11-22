<?php

namespace ctibor\task\http\controllers;

use ctibor\task\models\TimeTracker;
use ctibor\task\http\resources\TimeTrackerResource;
use Backend\Classes\Controller;
use ctibor\task\models\Task;
use Carbon\Carbon;
use Illuminate\Http\Response;





class TimeTrackerController extends Controller
{

  public function start_tracking($id)
  {
    $user_id = request("user_id");

    $task = Task::find($id);
    if (!$task) {
      return \Response::make("Task not found", 404);
    }

    
    // find  tracking for user which has no end_time
    $tracking = TimeTracker::where('user_id', $user_id)
      ->where('start_time', '<=', Carbon::now())
      ->where('end_time', '==', Null)
      ->first();

    if ($tracking) {
      stop_exact_tracking($tracking->id);
    }

    $time_tracker = new TimeTracker;
    $time_tracker->user_id = request("user_id");
    $time_tracker->task_id = $id;
    $time_tracker->start_time = date("Y-m-d H:i:s");
    $time_tracker->end_time = null;
    $time_tracker->save();

    //Set the task as tracking
    $task = Task::find($id);
    $task->tracking = True;
    $task->save();

    return new TimeTrackerResource($time_tracker);
    
  }

  public function stop_tracking($id)
  {

    $task = Task::find($id);
    if (!$task) {
      return \Response::make("Task not found", 404);
    }

    //if timetracker exist create new one
    
    //find time_tracker for user which has no end_time

    $time_tracker = TimeTracker::where('user_id', request("user_id"))
      ->where('end_time', '=', NULL)
      ->where('task_id', $id)
      ->first();

    if ($time_tracker) {
      $time_tracker->user_id = request("user_id");
      $time_tracker->task_id = $id;
      $time_tracker->end_time = date("Y-m-d H:i:s");


      $start = Carbon::parse($time_tracker->start_time);
      $end = Carbon::parse($time_tracker->end_time);
      $diff_in_seconds = $start->diffInSeconds($end);

      $time_tracker->duration_seconds = $diff_in_seconds;
      $time_tracker->save();

      //Set the task as not tracking
      $task = Task::find($id);
      $task->tracking = False;
      $task->duration_seconds += $diff_in_seconds;
      $task->save();

      return new TimeTrackerResource($time_tracker);
    }
    
    else{

      $task = Task::find($id);
      if ($task) {
        return response()->json([
          'message' => 'This task is not being tracked',
        ], 404);
      }
      else {
        return response()->json([
          'message' => 'This task does not exist',
        ], 404);
      }
      
    }
  } 

  public function get_all_trackings()
  {
    return TimeTrackerResource::collection(TimeTracker::all());
  }

  public function update_tracking($id)
  {
    $user = request("user_id");
    $task_owner = TimeTracker::find($id)->task->user_id;

    if ($user == $task_owner) {
      $time_tracker = TimeTracker::find($id);
      $time_tracker->task_id = request("task_id");
      $time_tracker->user_id = request("user_id");
      $time_tracker->start_time = request("start_time");
      $time_tracker->end_time = request("end_time");
      $time_tracker->duration = request("duration");
      $time_tracker->save();
      return new TimeTrackerResource($time_tracker);
    } else {
      return response()->json([
        "message" => "You are not the owner of this task"
      ], 403);
    }
  }

  public function get_task_trackings($id)
  {
    return TimeTrackerResource::collection(TimeTracker::where("task_id", $id)->get());
  }





  public function stop_exact_tracking($id)
  {
    $time_tracker = TimeTracker::find($id);
    $time_tracker->end_time = date("Y-m-d H:i:s");
    $start = Carbon::parse($time_tracker->start_time);
    $end = Carbon::parse($time_tracker->end_time);
    $diff_in_seconds = $start->diffInSeconds($end);

    $time_tracker->duration_seconds = $diff_in_seconds;
    $time_tracker->save();

    //Set the task as not tracking
    $task = Task::find($time_tracker->task_id);
    $task->tracking = False;
    $task->save();



}
}