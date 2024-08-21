<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Support\Facades\Storage;

class DoctorService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function save($request, int $id)
    {
        $doctor_validate = $request->all();

        // Check if an image is provided
        if ($request->hasFile('image')) {
            $name = $request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('uploads_doctor'), $name);
        } else {
            $name = 'default_image.png';
        }
        $doctor_validate['image'] = $name;

        $doctor_validate["user_id"] = $id;

        Doctor::create($doctor_validate);
    }

    public function schedule(int $id)
    {
        $doctor_schedule = Schedule::query()
            ->where('doctor_id', '=', $id)
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
        return ['doctor_schedule' => $doctor_schedule, 'schedules' =>  $schedules];
    }


    public function update($request, Doctor $doctor)
    {
        $doctor->contact = $request->contact;
        $doctor->bio = $request->bio;
        $doctor->department_id = $request->department_id;

        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::exists('public/uploads_doctor/' . $doctor->image)) {
                Storage::delete('public/uploads_doctor/' . $doctor->image);
            }

            $imagePath = $request->file('image')->store('uploads_doctor', 'public');
            $doctor->image = basename($imagePath);
        }

        $doctor->save();
    }
}
