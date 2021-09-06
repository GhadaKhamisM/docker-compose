<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorService extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        'doctor_id', 'service_id',
    ];
}
