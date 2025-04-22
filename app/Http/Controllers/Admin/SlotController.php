<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Models\Court;
use App\Models\Sport;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::paginate(15);
        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        $sports = Sport::all()->where('status', 'active')->pluck('sport_name', 'id');
        return view('admin.slots.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,sports.id',
            'court_id' => 'required|exists:courts,courts.id',
            'slot_date' => 'required|date',
            'slot_time' => 'required|date_format:H:i',
            'slot_end_time' => 'required|date_format:H:i|after:slot_time',
            'is_member_slot' => 'required|in:1,0',
            'max_players' => 'required|integer|min:4',
            'available_slots' => 'required|integer|min:1',
            'is_peak_hour' => 'required|in:1,0',
            'status' => 'required|in:available,booked,blocked'
        ]);

        Slot::create($validated);

        return redirect()->route('admin.slots.index')->with('success', 'Slot created successfully');
    }

    public function show(Slot $slot)
    {
        return view('admin.slots.show', compact('slot'));
    }

    public function edit(Slot $slot)
    {
        $courts = Court::all()->where('status', 'active')->where('sport_id', $slot->sport_id);
        $sports = Sport::all()->where('status', 'active')->pluck('sport_name', 'id');
        return view('admin.slots.edit', compact('slot', 'courts', 'sports'));
    }

    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,sports.id',
            'court_id' => 'required|exists:courts,courts.id',
            'slot_date' => 'required|date',
            'slot_time' => 'required|date_format:H:i',
            'slot_end_time' => 'required|date_format:H:i|after:slot_time',
            'is_member_slot' => 'required|in:1,0',
            'max_players' => 'required|integer|min:4',
            'available_slots' => 'required|integer|min:1',
            'is_peak_hour' => 'required|in:1,0',
            'status' => 'required|in:available,booked,blocked'
        ]);

        $slot->update($validated);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot updated successfully');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();
        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot deleted successfully');
    }
}
