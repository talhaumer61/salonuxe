<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\RedirectAuthenticatedUser;
use App\Http\Middleware\CheckAuthentication;
use App\Http\Middleware\ClientVerification;
use Illuminate\Support\Facades\Route;

// Main Website Routes
Route::get('/', [SiteController::class, 'home']);
Route::get('/services', [SiteController::class, 'services']);
Route::get('/salons', [SiteController::class, 'salons']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);

// Routes Accessible Only to Guests (Prevent Logged-in Users from Accessing Login/Signup)
Route::middleware([RedirectAuthenticatedUser::class])->group(function () {
    Route::get('/login', [SiteController::class, 'login'])->name('login');
    
    // Client & Salon Login
    Route::post('/login', [SiteController::class, 'user_login'])->name('userLogin');
    
    Route::get('/signup', [SiteController::class, 'signup']);
    Route::post('/signup', [ClientController::class, 'signup'])->name('clientSignup');

    Route::post('/check-availability', [siteController::class, 'checkAvailability'])->name('checkAvailability');
});

// Routes Accessible Only to Logged-in Users (Protected Routes)
Route::middleware([CheckAuthentication::class])->group(function () {
    // Routes Accessible Only to Clients (login_type = 2)
    Route::middleware([ClientVerification::class])->group(function () {
        Route::get('/client-dashboard', [ClientController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ClientController::class, 'profile']);
    });
    
    
    Route::get('/logout', [SiteController::class, 'logout'])->name('logout');
});
