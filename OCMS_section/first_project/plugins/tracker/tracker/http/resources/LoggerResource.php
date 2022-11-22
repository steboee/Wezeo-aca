<?php
namespace Ctibor\Tracker\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "name" => $this->name,
            'arrival_date' => $this->arrival_date,
            'student_id' => $this->student_id,
            'delayed' => $this->delayed,
        ];
    }
}