<?php

namespace Database\Seeders;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createAdmin = User::create([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'birth' => Carbon::createFromDate(1985, 4, 15),
            'phone' => '011/111-2223',
            'note' => 'Napomena...',
            'email' => 'admin@imfit.rs',
            'password' => '123456',
        ]);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'vežbač']);
        Role::create(['name' => 'trener']);

        $createAdmin->assignRole('admin');
    }
}
