<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function index()
    {
        return view('font.account.profile');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}


  