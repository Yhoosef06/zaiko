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
                'account_status' => 'approved',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2014036392,
                'first_name' => 'Peter',
                'last_name' => 'Alao',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'faculty',
                'account_status' => 'approved',
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
                'account_status' => 'approved',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2012321404,
                'first_name' => 'Julius Ceasar',
                'last_name' => 'Milan',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'student',
                'account_status' => 'pending',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2014571321,
                'first_name' => 'Divine',
                'last_name' => 'Alilis',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'student',
                'account_status' => 'pending',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2014175231,
                'first_name' => 'Minerva Jane',
                'last_name' => 'Austin',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'student',
                'account_status' => 'pending',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 1111,
                'first_name' => 'Francis Louie',
                'last_name' => 'Alolor',
                'password' => Hash::make('usjrscs-123'),
                'account_type' => 'student',
                'account_status' => 'approved',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ]
        ];
        DB::table('users')->insert($user); 
    }
}
