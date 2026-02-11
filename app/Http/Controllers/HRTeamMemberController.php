<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;


/**
 * This is code that handle request about team member so every team
 */
class HRTeamMemberController extends Controller
{
        use AuthorizesRequests;

    public function create()
{
    // Fetch departments linked to the HR Admin's current team
    $departments = \App\Models\Department::where('team_id', auth()->user()->current_team_id)->get();

    return Inertia::render('Employee/Create', [
        'departments' => $departments
    ]);
}
  
    public function store(Request $request)
    {
        // 1. Grab the current company (The HR Admin's team)
    $team = auth()->user()->currentTeam;

    // 2. Create the User (Password is a random string for now)
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make(Str::random(32)), 
        'user_level' => 0, 
        'current_team_id' => $team->id, // Lock them to this company
    ]);

    // 3. Attach them to the Jetstream team table so they show up in 'Team Settings'
    $team->users()->attach($user, ['role' => 'employee']);

    // 4. Send the Invitation Email
    // (We will generate the 'Set Password' link here)

        // send welcome email
       // \Mail::to($user->email)->send(new \App\Mail\WelcomeUser($user, $temporaryPassword));

        return back()->with('success', 'Team member added successfully.');
    }
}
