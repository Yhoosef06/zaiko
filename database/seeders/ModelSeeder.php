<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelSeeder extends Seeder
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
                'id' => 1,
                'brand_id' => 2,
                'model_name' => 'Z690',
            ],
            [
                'id' => 2,
                'brand_id' => 4,
                'model_name' => 'A17s',
            ],
            [
                'id' => 3,
                'brand_id' => 6,
                'model_name' => 'Clintiq 16',
            ],
            [
                'id' => 4,
                'brand_id' => 7,
                'model_name' => 'NX7000',
            ],
            [
                'id' => 5,
                'brand_id' => 7,
                'model_name' => 'KB110',
            ],
            [
                'id' => 6,
                'brand_id' => 3,
                'model_name' => 'Mirella',
            ],
            [
                'id' => 7,
                'brand_id' => 5,
                'model_name' => 'Screw 2022',
            ],
            [
                'id' => 8,
                'brand_id' => 5,
                'model_name' => 'Pliers 2021',
            ],
            
        ];
        DB::table('models')->insert($name);   
    }
    
}
