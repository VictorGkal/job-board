<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::where('status', 'open')->latest();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $jobPosts = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('candidate.job-posts.index', compact('jobPosts', 'categories'));
    }

    public function show(JobPost $jobPost)
    {
        return view('candidate.job-posts.show', compact('jobPost'));
    }
}