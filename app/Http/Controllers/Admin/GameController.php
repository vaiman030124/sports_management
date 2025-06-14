<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['sport'])->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'court_id' => 'nullable|exists:courts,id',
            'slot_id' => 'nullable|exists:slots,id',
            'group_id' => 'nullable|exists:groups,id',
            'is_split_payment' => 'boolean',
            'status' => 'required|in:pending,confirmed,canceled,completed',
        ]);

        // Check if slot is confirmed or booked
        if (isset($validated['slot_id'])) {
            $slot = \App\Models\Slot::find($validated['slot_id']);
            if (!$slot || in_array($slot->status, ['confirmed', 'booked'])) {
                return redirect()->back()->withInput()->withErrors(['slot_id' => 'Cannot create game for a slot that is already confirmed or booked.']);
            }
        }

        $validated['created_by'] = auth()->id();

        Game::create($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game created successfully');
    }

    public function show(Game $game)
    {
        return view('admin.games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'court_id' => 'nullable|exists:courts,id',
            'slot_id' => 'nullable|exists:slots,id',
            'group_id' => 'nullable|exists:groups,id',
            'is_split_payment' => 'boolean',
            'status' => 'required|in:pending,confirmed,canceled,completed',
        ]);

        // Check if slot is confirmed or booked
        if (isset($validated['slot_id'])) {
            $slot = \App\Models\Slot::find($validated['slot_id']);
            if (!$slot || in_array($slot->status, ['confirmed', 'booked'])) {
                return redirect()->back()->withInput()->withErrors(['slot_id' => 'Cannot update game for a slot that is already confirmed or booked.']);
            }
        }

        $game->update($validated);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game updated successfully');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')
            ->with('success', 'Game deleted successfully');
    }
}
