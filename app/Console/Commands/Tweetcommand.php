<?php

namespace App\Console\Commands;
use App;
use Thujohn\Twitter\Facades\Twitter;
use App\Services\TweetService;
use DateTime;
use Exception;
use Illuminate\Console\Command;

class Tweetcommand extends Command
{
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
    public function __construct()
    {   
        parent::__construct();
        Twitter::reconfig(['token' => '1108600526-99WKqQUKy8YcUWADCR1E3ptpOaXF3851dUMR148', 'secret' => 'ViM4HySAvTTxlVAiPFwnTsYEuqaT2y1qzs2ySQSmDRV1t']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // make tweets from json works here

        $service = new TweetService();
        $tweets = $service->getTweets();

        $now = new DateTime();

        $tweetSorted = [];

        foreach ($tweets as $tweet) {
            if (!$tweet->sent) {

                try {
                    $date = new DateTime($tweet->publishDate);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit(1);
                }

                if($date < $now) {
                    array_push($tweetSorted, $tweet);

                    $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
                    
                    dd($data);
                }
            }
        }
        dd($tweetSorted);
        // all tweets needed to be published 
    }
}
