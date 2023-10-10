<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => 'manage-inventory',
            ],
            [
                'name' => 'manage-user',
            ],
            [
                'name' => 'generate-report',
            ],
            [
                'name' => 'manage-settings',
            ],
            [
                'name' => 'manage-borrowings',
            ],
            [
                'name' => 'borrow-items',
            ],
            [
                'name' => 'add-items',
            ],
            [
                'name' => 'update-items',
            ],
            [
                'name' => 'view-items',
            ],
            [
                'name' => 'delete-items',
            ],
            [
                'name' => 'transfer-items',
            ],
            [
                'name' => 'add-sub-items',
            ],
            [
                'name' => 'replace-items',
            ],
            [
                'name' => 'add-users',
            ],
            [
                'name' => 'update-users',
            ],
            [
                'name' => 'delete-users',
            ],
            [
                'name' => 'view-users',
            ],
        ];
        DB::table('permissions')->insert($permission); 
    }
}
