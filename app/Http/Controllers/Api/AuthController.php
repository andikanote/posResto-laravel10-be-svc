<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Add this line

class AuthController extends Controller
{
    //Login
    public function login(Request $request)
    {
        //Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Check if the user exists and credentials are correct
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'User not found'
            ], 404);
        }

        //Check if the user is correctly
        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        //Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        //Send response
        return response()->json([
            'status' => 'Success',
            'message' => 'User logged in successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ],
            'token' => $token,
        ], 200);
    }
}
