<?php namespace WUserApi\UserApi\Http\Controllers;

use October\Rain\Exception\ApplicationException;
use RainLab\User\Models\User;
use WUserApi\UserApi\Classes\UserApiHook;

class VerifyApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $params = [
            'email' => input('email'),
            'code' => input('code')
        ];

        $user =  User::where('email', $params['email'])->firstOrFail();

        if (!$user->attemptActivation($params['code'])) {
            throw new ApplicationException('Activation code is not valid');
        }

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
