<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Sport;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::all();
        return view('admin.courts.index', compact('courts'));
    }

    public function create()
    {
        $sports = Sport::all()->where('status', 'active')->pluck('sport_name', 'id');
        return view('admin.courts.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive,maintenance',
            'court_type' => 'required|in:shared,dedicated'
        ]);

        Court::create($validated);

        return redirect()->route('admin.courts.index')->with('success', 'Court created successfully');
    }

    public function show(Court $court)
    {
        return view('admin.courts.show', compact('court'));
    }

    public function edit(Court $court)
    {
        $sports = Sport::all()->where('status', 'active')->pluck('sport_name', 'id');
        return view('admin.courts.edit', compact('court', 'sports'));
    }

    public function update(Request $request, Court $court)
    {
        $validated = $request->validate([
            'court_name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive,maintenance',
            'court_type' => 'required|in:shared,dedicated'
        ]);

        $court->update($validated);

        return redirect()->route('admin.courts.index')->with('success', 'Court updated successfully');
    }

    public function destroy(Court $court)
    {
        $court->delete();
        return redirect()->route('admin.courts.index')
            ->with('success', 'Court deleted successfully');
    }

    public function getCourtListBySports(Request $request) {
        try {
            $arr = ['status' => '0', 'message' => 'Courts not found.'];

            $sport_id = $request->sport_id ?? 0;

            if($sport_id > 0) {
                $courts = Court::all()->where('status', 'active')->where('sport_id', $sport_id);
                $arr = ['status' => '1', 'message' => 'Courts found.', 'courts' => $courts];
            }

            return response()->json($arr);
        } catch (\Exception $e) {
            return response()->json(['status' => '0', 'message' => $e->getMessage()]);
        }
    }
}
