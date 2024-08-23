<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Schedule;

class RescheduleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show(Appointment $appointment)
    {
        $doctor_schedule = Schedule::query()
            ->where('doctor_id', '=', $appointment->doctor_id)
            ->with('doctor')
            ->get();

        $weekDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $schedules = [];

        foreach ($weekDays as $day) {
            $daySchedule = $doctor_schedule->where('week_day', $day)->first();
            $schedules[$day . '_start_time'] = $daySchedule
                ? $daySchedule->start_time->format('H:i') // Use 24-hour format
                : '';
            $schedules[$day . '_end_time'] = $daySchedule
                ? $daySchedule->end_time->format('H:i') // Use 24-hour format
                : '';
        }

        return  [
            'doctor_schedule' => $doctor_schedule,
            'schedules' => $schedules,
            'appointment' => $appointment
        ];
    }
}
