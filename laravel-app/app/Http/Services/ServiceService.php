<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\ServiceRepository;
use App\Http\Filters\ServiceFilter;
use App\Models\Service;

class ServiceService
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function create(array $data){
        return $this->serviceRepository->create($data);
    }

    public function getAll(ServiceFilter $filter){
        return $this->serviceRepository->getAll($filter);
    }

    public function update(Service $service,array $data){
        $this->serviceRepository->update($service->id,$data);
        return $this->serviceRepository->getService('id',$service->id);
    }

    public function delete(Service $service){
        $this->serviceRepository->delete($service->id);
    }
}
