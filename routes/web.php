<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
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
	$route->get('/logout', 'logout')->name('logout');

	// POST
	$route->post('login', 'login')->name('post-login');	
});

// PROTECTED ROUTES
Route::middleware('auth')->group(function (Router $route): void {
	
	// BOOK ROUTES
	$route->prefix('/books')->name('books.')->controller(BookController::class)->group(function (Router $route): void {
		// GET
		$route->get('', 'index')->name('list');
		$route->get('create', 'create')->name('create');
		$route->get('{book_id}', 'single')->name('single');
		
		// POST
		$route->post('', 'store')->name('store');
		
		// PUT
		$route->put('{book_id}', 'update')->name('update');
		
		// DELETE
		$route->delete('{book_id}', 'delete')->name('delete');
	});

	// AUTHOR ROUTES
	$route->prefix('/authors')->name('authors.')->controller(AuthorController::class)->group(function (Router $route): void {
		// GET
		$route->get('', 'index')->name('list');
		$route->get('{author_id}', 'single')->name('single');
		
		// DELETE
		$route->delete('{author_id}', 'delete')->name('delete');
	});
	
	$route->get('/profile', function () {
		return view('home')->with(['user' => Auth::user()]);
	})->name('profile');
});
