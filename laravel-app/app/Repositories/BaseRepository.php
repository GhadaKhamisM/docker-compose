<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\QueryFilter;

abstract class BaseRepository
{
    protected $model;

    public function __construct(String $model)
    {
        $this->model = new $model;
    }

    public function findBy(string $column, string $value){
        return $this->model->where($column,$value)->first();
    }

    public function getAll(QueryFilter $filter){
        return $this->model->filter($filter)->get();
    }
}