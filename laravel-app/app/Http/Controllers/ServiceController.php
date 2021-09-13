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
use Lang;

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
        return response()->json(['message' => Lang::get('messages.services.success.created')] , Response::HTTP_CREATED);
    }

    public function update(UpdateServiceRequest $request,Service $service){
        $this->serviceService->update( $service,$request->validated());
        return response()->json(['message' => Lang::get('messages.services.success.updated')] , Response::HTTP_OK);
    }

    public function destroy(Service $service){
        $this->serviceService->delete($service);
        return response()->json(['message' => Lang::get('messages.services.success.delete')] , Response::HTTP_OK);
    }
}
