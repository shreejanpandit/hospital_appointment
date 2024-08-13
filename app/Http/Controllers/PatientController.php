<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientStoreRequest;
use App\Models\Appointment;
use App\Models\Patient;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
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
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreRequest $request)
    {
        $patient_validate = $request->all();

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads_patient'), $name);

        $dob = $request->dob;
        $dobDateTime = new DateTime($dob);
        $currentDateTime = new DateTime();
        $age = $currentDateTime->diff($dobDateTime)->y;

        $patient_validate["age"] = $age;
        $patient_validate['image'] = $name;
        $user = Auth::user();
        $patient_validate["user_id"] = $user->id;

        Patient::create($patient_validate);

        return redirect()->route('patient.dashboard');
    }

    public function dashboard()
    {
        $appointments = Appointment::with('patient')->get();

        return view('patient.dashboard', ['appointments' => $appointments]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
