<?php namespace Tracker\Tracker;

use Backend;
use System\Classes\PluginBase;

/**
 * tracker Plugin Information File
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
            'name'        => 'tracker',
            'description' => 'No description provided yet...',
            'author'      => 'tracker',
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
            'Tracker\Tracker\Components\MyComponent' => 'myComponent',
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
            'tracker.tracker.some_permission' => [
                'tab' => 'tracker',
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
            'tracker' => [
                'label'       => 'tracker',
                'url'         => Backend::url('tracker/tracker/students'),
                'icon'        => 'icon-leaf',
                'permissions' => ['tracker.tracker.*'],
                'order'       => 500,

                'sideMenu' => [
                    'students' => [
                        'label'       => 'Students',
                        'icon'        => 'icon-user',
                        'url'         => Backend::url('tracker/tracker/students'),
                        'permissions' => ['tracker.tracker.*'],
                        'order'       => 500,
                    ],
                    "arrivals" => [
                        'label'       => 'Arrivals',
                        'icon'        => 'icon-user',
                        'url'         => Backend::url('tracker/tracker/arrivals'),
                        'permissions' => ['tracker.tracker.*'],
                        'order'       => 500,
                    ],
                ],
            ],
        ];
    }
}
