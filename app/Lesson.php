<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
