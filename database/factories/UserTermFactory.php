<?php

namespace Database\Factories;

use App\Term;
use App\User;
use App\UserPlan;
use App\UserTerm;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTermFactory extends Factory
{
    protected $model = UserTerm::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'term_id' => Term::factory(),
            'user_plan_id' => UserPlan::factory(),
            'user_delayed' => 0,
        ];
    }

    public function delayed()
    {
        return $this->state(function () {
            return ['user_delayed' => 1];
        });
    }
}
