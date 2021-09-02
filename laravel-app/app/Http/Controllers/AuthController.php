<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Services\UserService;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request){
        $user = $this->userService->getUserByEmail($request->email);
        if($user && $this->userService->validateCorrectPassword($request->password,$user)){
            $token = JWTAuth::fromUser($user);
            return response()->json(['results' => array('token' => $token), 'messages' => 'Token generated successfully'] , 200);
        }
        return response()->json(['results' => null, 'messages' => 'Wrong email or password'] ,401);
    }


    public function registration(){

    }

}
