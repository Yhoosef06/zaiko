<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            [   'id' => 1,
                'brand_name' => 'No Brand',
            ],
            [
                'id' => 2,
                'brand_name' => 'Samsung',
            ],
            [
                'id' => 3,
                'brand_name' => 'Asus',
            ],
            [
                'id' => 4,
                'brand_name' => 'Uratex',
            ],
            [
                'id' => 5,
                'brand_name' => 'Oppo',
            ],
            [
                'id' => 6,
                'brand_name' => 'Philips',
            ],
            [
                'id' => 7,
                'brand_name' => 'Wacom',
            ],
            [
                'id' => 8,
                'brand_name' => 'Genius',
            ],
        ];
        DB::table('brands')->insert($name);   
    }
}
