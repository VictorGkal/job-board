<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create(JobPost $jobPost)
    {
        return view('candidate.applications.create', compact('jobPost'));
    }

    public function store(Request $request, JobPost $jobPost)
    {
        // Check if already applied
        $alreadyApplied = Application::where('user_id', auth()->id())
            ->where('job_post_id', $jobPost->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()
                ->with('error', 'You have already applied to this job!');
        }

        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string'],
            'cv'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        Application::create([
            'user_id'      => auth()->id(),
            'job_post_id'  => $jobPost->id,
            'cover_letter' => $validated['cover_letter'],
            'cv_path'      => $cvPath,
            'status'       => 'pending',
        ]);

        return redirect()->route('candidate.applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    public function index()
    {
        $applications = auth()->user()->applications()->with('jobPost.category')->latest()->get();
        return view('candidate.applications.index', compact('applications'));
    }
}