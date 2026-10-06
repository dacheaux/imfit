<?php

namespace Database\Factories;

use App\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    protected $model = Workout::class;

    public function definition()
    {
        return [
            'name' => 'Pilates',
            'workout_time' => 60,
        ];
    }
}
