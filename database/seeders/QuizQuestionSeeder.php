<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //question 1
        DB::table('quiz_questions')->insert([
            'question'  => 'What does URL stand for?',
            'quiz_id'   => 1,
            'correct_answer' => 'Uniform Resource Location',
        ]);

        //question 2
        DB::table('quiz_questions')->insert([
            'question'  => 'The physical, tangible parts of a computer system is the...?',
            'quiz_id'   => 1,
            'correct_answer' => 'Hardware',
        ]);

        //question 3
        DB::table('quiz_questions')->insert([
            'question'  => 'ICT stands for _______________?',
            'quiz_id'   => 1,
            'correct_answer' => 'Information and Communication Technology',
        ]);
    }
}
