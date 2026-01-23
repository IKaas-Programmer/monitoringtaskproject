<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Bungkus semua route yang butuh login dalam satu grup middleware
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard menggunakan ProjectController
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');

    // CRUD Project (index, create, store, show, edit, update, destroy)
    Route::resource('projects', ProjectController::class);

    // Update Status Task
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Profile Management (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';