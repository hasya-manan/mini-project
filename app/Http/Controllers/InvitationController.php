<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InvitationController extends Controller
{
    // Show the "Set Your Password" form
    public function show(Request $request, User $user)
    {
        // If the URL signature is invalid or expired, Laravel handles it 
        // via the 'signed' middleware we will add to the route.
        return Inertia::render('Auth/SetPassword', [
            'user' => $user,
        ]);
    }

    // Save the new password
    public function store(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Optional: Log them in immediately
        auth()->login($user);

        return redirect()->route('dashboard')->with('flash', [
            'banner' => 'Account activated! Welcome to the team.'
        ]);
    }
}