<?php

namespace App\Http\Services;

use Hash;
use Illuminate\Database\DatabaseManager;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Repositories\PatientRepository;

class RegisterService
{
    private $database, $patientRepository;

    public function __construct(DatabaseManager $database, PatientRepository $patientRepository)
    {
        $this->database = $database;
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
