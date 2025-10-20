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

Route::get('/find_ticket', fn() => view('user.find_ticket'))->name('find_ticket');

Route::get('/book_ticket', fn() => view('user.book_ticket'))->name('book_ticket');

Route::get('/user_detail', fn() => view('user.user_detail'))->name('user_detail');
Route::post('/firebase/register', [AuthController::class, 'register'])->name('firebase.register');
Route::post('/firebase/verify', [AuthController::class, 'verifyFirebase'])->name('firebase.verify');


