<?php

namespace App\Http\Services;

use Hash;
use Illuminate\Database\DatabaseManager;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use App\Repositories\PatientRepository;
use App\Repositories\AdminRepository;

class LoginService
{
    private $database, $patientRepository, $adminRepository;

    public function __construct(DatabaseManager $database, PatientRepository $patientRepository,
        AdminRepository $adminRepository)
    {
        $this->database = $database;
        $this->patientRepository = $patientRepository;
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
        $admin = $this->adminRepository->getAdmin('username',$requestData['username']);
        if($admin && $this->validateCorrectPassword($requestData['password'],$admin->password)){
            $token = JWTAuth::fromUser($admin);
            return response()->json(['results' => array('token' => $token), 'messages' => 'Token generated successfully'] , Response::HTTP_OK);
        }
        abort(Response::HTTP_UNAUTHORIZED,'Wrong email or password');
    }

    /**
     * login as patient
     * 
     * @param $requestData
     * @return token
     */
    public function patientLogin(array $requestData){
        $patient = $this->patientRepository->getPatient('mobile',$requestData['mobile']);
        if($patient && $this->validateCorrectPassword($requestData['password'],$patient->password)){
            $token = JWTAuth::fromUser($patient);
            return response()->json(['results' => array('token' => $token), 'messages' => 'Token generated successfully'] , Response::HTTP_OK);
        }
        abort(Response::HTTP_UNAUTHORIZED,'Wrong email or password');
    }
}
