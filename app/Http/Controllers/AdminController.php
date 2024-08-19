<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // $patient = auth()->user()->patient; // Assuming each user is also a patient
        $total_patient = Patient::count();
        $total_doctor = Doctor::count();
        $total_appointment = Appointment::count();
        $data_count = [
            'total_patient' => $total_patient,
            'total_doctor' => $total_doctor,
            'total_appointment' => $total_appointment
        ];
        // Pass relevant data to the view
        return view('admin.dashboard', $data_count);
    }
}
