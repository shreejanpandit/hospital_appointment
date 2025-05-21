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

    public function show(Appointment $reshedule)
    {

        $user = Auth::user();
        $this->authorize('reschedule', $reshedule);

        $rescheduleService = new RescheduleService();

        return view('appointment.reshedule', $rescheduleService->show($reshedule));
    }

    public function update(Appointment $reshedule, Request $request)
    {
        $this->authorize('reschedule', $reshedule);
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $reshedule->update([
            'date' => $request->date,
            'time' =>  $request->time
        ]);

        Notification::send($reshedule->patient->user, new AppointmentRescheduled($reshedule));

        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'The appointment date has been rescheduled successfully.',
            'type' => 'success'
        ]);
    }
}
