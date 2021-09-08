<?php

namespace App\Repositories;

use App\Models\Booking;
use Tymon\JWTAuth\Facades\JWTAuth;

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
}
