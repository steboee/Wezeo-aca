<?php namespace WUserApi\UserApi\Http\Controllers\Ui;

use WUserApi\UserApi\Http\Controllers\UserApiController;

class UiResetPasswordController extends UserApiController
{
	public function handle()
	{
		$params = [
			'email' => input('email'),
			'code' => input('code')
		];

		return view(config('wuserapi.userapi::ui_reset_password.reset_password_view'), [
			'reset' => false,
			'params' => $params
		]);
    }
}
