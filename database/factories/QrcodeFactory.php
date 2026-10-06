<?php

namespace Database\Factories;

use App\Qrcode;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QrcodeFactory extends Factory
{
    protected $model = Qrcode::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'token' => 'test-token-'.$this->faker->unique()->numerify('######'),
            'qrcode_image' => 'qrcode-test.png',
            'type' => 0,
        ];
    }
}
