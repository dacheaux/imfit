<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'type' => 0,
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'birth' => '1990-05-15',
            'phone' => '011/111-2223',
            'note' => null,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    public function member()
    {
        return $this->state(function () {
            return ['type' => 0];
        })->afterCreating(function (User $user) {
            $user->assignRole('vežbač');
        });
    }

    public function trainer()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('trener');
        });
    }
}
