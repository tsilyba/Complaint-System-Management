<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //complaint routes
    Route::get('/complaint', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaint', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::resource('complaints', ComplaintController::class);

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/complaint/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
});

require __DIR__.'/auth.php';
