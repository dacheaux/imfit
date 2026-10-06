<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTerm extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'term_id', 'user_plan_id', 'user_delayed'];


    public function term()
    {
        return $this->belongsTo('App\Term');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userPlan()
    {
        return $this->belongsTo(UserPlan::class);
    }
}
