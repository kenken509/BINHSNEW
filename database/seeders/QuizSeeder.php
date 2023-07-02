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
        DB::table('quizzes')->insert([
            'title'             => 'Quiz 1',
            'subject_id'        => 3,
            'grading_period'    => '1st',
            'duration'          => 20,
        ]);
    }
}
