<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::paginate(15);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('admin.trainers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers',
            'phone' => 'required|string|max:15',
            'status' => 'required|in:active,inactive'
        ]);

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
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email,'.$trainer->id,
            'phone' => 'required|string|max:15',
            'status' => 'required|in:active,inactive'
        ]);

        $trainer->update($validated);

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
