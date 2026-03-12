<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for: ') }} {{ $jobPost->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <!-- Job Summary -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-500">Company</p>
                    <p class="font-medium">{{ $jobPost->employer->name }}</p>
                    <p class="text-sm text-gray-500 mt-2">Location</p>
                    <p class="font-medium">{{ $jobPost->location }} · {{ $jobPost->type }}</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" 
                      action="{{ route('candidate.applications.store', $jobPost) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <!-- Cover Letter -->
                    <div class="mb-4">
                        <x-input-label for="cover_letter" :value="__('Cover Letter')" />
                        <textarea id="cover_letter" name="cover_letter" rows="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Tell the employer why you are the best candidate...">{{ old('cover_letter') }}</textarea>
                        <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                    </div>

                    <!-- CV Upload -->
                    <div class="mb-6">
                        <x-input-label for="cv" :value="__('Upload CV (PDF, DOC, DOCX - max 2MB)')" />
                        <label for="cv" class="mt-1 flex items-center gap-3 cursor-pointer">
                            <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm">
                                Choose File
                            </span>
                            <span id="cv-filename" class="text-sm text-gray-500">No file chosen</span>
                        </label>
                        <input id="cv" name="cv" type="file" accept=".pdf,.doc,.docx" class="hidden" 
                            onchange="document.getElementById('cv-filename').textContent = this.files[0]?.name || 'No file chosen'" />
                        <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('candidate.job-posts.show', $jobPost) }}"
                           class="text-blue-500 hover:underline">
                            ← Back to Job
                        </a>
                        <x-primary-button>
                            {{ __('Submit Application') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>