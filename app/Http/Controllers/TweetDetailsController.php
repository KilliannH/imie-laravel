<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use DateTime;
use Illuminate\Http\Request;

class TweetDetailsController extends Controller
{
    private $tweetservice;
    public function __construct(TweetService $tweetservice)
    {
        $this->middleware('auth');
        $this->tweetservice = $tweetservice;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = $request->route('id');
        $tweet = $this->tweetservice->getTweet($id);
        $now = new DateTime();

        return view('tweet-details', ['tweet' => $tweet, 'now' => $now]);
    }
}
