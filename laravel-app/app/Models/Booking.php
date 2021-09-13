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
        'patient_id', 'doctor_id', 'status_id', 'visit_date', 'doctor_week_day_id',
        'start_hour', 'to_hour', 'time_slot',
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

    public function scopeAccept($query)
    {
        return $query->where('status_id', config('statuses.accepted'));
    }

    protected static function boot()
    {
        parent::boot();

    }
}
