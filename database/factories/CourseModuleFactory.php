<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseModule;
use Faker\Generator as Faker;

$factory->define(CourseModule::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'course_id' => function () {
            return factory(App\Course::class)->create()->id;
        },


    ];
});
