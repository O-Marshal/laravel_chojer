<?php

namespace Ckryo\Laravel\Auth\Middleware;

use Ckryo\Laravel\Auth\Auth;
use Ckryo\Laravel\Handler\ErrorCodeException;
use Closure;

class AuthenticateMiddleware
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param string $action
     * @return mixed
     * @throws ErrorCodeException
     */
    public function handle($request, Closure $next, $action = "json")
    {
        if (is_null($this->auth->user($action))) {
            throw new ErrorCodeException(200);
        }

        return $next($request);
    }
}
