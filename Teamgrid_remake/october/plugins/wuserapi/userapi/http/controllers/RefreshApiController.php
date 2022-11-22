<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Tymon\JWTAuth\Exceptions\JWTException;
use WUserApi\UserApi\Facades\JWTAuth;
use WUserApi\UserApi\Classes\UserApiHook;

class RefreshApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        if (!$newToken = JWTAuth::parseToken()->refresh()) {
            throw new JWTException();
        }

        $user = JWTAuth::setToken($newToken)->authenticate();

        Event::fire('wuserapi.userapi.beforeReturnUser', [$user]);

        $userResourceClass = config('wuserapi.userapi::resources.user');
        $response = [
            'success' => true,
            'token' => $newToken,
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
