<?php

use App\Http\Controllers\{ProfileController, NoteBookController, NoteController, DashboardController, ActivityController, TrashController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    return redirect()->route('notebooks.index');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('notebooks', NoteBookController::class);
    Route::resource('notes', NoteController::class);

    // Merged Activity Routes
    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');

    // Merged Trash Routes
    Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
    Route::post('/trash/restore/{type}/{id}', [TrashController::class, 'restore'])->name('trash.restore');
    Route::delete('/trash/force-delete/{type}/{id}', [TrashController::class, 'forceDelete'])->name('trash.force-delete');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';