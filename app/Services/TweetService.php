<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Tweet;
use Laravel\Socialite\Facades\Socialite;

class TweetService
{

    public function createTweet($newTweet) {
        $tweet = new Tweet();
        $tweet->content = $newTweet->content;
        $tweet->publishDate = $newTweet->publishDate;
        $tweet->sent = false;

        // considering we only use twitter for login
        $provider = 'twitter';
        $connectedUser = Socialite::driver($provider)->user();

        $user = User::find($connectedUser->id);

        if(!$user) {
            return null;
        }

        $tweet->user()->associate($user);
        $tweet->save();
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
}