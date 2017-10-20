<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Workshop::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence(5, true), 0, 50),
        //'number' => $faker->randomDigit,
        'number' => rand(101, 399),
        'abstract' => $faker->paragraph,
        //'level' => $faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
        'level_id' => rand(21,23),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
