<?php

use App\Http\Controllers\AdminController;
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

// Admin Routes 
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/patients/index', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/patients/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::patch('patients/{patient}', [PatientController::class, 'adminPatientUpdate'])->name('admin.patient.update');
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patient.delete');

    Route::get('/doctors/index', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::patch('doctors/{doctor}', [DoctorController::class, 'adminDoctorUpdate'])->name('admin.doctor.update');
    Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('admin.doctor.delete');

    Route::get('/appointments/index', [AppointmentController::class, 'index'])->name('appointment.index');
});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->group(function () {

    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointment.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.cancel');
    Route::post('/notifications/mark-as-read', [PatientController::class, 'markNotificationsAsRead'])->name('notifications.markAsRead');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/schedule', [ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [ScheduleController::class, 'update'])->name('doctor.schedule.update');
    Route::get('/appointments/{appointment}/reshedule', [ScheduleController::class, 'reshedule'])->name('appointment.reshedule');
    Route::patch('/appointments/{appointment}/reshedule', [ScheduleController::class, 'resheduleStore'])->name('appointment.reshedule.store');
    Route::post('/doctor/schedule/find', [DoctorController::class, 'findDoctorsSchedule'])->name('doctor.schedule.find');
});

// Routes for Both Doctor and Patient
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('doctor/find', [DoctorController::class, 'findDoctor'])->name('appointment.doctor.find');
    Route::patch('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/doctor/schedule/find', [DoctorController::class, 'findDoctorsSchedule'])->name('doctor.schedule.find');

    Route::patch('patients/{patient}', [PatientController::class, 'update'])->name('patient.update');
    Route::post('patient', [PatientController::class, 'store'])->name('patient.store');
    Route::get('patient/create', [PatientController::class, 'create'])->name('patient.create');
    Route::get('/doctors/search', [DoctorController::class, 'search'])->name('doctor.search');
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patient.search');
});
