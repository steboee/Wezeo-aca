<?php namespace WUserApi\UserApi\Http\Controllers\Ui;

use WUserApi\UserApi\Http\Controllers\ResetApiController;
use WUserApi\UserApi\Http\Controllers\UserApiController;

class UiResetPasswordPostController extends UserApiController
{
	public function handle()
	{
		$resetApiController = new ResetApiController;
		$reset = true;
		$error = null;

		$params = [
			'email' => input('email'),
			'code' => input('code')
		];

		try {
			$resetApiController->handle();
		} catch (\Throwable $th) {
			$reset = false;
			$error = $th->getMessage();
		}

		return view(config('wuserapi.userapi::ui_reset_password.reset_password_view'), [
			'reset'	=> $reset,
			'params' => $params,
			'error'	=> $error
		]);
    }
}
