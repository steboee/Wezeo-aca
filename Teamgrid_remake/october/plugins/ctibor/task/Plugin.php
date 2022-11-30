<?php namespace Ctibor\Task;

use Backend;
use System\Classes\PluginBase;
use Event;


/**
 * Task Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Task',
            'description' => 'No description provided yet...',
            'author'      => 'Ctibor',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {


    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Event::listen('getting_arrivals',function($timeTracker) {
            echo('getting_arrivals');
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Ctibor\Task\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'ctibor.task.some_permission' => [
                'tab' => 'Task',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'task' =>
            [
                'label'       => 'Task',
                'url'         => Backend::url('ctibor/task/tasks'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ctibor.task.*'],
                'order'       => 500,

            "sideMenu" => [
                "tasks" =>
                [
                    "label" => "Tasks",
                    "icon" => "icon-leaf",
                    "url" => Backend::url("ctibor/task/tasks"),
                    "permissions" => ["ctibor.task.*"],
                    "order" => 500,
                ],

                "time_trackers" =>
                [
                    "label" => "Time Trackers",
                    "icon" => "icon-leaf",
                    "url" => Backend::url("ctibor/task/timetrackers"),
                    "permissions" => ["ctibor.task.*"],
                    "order" => 500,
                ],

            ]
            ]
        ];
    }
}
