<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});
/*Route Login */
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/firebase/logout', [Authcontroller::class,'logout'])->name('logout');

Route::get('/register', fn() => view('auth.auth-register'))->name('register');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/get-price', [HomeController::class, 'getPrice'])->name('get.price');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update/{id}', [ProfileController::class, 'updateorcreate'])->name('profile.update');
});

Route::get('/find_ticket', fn() => view('user.find_ticket'))->name('find_ticket');

Route::get('/book_ticket', fn() => view('user.book_ticket'))->name('book_ticket');
Route::post('/book_ticket/confirm', [App\Http\Controllers\BookingController::class, 'confirm'])->name('book_ticket.confirm');

Route::get('/user_detail', fn() => view('user.user_detail'))->name('user_detail');

Route::post('/login', [Authcontroller::class,'login']);
Route::post('/firebase/register', [AuthController::class, 'register'])->name('firebase.register');
Route::post('/firebase/verify', [AuthController::class, 'verifyFirebase'])->name('firebase.verify');


// Route::get('/home', [HomeController::class, 'index'])->name('home');