<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * AuthController
 * Handles user authentication operations
 * - Login (display form & process)
 * - Logout
 */
class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Return the login view located at resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * This method validates credentials and logs the user in if valid.
     * Uses username for authentication.
     */
    
    public function login(Request $request)
    {
        // STEP 1: Validate incoming request data
        $credentials = $request->validate([
            'username' => 'required|string',  
            'password' => 'required|string',
        ]);

        // STEP 2: Find user by username
        // Query the users table to find a user with the provided username
        $user = User::where('username', $credentials['username'])->first();

        // STEP 3: Verify user exists and password matches
        if ($user && $user->password === $credentials['password']) {
            
            // STEP 4: Log the user in
            Auth::login($user);
            $request->session()->regenerate();
            
            // Redirect to the intended page (or dashboard by default)
            // intended() remembers where user was trying to go before login
            return redirect()->intended('/dashboard');
        }
        // STEP 5: Authentication failed
        // Return to login page with error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username'); // Keep username field filled, clear password
    }

    public function logout(Request $request)
    {
        // Log the current user out
        Auth::logout();
        
        // Invalidate the current session (delete all session data)
        $request->session()->invalidate();
        
        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();
        
        // Redirect to login page
        return redirect('/login');
    }
}