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

        $tweetSorted = [];

        foreach ($tweets as $tweet) {
            if (!$tweet->sent) {
                try {
                    // $date = new DateTime($tweet->publishDate);
                    Twitter::postTweet(
                        array(
                            'status' => $tweet->content,
                            'format' => 'json')
                    );

                    // $tweet->sent = 1;
                    // $tweet->save();
                    // echo 'Tweet publié: ' + $tweet->content;
                } catch (Exception $e) {
                    echo $e->getMessage();
                    // exit(1);
                }


                // if($date < $now) {
                //     array_push($tweetSorted, $tweet);

                //     $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);

                //     dd($data);
                // }
            }

        }
        // all tweets needed to be published
    }
}
