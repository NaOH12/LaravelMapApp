<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SessionLog;
use Faker\Generator as Faker;

$factory->define(SessionLog::class, function (Faker $faker) {
    return [
        'logged_in' => $faker->dateTimeBetween('2018-01-01', '2020-07-20'),
        'logged_out' => $faker->dateTimeBetween('2018-01-01', '2020-07-20'),
        'user_id' => App\User::inRandomOrder()->first()->id,
    ];
});
