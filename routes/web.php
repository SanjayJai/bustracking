<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\BusController;

use App\Http\Controllers\BusTrackerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // Route::view('Bus', 'Bus')
    // ->middleware(['auth', 'verified'])
    // ->name('Bus');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::get('/find-my-bus', [BusController::class, 'index'])->name('Bus');
Route::get('/track/{bus}', [BusTrackerController::class, 'show'])->name('track.bus');
require __DIR__.'/auth.php';
