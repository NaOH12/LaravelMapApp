<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'post_content' => $faker->sentence($nbWords = 20, $variableNbWords = true),
        // 'longitude' => $faker->randomFloat($nbMaxDecimals = 3, $min = -2.14, $max = -2.34),
        // 'latitude' => $faker->randomFloat($nbMaxDecimals = 3, $min = 51.766, $max = 51.966),
        'longitude' => 0,
        'latitude' => 0,
        'likes' => $faker->numberBetween(0, 50),
        'user_id' => App\User::inRandomOrder()->first()->id,
        'tile_id' => App\Tile::inRandomOrder()->first()->id,
        // 'tile_id' => 0,
    ];
});
