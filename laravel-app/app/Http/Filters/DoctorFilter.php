<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class DoctorFilter extends QueryFilter
{
    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $this->builder->whereRaw('(name_arabic like ? OR name_english like ?)', array('%'.$name.'%','%'.$name.'%'));
    }

    /**
     * @param string $mobile
     */
    public function mobile(string $mobile)
    {
        $this->builder->whereRaw('mobile like ?', array('%'.$mobile.'%'));
    }

    /**
     * @param string $timeSlot
     */
    public function time_slot(string $timeSlot)
    {
        $this->builder->where('time_slot',$timeSlot);
    }
}