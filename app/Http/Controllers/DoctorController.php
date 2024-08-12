<?php

namespace App\Http\Controllers;

use App\Http\Requests\doctor\DoctorStoreRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
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
        $departments = Department::all();
        return view('doctor.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
    {
        $doctor_validate = $request->all();

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads_doctor'), $name);
        $doctor_validate['image'] = $name;
        $user = Auth::user();
        $doctor_validate["user_id"] = $user->id;
        // dd($doctor_validate);
        Doctor::create($doctor_validate);
        return redirect()->route('doctor.dashboard');
    }

    public function dashboard()
    {
        return view('doctor.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
