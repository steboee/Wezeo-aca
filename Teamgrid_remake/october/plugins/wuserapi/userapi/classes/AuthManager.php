<?php namespace WUserApi\UserApi\Classes;

use \RainLab\User\Classes\AuthManager as AuthManagerBase;
use WUserApi\UserApi\Models\User;

class AuthManager extends AuthManagerBase
{
    protected $userModel = User::class;
}
