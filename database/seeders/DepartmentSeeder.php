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
                'department_name' => 'Department of Journalism and Communication',
                'college_id' => '1'
            ],
            [
                'department_name' => 'Department of Mathematics and Sciences',
                'college_id' => '1'
            ],
            [
                'department_name' => 'Department of Social Sciences and Philosophy',
                'college_id' => '1'
            ],
            [
                'department_name' => 'Department of Psychology and Library Information Science',
                'college_id' => '1'
            ],
            [
                'department_name' => 'Department of Language and Literature',
                'college_id' => '1'
            ],
            [
                'department_name' => 'Business Administration Department',
                'college_id' => '2'
            ],
            [
                'department_name' => 'Entrepreneurship Department',
                'college_id' => '2'
            ],
            [
                'department_name' => 'Accountancy Department',
                'college_id' => '2'
            ],
            [
                'department_name' => 'Tourism and Hospitality Management Department',
                'college_id' => '2'
            ],
            [
                'department_name' => 'Education Department',
                'college_id' => '3'
            ],
            [
                'department_name' => 'P.E. Department',
                'college_id' => '3'
            ],
            [
                'department_name' => 'Civil Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Computer Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Electronics and Communication Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Electrical Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Industrial Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Mechanical Engineering',
                'college_id' => '4'
            ],
            [
                'department_name' => 'Computer Science',
                'college_id' => '5'
            ],
            [
                'department_name' => 'Information Technology',
                'college_id' => '5'
            ],
            [
                'department_name' => 'Information Systems',
                'college_id' => '5'
            ],
            [
                'department_name' => 'Medical Sciences',
                'college_id' => '6'
            ],
            [
                'department_name' => 'Law Department',
                'college_id' => '7'
            ],
         
        ];
        DB::table('departments')->insert($name); 
    }
}
