<?php

namespace Database\Seeders;

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
        $this->call([
           SalvosSeeder::class,
           AccountSeeder::class,
           ItemSeeder::class,
           TeamSeeder::class,
           PostSeeder::class,
           TreasureMapSeeder::class
        ]);
    }
}
