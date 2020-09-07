<?php

use Illuminate\Database\Seeder;

class CourseQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseQuestion::class, 3000)->create();

    }
}
