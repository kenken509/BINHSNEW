<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizChoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 1,
            'option_a'          => 'Uniform Resource Locator',
            'option_b'          => 'Uniform Resource Location',
            'option_c'          => 'Universal Response Locator',
            'option_d'          => 'Universal Response Location',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 2,
            'option_a'          => 'Tower Casing',
            'option_b'          => 'Monitor',
            'option_c'          => 'Keyboard',
            'option_d'          => 'Hardware',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 3,
            'option_a'          => 'Information and Communication Technology',
            'option_b'          => 'Information and Communication Terminology',
            'option_c'          => 'Information and Common Technology',
            'option_d'          => 'Information to Communication Technology',
        ]);

        //QUIZ 2
        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 4,
            'option_a'          => 'Uniform Resource Locator',
            'option_b'          => 'Uniform Resource Location',
            'option_c'          => 'Universal Response Locator',
            'option_d'          => 'Universal Response Location',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 5,
            'option_a'          => 'Tower Casing',
            'option_b'          => 'Monitor',
            'option_c'          => 'Keyboard',
            'option_d'          => 'Hardware',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 6,
            'option_a'          => 'Information and Communication Technology',
            'option_b'          => 'Information and Communication Terminology',
            'option_c'          => 'Information and Common Technology',
            'option_d'          => 'Information to Communication Technology',
        ]);

        //QUIZ 3
        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 7,
            'option_a'          => 'Uniform Resource Locator',
            'option_b'          => 'Uniform Resource Location',
            'option_c'          => 'Universal Response Locator',
            'option_d'          => 'Universal Response Location',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 8,
            'option_a'          => 'Tower Casing',
            'option_b'          => 'Monitor',
            'option_c'          => 'Keyboard',
            'option_d'          => 'Hardware',
        ]);

        DB::table('quiz_choices')->insert([
            'quiz_question_id'  => 9,
            'option_a'          => 'Information and Communication Technology',
            'option_b'          => 'Information and Communication Terminology',
            'option_c'          => 'Information and Common Technology',
            'option_d'          => 'Information to Communication Technology',
        ]);
    }
}
