<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Jetstream\TeamInvitation;

class AcceptInvitationController extends Controller
{

    public function index()
    {
    $invitations = TeamInvitation::all();


    return inertia('Dashboard', [
        'invitations' => $invitations,
    ]);
    }
    // public function accept(TeamInvitation $invitation)
    // {
    //     abort_if(
    //         $invitation->email !== auth()->user()->email,
    //         403
    //     );

    //     $invitation->team->users()->attach(
    //         auth()->id(),
    //         ['role' => $invitation->role]
    //     );

    //     $invitation->delete();

    //     return back();
    // }
}
