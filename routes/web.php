<?php

use App\Http\Controllers\HRTeamMemberController;
use App\Http\Controllers\InvitationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

  /**
     * =====================================================
     *     New employee accept invitation to insert password
     * =====================================================
     */
// The 'signed' middleware ensures the link hasn't been tampered with
Route::get('/accept-invitation/{user}', [InvitationController::class, 'show'])
    ->name('accept.invitation')
    ->middleware('signed');

Route::post('/accept-invitation/{user}', [InvitationController::class, 'store'])
    ->name('accept.invitation.store');

    
// This group is ONLY accessible if:
// 1. User is logged in (auth)
// 2. User has user_level 2 (sysadmin)
Route::middleware(['auth', 'sysadmin'])->group(function () {
    
    Route::get('/super-admin/dashboard', function () {
        return "Welcome, Boss. You can see all companies here.";
    })->name('superadmin.dashboard');

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /**
     * ==========================================
     *     HR/ADMIN ADD MEMBER ROUTE HERE
     * ==========================================
     */
   
    Route::middleware(['sysadmin'])->group(function () {
        // Page to show the form
        Route::get('/employees/create', [HRTeamMemberController::class, 'create'])
            ->name('team.add-member.create');
        
        // Action to save the data
        Route::post('/employees', [HRTeamMemberController::class, 'store'])
            ->name('team.add-member.store');
    });
    
    
});
