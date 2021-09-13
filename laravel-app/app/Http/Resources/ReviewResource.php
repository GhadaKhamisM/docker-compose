<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'patient' => new PatientResource($this->patient),
            'rating' => $this->rating,
            'review' => $this->review,
            'date' => $this->date,
        );
    }
}
