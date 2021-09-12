<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\PatientRegisterRequest;
use App\Http\Services\RegisterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function patientRegistration(PatientRegisterRequest $request){
        $token =  $this->registerService->patientRegistration($request->validated());
        return response()->json(['token' => $token] , Response::HTTP_OK);
    }
}
