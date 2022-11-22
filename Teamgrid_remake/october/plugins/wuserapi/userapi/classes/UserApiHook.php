<?php namespace WUserApi\UserApi\Classes;

use Illuminate\Support\Facades\Event;

class UserApiHook
{
    public static function hook($hook, $data, $callback)
    {
        $hook = Event::fire(sprintf('wuserapi.userapi.%s', $hook), $data, true);
        if (!is_null($hook)) {
            return $hook;
        }

        return $callback();
    }
}
