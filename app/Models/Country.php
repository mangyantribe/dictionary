<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name','code','photo'])]
class Country extends Model
{
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
