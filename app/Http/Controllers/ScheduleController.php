<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
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

        return view('doctor.schedule', [
            'weekDays' => $weekDays,
            'schedule' => $scheduleData
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }
    public function getSchedules($doctorId)
    {
        $schedules = Schedule::with('doctor')
            ->where('doctor_id', $doctorId)
            ->get();
        // $schedules = Schedule::where('doctor_id', $doctorId)
        //     ->get()
        //     ->groupBy(function ($date) {
        //         return $date->start_time->format('l'); // Group by weekday
        //     });

        return response()->json($schedules);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $user = Auth::user();
        $doctorId = $user->doctor->id;

        $weekDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        foreach ($weekDays as $day) {
            $startTime = $request->input("{$day}_start_time");
            $endTime = $request->input("{$day}_end_time");

            if ($startTime && $endTime) {
                $schedule::updateOrCreate(
                    [
                        'doctor_id' => $doctorId,
                        'week_day' => $day
                    ],
                    [
                        'start_time' => $startTime,
                        'end_time' => $endTime
                    ]
                );
            }
        }

        return redirect()->route('doctor.schedule')->with('status', [
            'message' => 'Schedule updated successfully',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
