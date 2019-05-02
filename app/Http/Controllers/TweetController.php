<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TweetController extends Controller
{
    private $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function getTweets() {
        $tweets = $this->tweetService->getTweets();
        $response = ['tweets' => $tweets];

        return response()->json($response, 200);
    }

    public function getTweet($id) {
        $tweet = $this->tweetService->getTweet($id);
        if(!$tweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $response = ['tweet' => $tweet];
        return response()->json($response, 200);
    }

    // we do not use the service here
    // you cannot post if you're not authenticated
    public function postTweet(Request $request) {
        dd($request);
        $newTweet = new Tweet();
        $newTweet->content = $request->input('content');
        $newTweet->publishDate = $request->input('publishDate');
        $newTweet->sent = false;

        $provider = 'twitter';
        $connectedUser = Socialite::driver($provider)->user();

        $user = User::find($connectedUser->id);

        if(!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $newTweet->user()->associate($user);
        $newTweet->save();
        return response()->json(['tweet' => $newTweet], 201);
    }

    // neither here
    public function putTweet(Request $request, $id) {
        $editedTweet = Tweet::find($id)->first();
        if(!$editedTweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $editedTweet->content = $request->input('content');
        $editedTweet->publishDate = $request->input('publishDate');
        $editedTweet->sent = $request->input('sent');
        $editedTweet->tweet_id = $request->input('tweet_id');

        $editedTweet->save();
        return response()->json(['tweet' => $editedTweet], 200);
    }

    public function deleteTweet($id) {
        $deletedTweet = $this->tweetService->removeTweet($id);
        if(!$deletedTweet) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        return response()->json(['message' => 'Tweet deleted'], 200);
    }
}
