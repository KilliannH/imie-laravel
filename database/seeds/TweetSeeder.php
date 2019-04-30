<?php

use Illuminate\Database\Seeder;

class TweetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Tweets
        return factory(App\Tweet::class, 80)->create(['isFuture' => true]);
    }
}
