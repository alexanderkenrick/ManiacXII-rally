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
        $teams = [
            [
                'id' => '1',
                'account_id' => '19',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '2',
                'account_id' => '20',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '3',
                'account_id' => '21',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '4',
                'account_id' => '22',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '5',
                'account_id' => '23',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '6',
                'account_id' => '24',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '7',
                'account_id' => '25',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '8',
                'account_id' => '26',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '9',
                'account_id' => '27',
                'currency' => '0',
                'file_qr_loc' => ""
            ],
            [
                'id' => '10',
                'account_id' => '28',
                'currency' => '0',
                'file_qr_loc' => ""
            ]
        ];
        foreach ($teams as $value) {
            Team::create($value);
        }
    }
}
