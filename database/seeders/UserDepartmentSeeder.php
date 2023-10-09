<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userDepartment = [
            [
                'user_id_number' => 8888,
                'department_id' => 19
            ],
            [
                'user_id_number' => 1111,
                'department_id' => 19
            ],
            [
                'user_id_number' => 2016013001,
                'department_id' => 19
            ],
            [
                'user_id_number' => 2016013001,
                'department_id' => 18
            ],
            [
                'user_id_number' => 2016013001,
                'department_id' => 20
            ],
            [
                'user_id_number' => 2014036392,
                'department_id' => 19
            ],
            [
                'user_id_number' => 2012321404,
                'department_id' => 19
            ],
            [
                'user_id_number' => 2014571321,
                'department_id' => 19
            ],
            [
                'user_id_number' => 2014175231,
                'department_id' => 19
            ],
        ];
        DB::table('user_departments')->insert($userDepartment); 
    }
}
