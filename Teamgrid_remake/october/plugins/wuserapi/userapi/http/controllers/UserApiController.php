<?php namespace WUserApi\UserApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use WUserApi\UserApi\Classes\ApiError;
use WUserApi\UserApi\Classes\UserApiHook;

abstract class UserApiController extends Controller
{
    abstract public function handle();

    public function __construct()
    {
        Event::fire('wuserapi.userapi.controllerConstruct', [$this]);
    }

    public function __invoke(Request $request)
    {
        try {
            return UserApiHook::hook('beforeProcess', [$this], function () {
                return $this->handle();
            });
        } catch (\Exception $exception) {
            return UserApiHook::hook('beforeReturnException', [$this, $exception], function () use ($exception) {
                throw $exception;
            });
        }
    }
}
