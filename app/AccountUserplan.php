<?php

namespace App;


class AccountUserplan extends Model
{
    protected $fillable = [ 'user_id', 'account_plan_id', 'paid', 'approved'];


    public function accountplan()
    {
        return $this->belongsTo('App\AccountPlan','account_plan_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
