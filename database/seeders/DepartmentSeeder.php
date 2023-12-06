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
                'college_id' => '1',
                'department_abbre' => 'DJC'
            ],
            [
                'department_name' => 'Department of Mathematics and Sciences',
                'college_id' => '1',
                'department_abbre' => 'DMS'
            ],
            [
                'department_name' => 'Department of Social Sciences and Philosophy',
                'college_id' => '1',
                'department_abbre' => 'DSSP'
            ],
            [
                'department_name' => 'Department of Psychology and Library Information Science',
                'college_id' => '1',
                'department_abbre' => 'DPLIS'
            ],
            [
                'department_name' => 'Department of Language and Literature',
                'college_id' => '1',
                'department_abbre' => 'DLL'
            ],
            [
                'department_name' => 'Business Administration Department',
                'college_id' => '2',
                'department_abbre' => 'BUSINESS AD'
            ],
            [
                'department_name' => 'Entrepreneurship Department',
                'college_id' => '2',
                'department_abbre' => 'ETREP'
            ],
            [
                'department_name' => 'Accountancy Department',
                'college_id' => '2',
                'department_abbre' => 'ACCOUNTANCY'
            ],
            [
                'department_name' => 'Tourism and Hospitality Management Department',
                'college_id' => '2',
                'department_abbre' => 'TOURISM'
            ],
            [
                'department_name' => 'Education Department',
                'college_id' => '3',
                'department_abbre' => 'EDUC'
            ],
            [
                'department_name' => 'P.E. Department',
                'college_id' => '3',
                'department_abbre' => 'PE'
            ],
            [
                'department_name' => 'Civil Engineering',
                'college_id' => '4',
                'department_abbre' => 'CE'
            ],
            [
                'department_name' => 'Computer Engineering',
                'college_id' => '4',
                'department_abbre' => 'CPE'
            ],
            [
                'department_name' => 'Electronics and Communication Engineering',
                'college_id' => '4',
                'department_abbre' => 'ECE'
            ],
            [
                'department_name' => 'Electrical Engineering',
                'college_id' => '4',
                'department_abbre' => 'EE'
            ],
            [
                'department_name' => 'Industrial Engineering',
                'college_id' => '4',
                'department_abbre' => 'IE'
            ],
            [
                'department_name' => 'Mechanical Engineering',
                'college_id' => '4',
                'department_abbre' => 'ME'
            ],
            [
                'department_name' => 'Computer Science',
                'college_id' => '5',
                'department_abbre' => 'CS'
            ],
            [
                'department_name' => 'Information Technology',
                'college_id' => '5',
                'department_abbre' => 'IT'
            ],
            [
                'department_name' => 'Information Systems',
                'college_id' => '5',
                'department_abbre' => 'IS'
            ],
            [
                'department_name' => 'Medical Sciences',
                'college_id' => '6',
                'department_abbre' => 'MED SCI'
            ],
            [
                'department_name' => 'Law Department',
                'college_id' => '7',
                'department_abbre' => 'LAW'
            ],
         
        ];
        DB::table('departments')->insert($name); 
    }
}
