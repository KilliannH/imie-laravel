<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TweetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        // Create Tweets
        return factory(App\Tweet::class, 80)->make()->each(function($tweet) use($faker) {

            $rand = rand(0, 1);

            if($rand == 0) {
                $datesRange = [null, '-1 week'];
            } else {
                $datesRange = ['+1 week', '+1 month'];
            }

            $tweet["publishDate"] = $faker->dateTimeBetween($datesRange[0], $datesRange[1]);
            $tweet->save();
        });
    }
}
