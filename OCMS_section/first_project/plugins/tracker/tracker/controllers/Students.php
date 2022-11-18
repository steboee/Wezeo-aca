<?php namespace Tracker\Tracker\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Students Back-end Controller
 */
class Students extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tracker.Tracker', 'tracker', 'students');
        
    }

    // add user time to table arrivals
    public function onAddArrival()
    {
        $student_id = post('student_id');
        $arrival_date = post('arrival_date');

        $arrival = new \Tracker\Tracker\Models\Arrival;
        $arrival->student_id = $student_id;
        $arrival->arrival_date = $arrival_date;
        $arrival->save();

        return $this->listRefresh();
    }


     


    // Add to arrival table after student "logged"
    public function formAfterCreate($model)
    {
        $student_id = $model->id;
        $arrival_date = $model->created_at;
        // if arrival date is after 8:00 set delayed to true
        $delayed = $arrival_date > '08:00:00' ? true : false;


        $arrival = new \Tracker\Tracker\Models\Arrival;
        $arrival->student_id = $student_id;
        $arrival->arrival_date = $arrival_date;
        $arrival->delayed = $delayed;
        $arrival->save();
    }
    
}
