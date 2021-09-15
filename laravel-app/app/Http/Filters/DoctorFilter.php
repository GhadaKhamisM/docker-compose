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
     * @param string $weekDayId
     */
    public function week_day_id(string $weekDayId)
    {
        $this->builder->whereHas('doctorWeekDays', function($query) use ($weekDayId){
            $query->where('week_day_id', $weekDayId);
        });
    }

    /**
     * Sort the services by the given order and field.
     *
     * @param  array  $value
     */
    public function sort(string $value)
    {
        list($field,$order) = explode(',', $value);
        $this->builder->orderBy($field, $order);
    }

    /**
     * Paginate the services by the given limit and field.
     *
     * @param  array  $value
     */
    public function pagination(string $value)
    {
        list($pageSize,$pageNumber) = explode(',', $value);
        $this->builder->paginate($pageSize,['*'],'page',$pageNumber);
    }
}