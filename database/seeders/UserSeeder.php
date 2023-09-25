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
                'role' => 'manager',
                'department_id' => '1',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 201406392,
                'first_name' => 'Peter',
                'last_name' => 'Alao',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'approved',
                'account_type' => 'faculty',
                'role' => 'manager',
                'department_id' => '5',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2016013001,
                'first_name' => 'Joseph',
                'last_name' => 'Magabilin',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'approved',
                'account_type' => 'faculty',
                'role' => 'manager',
                'department_id' => '7',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2012321404,
                'first_name' => 'Julius Ceasar',
                'last_name' => 'Milan',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'pending',
                'account_type' => 'student',
                'role' => 'borrower',
                'department_id' => '5',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2016331404,
                'first_name' => 'Alexander',
                'last_name' => 'De Grate',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'pending',
                'account_type' => 'student',
                'role' => 'borrower',
                'department_id' => '5',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2014571321,
                'first_name' => 'Divine',
                'last_name' => 'Alilis',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'pending',
                'account_type' => 'student',
                'role' => 'borrower',
                'department_id' => '6',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 2014175231,
                'first_name' => 'Minerva Jane',
                'last_name' => 'Austin',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'pending',
                'account_type' => 'student',
                'role' => 'borrower',
                'department_id' => '6',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ],
            [
                'id_number' => 1111,
                'first_name' => 'Francis Louie',
                'last_name' => 'Alolor',
                'password' => Hash::make('usjrscs-123'),
                'account_status' => 'approved',
                'account_type' => 'faculty',
                'role' => 'borrower',
                'department_id' => '19',
                'security_question_id' => '1',
                'answer' => 'default',
                'password_updated' => 1,
            ]
        ];
        DB::table('users')->insert($user); 
    }
}
