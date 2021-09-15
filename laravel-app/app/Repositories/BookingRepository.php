<?php

namespace App\Repositories;

use App\Models\Booking;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Filters\BookingFilter;

class BookingRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Booking::class);
    }

    public function create(Array $data){
        $data['status_id'] = config('statuses.pending');
        $booking = $this->model->create($data);
        return $booking;
    }

    public function accept(int $bookingId){
        $this->model->where('id',$bookingId)->update(['status_id' => config('statuses.accepted')]);
    }

    public function cancel(int $bookingId){
        $this->model->where('id',$bookingId)->update(['status_id' => config('statuses.canceled')]);
    }

    public function getOverlappingBooking($doctorId,$visitDate,$startHour,$toHour){
        return $this->model
            ->where('doctor_id',$doctorId)
            ->whereDate('visit_date', $visitDate)
            ->whereRaw('!(start_hour >= ? OR to_hour <= ?)',array($toHour,$startHour))
            ->get();
    }

    public function filterAll(BookingFilter $filter){
        return $this->model->filter($filter)
            ->with(['status' => function ($query){
                $query->withTranslation();
            },'doctor.reviews','patient','doctorWeekDay.weekDay'])->get();
    }
}
