<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(),
        'publishDate' => $faker->dateTimeBetween("-1 week"),
        'tweet_id' => $faker->unique()->randomNumber,
        'sent' => false,
        'user_id' => $faker->unique()->randomNumber,
    ];
});
