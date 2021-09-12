<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DoctorService;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Requests\DoctorDaysRequest;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use App\Http\Filters\DoctorFilter;
use Illuminate\Http\Response;
use App\Jobs\SendEmailJob;
use Lang;

class DoctorController extends Controller
{
    private $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index(DoctorFilter $filter){
        $doctors = $this->doctorService->getAll($filter);
        return DoctorResource::collection($doctors);
    }

    public function show(Doctor $doctor){
        return new DoctorResource($doctor);
    }

    public function store(StoreDoctorRequest $request){
        $doctor = $this->doctorService->create($request->validated());
        dispatch(new SendEmailJob($doctor,$request->password));
        return response()->json(['message' => Lang::get('messages.doctors.success.created')] , Response::HTTP_CREATED);
    }

    public function update(UpdateDoctorRequest $request,Doctor $doctor){
        $doctor = $this->doctorService->update( $doctor,$request->validated());
        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor){
        $this->doctorService->delete($doctor);
        return response()->json(['messages' => Lang::get('messages.doctors.success.delete')] , Response::HTTP_OK);
    }

    public function getDoctorAvailableDates(DoctorDaysRequest $request,Doctor $doctor){
        return $this->doctorService->getDoctorAvailableDates($doctor, $request->validated());
    }
}
