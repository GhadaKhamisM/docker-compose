<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'id' => $this->id,
            'status' =>  new StatusResource($this->status),
            'visit_date' => $this->visit_date,
            'doctor_week_day' => new DoctorWeekDayResource($this->doctorWeekDay),
            'doctor' => $this->when(config('auth.defaults.guard') == 'patient', new DoctorResource($this->doctor)),
            'patient' => $this->when(config('auth.defaults.guard') == 'doctor',new PatientResource($this->patient))
        );
    }
}
