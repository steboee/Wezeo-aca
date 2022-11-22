<?php namespace WUserApi\UserApi\Http\Controllers;

use October\Rain\Exception\ApplicationException;
use RainLab\User\Models\User;
use WUserApi\UserApi\Classes\Services\UserForgotPasswordService;
use WUserApi\UserApi\Classes\UserApiHook;

class ForgotApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $params = [
            'email' => input('email'),
        ];

        $user = User::where('email', $params['email'])->first();

        if ($user) {
            if (!$user->is_activated) {
                throw new ApplicationException('User not activated');
            }

            (new UserForgotPasswordService($user))->sendResetCode();
        }

        $response = [
            "success" => true,
            'message' => 'If your email address exists in our database, you will receive a password recovery link at your email address in few minutes.'
        ];

        return $afterProcess = UserApiHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'response' => $response,
                'status' => 200
            ], 200);
        });
    }
}
