<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\TestModel::factory(2)->create();
        // \App\Models\User::factory(15)->create();

        $this->call([
            SubjectSeeder::class,
            AdminSeeder::class,
            InstructorSeeder::class,
            SectionSeeder::class,
            StudentSeeder::class,
            QuizSeeder::class,
            QuizQuestionSeeder::class,
            QuizChoicesSeeder::class,
            WebPostSeeder::class,
            CommentSeeder::class,
            CarouselImageSeeder::class,
            WebAnalysysSeeder::class,
            GuestUserSeeder::class,
            SchoolYearSeeder::class,
            Instructor_Sections_Seeder::class,
        ]);
        
        
        
        


        //section factory
        //\App\Models\Section::factory(1)->create();
    }
}
