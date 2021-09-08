<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusTranslation extends Model
{
    use SoftDeletes;
    use LocalizeTrait;

    protected $fillable = [
        'name', 'status_id', 'locale',
    ];

    protected $hidden = [
    ];
}
