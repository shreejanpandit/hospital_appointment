<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/patient.php';
require __DIR__ . '/doctor.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('doctor/find', [DoctorController::class, 'show'])->name('appointment.doctor.find');
    Route::patch('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/schedule/find', [ScheduleController::class, 'show'])->name('doctor.schedule.find');

    Route::patch('patients/{patient}', [PatientController::class, 'update'])->name('patient.update');
    Route::post('patient', [PatientController::class, 'store'])->name('patient.store');
    Route::get('patient/create', [PatientController::class, 'create'])->name('patient.create');
});
