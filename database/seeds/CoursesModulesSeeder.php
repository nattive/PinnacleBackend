<?php

use Illuminate\Database\Seeder;

class CoursesModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseModule::class, 500)->create();
    }
}
