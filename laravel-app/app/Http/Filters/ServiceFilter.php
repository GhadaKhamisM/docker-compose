<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends QueryFilter
{
    use PaginationFilter;

    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $this->builder->whereHas('serviceTranslations', function($query) use ($name){
            $query->whereRaw('(name like ?)', array('%'.$name.'%'));
        });
    }

    /**
     * @param string $description
     */
    public function description(string $description)
    {
        $this->builder->whereHas('serviceTranslations', function($query) use ($description){
            $query->whereRaw('(description like ?)', array('%'.$description.'%'));
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
        $this->builder->join('service_translations','service_translations.service_id','services.id')->orderBy($field, $order);
    }
}