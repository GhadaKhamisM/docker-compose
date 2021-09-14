<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Http\Filters\Filterable;
use Hash;

class Doctor extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        'name_arabic', 'name_english', 'mobile', 'time_slot', 'password', 'photo', 'email',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function doctorWeekDays(){
        return $this->hasMany(DoctorWeekDay::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeRating()
    {
        return $this->reviews->avg('rating');
    }

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            // $model->services()->detach();
            // $model->doctorWeekDays()->delete();
        });
        static::deleted(function ($model) {
            $model->services()->detach();
            $model->doctorWeekDays()->delete();
        });
    }
}
