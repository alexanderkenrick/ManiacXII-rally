<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => '1',
                'name' => 'Shovel',
                'price' => 50,
                'description' => 'Used to dig krona',
            ],
            [
                'id' => '2',
                'name' => 'Thief Bag',
                'price' => 200,
                'description' => 'Steal krona from other player',
            ],
            [
                'id' => '3',
                'name' => 'Angel Card',
                'price' => 150,
                'description' => 'Protect you from thief',
            ]];
        foreach ($items as $value) {
            Item::create($value);
        }
    }
}
