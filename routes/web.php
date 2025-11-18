<?php

use App\Http\Controllers\ContainerController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect to login as the main page
Route::get('/', function () {
    return redirect()->route('login');
});

// Public routes (auth routes are handled separately by Breeze via auth.php)

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard - using our AdminLTE dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Container routes
    Route::resource('containers', ContainerController::class);
    Route::post('containers/{id}/update-status', [ContainerController::class, 'updateStatus'])->name('containers.update-status');

    // Train routes
    Route::resource('trains', TrainController::class);
    Route::post('trains/{train}/process-arrival', [TrainController::class, 'processArrival'])->name('trains.process-arrival');

    // DEPO routes
    Route::resource('depots', DepotController::class);
    Route::get('depots/empty-in-cy', [DepotController::class, 'emptyInCy'])->name('depots.empty-in-cy');
    Route::get('depots/full-in-cy', [DepotController::class, 'fullInCy'])->name('depots.full-in-cy');
    Route::post('depots/process-empty-out/{container}', [DepotController::class, 'processEmptyOut'])->name('depots.process-empty-out');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
