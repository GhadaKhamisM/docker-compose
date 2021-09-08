<?php

namespace App\Repositories;

use App\Models\WeekDay;

class WeekDayRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(WeekDay::class);
    }
}
