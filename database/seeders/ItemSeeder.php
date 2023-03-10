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
                'location' => 'BRD2',
                'serial_number' => 'GBRD41A013360',
                'item_description' => 'AOC LCD MONITOR',
                'quantity' => '1',
                'unit_number' => 'BRD201',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no',
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'XP1321151568s',
                'item_description' => 'GENIUS USB KEYBOARD',
                'quantity' => '1',
                'unit_number' => 'BRD201',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no',  
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'X68972707451',
                'item_description' => 'A4TECH PS/2 OPTICAL MOUSE',
                'quantity' => '1',
                'unit_number' => 'BRD201',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            
            [
                'location' => 'BRD2',
                'serial_number' => 'GBRD41A013319',
                'item_description' => 'AOC LCD MONITOR',
                'quantity' => '1',
                'unit_number' => 'BRD202',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no',
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'BRD202A',
                'item_description' => 'System Unit(Intel Core i5-3470, 4gb RAM 500GB HDD',
                'quantity' => '1',
                'unit_number' => 'BRD201',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'XP13211571',
                'item_description' => 'GENIUS USB KEYBOARD',
                'quantity' => '1',
                'unit_number' => 'BRD202',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no',  
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'X68972707452',
                'item_description' => 'A4TECH PS/2 OPTICAL MOUSE',
                'quantity' => '1',
                'unit_number' => 'BRD202',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BRD2',
                'serial_number' => 'BRD202B',
                'item_description' => 'System Unit',
                'quantity' => '1',
                'unit_number' => 'BRD202',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BCL8',
                'serial_number' => 'BCL801A',
                'item_description' => 'System Unit',
                'quantity' => '1',
                'unit_number' => 'BCL801',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BCL8',
                'serial_number' => 'GBRD41A013362',
                'item_description' => 'AOC LCD MONITOR',
                'quantity' => '1',
                'unit_number' => 'BCL801',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BCL8',
                'serial_number' => 'XP1321151566',
                'item_description' => 'A4TECH PS/2 OPTICAL MOUSE',
                'quantity' => '1',
                'unit_number' => 'BCL801',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
            [
                'location' => 'BCL8',
                'serial_number' => '1234567899',
                'item_description' => 'GENIUS USB KEYBOARD',
                'quantity' => '1',
                'unit_number' => 'BCL801',
                'aquisition_date' => '2014-10-29',
                'status' => 'Active',
                'inventory_tag' => 'with',
                'borrowed' => 'no', 
            ],
        ];
        DB::table('items')->insert($item);
    }
}
