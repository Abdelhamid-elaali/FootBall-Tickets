<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\MatchController as AdminMatchController;
use App\Http\Controllers\PaymentController; // Added PaymentController
use App\Http\Controllers\PayPalController; // Added PayPalController
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Matches routes
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show');
    
    // Tickets routes
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('my-tickets');
    Route::get('/tickets/{match}/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    
    // Payment routes
    Route::get('/payment/confirm', [PaymentController::class, 'create'])->name('payment.confirm');
    Route::post('/payment/process', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    
    // PayPal payment routes
    Route::post('/payment/paypal/create', [PayPalController::class, 'createPayment'])->name('paypal.create');
    Route::get('/payment/paypal/success', [PayPalController::class, 'capturePayment'])->name('paypal.success');
    Route::get('/payment/paypal/cancel', [PayPalController::class, 'cancelPayment'])->name('paypal.cancel');
});

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

// How It Works page
Route::get('/HowWorks', function () {
    return view('pages.how-it-works');
})->name('how-it-works');

// FAQs page
Route::get('/FAQs', function () {
    return view('pages.faqs');
})->name('faqs');

// Terms of Service page
Route::get('/terms', function () {
    return view('pages.terms-of-service');
})->name('terms');

// Privacy Policy page
Route::get('/privacy', function () {
    return view('pages.privacy-policy');
})->name('privacy');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Matches routes
        Route::resource('matches', App\Http\Controllers\Admin\MatchController::class)->names([
            'index' => 'admin.matches.index',
            'create' => 'admin.matches.create',
            'store' => 'admin.matches.store',
            'show' => 'admin.matches.show',
            'edit' => 'admin.matches.edit',
            'update' => 'admin.matches.update',
            'destroy' => 'admin.matches.destroy',
        ]);

        // Bookings routes - view only
        Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.bookings.index');
        
        // Users routes
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ])->except(['show']);
        Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    });
});

require __DIR__.'/auth.php';
