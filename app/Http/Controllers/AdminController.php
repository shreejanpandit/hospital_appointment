<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\DoctorUpdateRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDoctorUpdate(Doctor $doctor, DoctorUpdateRequest $request)
    {
        $adminService = new AdminService();
        $adminService->updateDoctor($doctor, $request);
        return redirect()->back()->with('status', [
            'message' => 'Doctor updated successfully',
            'type' => 'success'
        ]);
    }

    public function adminPatientUpdate(Patient $patient, Request $request)
    {
        $adminService = new AdminService();
        $adminService->updatePatient($patient, $request);

        return redirect()->back()->with('status', [
            'message' => 'Patient updated successfully',
            'type' => 'success'
        ]);
    }
}
