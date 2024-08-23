<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard/patient', [DashboardController::class, 'dashboardPatient'])->name('patient.dashboard');
    Route::resource('appointments', AppointmentController::class)->only(['create', 'store', 'show', 'edit', 'update', 'destroy'])->names([
        'destroy' => 'appointment.cancel'
    ]);
    Route::post('/notifications/mark-as-read', [PatientController::class, 'markNotificationsAsRead'])->name('notifications.markAsRead');
});
