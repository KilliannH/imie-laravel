<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Tweet;
use Laravel\Socialite\Facades\Socialite;

class TweetService
{

    public function postTweet(Request $request) {
        $tweet = new Tweet();
        $tweet->content = $request->input('content');
        $tweet->publishDate = $request->input('publishDate');
        $tweet->sent = false;

        // considering we only use twitter for login
        $provider = 'twitter';
        $connectedUser = Socialite::driver($provider)->user();

        $user = User::find($connectedUser->id);

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $tweet->user()->associate($user);
        $tweet->save();
        return response()->json(['tweet' => $tweet], 201);
    }

    public function getTweets() {
        $tweets = Tweet::all();
        $response = ['tweets' => $tweets];

        return response()->json($response, 200);
    }

    public function getTweet($id) {
        $tweet = Tweet::find($id)->first();

        if(!$tweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $response = ['tweet' => $tweet];
        return response()->json($response, 200);
    }

    public function putTweet(Request $request, $id) {
        $tweet = Tweet::find($id)->first();
        if(!$tweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $tweet->content = $request->input('content');
        $tweet->publishDate = $request->input('publishDate');
        $tweet->sent = $request->input('sent');
        $tweet->tweet_id = $request->input('tweet_id');

        $tweet->save();
        return response()->json(['tweet' => $tweet], 200);
    }

    public function deleteTweet($id) {
        $tweet = Tweet::find($id)->first();
        if(!$tweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $tweet->delete();
        return response()->json(['message' => 'Tweet deleted'], 200);
    }
}