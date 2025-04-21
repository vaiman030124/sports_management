<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
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
        return view('admin.slots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'status' => 'required|in:available,booked,maintenance'
        ]);

        Slot::create($validated);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Slot created successfully');
    }

    public function show(Slot $slot)
    {
        return view('admin.slots.show', compact('slot'));
    }

    public function edit(Slot $slot)
    {
        return view('admin.slots.edit', compact('slot'));
    }

    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'status' => 'required|in:available,booked,maintenance'
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
