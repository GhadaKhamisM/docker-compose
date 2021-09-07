<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Admin::class);
    }
}