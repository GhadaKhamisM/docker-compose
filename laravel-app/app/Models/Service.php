<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;

class Service extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;
    use Filterable;

    protected $fillable = [];

    protected $hidden = [];

    public $translatedAttributes = ['name', 'description'];

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
