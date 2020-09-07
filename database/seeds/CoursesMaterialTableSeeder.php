<?php

use Illuminate\Database\Seeder;

class CoursesMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseMaterials::class, 1000)->create();

    }
}
