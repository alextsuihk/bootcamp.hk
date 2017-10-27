<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Lesson::class, function (Faker $faker) {
    return [
        'course_id' => rand(1,5),
        'sequence' => 1,
        'active' => $faker->boolean(75),
        'venue' => $faker->streetName(),
        'instructor' => $faker->firstName(),
        'teaching_language_id' => rand(1,2),
        'first_day' => $faker->dateTimeInInterval($startDate = '+1 weeks', $interval = '+ 20 days'),
        'last_day' => $faker->dateTimeInInterval($startDate = '+5 weeks', $interval = '+ 20 days'),
        'schedule' => 'Every Sat 1-5pm',
        'quota' => rand(10,25),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});


