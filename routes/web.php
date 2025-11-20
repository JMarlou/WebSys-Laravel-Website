<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// =====================================
// PUBLIC ROUTES
// =====================================

// Home page - redirect to login
Route::get('/', function () {
    return redirect('/login');
});

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Public resume view - anyone can see this
Route::get('/resume/{id?}', [UserController::class, 'showPublicResume'])->name('public.resume');

// =====================================
// PROTECTED ROUTES (Require Authentication)
// =====================================

Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Update personal information
    Route::post('/update-resume', [UserController::class, 'updateResume'])->name('update.resume');
    
    // Education CRUD
    Route::post('/education/add', [UserController::class, 'addEducation'])->name('education.add');
    Route::post('/education/update/{id}', [UserController::class, 'updateEducation'])->name('education.update');
    Route::delete('/education/delete/{id}', [UserController::class, 'deleteEducation'])->name('education.delete');
    
    // Skills CRUD
    Route::post('/skill/add', [UserController::class, 'addSkill'])->name('skill.add');
    Route::delete('/skill/delete/{id}', [UserController::class, 'deleteSkill'])->name('skill.delete');
    
    // Experience CRUD
    Route::post('/experience/add', [UserController::class, 'addExperience'])->name('experience.add');
    Route::post('/experience/update/{id}', [UserController::class, 'updateExperience'])->name('experience.update');
    Route::delete('/experience/delete/{id}', [UserController::class, 'deleteExperience'])->name('experience.delete');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});