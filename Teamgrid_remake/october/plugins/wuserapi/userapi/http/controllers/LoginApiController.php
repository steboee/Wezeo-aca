<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use October\Rain\Auth\AuthException;
use RainLab\User\Facades\Auth;
use WUserApi\UserApi\Facades\JWTAuth;
use WUserApi\UserApi\Classes\UserApiHook;

class LoginApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $user = Event::fire('wuserapi.userapi.beforeLogin', [], true);

        if ($user) {
            Auth::loginUsingId($user->id);
        } else {
            $user = Auth::authenticate([
                'login' => input('login'),
                'password' => input('password')
            ], false);
        }

        if ($user->isBanned()) {
            throw new AuthException('rainlab.user::lang.account.banned');
        }

        $ipAddress = request()->ip();
        if ($ipAddress) {
            $user->touchIpAddress($ipAddress);
        }

        $token = JWTAuth::fromUser($user);

        Event::fire('wuserapi.userapi.beforeReturnUser', [$user]);

        $userResourceClass = config('wuserapi.userapi::resources.user');
        $response = [
            'token' => $token,
            'user' => new $userResourceClass($user),
        ];

        return $afterProcess = UserApiHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'response' => $response,
                'status' => 200
            ], 200);
        });
    }
}
