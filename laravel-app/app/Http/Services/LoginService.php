<?php

namespace App\Http\Services;

use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Repositories\PatientRepository;
use App\Repositories\AdminRepository;
use App\Repositories\DoctorRepository;
use Lang;

class LoginService
{
    private $patientRepository, $adminRepository, $doctorRepository;

    public function __construct(PatientRepository $patientRepository,
        AdminRepository $adminRepository, DoctorRepository $doctorRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->doctorRepository = $doctorRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * Validate password
     * 
     * @param $loginPassword
     * @param $password
     * @return boolean
     */
    public function validateCorrectPassword(string $loginPassword,string $password){
        return Hash::check($loginPassword,$password);
    }

    /**
     * login as admin
     * 
     * @param $requestData
     * @return token
     */
    public function adminLogin(array $requestData){
        $admin = $this->adminRepository->findBy('username',$requestData['username']);
        if($admin && $this->validateCorrectPassword($requestData['password'],$admin->password)){
            $token = JWTAuth::fromUser($admin);
            return response()->json(['token' => $token] , Response::HTTP_OK);
        }
        abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.login.errors.wrong_data'));
    }

    /**
     * login as patient
     * 
     * @param $requestData
     * @return token
     */
    public function patientLogin(array $requestData){
        $patient = $this->patientRepository->findBy('mobile',$requestData['mobile']);
        if($patient && $this->validateCorrectPassword($requestData['password'],$patient->password)){
            $token = JWTAuth::fromUser($patient);
            return response()->json(['token' => $token] , Response::HTTP_OK);
        }
        abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.login.errors.wrong_data'));
    }

    /**
     * login as doctor
     * 
     * @param $requestData
     * @return token
     */
    public function doctorLogin(array $requestData){
        $doctor = $this->doctorRepository->findBy('mobile',$requestData['mobile']);
        if($doctor && $this->validateCorrectPassword($requestData['password'],$doctor->password)){
            $token = JWTAuth::fromUser($doctor);
            return response()->json(['token' => $token] , Response::HTTP_OK);
        }
        abort(Response::HTTP_UNAUTHORIZED,Lang::get('messages.login.errors.wrong_data'));
    }
}
