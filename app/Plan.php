<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['workout_id','name', 'workouts_number', 'plan_duration', 'price'];

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }

}
