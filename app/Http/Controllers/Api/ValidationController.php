<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function checkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);
        $exists = User::where('email', $request->email)->exists();
        return response()->json([
         'available' => !$exists,
         'message' => $exists ? 'This email is already taken.' : 'Email is available.'
       ]);
    }
}
