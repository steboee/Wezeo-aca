<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\ValidationException;
use RainLab\User\Models\User;
use WUserApi\UserApi\Classes\UserApiHook;

class ResetApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $params = [
            'email' => input('email'),
            'code' => input('code'),
            'password' => input('password'),
            'password_confirmation' => input('password_confirmation') ?? input('password')
        ];

        $validation = Validator::make($params, [
            'email' => 'required|email',
            'code' => 'required',
            'password' => sprintf('required|between:%d,255|confirmed', User::getMinPasswordLength())
        ]);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $user = User::where('email', $params['email'])->first();

        if (!$user || !$user->attemptResetPassword($params['code'], $params['password'])) {
            throw new ApplicationException('User was not found in our database or reset password code is not valid', 403);
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
