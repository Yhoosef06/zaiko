<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'id' => 1,
                'description' => 'borrower'
            ],
            [
                'id' => 2,
                'description' => 'manager'
            ],
            [
                'id' => 3,
                'description' => 'admin'
            ]
        ];
        DB::table('roles')->insert($role); 
    }
}
