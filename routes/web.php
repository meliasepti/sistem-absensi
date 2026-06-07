<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InviteController;
use App\Livewire\Labeler;

Route::get('/', function () {
    return redirect('/login'); // Langsung ke login
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    
    // Attendance Routes
    Route::resource('attendance', App\Http\Controllers\AttendanceController::class);
   Route::get('/labeler', Labeler::class)->name('labeler');
    Route::post('/attendance/{attendance}/label', [App\Http\Controllers\AttendanceController::class, 'label'])->name('attendance.label');
});

Route::middleware('admin')->group(function () {
    Route::resource('invites', InviteController::class);
});