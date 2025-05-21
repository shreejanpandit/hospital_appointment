<?php

namespace App\Services;

use App\Models\Patient;
use DateTime;
use Illuminate\Support\Facades\Storage;

class PatientService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function show(?string $searchTerm)
    {
        $perPage = 10;

        $patients = Patient::with('user')
            ->where('gender', 'like', "%{$searchTerm}%")
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            })
            ->paginate($perPage);


        return ['patients' => $patients, 'search' => $searchTerm, 'perPage' => $perPage];
    }

    public function save($request, int $id)
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

        $patient_validate["user_id"] = $id;

        Patient::create($patient_validate);
    }

    public function update($request, Patient $patient)
    {
        $patient->dob = $request->input('dob');
        $patient->gender = $request->input('gender');

        if ($request->hasFile('image')) {
            if ($patient->image && Storage::exists('public/uploads_patient/' . $patient->image)) {
                Storage::delete('public/uploads_patient/' . $patient->image);
            }
            $imagePath = $request->file('image')->store('uploads_patient', 'public');
            $patient->image = basename($imagePath);
        }

        $patient->save();
    }
}
