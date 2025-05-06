<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SheepController;

Route::redirect('/', '/dashboard');
Route::prefix('dashboard')->name('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::get('/overview', function () {
        return view('dashboard.overview');
    })->name('.overview');

    Route::get('/analytics', function () {
        return view('dashboard.analytics');
    })->name('.analytics');

    Route::get('/settings', function () {
        return view('dashboard.settings');
    })->name('.settings');

    // Sheep Routes
    Route::prefix('sheep')->name('.sheep')->group(function () {
        Route::get('/', [SheepController::class, 'index'])->name('.index');
        Route::get('/create', [SheepController::class, 'create'])->name('.create');
        Route::post('/', [SheepController::class, 'store'])->name('.store');
        Route::get('/search', [SheepController::class, 'search'])->name('.search');
        Route::get('/{sheep}', [SheepController::class, 'show'])->name('.show');
        Route::get('/edit/{id}', [SheepController::class, 'edit'])->name('.edit');
        Route::put('{sheep}', [SheepController::class, 'update'])->name('.update');
        Route::delete('/{sheep}', [SheepController::class, 'destroy'])->name('.destroy');
    });

    Route::get('/pens', function () {
        return view('dashboard.pens');
    })->name('.pens.index');
});



// Temporary Sheep Routes

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::middleware('guest')->group(function () {
//     // Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('login', [LoginController::class, 'login']);
//     Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('register', [RegisterController::class, 'register']);
// });
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Route::middleware('auth')->group(function () {
//     Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// });



// Route RFID Check
Route::get('/check-uid', function () {
    return response()->json([
        'uid' => Cache::get('rfid_uid')
    ]);
});
Route::get('/rfid/uid-latest', function () {
    return response()->json(['uid' => Cache::get('rfid_uid')]);
});
