<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    global $isFuture;
    return [
        'content' => $faker->realText(),
        'publishDate' => $faker->dateTimeBetween($isFuture?"+1 week":"-1 week"),
        'tweet_id' => $isFuture ? null:$faker->randomDigitNotNull(),
        'boolean' => false,
        'user_id' => $faker->unique()->randomDigitNotNull(),
    ];
});
