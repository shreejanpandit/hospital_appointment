<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ResheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard/doctor', [DashboardController::class, 'dashboardDoctor'])->name('doctor.dashboard');
    Route::get('/doctor/schedule', [ScheduleController::class, 'index'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [ScheduleController::class, 'update'])->name('doctor.schedule.update');
    Route::resource('reshedule', ResheduleController::class)->only(['show', 'update'])->names([
        'show' => 'appointment.reshedule',
        'update' => 'appointment.reshedule.update'
    ]);
});
