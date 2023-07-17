<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = [
            [
                'question' => 'What is your the maiden name of your mother?'
            ],
            [
                'question' => 'What is your favorite subject in high school?'
            ],
            [
                'question' => 'What is your favorite movie?'
            ],
        ];
        DB::table('security_questions')->insert($question);
    }
}
