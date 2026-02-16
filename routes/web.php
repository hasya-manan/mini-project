<?php

use App\Http\Controllers\Api\ValidationController;
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
Route::controller(InvitationController::class)->group(function () {
    Route::get('/accept-invitation/{user}', 'show')->name('accept.invitation')->middleware('signed');
    Route::post('/accept-invitation/{user}', 'store')->name('accept.invitation.store');
});
    
// 3. Authenticated Routes (Logged in users)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /**
     * SHARED VALIDATION (Any logged-in user)
     * Even regular employees might need to validate things, 
     * but usually, this is for HR/Admins.
     */
    Route::prefix('validate')->group(function () {
        Route::post('/email', [ValidationController::class, 'checkEmail'])->name('validate.email');
    });

    /**
     * ==========================================
     * HR/ADMIN ADD MEMBER ROUTE HERE
     * ==========================================
     * SYSADMIN (Level 1) - HR / Admin (SystemAdmin Middleware)
     */
     
    Route::middleware(['sysadmin'])->group(function () {
        Route::get('/employees/create', [HRTeamMemberController::class, 'create'])->name('team.add-member.create');
        Route::post('/employees', [HRTeamMemberController::class, 'store'])->name('team.add-member.store');
    });

    /**
     * ==========================================
     * SUPER ADMIN (Level 2) - System Owner
     * ==========================================
     * 'superadmin' middleware (SuperAdmin Middleware)
     */
    Route::middleware(['superadmin'])->group(function () {
        Route::get('/super-admin/dashboard', function () {
            return "Welcome, Boss. You can see all companies here.";
        })->name('superadmin.dashboard');
    });

});


