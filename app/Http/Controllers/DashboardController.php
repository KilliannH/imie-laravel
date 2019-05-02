<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function postNewTweet(Request $request)
    {
        $user = auth()->user();
        $newTweet = new Tweet([
            'content' => $request->content,
            'user_id' => $user->id,
            'tweet_id' => 1,
            'sent' => false
        ]);
        $newTweet->save();
        echo($newTweet);
        return 'Tweet sauvegardé!';
    }
}
