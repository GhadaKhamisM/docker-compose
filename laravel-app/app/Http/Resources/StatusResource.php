<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App;

class StatusResource extends JsonResource
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
            'name' => $this->translate(App::getlocale())->name,
        );
    }
}
