<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use October\Rain\Exception\ValidationException;
use System\Models\File;
use WUserApi\UserApi\Classes\UserApiHook;
use WUserApi\UserApi\Facades\JWTAuth;

class InfoUpdateApiController extends UserApiController
{
    public function handle()
    {
        $response = [];

        $data = post();
        $user = JWTAuth::getUser();

        if (array_key_exists('password', $data) && !$user->checkHashValue('password', array_get($data, 'password_current'))) {
            throw new ValidationException(['password_current' => Lang::get('rainlab.user::lang.account.invalid_current_pass')]);
        }

        $user->fill($data);

        if (array_has($data, 'avatar') && empty($data['avatar']) && $user->avatar) {
            $user->avatar->delete();
            $user->avatar = null;
        }

        if (request()->hasFile('avatar')) {
            $file = new File();
            $file->fromPost(request()->file('avatar'));
            $file->save();

            $user->avatar = $file;
        }

        $user->save();

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
