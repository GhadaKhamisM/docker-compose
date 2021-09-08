<?php

namespace App\Models;

use App;

trait LocalizeTrait
{
    public function scopeLocalize($query)
    {
        return $query->where('locale', App::getLocale())->first();
    }
}
