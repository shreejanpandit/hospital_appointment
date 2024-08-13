<?php

namespace App\Http\Controllers;

use App\Http\Requests\appointment\AppointmentStoreRequest;
use App\Jobs\SendAppointmentMailJob;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
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
    public function store(AppointmentStoreRequest $request)
    {
        $user = Auth::user();

        $mailData = [
            'title' => 'Hospital Appointment',
            'body' => 'Your appointment has been booked sucessfully !!!',
            'email' => $user->email
        ];
        $appointment_validate = $request->all();

        unset($appointment_validate["department_id"]);
        // dd($appointment_validate);
        // dd($user->email);
        Appointment::create($appointment_validate);

        //dispatch mail
        dispatch(new SendAppointmentMailJob($mailData));
        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Appointment booked sucessfully',
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
