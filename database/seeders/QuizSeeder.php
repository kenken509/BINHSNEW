<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //'First Grading','Second Grading','Third Grading', 'Fifth Grading'
        DB::table('quizzes')->insert([
            'title'             => 'Quiz 1',
            'subject_id'        => 3,
            'grading_period'    => 'First Grading',
            'duration'          => 20,
            'school_year'       => '2023-2024',
            'created_by'        => 5
        ]);

        DB::table('quizzes')->insert([
            'title'             => 'Quiz 2',
            'subject_id'        => 3,
            'grading_period'    => 'First Grading',
            'duration'          => 20,
            'school_year'       => '2023-2024',
            'created_by'        => 5
        ]);

        DB::table('quizzes')->insert([
            'title'             => 'Quiz 3',
            'subject_id'        => 3,
            'grading_period'    => 'First Grading',
            'duration'          => 20,
            'school_year'       => '2023-2024',
            'created_by'        => 4
        ]);
    }
}
