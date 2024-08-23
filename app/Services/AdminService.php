<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function updateDoctor(Doctor $doctor, Request $request)
    {
        $doctor->user->name = $request['name'];

        $doctor->contact = $request['contact'];
        $doctor->bio = $request['bio'];
        $doctor->department_id = $request['department_id'];

        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::exists('public/uploads_doctor/' . $doctor->image)) {
                Storage::delete('public/uploads_doctor/' . $doctor->image);
            }

            $imagePath = $request->file('image')->store('uploads_doctor', 'public');
            $doctor->image = basename($imagePath);
        }

        $doctor->user->save();

        $doctor->save();
    }

    public function updatePatient(Patient $patient, Request $request)
    {
        $patient->user->name = $request['name'];

        $patient->dob = $request['dob'];
        $patient->gender = $request['gender'];

        if ($request->hasFile('image')) {
            if ($patient->image && Storage::exists('public/uploads_patient/' . $patient->image)) {
                Storage::delete('public/uploads_patient/' . $patient->image);
            }

            $imagePath = $request->file('image')->store('uploads_patient', 'public');
            $patient->image = basename($imagePath);
        }

        $patient->user->save();

        $patient->save();
    }
}
