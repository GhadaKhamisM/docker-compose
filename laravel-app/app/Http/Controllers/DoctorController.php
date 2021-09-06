<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DoctorService;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use App\Http\Filters\DoctorFilter;
use Illuminate\Http\Response;
use App\Http\Services\EmailService;
use App\Mail\NewDoctorNotification;

class DoctorController extends Controller
{
    private $doctorService,$emailService;

    public function __construct(DoctorService $doctorService, EmailService $emailService)
    {
        $this->doctorService = $doctorService;
        $this->emailService = $emailService;
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
        $this->emailService->sendEmail(new NewDoctorNotification($doctor,$request->password),$doctor->email);
        return new DoctorResource($doctor);
    }

    public function update(UpdateDoctorRequest $request,Doctor $doctor){
        $doctor = $this->doctorService->update( $doctor,$request->validated());
        return new DoctorResource($doctor);
    }

    public function destroy(Doctor $doctor){
        $this->doctorService->delete($doctor);
        return response()->json(['results' => null, 'messages' => 'Doctor deleted successfully'] , Response::HTTP_OK);
    }
}
