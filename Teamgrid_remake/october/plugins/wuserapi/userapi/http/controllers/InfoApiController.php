<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use WUserApi\UserApi\Classes\UserApiHook;
use WUserApi\UserApi\Facades\JWTAuth;

class InfoApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $user = JWTAuth::getUser();

        Event::fire('wuserapi.userapi.beforeReturnUser', [$user]);

        $userResourceClass = config('wuserapi.userapi::resources.user');
        $response = [
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
