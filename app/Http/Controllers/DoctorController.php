<?php

namespace App\Http\Controllers;

use App\Http\Requests\doctor\DoctorStoreRequest;
use App\Http\Requests\doctor\DoctorUpdateRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $doctorService = new DoctorService();
        $data =  $doctorService->show($request->input('search'));
        $data['currentPage'] = $request->input('page', 1);
        return view('doctor.index', $data);
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
        $user = Auth::user();

        $doctorService = new DoctorService();
        $doctorService->save($request, $user->id);

        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'Doctor Created sucessfully',
            'type' => 'success'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor, Request $request)
    {
        $department_id = $request->input('department_id');
        $department_doctors = Doctor::where('department_id', $department_id)->get();

        return view('doctor.show', [
            'department_doctors' => $department_doctors,
            'patient_id' => $request->input('patient_id'),
            'department_id' => $department_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $departments = Department::all();
        return view('doctor.edit', compact('doctor', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {

        $doctorService = new DoctorService();
        $doctorService->update($request, $doctor);

        return redirect()->back()->with('status', [
            'message' => 'Doctor updated successfully',
            'type' => 'success'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctor.index')->with('status', [
            'message' =>  'Dr.' . $doctor->user->name .  ' has been deleted successfully.',
            'type' => 'failure'
        ]);
    }
}
