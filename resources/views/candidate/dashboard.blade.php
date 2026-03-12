<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <p class="text-gray-600 mb-6">Welcome back, {{ auth()->user()->name }}!</p>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalApplications }}</p>
                    <p class="text-gray-500 mt-1">Total Applications</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $pendingApplications }}</p>
                    <p class="text-gray-500 mt-1">Pending</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $reviewedApplications }}</p>
                    <p class="text-gray-500 mt-1">Reviewed</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $acceptedApplications }}</p>
                    <p class="text-gray-500 mt-1">Accepted</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-red-600">{{ $rejectedApplications }}</p>
                    <p class="text-gray-500 mt-1">Rejected</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="flex gap-4">
                <a href="{{ route('candidate.job-posts.index') }}"
                   class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">
                    Browse Jobs
                </a>
                <a href="{{ route('candidate.applications.index') }}"
                   class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-purple-600">
                    My Applications
                </a>
            </div>

        </div>
    </div>
</x-app-layout>