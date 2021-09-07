<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ServiceService;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use App\Http\Filters\ServiceFilter;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    private $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index(ServiceFilter $filter){
        $services = $this->serviceService->getAll($filter);
        return ServiceResource::collection($services);
    }

    public function show(Service $service){
        return new ServiceResource($service);
    }

    public function store(StoreServiceRequest $request){
        $service = $this->serviceService->create($request->validated());
        return new ServiceResource($service);
    }

    public function update(UpdateServiceRequest $request,Service $service){
        $service = $this->serviceService->update( $service,$request->validated());
        return new ServiceResource($service);
    }

    public function destroy(Service $service){
        return $this->serviceService->delete($service);
    }
}
