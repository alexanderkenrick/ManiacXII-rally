<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<40;$i++) {
            Team::create([
                'id' => $i,
                'account_id' => $i+23,
                'currency' => '0',
                'file_qr_loc' => ""
            ]);
        }
    }
}
