<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{

    //protected $fillable = ['number', 'title', 'abstract', 'active', 'level_id'];
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
/*    public function getRouteKeyName()
    {
        return 'number';
    }*/

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
