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
        $patients = Patient::paginate(10);
        return view('patient.index', ['patients' => $patients]);
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

        // Fetch appointments for the patient
        $appointments = Appointment::where('patient_id', $user->patient->id)
            ->with('patient', 'doctor')
            ->orderBy('date', 'asc')
            ->get();

        // Fetch notifications for the patient
        $notifications = $user->notifications()->latest()->get();
        $unreadNotificationsCount = $notifications->where('read_at', null)->count();


        return view('patient.dashboard', [
            'appointments' => $appointments,
            'notifications' => $notifications,
            'unreadNotificationsCount' => $unreadNotificationsCount
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }
    // In your controller
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
        $patientName = $patient->user->name;
        $patient->delete();
        return redirect()->route('patient.index')->with('status', [
            'message' =>  'Patient ' . $patientName .  ' has been deleted successfully.',
            'type' => 'failure'
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $patients = Patient::with('user')
            ->where('gender', 'like', "%{$searchTerm}%")
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            })
            ->get();


        return view('patient.index', ['patients' => $patients, 'search' => $searchTerm]);
    }
}
