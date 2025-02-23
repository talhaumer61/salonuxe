<?php

use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\AdminVerification;
use App\Http\Middleware\RedirectAuthenticatedUser;
use App\Http\Middleware\CheckAuthentication;
use App\Http\Middleware\ClientVerification;
use App\Http\Middleware\SalonVerification;
use Illuminate\Support\Facades\Route;

// Main Website Routes
Route::get('/', [SiteController::class, 'home']);
Route::get('/services', [SiteController::class, 'services']);
Route::get('/salons', [SiteController::class, 'salons']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);

// Routes Accessible Only to Guests (Prevent Logged-in Users from Accessing Login/Signup)
Route::middleware([RedirectAuthenticatedUser::class])->group(function () {
    Route::get('/admin-login', [AdminController::class, 'adminLogin']);
    Route::post('/admin-login', [AdminController::class, 'login'])->name('adminLogin');
    
    // Client & Salon Login
    Route::post('/login', [SiteController::class, 'user_login'])->name('userLogin');
    
    // Salon Signup
    Route::get('/register-salon', [SiteController::class, 'regiter_salon']);
    Route::post('/salon-signup', [SalonController::class, 'signup'])->name('salonSignup');


    // Client Signup 
    Route::post('/signup', [ClientController::class, 'signup'])->name('clientSignup');

    Route::post('/check-availability', [siteController::class, 'checkAvailability'])->name('checkAvailability');
});

// Routes Accessible Only to Admin (login_type = 1)
Route::middleware([AdminVerification::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin-profile', [AdminController::class, 'profile']);
    Route::get('/appointments', [AdminController::class, 'appointments']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/service-types/{action?}/{href?}', [ServicesController::class, 'service_types'])->name('service_types');

    Route::post('/service-types/add', [ServicesController::class, 'add_service_type'])->name('service_types.add');
    Route::put('/service-types/update/{href}', [ServicesController::class, 'edit_service_type'])->name('service_types.update');

    Route::post('/delete-record', [DatabaseController::class, 'deleteRecord'])->name('delete.record');

});

// Routes Accessible Only to Logged-in Users (Protected Routes)
Route::middleware([CheckAuthentication::class])->group(function () {
    // Routes Accessible Only to Clients (login_type = 2)
    Route::middleware([ClientVerification::class])->group(function () {
        Route::get('/client-dashboard', [ClientController::class, 'index'])->name('clientDashboard');
        Route::get('/profile', [ClientController::class, 'profile']);
        Route::get('/bookings', [ClientController::class, 'bookings']);
    });
    // Routes Accessible Only to Clients (login_type = 3)
    Route::middleware([SalonVerification::class])->group(function () {
        Route::get('/salon-dashboard', [SalonController::class, 'index'])->name('salonDashboard');
        Route::get('/profile', [SalonController::class, 'profile']);
        Route::get('/salon-profile', [SalonController::class, 'salon_profile']);
        Route::post('/salon/add', [SalonController::class, 'addSalon'])->name('add.salon'); // Add new salon
        Route::put('/salon/update', [SalonController::class, 'updateSalon'])->name('update.salon'); // Update existing salon

        Route::get('/bookings', [SalonController::class, 'bookings']);
    });
    
    
    Route::get('/logout', [SiteController::class, 'logout'])->name('logout');
});
