<?php

namespace App\Http\Controllers;

use App\Http\Requests\appointment\AppointmentStoreRequest;
use App\Jobs\SendAppointmentMailJob;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Notifications\AppointmentRescheduled;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
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
        $userPatient = Auth::user()->patient;
        // $doctors = Doctor::all();
        $departments = Department::with('doctors')->get();

        return view('appointment.create', [
            'patient' => $userPatient,
            // 'doctors' => $doctors,
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AppointmentStoreRequest  $request)
    {

        $user = Auth::user();
        $doctorId = $request['doctor_id'];
        $this->authorize('create', Appointment::class);

        $appointment = Appointment::create([
            'patient_id' => $user->patient->id,
            'doctor_id' => $doctorId,
            'description' => $request['description'],
            'date' => $request['date'],
            'time' => $request['time']
        ]);

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
        // dd(1);
        // Dispatch email job
        dispatch(new SendAppointmentMailJob($mailData));

        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Appointment booked successfully',
            'type' => 'success'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Pass the appointment to the view
        return view('appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointment.edit', compact('appointment'));
    }

    public function reshedule(Appointment $appointment)
    {
        $user = Auth::user();
        $this->authorize('reschedule', $appointment);
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

        return view('appointment.reshedule', [
            'doctor_schedule' => $doctor_schedule,
            'schedules' => $schedules,
            'appointment' => $appointment
        ]);
    }

    public function resheduleStore(Appointment $appointment, Request $request)
    {
        $this->authorize('reschedule', $appointment);
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $appointment->update([
            'date' => $request->date,
            'time' =>  $request->time
        ]);

        // dd($appointment->patient->user->name);
        Notification::send($appointment->patient->user, new AppointmentRescheduled($appointment));

        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'The appointment date has been rescheduled successfully.',
            'type' => 'success'
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();

        $this->authorize('update', $appointment);

        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $doctorName = $appointment->doctor->user->name;

        $appointment->update([
            'description' => $request->input('description'),
        ]);

        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'The appointment with Dr. ' . $doctorName . ' has been updated successfully. New description: "' . $appointment->description . '".',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $doctorName = $appointment->doctor->user->name;
        $appointmentDate = $appointment->date->format('F j, Y');

        $appointment->delete();

        // Redirect with a success message
        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Appointment with Dr. ' . $doctorName . ' scheduled for ' . $appointmentDate . ' has been canceled successfully.',
            'type' => 'failure'
        ]);
    }
}
