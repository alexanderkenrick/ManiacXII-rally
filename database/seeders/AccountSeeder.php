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
                'username' => 'tim1',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 1',
                'role' => '2'
            ],
            [
                'id' => '20',
                'username' => 'tim2',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 2',
                'role' => '2'
            ],
            [
                'id' => '21',
                'username' => 'tim3',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 3',
                'role' => '2'
            ],
            [
                'id' => '22',
                'username' => 'tim4',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 4',
                'role' => '2'
            ],
            [
                'id' => '23',
                'username' => 'tim5',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 5',
                'role' => '2'
            ],
            [
                'id' => '24',
                'username' => 'tim6',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 6',
                'role' => '2'
            ],
            [
                'id' => '25',
                'username' => 'tim7',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 7',
                'role' => '2'
            ],
            [
                'id' => '26',
                'username' => 'tim8',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 8',
                'role' => '2'
            ],
            [
                'id' => '27',
                'username' => 'tim9',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 9',
                'role' => '2'
            ],
            [
                'id' => '28',
                'username' => 'tim10',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 10',
                'role' => '2'
            ],
            [
                'id' => '29',
                'username' => 'tim11',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 11',
                'role' => '2'
            ],
            [
                'id' => '30',
                'username' => 'tim12',
                'password' => Hash::make('maniac123'),
                'name' => 'Tim 12',
                'role' => '2'
            ],
            [
                'id' => '31',
                'username' => 'treasure1',
                'password' => Hash::make('maniac123'),
                'name' => 'Treasure 1',
                'role' => '3'
            ],
            [
                'id' => '32',
                'username' => 'treasure2',
                'password' => Hash::make('maniac123'),
                'name' => 'Treasure 2',
                'role' => '3'
            ],
            [
                'id' => '33',
                'username' => 'salvos1',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 1',
                'role' => '4'
            ],
            [
                'id' => '34',
                'username' => 'salvos2',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 2',
                'role' => '4'
            ],
            [
                'id' => '35',
                'username' => 'salvos3',
                'password' => Hash::make('maniac123'),
                'name' => 'Salvos 3',
                'role' => '4'
            ],

        ];
        foreach ($accounts as $value) {
            Account::create($value);
        }
    }
}
