<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    private $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function getTweets() {
        return $this->tweetService->getTweets();
    }

    public function getTweet($id) {
        return $this->tweetService->getTweet($id);
    }

    public function  postTweet(Request $request) {
        return $this->tweetService->postTweet($request);
    }

    public function  putTweet(Request $request, $id) {
        return $this->tweetService->putTweet($request, $id);
    }

    public function deleteTweet($id) {
        return $this->tweetService->deleteTweet($id);
    }
}
