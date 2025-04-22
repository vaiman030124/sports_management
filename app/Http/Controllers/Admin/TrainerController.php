<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\AdminUser;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with(['adminUser','trainerSport'])->paginate(15);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        $admin_users = AdminUser::all();
        $sports = Sport::all();
        return view('admin.trainers.create',compact('admin_users','sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_kid_trainer' => 'required|in:1,0',
            'is_adult_trainer' => 'required|in:1,0',
            'sports' => 'required|integer',
            'admin_user_id' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable'
        ]);

        if ($request->hasFile('photo')) {
            $directory = 'public/trainer';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $path = $request->file('photo')->store('photo', 'public');
            $validated['photo'] = $path;
        }

        Trainer::create($validated);

        return redirect()->route('admin.trainers.index')
            ->with('success', 'Trainer created successfully');
    }

    public function show(Trainer $trainer)
    {
        return view('admin.trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer)
    {
        $admin_users = AdminUser::all();
        $sports = Sport::all();
        return view('admin.trainers.edit', compact('trainer','admin_users','sports'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_kid_trainer' => 'required|in:1,0',
            'is_adult_trainer' => 'required|in:1,0',
            'sports' => 'required|integer',
            'admin_user_id' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
        ]);

        $trainer->name = $validated['name'];
        $trainer->is_kid_trainer = $validated['is_kid_trainer'];
        $trainer->is_adult_trainer = $validated['is_adult_trainer'];
        $trainer->sports = $validated['sports'];
        $trainer->admin_user_id = $validated['admin_user_id'];
        $trainer->status = $validated['status'];
        $trainer->description = isset($validated['description']) ?? null;

        if ($request->hasFile('photo')) {
            // Optional: delete old image
            if ($trainer->photo && Storage::exists($trainer->photo)) {
                Storage::delete($trainer->photo);
            }

            $path = $request->file('photo')->store('photo', 'public');
            $trainer->photo = $path;
        }

        $trainer->save();

        return redirect()->route('admin.trainers.index')
            ->with('success', 'Trainer updated successfully');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('admin.trainers.index')
            ->with('success', 'Trainer deleted successfully');
    }
}
