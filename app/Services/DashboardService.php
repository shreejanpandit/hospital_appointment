<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function admin()
    {
        $total_patient = Patient::count();
        $total_doctor = Doctor::count();
        $total_appointment = Appointment::count();
        $data_count = [
            'total_patient' => $total_patient,
            'total_doctor' => $total_doctor,
            'total_appointment' => $total_appointment
        ];
        return $data_count;
    }

    public function patient(User $user)
    {
        $appointments = Appointment::where('patient_id', $user->patient->id)
            ->with('patient', 'doctor')
            ->orderBy('date', 'asc')
            ->get();

        $notifications = $user->notifications()->latest()->get();
        $unreadNotificationsCount = $notifications->where('read_at', null)->count();
        return [
            'appointments' => $appointments,
            'notifications' => $notifications,
            'unreadNotificationsCount' => $unreadNotificationsCount
        ];
    }

    public function doctor(User $user)
    {
        $doctor = Doctor::where('user_id', $user->id)->firstOrFail();
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        // Define the current date and time
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();

        // Initialize arrays for each category of appointments
        $todayAppointments = [];
        $upcomingAppointments = [];
        $previousAppointments = [];

        foreach ($appointments as $appointment) {
            if ($appointment->date->isSameDay($today)) {
                $todayAppointments[] = $appointment;
            } elseif ($appointment->date->greaterThan($today)) {
                $upcomingAppointments[] = $appointment;
            } else {
                $previousAppointments[] = $appointment;
            }
        }
        return [
            'doctor' => $doctor,
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'previousAppointments' => $previousAppointments
        ];
    }
}
