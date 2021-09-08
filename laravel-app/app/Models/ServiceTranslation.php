<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App;

class ServiceTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'service_id', 'locale',
    ];

    protected $hidden = [
    ];

    public function scopeLocalize($query)
   {
          return $query->where('locale', App::getLocale())->first();
   }
}
