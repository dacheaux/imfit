<?php

namespace App;


class Term extends Model
{

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    protected $fillable = [ 'workout_id', 'trener_id', 'slots', 'note','start_datetime', 'end_datetime','type'];

    //protected $with = ['userTerms.user.membership'];

    public function workout()
    {
        return $this->belongsTo('App\Workout');
    }


    public function coaches()
    {
        return $this->hasMany(User::class, 'id', 'trener_id');
    }

    public function userTerms()
    {
        return $this->hasMany('App\UserTerm');
    }
}
