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
            [
                'brand_name' => 'Samsung',
            ],
            [
                'brand_name' => 'AOC',
            ],
            [
                'brand_name' => 'Lenovo',
            ],
            [
                'brand_name' => 'Asus',
            ],
            [
                'brand_name' => 'MSI',
            ],
            [
                'brand_name' => 'Logitech',
            ],
            [
                'brand_name' => 'Genius',
            ],
        ];
        DB::table('brands')->insert($name);   
    }
}
