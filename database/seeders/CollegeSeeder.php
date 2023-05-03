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
                'college_name' => 'SAS',
            ],
            [
                'college_name' => 'SBM',
            ],
            [
                'college_name' => 'SED',
            ],
            [
                'college_name' => 'SENG',
            ],
            [
                'college_name' => 'SCS',
            ],
            [
                'college_name' => 'SAMS',
            ],
            [
                'college_name' => 'SAMS',
            ],
            [
                'college_name' => 'SL',
            ],
        ];
        DB::table('colleges')->insert($name); 
    }
}
