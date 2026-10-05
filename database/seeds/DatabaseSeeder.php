<?php

use App\Page;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

           Page::create([
              'name' => 'Galerija',
              'uri' => 'galerija',
              'gallery' => 1,
          ]);
          \App\GlobalConf::create([
              'time_book' => 3,
              'time_delay' => 6,
              'time_pause' => 7,
          ]);
    }
}
