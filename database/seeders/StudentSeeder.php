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
         //agri-fishery arts (afa) student SECTION ID 1
         \App\Models\User::factory(1)->create([
            'email'         => 'afaStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 1,
            'section_id'    => 1,
            'isActive'      => 1,
            'school_year'   => '2023-2024'
        ]);
       
        //HE student SECTION ID 2
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);

         //ict student SECTION ID 3/4
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

        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent5@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 3,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);
        
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent6@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 4,
            'isActive' => 1,
            'school_year'   => '2019-2020'
        ]);

        

        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent3@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 4,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);
        
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent4@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 4,
            'isActive' => 1,
            'school_year'   => '2019-2020'
        ]);


        // industrial arts (ia) student SECTION ID 5
        \App\Models\User::factory(1)->create([
            'email'         => 'iaStudent@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 4,
            'section_id'    => 5,
            'isActive' => 1,
            'school_year'   => '2023-2024'
        ]);

        // Students for approval 
        //ict student SECTION ID 3/4
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent7@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 3,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);

        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent9@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 3,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent10@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 4,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'ictStudent11@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 3,
            'section_id'    => 4,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);

        //he student for aproval
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent2@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent3@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent4@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'heStudent5@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'student',
            'subject_id'    => 2,
            'section_id'    => 2,
            'isActive' => '0',
            'school_year'   => '2023-2024'
        ]);

    }
}
