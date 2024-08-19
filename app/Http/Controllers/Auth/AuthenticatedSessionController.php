<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $test = $request->session()->regenerate();
        // dd($test);
        if ($test) {
            $user = Auth::user()->role;
            // Redirect to appropriate form based on role
            if ($user === 'patient') {
                return redirect()->route('patient.dashboard')->with('status', [
                    'message' => 'Patient Login sucessfully',
                    'type' => 'success'
                ]);
            }

            if ($user === 'doctor') {
                return redirect()->route('doctor.dashboard')->with('status', [
                    'message' => 'Doctor Login sucessfully',
                    'type' => 'success'
                ]);
            }
            if ($user === 'admin') {
                return redirect()->route('admin.dashboard')->with('status', [
                    'message' => 'Admin Login sucessfully',
                    'type' => 'success'
                ]);
            }
        } else return "error";
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
