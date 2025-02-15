<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|in:admin,moderator,employee',
    ]);

    $user->update([
        'name' => $request->name,
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

}

