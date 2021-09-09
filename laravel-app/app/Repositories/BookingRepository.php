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
        $data['patient_id'] = JWTAuth::parseToken()->authenticate()->id;
        $data['status_id'] = config('statuses.pending');
        $booking = $this->model->create($data);
        return $booking;
    }

    public function acceptBooking(int $bookingId){
        $this->findBy('id',$bookingId)->update(['status_id' => config('statuses.accepted')]);
    }

    public function cancelBooking(int $bookingId){
        $this->findBy('id',$bookingId)->update(['status_id' => config('statuses.canceled')]);
    }

    public function getPatientBooking(BookingFilter $filter, int $patientId){
        return $this->model->filter($filter)
            ->where('patient_id',$patientId)
            ->get();
    }

    public function getDoctorBooking(BookingFilter $filter, int $doctorId){
        return $this->model->filter($filter)
            ->where('doctor_id',$doctorId)
            ->get();
    }
}
