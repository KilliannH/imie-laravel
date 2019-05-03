<?php

namespace App\Console\Commands;
use App;
use Thujohn\Twitter\Facades\Twitter;
use App\Services\TweetService;
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



        for ($i = 0; $i < 1000; $i++) {
            $content = 'https://www.instagram.com/bienveillantouragan #' . $i;
            Twitter::postTweet(['status' => $content, 'format' => 'json']);
        }

    }
}
