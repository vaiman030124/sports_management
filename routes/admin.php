<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CourtController;

Route::prefix('admin')->group(function() {
    // Redirect base admin URL to login or dashboard based on auth status
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    })->name('admin.base');

    // Authentication Routes
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Registration Routes
    Route::get('register', [AdminLoginController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('register', [AdminLoginController::class, 'register'])->name('admin.register.post');

    // Password Reset Routes
    Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])->name('admin.password.update');

    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function() {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Admin User Management Routes
        Route::prefix('admin-users')->group(function() {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.admin-users.index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('admin.admin-users.create');
            Route::post('/', [AdminUserController::class, 'store'])->name('admin.admin-users.store');
            Route::get('/{adminUser}', [AdminUserController::class, 'show'])->name('admin.admin-users.show');
            Route::get('/{adminUser}/edit', [AdminUserController::class, 'edit'])->name('admin.admin-users.edit');
            Route::put('/{adminUser}', [AdminUserController::class, 'update'])->name('admin.admin-users.update');
            Route::delete('/{adminUser}', [AdminUserController::class, 'destroy'])->name('admin.admin-users.destroy');
        });

        // Admin Profile & Settings Routes
        Route::get('/profile', [AdminUserController::class, 'profile'])->name('admin.profile');
        Route::put('/profile', [AdminUserController::class, 'updateProfile'])->name('admin.profile.update');
        Route::get('/settings', [AdminUserController::class, 'profile'])->name('admin.settings');
        
        // Resource Routes
        Route::resource('users', '\App\Http\Controllers\Admin\UserController')->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show', 
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);
        
        Route::resource('bookings', '\App\Http\Controllers\Admin\BookingController')->names('admin.bookings');
        Route::resource('venues', '\App\Http\Controllers\Admin\VenueController')->names('admin.venues');
        Route::resource('sports', '\App\Http\Controllers\Admin\SportController')->names('admin.sports');

        // Route to remove sport image
        Route::delete('sports/{sport}/images', [\App\Http\Controllers\Admin\SportController::class, 'removeImage'])->name('admin.sports.removeImage');
        Route::delete('courts/{court}/images', [\App\Http\Controllers\Admin\CourtController::class, 'removeImage'])->name('admin.courts.removeImage');
        Route::resource('trainers', '\App\Http\Controllers\Admin\TrainerController')->names('admin.trainers');
        Route::resource('transactions', '\App\Http\Controllers\Admin\TransactionController')->names('admin.transactions');
        // Route::resource('reports', '\App\Http\Controllers\Admin\ReportController')->names('admin.reports');
        Route::resource('trainer_bookings', '\App\Http\Controllers\Admin\TrainerBookingController')->names('admin.trainer_bookings');
        Route::resource('groups', '\App\Http\Controllers\Admin\GroupController')->names('admin.groups');
        Route::resource('notifications', '\App\Http\Controllers\Admin\NotificationController')->names('admin.notifications');
        Route::resource('refunds', '\App\Http\Controllers\Admin\RefundController')->names('admin.refunds');
        Route::resource('reviews', '\App\Http\Controllers\Admin\ReviewController')->names('admin.reviews');

        Route::resource('slots', '\App\Http\Controllers\Admin\SlotController')->names('admin.slots');
        Route::resource('courts', '\App\Http\Controllers\Admin\CourtController')->names('admin.courts');
        Route::resource('email-templates', '\App\Http\Controllers\Admin\EmailTemplateController')->names('admin.email-templates');

        Route::resource('razorpay-payments', '\App\Http\Controllers\Admin\RazorpayPaymentController')->only(['index', 'show'])->names('admin.razorpay-payments');

        Route::prefix('razorpay-booking')->group(function () {
            Route::get('/create', [\App\Http\Controllers\Admin\razorpay_payment\RazorpayBookingController::class, 'create'])->name('admin.razorpay-booking.create');
            Route::post('/store', [\App\Http\Controllers\Admin\razorpay_payment\RazorpayBookingController::class, 'store'])->name('admin.razorpay-booking.store');
            Route::post('/verify-payment', [\App\Http\Controllers\Admin\razorpay_payment\RazorpayBookingController::class, 'verifyPayment'])->name('admin.razorpay-booking.verify-payment');
        });

        Route::post('/courtList', [CourtController::class, 'getCourtListBySports'])->name('admin.court.listBySports');

        Route::get('/spBook', [AdminController::class, 'sportWiseBooking'])->name('admin.spBook');
        Route::get('/calBookings', [AdminController::class, 'bookings'])->name('admin.calBookings');
    });
});
