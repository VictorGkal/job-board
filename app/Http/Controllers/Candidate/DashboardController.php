<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalApplications = auth()->user()->applications()->count();
        $pendingApplications = auth()->user()->applications()->where('status', 'pending')->count();
        $reviewedApplications = auth()->user()->applications()->where('status', 'reviewed')->count();
        $acceptedApplications = auth()->user()->applications()->where('status', 'accepted')->count();
        $rejectedApplications = auth()->user()->applications()->where('status', 'rejected')->count();

        return view('candidate.dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'reviewedApplications',
            'acceptedApplications',
            'rejectedApplications'
        ));
    }
}