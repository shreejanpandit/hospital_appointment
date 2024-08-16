<?php

namespace App\Http\Controllers;

use App\Http\Requests\appointment\AppointmentStoreRequest;
use App\Jobs\SendAppointmentMailJob;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
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
        $userPatient = Auth::user()->patient;
        $doctors = Doctor::all();
        $departments = Department::with('doctors')->get();

        return view('appointment.create', [
            'patient' => $userPatient,
            'doctors' => $doctors,
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // AppointmentController.php
    public function store(AppointmentStoreRequest  $request)
    {
        // dd($request);
        $user = Auth::user();
        $doctorId = $request['doctor_id'];

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
