<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ****** SUBJECTS TABLE ***********

        \App\Models\Subject::factory(1)->create([
            'name' => 'Agri-Fishery Arts'
        ]);
        \App\Models\Subject::factory(1)->create([
            'name' => 'HOME ECONOMICS'
        ]);

        \App\Models\Subject::factory(1)->create([
            'name' => 'ICT'
        ]);

        \App\Models\Subject::factory(1)->create([
            'name' => 'INDUSTRIAL ARTS'
        ]);
        
        // ****** SUBJECTS TABLE ***********
    }
}
