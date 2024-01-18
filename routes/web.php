<?php

use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegistrationController;
use App\Http\Controllers\User\UserController;
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

Route::group([
    'as' => 'auth.'
], function () {
    // Auth Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])
        ->name('logout');

    // Register
    Route::get('register', [RegistrationController::class, 'showRegisterForm'])
        ->name('register');
    Route::post('register', [RegistrationController::class, 'register']);
    Route::get('register/verification/{token}', [RegistrationController::class, 'showVerifyForm'])
        ->name('verify');

    // Forgot Password
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
        ->name('forgot_password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::get('forgot-password/reset/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])
        ->name('forgot_password.reset');
    Route::post('forgot-password/reset/{token}', [ForgotPasswordController::class, 'resetPassword']);
});

// User Routes
Route::group([
    'as' => 'user.',
    'middleware' => 'auth:web',
], function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('home');
    Route::post('/booking-room', [UserController::class, 'bookingRoom'])
        ->name('booking_room');
    Route::get('/bookings', [UserController::class, 'bookings'])
        ->name('bookings');
});
