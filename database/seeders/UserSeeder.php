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
                'account_type' => 'faculty',
                'isActive' => true,
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2016013001,
                'first_name' => 'Joseph',
                'last_name' => 'Magabilin',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'faculty',
                'isActive' => true,
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
        ];
        DB::table('users')->insert($user); 
    }
}
