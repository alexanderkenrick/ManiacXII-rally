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
                'multiple' => rand(1,10),
                'turn' => 6,
            ],
            [
                'multiple' => rand(1,10),
                'turn' => 12,
            ],
            [
                'multiple' => rand(1,10),
                'turn' => 18,
            ],
            [
                'multiple' => rand(1,10),
                'turn' => 18+6,
            ]
        ];
        foreach ($dmgs as $value) {
            SalvosDamage::create($value);
        }
    }
}
