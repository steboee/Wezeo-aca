<?php namespace Ctibor\Task\Models;

use Model;
use Ctibor\Project\Models\Project;

/**
 * task Model
 */
class Task extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ctibor_task_tasks';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];


    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

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
    public $hasMany = [
        'time_trackers' => 'Ctibor\Task\Models\TimeTracker'
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'project' => [Project::class, 'key' => 'project_id'],
        'user' => [User::class, 'key' => 'user_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    public function getProjectIdOptions()
    {
        // Projects which are not completed
        $projects = Project::where('completed', 0)->lists('name', 'id');
        return $projects;
    }

    public function scopeFilterMake($query, $parent){
        if ($parent->project) {
            $query = $query->where('id', $parent->project_id);
        }
        return $query;
        }
}
