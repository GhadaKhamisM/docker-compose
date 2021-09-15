<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    protected $fillable = [];

    protected $hidden = [];

    public $translatedAttributes = ['name', 'description'];

    public function statusTranslations()
    { 
        return $this->hasMany(StatusTranslation::class); 
    }
}
