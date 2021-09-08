<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BookingFilter extends QueryFilter
{
    use PaginationFilter;

    /**
     * @param string $visitDate
     */
    public function visit_date(string $visitDate)
    {
        $this->builder->whereDate('visit_date',$visitDate);
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
}