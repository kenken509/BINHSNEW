<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Instructor_Sections_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ict instructors id 4/5/6
        DB::table('instructor_sections')->insert([
            'instructor_id' => 2,
            'section_id'    => 1,
        ]);

        DB::table('instructor_sections')->insert([
            'instructor_id' => 3,
            'section_id'    => 2,
        ]);

        DB::table('instructor_sections')->insert([
            'instructor_id' => 4,
            'section_id'    => 3,
        ]);

        DB::table('instructor_sections')->insert([
            'instructor_id' => 5,
            'section_id'    => 4,
        ]);
        DB::table('instructor_sections')->insert([
            'instructor_id' => 6,
            'section_id'    => 5,
        ]);

        DB::table('instructor_sections')->insert([
            'instructor_id' => 7,
            'section_id'    => 6,
        ]);
    }
}
