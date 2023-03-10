<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\RegisterController;
use Modules\Auth\Http\Controllers\ResetPasswordController;
use Modules\Auth\Http\Middleware\AuthMiddleware;
use Modules\Auth\Http\Middleware\GuestMiddleware;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::group(['middleware' => [GuestMiddleware::class]], function () {
        Route::get('/login', [LoginController::class, 'index'])->name('loginPage');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/register', [RegisterController::class, 'index'])->name('registerPage');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->name('forgotPasswordPage');
        Route::post('/forgot-password', [ResetPasswordController::class, 'forgot'])->name('forgotPassword');
        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPage'])->name('resetPasswordPage');
        Route::post('/reset-password/{token}', [ResetPasswordController::class, 'reset'])->name('resetPassword');
    });

    Route::group(['middleware' => [AuthMiddleware::class]], function () {
        Route::get('/', function () {
            return Inertia::render('Auth::Welcome', [
                'logo' => config('ladmin.logo'),
                'user' => auth()->user(),
            ]);
        })->name('welcome');
    });

});
