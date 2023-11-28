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
                'user_id_number' => 2016013001,
                'role_id' => 2
            ],
        ];
        DB::table('user_roles')->insert($userRole);
    }
}
