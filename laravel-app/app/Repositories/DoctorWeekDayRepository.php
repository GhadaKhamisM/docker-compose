<?php

namespace App\Repositories;

use App\Models\DoctorWeekDay;

class DoctorWeekDayRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(DoctorWeekDay::class);
    }

    public function getDoctorWeekDays($doctorId,$dayIndex){
        return $this->model
            ->where('doctor_id',$doctorId)
            ->whereHas('weekDay', function($query) use ($dayIndex){
                $query->where('day_index', $dayIndex);
            })->get();
    }
}
