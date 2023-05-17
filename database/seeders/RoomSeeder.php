<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room = [
            [
                'room_name' => 'BRD2',
                'department_id' => '7'
            ],
            [
                'room_name' => 'BCL4',
                'department_id' => '7'
            ],
            [
                'room_name' => 'BCL5',
                'department_id' => '7'
            ],
            [
                'room_name' => 'RM102',
                'department_id' => '5'
            ],
            [
                'room_name' => 'RM103',
                'department_id' => '5'
            ],
            [
                'room_name' => 'RM202',
                'department_id' => '7'
            ]
        ];
        DB::table('rooms')->insert($room); 
    }
}
