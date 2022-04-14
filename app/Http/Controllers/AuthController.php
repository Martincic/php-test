<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function loginPrompt()
    {
        return view('login');
    }
    
    public function login(Request $request)
    {
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        
		return redirect()->intended(route('home'));
    }
}