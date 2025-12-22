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

Route::get('/login', [Authcontroller::class,'showLoginForm'])->name('login');
Route::get('/register', [Authcontroller::class,'showRegisterForm'])->name('register');

Route::post('/verify/register', [AuthController::class, 'register'])->name('verify.register');
Route::post('/verify/login', [AuthController::class, 'login'])->name('verify.login');
Route::post('/verify/logout', [Authcontroller::class,'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-price', [HomeController::class, 'getPrice'])->name('get.price');
Route::get('/find_ticket', fn() => view('user.find_ticket'))->name('find_ticket');

Route::middleware(['auth', 'customer'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    
    Route::get('/history', [HistoryController::class, 'history'])->name('history');
    Route::get('/history/{status}', [HistoryController::class, 'history'])
        ->name('history.status');

    Route::get('/book_ticket', fn() => view('user.book_ticket'))
        ->name('book_ticket')
        ->middleware(\App\Http\Middleware\EnsureProfileComplete::class);

    Route::post('/book_ticket/detail', [BookingController::class, 'detail'])
        ->name('book_ticket.detail');

    Route::get('/book_ticket/confirm', [BookingController::class, 'showPayment'])
        ->name('book_ticket.confirm');

    Route::post('/book_ticket/confirm', [BookingController::class, 'confirm'])
        ->name('book_ticket.confirm.payment');

    Route::post('/booking/cancel', [BookingController::class, 'cancel'])
        ->name('booking.cancel');

    Route::get('/book_ticket/download/{id}', [BookingController::class, 'downloadTicket'])
        ->name('book_ticket.download');

    Route::get('/user_detail', fn() => view('user.user_detail'))
        ->name('user_detail');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/', fn() => view('admin.dashboard.dashboard'))
        ->name('admin.dashboard');

    Route::get('/order-list', [BookingAdminController::class, 'index']);
    Route::get('/order-detail/{id}', [BookingAdminController::class, 'detail'])
        ->whereNumber('id');

    Route::get('/order/{id}/update-status-order', [BookingAdminController::class, 'update']);

    Route::get('/tiket', [TiketPriceController::class, 'index']);
    Route::post('/tiket/store', [TiketPriceController::class, 'store'])
        ->name('admin.tiket.store');

    Route::put('/tiket/update', [TiketPriceController::class, 'update'])
        ->name('admin.tiket.update');

    Route::delete('/tiket/delete', [TiketPriceController::class, 'destroy'])
        ->name('admin.tiket.delete');

    Route::get('/notification', fn() => view('admin.notification.index'));
});