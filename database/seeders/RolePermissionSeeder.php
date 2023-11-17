<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolePermission = [
            [
                'role_id' => 1,
                'permission_id' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 2
            ],
            [
                'role_id' => 1,
                'permission_id' => 3
            ],
            [
                'role_id' => 1,
                'permission_id' => 7
            ],
            [
                'role_id' => 1,
                'permission_id' => 8
            ],
            [
                'role_id' => 1,
                'permission_id' => 9
            ],
            [
                'role_id' => 1,
                'permission_id' => 10
            ],
            [
                'role_id' => 1,
                'permission_id' => 11
            ],
            [
                'role_id' => 1,
                'permission_id' => 12
            ],
            [
                'role_id' => 1,
                'permission_id' => 13
            ],
            [
                'role_id' => 1,
                'permission_id' => 14
            ],
            [
                'role_id' => 1,
                'permission_id' => 15
            ],
            [
                'role_id' => 1,
                'permission_id' => 16
            ],
            [
                'role_id' => 1,
                'permission_id' => 17
            ],

            [
                'role_id' => 2,
                'permission_id' => 1
            ],
            [
                'role_id' => 2,
                'permission_id' => 2
            ],
            [
                'role_id' => 2,
                'permission_id' => 3
            ],
            [
                'role_id' => 2,
                'permission_id' => 5
            ],
            [
                'role_id' => 2,
                'permission_id' => 6
            ],
            [
                'role_id' => 2,
                'permission_id' => 7
            ],
            [
                'role_id' => 2,
                'permission_id' => 8
            ],    
            [
                'role_id' => 2,
                'permission_id' => 9
            ],
            [
                'role_id' => 2,
                'permission_id' => 10
            ],
            [
                'role_id' => 2,
                'permission_id' => 11
            ],
            [
                'role_id' => 2,
                'permission_id' => 12
            ],
            [
                'role_id' => 2,
                'permission_id' => 13
            ],
            [
                'role_id' => 2,
                'permission_id' => 17
            ],
            [
                'role_id' => 3,
                'permission_id' => 6
            ],
        ];
        DB::table('role_permissions')->insert($rolePermission);
    }
}
