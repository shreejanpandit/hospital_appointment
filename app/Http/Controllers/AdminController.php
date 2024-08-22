<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDoctorUpdate(Doctor $doctor, Request $request)
    {
        $test =   $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string',
            'bio' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $doctor->user->name = $validatedData['name'];

        $doctor->contact = $validatedData['contact'];
        $doctor->bio = $validatedData['bio'];
        $doctor->department_id = $validatedData['department_id'];

        if ($request->hasFile('image')) {
            if ($doctor->image && Storage::exists('public/uploads_doctor/' . $doctor->image)) {
                Storage::delete('public/uploads_doctor/' . $doctor->image);
            }

            $imagePath = $request->file('image')->store('uploads_doctor', 'public');
            $doctor->image = basename($imagePath);
        }

        $doctor->user->save();

        $doctor->save();

        return redirect()->back()->with('status', [
            'message' => 'Doctor updated successfully',
            'type' => 'success'
        ]);
    }

    public function adminPatientUpdate(Patient $patient, Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Added max length for name
            'dob' => 'required|date|before:today', // Ensure DOB is before today
            'gender' => 'required|in:male,female,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $patient->user->name = $validatedData['name'];

        $patient->dob = $validatedData['dob'];
        $patient->gender = $validatedData['gender'];

        // Handle file upload
        if ($request->hasFile('image')) {
            if ($patient->image && Storage::exists('public/uploads_patient/' . $patient->image)) {
                Storage::delete('public/uploads_patient/' . $patient->image);
            }

            $imagePath = $request->file('image')->store('uploads_patient', 'public');
            $patient->image = basename($imagePath);
        }

        $patient->user->save();

        $patient->save();

        // Redirect back with success message
        return redirect()->back()->with('status', [
            'message' => 'Patient updated successfully',
            'type' => 'success'
        ]);
    }
}
