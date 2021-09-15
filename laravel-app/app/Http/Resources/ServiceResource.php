<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App;

class ServiceResource extends JsonResource
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
            'name' => $this->translate(App::getlocale())->name?? null,
            'description' => $this->translate(App::getlocale())->description?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
    }
}
