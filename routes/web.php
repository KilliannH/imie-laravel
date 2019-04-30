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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/connect', 'AuthController@connect');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('email-register', 'Auth\RegisterController@emailRegister');
Route::post('email-register-post', 'Auth\RegisterController@emailRegisterPost')->name('email-register-post');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
