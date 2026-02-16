<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Document Details</h1>
            <p class="text-sm text-gray-500">View document information and details.</p>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $document)
                <x-ui.button variant="success" size="sm" href="{{ route('documents.edit', $document) }}">
                    <x-slot:icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </x-slot:icon>
                    Edit
                </x-ui.button>
            @endcan

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
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="documentViewer()">
        <!-- Left Column — Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Document Info Card -->
            <x-form.card>
                <x-slot:title>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Document Information</h3>
                            <p class="text-sm text-gray-500 font-normal mt-1">Details and metadata about this document.
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

                <!-- Title -->
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Title</p>
                        <p class="text-gray-900 font-semibold text-lg">{{ $document->title }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Description</p>
                        @if ($document->description)
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $document->description }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">No description provided.</p>
                        @endif
                    </div>

                    <!-- Category -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Category</p>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $document->category->name ?? "Not Set" }}
                        </span>
                    </div>

                    <!-- Slug -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Slug</p>
                        <code class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg font-mono">
                            {{ $document->slug }}
                        </code>
                    </div>
                </div>
            </x-form.card>

            <!-- File Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Document File</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">The file associated with this document.</p>
                </x-slot:title>

                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-university-red/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-university-red" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ basename($document->file_url) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Uploaded on {{ $document->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <!-- Preview Button -->
                    <button type="button" @click="openPreview('{{ route('documents.preview', $document) }}')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-university-red text-white text-sm font-medium rounded-lg hover:bg-university-red/90 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Preview
                    </button>
                </div>
            </x-form.card>

            <!-- Tags Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Tags</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">Categories and labels for this document.</p>
                </x-slot:title>

                @if($document->tags->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($document->tags as $tag)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-university-red/10 text-university-red rounded-lg text-sm font-medium border border-university-red/20 transition-colors hover:bg-university-red/20">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 font-medium">No tags assigned</p>
                        <p class="text-xs text-gray-400 mt-1">This document doesn't have any tags yet.</p>
                        @can('update', $document)
                            <a href="{{ route('documents.edit', $document) }}" 
                               class="mt-3 text-xs text-university-red hover:text-university-red/80 font-medium">
                                Add tags →
                            </a>
                        @endcan
                    </div>
                @endif
            </x-form.card>
        </div>

        <!-- Right Column — Sidebar -->
        <div class="space-y-6">
            <!-- Statistics Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Statistics</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">Engagement and usage metrics.</p>
                </x-slot:title>

                <div class="space-y-4">
                    <!-- View Count -->
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

                    <!-- Upload Date -->
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
                                <p class="text-xs text-green-700">{{ $document->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-purple-600 font-medium uppercase">Last Updated</p>
                                <p class="text-sm font-bold text-purple-900">
                                    {{ $document->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-purple-700">{{ $document->updated_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-form.card>

            <!-- Uploader Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Uploaded By</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">The user who uploaded this document.</p>
                </x-slot:title>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $document->uploader->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $document->uploader->email }}</p>
                    </div>
                </div>
            </x-form.card>
        </div>

        <!-- PDF Preview Modal -->
        @include('livewire.documents.show-pdf-preview-modal')
    </div>
</div>

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')