<?php 
namespace Ctibor\Task\Models;

use Model;
use Ctibor\Project\Models\Project;
use Rainlab\User\Models\User;
use Ctibor\Task\Models\Task;
use Carbon\Carbon;

/**
 * TimeTracker Model
 */
class TimeTracker extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ctibor_task_time_trackers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    


    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'task' => [Task::class, 'key' => 'task_id'],
        'user' => [User::class, 'key' => 'user_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];




    // update tracked_time in task after timetracker changed
    public function beforeUpdate(){
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $diff_in_seconds = $start->diffInSeconds($end);
        $this->duration_seconds = $diff_in_seconds;
    }



    // update TASK - duration seconds when timetracker changed 
    public function afterUpdate()
    {
        $task = $this->task;
        $task->duration_seconds = $task->time_trackers->sum('duration_seconds');
        $task->save();
    }



    // after timetracker was deleted change TASK->duration seconds
    public function afterDelete()
    {
        $task = $this->task;
        $task->duration_seconds = $task->time_trackers->sum('duration_seconds');
        $task->save();
    }


    public function getProjectOptions(){
        
        return Project::all()->lists('name', 'id');
    }


    // dropdown for backend form
    public function getTaskOptions()
    {   
        $tasks = Task::all();
        if ($this->_project){
            $project_id = $this->_project;
            $tasks = $tasks->where('project_id', $project_id);
            return $tasks->lists('name', 'id');
        }
        else{
            return $tasks->lists('name', 'id');
        }
        return [];   
    }

    


}
