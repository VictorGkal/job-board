<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('/employer/dashboard', [\App\Http\Controllers\Employer\DashboardController::class, 'index'])
    ->name('employer.dashboard');

    Route::resource('employer/job-posts', \App\Http\Controllers\Employer\JobPostController::class)
        ->names('employer.job-posts');

    Route::get('employer/job-posts/{jobPost}/applications', [\App\Http\Controllers\Employer\ApplicationController::class, 'index'])
        ->name('employer.applications.index');

    Route::patch('employer/applications/{application}', [\App\Http\Controllers\Employer\ApplicationController::class, 'update'])
        ->name('employer.applications.update');

});

Route::middleware(['auth', 'candidate'])->group(function () {
    Route::get('/candidate/dashboard', [\App\Http\Controllers\Candidate\DashboardController::class, 'index'])
    ->name('candidate.dashboard');

    Route::get('candidate/job-posts', [\App\Http\Controllers\Candidate\JobPostController::class, 'index'])
        ->name('candidate.job-posts.index');

    Route::get('candidate/job-posts/{jobPost}', [\App\Http\Controllers\Candidate\JobPostController::class, 'show'])
        ->name('candidate.job-posts.show');

    Route::get('candidate/job-posts/{jobPost}/apply', [\App\Http\Controllers\Candidate\ApplicationController::class, 'create'])
        ->name('candidate.applications.create');

    Route::post('candidate/job-posts/{jobPost}/apply', [\App\Http\Controllers\Candidate\ApplicationController::class, 'store'])
        ->name('candidate.applications.store');

    Route::get('candidate/applications', [\App\Http\Controllers\Candidate\ApplicationController::class, 'index'])
        ->name('candidate.applications.index');
    
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
