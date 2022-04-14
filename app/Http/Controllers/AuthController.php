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
        if(Auth::check()) return redirect()->route('profile');
        return view('login');
    }
    
    public function login(Request $request)
    {
        $auth = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($auth) {
            session()->regenerate();
            return redirect()->intended(route('profile'));
        }

        return redirect(route('login'))->withErrors([
            'credentials' => 'The provided credentials do not match our records.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}