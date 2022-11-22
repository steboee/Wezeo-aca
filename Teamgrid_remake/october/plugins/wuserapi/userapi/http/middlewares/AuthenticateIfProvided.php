<?php namespace WUserApi\UserApi\Http\Middlewares;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Closure;
use Tymon\JWTAuth\JWTAuth;

class AuthenticateIfProvided
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function checkForToken(Request $request, $next)
    {
        return $this->auth->parser()->setRequest($request)->hasToken();
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->checkForToken($request, $next)) {
            try {
                if (!$this->auth->parseToken()->authenticate()) {
                    throw new UnauthorizedHttpException('jwt-auth', 'User not found');
                }
            } catch (JWTException $e) {
                throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
            }
        }

        return $next($request);
    }
}
