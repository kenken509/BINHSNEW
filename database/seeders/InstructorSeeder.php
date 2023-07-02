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
        ]);

        //HE instructor
        \App\Models\User::factory(1)->create([
            
            'email'         => 'heInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 2,
        ]);
        //ict instructor
        \App\Models\User::factory(1)->create([
            'email'         => 'ictInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 3,
        ]);

        //industrial arts (ia) instructor
        \App\Models\User::factory(1)->create([
            
            'email'         => 'iaInstructor@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'instructor',
            'subject_id'    => 4,
        ]);
    }
}
