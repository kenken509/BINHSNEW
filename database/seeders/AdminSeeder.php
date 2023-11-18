<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ****** USERS TABLE ***********

        \App\Models\User::factory(1)->create([
            'fName' => 'aries',
            'email' => 'admin@gmail.com',
            'phoneNumber' => '639191234567',
            'isActive' => 1,
        ]);

        
       
        // ****** USERS TABLE ***********
    }
}
