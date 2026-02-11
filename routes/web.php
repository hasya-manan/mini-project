<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HRTeamMemberController;




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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
   
     // Page to show the form
    Route::get('/employees/create', [HRTeamMemberController::class, 'create'])->name('team.add-member.create');
    
    // Action to save the data
    Route::post('/employees', [HRTeamMemberController::class, 'store'])->name('team.add-member.store');
    
    
});
