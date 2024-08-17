<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (authenticated and verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentication Routes
require __DIR__ . '/auth.php';

// Patient Routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointment.show');
    // Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('available.slots');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/schedule', [ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [ScheduleController::class, 'update'])->name('doctor.schedule.update');
    // Route::get('/schedules/{doctorId}', [ScheduleController::class, 'getSchedules'])->name('schedules.get');
    Route::post('/doctor/schedule/find', [DoctorController::class, 'findDoctorsSchedule'])->name('doctor.schedule.find');
});

// Routes for Both Doctor and Patient
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('doctor/find', [DoctorController::class, 'findDoctor'])->name('appointment.doctor.find');
    Route::patch('doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/doctor/schedule/find', [DoctorController::class, 'findDoctorsSchedule'])->name('doctor.schedule.find');

    Route::patch('patient/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::post('patient', [PatientController::class, 'store'])->name('patient.store');
    Route::get('patient/create', [PatientController::class, 'create'])->name('patient.create');
});

// Admin Routes (Optional)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Define any admin-specific routes here if needed
});
