<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Patient routes
Route::get('patient/create', [PatientController::class, 'create'])->name('patient.create');
Route::post('patient', [PatientController::class, 'store'])->name('patient.store');
Route::get('patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');

// Doctor routes
Route::get('doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
Route::post('doctor', [DoctorController::class, 'store'])->name('doctor.store');
Route::get('doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
