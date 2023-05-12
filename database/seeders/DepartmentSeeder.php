<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
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
                'department_name' => 'Department of Journalism and Communication',
                'college_id' => '1'
            ],
            [
                'id' => '2',
                'department_name' => 'Department of Mathematics and Sciences',
                'college_id' => '1'
            ],
            [
                'id' => '3',
                'department_name' => 'Department of Social Sciences and Philosophy',
                'college_id' => '1'
            ],
            [
                'id' => '4',
                'department_name' => 'Department of Psychology and Library Information Science',
                'college_id' => '1'
            ],
            [
                'id' => '5',
                'department_name' => 'Department of Language and Literature',
                'college_id' => '1'
            ],
            [
                'id' => '6',
                'department_name' => 'Department of Education Programs',
                'college_id' => '3'
            ],
            [
                'id' => '7',
                'department_name' => 'Department of Computer Studies',
                'college_id' => '5'
            ],
            [
                'id' => '8',
                'department_name' => 'Department of Business Management',
                'college_id' => '2'
            ],
            [
                'id' => '9',
                'department_name' => 'Department of Law Studies',
                'college_id' => '8'
            ],
            [
                'id' => '10',
                'department_name' => 'Department of Medical Studies',
                'college_id' => '7'
            ],
            [
                'id' => '11',
                'department_name' => 'Department of Engineering Studies',
                'college_id' => '4'
            ],
        ];
        DB::table('departments')->insert($name); 
    }
}
