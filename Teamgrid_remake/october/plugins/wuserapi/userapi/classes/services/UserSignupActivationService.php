<?php namespace WUserApi\UserApi\Classes\Services;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class UserSignupActivationService
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function sendActivationCode()
    {
        $activationCode = $this->user->activation_code ?? $this->user->getActivationCode();
        // this event allows us to hook at it and send custom email notification
        $isSent = Event::fire('wuserapi.userapi.sendActivationCode', [$this->user, $activationCode], true);

        // default email notification
        if (!$isSent) {
            $activationCode = implode('!', [$this->user->id, $activationCode]);

            $data = [
                'name' => $this->user->name,
                'link' => url(config('wuserapi.userapi::cms_default_pages.signup_activation_page'), [
                    'code' => $activationCode
                ]),
                'code' => $activationCode
            ];

            Mail::send('rainlab.user::mail.activate', $data, function ($message) {
                $message->to($this->user->email, $this->user->name);
            });
        }
    }
}
