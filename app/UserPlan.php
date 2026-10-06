<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class UserPlan extends Model
{
    use HasFactory;


    protected $casts = [
        'expired_time' => 'datetime',
        'pause_time' => 'datetime',
        'pause_from' => 'datetime',
    ];

    protected $fillable = [ 'user_id', 'plan_id', 'terms_number', 'expired_time', 'pause_time', 'pause_from','pause_flag', 'active', 'paid', 'approved'];

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y. H:i');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userterms()
    {
        return $this->hasMany('App\UserTerm');
    }
}
