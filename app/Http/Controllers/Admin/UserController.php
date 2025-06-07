<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Sport;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $sports = Sport::where('status', 'active')->get();
        return view('admin.users.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sport_played' => 'nullable|array',
            'sport_played.*' => 'string',
            'level' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $directory = 'public/profile_images';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $validated['profile_image'] = $path;
        }

        // Hash the password before saving
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $sports = Sport::where('status', 'active')->get();
        // Remove json_decode because sport_played is already cast as array
        // $user->sport_played = json_decode($user->sport_played, true);
        return view('admin.users.edit', compact('user', 'sports'));
    }

    public function update(Request $request, User $user)
    {    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sport_played' => 'nullable|array',
            'sport_played.*' => 'string',
            'level' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            // Optional: delete old image
            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        if (isset($validated['sport_played'])) {
            $user->sport_played = json_encode($validated['sport_played']);
        } else {
            $user->sport_played = null;
        }

        $user->level = $validated['level'];
        $user->location = $validated['location'];

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
