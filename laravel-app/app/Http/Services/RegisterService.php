<?php

namespace App\Http\Services;

use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\PatientRepository;

class RegisterService
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * Patient registeration
     * 
     * @param $patientData
     * @return token
     */
    public function patientRegistration(array $patientData){
        $patient = $this->patientRepository->create($patientData);
        $token = JWTAuth::fromUser($patient);
        return $token;
    }
}
