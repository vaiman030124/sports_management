<?php

use Illuminate\Support\Facades\Route;

// Admin Routes
require __DIR__.'/admin.php';

// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('admin-users', AdminUserController::class);
// });
Route::redirect('/', 'admin/login');
Route::redirect('/admin', 'admin/login');
// Other web routes can be added here

require __DIR__.'/api.php';