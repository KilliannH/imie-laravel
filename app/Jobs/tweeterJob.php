<?php

namespace App\Jobs;

use App\Services\TweetService;
use DateTime;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Thujohn\Twitter\Facades\Twitter;
use App\Services\TweetService;
use DateTime;

class TweeterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // make tweets from json works here
        $user = $this->user;
        $tw = new Twitter();
        $tw = Twitter::reconfig(
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
<<<<<<< HEAD
                        dd($tw, $user);
                        $tw->postTweet(
=======
                        Twitter::postTweet(
>>>>>>> 74abd7130f4d625a64293192f1cfde7a20054884
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
