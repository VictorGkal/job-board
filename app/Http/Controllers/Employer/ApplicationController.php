<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(JobPost $jobPost)
    {
        // Make sure the job post belongs to the logged in employer
        if ($jobPost->user_id !== auth()->id()) {
            abort(403);
        }

        $applications = $jobPost->applications()->with('candidate')->latest()->get();
        return view('employer.applications.index', compact('jobPost', 'applications'));
    }

    public function update(Request $request, Application $application)
    {
        // Make sure the application belongs to the logged in employer's job post
        if ($application->jobPost->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
        ]);

        $application->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Application status updated!');
    }
}