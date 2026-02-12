<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EmployeeDetail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;


/**
 * This is code that handle request about team member so every team
 */
class HRTeamMemberController extends Controller
{
        use AuthorizesRequests;

    // TODO: added the Global Scope to Department model , so can actually make it even cleaner. can find it inside 
    // model department
    public function create()

    {
        // The Global Scope handles the "where team_id" (model department) part automatically so no need to fetch team_id
        return Inertia::render('Employee/Create', [
            'departments' => Department::all(), 
            'supervisors' => User::where('current_team_id', auth()->user()->current_team_id)->get(),
    ]);
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department_id' => 'required|exists:departments,id',
            'position' => 'nullable|string|max:255',
            'joined_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $currentTeam = auth()->user()->currentTeam;

            // 1. Create the User (Account)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(32)), // Random password until they set it
                'user_level' => 0, // Employee level
                'current_team_id' => $currentTeam->id,
            ]);

            // 2. Attach to Jetstream Team (Crucial for Jetstream permissions)
            $currentTeam->users()->attach($user, ['role' => 'employee']);

            // 3. Create the Employee Profile (Work Data)
            EmployeeDetail::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'supervisor_id' => $request->supervisor_id,
                'position' => $request->position,
                'joined_date' => $request['joined_date']
            ]);
            
            // TODO: Send the "Set Your Password" email here
        });

        return redirect()->route('dashboard')->with('flash', [
            'banner' => 'Employee invited successfully!'
        ]);
    }
}
