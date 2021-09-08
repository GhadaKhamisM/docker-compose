<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorWeekDay extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id', 'week_day_id', 'start_hour', 'to_hour',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function weekDay()
    {
        return $this->belongsTo(WeekDay::class);
    }
}
