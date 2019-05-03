<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use App\Tweet;
use Illuminate\Http\Request;
use App\Jobs\TweeterJob;

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

    public function postTweet(Request $request) {
        $user = auth()->user();
        $content = $request->get('content');
        $publishDate = $request->get('date');

		$newTweet = new Tweet([
			'content' => $content,
            'publishDate' => $publishDate,
            'sent' => false
        ]);

        $newTweet->user()->associate($user);
        $newTweet->save();

        $minutes = (strtotime($newTweet->publishDate) - time()) / 60;
        TweeterJob::dispatch($newTweet)->delay(now()->addMinutes($minutes));

        return redirect()->route('tweet-details', $newTweet->id);
    }

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
