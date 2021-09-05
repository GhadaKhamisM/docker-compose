<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{

    public function __construct()
    {
    }

    public function getAdmin(string $filter, string $value)
    {
        return Admin::where($filter,$value)->first();
    }
}