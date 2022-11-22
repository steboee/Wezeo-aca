<?php namespace WUserApi\UserApi\Classes\Services;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class UserForgotPasswordService
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function sendResetCode()
    {
        $resetPasswordCode = $this->user->getResetPasswordCode();
        $isSent = Event::fire('wuserapi.userapi.sendResetPasswordCode', [$this->user, $resetPasswordCode], true);

        if(!$isSent) {
            $data = [
                'name' => $this->user->name,
                'username' => $this->user->username,
                'link' => url(vsprintf('/api/v1/auth/reset-password/?email=%s&code=%s', [
                    $this->user->email,
                    $resetPasswordCode
                ])),
                'code' => $resetPasswordCode
            ];

            Mail::send('rainlab.user::mail.restore', $data, function($message) {
                $message->to($this->user->email, $this->user->full_name);
            });
        }
    }
}
