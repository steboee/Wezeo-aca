<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use RainLab\User\Facades\Auth;
use RainLab\User\Models\Settings as UserSettings;
use WUserApi\UserApi\Classes\Services\UserSignupActivationService;
use WUserApi\UserApi\Classes\UserApiHook;
use WUserApi\UserApi\Facades\JWTAuth;
use Exception;
use WUserApi\UserApi\Models\User;

class SignupApiController extends UserApiController
{
    public function handle()
    {
        $data = post();

        if (!array_key_exists('password_confirmation', $data)) {
            $data['password_confirmation'] = post('password');
        }

        $user = $this->registerUser($data);

        $token = null;
        if ($user->is_activated) {
            $token = JWTAuth::fromUser($user);
        }

        Event::fire('wuserapi.userapi.beforeReturnUser', [$user]);

        $userResourceClass = config('wuserapi.userapi::resources.user');
        $response = [
            'token' => $token,
            'user' => new $userResourceClass($user),
        ];

        return $afterProcess = UserApiHook::hook('afterProcess', [$this, $response], function () use ($response) {
            return response()->make([
                'response' => $response,
                'status' => 201
            ], 201);
        });
    }

    protected function registerUser($data)
    {
        Event::fire('rainlab.user.beforeRegister', [&$data]);

        $automaticActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_AUTO;
        $userActivation = UserSettings::get('activate_mode') == UserSettings::ACTIVATE_USER;

        try {
            $user = Auth::register($data, $automaticActivation);
        } catch (Exception $e) {
            $user = User::where('email',$data['email'])->where('is_activated', false)->first();

            if ($userActivation && $user) {
                (new UserSignupActivationService($user))->sendActivationCode();
                return response([
                    'response' => 'Email with account activation code was sent',
                    'status' =>  200
                ], 200);
            }

            throw $e;
        }

        Event::fire('rainlab.user.register', [$user, $data]);

        if ($userActivation && !$user->is_activated) {
            (new UserSignupActivationService($user))->sendActivationCode();
        }

        return $user;
    }

    protected function loginAttribute()
    {
        return UserSettings::get('login_attribute', UserSettings::LOGIN_EMAIL);
    }
}
