<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termpattern extends Model
{
    protected $fillable = [ 'name','workout_id', 'trener_id', 'slots', 'note','hours','type'];


    public function workout()
    {
        return $this->belongsTo('App\Workout');
    }

    public function coach()
    {
        return $this->hasOne(User::class, 'id', 'trener_id');
    }
}
