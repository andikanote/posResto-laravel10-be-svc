<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    //Index
    public function index()
    {
        // Get Users Pagination
        $users = \App\Models\User::paginate(10);
        return view('pages.user.index', compact('users'));
    }

    //Create
    public function create()
    {
        return view('user.create');
    }

    //Store
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    //Show
    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    //Edit
    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    //Update
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        // Find the user by ID
        $user = User::findOrFail($id);
        // Update the user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    //Destroy
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        // Delete the user
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}

