<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //agri-fishery arts (afa) instructor
         \App\Models\User::factory(1)->create([
            'email'         => 'afaInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 1,
            'isActive' => 1,
        ]);

        //HE instructor
        \App\Models\User::factory(1)->create([
            
            'email'         => 'heInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 2,
            'isActive' => 1,
        ]);
        //ict instructor
        \App\Models\User::factory(1)->create([
            'email'         => 'ictInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 3,
            'isActive' => 1,
        ]);

        //ict instructor
        \App\Models\User::factory(1)->create([
            'email'         => 'ictInstructor2@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 3,
            'isActive' => 1,
        ]);

        //ict instructor
        \App\Models\User::factory(1)->create([
            'email'         => 'ictInstructor3@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 3,
            'isActive' => 1,
        ]);

        //industrial arts (ia) instructor
        \App\Models\User::factory(1)->create([
            
            'email'         => 'iaInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 4,
            'isActive' => 1,
        ]);
    }
}
