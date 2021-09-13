<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Lang;

class CheckCanReview
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
        $doctor = $request->doctor;
        $patient = JWTAuth::parseToken()->authenticate();
        $acceptedPatietBookings = $patient->bookings()->where('doctor_id',$doctor->id)->accept()->get();
        
        if($acceptedPatietBookings->count() == 0){
            abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.reviews.errors.created'));
        }

        $reviews = $patient->reviews()->where('doctor_id',$doctor->id)->get();
        if($reviews->count() != 0){
            abort(Response::HTTP_BAD_REQUEST,Lang::get('messages.reviews.errors.exist'));
        }

        return $next($request);
    }
}
