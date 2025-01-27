<?php

use Illuminate\Support\Facades\Route;

// Main Website Routes
Route::get('/', function () {
    return view('home');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/salons', function () {
    return view('salons');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
// Dashboard Routes
Route::get('/client-dashboard', function () {
    return view('dashboard');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/bookings', function () {
    return view('bookings');
});
