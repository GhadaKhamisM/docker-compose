<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\PatientRegisterRequest;
use App\Http\Services\RegisterService;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function patientRegistration(PatientRegisterRequest $request){
        return $this->registerService->patientRegistration($request->validated());
    }
}
