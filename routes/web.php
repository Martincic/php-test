<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// PUBLIC ROUTES
Route::get('/', function () {
    return view('welcome');
});

// AUTH ROUTES
Route::controller(AuthController::class)->prefix('/auth')->group(function (Router $route): void {
	// GET
	$route->get('login', 'loginPrompt')->name('login');
	// $route->post('login', function () {
	// 	echo 123;
	// });
	$route->post('login', 'login')->name('post-login');
	
	$route->get('/logout', function () {
		Auth::logout();
		return redirect('/');
	})->name('logout');

});

// PROTECTED ROUTES
Route::middleware('auth')->group(function (Router $route): void {
	// GET
	$route->get('/home', function () {
		// dd(Auth::user());
		return view('home')->with(['user' => Auth::user()]);
	})->name('home');
	
	$route->get('/test', function () {
		return view('home')->with(['user' => Auth::user()]);
	})->name('test');
});
