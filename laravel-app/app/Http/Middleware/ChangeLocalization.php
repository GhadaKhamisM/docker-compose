<?php

namespace App\Http\Middleware;

use Closure;
use App;

class ChangeLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = $request->header('Accept-Language');
        App::setlocale($language?? 'en');
        return $next($request);
    }
}
