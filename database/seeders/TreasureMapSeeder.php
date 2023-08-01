<?php

namespace Database\Seeders;

use App\Models\TreasureMap;
use Illuminate\Database\Seeder;

class TreasureMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++)
        { 
            for ($j = 1; $j <= 15; $j++)
            {
                $getKrona = 0;
                $rand = rand(0, 100);
                if ($rand < 80)
                    $getKrona = rand(0, 10);
                else
                    $getKrona = rand(10, 20);
                $getKrona *= 10;

                $value = [
                    'row' => $i,
                    'column' => $j,
                    'digged' => false,
                    'krona' => $getKrona,
                ];
                TreasureMap::create($value);
            }
        }
    }
}
