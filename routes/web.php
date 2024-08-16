<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
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

// Doctor routes
Route::get('doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
Route::post('doctor', [DoctorController::class, 'store'])->name('doctor.store');

Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointment.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');

    Route::post('doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/doctor/find', [DoctorController::class, 'findDoctor'])->name('appointment.doctor.find');
    Route::patch('patient/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::patch('doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctor/schedule', [ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [ScheduleController::class, 'update'])->name('doctor.schedule.update');
    Route::get('/schedules/{doctorId}', [ScheduleController::class, 'getSchedules'])->name('schedules.get');
});


Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('available.slots');

require __DIR__ . '/auth.php';
