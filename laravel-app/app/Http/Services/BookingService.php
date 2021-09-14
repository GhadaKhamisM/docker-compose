<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\BookingRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\DoctorWeekDayRepository;
use App\Http\Filters\BookingFilter;
use App\Models\Booking;
use Carbon\Carbon;
use Lang;

class BookingService
{
    use DayInterval;

    private $bookingRepository, $doctorRepository, $doctorWeekDayRepository;

    public function __construct(BookingRepository $bookingRepository,
        DoctorRepository $doctorRepository, DoctorWeekDayRepository $doctorWeekDayRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->doctorRepository = $doctorRepository;
        $this->doctorWeekDayRepository = $doctorWeekDayRepository;
    }

    public function create(array $data){
        $doctor = $this->doctorRepository->findBy('id',$data['doctor_id'])->load('doctorWeekDays.bookings');
        $doctorWeekDay = $this->doctorWeekDayRepository->findBy('id',$data['doctor_week_day_id']);
        $availableIntervals = $this->getAvailableTimesInInterval($doctor,$doctorWeekDay,$data['visit_date'])->toArray(); 
        $selectedInterval = array_filter($availableIntervals,function ($availableInterval) use ($data){ 
            return $availableInterval->is_available && $availableInterval->start_hour == $data['start_hour']
            && $availableInterval->to_hour == $data['to_hour']; });

        if(empty($selectedInterval)){
            abort(Response::HTTP_UNPROCESSABLE_ENTITY,Lang::get('messages.booking.errors.not_available'));    
        }
        $data['time_slot'] = $doctor->time_slot; 
        return $this->bookingRepository->create($data);
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
