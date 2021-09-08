<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\BookingRepository;
use App\Http\Filters\BookingFilter;
use App\Models\Booking;
use Tymon\JWTAuth\Facades\JWTAuth;
use Lang;

class BookingService
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function create(array $data){
        return $this->bookingRepository->create($data);
    }

    public function getAll(BookingFilter $filter){
        $user = JWTAuth::parseToken()->authenticate();
        $guaed = config('auth.defaults.guard');
        if($guaed == 'patient') {
            return $this->bookingRepository->getPatientBooking($filter,$user->id);
        }
        return $this->bookingRepository->getDoctorBooking($filter, $user->id);
    }

    public function acceptBooking(Booking $booking){
        $this->bookingRepository->acceptBooking($booking->id);
        return response()->json(['messages' => Lang::get('messages.booking.success.accept')] , Response::HTTP_OK);
    }

    public function cancelBooking(Booking $booking){
        $this->bookingRepository->cancelBooking($booking->id);
        return response()->json(['messages' => Lang::get('messages.booking.success.cancel')] , Response::HTTP_OK);
    }
}
