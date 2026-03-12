<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Jobs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Bar -->
            <form method="GET" action="{{ route('candidate.job-posts.index') }}" class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="title" :value="__('Search Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            value="{{ request('title') }}" placeholder="e.g. PHP Developer" />
                    </div>
                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="type" :value="__('Job Type')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">All Types</option>
                            <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                            <option value="freelance" {{ request('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <x-primary-button>{{ __('Search') }}</x-primary-button>
                    <a href="{{ route('candidate.job-posts.index') }}"
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Clear
                    </a>
                </div>
            </form>

            <!-- Job Posts List -->
            @if($jobPosts->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                    No open job posts found.
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($jobPosts as $jobPost)
                        <div class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $jobPost->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $jobPost->category->name }} · {{ $jobPost->location }} · {{ $jobPost->type }}
                                    </p>
                                    @if($jobPost->salary_min || $jobPost->salary_max)
                                        <p class="text-sm text-green-600 mt-1">
                                            ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-xs text-gray-400">
                                        {{ $jobPost->created_at->diffForHumans() }}
                                    </span>
                                    <div class="flex gap-2">
                                        <a href="{{ route('candidate.job-posts.show', $jobPost) }}"
                                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm">
                                            View Job
                                        </a>
                                        @php
                                            $alreadyApplied = auth()->user()->applications()
                                                ->where('job_post_id', $jobPost->id)
                                                ->exists();
                                        @endphp

                                        @if($alreadyApplied)
                                            <span class="bg-gray-300 text-gray-600 px-4 py-2 rounded-md cursor-not-allowed text-sm">
                                                Already Applied
                                            </span>
                                        @else
                                            <a href="{{ route('candidate.applications.create', $jobPost) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                                Apply Now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $jobPosts->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>