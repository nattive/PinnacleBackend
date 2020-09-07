<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Tutor;
use Faker\Generator as Faker;

$factory->define(Tutor::class, function (Faker $faker) {
    return [
        'isCotF_tutor' => $faker->boolean(),
        'isPO_tutor' => $faker->boolean(),
        'isActive' => $faker->boolean(),
        'name' => $faker->name(),
        'rating' => $faker->realText(),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
