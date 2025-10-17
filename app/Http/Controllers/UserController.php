<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 🔒 Admin-only access check
    private function checkAdmin()
    {
        $user = Auth::user();

        // Ensure user has a role and check role_name
        if (!$user || !$user->role || strtolower($user->role->role_name) !== 'admin') {
            abort(403, 'Unauthorized - Only Admin can access users.');
        }
    }

    // 🟢 Show users list
    public function index()
    {
        $this->checkAdmin();
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    // 🟢 Show Add User form
    public function create()
    {
        $this->checkAdmin();
        $roles = Role::all(); // fetch roles from roles table
        return view('users.create', compact('roles'));
    }

    // 🟢 Store new user
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id'  => $request->role_id, // store role id
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }

    // 🟢 Show Edit form
    public function edit($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // 🟢 Update user
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role_id'  => 'required|exists:roles,id',
            'password' => 'nullable|min:6',
        ]);

        $updateData = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // 🟢 Delete user
    public function destroy($id)
    {
        $this->checkAdmin();
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}

