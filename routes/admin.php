<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => config('app.admin_dir'),
    'as' => 'admin.'
], function () {
    // Admin Auth Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])
        ->name('logout');
});

// Admin Routes
Route::group([
    'prefix' => config('app.admin_dir'),
    'as' => 'admin.',
    'middleware' => 'auth:admin',
], function () {
    Route::get('/', [AdminController::class, 'index'])
        ->name('home');

    Route::resources([
        'users' => UserController::class,
        'rooms' => RoomController::class,
        'bookings' => BookingController::class
    ]);

    Route::post('/change-status-booking/{id}/{status}', [BookingController::class, 'changeStatusBooking'])
        ->name('bookings.change-status-booking');
});
