<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    include(__DIR__ . "/../../resources/assets/pornWord.php");
    include(__DIR__ . "/../../resources/assets/name.php");
    $content = $names[array_rand($names)]." is fapping on ".$pornWords[array_rand($pornWords)];
    return [
        'content' => $content,
        'publishDate' => $faker->dateTimeBetween("-1 week"),
        'tweet_id' => $faker->unique()->randomNumber,
        'sent' => false,
        'user_id' => 0
    ];
});
