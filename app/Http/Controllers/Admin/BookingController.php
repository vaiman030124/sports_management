<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Group;
use App\Models\Trainer;
use App\Models\Venue;
use App\Models\Court;
use App\Models\Sport;
use App\Models\Slot;
use App\Models\Game;
use App\Models\Membership;
use App\Models\Transaction;
use App\Models\Refund;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'group', 'trainer', 'venue', 'court', 'sport', 'slot', 'game', 'membership', 'payment', 'refund'])->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $groups = Group::all();
        $trainers = Trainer::all();
        $venues = Venue::all();
        $courts = Court::all();
        $sports = Sport::all();
        $slots = Slot::all();
        $games = Game::all();
        $memberships = Membership::all();
        $payments = Transaction::all();
        $refunds = Refund::all();

        return view('admin.bookings.create', compact('users', 'groups', 'trainers', 'venues', 'courts', 'sports', 'slots', 'games', 'memberships', 'payments', 'refunds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'venue_id' => 'nullable|exists:venues,id',
            'court_id' => 'required|exists:courts,id',
            'sport_id' => 'required|exists:sports,id',
            'slot_id' => 'required|exists:slots,id',
            'is_member_booking' => 'boolean',
            'is_group_game' => 'boolean',
            'game_id' => 'nullable|exists:games,id',
            'membership_id' => 'nullable|exists:memberships,id',
            'booking_date' => 'required|date',
            'number_of_players' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_id' => 'nullable|exists:transactions,id',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'refund_id' => 'nullable|exists:refunds,id',
        ]);

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'group', 'trainer', 'venue', 'court', 'sport', 'slot', 'game', 'membership', 'payment', 'refund']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $users = User::all();
        $groups = Group::all();
        $trainers = Trainer::all();
        $venues = Venue::all();
        $courts = Court::all();
        $sports = Sport::all();
        $slots = Slot::all();
        $games = Game::all();
        $memberships = Membership::all();
        $payments = Transaction::all();
        $refunds = Refund::all();

        return view('admin.bookings.edit', compact('booking', 'users', 'groups', 'trainers', 'venues', 'courts', 'sports', 'slots', 'games', 'memberships', 'payments', 'refunds'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'venue_id' => 'nullable|exists:venues,id',
            'court_id' => 'required|exists:courts,id',
            'sport_id' => 'required|exists:sports,id',
            'slot_id' => 'required|exists:slots,id',
            'is_member_booking' => 'boolean',
            'is_group_game' => 'boolean',
            'game_id' => 'nullable|exists:games,id',
            'membership_id' => 'nullable|exists:memberships,id',
            'booking_date' => 'required|date',
            'number_of_players' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_id' => 'nullable|exists:transactions,id',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'refund_id' => 'nullable|exists:refunds,id',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully');
    }
}
