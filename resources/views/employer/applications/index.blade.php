<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Applications for: {{ $jobPost->title }}
            </h2>
            <a href="{{ route('employer.job-posts.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                ← Back to Job Posts
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($applications->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                    No applications yet for this job post.
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($applications as $application)
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $application->candidate->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $application->candidate->email }}
                                    </p>
                                    <p class="text-sm text-gray-400 mt-1">
                                        Applied {{ $application->created_at->diffForHumans() }}
                                    </p>

                                    @if($application->cover_letter)
                                        <div class="mt-3 bg-gray-50 p-3 rounded-md">
                                            <p class="text-sm text-gray-500 mb-1">Cover Letter</p>
                                            <p class="text-sm text-gray-700">{{ $application->cover_letter }}</p>
                                        </div>
                                    @endif

                                    @if($application->cv_path)
                                        <a href="{{ asset('storage/' . $application->cv_path) }}"
                                           target="_blank"
                                           class="inline-block mt-3 text-blue-500 hover:underline text-sm">
                                            Download CV
                                        </a>
                                    @endif
                                </div>

                                <div class="flex flex-col items-end gap-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @switch($application->status)
                                            @case('pending')   bg-yellow-100 text-yellow-800 @break
                                            @case('reviewed')  bg-blue-100 text-blue-800 @break
                                            @case('accepted')  bg-green-100 text-green-800 @break
                                            @case('rejected')  bg-red-100 text-red-800 @break
                                        @endswitch">
                                        {{ ucfirst($application->status) }}
                                    </span>

                                    <form action="{{ route('employer.applications.update', $application) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="border-gray-300 rounded-md shadow-sm text-sm">
                                            <option value="pending"  {{ $application->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                            <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                            <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>