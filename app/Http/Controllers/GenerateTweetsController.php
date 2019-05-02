<?php


namespace App\Http\Controllers;


use App\Services\TweetService;
use Illuminate\Http\Request;

class GenerateTweetsController extends Controller
{

    public function form () {
        return view('generate-tweets-form');
    }

    public function submit (Request $request) {

        $number = $request->get('number');
        $service = new TweetService();
        $service->generateRandomTweets($number);
        return Redirect()->route('home')->with('status', 'Génération des tweets effectuée.');
    }
}