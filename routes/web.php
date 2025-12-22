<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AdminController\TiketPriceController;
use App\Http\Controllers\AdminController\BookingAdminController;

Route::get('/login', fn() => view('auth.login'))->name('login');
// Route::post('/firebase/logout', [Authcontroller::class,'logout'])->name('logout');
/*Route Login */
Route::get('/login', [Authcontroller::class,'showLoginForm'])->name('login');
Route::get('/register', [Authcontroller::class,'showRegisterForm'])->name('register');
Route::post('/verify/logout', [Authcontroller::class,'logout'])->name('logout');
Route::post('/Verify/register', [AuthController::class, 'register'])->name('verify.register');
Route::post('/verify/verify', [AuthController::class, 'login'])->name('verify.login');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-price', [HomeController::class, 'getPrice'])->name('get.price');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/history', [HistoryController::class, 'history'])->name('history');
    Route::get('/history/{status}', [HistoryController::class, 'history'])
    ->name('history.status');

});

Route::get('/find_ticket', fn() => view('user.find_ticket'))->name('find_ticket');

Route::get('/book_ticket', fn() => view('user.book_ticket'))
    ->name('book_ticket')
    ->middleware(['auth', \App\Http\Middleware\EnsureProfileComplete::class]);
Route::post('/book_ticket/detail', [BookingController::class, 'detail'])->name('book_ticket.detail');
// Route::post('/book_ticket/confirm', [App\Http\Controllers\BookingController::class, 'confirm'])->name('book_ticket.confirm');
Route::get('/book_ticket/confirm', [BookingController::class, 'showPayment'])
    ->name('book_ticket.confirm');
Route::post('/book_ticket/confirm', [BookingController::class, 'confirm'])
    ->name('book_ticket.confirm.payment');

Route::post('/booking/cancel', [BookingController::class, 'cancel'])
    ->name('booking.cancel');

Route::get('/book_ticket/download/{id}', [App\Http\Controllers\BookingController::class, 'downloadTicket'])
    ->name('book_ticket.download')
    ->middleware(['auth', \App\Http\Middleware\EnsureProfileComplete::class]);

Route::get('/user_detail', fn() => view('user.user_detail'))->name('user_detail');



//AdminController

Route::get('/admin', function () {
    return view('admin.dashboard.dashboard');
});
Route::get('/admin/order-list', [BookingAdminController::class, 'index']);
Route::get('/admin/order-detail/{id}', [BookingAdminController::class, 'detail'])->whereNumber('id');
Route::get('/admin/order/{id}/update-status-order', [BookingAdminController::class, 'update']);

Route::get('/admin/tiket', [TiketPriceController::class, 'index']);
Route::post('/admin/tiket/store', [TiketPriceController::class, 'store'])
    ->name('admin.tiket.store');
Route::put('/admin/tiket/update', [TiketPriceController::class, 'update'])
    ->name('admin.tiket.update');
Route::delete('/admin/tiket/delete', [TiketPriceController::class, 'destroy'])
    ->name('admin.tiket.delete');

Route::get('/admin/notification', function () {
    return view('admin.notification.index');
});
