<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use WUserApi\UserApi\Facades\JWTAuth;
use WUserApi\UserApi\Classes\UserApiHook;

class InvalidateApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $user = JWTAuth::getUser();

        $token = JWTAuth::parseToken()->getToken();
        JWTAuth::invalidate($token);

        Event::fire('wuserapi.userapi.afterInvalidate', [$user]);

        $response = [
            'success' => true
        ];

        return $afterProcess = UserApiHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'response' => $response,
                'status' => 200
            ], 200);
        });
    }
}
