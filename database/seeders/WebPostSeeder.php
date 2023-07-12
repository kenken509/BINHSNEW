<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WebPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        \App\Models\WebPost::factory(1)->create([
            'author_id' => 1,
            'subject_id' => 3,
            'title'     => 'Latest Post',
            'content'   => $faker->realText(200,2),
            'status'    => 'pending', //experimental
        ]);

        \App\Models\WebPost::factory(1)->create([
            'author_id' => 2,
            'subject_id' => 3,
            'title'     => 'Latest Post',
            'content'   => $faker->realText(200,2),
            'status'    => 'pending', //experimental
        ]);
    }
}
