<?php

namespace App\Http\Controllers;

use App\Http\Requests\patient\PatientUpdateRequest;
use App\Http\Requests\PatientStoreRequest;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $patientService = new PatientService();
        $data =  $patientService->show($request->input('search'));
        $data['currentPage'] = $request->input('page', 1);
        return view('patient.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request)
    {
        $user = Auth::user();

        $patientService = new PatientService();
        $patientService->save($request, $user->id);

        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Patient Created sucessfully',
            'type' => 'success'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }


    public function markNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patient.edit', compact('patient'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateRequest $request, Patient $patient)
    {
        $patientService = new PatientService();
        $patientService->update($request, $patient);

        return redirect()->back()->with('status', [
            'message' => 'Patient updated sucessfully',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patient.index')->with('status', [
            'message' =>  'Patient ' . $patient->user->name .  ' has been deleted successfully.',
            'type' => 'failure'
        ]);
    }
}
