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
        $this->builder->whereRaw('name_arabic like ? OR name_english like ?', array('%'.$name.'%','%'.$name.'%'));
    }

    /**
     * @param string $description
     */
    public function description(string $description)
    {
        $this->builder->whereRaw('name like ?', array('%'.$description.'%'));
    }
}