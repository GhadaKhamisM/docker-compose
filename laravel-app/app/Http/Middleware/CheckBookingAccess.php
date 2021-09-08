<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use Lang;

class CheckBookingAccess
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
        $user = JWTAuth::parseToken()->authenticate();
        $guaed = config('auth.defaults.guard');
        if(isset($request->booking)){
            $accessCondition = $guaed == 'patient'? ($user->id == $request->booking->patient_id) : ($user->id == $request->booking->doctor_id);
            if(!$accessCondition) {
                abort(Response::HTTP_FORBIDDEN,Lang::get('messages.login.errors.authorization'));
            }
        }

        return $next($request);
    }
}
