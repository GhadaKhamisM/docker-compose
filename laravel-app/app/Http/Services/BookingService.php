<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\BookingRepository;
use App\Repositories\DoctorRepository;
use App\Http\Filters\BookingFilter;
use App\Models\Booking;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Lang;

class BookingService
{
    private $bookingRepository, $doctorRepository;

    public function __construct(BookingRepository $bookingRepository,
        DoctorRepository $doctorRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->doctorRepository = $doctorRepository;
    }

    public function create(array $data){
        $bookingAvailable = $this->validateBookingAvailable($data);
        if($bookingAvailable){
            return $this->bookingRepository->create($data);
        }
        abort(Response::HTTP_UNPROCESSABLE_ENTITY,Lang::get('messages.booking.errors.not_available'));
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

    public function validateBookingAvailable($data){
        $doctor = $this->doctorRepository->findBy('id',$data['doctor_id']);
        $doctorBockingsCount = $doctor->bookings()->whereDate('visit_date',$data['visit_date'])
            ->where('doctor_week_day_id',$data['doctor_week_day_id'])->count();
        $doctorWorkingDay = $doctor->doctorWeekDays()->where('id',$data['doctor_week_day_id'])->first();
        $numberOfBookings = $this->getBookingsNumberAtWorkingDuration($doctor->time_slot,$doctorWorkingDay,$data['visit_date']);
        return $numberOfBookings > $doctorBockingsCount;
    }

    public function getBookingsNumberAtWorkingDuration($timeSlot,$doctorWorkingDay,$visitDate){
        $periodStartHour = Carbon::parse($visitDate .' '. $doctorWorkingDay->start_hour);
        $periodEndHour = Carbon::parse($visitDate .' '. $doctorWorkingDay->to_hour);
        $durationOfPeriod = $periodEndHour->diffInMinutes($periodStartHour);
        return $durationOfPeriod / $timeSlot;
    }
}
