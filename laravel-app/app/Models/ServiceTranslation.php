<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTranslation extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'service_id', 'locale',
    ];

    protected $hidden = [
    ];

    public function service(){
        return $this->belongsTo(Service::class); 
    }
}
