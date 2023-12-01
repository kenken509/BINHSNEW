<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //agri-fishery arts (afa) student
         \App\Models\User::factory(1)->create([
            'email'         => 'afaStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 1,
            'section_id'    => 1,
            'isActive'      => 1,
            'school_year'   => '2023-2024'
        ]);
       
        //HE student
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);

         //ict student
         \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 3,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent2@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 3,
            'isActive' => 1,
            'school_year'   => '2019-2020'
        ]);

        // industrial arts (ia) student
        \App\Models\User::factory(1)->create([
            'email'         => 'iaStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 4,
            'section_id'    => 4,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);
    }
}
