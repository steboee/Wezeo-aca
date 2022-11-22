<?php
namespace Ctibor\task\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'completed' => $this->completed,
            'due_date' => $this->due_date,
            'planned_start_date' => $this->planned_start_date,
            'planned_end_date' => $this->planned_end_date,
            'tracking' => $this->tracking,
        ];
    }
}