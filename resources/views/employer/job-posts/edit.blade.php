<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('employer.job-posts.update', $jobPost) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Job Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            :value="old('title', $jobPost->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $jobPost->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $jobPost->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                            :value="old('location', $jobPost->location)" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Type -->
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Job Type')" />
                        <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Type --</option>
                            <option value="full-time" {{ old('type', $jobPost->type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part-time" {{ old('type', $jobPost->type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                            <option value="freelance" {{ old('type', $jobPost->type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="internship" {{ old('type', $jobPost->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <!-- Salary -->
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="salary_min" :value="__('Minimum Salary')" />
                            <x-text-input id="salary_min" name="salary_min" type="number" class="mt-1 block w-full"
                                :value="old('salary_min', $jobPost->salary_min)" />
                            <x-input-error :messages="$errors->get('salary_min')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="salary_max" :value="__('Maximum Salary')" />
                            <x-text-input id="salary_max" name="salary_max" type="number" class="mt-1 block w-full"
                                :value="old('salary_max', $jobPost->salary_max)" />
                            <x-input-error :messages="$errors->get('salary_max')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="open" {{ old('status', $jobPost->status) == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status', $jobPost->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('employer.job-posts.index') }}"
                           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <x-primary-button>
                            {{ __('Update Job Post') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>