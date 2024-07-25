<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/memories', [MemoryController::class, 'index'])->name('memories.index');
    Route::get('/memories/create', [MemoryController::class, 'create'])->name('memories.create');
    Route::post('/memories', [MemoryController::class, 'store'])->name('memories.store');
    Route::get('/memories/{memory}/edit', [MemoryController::class, 'edit'])->name('memories.edit');
    Route::put('/memories/{memory}', [MemoryController::class, 'update'])->name('memories.update');
    Route::delete('/memories/{memory}', [MemoryController::class, 'destroy'])->name('memories.destroy');
    Route::delete('/memories/{memory}/images', [MemoryController::class, 'deleteImage'])->name('memories.deleteImage');
});

require __DIR__.'/auth.php';
