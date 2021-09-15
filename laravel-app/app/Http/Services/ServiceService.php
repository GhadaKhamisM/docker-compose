<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceTranslationRepository;
use App\Http\Filters\ServiceFilter;
use App\Models\Service;
use Lang;

class ServiceService
{
    private $serviceRepository, $serviceTranslationRepository;

    public function __construct(ServiceRepository $serviceRepository,
        ServiceTranslationRepository $serviceTranslationRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceTranslationRepository = $serviceTranslationRepository;
    }

    public function create(array $data){
        return $this->serviceRepository->create($data);
    }

    public function getAll(ServiceFilter $filter){
        return $this->serviceRepository->filterAll($filter);
    }

    public function update(Service $service,array $data){
        foreach ($data as $locale => $translation) {
            $this->serviceTranslationRepository->update($service->id,$locale,$translation);
        }
    }

    public function delete(Service $service){
        if($service->doctors->count()){
            abort(Response::HTTP_METHOD_NOT_ALLOWED, Lang::get('messages.services.errors.delete'));
        }
        $service->delete();
    }
}
