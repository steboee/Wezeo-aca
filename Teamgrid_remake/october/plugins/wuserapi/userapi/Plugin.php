<?php namespace WUserApi\UserApi;

use System\Classes\PluginBase;
use WUserApi\UserApi\Providers\AuthServiceProvider;
use WUserApi\UserApi\Providers\JWTAuthServiceProvider;
use WUserApi\UserApi\Classes\Extend\Hook\RainLabAuthExtend;

/**
 * UserApi Plugin Information File
 */
class Plugin extends PluginBase
{
    public $elevated = true;

    public $require = [
        'WApi.ApiException',
        'RainLab.User'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'UserApi',
            'description' => 'Implement auth API for RainLab.User plugin',
            'author' => 'Wezeo',
            'icon' => 'icon-key'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        RainLabAuthExtend::throwExceptionIfUserIsTrashed();
    }
}
