<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::get('/admin/complaints/export', [AdminController::class, 'exportPdf'])
    ->name('admin.complaints.exportPdf');

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Complaint routes
    Route::get('/complaint', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::resource('complaints', ComplaintController::class);

  
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/residents', [AdminController::class, 'users'])->name('residents');
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('complaints');
    Route::patch('/complaint/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
});

require __DIR__.'/auth.php';