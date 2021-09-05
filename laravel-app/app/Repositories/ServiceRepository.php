<?php

namespace App\Repositories;

use App\Models\Service;
use App\Http\Filters\ServiceFilter;

class ServiceRepository
{

    public function __construct()
    {
    }

    public function create(Array $data){
        return Service::create($data);
    }

    public function getAll(ServiceFilter $filter){
        return Service::filter($filter)->get();
    }

    public function update(int $id,Array $data){
        Service::where('id',$id)->update($data);
    }

    public function getService(string $filter, string $value)
    {
        return Service::where($filter,$value)->first();
    }

    public function delete(int $id){
        Service::where('id',$id)->delete();
    }
}
