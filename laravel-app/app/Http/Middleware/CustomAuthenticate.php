<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Response;
use Lang;

class CustomAuthenticate extends BaseMiddleware
{
    public function __construct(JWTAuth $auth)
    {
        parent::__construct($auth);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.login.errors.token'));
        }
        try {
            if (! $this->auth->parseToken()->authenticate()) {
                abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.login.errors.user_not_found'));
            }
        } catch (JWTException $e) {
            abort(Response::HTTP_UNAUTHORIZED,$e->getMessage());
        }

        return $next($request);
    }
}
