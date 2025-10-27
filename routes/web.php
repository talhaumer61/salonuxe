<?php

use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttributesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FindServiceController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\SalonQueryController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\AdminVerification;
use App\Http\Middleware\RedirectAuthenticatedUser;
use App\Http\Middleware\CheckAuthentication;
use App\Http\Middleware\ClientVerification;
use App\Http\Middleware\SalonVerification;
use Illuminate\Support\Facades\Route;

// Main Website Routes
Route::get('/', [SiteController::class, 'home']);
// Route::get('/available-services/{href?}', [SiteController::class, 'available_services']);
Route::match(['get', 'post'], '/available-services/{href?}', [SiteController::class, 'available_services']);

Route::get('/salons', [SiteController::class, 'salons']);
Route::get('/salon/{href}', [SiteController::class, 'salonDetail']);

Route::get('/about', [SiteController::class, 'about']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/find-a-service', [FindServiceController::class, 'showSearchForm']);
Route::get('/find-service-results', [FindServiceController::class, 'searchServices'])->name('client.services.search');

// Routes Accessible Only to Guests (Prevent Logged-in Users from Accessing Login/Signup)
Route::middleware([RedirectAuthenticatedUser::class])->group(function () {

    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    // Separate route for salon Google signup
    Route::get('/auth/google/salon', [GoogleAuthController::class, 'redirectToGoogleSalon'])->name('google.salon.redirect');
    Route::get('/auth/google/salon/callback', [GoogleAuthController::class, 'handleGoogleCallbackSalon'])->name('google.salon.callback');

    // ADMIN LOGIN 
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
    Route::get('/added-services', [AdminController::class, 'added_services']);
    // APPROVE/REJECT SERVICE
    Route::get('/admin/services/change-status/{href}/{status}', [AdminController::class, 'changeStatus'])->name('admin.services.changeStatus');

    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/salons-list', [AdminController::class, 'salons_list']);
    // SERVICE TYPES
    Route::get('/service-types/{action?}/{href?}', [ServicesController::class, 'service_types'])->name('service_types');
    Route::post('/service-types/add', [ServicesController::class, 'add_service_type'])->name('service_types.add');
    Route::put('/service-types/update/{href}', [ServicesController::class, 'edit_service_type'])->name('service_types.update');

    // SERVICE TYPE ATTRIBUTES
    // List / Add / Edit (GET only)
    Route::get('/service-type-attributes/{action?}/{href?}', [AttributesController::class, 'index'])->name('service_type_attributes');
    Route::post('/service-type-attributes/store', [AttributesController::class, 'store'])->name('service_attributes.store');
    Route::put('//service-type-attributes/update/{href}', [AttributesController::class, 'update'])->name('service_attributes.update');



    // FAQS
    Route::get('/faqs/{action?}/{id?}', [FaqsController::class, 'faqs'])->name('faqs.index');
    Route::post('/faqs/store', [FaqsController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/update/{id}', [FaqsController::class, 'update'])->name('faqs.update');


    Route::post('/delete-record', [DatabaseController::class, 'deleteRecord'])->name('delete.record');

});

// Routes Accessible Only to Logged-in Users (Protected Routes)
Route::middleware([CheckAuthentication::class])->group(function () {

    Route::post('/change-password', [SiteController::class, 'changePassword'])->name('change.password');
    Route::post('/update-profile', [SiteController::class, 'updateProfile'])->name('profile.update');

    Route::post('/appointments/{id}/mark-completed', [PaymentController::class, 'markCompleted'])->name('appointments.markCompleted');

    
    // Routes Accessible Only to Clients (login_type = 2)
    Route::middleware([ClientVerification::class])->group(function () {
        Route::get('/client-dashboard', [ClientController::class, 'index'])->name('clientDashboard');
        Route::get('/user-profile', [ClientController::class, 'profile']);
        Route::get('/my-bookings', [ClientController::class, 'bookings'])->name('client.bookings');

        // BOOK APPOINTMENT
        Route::get('/book-appointment/{href}', [ClientController::class, 'book_appointment']);
        Route::post('/make-appointment', [ClientController::class, 'makeAppointment'])->name('make.appointment');

            // PAYMENT ROUTES
        Route::post('/appointments/{href}/pay', [PaymentController::class, 'createCheckoutSession'])->name('appointments.pay');
        Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

        // Stripe webhook (do NOT protect with CSRF)
        Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

        // DELETE APPOINTMENT
        Route::delete('/appointments/delete/{href}', [ClientController::class, 'deleteAppointment'])->name('appointments.delete');

        Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('apply.job');

        // Customer (user) routes
        Route::get('/my-queries', [QueryController::class, 'myQueries'])->name('queries.my');
        Route::post('/queries/start', [QueryController::class, 'store'])->name('queries.start');          // start new query
        Route::post('/queries/{id}/message', [QueryController::class, 'sendMessage'])->name('queries.message'); // add message to existing
        // Show thread modal (for salon detail)
        Route::get('/salon/{id}/thread', [QueryController::class, 'salonThread'])->name('queries.salonThread');



    });

    // Routes Accessible Only to Salons (login_type = 3)
    Route::middleware([SalonVerification::class])->group(function () {

        Route::get('/get-attributes/{id}', [SalonController::class, 'getAttributes']);

        Route::get('/salon-dashboard', [SalonController::class, 'index'])->name('salonDashboard');
        Route::get('/profile', [SalonController::class, 'profile']);

        Route::get('/salon-profile', [SalonController::class, 'salon_profile'])->name('salon.profile');
        Route::post('/salon/add', [SalonController::class, 'addSalon'])->name('add.salon'); // Add new salon
        Route::put('/salon/update', [SalonController::class, 'updateSalon'])->name('update.salon'); // Update existing salon

        Route::get('/salon/stripe/onboard', [SalonController::class, 'createStripeAccount'])->name('stripe.onboard');
        Route::get('/salon/stripe/onboard/success', [SalonController::class, 'onboardSuccess'])->name('stripe.onboard.success');
        Route::get('/salon/stripe/onboard/refresh', [SalonController::class, 'onboardRefresh'])->name('stripe.onboard.refresh');


        Route::get('/services/{action?}/{href?}', [SalonController::class, 'services'])->name('salon.services');
        Route::post('/services/add-service', [SalonController::class, 'addService'])->name('salon.services.add');
        Route::put('/services/update-service/{id}', [SalonController::class, 'editService'])->name('salon.services.update');

        Route::get('/bookings', [SalonController::class, 'bookings']);
        Route::post('/appointments/update-status/{href}', [SalonController::class, 'updateStatus']);


        Route::get('/jobs/{action?}/{href?}', [JobsController::class, 'jobs'])->name('salon.jobs');
        Route::post('/salon-jobs/add', [JobsController::class, 'addJob'])->name('salon.jobs.add');
        Route::put('/jobs/update/{id}', [JobsController::class, 'editJob'])->name('salon.jobs.update');

        Route::post('/applications/respond', [JobsController::class, 'respond'])->name('applications.respond');

        // Salon owner routes
        Route::get('/customer-messages', [SalonQueryController::class, 'ownerIndex'])->name('owner.queries');
        Route::post('/owner/queries/{id}/reply', [SalonQueryController::class, 'reply'])->name('owner.queries.reply');

        Route::post('/delete-record', [DatabaseController::class, 'deleteRecord'])->name('delete.record');

    });
    
    
    Route::get('/logout', [SiteController::class, 'logout'])->name('logout');
});
