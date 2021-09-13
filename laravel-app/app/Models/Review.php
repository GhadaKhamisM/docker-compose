<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;

class Review extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        'patient_id', 'doctor_id', 'rating', 'date', 'review',
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

    protected static function boot()
    {
        parent::boot();
    }
}
