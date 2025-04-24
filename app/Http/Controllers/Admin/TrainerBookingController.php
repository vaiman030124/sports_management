<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerBooking;
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\User;

class TrainerBookingController extends Controller
{
    public function index()
    {
        $bookings = TrainerBooking::with(['user', 'trainer'])->paginate(15);
        return view('admin.trainer_bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all()->where('status', 'active')->pluck('name', 'id');
        $trainers = Trainer::all()->where('status', 'active')->pluck('name', 'id');
        return view('admin.trainer_bookings.create', compact('users', 'trainers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'trainer_id' => 'required|exists:trainers,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'booking_end_time' => 'required|date_format:H:i|after:booking_time',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        TrainerBooking::create($validated);

        return redirect()->route('admin.trainer_bookings.index')->with('success', 'Trainer booking created successfully');
    }

    public function show(TrainerBooking $trainerBooking)
    {
        return view('admin.trainer_bookings.show', compact('trainerBooking'));
    }

    public function edit(TrainerBooking $trainerBooking)
    {
        $users = User::all()->where('status', 'active')->pluck('name', 'id');
        $trainers = Trainer::all()->where('status', 'active')->pluck('name', 'id');
        return view('admin.trainer_bookings.edit', compact('trainerBooking', 'users', 'trainers'));
    }

    public function update(Request $request, TrainerBooking $trainerBooking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'trainer_id' => 'required|exists:trainers,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'booking_end_time' => 'required|date_format:H:i|after:booking_time',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $trainerBooking->update($validated);

        return redirect()->route('admin.trainer_bookings.index')->with('success', 'Trainer booking updated successfully');
    }

    public function destroy(TrainerBooking $trainerBooking)
    {
        $trainerBooking->delete();
        return redirect()->route('admin.trainer_bookings.index')->with('success', 'Trainer booking deleted successfully');
    }
}
