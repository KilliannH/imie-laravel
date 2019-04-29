<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function registerEmail(){
        return view('auth.register-email');
    }

    public function connect() {
        return view('auth.connect');
    }
}
