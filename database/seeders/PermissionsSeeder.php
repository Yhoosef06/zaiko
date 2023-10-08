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
        ];
        DB::table('permissions')->insert($permission); 
    }
}
