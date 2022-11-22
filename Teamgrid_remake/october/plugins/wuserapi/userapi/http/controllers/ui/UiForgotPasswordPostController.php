<?php namespace WUserApi\UserApi\Http\Controllers\Ui;

use WUserApi\UserApi\Http\Controllers\ForgotApiController;
use WUserApi\UserApi\Http\Controllers\UserApiController;

class UiForgotPasswordPostController extends UserApiController
{
	public function handle()
	{
		$forgotApiController = new ForgotApiController;

		$response 	= $forgotApiController->handle();
		$message 	= json_decode($response->getContent())->response->message;

		return view(config('wuserapi.userapi::ui_reset_password.forgot_password_view'), [
			'email'		=> input('email'),
			'message' 	=> $message
		]);
    }
}
