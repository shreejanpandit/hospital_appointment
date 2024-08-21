<?php

namespace App\Http\Controllers;

use App\Http\Requests\appointment\AppointmentStoreRequest;
use App\Http\Requests\appointment\AppointmentUpdateRequest;
use App\Jobs\SendAppointmentMailJob;
use App\Models\Appointment;
use App\Models\Department;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user  = Auth::user();
        $this->authorize('viewAny', Appointment::class);

        $perPage = 10;
        $appointments = Appointment::paginate($perPage);
        return view('appointment.index', [
            'appointments' => $appointments,
            'perPage' => $perPage,
            'currentPage' => $request->input('page', 1),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userPatient = Auth::user()->patient;
        $departments = Department::with('doctors')->get();

        return view('appointment.create', [
            'patient' => $userPatient,
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AppointmentStoreRequest  $request)
    {
        $user = Auth::user();
        $this->authorize('create', Appointment::class);

        $appointmentService = new AppointmentService();
        $appointmentService->save($user, $request->all());
        $mailData = $appointmentService->mailSend($user, $request['doctor_id']);
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
        $appointment = Appointment::findOrFail($id);

        return view('appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('appointment.edit', compact('appointment'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentUpdateRequest $request, Appointment $appointment)
    {
        $user = Auth::user();

        $this->authorize('update', $appointment);

        $appointment->update([
            'description' => $request->input('description'),
        ]);

        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'The appointment with Dr. ' . $appointment->doctor->user->name . ' has been updated successfully. New description: "' . $appointment->description . '".',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        // Redirect with a success message
        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Appointment with Dr. ' . $appointment->doctor->user->name . ' scheduled for ' . $appointment->date->format('F j, Y') . ' has been canceled successfully.',
            'type' => 'failure'
        ]);
    }
}
