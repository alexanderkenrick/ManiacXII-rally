<?php

namespace Database\Seeders;

use App\Models\SalvosDamage;
use Illuminate\Database\Seeder;

class SalvosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dmgs = [
            [
                'multiple' => rand(1,7),
                'turn' => 6,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 12,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 18,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 24,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 30,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 36,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 42,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 48,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 54,
            ],
            [
                'multiple' => rand(1,7),
                'turn' => 60,
            ],
        ];
        foreach ($dmgs as $value) {
            SalvosDamage::create($value);
        }
    }
}
