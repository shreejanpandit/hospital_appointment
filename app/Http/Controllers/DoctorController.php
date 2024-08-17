<?php

namespace App\Http\Controllers;

use App\Http\Requests\doctor\DoctorStoreRequest;
use App\Http\Requests\doctor\DoctorUpdateRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('doctor.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
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

        $user = Auth::user();
        $doctor_validate["user_id"] = $user->id;
        // dd($doctor_validate);

        Doctor::create($doctor_validate);

        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'Doctor Created sucessfully',
            'type' => 'success'
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
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

        return view('doctor.dashboard', [
            'doctor' => $doctor,
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'previousAppointments' => $previousAppointments
        ]);
    }

    public function findDoctor(Request $request)
    {
        $department_id = $request->input('department_id');
        $department_doctors = Doctor::where('department_id', $department_id)->get();

        $weekDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $schedules = [];
        foreach ($department_doctors as $doctor) {
            $doctorSchedules = Schedule::where('doctor_id', $doctor->id)->get();
            $scheduleData = [];

            foreach ($weekDays as $day) {
                $daySchedule = $doctorSchedules->where('week_day', $day)->first();
                $scheduleData[$day . '_start_time'] = $daySchedule ? $daySchedule->start_time->format('H:i A') : '';
                $scheduleData[$day . '_end_time'] = $daySchedule ? $daySchedule->end_time->format('H:i A') : '';
            }

            $schedules[$doctor->id] = $scheduleData;
        }

        return view('doctor.show', [
            'department_doctors' => $department_doctors,
            // 'schedules' => $schedules,
            'patient_id' => $request->input('patient_id'),
            'department_id' => $department_id,
        ]);
    }

    public function findDoctorsSchedule(Request $request)
    {
        $doctor_schedule = Schedule::query()
            ->where('doctor_id', '=', $request->doctor_id)
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

        return view('doctor.show-schedule', [
            'doctor_schedule' => $doctor_schedule,
            'schedules' => $schedules,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, int $id)
    {

        $doctor = Doctor::findOrFail($id);

        $doctor->contact = $request->input('contact');
        $doctor->bio = $request->input('bio');
        $doctor->department_id = $request->input('department_id');

        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::exists('public/uploads_doctor/' . $doctor->image)) {
                Storage::delete('public/uploads_doctor/' . $doctor->image);
            }

            $imagePath = $request->file('image')->store('uploads_doctor', 'public');
            $doctor->image = basename($imagePath);
        }

        $doctor->save();

        // Redirect back with success message
        return redirect()->back()->with('status', [
            'message' => 'Doctor updated successfully',
            'type' => 'success'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
