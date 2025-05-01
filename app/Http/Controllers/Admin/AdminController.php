<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use App\Models\Transaction;
use App\Models\Membership;

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
        $_totalBookings = Booking::whereNotIn('status', ['canceled'])->count();
        $_totalUser = User::where('status', 'active')->count();
        $_totalVenue = Venue::where('status', 'active')->count();
        $_totalBookingRevenue = Transaction::whereNotIn('status', ['refunded', 'failed', 'pending'])->sum('amount');
        $_totalMemberShipRevenue = Membership::leftJoin('membership_plans', 'memberships.plan_id', '=', 'membership_plans.id')->where('status', 'active')->whereRaw('? between start_date and end_date', [date('Y-m-d')])->sum('membership_plans.price');

        // Get Recent Booking
        $_recentBooking = Booking::whereNotIn('status', ['canceled'])->orderBy('id', 'DESC')->limit(10)->get();

        // Get Recent Transaction
        $_recentTransaction = Transaction::select('amount', 'status', 'transaction_date')->orderBy('id', 'DESC')->limit(10)->get();
        
        return view('admin.dashboard', compact('_totalBookings', '_totalUser', '_totalVenue', '_totalBookingRevenue', '_totalMemberShipRevenue', '_recentBooking', '_recentTransaction'));
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

     /**
     * Get booking event for calendar.
     */
    public function bookings()
    {
        try {
            $data = Booking::whereNotIn('status', ['canceled', 'complete'])->get();

            if(empty($data)) {
                $data = [
                    "status" => 0
                ];
            } else {
                $events = [];
                foreach ($data as $key => $value) {
                    $events[] = array(
                        'title' => $value->user->name,
                        'start' => $value->booking_date->format('Y-m-d'),
                        'end' => $value->booking_date->format('Y-m-d'),
                        'venue' => $value->venue->venue_name,
                        'court' => $value->court->court_name,
                        'sport' => $value->sport->sport_name,
                        'time_slot' => $value->slot->slot_time . " - " . $value->slot->slot_end_time,
                    );
                }

                $data = [
                    'status' => 1,
                    'events' => $events
                ];
            }

            return response()->json($data);
        } catch (\Throwable $th) {
            $data = [
                "status" => 0
            ];

            return response()->json($data);
        }
    }
}
