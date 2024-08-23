<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\User;

class ScheduleService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function index(User $user)
    {
        $doctorId = $user->doctor->id;

        // Define the days of the week
        $weekDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        // Fetch the existing schedule for the doctor
        $schedules = Schedule::where('doctor_id', $doctorId)
            ->get()
            ->keyBy('week_day');

        // Prepare data to pass to the view
        $scheduleData = [];
        foreach ($weekDays as $day) {
            $schedule = $schedules->get($day);
            $scheduleData[$day . '_start_time'] = $schedule ? $schedule->start_time->format('H:i') : '';
            $scheduleData[$day . '_end_time'] = $schedule ? $schedule->end_time->format('H:i') : '';
        }

        return [
            'weekDays' => $weekDays,
            'schedule' => $scheduleData
        ];
    }

    public function update(int $id, $request, $schedule)
    {


        $weekDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        foreach ($weekDays as $day) {
            $startTime = $request->input("{$day}_start_time");
            $endTime = $request->input("{$day}_end_time");

            if ($startTime && $endTime) {
                $schedule::updateOrCreate(
                    [
                        'doctor_id' => $id,
                        'week_day' => $day
                    ],
                    [
                        'start_time' => $startTime,
                        'end_time' => $endTime
                    ]
                );
            }
        }
    }
}
