<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
    	return view('login.home');
    }
}
