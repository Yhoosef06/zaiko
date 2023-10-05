<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = [
            [
                'user_id_number' => 8888,
                'role_id' => 1
            ],
            [
                'user_id_number' => 1111,
                'role_id' => 3
            ],
            [
                'user_id_number' => 2016013001,
                'role_id' => 2
            ],
            [
                'user_id_number' => 2014036392,
                'role_id' => 3
            ],
            [
                'user_id_number' => 2012321404,
                'role_id' => 3
            ],
            [
                'user_id_number' => 2016331404,
                'role_id' => 3
            ],
            [
                'user_id_number' => 2014571321,
                'role_id' => 3
            ],
            [
                'user_id_number' => 2014175231,
                'role_id' => 3
            ],
        ];
        DB::table('user_roles')->insert($userRole);
    }
}
