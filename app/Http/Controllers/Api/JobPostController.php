<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobPostResource;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('category', 'employer')
            ->where('status', 'open')
            ->latest();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $jobPosts = $query->get();

        return response()->json([
            'success' => true,
            'data'    => JobPostResource::collection($jobPosts),
            'count'   => $jobPosts->count(),
        ]);
    }

    public function show(JobPost $jobPost)
    {
        $jobPost->load('category', 'employer');

        return response()->json([
            'success' => true,
            'data'    => new JobPostResource($jobPost),
        ]);
    }
}