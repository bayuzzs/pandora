<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SheepController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

Route::redirect('/', '/dashboard');
Route::prefix('dashboard')->name('dashboard')->middleware('auth')->group(function () {
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

    Route::get('/profile', function () {
        return view('dashboard.profile');
    })->name('.profile');

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
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences');
});



// Route RFID Check
Route::get('/check-uid', function () {
    return response()->json([
        'uid' => Cache::get('rfid_uid')
    ]);
});
Route::get('/rfid/uid-latest', function () {
    return response()->json(['uid' => Cache::get('rfid_uid')]);
});
