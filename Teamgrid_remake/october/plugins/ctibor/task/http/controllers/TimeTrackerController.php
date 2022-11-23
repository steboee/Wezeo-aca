<?php

namespace Ctibor\Task\Http\Controllers;

use Ctibor\Task\Models\TimeTracker;
use Ctibor\Task\http\resources\TimeTrackerResource;
use Backend\Classes\Controller;
use Ctibor\Task\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Ctibor\Task\Http\Services\TimeTrackerService;





class TimeTrackerController extends Controller
{

  public function start_tracking($id)
  {
    $tracking = TimeTrackerService::start_tracking($id);

    return new TimeTrackerResource($time_tracker);
    
  }







  public function stop_tracking($id)
  {

    $Task = Task::find($id);
    if (!$Task) {
      return \Response::make("Task not found", 404);
    }

    //if timetracker exist create new one
    
    //find time_tracker for user which has no end_time

    $time_tracker = TimeTracker::where('user_id', request("user_id"))
      ->whereNull('end_time')
      ->where('Task_id', $id)
      ->first();

    if (!$time_tracker) {
        return response()->json([
          'message' => 'This Task is not being tracked',
        ], 404);
    }
  
    $time_tracker->user_id = request("user_id");
      $time_tracker->Task_id = $id;
      $time_tracker->end_time = date("Y-m-d H:i:s");


      $start = Carbon::parse($time_tracker->start_time);
      $end = Carbon::parse($time_tracker->end_time);
      $diff_in_seconds = $start->diffInSeconds($end);

      $time_tracker->duration_seconds = $diff_in_seconds;
      $time_tracker->save();

      //Set the Task as not tracking
      $Task = Task::find($id);
      $Task->tracking = False;
      $Task->duration_seconds += $diff_in_seconds;
      $Task->save();

      return new TimeTrackerResource($time_tracker);


  } 

  public function get_all_trackings()
  {
    return TimeTrackerResource::collection(TimeTracker::all());
  }

  public function update_tracking($id)
  {
    $user = request("user_id");
    $Task_owner = TimeTracker::find($id)->Task->user_id;

    if ($user == $Task_owner) {
      $time_tracker = TimeTracker::find($id);
      $time_tracker->Task_id = request("Task_id");
      $time_tracker->user_id = request("user_id");
      $time_tracker->start_time = request("start_time");
      $time_tracker->end_time = request("end_time");
      $time_tracker->duration = request("duration");
      $time_tracker->save();
      return new TimeTrackerResource($time_tracker);
    } else {
      return response()->json([
        "message" => "You are not the owner of this Task"
      ], 403);
    }
  }

  public function get_Task_trackings($id)
  {
    return TimeTrackerResource::collection(TimeTracker::where("Task_id", $id)->get());
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

    //Set the Task as not tracking
    $Task = Task::find($time_tracker->Task_id);
    $Task->tracking = False;
    $Task->save();



}
}