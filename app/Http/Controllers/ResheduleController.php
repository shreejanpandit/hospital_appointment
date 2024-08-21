<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Notifications\AppointmentRescheduled;
use App\Services\RescheduleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ResheduleController extends Controller
{
    use AuthorizesRequests;

    public function show(Appointment $appointment)
    {
        $user = Auth::user();
        $this->authorize('reschedule', $appointment);

        $rescheduleService = new RescheduleService();

        return view('appointment.reshedule', $rescheduleService->show($appointment));
    }

    public function store(Appointment $appointment, Request $request)
    {
        $this->authorize('reschedule', $appointment);
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $appointment->update([
            'date' => $request->date,
            'time' =>  $request->time
        ]);

        Notification::send($appointment->patient->user, new AppointmentRescheduled($appointment));

        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'The appointment date has been rescheduled successfully.',
            'type' => 'success'
        ]);
    }
}
