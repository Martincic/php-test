<?php

namespace App\Http\Controllers;

use App\Util\QApiHandler;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $handler = new QApiHandler(Auth::user());
        dd($handler);
    }
}
