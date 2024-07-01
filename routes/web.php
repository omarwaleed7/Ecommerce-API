<?php

use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Google login
Route::controller(UserController::class)->group(function () {
    // Redirect to Google for authentication
    Route::get('login/google', 'redirectToGoogle')->name('login.google');

    // Google callback
    Route::get('login/google/callback', 'handleGoogleCallback');
});
