<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoteBookController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('notebooks.index');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::resource('notebooks', NoteBookController::class);
    Route::resource('notes', NoteController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
