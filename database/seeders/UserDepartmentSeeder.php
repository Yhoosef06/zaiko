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
        ];
        DB::table('user_departments')->insert($userDepartment); 
    }
}
