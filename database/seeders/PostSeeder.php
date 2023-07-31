<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'id' => '1',
                'penpos_id' => '2',
                'name' => 'Walking Fairy Tail Game',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '2',
                'penpos_id' => '3',
                'name' => 'Draw Your Part',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '3',
                'penpos_id' => '4',
                'name' => 'Kill the Evil Dragon',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '4',
                'penpos_id' => '5',
                'name' => 'Get the Story',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '5',
                'penpos_id' => '6',
                'name' => 'My Ears are Blind',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '6',
                'penpos_id' => '7',
                'name' => 'Guess the Logo',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '7',
                'penpos_id' => '8',
                'name' => 'Make me be one Unity',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '8',
                'penpos_id' => '9',
                'name' => 'Mirror of black and white',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '9',
                'penpos_id' => '10',
                'name' => 'Match the picture',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '10',
                'penpos_id' => '11',
                'name' => 'Fill the Arena',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '11',
                'penpos_id' => '12',
                'name' => 'Wonderland Castle',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Battle"
            ], 
            [
                'id' => '12',
                'penpos_id' => '13',
                'name' => 'Give Color to your square',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Battle"
            ], 
            [
                'id' => '13',
                'penpos_id' => '14',
                'name' => 'Test your creativity',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Battle"
            ], 
            [
                'id' => '14',
                'penpos_id' => '15',
                'name' => 'Disney Charades',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Battle"
            ], 
            [
                'id' => '15',
                'penpos_id' => '16',
                'name' => 'Eyes checking',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Dungeon"
            ], 
            [
                'id' => '16',
                'penpos_id' => '17',
                'name' => 'Change the face',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Dungeon"
            ], 
            [
                'id' => '17',
                'penpos_id' => '18',
                'name' => 'Bingo',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Dungeon"
            ], 
            [
                'id' => '18',
                'penpos_id' => '29',
                'name' => 'Treasure 1',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
            [
                'id' => '19',
                'penpos_id' => '30',
                'name' => 'Treasure 2',
                'status' => "Full",
                'file_photo_loc' => "",
                'post_type' => "Single"
            ], 
        ];
        foreach ($posts as $value){
            Post::create($value);
        }
    }
}
