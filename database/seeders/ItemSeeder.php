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
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'N/A',
                'aquisition_date' => '07-21-19',
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
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'N/A',
                'aquisition_date' => '08-11-19',
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
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => '05-20-19',
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
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => '05-20-19',
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
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => '05-20-19',
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
                'unit_number' => 'N/A',
                'aquisition_date' => 'N/A',
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
                'unit_number' => 'N/A',
                'aquisition_date' => 'N/A',
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '6',
                'category_id' => '7',
                'brand' => 'Uratex',
                'Model' => 'Classic 101',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '15',
                'unit_number' => 'N/A',
                'aquisition_date' => 'N/A',
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ], 
            [
                'location' => '6',
                'category_id' => '7',
                'brand' => 'Uratex',
                'Model' => 'Mirella',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '9',
                'unit_number' => 'N/A',
                'aquisition_date' => 'N/A',
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],       
        ];
        DB::table('items')->insert($item);
    }
}
