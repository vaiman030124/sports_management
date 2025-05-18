<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;

// Admin Routes
require __DIR__.'/admin.php';

Route::redirect('/', 'admin/');
Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');

require __DIR__.'/api.php';