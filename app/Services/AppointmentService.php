<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;

class AppointmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function save(User $user, array $request)
    {
        // $user = Auth::user();
        $doctorId = $request['doctor_id'];

        $appointment = Appointment::create([
            'patient_id' => $user->patient->id,
            'doctor_id' => $doctorId,
            'description' => $request['description'],
            'date' => $request['date'],
            'time' => $request['time']
        ]);
    }

    public function mailSend(User $user, int $doctorId)
    {

        $doctor = Doctor::with('user')->find($doctorId);
        $doctor_email = $doctor->user->email;
        $doctor_name = $doctor->user->name;
        // Prepare email data
        $mailData = [
            'title' => 'Hospital Appointment',
            'body' => 'Your appointment has been booked successfully!',
            'patient_email' => $user->email,
            'doctor_email' =>  $doctor_email,
            'doctor_name' => $doctor_name,
            'patient_name' => $user->name,
        ];
        return $mailData;
    }
}
