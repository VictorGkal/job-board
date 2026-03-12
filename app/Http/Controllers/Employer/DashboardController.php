<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJobs = auth()->user()->jobPosts()->count();
        $openJobs = auth()->user()->jobPosts()->where('status', 'open')->count();
        $closedJobs = auth()->user()->jobPosts()->where('status', 'closed')->count();
        $totalApplications = Application::whereHas('jobPost', function($query) {
            $query->where('user_id', auth()->id());
        })->count();
        $pendingApplications = Application::whereHas('jobPost', function($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'pending')->count();
        $acceptedApplications = Application::whereHas('jobPost', function($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'accepted')->count();

        return view('employer.dashboard', compact(
            'totalJobs',
            'openJobs',
            'closedJobs',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications'
        ));
    }
}