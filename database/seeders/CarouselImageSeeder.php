<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarouselImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CarouselImageModel::factory(1)->create([
            'filename' => 'Images/carousel1.jpg'
        ]);
        \App\Models\CarouselImageModel::factory(1)->create([
            'filename' => 'Images/carousel2.jpg'
        ]);
        \App\Models\CarouselImageModel::factory(1)->create([
            'filename' => 'Images/carousel3.png'
        ]);
    }
}
