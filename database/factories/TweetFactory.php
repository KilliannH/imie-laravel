<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    global $isFuture;
    return [
        'content' => $faker->realText(),
        'publishDate' => $faker->dateTimeBetween($isFuture?"+1 week":"-1 week"),
        'tweet_id' => $isFuture ? null:$faker->unique()->randomNumber,
        'sent' => false,
        'user_id' => $faker->unique()->randomNumber,
    ];
});
