<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class HRTeamMemberController extends Controller
{
        use AuthorizesRequests;

    public function create()
    {
         $team = auth()->user()->currentTeam;

        $this->authorize('addTeamMember', $team);
        return Inertia::render('Teams/RegisterTeam');
    }
  
    public function store(Request $request)
    {
        $team = auth()->user()->currentTeam;
        $this->authorize('addTeamMember', $team);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:manager,employee',
        ]);

        // create user with temporary password
        $temporaryPassword = 'user1234';


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
        ]);

        // attach to HR's team
        auth()->user()->currentTeam->users()->attach($user->id, [
            'role' => $request->role,
        ]);

        // send welcome email
       // \Mail::to($user->email)->send(new \App\Mail\WelcomeUser($user, $temporaryPassword));

        return back()->with('success', 'Team member added successfully.');
    }
}
