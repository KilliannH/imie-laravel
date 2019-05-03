<?php

namespace App\Http\Controllers;

use App\Services\TweetService;
use DateTime;

class DashboardController extends Controller
{
    private $tweetservice;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
    public function index()
    {
        $tweets = $this->tweetservice->getTweets();
        $now = new DateTime();
        return view('home', ['tweets' => $tweets, 'now' => $now]);
    }
}
