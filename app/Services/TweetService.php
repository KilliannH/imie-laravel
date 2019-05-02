<?php


namespace App\Services;


use App\Tweet;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mikemike\Spinner\Spinner;

class TweetService
{

    public function createTweet($content) {

        $uid = Auth::id();

        $tweet = Tweet::create([
            'content' => $content,
            'publishDate' => date('Y-m-d'),
            'sent' => false,
            'user_id' => $uid
        ]);

        return $tweet;
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

    public function generateRandomTweets($number) {

        $spinner = new Spinner();
        $string = 'Hey {Marin|Alexis|Ayoub|Thomas|Elies|Kylliann}, why are you {working|fucking|eating|sitting|driving} ? Go into your {wife|house|car|cat|bedroom} now !';
        for ($i = 0; $i < $number; $i++) {
            $tweetContent = $spinner->process($string);
            $this->createTweet($tweetContent);
        }
    }
}