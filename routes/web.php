<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return redirect()->route('properties.index');
});

// Alias for the property listing page
Route::get('/property-listing', function () {
    return redirect()->route('properties.index');
})->name('property.listing');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create')->middleware('auth');
Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store')->middleware('auth');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit')->middleware('auth');
Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update')->middleware('auth');
Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
});

require __DIR__.'/auth.php';
