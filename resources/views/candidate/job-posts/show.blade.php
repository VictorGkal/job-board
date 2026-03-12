<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobPost->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Company</p>
                        <p class="font-medium">{{ $jobPost->employer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium">{{ $jobPost->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Location</p>
                        <p class="font-medium">{{ $jobPost->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Type</p>
                        <p class="font-medium">{{ $jobPost->type }}</p>
                    </div>
                    @if($jobPost->salary_min || $jobPost->salary_max)
                    <div>
                        <p class="text-sm text-gray-500">Salary Range</p>
                        <p class="font-medium text-green-600">
                            ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}
                        </p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Posted</p>
                        <p class="font-medium">{{ $jobPost->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="border-t pt-6 mb-6">
                    <p class="text-sm text-gray-500 mb-2">Description</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $jobPost->description }}</p>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('candidate.job-posts.index') }}"
                       class="text-blue-500 hover:underline">
                        ← Back to Jobs
                    </a>
                    @php
                        $alreadyApplied = auth()->user()->applications()
                            ->where('job_post_id', $jobPost->id)
                            ->exists();
                    @endphp

                    @if($alreadyApplied)
                        <span class="bg-gray-300 text-gray-600 px-6 py-2 rounded-md cursor-not-allowed">
                            Already Applied
                        </span>
                    @else
                        <a href="{{ route('candidate.applications.create', $jobPost) }}"
                        class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                            Apply Now
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>