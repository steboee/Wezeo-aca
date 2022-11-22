# User API

## Description
Implement auth API for RainLab.User plugin

## Installation
1. Copy files to `plugins/wuserapi/userapi` directory
    - Via git submodules
        ```bash
        git submodule add https://gitlab.com/wezeo/ocms-private-plugins/wuserapi/userapi.git plugins/wuserapi/userapi
        ```
    - Via git clone
        ```bash
        git clone https://gitlab.com/wezeo/ocms-private-plugins/wuserapi/userapi.git plugins/wuserapi/userapi
        ```
2. Install plugin dependencies
   ```
   WApi.ApiException
   RainLab.User
   ```
3. Update composer dependencies
    ```bash
    composer update tymon/jwt-auth --with-dependencies
    ```
4. Generate JWT secret key
    ```bash
    php artisan jwt:secret
    ```
5. Set env variables
6. Allow authorization header in your `.htaccess`
    ```apacheconfig
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    ```
7. Setup Insomnia collection from `Insomnia.json` file (contains all endpoints with data)

## ENV variables
- `JWT_SECRET`
    - Secret key will be used for Symmetric algorithms only (HMAC)
    - default: config('app.key')
- `JWT_TTL`
    - Time (in minutes) that the token will be valid for
    - default: 60 (1 hour)
- `JWT_REFRESH_TTL`
    - Time (in minutes) that the token can be refreshed
    - default: 20160 (2 weeks)

## Events
- Before process the controller action
    ```php
    Event::listen('wuserapi.userapi.beforeProcess', function ($controller) {

        if (!$controller instanceof SignupApiController) {
            return;
        }

        return response()->make([
            'success' => true
        ], 201);
    });
    ```
- After process the controller action
    ```php
    Event::listen('wuserapi.userapi.afterProcess', function ($controller, $data) {

        if (!$controller instanceof SignupApiController) {
            return;
        }

        return response()->make($data, 201);
    });
    ```
- Before return user in the response
    ```php
    Event::listen('wuserapi.userapi.beforeReturnUser', function ($user) {
        $user->additional = 'userapi';
    });
    ```
- Send activation code after user sign up
    ```php
        Event::listen('wuserapi.userapi.sendActivationCode', function ($user, $code) {
            return Mail::send(...);
        });
    ```
- Send reset password code after user sign up
    ```php
        Event::listen('wuserapi.userapi.sendResetPasswordCode', function ($user, $code) {
            return Mail::send(...);
        });
    ```
- Create statistics after user logged out
    ```php
        Event::listen('wuserapi.userapi.afterInvalidate', function ($user) {
            return Statistic::create(..);
        });
    ```

## Default forgot & password pageges
- You can reset your password without your own FE, with userapi default pages

    - 'api/v1/auth/forgot-password'
    - 'api/v1/auth/reset-password'