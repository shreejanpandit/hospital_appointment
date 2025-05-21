<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardAdmin()
    {
        $dashboardService = new DashboardService();

        return view('admin.dashboard', $dashboardService->admin());
    }

    public function dashboardPatient()
    {
        $user = Auth::user();
        $dashboardService = new DashboardService();
        return view('patient.dashboard', $dashboardService->patient($user));
    }

    public function dashboardDoctor()
    {
        $user = Auth::user();
        $dashboardService = new DashboardService();
        return view('doctor.dashboard', $dashboardService->doctor($user));
    }
}
