<?php

namespace Database\Factories;

use App\Account;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'balance' => 0,
        ];
    }
}
