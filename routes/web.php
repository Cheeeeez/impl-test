<?php

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

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home.dashboard');
    })->name('home');
});

Route::get('/login/github', 'GithubAuthController@redirectLogin');
Route::get('/callback/github', 'GithubAuthController@handleCallback');
Route::get('/logout', 'GithubAuthController@logout')->name('logout');
