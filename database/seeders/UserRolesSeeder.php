<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $userRole = [
            [
                'id' => 1,
                'user_id' => 8888,
                'role_id' => 3,
                'department_id' => null
            ],
            [
                'id' => 2,
                'user_id' => 1111,
                'role_id' => 1,
                'department_id' => 19
            ],
            [
                'id' => 3,
                'user_id' => 20160130001,
                'role_id' => 2,
                'department_id' => 19
            ],
            [
                'id' => 4,
                'user_id' => 2014036392,
                'role_id' => 1,
                'department_id' => 19
            ],
            [
                'id' => 5,
                'user_id' => 2012321404,
                'role_id' => 1,
                'department_id' => 19
            ],
            [
                'id' => 6,
                'user_id' => 2016331404,
                'role_id' => 1,
                'department_id' => 19
            ],
            [
                'id' => 7,
                'user_id' => 2014571321,
                'role_id' => 1,
                'department_id' => 19
            ],
            [
                'id' => 8,
                'user_id' => 2014175231,
                'role_id' => 1,
                'department_id' => 19
            ],
        ];
        DB::table('user_roles')->insert($userRole); 

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
