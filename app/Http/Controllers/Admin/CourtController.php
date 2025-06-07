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
            'court_type' => 'required|in:shared,dedicated',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('courts', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

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
            'court_type' => 'required|in:shared,dedicated',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePaths = $court->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('courts', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

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
                $courts = Court::where('status', 'active')->where('sport_id', $sport_id)->get(['id', 'court_name']);
                $arr = ['status' => '1', 'message' => 'Courts found.', 'courts' => $courts];
            }

            return response()->json($arr);
        } catch (\Exception $e) {
            return response()->json(['status' => '0', 'message' => $e->getMessage()]);
        }
    }

    public function removeImage(Request $request, Court $court)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageToRemove = $request->input('image');
        $images = $court->images ?? [];

        if (!in_array($imageToRemove, $images)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Remove image from array
        $images = array_filter($images, function ($img) use ($imageToRemove) {
            return $img !== $imageToRemove;
        });

        // Delete image file from storage
        \Storage::disk('public')->delete($imageToRemove);

        // Update court images
        $court->images = array_values($images);
        $court->save();

        return response()->json(['message' => 'Image removed successfully']);
    }
}
