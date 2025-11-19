<?php

use App\Http\Controllers\Authcontroller;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('user.home');
// });
/*Route Login */
Route::get('/login', fn() => view('auth.login'))->name('login');
<<<<<<< Updated upstream
Route::post('/login', [Authcontroller::class,'login']);

Route::get('/register', fn() => view('auth.auth-register'))->name('register');
Route::get('/home', fn() => view('user.home'))->name('home');
=======
Route::post('/firebase/logout', [Authcontroller::class,'logout'])->name('logout');
Route::post('/login', [Authcontroller::class,'login']);
Route::post('/firebase/register', [AuthController::class, 'register'])->name('firebase.register');
Route::post('/firebase/verify', [AuthController::class, 'verifyFirebase'])->name('firebase.verify');


Route::get('/register', fn() => view('auth.auth-register'))->name('register');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-price', [HomeController::class, 'getPrice'])->name('get.price');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile/update/{id}', [ProfileController::class, 'updateorcreate'])->name('profile.update');
    Route::get('/book_ticket', fn() => view('user.book_ticket'))->name('book_ticket');
});
>>>>>>> Stashed changes

Route::get('/find_ticket',[TicketController::class,'find_ticket'])->name('find_ticket');


<<<<<<< Updated upstream
Route::get('/book_ticket', fn() => view('user.book_ticket'))->name('book_ticket');

Route::get('/user_detail', fn() => view('user.user_detail'))->name('user_detail');

=======
Route::post('/book_ticket/confirm', [App\Http\Controllers\BookingController::class, 'confirm'])->name('book_ticket.confirm');

Route::get('/user_detail', fn() => view('user.user_detail'))->name('user_detail');



// Route::get('/home', [HomeController::class, 'index'])->name('home');


>>>>>>> Stashed changes

