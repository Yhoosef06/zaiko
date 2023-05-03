<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            [
                'category_name' => 'PCs',
            ],
            [
                'category_name' => 'Monitors',
            ],
            [
                'category_name' => 'Mobile Devices',
            ],
            [
                'category_name' => 'Peripherals',
            ],
            [
                'category_name' => 'Microcontrollers',
            ],
            [
                'category_name' => 'Kits',
            ],
            [
                'category_name' => 'Tools',
            ],
        ];
        DB::table('item_categories')->insert($name);   
    }
}
