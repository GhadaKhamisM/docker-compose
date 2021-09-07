<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Lang;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$gruard = null)
    {
        if($gruard && Auth::guard($gruard)->check()){
            return $next($request);
        }
        abort(Response::HTTP_FORBIDDEN,Lang::get('messages.login.errors.authorization'));
    }
}
