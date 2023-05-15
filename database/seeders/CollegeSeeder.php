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
                'college_name' => 'School of Arts & Sciences',
            ],
            [
                'college_name' => 'School of Business & Management',
            ],
            [
                'college_name' => 'School of Education',
            ],
            [
                'college_name' => 'School of Engineering',
            ],
            [
                'college_name' => 'School of Computer Studies',
            ],
            [
                'college_name' => 'School of Allied & Medical Sciences',
            ],
            [
                'college_name' => 'School of Law',
            ],
        ];
        DB::table('colleges')->insert($name);
    }
}
