<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResheduleController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'dashboardAdmin'])->name('admin.dashboard');
    Route::get('/patients/index', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/patients/{patient}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patient.delete');
    Route::patch('admin/patient/{patient}', [AdminController::class, 'adminPatientUpdate'])->name('admin.patient.update');

    Route::get('/doctors/index', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::patch('admin/doctor/{doctor}', [AdminController::class, 'adminDoctorUpdate'])->name('admin.doctor.update');
    Route::delete('doctors/{doctor}', [DoctorController::class, 'destroy'])->name('admin.doctor.delete');

    Route::get('/appointments/index', [AppointmentController::class, 'index'])->name('appointment.index');
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard/patient', [DashboardController::class, 'dashboardPatient'])->name('patient.dashboard');
    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointment.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.cancel');
    Route::post('/notifications/mark-as-read', [PatientController::class, 'markNotificationsAsRead'])->name('notifications.markAsRead');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard/doctor', [DashboardController::class, 'dashboardDoctor'])->name('doctor.dashboard');
    Route::get('/doctor/schedule', [ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [ScheduleController::class, 'update'])->name('doctor.schedule.update');
    Route::get('/reshedule/{appointment}', [ResheduleController::class, 'show'])->name('appointment.reshedule');
    Route::patch('/reshedule/{appointment}', [ResheduleController::class, 'store'])->name('appointment.reshedule.store');
});

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
