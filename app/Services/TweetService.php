<?php


namespace App\Services;


use App\Jobs\TweeterJob;
use App\Tweet;
use Illuminate\Support\Facades\Auth;
use Mikemike\Spinner\Spinner;

class TweetService
{

    public function createTweet($content, $publishDate) {

        $uid = Auth::id();

        $newTweet = Tweet::create([
            'content' => $content,
            'publishDate' => $publishDate,
            'sent' => false,
            'user_id' => $uid
        ]);

        $minutes = (strtotime($newTweet->publishDate) - time()) / 60;
        TweeterJob::dispatch($newTweet)->delay(now()->addMinutes($minutes));

    }

    public function getTweets() {
        $tweets = Tweet::all();
        return $tweets;
    }

    public function getTweet($id) {
        $tweet = Tweet::find($id)->first();

        if(!$tweet) {
            return null;
        }
        return $tweet;
    }

    public function editTweet($id, $editedTweet) {
        $tweet = Tweet::find($id)->first();
        if(!$tweet) {
            return null;
        }
        $tweet->content = $editedTweet->content;
        $tweet->publishDate = $editedTweet->publishDate;
        $tweet->sent = $editedTweet->sent;
        $tweet->tweet_id = $editedTweet->tweet_id;

        $tweet->save();
        return $tweet;
    }

    public function removeTweet($id) {
        $tweet = Tweet::find($id)->first();
        if(!$tweet) {
            return null;
        }
        $tweet->delete();
        return $tweet;
    }

    public function generateRandomTweets($number, $publishDate) {

        $spinner = new Spinner();
        $string = 'Hey {Marin|Alexis|Ayoub|Thomas|Elies|Kylliann}, why are you {working|fucking|eating|sitting|driving} ? Go into your {wife|house|car|cat|bedroom} now !';
        for ($i = 0; $i < $number; $i++) {
            $tweetContent = $spinner->process($string);
            $this->createTweet($tweetContent, $publishDate);
        }
    }
}