<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = AdminUser::paginate(15);
        return view('admin.admin_users.index', compact('admins'));
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.admin_users.profile', compact('admin'));
    }

    public function create() {
        return view('admin.admin_users.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);
    
        // Create the new admin user
        AdminUser::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);
        
        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user created successfully.');
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,'.$admin->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }

    public function show($id)
    {
        $admin = AdminUser::findOrFail($id);
        return view('admin.admin_users.show', compact('admin'));
    }

    public function edit($id)
    {
        $admin = AdminUser::findOrFail($id);
        return view('admin.admin_users.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = AdminUser::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,'.$admin->id,
            'role' => 'required|in:admin,super_admin',
        ]);
        $admin->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user updated successfully');
    }

    public function destroy($id)
    {
        $admin = AdminUser::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user deleted successfully');
    }
}
