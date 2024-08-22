<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    // use HandlesAuthorization;

    /**
     * Determine whether the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {

        return $user->role === 'admin' ||
            ($user->role === 'patient' && $user->id === $appointment->patient->user->id) ||
            ($user->role === 'doctor' && $user->id === $appointment->doctor->user->id);
    }

    /**
     * Determine whether the user can create appointments.
     */
    public function create(User $user): bool
    {
        // Patients can create appointments
        return $user->role === 'patient';
    }

    /**
     * Determine whether the user can update the appointment.
     */
    public function update(User $user, Appointment $appointment): bool
    {

        return $user->role === 'admin' ||
            ($user->role === 'patient' && $user->id === $appointment->patient->user->id) ||
            ($user->role === 'doctor' && $user->id === $appointment->doctor->user->id);
    }

    /**
     * Determine whether the user can delete the appointment.
     */
    public function delete(User $user, Appointment $appointment): bool
    {

        return $user->role === 'admin' ||
            ($user->role === 'patient' && $user->id === $appointment->patient->user->id);
    }

    /**
     * Determine whether the user can reschedule the appointment.
     */
    public function reschedule(User $user, Appointment $appointment): bool
    {
        return $user->role === 'admin' ||
            ($user->role === 'doctor' && $user->id === $appointment->doctor?->user?->id);
    }
}
