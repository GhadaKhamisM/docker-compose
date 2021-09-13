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
    use ValidateBooking;

    private $bookingRepository, $doctorRepository;

    public function __construct(BookingRepository $bookingRepository,
        DoctorRepository $doctorRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->doctorRepository = $doctorRepository;
    }

    public function create(array $data){
        $doctor = $this->doctorRepository->findBy('id',$data['doctor_id'])->load('doctorWeekDays.bookings');
        $doctorWorkingDay = $doctor->doctorWeekDays()->where('id',$data['doctor_week_day_id'])->first();
        $canBooking = $this->canBooking($doctor,$doctorWorkingDay,$data['visit_date']);

        if($canBooking){
            $lastBooking = $doctorWorkingDay->bookings()->whereDate('visit_date',$data['visit_date'])->orderBy('id','desc')->first();            
            $startHour = $lastBooking? $lastBooking->to_hour : $doctorWorkingDay->start_hour;
            $toHour = Carbon::parse($data['visit_date'] .' '. $startHour)->addMinutes($doctor->time_slot);
            $data = array_merge($data,array('start_hour' => $startHour,
                    'to_hour' => $toHour->format('H:i'), 'time_slot' => $doctor->time_slot)); 

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
}
