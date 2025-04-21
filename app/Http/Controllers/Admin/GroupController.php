<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\User;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with(['creator'])->paginate(15);
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'created_by' => 'required|integer',
            'status' => 'required|in:active,inactive'
        ]);

        Group::create($validated);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group created successfully');
    }

    public function show(Group $group)
    {
        return view('admin.groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        $users = User::all();
        return view('admin.groups.edit', compact('group','users'));
    }

    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'created_by' => 'required|integer',
            'status' => 'required|in:active,inactive'
        ]);

        $group->update($validated);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Group updated successfully');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index')
            ->with('success', 'Group deleted successfully');
    }
}
