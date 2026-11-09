<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit');
    }

    public function update(Request $request) {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|string|min:8',
            // Add other fields as necessary
        ]);

        if (!$request->filled('password')) {
            unset($validatedData['password']); // Remove password if not provided
        }

        // Update the user's profile
        $user = auth()->user();
        $user->update($validatedData);

        
        

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
