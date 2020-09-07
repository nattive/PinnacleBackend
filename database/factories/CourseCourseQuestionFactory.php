<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseQuestion;
use Faker\Generator as Faker;

$factory->define(CourseQuestion::class, function (Faker $faker) {
    $str  = ['A','B', 'C', 'D'];

    return [
        'question' => $faker->realText(100),
        'course_materials_id' => function () {
            return App\CourseMaterials::where('id', random_int(1, 1000))->first()->id;
        },
        'optionA' => $faker->realText(50),
        'optionB' => $faker->realText(50),
        'optionC' => $faker->realText(50),
        'optionD' => $faker->realText(50),
        'answer' =>  $str[rand(0, 3)],
    ];
});
