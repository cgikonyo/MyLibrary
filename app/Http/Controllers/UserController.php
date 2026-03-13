<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show the form
    public function create()
    {
        $users = User::all(); //Fetch Everyone from the database
        return view('users.create', compact('users'));
    }

    // Save the user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Always hash passwords!
        ]);

        return redirect()->back()->with('success', 'User saved successfully!');
    }

    public function index()
    {
        //fetch all users sorted by newest first
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    //show edit form
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //update user data
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    //delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
