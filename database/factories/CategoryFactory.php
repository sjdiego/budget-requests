<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(
    Category::class,
    function (Faker $faker) {
        $name = $faker->domainWord;
        return [
            'name' => $name,
            'description' => $faker->realText(30),
            'slug' => \Illuminate\Support\Str::slug($name)
        ];
    }
);
