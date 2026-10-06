<?php

namespace App;

use Illuminate\Support\Carbon;

class AccountPlan extends Model
{
    protected $fillable = [ 'plan_name', 'deposit_amount', 'inactive'];

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');
    }

    public function accountuserPlan()
    {
        return $this->hasMany(AccountUserplan::class, 'id', 'account_plan_id');
    }
}
