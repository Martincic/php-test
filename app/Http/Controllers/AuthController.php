<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        dump(Auth::login(new User([
            'email' => 'ahsoka.tano@q.agency',
            'password' => 'Kryze4President',
            'test' => 1234,
            'bool' => true,
            'object' => null
        ])));

        dump(Auth::user());

        
        dd();



        return view('welcome');
    }
}