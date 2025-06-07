<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\Venue;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $sports = Sport::with('venue')->paginate(15);
        return view('admin.sports.index', compact('sports'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('admin.sports.create', compact('venues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_name' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'court_count' => 'required|integer|min:0',
            'shared_with' => 'nullable|array',
            'shared_with.*' => 'string',
            'pricing_peak' => 'required|numeric|min:0',
            'pricing_non_peak' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descriptions' => 'nullable|string',
            'facilities' => 'nullable|string',
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('sports', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

        Sport::create($validated);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Sport created successfully');
    }

    public function show(Sport $sport)
    {
        $sport->load('venue');
        return view('admin.sports.show', compact('sport'));
    }

    public function edit(Sport $sport)
    {
        $venues = Venue::all();
        return view('admin.sports.edit', compact('sport', 'venues'));
    }

    public function update(Request $request, Sport $sport)
    {
        $validated = $request->validate([
            'sport_name' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'court_count' => 'required|integer|min:0',
            'shared_with' => 'nullable|array',
            'shared_with.*' => 'string',
            'pricing_peak' => 'required|numeric|min:0',
            'pricing_non_peak' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descriptions' => 'nullable|string',
            'facilities' => 'nullable|string',
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        // Handle image uploads
        $imagePaths = $sport->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('sports', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

        $sport->update($validated);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Sport updated successfully');
    }

    public function destroy(Sport $sport)
    {
        $sport->delete();
        return redirect()->route('admin.sports.index')
            ->with('success', 'Sport deleted successfully');
    }

    public function removeImage(Request $request, Sport $sport)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageToRemove = $request->input('image');
        $images = $sport->images ?? [];

        if (!in_array($imageToRemove, $images)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Remove image from array
        $images = array_filter($images, function ($img) use ($imageToRemove) {
            return $img !== $imageToRemove;
        });

        // Delete image file from storage
        \Storage::disk('public')->delete($imageToRemove);

        // Update sport images
        $sport->images = array_values($images);
        $sport->save();

        return response()->json(['message' => 'Image removed successfully']);
    }
}
