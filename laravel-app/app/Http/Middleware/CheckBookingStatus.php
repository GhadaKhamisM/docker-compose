<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Lang;

class CheckBookingStatus
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
        if(isset($request->booking) && $request->booking->status_id != config('statuses.pending')){
            abort(Response::HTTP_FORBIDDEN,Lang::get('messages.booking.errors.status'));
        }
        return $next($request);
    }
}
