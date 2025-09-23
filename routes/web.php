<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Memory;

Route::get('/', [HomeController::class, 'homepage'])->name('homepage');   // new homepage
Route::get('/memories/form', [HomeController::class, 'index'])->name('memories.form'); // form page
Route::post('/memories', [HomeController::class, 'store'])->name('memories.store');

// NEW: list of memories (testimonials)
Route::get('/memories', [HomeController::class, 'testimonials'])->name('memories.index');
Route::get('/debug-mem', function () {
    return 'DB: ' . config('database.default') . ' | table count=' . Memory::count();
});
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::post('/memories', [HomeController::class, 'store'])->name('memories.store');

// Route::get('/', function () {
//     return view('welcome');
// });

// ADMIN (protect later with auth/middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/memories', [HomeController::class, 'adminIndex'])->name('memories.index');
    Route::get('/memories/{memory}/edit', [HomeController::class, 'edit'])->name('memories.edit');
    Route::put('/memories/{memory}', [HomeController::class, 'update'])->name('memories.update');
    Route::patch('/memories/{memory}/approve', [HomeController::class, 'approve'])->name('memories.approve');
    Route::delete('/memories/{memory}', [HomeController::class, 'destroy'])->name('memories.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
