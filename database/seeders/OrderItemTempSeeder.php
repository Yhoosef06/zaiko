<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_item_temp = [
            [
                'order_id' => 1,
                'item_id' => 1,
                'quantity' => 3,       

            ],
            [
                'order_id' => 1,
                'item_id' => 2,
                'quantity' => 1, 
            ],
            [
                'order_id' => 2,
                'item_id' => 5,
                'quantity' => 1, 
            ]
        ];
        DB::table('order_item_temps')->insert($order_item_temp); 
    }
}
