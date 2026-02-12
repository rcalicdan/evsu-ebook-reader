<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Upload Document</h1>
            <p class="text-sm text-gray-500">Upload a new document to the system for sharing and organization.</p>
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

    <!-- Upload Document Card -->
    <form wire:submit.prevent="save">
        <x-form.card title="Document Information" description="Fill in the details and upload your document file.">
            <x-slot:footer>
                <div class="flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" href="{{ route('documents.index') }}">
                        Cancel
                    </x-ui.button>

                    <x-ui.button type="submit" variant="primary">
                        <x-slot:icon>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </x-slot:icon>
                        Upload Document
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
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </x-form.grid>

            <!-- File Upload Section -->
            <x-form.section title="File Upload" description="Upload your document file (Max size: 10MB)">
                <div>
                    <x-form.label for="file" required>Document File</x-form.label>
                    <div class="mt-1">
                        <label for="file" 
                            class="flex flex-col items-center justify-center w-full h-48 px-4 transition bg-gray-50 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer hover:bg-gray-100 hover:border-university-red/30">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if($file)
                                    <svg class="w-12 h-12 mb-3 text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p class="mb-2 text-sm font-semibold text-gray-700">
                                        File Selected: <span class="text-university-red">{{ $file->getClientOriginalName() }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Size: {{ number_format($file->getSize() / 1024, 2) }} KB
                                    </p>
                                @else
                                    <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm font-semibold text-gray-700">
                                        Click to upload or drag and drop
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
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="font-medium">Uploading file...</span>
                        </div>
                    </div>
                </div>
            </x-form.section>

            <!-- Description Section -->
            <x-form.section title="Document Description" description="Provide additional details about this document">
                <div>
                    <x-form.label for="description">Description</x-form.label>
                    <x-form.text-area id="description" wire:model="description" rows="4"
                        placeholder="Provide a brief description of this document...">
                    </x-form.text-area>
                    <p class="mt-1 text-xs text-gray-500">Optional: Add a description to help users understand the content and purpose of this document.</p>
                </div>
            </x-form.section>

            <!-- Settings Section -->
            <x-form.section title="Document Settings" description="Configure visibility and status options">
                <x-form.grid cols="2">
                    <!-- Visibility -->
                    <div>
                        <x-form.label for="visibility" required>Visibility</x-form.label>
                        <x-form.select id="visibility" wire:model="visibility">
                            @foreach($visibilityOptions as $option)
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
                            @foreach($statusOptions as $option)
                                <option value="{{ $option->value }}">{{ $option->label() }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </x-form.grid>
            </x-form.section>
        </x-form.card>
    </form>
</div>