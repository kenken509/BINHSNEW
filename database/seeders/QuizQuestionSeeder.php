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
        // QUIZ 1
        //question 1
        DB::table('quiz_questions')->insert([
            'question'  => 'What does URL stand for?',
            'quiz_id'   => 1,
            'correct_answer' => 'A',
        ]);

        //question 2
        DB::table('quiz_questions')->insert([
            'question'  => 'The physical, tangible parts of a computer system is the...?',
            'quiz_id'   => 1,
            'correct_answer' => 'D',
        ]);

        //question 3
        DB::table('quiz_questions')->insert([
            'question'  => 'ICT stands for _______________?',
            'quiz_id'   => 1,
            'correct_answer' => 'A',
        ]);

        // QUIZ 2
        //question 1
        DB::table('quiz_questions')->insert([
            'question'  => 'What does URL stand for?',
            'quiz_id'   => 2,
            'correct_answer' => 'A',
        ]);

        //question 2
        DB::table('quiz_questions')->insert([
            'question'  => 'The physical, tangible parts of a computer system is the...?',
            'quiz_id'   => 2,
            'correct_answer' => 'D',
        ]);

        //question 3
        DB::table('quiz_questions')->insert([
            'question'  => 'ICT stands for _______________?',
            'quiz_id'   => 2,
            'correct_answer' => 'A',
        ]);

        // QUIZ 3

        //question 1
        DB::table('quiz_questions')->insert([
            'question'  => 'What does URL stand for?',
            'quiz_id'   => 3,
            'correct_answer' => 'A',
        ]);

        //question 2
        DB::table('quiz_questions')->insert([
            'question'  => 'The physical, tangible parts of a computer system is the...?',
            'quiz_id'   => 3,
            'correct_answer' => 'D',
        ]);

        //question 3
        DB::table('quiz_questions')->insert([
            'question'  => 'ICT stands for _______________?',
            'quiz_id'   => 3,
            'correct_answer' => 'A',
        ]);

    }
}
