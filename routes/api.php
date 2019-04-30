<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/tweets', 'TweetController@getTweets');
Route::get('/tweets/{id}', 'TweetController@getTweet');

Route::post('/tweets', 'TweetController@postTweet');

Route::put('/tweets/{id}', 'TweetController@putTweet');

Route::delete('/tweets/{id}', 'TweetController@deleteTweet');