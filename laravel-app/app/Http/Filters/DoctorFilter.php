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

    /**
     * Sort the services by the given order and field.
     *
     * @param  array  $value
     */
    public function sort(string $value)
    {
        [$field,$order] = explode(',', $value);
        $this->builder->orderBy($field, $order);
    }

    /**
     * Paginate the services by the given limit and field.
     *
     * @param  array  $value
     */
    public function pagination(string $value)
    {
        [$pageSize,$pageNumber] = explode(',', $value);
        $count = count($this->builder->get());
        $skip  = ($pageNumber - 1) * $pageSize;
        $this->builder->skip($skip)->take($pageSize);
    }
}