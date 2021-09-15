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
        $doctor = $this->doctorRepository->findBy('id',$data['doctor_id']);
        $doctorWeekDay = $this->doctorWeekDayRepository->findBy('id',$data['doctor_week_day_id']);

        $intervaltClosed = $this->checkIntervaltClosed($doctor,$doctorWeekDay,$data['visit_date']);
        if($intervaltClosed) {
            abort(Response::HTTP_BAD_REQUEST, Lang::get('messages.doctors.errors.booking'));
        }
        
        $overlapingBookings = $this->bookingRepository->getOverlappingBooking($doctor->id,$data['visit_date'],$data['start_hour'],$data['to_hour']);
        if($overlapingBookings->count()){
            abort(Response::HTTP_UNPROCESSABLE_ENTITY,Lang::get('messages.booking.errors.not_available'));    
        }

        $intervals = $this->getTimeIntervals($doctor,$doctorWeekDay,$data['visit_date']); 
        $selectedInterval = array_filter($intervals,function ($availableInterval) use ($data){ 
            return $availableInterval->start_hour == $data['start_hour']
            && $availableInterval->to_hour == $data['to_hour']; });

        if(empty($selectedInterval)){
            abort(Response::HTTP_UNPROCESSABLE_ENTITY,Lang::get('messages.booking.errors.not_available'));    
        }
        $data['time_slot'] = $doctor->time_slot; 
        return $this->bookingRepository->create($data);
    }

    public function getAll(BookingFilter $filter){
        return $this->bookingRepository->filterAll($filter);
    }

    public function accept(Booking $booking){
        $this->bookingRepository->accept($booking->id);
    }

    public function cancel(Booking $booking){
        $this->bookingRepository->cancel($booking->id);
    }
}
