<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;

class Service extends Model
{
    use SoftDeletes;
    use Filterable;

    protected $fillable = [
        
    ];

    protected $hidden = [
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function serviceTranslations()
    { 
        return $this->hasMany(ServiceTranslation::class); 
    }

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->serviceTranslations()->delete();
        });
    }
}
