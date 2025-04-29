<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DombaController;


Route::prefix('domba')->group(function () {
    Route::get('/', [DombaController::class, 'index']); // Get semua domba
    Route::post('/', [DombaController::class, 'store']); // Tambah domba
    Route::get('{id}', [DombaController::class, 'show']); // Get domba by ID
    Route::put('{id}', [DombaController::class, 'update']); // Update domba
    Route::delete('{id}', [DombaController::class, 'destroy']); // Hapus domba
});






// Route::prefix('domba')->group(function () {
//     Route::get('/', [DombaController::class, 'index']); // Get semua domba
//     Route::post('/', [DombaController::class, 'store']); // Tambah domba
//     Route::get('{id}', [DombaController::class, 'show']); // Get domba by ID
//     Route::put('{id}', [DombaController::class, 'update']); // Update domba
//     Route::delete('{id}', [DombaController::class, 'destroy']); // Hapus domba
// });
