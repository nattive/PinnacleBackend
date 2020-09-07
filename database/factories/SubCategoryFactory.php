<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubCategory;
use Faker\Generator as Faker;

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'main_category_id' => function () {
            return factory(App\MainCategory::class)->create()->id;
        }
    ];
});
