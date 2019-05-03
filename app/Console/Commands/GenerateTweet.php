<?php

namespace App\Console\Commands;

use App\Services\TweetService;
use Illuminate\Console\Command;
use Mikemike\Spinner\Spinner;

class GenerateTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for auto-generate tweet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $number = $this->ask('Nombre de tweets à générer ');

        if (!is_numeric($number)) {
            $this->error('Veuillez renseigner un nombre supérieur ou égal à 1.');
            return;
        } else if (intval($number) < 1) {
            $this->error('Veuillez renseigner un nombre suoérieur ou égal à 1.');
            return;
        }

        $service = new TweetService();
//        $service->generateRandomTweets($number, );

        $this->info($number . ' tweet(s) generated');

    }
}
