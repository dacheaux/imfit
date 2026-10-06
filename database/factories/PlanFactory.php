<?php

namespace Database\Factories;

use App\Plan;
use App\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition()
    {
        return [
            'workout_id' => Workout::factory(),
            'name' => 'Paket 8',
            'workouts_number' => 8,
            'plan_duration' => 30,
            'price' => '4000',
            'seen' => 0,
        ];
    }
}
