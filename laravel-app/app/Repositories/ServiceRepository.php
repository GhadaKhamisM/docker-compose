<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Service::class);
    }

    public function create(Array $data){
        $service_translations = $data['service_translations'];
        unset($data['service_translations']);
        $service = $this->model->create($data);
        $service->serviceTranslations()->createMany($service_translations);
        return $service;
    }

    public function update(Service $service,Array $data){
        $service_translations = $data['service_translations'];
        //$this->findBy('id',$service->id)->update($data);
        $service->serviceTranslations()->delete();
        $service->serviceTranslations()->createMany($service_translations);
    }

    public function delete(int $id){
        $this->findBy('id',$id)->delete();
    }
}
