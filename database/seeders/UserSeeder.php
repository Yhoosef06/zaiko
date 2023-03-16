<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
                'id_number' => 8888,
                'first_name' => 'admin',
                'last_name' => 'usjr',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'approved',
                'account_type' => 'admin',
                'front_of_id' => 'null',
                'back_of_id' => 'null'
            ]
        ];
        DB::table('users')->insert($user); 
    }
}
