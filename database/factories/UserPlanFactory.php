<?php

namespace Database\Factories;

use App\Plan;
use App\User;
use App\UserPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserPlanFactory extends Factory
{
    protected $model = UserPlan::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'terms_number' => 8,
            'expired_time' => Carbon::now(),
            'pause_flag' => 0,
            'active' => 0,
            'paid' => 0,
            'approved' => 0,
        ];
    }

    public function pending()
    {
        return $this->state(function () {
            return [
                'approved' => 0,
                'paid' => 0,
                'active' => 0,
                'expired_time' => Carbon::now(),
            ];
        });
    }

    public function approvedPaid()
    {
        return $this->state(function () {
            return [
                'approved' => 1,
                'paid' => 1,
                'active' => 0,
                'expired_time' => Carbon::now(),
            ];
        });
    }

    public function active()
    {
        return $this->state(function () {
            return [
                'approved' => 1,
                'paid' => 1,
                'active' => 1,
                'pause_flag' => 0,
                'expired_time' => Carbon::now()->addDays(30),
            ];
        });
    }
}
