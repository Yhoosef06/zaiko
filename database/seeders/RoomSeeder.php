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
            ],
            [
                'room_name' => 'BCL4',
            ],
            [
                'room_name' => 'BCL5',
            ],
            [
                'room_name' => 'FACULTY',
            ],
            [
                'room_name' => 'BRD1',
            ],
            [
                'room_name' => 'BCL8',
            ]
        ];
        DB::table('rooms')->insert($room); 
    }
}
