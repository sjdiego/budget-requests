<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Budget;
use Faker\Generator as Faker;

$factory->define(
    Budget::class,
    function (Faker $faker) {
        return [
            'title' => $faker->text(30),
            'description' => $faker->realText(120),
            'status_id' => Budget::STATUS_PENDING,
            'user_id' => factory(\App\User::class),
            'category_id' => factory(\App\Category::class)
        ];
    }
);
