<?php

namespace Ctibor\Task\Http\Services;

use Ctibor\Task\Models\TimeTracker;
use Ctibor\Task\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;




class TimeTrackerService
{

  public function start_tracking($id)
  {
    $user = JWTAuth::parseToken()->authenticate();

    $Task = Task::find($id);
    if (!$Task) {
      return \Response::make("Task not found", 404);
    }

    
    // find  tracking for user which has no end_time
    $tracking = TimeTracker::where('user_id', $user->id)
      ->where('start_time', '<=', Carbon::now())
      ->whereNuLL('end_time')
      ->first();


    if ($tracking) {
      stop_exact_tracking($tracking->id);
    }

    $time_tracker = new TimeTracker;
    $time_tracker->user_id = request("user_id");
    $time_tracker->Task_id = $id;
    $time_tracker->start_time = date("Y-m-d H:i:s");
    $time_tracker->end_time = null;
    $time_tracker->save();
    return new TimeTrackerResource($time_tracker);
  }

}