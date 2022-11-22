<?php namespace WUserApi\UserApi\Classes\Extend\Hook;

use Auth;
use Event;
use October\Rain\Auth\AuthException;

class RainLabAuthExtend
{
    public static function throwExceptionIfUserIsTrashed()
    {
        Event::listen('rainlab.user.beforeAuthenticate', function($handler, $credentials) {
            
            $login = array_get($credentials, 'login');

            /*
             * No such user exists
             */
            if (!$user = Auth::findUserByLogin($login)) {
                return;
            }

            /*
             * Throw exception if user is trashed, otherwise he would be reactivated
             */
            if ( $user->trashed() ) {
                throw new AuthException(sprintf('Account %s has been deactivated, please contact support.',$login),401);
            }
        });
    }
}