<?php

namespace App\Repositories;

use App\Models\Service;
use App\Http\Filters\ServiceFilter;

class ServiceRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Service::class);
    }

    public function create(Array $data){
        $service = $this->model->create($data);
        return $service;
    }

    public function filterAll(ServiceFilter $filter){
        return $this->model->filter($filter)->withTranslation()->get();
    }
}
