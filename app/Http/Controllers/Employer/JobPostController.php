<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->jobPosts()->latest();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobPosts = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('employer.job-posts.index', compact('jobPosts', 'categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('employer.job-posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:full-time,part-time,freelance,internship'],
            'salary_min'  => ['nullable', 'numeric'],
            'salary_max'  => ['nullable', 'numeric'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'open';

        JobPost::create($validated);

        return redirect()->route('employer.job-posts.index')
            ->with('success', 'Job post created successfully!');
    }

    public function show(JobPost $jobPost)
    {
        return view('employer.job-posts.show', compact('jobPost'));
    }

    public function edit(JobPost $jobPost)
    {
        $categories = Category::all();
        return view('employer.job-posts.edit', compact('jobPost', 'categories'));
    }

    public function update(Request $request, JobPost $jobPost)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:full-time,part-time,freelance,internship'],
            'salary_min'  => ['nullable', 'numeric'],
            'salary_max'  => ['nullable', 'numeric'],
            'status'      => ['required', 'in:open,closed'],
        ]);

        $jobPost->update($validated);
    
        return redirect()->route('employer.job-posts.index')
            ->with('success', 'Job post updated successfully!');
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();

        return redirect()->route('employer.job-posts.index')
            ->with('success', 'Job post deleted successfully!');
    }
}