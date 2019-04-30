<?php

namespace App\Console\Commands;
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
    protected $signature = 'Tweetcommand';

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
        $tweets = $this->tweetService->getTweets();
    }
}
