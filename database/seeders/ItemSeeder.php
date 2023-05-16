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
                'item_category' => 'Mobile Devices',
                'brand' => 'Oppo',
                'Model' => 'A17s',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'A17S000123', 
            ],
            [
                'location' => '1',
                'item_category' => 'Peripherals',
                'brand' => 'Wacom',
                'Model' => 'Clintiq 16',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'without',
                'serial_number' => 'WCL16S0111334', 
            ],
            [
                'location' => '2',
                'item_category' => 'Peripherals',
                'brand' => 'Genius',
                'Model' => 'NX7000',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'NX7000A1011', 
            ],
            [
                'location' => '2',
                'item_category' => 'Peripherals',
                'brand' => 'Genius',
                'Model' => 'KB110',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'KB11000A1011', 
            ],
            [
                'location' => '2',
                'item_category' => 'PCs',
                'brand' => 'ASUS',
                'Model' => 'Z690',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '1',
                'unit_number' => 'BCL401',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'Z690012311', 
            ],
            [
                'location' => '4',
                'item_category' => 'Furnitures',
                'brand' => 'Uratex',
                'Model' => 'Mirella',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '20',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '5',
                'item_category' => 'Furnitures',
                'brand' => 'Uratex',
                'Model' => 'Classic 101',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '35',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],
            [
                'location' => '6',
                'item_category' => 'Furnitures',
                'brand' => 'Uratex',
                'Model' => 'Classic 101',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '15',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ], 
            [
                'location' => '6',
                'item_category' => 'Furnitures',
                'brand' => 'Uratex',
                'Model' => 'Mirella',
                'Description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tellus a malesuada vulputate.',
                'quantity' => '9',
                'unit_number' => 'N/A',
                'aquisition_date' => now()->format('F j, Y'),
                'status' => 'active',
                'borrowed' => 'no',
                'inventory_tag' => 'with',
                'serial_number' => 'N/A', 
            ],       
        ];
        DB::table('items')->insert($item);
    }
}
