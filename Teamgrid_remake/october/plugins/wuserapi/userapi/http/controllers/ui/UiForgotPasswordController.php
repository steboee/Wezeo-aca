<?php namespace WUserApi\UserApi\Http\Controllers\Ui;

use WUserApi\UserApi\Http\Controllers\UserApiController;

class UiForgotPasswordController extends UserApiController
{
	public function handle()
	{
		return view(config('wuserapi.userapi::ui_reset_password.forgot_password_view'));
    }
}
