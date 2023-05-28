<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = [
            [
                'id' => 1,
                'user_id' => 2012321404,
                'date_submitted' => now(),
                'date_returned' => '',
                
            ],
            [
                'id' => 2,
                'user_id' => 2016331404,
                'date_submitted' => '',
                'date_returned' => '',
            ]
        ];
        DB::table('orders')->insert($order); 
    }
}
