<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/*Route Login */
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [Authcontroller::class,'login']);

Route::get('/register', fn() => view('auth.auth-register'))->name('register');
Route::get('/home', fn() => view('user.home'))->name('home');