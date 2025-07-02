<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    //Index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('pages.user.index', compact('users'));
    }

    //Create
    public function create()
    {
        return view('pages.user.create');
    }

    //Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'roles' => 'required|in:ADMIN,STAFF,USER', // Validate against allowed values
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Pastikan roles uppercase
        $validated['roles'] = strtoupper($validated['roles']);

        User::create($validated);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    //Show
    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        if(request()->ajax()) {
            return response()->json($user);
        }

        return view('user.show', compact('user'));
    }

    //Edit
    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    //Update
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'roles' => 'required|in:ADMIN,STAFF,USER',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->roles = strtoupper($validated['roles']); // Pastikan uppercase
        $user->phone = $validated['phone'] ?? $user->phone;

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Tambahkan ini untuk memastikan updated_at terupdate
        $user->touch(); // Ini akan mengupdate updated_at

        // Atau alternatifnya:
        // $user->updated_at = now();

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

