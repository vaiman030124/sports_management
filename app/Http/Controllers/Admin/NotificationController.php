<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['user'])->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::all()->where('status', 'active')->pluck('name', 'id');
        return view('admin.notifications.create',compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:unread,read'
        ]);

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification created successfully');
    }

    public function show(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        $users = User::all()->where('status', 'active')->pluck('name', 'id');
        return view('admin.notifications.edit', compact('notification','users'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:unread,read'
        ]);

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification updated successfully');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully');
    }
}
