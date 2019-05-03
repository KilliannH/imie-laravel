<?php

namespace App\Jobs;

use App\Services\TweetService;
use App\Tweet;
use DateTime;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Thujohn\Twitter\Facades\Twitter;

class TweeterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // make tweets from json works here
        $user = $this->tweet->user()->first();

//        $tw = new Twitter();
        Twitter::reconfig(
            [
                'token' => $user->token,
                'secret' => $user->token_secret
            ]
        );
        $ts = new TweetService();
        $tweets = $ts->getTweets();
        $now = new DateTime();
        foreach ($tweets as $tweet) {
            if (!$tweet->sent) {
                if($tweet->publishDate < $now) {
                    try {
                        Twitter::postTweet(
                            array(
                                'status' => $tweet->content,
                                'format' => 'json')
                        );
                        $tweet->sent = true;
                        $tweet->save();
                        // echo 'Tweet publié: ' + $tweet->content;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        // exit(1);
                    }
                }
            }
        }
    }
}