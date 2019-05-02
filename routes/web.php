<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/connect', 'AuthController@connect');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('email-register', 'Auth\LoginController@emailRegister');
Route::post('email-register-post', 'Auth\LoginController@emailRegisterPost')->name('email-register-post');
Route::post('post-new-tweet', 'TweetController@postTweet')->name('post-new-tweet');
// Route::post('post-tweet', 'TweetController@postTweet')->name('post-tweet');
<<<<<<< HEAD
Route::get('/home', 'DashboardController@index');
Route::get('/details/{id}', 'TweetDetailsController@index')->name('tweet-details');
=======
Route::get('/home', 'DashboardController@index')->name('home');

Route::get('generate-tweets', 'GenerateTweetsController@form')->name('generate-tweets-form');
Route::post('generate-tweets-post', 'GenerateTweetsController@submit')->name('generate-tweets-post');
>>>>>>> afdd8e2918c675413731242b4005c0d733e6400b
