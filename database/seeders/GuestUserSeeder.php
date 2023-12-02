<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        \App\Models\User::factory(1)->create([
            'email'         => 'guest1@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest2@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest3@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest4@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest5@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest6@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest7@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest8@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest9@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
        \App\Models\User::factory(1)->create([
            'email'         => 'guest10@gmail.com',
            'phoneNumber'   => '639191234567',
            'role'          => 'guest',
            'isActive' => 1,
        ]);
    }
}
