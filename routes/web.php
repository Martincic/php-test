<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Router;
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

// ROUTES
Route::controller(AuthController::class)->prefix('/')->group(function (Router $route): void {
	// GET
    $route->get('', 'index')->name('welcome');
	$route->get('/login', 'login-prompt')->name('login-prompt');
	$route->post('/login', 'login')->name('login');
});
