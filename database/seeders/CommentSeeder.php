<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        \App\Models\Comment::factory(1)->create([
            'web_post_id' => 1,
            'user_id'     => 1,
            'content'     => $faker->realText(200,2),
            'status'      => 'private',
        ]);
        \App\Models\Comment::factory(1)->create([
            'web_post_id' => 1,
            'user_id'     => 1,
            'content'     => $faker->realText(200,2),
            'status'      => 'private',
        ]);
        \App\Models\Comment::factory(1)->create([
            'web_post_id' => 1,
            'user_id'     => 1,
            'content'     => $faker->realText(200,2),
            'status'      => 'private',
        ]);
    }
}
