<?php

namespace Database\Factories;

use App\Term;
use App\User;
use App\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TermFactory extends Factory
{
    protected $model = Term::class;

    public function definition()
    {
        $start = Carbon::now()->addDays(2)->setTime(18, 0, 0);

        return [
            'workout_id' => Workout::factory(),
            'trener_id' => User::factory(),
            'slots' => 5,
            'start_datetime' => $start,
            'end_datetime' => $start->copy()->addHour(),
            'note' => 'Evening class',
            'type' => 0,
        ];
    }
}
