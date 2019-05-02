<?php


namespace App\Http\Controllers;


class GenerateTweetsController extends Controller
{

    public function form () {
        return view('generate-tweets');
    }
}