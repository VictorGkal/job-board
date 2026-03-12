<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Applications') }}
        </h2>
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
                    You haven't applied to any jobs yet.
                    <a href="{{ route('candidate.job-posts.index') }}" class="text-blue-500 hover:underline ml-1">
                        Browse Jobs
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($applications as $application)
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $application->jobPost->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $application->jobPost->category->name }} ·
                                        {{ $application->jobPost->location }} ·
                                        {{ $application->jobPost->type }}
                                    </p>
                                    <p class="text-sm text-gray-400 mt-1">
                                        Applied {{ $application->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @switch($application->status)
                                            @case('pending')   bg-yellow-100 text-yellow-800 @break
                                            @case('reviewed')  bg-blue-100 text-blue-800 @break
                                            @case('accepted')  bg-green-100 text-green-800 @break
                                            @case('rejected')  bg-red-100 text-red-800 @break
                                        @endswitch">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>