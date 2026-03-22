<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Facility;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    $facilities = Facility::where('status', 'active')->get();
    return view('welcome', compact('facilities'));
})->name('welcome');

// --- AUTHENTICATION ROUTES (Public) ---
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Added: 100 attempts per 1 minute
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:100,1')
    ->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- 2FA OTP ROUTES (Must be Public/Guest) ---
Route::get('/login/verify', [LoginController::class, 'showOtpForm'])->name('login.otp.view');
Route::post('/login/verify', [LoginController::class, 'verifyOtp'])->name('login.otp.verify');
Route::get('/login/resend', [LoginController::class, 'resendOtp'])->name('login.otp.resend');


// --- PUBLIC RESERVATION & CONTACT ROUTES ---
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');


// --- PROTECTED ROUTES (Requires verified login) ---
Route::middleware(['auth'])->group(function () {
    
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->middleware('is.admin')->name('admin.dashboard');

    // Admin: Messages
    Route::get('/admin/messages', [MessagesController::class, 'index'])->middleware('is.admin')->name('admin.messages.index');
    Route::get('/admin/messages/{message}', [MessagesController::class, 'show'])->middleware('is.admin')->name('admin.messages.show');
    
    // Facility CRUD (Admin only)
    Route::middleware('is.admin')->group(function () {
        Route::resource('facilities', FacilityController::class, ['except' => ['show']]);
        Route::post('/admin/update-gmail', [DashboardController::class, 'updateGmailAddress'])->name('admin.update-gmail');
    });
    
    // Facility Show
    Route::get('/facilities/{facility}', [FacilityController::class, 'show'])->name('facilities.show');
    
    // Chair Ordering
    Route::get('/chairs/order/{facility}', function (Facility $facility) {
        return view('chairs.order', compact('facility'));
    })->name('chairs.order');
    Route::post('/chairs/process-order', [ChairOrderController::class, 'store'])->name('chairs.process_order');

    // Reservation Management
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    /**
     * UPDATED: Reservation Show 
     * This handles the "View Details" data retrieval for both Users and Admins
     */
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    
    // --- CLINIC SYNC & APPROVAL (Admin only) ---
    Route::middleware('is.admin')->group(function () {
        // This specific route handles the Clinic Syncs tab filtering
        Route::get('/admin/reservations/clinic', [ReservationController::class, 'index'])->name('admin.reservations.clinic');
        
        Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approveReservation'])->name('reservations.approve');
        
        /**
         * ADDED: Reject Route
         * Handles the rejection of clinic and standard reservations
         */
        Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');
    });
});

// --- DEBUG/TEST ROUTES ---
Route::get('/test-google-file', function () {
    $path = storage_path('app/google-credentials.json');
    $exists = File::exists($path);
    $readable = is_readable($path);
    
    return response()->json([
        'target_path' => $path,
        'file_exists' => $exists,
        'is_readable' => $readable,
        'current_user' => get_current_user(),
    ]);
});