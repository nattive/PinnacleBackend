<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'title' => $faker-> word(),
        'isApproved' =>'true',
        'ApprovedBy' => $faker->name,
        'courseCode' => $faker-> uuid,
        'videoPath' => '2SrJ0xLQMDdC6DGq4ReMMJFnDMptTaFoWvS1arxQ.mp4',
        'sub_category_id' => function () {
            return App\SubCategory::where('id', random_int(1, 50))->first()->id;

        },
        'description' => $faker->realText(250),
        // 'videoOriginal_name' => $faker->name,
        'banner' => '1591828012.jpeg' ,
        'isPO' => $faker->boolean(),
        'isCareer' => $faker->boolean(),
        'isFree' => $faker->boolean(),
        'price' => 10000,
        'objective' => $faker-> realText(200),
        'tutor_id' => 1,
        'slug' => $faker-> slug(),
    ];
});
