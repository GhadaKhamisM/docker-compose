<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomDoctorResource extends JsonResource
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
            'name_arabic' => $this->name_arabic,
            'name_english' => $this->name_english,
            'mobile' => $this->mobile,
            'time_slot' => $this->time_slot,
            'photo' => $this->photo,
            'email' => $this->email,
            'rating' => $this->rating(),
        );
    }
}
