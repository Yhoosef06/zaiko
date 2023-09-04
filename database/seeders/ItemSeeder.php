<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
            [
                'location' => '1',
                'category_id' => '3',
                'brand_id' => '4',
                'model_id' => '2',
                'description' => '7" inches screen snapdragon processor',
                'quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'A17S000123', 
            ],
            [
                'location' => '1',
                'category_id' => '4',
                'brand_id' => '6',
                'model_id' => '3',
                'description' => '12 inches tablet with pen',
                'quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'WCL16S0111334', 
            ],
            [
                'location' => '2',
                'category_id' => '4',
                'brand_id' => '7',
                'model_id' => '4',
                'description' => 'Ergonomic Black classic keyboard',
                'quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'NX7000A1011', 
            ],
            [
                'location' => '2',
                'category_id' => '4',
                'brand_id' => '7',
                'model_id' => '5',
                'description' => 'Lase ergonomic mouse',
                'quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'KB11000A1011', 
            ],
            [
                'location' => '3',
                'category_id' => '1',
                'brand_id' => '2',
                'model_id' => '1',
                'description' => 'LED screen 15"',
                'quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'Z690012311', 
            ],
            [
                'location' => '4',
                'category_id' => '7',
                'brand_id' => '3',
                'model_id' => '6',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'aquisition_date' => now(),
                'quantity' => '30',
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '1',
                'category_id' => '7',
                'brand_id' => '5',
                'model_id' => '7',
                'description' => 'Screw Driver',
                'quantity' => '15',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ], 
            [
                'location' => '4',
                'category_id' => '7',
                'brand_id' => '5',
                'model_id' => '8',
                'description' => 'Pliers',
                'quantity' => '9',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],       
        ];
        DB::table('items')->insert($item);
    }
}
