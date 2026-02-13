<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Document</h1>
            <p class="text-sm text-gray-500">Update the document details and information.</p>
        </div>
        <x-ui.button variant="secondary" size="sm" href="{{ route('documents.index') }}">
            <x-slot:icon>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </x-slot:icon>
            Back to Documents
        </x-ui.button>
    </div>

    <!-- Edit Document Card -->
    <form wire:submit.prevent="update">
        <x-form.card>
            <!-- Custom Header with Badge -->
            <x-slot:title>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Document Information</h3>
                        <p class="text-sm text-gray-500 font-normal mt-1">Modify the fields below to update the
                            document.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-ui.badge :variant="$document->status->color()">
                            {{ $document->status->label() }}
                        </x-ui.badge>
                        @if ($document->visibility === \App\Enums\DocumentVisibility::PUBLIC)
                            <x-ui.badge variant="success">Public</x-ui.badge>
                        @else
                            <x-ui.badge variant="warning">Restricted</x-ui.badge>
                        @endif
                    </div>
                </div>
            </x-slot:title>

            <x-slot:footer>
                <div class="flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" href="{{ route('documents.index') }}">
                        Cancel
                    </x-ui.button>

                    <x-ui.button type="submit" variant="primary">
                        <x-slot:icon>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </x-slot:icon>
                        Update Document
                    </x-ui.button>
                </div>
            </x-slot:footer>

            <!-- Basic Information Section -->
            <x-form.grid cols="2">
                <!-- Document Title -->
                <div>
                    <x-form.label for="title" required>Document Title</x-form.label>
                    <x-form.input type="text" id="title" wire:model="title"
                        placeholder="e.g. Course Syllabus - Spring 2024">
                        <x-slot:icon>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </x-slot:icon>
                    </x-form.input>
                </div>

                <!-- Category -->
                <div>
                    <x-form.label for="category_id" required>Category</x-form.label>
                    <x-form.select id="category_id" wire:model="category_id" placeholder="Select a category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </x-form.grid>

            <!-- Current File Section -->
            <x-form.section title="Current File" description="Information about the currently uploaded file">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-university-red/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-university-red" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ basename($document->file_url) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Uploaded on {{ $document->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                </div>
            </x-form.section>

            <!-- Replace File Section -->
            <x-form.section title="Replace File (Optional)" description="Upload a new file to replace the current one">
                <div>
                    <x-form.label for="file">New Document File</x-form.label>
                    <div class="mt-1">
                        <label for="file"
                            class="flex flex-col items-center justify-center w-full h-40 px-4 transition bg-gray-50 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer hover:bg-gray-100 hover:border-university-red/30">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if ($file)
                                    <svg class="w-10 h-10 mb-3 text-university-red" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p class="mb-2 text-sm font-semibold text-gray-700">
                                        New File: <span
                                            class="text-university-red">{{ $file->getClientOriginalName() }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Size: {{ number_format($file->getSize() / 1024, 2) }} KB
                                    </p>
                                @else
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm font-semibold text-gray-700">
                                        Click to upload a replacement file
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG (MAX. 10MB)
                                    </p>
                                @endif
                            </div>
                            <input id="file" type="file" wire:model="file" class="hidden" />
                        </label>
                    </div>
                    @error('file')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="file" class="mt-2">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="animate-spin h-4 w-4 text-university-red" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="font-medium">Uploading new file...</span>
                        </div>
                    </div>

                    @if ($file)
                        <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-xs text-blue-700 font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                The current file will be replaced when you save this form.
                            </p>
                        </div>
                    @endif
                </div>
            </x-form.section>

            <!-- Description Section -->
            <x-form.section title="Document Description" description="Provide additional details about this document">
                <div>
                    <x-form.label for="description">Description</x-form.label>
                    <x-form.text-area id="description" wire:model="description" rows="4"
                        placeholder="Provide a brief description of this document...">
                    </x-form.text-area>
                    <p class="mt-1 text-xs text-gray-500">Optional: Add a description to help users understand the
                        content and purpose of this document.</p>
                </div>
            </x-form.section>

            <!-- Tags Section -->
            <x-form.section title="Document Tags"
                description="Manage tags to help categorize and search for this document">
                <div class="space-y-4">
                    <!-- Existing Tags Display -->
                    @if ($document->tags->count() > 0)
                        <div class="mb-4">
                            <p class="text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Current Tags
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($document->tags as $existingTag)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-university-red/10 text-university-red rounded-lg text-sm font-medium border border-university-red/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $existingTag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Use the fields below to add, remove, or modify tags for this document.
                            </p>
                        </div>
                    @endif

                    <!-- Tag Inputs -->
                    @foreach ($tags as $index => $tag)
                        <!-- Wrapper div for the whole row including errors -->
                        <div wire:key="tag-{{ $index }}">

                            <!-- Input and Button Row: Aligned Center -->
                            <div class="flex gap-3 items-center">

                                <!-- Input Container -->
                                <div class="flex-1 relative">
                                    <x-form.input type="text"
                                        wire:model.live.debounce.300ms="tags.{{ $index }}.name"
                                        placeholder="Enter or search for a tag">
                                        <x-slot:icon>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </x-slot:icon>
                                    </x-form.input>
                                </div>

                                <!-- Button Container: Removed pt-2, added shrink-0 -->
                                <div class="flex gap-2 shrink-0">
                                    @if ($index === count($tags) - 1)
                                        <button type="button" wire:click="addTag"
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-white bg-university-red rounded-lg hover:bg-university-red/90 focus:outline-none focus:ring-2 focus:ring-university-red focus:ring-offset-2 transition-colors"
                                            title="Add another tag">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    @endif

                                    @if (count($tags) > 1)
                                        <button type="button" wire:click="removeTag({{ $index }})"
                                            class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition-colors"
                                            title="Remove tag">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Error Message: -->
                            @error("tags.{$index}.name")
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <!-- Tag Suggestions Dropdown -->
                    @if ($showSuggestions && !empty($suggestedTags))
                        <div class="relative">
                            <div
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <div class="p-2">
                                    <p class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Existing Tags</p>
                                    @foreach ($suggestedTags as $suggestion)
                                        <button type="button"
                                            wire:click="selectTag('{{ $suggestion['name'] }}', {{ count($tags) - 1 }})"
                                            class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-md transition-colors flex items-center justify-between group">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $suggestion['name'] }}</span>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $suggestion['document_count'] }}
                                                docs</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <p class="text-xs text-gray-500">
                        <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Start typing to see existing tags or create new ones. Changes will be saved when you update the
                        document.
                    </p>
                </div>
            </x-form.section>

            <!-- Settings Section -->
            <x-form.section title="Document Settings" description="Configure visibility and status options">
                <x-form.grid cols="2">
                    <!-- Visibility -->
                    <div>
                        <x-form.label for="visibility" required>Visibility</x-form.label>
                        <x-form.select id="visibility" wire:model="visibility">
                            @foreach ($visibilityOptions as $option)
                                <option value="{{ $option->value }}">
                                    {{ $option->label() }} - {{ $option->description() }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <!-- Status -->
                    <div>
                        <x-form.label for="status" required>Status</x-form.label>
                        <x-form.select id="status" wire:model="status">
                            @foreach ($statusOptions as $option)
                                <option value="{{ $option->value }}">{{ $option->label() }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </x-form.grid>
            </x-form.section>

            <!-- Document Stats Section -->
            <x-form.section title="Document Statistics" description="View engagement and usage metrics">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 font-medium uppercase">Total Views</p>
                                <p class="text-xl font-bold text-blue-900">{{ number_format($document->view_count) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-green-600 font-medium uppercase">Uploaded Date</p>
                                <p class="text-sm font-bold text-green-900">
                                    {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-purple-600 font-medium uppercase">Uploaded By</p>
                                <p class="text-sm font-bold text-purple-900">{{ $document->uploader->full_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-form.section>
        </x-form.card>
    </form>
</div>
