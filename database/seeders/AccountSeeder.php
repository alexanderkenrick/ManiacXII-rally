<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function csvToArray($csv)
        {
            // create file handle to read CSV file
            $csvToRead = fopen($csv, 'r');

            // read CSV file using comma as delimiter
            while (!feof($csvToRead)) {
                $csvArray[] = fgetcsv($csvToRead, 1000, ',');
            }

            fclose($csvToRead);
            return $csvArray;
        }
        $accounts = [
            [
                'id' => '1',
                'username' => 'admin',
                'password' => Hash::make('maniac123!'),
                'name' => 'Admin Maniac',
                'role' => '0'
            ],
            [
                'id' => '2',
                'username' => 'walking',
                'password' => Hash::make('maniac123'),
                'name' => 'Walking Fairy Tail Game',
                'role' => '1'
            ],
            [
                'id' => '3',
                'username' => 'draw',
                'password' => Hash::make('maniac123'),
                'name' => 'Draw Your Part',
                'role' => '1'
            ],
            [
                'id' => '4',
                'username' => 'kill',
                'password' => Hash::make('maniac123'),
                'name' => 'Kill the Evil Dragon',
                'role' => '1'
            ],
            [
                'id' => '5',
                'username' => 'get',
                'password' => Hash::make('maniac123'),
                'name' => 'Get The Story',
                'role' => '1'
            ],
            [
                'id' => '6',
                'username' => 'ears',
                'password' => Hash::make('maniac123'),
                'name' => 'My Ears are Blind',
                'role' => '1'
            ],
            [
                'id' => '7',
                'username' => 'guess',
                'password' => Hash::make('maniac123'),
                'name' => 'Guess The Logo',
                'role' => '1'
            ],
            [
                'id' => '8',
                'username' => 'make',
                'password' => Hash::make('maniac123'),
                'name' => 'Make me be the one Unity',
                'role' => '1'
            ],
            [
                'id' => '9',
                'username' => 'mirror',
                'password' => Hash::make('maniac123'),
                'name' => 'Mirror Of Black and White',
                'role' => '1'
            ],
            [
                'id' => '10',
                'username' => 'match',
                'password' => Hash::make('maniac123'),
                'name' => 'Match the Picture',
                'role' => '1'
            ],
            [
                'id' => '11',
                'username' => 'fill',
                'password' => Hash::make('maniac123'),
                'name' => 'Fill the Arena',
                'role' => '1'
            ],
            [
                'id' => '12',
                'username' => 'wonder',
                'password' => Hash::make('maniac123'),
                'name' => 'Wonderland Castle',
                'role' => '1'
            ],
            [
                'id' => '13',
                'username' => 'give',
                'password' => Hash::make('maniac123'),
                'name' => 'Give Color to your square',
                'role' => '1'
            ],
            [
                'id' => '14',
                'username' => 'test',
                'password' => Hash::make('maniac123'),
                'name' => 'Test your Creativity',
                'role' => '1'
            ],
            [
                'id' => '15',
                'username' => 'disney',
                'password' => Hash::make('maniac123'),
                'name' => 'Disney Charades',
                'role' => '1'
            ],
            [
                'id' => '16',
                'username' => 'eyes',
                'password' => Hash::make('maniac123'),
                'name' => 'Eyes Checking',
                'role' => '1'
            ],
            [
                'id' => '17',
                'username' => 'change',
                'password' => Hash::make('maniac123'),
                'name' => 'Change the Face',
                'role' => '1'
            ],
            [
                'id' => '18',
                'username' => 'bingo',
                'password' => Hash::make('maniac123'),
                'name' => 'Bingo',
                'role' => '1'
            ],

            [
                'id' => '19',
                'username' => 'treasure1',
                'password' => Hash::make('maniac123'),
                'name' => 'Treasure 1',
                'role' => '3'
            ],
            [
                'id' => '20',
                'username' => 'treasure2',
                'password' => Hash::make('maniac123'),
                'name' => 'Treasure 2',
                'role' => '3'
            ],
            [
                'id' => '21',
                'username' => 'salvos1',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 1',
                'role' => '4'
            ],
            [
                'id' => '22',
                'username' => 'salvos2',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 2',
                'role' => '4'
            ],
            [
                'id' => '23',
                'username' => 'salvos3',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 3',
                'role' => '4'
            ],

        ];
        foreach ($accounts as $value) {
            Account::create($value);
        }
        // CSV file to read into an Array
        $csvFile = 'database/data/teams.csv';
        $csvArray = csvToArray($csvFile);
        for ($i = 0; $i < 39; $i++) {
            Account::create([
                'id' => $i+24,
                'username' => 'tim' . $i,
                'password' => Hash::make('maniac123'),
                'name' => $csvArray[$i][0],
                'role' => '2'
            ]);
        }
    }
}
