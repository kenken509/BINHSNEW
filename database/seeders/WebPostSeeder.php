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
            'author_id' => 4,
            'subject_id' => 3,
            'title'     => 'Latest Post',
            'content'   => $faker->realText(200,2),
            'status'    => 'active', //experimental
        ]);

        \App\Models\WebPost::factory(1)->create([
            'author_id' => 4,
            'subject_id' => 3,
            'title'     => 'New Post',
            'content'   => $faker->realText(200,2),
            'status'    => 'active', //experimental
        ]);
    }
}
