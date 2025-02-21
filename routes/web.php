<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;
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
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
});

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['web', 'auth', AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Matches routes
        Route::resource('matches', \App\Http\Controllers\Admin\MatchController::class)
            ->names([
                'index' => 'admin.matches.index',
                'create' => 'admin.matches.create',
                'store' => 'admin.matches.store',
                'show' => 'admin.matches.show',
                'edit' => 'admin.matches.edit',
                'update' => 'admin.matches.update',
                'destroy' => 'admin.matches.destroy',
            ]);

        // Bookings routes
        Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings');
        
        // Users routes - accessible by both admin and super admin
        Route::resource('users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ])->except(['show']); // Remove show from this group

        // User show route - separate to allow proper access control
        Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    });
});

require __DIR__.'/auth.php';
