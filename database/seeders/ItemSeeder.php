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
                'brand' => 'Oppo',
                'Model' => 'A17s',
                'Description' => '7" inches screen snapdragon processor',
                'quantity' => '1',
                'available_quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'A17S000123', 
            ],
            [
                'location' => '1',
                'category_id' => '4',
                'brand' => 'Wacom',
                'Model' => 'Clintiq 16',
                'Description' => '12 inches tablet with pen',
                'quantity' => '1',
                'available_quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'WCL16S0111334', 
            ],
            [
                'location' => '2',
                'category_id' => '4',
                'brand' => 'Genius',
                'Model' => 'NX7000',
                'Description' => 'Ergonomic Black classic keyboard',
                'quantity' => '1',
                'available_quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'NX7000A1011', 
            ],
            [
                'location' => '2',
                'category_id' => '4',
                'brand' => 'Genius',
                'Model' => 'KB110',
                'Description' => 'Lase ergonomic mouse',
                'quantity' => '1',
                'available_quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'KB11000A1011', 
            ],
            [
                'location' => '2',
                'category_id' => '1',
                'brand' => 'ASUS',
                'Model' => 'Z690',
                'Description' => 'LED screen 15"',
                'quantity' => '1',
                'available_quantity' => '1',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'Z690012311', 
            ],
            [
                'location' => '4',
                'category_id' => '7',
                'brand' => 'Uratex',
                'Model' => 'Mirella',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '20',
                'available_quantity' => '20',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '5',
                'category_id' => '7',
                'brand' => 'Uratex',
                'Model' => 'Classic 101',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '35',
                'available_quantity' => '35',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '6',
                'category_id' => '7',
                'brand' => 'Philips',
                'Model' => 'Screw 2022',
                'Description' => 'Screw Driver',
                'quantity' => '15',
                'available_quantity' => '15',
                'aquisition_date' => now(),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ], 
            [
                'location' => '6',
                'category_id' => '7',
                'brand' => 'Philips',
                'Model' => 'Pliers 2021',
                'Description' => 'Pliers',
                'quantity' => '9',
                'available_quantity' => '9',
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
