<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile();

        return view('pages.profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subscribe_newsletter' => 'nullable|boolean',
        ]);

        // Update user data
        $user->update([
            'name' => trim($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $request->bio,
                'subscribe_newsletter' => $request->has('subscribe_newsletter'),
            ]
        );

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function showModal(User $user)
    {
        $profile = $user->profile;
        return view('profile.modal-content', [
            'user' => $user,
            'profile' => $profile ?? new UserProfile()
        ]);
    }
}
