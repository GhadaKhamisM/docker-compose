<?php

namespace App\Http\Services;

use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
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
        return response()->json(['results' => array('token' => $token), 'messages' => 'Your account successfully'] , Response::HTTP_OK);
    }
}
