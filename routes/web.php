<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Facility;

Route::get('/', function () {
    $facilities = Facility::where('status', 'active')->get();
    return view('welcome', compact('facilities'));
});

// Authentication routes
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login', function () {
    return view('login');
})->name('login');

// Public reservation routes (no authentication required)
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->middleware('is.admin')->name('admin.dashboard');
    
    // Facility CRUD (Admin only)
    Route::middleware('is.admin')->group(function () {
        Route::resource('facilities', FacilityController::class, ['except' => ['show']]);
    });
    
    // Facility Show (available for all authenticated users)
    Route::get('/facilities/{facility}', [FacilityController::class, 'show'])->name('facilities.show');
    
    // Reservation routes for authenticated users
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Approve/Reject Reservations (Admin only)
    Route::middleware('is.admin')->group(function () {
        Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approveReservation'])->name('reservations.approve');
        Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
    });
});

// Public reservation routes (no auth required)
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

