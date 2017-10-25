<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Lesson::class, function (Faker $faker) {
    return [
        'course_id' => 1,
        'sequence' => 1,
        'enrollable' => true,
        'instructor' => 'Alex',
        'language_id' => rand(1,2),
        'venue' => 'TBD',
        'first_day' => '2017-10-01',
        'last_day' => '2017-10-30',
        'schedule' => 'Every Sat 1-5pm',
        'quota' => 20,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});


