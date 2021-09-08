<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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
        return $this->loginService->adminLogin($request->validated());
    }

    public function patientLogin(PatientLoginRequest $request){
        return $this->loginService->patientLogin($request->validated());
    }

    public function doctorLogin(DoctorLoginRequest $request){
        return $this->loginService->doctorLogin($request->validated());
    }
}
