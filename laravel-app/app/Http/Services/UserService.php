<?php

namespace App\Http\Services;

use Hash;
use App\Models\User;
use Illuminate\Database\DatabaseManager;

class UserService
{
    private $database;

    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Get user by email
     * 
     * @param $email
     * @return User
     */
    public function getUserByEmail(string $email){
        return User::where('email',trim($email))->first();
    }

     /**
     * Validate user password
     * 
     * @param $password
     * @param $user
     * @return boolean
     */
    public function validateCorrectPassword(string $password,User $user){
        return Hash::check($password,$user->password);
    }
}
