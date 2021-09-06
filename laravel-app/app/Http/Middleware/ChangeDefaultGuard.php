<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class ChangeDefaultGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$gruard = 'admin')
    { 
        config()->set('auth.defaults.guard', $gruard );
        config()->set('auth.defaultspasswords',$gruard.'s');

        return $next($request);
    }
}
