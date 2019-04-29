<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function emailRegister(){
        return view('auth.email-register');
    }

    public function connect() {
        return view('auth.connect');
    }
}
