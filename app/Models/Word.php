<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['word'])]
class Word extends Model
{
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
