<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends QueryFilter
{
    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $this->builder->whereTranslationLike('name','%'.$name.'%');
    }

    /**
     * @param string $description
     */
    public function description(string $description)
    {
        $this->builder->whereTranslationLike('description','%'.$description.'%');
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