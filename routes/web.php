<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HRTeamMemberController;
use App\Http\Controllers\AcceptInvitationController;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [AcceptInvitationController::class, 'index'])
        ->name('dashboard');

     // Accept invitation
    Route::post(
        '/invitations/{invitation}/accept',
        [AcceptInvitationController::class, 'accept']
    )->name('invitations.accept');

    /**
     * ==========================================
     *     HR ADD MEMBER ROUTE HERE
     * ==========================================
     */
    Route::get('/team/add-member', [HRTeamMemberController::class, 'create'])
        ->name('team.add-member');

    Route::post('/team/add-member', [HRTeamMemberController::class, 'store']);
    
});
