<?php


namespace App\Services;


use App\Tweet;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Mikemike\Spinner\Spinner;

class TweetService
{

    public function createTweet($content, $publishDate) {

        // considering we only use twitter for login
        $provider = 'twitter';
        $connectedUser = Socialite::driver($provider)->user();
        $user = User::find($connectedUser->id);

        $tweet = Tweet::create([
            'content' => $content,
            'publishDate' => $publishDate,
            'sent' => false,
            'user_id' => 'test'
        ]);

        if(!$user) {
            return null;
        }

       /* $tweet->user()->associate($user);
        $tweet->save();*/
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

    public static function generateRandomTweets($number) {

        $spinner = new Spinner();
        $string = 'Hey {Marin|Alexis|Ayoub|Thomas|Elies}, why are you {working|fucking|eating|sitting|driving} ? Go into your {wife|house|car|cat|bedroom} now !';

        $tweets = array();
        for ($i = 0; $i < $number; $i++) {
            $tweetContent = $spinner->process($string);
            $tweets[] = $tweetContent;
        }
        return $tweets;
    }
}