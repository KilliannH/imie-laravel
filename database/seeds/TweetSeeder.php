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
        factory(App\User::class, 1)->create()->each(function($user){
            factory(App\Tweet::class, 3)->create(['user_id'=>$user['id']]);
        });
    }
}