<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Filters\Filterable;

class WeekDay extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_arabic', 'name_english',
    ];

    public function doctors(){
        return $this->belongsToMany(Doctor::class);
    }
}
