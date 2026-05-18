<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['word_id','country_id','translation'])]
class Translation extends Model
{

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
