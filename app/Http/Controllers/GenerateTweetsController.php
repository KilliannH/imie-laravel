<?php


namespace App\Http\Controllers;


use App\Services\TweetService;
use Illuminate\Http\Request;

class GenerateTweetsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form () {
        return view('generate-tweets-form');
    }

    public function submit (Request $request) {

        $number = $request->get('number');
        $publishDate = $request->get('date');
        $service = new TweetService();
        $service->generateRandomTweets($number, $publishDate);
        return Redirect()->route('home')->with('status', 'Génération des tweets effectuée.');
    }
}