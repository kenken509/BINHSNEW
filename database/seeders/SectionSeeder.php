<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ****** SECTIONS TABLE ***********

        \App\Models\Section::factory(1)->create([
            'name'          => 'AFA11A1',
            'subject_id'    => '1',
            //'instructor_id' => '2',
        ]);

        \App\Models\Section::factory(1)->create([
            'name'          => 'HE11A1',
            'subject_id'    => '2',
            //'instructor_id' => '3',
        ]);

        //ict sections ID 3 & 4
        \App\Models\Section::factory(1)->create([ 
            'name'          => 'ICT11M1',
            'subject_id'    => '3',
            //'instructor_id' => '4',
        ]);

        \App\Models\Section::factory(1)->create([
            'name'          => 'ICT11A1',
            'subject_id'    => '3',
            //'instructor_id' => '4',
        ]);

        \App\Models\Section::factory(1)->create([
            'name'          => 'ICT11A2',
            'subject_id'    => '3',
            //'instructor_id' => '4',
        ]);
        
        \App\Models\Section::factory(1)->create([
            'name'          => 'IA11M1',
            'subject_id'    => '4',
            //'instructor_id' => '5',
        ]);

        // ****** SECTIONS TABLE ***********
    }
}
