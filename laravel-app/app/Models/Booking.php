<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;

class Booking extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        'patient_id', 'doctor_id', 'status_id', 'visit_date', 'doctor_week_day_id'
    ];

    protected $hidden = [
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    { 
        return $this->belongsTo(Patient::class);
    }

    public function status()
    { 
        return $this->belongsTo(Status::class);
    }

    public function doctorWeekDay(){
        return $this->belongsTo(DoctorWeekDay::class);
    }

    protected static function boot()
    {
        parent::boot();

    }
}
