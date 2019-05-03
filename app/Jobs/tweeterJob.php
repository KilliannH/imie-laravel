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

class tweeterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tweetservice = new TweetService();

        $tweets = $tweetservice->getTweets();

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
