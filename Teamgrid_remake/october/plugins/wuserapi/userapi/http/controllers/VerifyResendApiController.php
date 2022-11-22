<?php namespace WUserApi\UserApi\Http\Controllers;

use October\Rain\Exception\ApplicationException;
use RainLab\User\Models\User;
use WUserApi\UserApi\Classes\Services\UserSignupActivationService;
use WUserApi\UserApi\Classes\UserApiHook;

class VerifyResendApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $params = [
            'email' => input('email')
        ];

        $user = User::where('email', $params['email'])->firstOrFail();

        if ($user->is_activated) {
            throw new ApplicationException('User already activated');
        }

        (new UserSignupActivationService($user))->sendActivationCode();

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
