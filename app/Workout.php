<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Workout extends Model
{
     protected $fillable = ['name','workout_time'];


     public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');
    }

    public function terms()
    {
        return $this->hasMany('App\Term');
    }
    public function workouts()
    {
        return $this->hasMany(Plan::class);
    }
}
