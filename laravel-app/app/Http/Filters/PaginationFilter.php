<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

trait PaginationFilter
{
    /**
     * Paginate the services by the given limit and field.
     *
     * @param  array  $value
     */
    public function pagination(string $value)
    {
        list($pageSize,$pageNumber) = explode(',', $value);
        $count = count($this->builder->get());
        $skip  = ($pageNumber - 1) * $pageSize;
        $this->builder->skip($skip)->take($pageSize);
    }
}