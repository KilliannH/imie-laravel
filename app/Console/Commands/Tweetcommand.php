<?php

namespace App\Console\Commands;
use App;
use Twitter;
use App\Services\TweetService;
use DateTime;
use Exception;
use Illuminate\Console\Command;

class Tweetcommand extends Command
{
    private $tweetService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweetcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Tweets and send them';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TweetService $tweetService)
    {
        parent::__construct();

        $this->tweetService = $tweetService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // make tweets from json works here

        $tweets = $this->tweetService->getTweets();

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
