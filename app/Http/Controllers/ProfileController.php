<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $profileData = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        return response()->json($profileData);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }

        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }

        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }
}
