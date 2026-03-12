<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $jobPost->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('employer.job-posts.edit', $jobPost) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Edit
                </a>
                <form action="{{ route('employer.job-posts.destroy', $jobPost) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                        onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="grid grid-cols-2 gap-6 mb-6">
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
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $jobPost->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $jobPost->status }}
                        </span>
                    </div>
                    @if($jobPost->salary_min || $jobPost->salary_max)
                    <div>
                        <p class="text-sm text-gray-500">Salary Range</p>
                        <p class="font-medium">
                            ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}
                        </p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Posted</p>
                        <p class="font-medium">{{ $jobPost->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <p class="text-sm text-gray-500 mb-2">Description</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $jobPost->description }}</p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('employer.job-posts.index') }}"
                       class="text-blue-500 hover:underline">
                        ← Back to Job Posts
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>