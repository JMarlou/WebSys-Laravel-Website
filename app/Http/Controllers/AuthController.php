<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * ============================================
 * AuthController
 * ============================================
 * Handles user authentication operations
 * - Login (display form & process)
 * - Logout
 * 
 * Security features:
 * - Session regeneration after login
 * - Token invalidation on logout
 * - Input validation
 */
class AuthController extends Controller
{
    /**
     * Display the login form
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Return the login view located at resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Process login authentication
     * 
     * This method validates credentials and logs the user in if valid.
     * Uses username (not email) for authentication.
     * 
     * @param Request $request - Contains form data (username, password)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // ========================================
        // STEP 1: Validate incoming request data
        // ========================================
        $credentials = $request->validate([
            'username' => 'required|string',  // Username is required and must be a string
            'password' => 'required|string',  // Password is required and must be a string
        ]);

        // ========================================
        // STEP 2: Find user by username
        // ========================================
        // Query the users table to find a user with the provided username
        $user = User::where('username', $credentials['username'])->first();

        // ========================================
        // STEP 3: Verify user exists and password matches
        // ========================================
        // Check if:
        // 1. User was found in database
        // 2. Password matches (using plain text comparison - NOT RECOMMENDED for production)
        // 
        // SECURITY WARNING: Plain text password comparison is insecure!
        // For production, use: Hash::check($credentials['password'], $user->password)
        if ($user && $user->password === $credentials['password']) {
            
            // ========================================
            // STEP 4: Log the user in
            // ========================================
            // Manually authenticate the user using Laravel's Auth facade
            Auth::login($user);
            
            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();
            
            // Redirect to the intended page (or dashboard by default)
            // intended() remembers where user was trying to go before login
            return redirect()->intended('/dashboard');
        }

        // ========================================
        // STEP 5: Authentication failed
        // ========================================
        // Return to login page with error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username'); // Keep username field filled, clear password
    }

    /**
     * Log the user out
     * 
     * This method:
     * 1. Logs out the authenticated user
     * 2. Invalidates the session
     * 3. Regenerates CSRF token
     * 4. Redirects to login page
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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