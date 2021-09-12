<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\PatientLoginRequest;
use App\Http\Requests\DoctorLoginRequest;
use App\Http\Services\LoginService;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function adminLogin(AdminLoginRequest $request){
        $token = $this->loginService->adminLogin($request->validated());
        return response()->json(['token' => $token] , Response::HTTP_OK);
    }

    public function patientLogin(PatientLoginRequest $request){
        $token = $this->loginService->patientLogin($request->validated());
        return response()->json(['token' => $token] , Response::HTTP_OK);
    }

    public function doctorLogin(DoctorLoginRequest $request){
        $token = $this->loginService->doctorLogin($request->validated());
        return response()->json(['token' => $token] , Response::HTTP_OK);
    }
}
