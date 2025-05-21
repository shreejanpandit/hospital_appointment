<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'dashboardAdmin'])->name('admin.dashboard');
    Route::resource('patients', PatientController::class)->only(['index', 'edit', 'destroy'])->names([
        'index' => 'patient.index',
        'edit' => 'patient.edit',
        'destroy' => 'admin.patient.delete',
    ]);
    Route::resource('doctors', DoctorController::class)->only(['index', 'edit', 'destroy'])->names([
        'index' => 'doctor.index',
        'edit' => 'doctor.edit',
        'destroy' => 'admin.doctor.delete',
    ]);
    Route::patch('admin/doctor/{doctor}', [AdminController::class, 'adminDoctorUpdate'])->name('admin.doctor.update');
    Route::patch('admin/patient/{patient}', [AdminController::class, 'adminPatientUpdate'])->name('admin.patient.update');

    Route::get('/appointments/index', [AppointmentController::class, 'index'])->name('appointment.index');
});
