<?php

namespace ctibor\task\http\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeTrackerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration_seconds' => $this->duration_seconds,
        ];
    }
}