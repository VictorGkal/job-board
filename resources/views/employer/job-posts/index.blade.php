<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Job Posts') }}
            </h2>
            <a href="{{ route('employer.job-posts.create') }}" 
               class="bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600">
                + New Job Post
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
                    
            <!-- Filter Bar -->
        <form method="GET" action="{{ route('employer.job-posts.index') }}" class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="grid grid-cols-4 gap-4">
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
                    <x-input-label for="type" :value="__('Type')" />
                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="freelance" {{ request('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Statuses</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <x-primary-button>
                    {{ __('Search') }}
                </x-primary-button>
                <a href="{{ route('employer.job-posts.index') }}"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    Clear
                </a>
            </div>
        </form>

            @if($jobPosts->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                    You have no job posts yet. Create your first one!
                </div>
            @else
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-gray-600">Title</th>
                                <th class="px-6 py-3 text-gray-600">Category</th>
                                <th class="px-6 py-3 text-gray-600">Type</th>
                                <th class="px-6 py-3 text-gray-600">Status</th>
                                <th class="px-6 py-3 text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobPosts as $jobPost)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $jobPost->title }}</td>
                                    <td class="px-6 py-4">{{ $jobPost->category->name }}</td>
                                    <td class="px-6 py-4">{{ $jobPost->type }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            {{ $jobPost->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $jobPost->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="{{ route('employer.applications.index', $jobPost) }}"
                                        class="text-green-500 hover:underline">Applications</a>
                                        <a href="{{ route('employer.job-posts.edit', $jobPost) }}" 
                                        class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('employer.job-posts.destroy', $jobPost) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4">
                        {{ $jobPosts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>