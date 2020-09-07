<?php

use Illuminate\Database\Seeder;
use bfinlay\SpreadsheetSeeder\SpreadsheetSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            SpreadsheetSeeder::class,
        ]);

        // $this->call(TutorsTableSeeder::class);
        // $this->call(TutorsTableSeeder::class);
        // $this->call(CoursesMaterialTableSeeder::class);
        // $this->call(CoursesModulesSeeder::class);
        // $this->call(CoursesTableSeeder::class);
        // $this->call(MainCategoryTableSeeder::class);
        // $this->call(CourseQuestionTableSeeder::class);
        // $this->call(MainCategoryTableSeeder::class);
    }
}
