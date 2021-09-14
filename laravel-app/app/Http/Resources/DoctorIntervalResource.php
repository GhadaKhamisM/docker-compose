<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorIntervalResource extends JsonResource
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
            'name_arabic' => $this->weekDay->name_arabic,
            'name_english' => $this->weekDay->name_english,
            'intervals' => IntervalResource::collection($this->intervals)
        );
    }
}
