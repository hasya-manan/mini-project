<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Mail\EmployeeWelcomeMail;
use App\Models\Department;
use App\Models\EmployeeDetail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;


/**
 * This is code that handle request about team member so every team
 *  Do not have to do check user_level anymore as we create the middleware system admin already!
 */
class HRTeamMemberController extends Controller
{
    use AuthorizesRequests;
    public function create()
    {      
        $user = auth()->user();
        
        // The Global Scope handles the "where team_id" (model department) part automatically so no need to fetch team_id
        return Inertia::render('Employee/Create', [
            'departments' => Department::all(), 
            'supervisors' => User::where('current_team_id', auth()->user()->current_team_id)->get(),
            'roles' => collect(Jetstream::$roles)
            ->filter(function ($role) use ($user) {
                // If I am NOT a Super Admin (Level 2), hide the 'superadmin' role
                if ($user->user_level < 2) {
                    return $role->key !== 'superadmin';
                }
                
                // If I AM a Super Admin, let me see everything
                return true; 
            })
            ->transform(function ($role) {
                return [
                    'key' => $role->key,
                    'name' => $role->name,
                    'description' => $role->description,
                ];
            })
            ->values(),
    ]);
    }
  
    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department_id' => 'required|exists:departments,id',
            'supervisor_id' => 'nullable|exists:users,id',
            'position' => 'nullable|string|max:255',
            'joined_date' => 'required|date',
            'role' => 'required|string', // Add this
        ], [
    // Customizing the message (Optional)
        'email.unique' => 'This email is already assigned to an existing employee.',
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
            $currentTeam->users()->attach($user, ['role' => $request->role]);
            // 3. Create the Employee Profile (Work Data)
            EmployeeDetail::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'supervisor_id' => $request->supervisor_id,
                'position' => $request->position,
                'joined_date' => $request['joined_date']
            ]);
            
            // TODO: Send the "Set Your Password" email here
            // Generate a temporary signed URL to a route named 'accept.invitation'
            $invitationUrl = URL::temporarySignedRoute(
            'accept.invitation', 
            now()->addDays(3), 
            ['user' => $user->id]
            );

        // Send the Welcome Email with this $invitationUrl
            Mail::to($user->email)->send(new EmployeeWelcomeMail($user, $invitationUrl));
            });

        return redirect()->route('dashboard')->with('flash', [
            'banner' => 'Employee invited successfully!'
        ]);
    }
}
