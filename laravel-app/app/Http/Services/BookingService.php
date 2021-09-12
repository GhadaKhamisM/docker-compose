<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\BookingRepository;
use App\Repositories\DoctorRepository;
use App\Http\Filters\BookingFilter;
use App\Models\Booking;
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
        return $this->bookingRepository->getAll($filter);
    }

    public function accept(Booking $booking){
        $this->bookingRepository->accept($booking->id);
    }

    public function cancel(Booking $booking){
        $this->bookingRepository->cancel($booking->id);
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
