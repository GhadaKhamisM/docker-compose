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
        'name_arabic', 'name_english', 'description',
    ];

    protected $hidden = [
    ];
}
