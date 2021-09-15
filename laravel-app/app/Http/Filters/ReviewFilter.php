<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ReviewFilter extends QueryFilter
{
    /**
     * @param string $rating
     */
    public function rating(string $rating)
    {
        $this->builder->where('rating',$rating);
    }

    /**
     * @param string $date
     */
    public function date(string $date)
    {
        $this->builder->whereDate('date',$date);
    }
    
    /**
     * @param string $doctorId
     */
    public function doctor_id(string $doctorId)
    {
        $this->builder->where('doctor_id',$doctorId);
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