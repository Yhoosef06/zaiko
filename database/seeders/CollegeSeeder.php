<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
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
                'id' => '1',
                'college_name' => 'SAS',
            ],
            [
                'id' => '2',
                'college_name' => 'SBM',
            ],
            [
                'id' => '3',
                'college_name' => 'SED',
            ],
            [
                'id' => '4',
                'college_name' => 'SENG',
            ],
            [
                'id' => '5',
                'college_name' => 'SCS',
            ],
            [
                'id' => '6',
                'college_name' => 'SAMS',
            ],
            [
                'id' => '7',
                'college_name' => 'SAMS',
            ],
            [
                'id' => '8',
                'college_name' => 'SL',
            ],
        ];
        DB::table('colleges')->insert($name); 
    }
}
