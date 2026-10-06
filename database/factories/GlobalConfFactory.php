<?php

namespace Database\Factories;

use App\GlobalConf;
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalConfFactory extends Factory
{
    protected $model = GlobalConf::class;

    public function definition()
    {
        return [
            'time_book' => 3,
            'time_delay' => 6,
            'time_pause' => 7,
        ];
    }
}
