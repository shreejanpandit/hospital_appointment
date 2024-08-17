<?php

namespace App\Http\Controllers;

use App\Http\Requests\patient\PatientUpdateRequest;
use App\Http\Requests\PatientStoreRequest;
use App\Models\Appointment;
use App\Models\Patient;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // Check if an image is provided
        if ($request->hasFile('image')) {
            $name = $request->file('image')->getClientOriginalName();

            $request->file('image')->move(public_path('uploads_patient'), $name);
        } else {
            $name = 'default_image.png';
        }

        $dob = $request->dob;
        $dobDateTime = new DateTime($dob);
        $currentDateTime = new DateTime();
        $age = $currentDateTime->diff($dobDateTime)->y;

        $patient_validate["age"] = $age;
        $patient_validate['image'] = $name;
        $user = Auth::user();
        $patient_validate["user_id"] = $user->id;

        Patient::create($patient_validate);

        return redirect()->route('patient.dashboard')->with('status', [
            'message' => 'Patient Created sucessfully',
            'type' => 'success'
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $appointments = Appointment::where('patient_id', $user->patient->id)->with('patient', 'doctor')->orderBy('date', 'asc')->get();
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
    public function update(PatientUpdateRequest $request, int $id)
    {
        // Find the patient record
        $patient = Patient::findOrFail($id);

        // Update patient details
        $patient->dob = $request->input('dob');
        $patient->gender = $request->input('gender');

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($patient->image && Storage::exists('public/uploads_patient/' . $patient->image)) {
                Storage::delete('public/uploads_patient/' . $patient->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('uploads_patient', 'public');
            $patient->image = basename($imagePath);
        }

        // Save changes
        $patient->save();

        // Redirect back with success message
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
        //
    }
}
