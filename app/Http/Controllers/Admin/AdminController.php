<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the admin out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Load Sports wise booking chart.
     */
    public function sportWiseBooking()
    {
        try {
            $data = DB::select("SELECT COUNT(bookings.id) AS y, sports.sport_name AS name FROM sports LEFT JOIN bookings ON sports.id = bookings.sport_id AND bookings.booking_date >= CURDATE() AND bookings.status IN ('pending', 'confirmed') GROUP BY sports.id;");

            if(empty($data)) {
                $data = [
                    [
                        "name" => "No Sport",
                        "y" => 0
                    ]
                ];
            }

            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                "name" => 'No Sport',
                "y" => '0',
            ];

            return response()->json($data);
        }
    }
}
