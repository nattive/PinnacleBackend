<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseMaterials;
use Faker\Generator as Faker;

$factory->define(CourseMaterials::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(10),
        'course_module_id' =>  function () {
            return App\CourseModule::where('id', random_int(1, 50))->first()->id;
        },
        'text' => $faker->realText(500),
        'quiz' => $faker->word(),
        'objective' => $faker->realText(300),
        'prerequisite' => $faker->realText(),
        'sourceIsYouTube' => $faker->word(),
        'sourceIsServer' => $faker->word(),
        'videoPath' => '0RUE2RzBSdfHbi5rwt3HDnfZNLJbi5pbnSrm29lV.mp4',
        'images' => '1590791505.jpeg',
    ];
});
